<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LotteryResult;
use App\Services\PredictionService;

class LotteryController extends Controller
{
    /**
     * Map route region names to DB region codes
     */
    private function regionCode(string $region): string
    {
        return match ($region) {
            'north' => 'MB',
            'central' => 'MT',
            'south' => 'MN',
            default => 'MB',
        };
    }

    /**
     * Get latest result for a region, formatted for the view
     */
    private function getLatest(string $region): ?array
    {
        $code = $this->regionCode($region);

        $result = LotteryResult::where('region', $code)
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->first();

        if (!$result) return null;

        return [
            'date' => $result->date->format('d/m/Y'),
            'province' => $result->province,
            'prizes' => $result->prizes,
            'numbers' => $result->numbers,
        ];
    }

    public function index()
    {
        return view('welcome', [
            'lotteryMB' => $this->getLatest('north'),
            'lotteryMT' => $this->getLatest('central'),
            'lotteryMN' => $this->getLatest('south'),
            'predictionAI' => null,
        ]);
    }

    public function history($region = 'north')
    {
        $code = $this->regionCode($region);

        $results = LotteryResult::where('region', $code)
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->limit(20)
            ->get()
            ->map(fn($r) => [
                'date' => $r->date->format('d/m/Y'),
                'province' => $r->province,
                'prizes' => $r->prizes,
                'numbers' => $r->numbers,
            ])
            ->toArray();

        return view('history', [
            'history' => $results,
            'region' => $region,
        ]);
    }

    public function prediction()
    {
        $service = new PredictionService();
        $result = $service->predict(null, 'MB');

        if (empty($result['top10'])) {
            return view('prediction', ['prediction' => null]);
        }

        $top10 = $result['top10'];

        // Format for the view
        $prediction = [
            'final_prediction' => [
                $top10[0]['number'],
                $top10[1]['number'] ?? null,
                $top10[2]['number'] ?? null,
            ],
            'model_predictions' => [
                [
                    'model' => 'Scoring Algorithm v1.5',
                    'reasoning' => $this->buildReasoning($top10[0]),
                    'prediction' => array_map(fn($t) => $t['number'], array_slice($top10, 0, 3)),
                ],
                [
                    'model' => 'Phân tích tần suất',
                    'reasoning' => $this->buildReasoning($top10[1] ?? $top10[0]),
                    'prediction' => array_map(fn($t) => $t['number'], array_slice($top10, 3, 3)),
                ],
                [
                    'model' => 'Phân tích chu kỳ',
                    'reasoning' => $this->buildReasoning($top10[2] ?? $top10[0]),
                    'prediction' => array_map(fn($t) => $t['number'], array_slice($top10, 6, 3)),
                ],
            ],
            'top10' => $top10,
            'details' => $result['details'],
        ];

        return view('prediction', ['prediction' => $prediction]);
    }

    private function buildReasoning(array $item): string
    {
        $reasons = $item['reasons'];
        if (empty($reasons)) {
            return "Số {$item['number']} đạt điểm {$item['score']} dựa trên phân tích lịch sử.";
        }
        return "Số {$item['number']} (điểm: {$item['score']}) — " . implode(', ', $reasons) . '.';
    }

    public function quayThu()
    {
        return view('quay-thu');
    }

    public function statistics()
    {
        $results = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays(30)->toDateString())
            ->orderByDesc('date')
            ->get();

        $freq = [];
        $lastSeen = [];

        foreach ($results as $idx => $r) {
            foreach ($r->numbers as $num) {
                $last2 = substr($num, -2);
                $freq[$last2] = ($freq[$last2] ?? 0) + 1;
                if (!isset($lastSeen[$last2])) {
                    $lastSeen[$last2] = $idx;
                }
            }
        }

        arsort($freq);
        $frequency = [];
        foreach (array_slice($freq, 0, 10, true) as $num => $count) {
            $frequency[] = ['number' => $num, 'count' => $count];
        }

        arsort($lastSeen);
        $waiting = [];
        foreach (array_slice($lastSeen, 0, 10, true) as $num => $days) {
            $waiting[] = ['number' => $num, 'days' => $days];
        }

        return view('statistics', [
            'frequency' => $frequency,
            'waiting' => $waiting,
        ]);
    }

    public function bridge(Request $request)
    {
        $region = $request->query('region', 'north');
        $code = $this->regionCode($region);
        $minLength = (int) $request->query('minLength', 3);

        $results = LotteryResult::where('region', $code)
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->limit(30)
            ->get();

        $allNumbers = [];
        foreach ($results as $r) {
            $day = [];
            foreach ($r->numbers as $num) {
                $day[] = substr($num, -2);
            }
            $allNumbers[] = array_unique($day);
        }

        $sequences = [];
        if (count($allNumbers) >= $minLength) {
            for ($i = 0; $i <= count($allNumbers) - $minLength; $i++) {
                $common = $allNumbers[$i];
                for ($j = 1; $j < $minLength; $j++) {
                    $common = array_intersect($common, $allNumbers[$i + $j]);
                }
                foreach ($common as $num) {
                    if (!isset($sequences[$num]) || $sequences[$num] < $minLength) {
                        $sequences[$num] = $minLength;
                    }
                }
            }
        }

        $data = [];
        foreach ($sequences as $num => $len) {
            $data[] = ['number' => $num, 'length' => $len];
        }
        usort($data, fn($a, $b) => $b['length'] <=> $a['length']);

        return response()->json(['success' => true, 'data' => array_slice($data, 0, 20)]);
    }
}
