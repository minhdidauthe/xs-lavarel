<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LotteryResult;
use App\Models\Page;
use App\Models\Post;
use App\Services\PredictionService;
use App\Services\ShortcodeParser;

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
        // Check for CMS-managed homepage
        $page = Page::where('slug', 'home')->published()->first();
        if ($page) {
            $parser = app(ShortcodeParser::class);
            $renderedContent = $parser->parse($page->content);
            return view('home', compact('page', 'renderedContent'));
        }

        return $this->indexFallback();
    }

    private function indexFallback()
    {
        // Frequency & waiting stats (reuse logic from statistics())
        $results = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays(30)->toDateString())
            ->orderByDesc('date')
            ->get();

        $today = now()->startOfDay();
        $freq = [];
        $lastSeen = [];
        foreach ($results as $r) {
            $daysAgo = (int) $r->date->startOfDay()->diffInDays($today);
            foreach ($r->numbers as $num) {
                $last2 = substr($num, -2);
                $freq[$last2] = ($freq[$last2] ?? 0) + 1;
                if (!isset($lastSeen[$last2])) {
                    $lastSeen[$last2] = $daysAgo;
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

        // Special prize detailed stats
        $freqDB = [];
        $ganHead = [];
        $ganTail = [];
        $ganSum = [];

        foreach ($results as $r) {
            $daysAgo = (int) $r->date->startOfDay()->diffInDays($today);
            $special = $r->prizes['special'] ?? null;
            if (!$special) continue;
            $spStr = is_array($special) ? ($special[0] ?? '') : $special;
            $last2 = substr($spStr, -2);
            if (strlen($last2) !== 2 || !ctype_digit($last2)) continue;

            $freqDB[$last2] = ($freqDB[$last2] ?? 0) + 1;

            $head = (int) $last2[0];
            $tail = (int) $last2[1];
            $sum = ($head + $tail) % 10;

            if (!isset($ganHead[$head])) $ganHead[$head] = $daysAgo;
            if (!isset($ganTail[$tail])) $ganTail[$tail] = $daysAgo;
            if (!isset($ganSum[$sum])) $ganSum[$sum] = $daysAgo;
        }

        arsort($freqDB);
        $frequencyDB = [];
        foreach (array_slice($freqDB, 0, 10, true) as $num => $count) {
            $frequencyDB[] = ['number' => $num, 'count' => $count];
        }

        $maxDays = 31;
        for ($d = 0; $d <= 9; $d++) {
            if (!isset($ganHead[$d])) $ganHead[$d] = $maxDays;
            if (!isset($ganTail[$d])) $ganTail[$d] = $maxDays;
            if (!isset($ganSum[$d])) $ganSum[$d] = $maxDays;
        }
        arsort($ganHead);
        arsort($ganTail);
        arsort($ganSum);

        // Latest blog posts
        $latestPosts = Post::published()
            ->with('category')
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        // AI prediction top numbers
        $predictionAI = null;
        try {
            $service = new PredictionService();
            $predResult = $service->predict(null, 'MB');
            if (!empty($predResult['top10'])) {
                $predictionAI = $predResult['top10'];
            }
        } catch (\Exception $e) {
            // Prediction service not available
        }

        // === Soi Cầu MB + Cầu Đẹp + Lô Top ===
        $soiCauMB = null;
        $cauDep = null;
        $loTop = [];

        // Head/Tail frequency for ĐB chạm
        $headFreq = array_fill(0, 10, 0);
        $tailFreq = array_fill(0, 10, 0);
        foreach ($results as $r) {
            $special = $r->prizes['special'] ?? null;
            if (!$special) continue;
            $spStr = is_array($special) ? ($special[0] ?? '') : $special;
            $l2 = substr($spStr, -2);
            if (strlen($l2) == 2 && ctype_digit($l2)) {
                $headFreq[(int) $l2[0]]++;
                $tailFreq[(int) $l2[1]]++;
            }
        }
        arsort($headFreq);
        arsort($tailFreq);

        // Lô kép (double digits) from frequency
        $loKep = [];
        foreach ($freq as $n => $c) {
            $n = str_pad((string) $n, 2, '0', STR_PAD_LEFT);
            if ($n[0] === $n[1]) $loKep[] = $n;
        }

        if ($predictionAI && count($predictionAI) >= 10) {
            $top = $predictionAI;
            $topDau = array_key_first($headFreq);
            $topDuoi = array_key_first($tailFreq);

            $soiCauMB = [
                'bach_thu' => $top[0]['number'],
                'song_thu' => [$top[0]['number'], $top[1]['number']],
                'xien2' => [
                    [$top[0]['number'], $top[5]['number']],
                    [$top[1]['number'], $top[6]['number']],
                    [$top[2]['number'], $top[7]['number']],
                    [$top[3]['number'], $top[8]['number']],
                ],
                'lo_kep' => array_slice($loKep, 0, 2),
                'db_cham_dau' => $topDau,
                'db_cham_duoi' => $topDuoi,
                'dan_3cang' => [
                    $topDau . $top[0]['number'],
                    $topDau . $top[1]['number'],
                    $topDuoi . $top[2]['number'],
                    $topDuoi . $top[3]['number'],
                ],
            ];

            // Cầu đẹp - cầu loto: top prediction + mirror
            $cauLoto = [];
            foreach (array_slice($top, 0, 7) as $item) {
                $n = $item['number'];
                $mirror = strrev($n);
                $cauLoto[] = ($n === $mirror) ? $n : $n . ',' . $mirror;
            }

            // Cầu 2 nháy: số xuất hiện 2 ngày liên tiếp gần nhất
            $cau2Nhay = [];
            if ($results->count() >= 2) {
                $day1Nums = [];
                $day2Nums = [];
                foreach ($results[0]->numbers as $num) {
                    $day1Nums[] = substr($num, -2);
                }
                foreach ($results[1]->numbers as $num) {
                    $day2Nums[] = substr($num, -2);
                }
                $consecutive = array_values(array_unique(array_intersect($day1Nums, $day2Nums)));
                usort($consecutive, function ($a, $b) use ($freq) {
                    return ($freq[$b] ?? 0) <=> ($freq[$a] ?? 0);
                });
                $cau2Nhay = array_slice($consecutive, 0, 7);
            }

            // Cầu ĐB đẹp: dựa trên giải ĐB gần nhất + prediction
            $cauDB = [];
            foreach (array_slice($top, 3, 6) as $item) {
                $n = $item['number'];
                $mirror = strrev($n);
                $cauDB[] = ($n === $mirror) ? $n : $n . ',' . $mirror;
            }

            $cauDep = [
                'loto' => $cauLoto,
                'nhay2' => $cau2Nhay,
                'db' => $cauDB,
            ];
        }

        // Lô top chơi nhiều (top 20)
        foreach (array_slice($freq, 0, 20, true) as $n => $c) {
            $loTop[] = $n;
        }

        return view('welcome', [
            'lotteryMB' => $this->getLatest('north'),
            'lotteryMT' => $this->getLatest('central'),
            'lotteryMN' => $this->getLatest('south'),
            'predictionAI' => $predictionAI,
            'frequency' => $frequency,
            'waiting' => $waiting,
            'frequencyDB' => $frequencyDB,
            'ganHead' => $ganHead,
            'ganTail' => $ganTail,
            'ganSum' => $ganSum,
            'soiCauMB' => $soiCauMB,
            'cauDep' => $cauDep,
            'loTop' => $loTop,
            'latestPosts' => $latestPosts,
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

        $today = now()->startOfDay();
        $freq = [];
        $lastSeen = [];

        foreach ($results as $r) {
            $daysAgo = (int) $r->date->startOfDay()->diffInDays($today);
            foreach ($r->numbers as $num) {
                $last2 = substr($num, -2);
                $freq[$last2] = ($freq[$last2] ?? 0) + 1;
                if (!isset($lastSeen[$last2])) {
                    $lastSeen[$last2] = $daysAgo;
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
