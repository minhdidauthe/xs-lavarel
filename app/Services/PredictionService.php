<?php

namespace App\Services;

use App\Models\LotteryResult;
use Illuminate\Support\Collection;

/**
 * Lottery Prediction Service
 * Based on HistoryAppearancePointAlgorithm from Lottery-Predictor
 * Ported from Python → PHP, reads from MySQL
 */
class PredictionService
{
    // ── Configurable parameters ──
    private int $shortTermDays = 14;
    private int $freqWindowShort = 45;
    private int $freqWindowLong = 180;
    private float $basePointShort = 3.5;
    private float $freqWeightShort = 0.5;
    private float $freqWeightLong = 0.25;
    private float $neighborBonus = 1.2;
    private int $neighborRange = 5;
    private float $increment = 0.005;
    private float $bonusAfter3Days = 0.07;
    private float $bonusLongAbsence = 0.8;
    private float $deductionLastDay = -0.02;
    private float $bonusFreq5 = 0.25;
    private float $cycle7Bonus = 0.2;
    private float $cycle30Bonus = 0.3;
    private float $specialMultiplier = 2.0;
    private float $specialFreqMultiplier = 3.0;

    /**
     * Run prediction for a given date and region
     *
     * @return array{scores: array, top10: array, details: array}
     */
    public function predict(string $date = null, string $region = 'MB'): array
    {
        $predictDate = $date ? new \DateTime($date) : new \DateTime();

        // Load history from MySQL (last 180 days)
        $history = $this->loadHistory($predictDate, $region);

        if ($history->isEmpty()) {
            return ['scores' => [], 'top10' => [], 'details' => []];
        }

        // Initialize scores for 00-99
        $scores = array_fill(0, 100, 0.0);
        $reasons = array_fill(0, 100, []);

        // ── Phase 1: Short-term recency scoring ──
        $shortTermData = $history->filter(function ($r) use ($predictDate) {
            return $r->date->diffInDays($predictDate) <= $this->shortTermDays;
        });

        foreach ($shortTermData as $result) {
            $daysAgo = $result->date->diffInDays($predictDate);
            if ($daysAgo < 1) continue;

            $specialNum = $this->getSpecialLast2($result);
            $numbers = $this->extractLast2Digits($result);

            foreach ($numbers as $num) {
                $point = $this->basePointShort * (1 - 0.08 * $daysAgo);
                if ($num === $specialNum) {
                    $point *= $this->specialMultiplier;
                    $reasons[$num][] = 'GĐB gần đây';
                }
                $scores[$num] += $point;
            }
        }

        // ── Phase 2: Frequency analysis ──
        $freqShort = array_fill(0, 100, 0);
        $freqLong = array_fill(0, 100, 0);
        $specialFreqShort = array_fill(0, 100, 0);

        foreach ($history as $result) {
            $daysAgo = $result->date->diffInDays($predictDate);
            $numbers = array_unique($this->extractLast2Digits($result));
            $specialNum = $this->getSpecialLast2($result);

            foreach ($numbers as $num) {
                if ($daysAgo <= $this->freqWindowShort) {
                    $freqShort[$num]++;
                }
                if ($daysAgo <= $this->freqWindowLong) {
                    $freqLong[$num]++;
                }
            }
            if ($specialNum !== null && $daysAgo <= $this->freqWindowShort) {
                $specialFreqShort[$specialNum]++;
            }
        }

        // Tính median frequency để dùng làm threshold động
        $sortedFreqs = $freqShort;
        sort($sortedFreqs);
        $medianFreq = $sortedFreqs[50]; // median of 100 numbers
        $highFreqThreshold = max($medianFreq + 3, 15); // top ~15% numbers

        for ($n = 0; $n < 100; $n++) {
            $scores[$n] += $this->freqWeightShort * $freqShort[$n];
            $scores[$n] += $this->freqWeightLong * $freqLong[$n];

            if ($freqShort[$n] > $highFreqThreshold) {
                $scores[$n] += $this->bonusFreq5;
                $reasons[$n][] = 'Tần suất cao (45 ngày)';
            }
            if ($specialFreqShort[$n] >= 2) {
                $scores[$n] += $this->specialFreqMultiplier;
                $reasons[$n][] = 'GĐB xuất hiện nhiều';
            }
        }

        // ── Phase 3: Neighbor bonus (yesterday's special) ──
        $yesterday = $history->first(); // most recent result
        if ($yesterday) {
            $specialLast = $this->getSpecialLast2($yesterday);
            if ($specialLast !== null) {
                for ($offset = -$this->neighborRange; $offset <= $this->neighborRange; $offset++) {
                    if ($offset === 0) continue;
                    $neighbor = (($specialLast + $offset) % 100 + 100) % 100;
                    $bonus = $this->neighborBonus * (1 - 0.1 * abs($offset));
                    $scores[$neighbor] += $bonus;
                    if (abs($offset) <= 2) {
                        $reasons[$neighbor][] = 'Cầu láng giềng GĐB';
                    }
                }
            }
        }

        // ── Phase 4: Cycle-based bonuses ──
        foreach ($history as $result) {
            $daysAgo = $result->date->diffInDays($predictDate);
            $numbers = array_unique($this->extractLast2Digits($result));

            if ($daysAgo > 0 && $daysAgo % 7 === 0 && $daysAgo <= 28) {
                foreach ($numbers as $num) {
                    $scores[$num] += $this->cycle7Bonus;
                }
            }
            if ($daysAgo > 0 && $daysAgo % 30 === 0 && $daysAgo <= 180) {
                foreach ($numbers as $num) {
                    $scores[$num] += $this->cycle30Bonus;
                    $reasons[$num][] = 'Chu kỳ 30 ngày';
                }
            }
        }

        // ── Phase 5: Long-absence bonus ──
        for ($n = 0; $n < 100; $n++) {
            $daysSince = 0;
            foreach ($history as $result) {
                $numbers = $this->extractLast2Digits($result);
                if (in_array($n, $numbers)) break;
                $daysSince++;
            }

            $scores[$n] += $daysSince * $this->increment;

            if ($daysSince >= 3) {
                $scores[$n] += $this->bonusAfter3Days;
            }
            if ($daysSince >= 15 && $freqLong[$n] > 10) {
                $scores[$n] += $this->bonusLongAbsence;
                $reasons[$n][] = "Lô gan {$daysSince} ngày";
            }
        }

        // ── Phase 6: Yesterday appearance penalty ──
        if ($yesterday) {
            $yesterdayNums = $this->extractLast2Digits($yesterday);
            foreach ($yesterdayNums as $num) {
                $scores[$num] += $this->deductionLastDay;
            }
        }

        // ── Build results ──
        $ranked = [];
        for ($n = 0; $n < 100; $n++) {
            $ranked[] = [
                'number' => str_pad($n, 2, '0', STR_PAD_LEFT),
                'score' => round($scores[$n], 2),
                'reasons' => array_values(array_unique($reasons[$n])),
            ];
        }

        usort($ranked, fn($a, $b) => $b['score'] <=> $a['score']);

        $top10 = array_slice($ranked, 0, 10);

        return [
            'scores' => $ranked,
            'top10' => $top10,
            'details' => [
                'history_days' => $history->count(),
                'predict_date' => $predictDate->format('d/m/Y'),
                'yesterday_special' => $yesterday ? $this->getSpecialLast2($yesterday) : null,
            ],
        ];
    }

    /**
     * Load history results sorted by date DESC
     */
    private function loadHistory(\DateTime $predictDate, string $region): Collection
    {
        $startDate = (clone $predictDate)->modify("-{$this->freqWindowLong} days");

        return LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '<', $predictDate->format('Y-m-d'))
            ->where('date', '>=', $startDate->format('Y-m-d'))
            ->orderByDesc('date')
            ->get();
    }

    /**
     * Extract last 2 digits from all numbers in a result
     */
    private function extractLast2Digits(LotteryResult $result): array
    {
        $digits = [];
        foreach ($result->numbers as $num) {
            $last2 = (int) substr($num, -2);
            $digits[] = $last2;
        }
        return $digits;
    }

    /**
     * Get last 2 digits of the special prize
     */
    private function getSpecialLast2(LotteryResult $result): ?int
    {
        $prizes = $result->prizes;
        $special = $prizes['special'] ?? null;

        if (!$special) return null;

        $val = is_array($special) ? ($special[0] ?? null) : $special;
        if ($val === null) return null;

        return (int) substr((string) $val, -2);
    }
}
