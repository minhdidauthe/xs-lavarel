<?php

namespace App\Services;

use App\Models\LotteryResult;
use App\Models\Post;
use App\Models\Shortcode;

class ShortcodeParser
{
    private array $builtins = [
        'kqxs' => 'renderKqxs',
        'soi_cau' => 'renderSoiCau',
        'thong_ke' => 'renderThongKe',
        'lo_gan' => 'renderLoGan',
        'welcome_banner' => 'renderWelcomeBanner',
        'soi_cau_mb' => 'renderSoiCauMB',
        'cau_dep' => 'renderCauDep',
        'lo_top' => 'renderLoTop',
        'du_doan_cards' => 'renderDuDoanCards',
        'kqxs_full' => 'renderKqxsFull',
        'thong_ke_nhanh' => 'renderThongKeNhanh',
        'kqxs_mt_mn' => 'renderKqxsMtMn',
        'thong_ke_lo' => 'renderThongKeLo',
        'blog_moi' => 'renderBlogMoi',
    ];

    /** Cache prediction data (shared by soi_cau_mb, cau_dep, lo_top, du_doan_cards) */
    private ?array $predictionCache = null;

    /** Cache stats data (shared by thong_ke_nhanh, thong_ke_lo) */
    private ?array $statsCache = null;

    public function parse(string $content): string
    {
        $pattern = '/\[([a-z_][a-z0-9_]*)((?:\s+[a-z_]+="[^"]*")*)\]/i';

        return preg_replace_callback($pattern, function ($matches) {
            $tag = strtolower($matches[1]);
            $attrs = $this->parseAttributes($matches[2] ?? '');

            if (isset($this->builtins[$tag])) {
                // Check if this builtin has been deactivated in DB
                $dbRecord = Shortcode::where('code', $tag)->where('is_builtin', true)->first();
                if ($dbRecord && !$dbRecord->is_active) {
                    return ''; // Shortcode disabled by admin
                }
                $method = $this->builtins[$tag];
                return $this->$method($attrs);
            }

            $custom = Shortcode::where('code', $tag)->where('is_active', true)->first();
            if ($custom) {
                return $this->renderCustom($custom, $attrs);
            }

            return $matches[0];
        }, $content);
    }

    private function parseAttributes(string $attrString): array
    {
        $attrs = [];
        preg_match_all('/([a-z_]+)="([^"]*)"/i', $attrString, $m, PREG_SET_ORDER);
        foreach ($m as $match) {
            $attrs[$match[1]] = $match[2];
        }
        return $attrs;
    }

    // ─────────────────────────────────────────────
    // Shared data helpers
    // ─────────────────────────────────────────────

    private function getPredictionData(): array
    {
        if ($this->predictionCache !== null) {
            return $this->predictionCache;
        }

        $results = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays(30)->toDateString())
            ->orderByDesc('date')
            ->get();

        $freq = [];
        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $last2 = substr($num, -2);
                $freq[$last2] = ($freq[$last2] ?? 0) + 1;
            }
        }
        arsort($freq);

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

        // Lô kép
        $loKep = [];
        foreach ($freq as $n => $c) {
            $n = str_pad((string) $n, 2, '0', STR_PAD_LEFT);
            if ($n[0] === $n[1]) $loKep[] = $n;
        }

        // AI prediction
        $predictionAI = null;
        $soiCauMB = null;
        $cauDep = null;
        $loTop = [];

        try {
            $service = new PredictionService();
            $predResult = $service->predict(null, 'MB');
            if (!empty($predResult['top10'])) {
                $predictionAI = $predResult['top10'];
            }
        } catch (\Exception $e) {
            // Prediction not available
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

        // Lô top
        foreach (array_slice($freq, 0, 20, true) as $n => $c) {
            $loTop[] = $n;
        }

        $this->predictionCache = [
            'predictionAI' => $predictionAI,
            'soiCauMB' => $soiCauMB,
            'cauDep' => $cauDep,
            'loTop' => $loTop,
            'freq' => $freq,
        ];

        return $this->predictionCache;
    }

    private function getStatsData(int $days = 30): array
    {
        if ($this->statsCache !== null) {
            return $this->statsCache;
        }

        $results = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays($days)->toDateString())
            ->orderByDesc('date')
            ->get();

        $today = now()->startOfDay();
        $freq = [];
        $lastSeen = [];
        $freqDB = [];
        $ganHead = [];
        $ganTail = [];
        $ganSum = [];

        foreach ($results as $r) {
            $daysAgo = (int) $r->date->startOfDay()->diffInDays($today);

            foreach ($r->numbers as $num) {
                $last2 = substr($num, -2);
                $freq[$last2] = ($freq[$last2] ?? 0) + 1;
                if (!isset($lastSeen[$last2])) {
                    $lastSeen[$last2] = $daysAgo;
                }
            }

            $special = $r->prizes['special'] ?? null;
            if ($special) {
                $spStr = is_array($special) ? ($special[0] ?? '') : $special;
                $last2 = substr($spStr, -2);
                if (strlen($last2) === 2 && ctype_digit($last2)) {
                    $freqDB[$last2] = ($freqDB[$last2] ?? 0) + 1;
                    $head = (int) $last2[0];
                    $tail = (int) $last2[1];
                    $sum = ($head + $tail) % 10;
                    if (!isset($ganHead[$head])) $ganHead[$head] = $daysAgo;
                    if (!isset($ganTail[$tail])) $ganTail[$tail] = $daysAgo;
                    if (!isset($ganSum[$sum])) $ganSum[$sum] = $daysAgo;
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
        foreach (array_slice($lastSeen, 0, 10, true) as $num => $gap) {
            $waiting[] = ['number' => $num, 'days' => $gap];
        }

        arsort($freqDB);
        $frequencyDB = [];
        foreach (array_slice($freqDB, 0, 10, true) as $num => $count) {
            $frequencyDB[] = ['number' => $num, 'count' => $count];
        }

        $maxDays = $days + 1;
        for ($d = 0; $d <= 9; $d++) {
            if (!isset($ganHead[$d])) $ganHead[$d] = $maxDays;
            if (!isset($ganTail[$d])) $ganTail[$d] = $maxDays;
            if (!isset($ganSum[$d])) $ganSum[$d] = $maxDays;
        }
        arsort($ganHead);
        arsort($ganTail);
        arsort($ganSum);

        $this->statsCache = compact(
            'frequency', 'waiting', 'frequencyDB',
            'ganHead', 'ganTail', 'ganSum'
        );

        return $this->statsCache;
    }

    private function getLatest(string $regionCode): ?array
    {
        $result = LotteryResult::where('region', $regionCode)
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

    // ─────────────────────────────────────────────
    // Original 4 built-in shortcodes
    // ─────────────────────────────────────────────

    private function renderKqxs(array $attrs): string
    {
        $region = $attrs['region'] ?? 'MB';
        $result = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->first();

        if (!$result) {
            return '<p class="text-gray-400 italic">Chưa có dữ liệu KQXS.</p>';
        }

        return view('components.shortcodes.kqxs', compact('result', 'region'))->render();
    }

    private function renderSoiCau(array $attrs): string
    {
        $region = $attrs['region'] ?? 'MB';
        $service = new PredictionService();
        $prediction = $service->predict(null, $region);

        if (empty($prediction['top10'])) {
            return '<p class="text-gray-400 italic">Chưa có dữ liệu soi cầu.</p>';
        }

        return view('components.shortcodes.soi-cau', compact('prediction'))->render();
    }

    private function renderThongKe(array $attrs): string
    {
        $days = (int) ($attrs['days'] ?? 30);
        $region = $attrs['region'] ?? 'MB';

        $results = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays($days)->toDateString())
            ->orderByDesc('date')
            ->get();

        $freq = [];
        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $last2 = substr($num, -2);
                $freq[$last2] = ($freq[$last2] ?? 0) + 1;
            }
        }
        arsort($freq);

        $frequency = array_slice($freq, 0, 20, true);

        return view('components.shortcodes.thong-ke', compact('frequency', 'days'))->render();
    }

    private function renderLoGan(array $attrs): string
    {
        $region = $attrs['region'] ?? 'MB';
        $limit = (int) ($attrs['limit'] ?? 10);

        $results = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->limit(60)
            ->get();

        $today = now()->startOfDay();
        $lastSeen = [];
        foreach ($results as $r) {
            $daysAgo = (int) $r->date->startOfDay()->diffInDays($today);
            foreach ($r->numbers as $num) {
                $last2 = substr($num, -2);
                if (!isset($lastSeen[$last2])) {
                    $lastSeen[$last2] = $daysAgo;
                }
            }
        }
        arsort($lastSeen);

        $loGan = array_slice($lastSeen, 0, $limit, true);

        return view('components.shortcodes.lo-gan', compact('loGan'))->render();
    }

    // ─────────────────────────────────────────────
    // New 10 homepage shortcodes
    // ─────────────────────────────────────────────

    private function renderWelcomeBanner(array $attrs): string
    {
        return view('components.shortcodes.welcome-banner')->render();
    }

    private function renderSoiCauMB(array $attrs): string
    {
        $data = $this->getPredictionData();
        $soiCauMB = $data['soiCauMB'];

        return view('components.shortcodes.soi-cau-mb', compact('soiCauMB'))->render();
    }

    private function renderCauDep(array $attrs): string
    {
        $data = $this->getPredictionData();
        $cauDep = $data['cauDep'];

        return view('components.shortcodes.cau-dep', compact('cauDep'))->render();
    }

    private function renderLoTop(array $attrs): string
    {
        $limit = (int) ($attrs['limit'] ?? 20);
        $data = $this->getPredictionData();
        $loTop = array_slice($data['loTop'], 0, $limit);

        // Lấy top lô cho hôm qua và hôm kia
        $loTopYesterday = [];
        $loTopDayBefore = [];
        $results = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->limit(3)
            ->get();

        foreach ([1 => &$loTopYesterday, 2 => &$loTopDayBefore] as $offset => &$target) {
            if (isset($results[$offset])) {
                $dayFreq = [];
                foreach ($results[$offset]->numbers as $num) {
                    $last2 = substr($num, -2);
                    $dayFreq[$last2] = ($dayFreq[$last2] ?? 0) + 1;
                }
                arsort($dayFreq);
                $target = array_keys(array_slice($dayFreq, 0, $limit, true));
            }
        }
        unset($target);

        $dates = [
            now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y'),
            isset($results[1]) ? $results[1]->date->format('d/m/Y') : '',
            isset($results[2]) ? $results[2]->date->format('d/m/Y') : '',
        ];

        return view('components.shortcodes.lo-top', compact('loTop', 'loTopYesterday', 'loTopDayBefore', 'dates'))->render();
    }

    private function renderDuDoanCards(array $attrs): string
    {
        $data = $this->getPredictionData();
        $predictionAI = $data['predictionAI'];

        return view('components.shortcodes.du-doan-cards', compact('predictionAI'))->render();
    }

    private function renderKqxsFull(array $attrs): string
    {
        $region = $attrs['region'] ?? 'MB';
        $lottery = $this->getLatest($region);

        return view('components.shortcodes.kqxs-full', compact('lottery', 'region'))->render();
    }

    private function renderThongKeNhanh(array $attrs): string
    {
        $days = (int) ($attrs['days'] ?? 30);
        $stats = $this->getStatsData($days);

        return view('components.shortcodes.thong-ke-nhanh', $stats)->render();
    }

    private function renderKqxsMtMn(array $attrs): string
    {
        $lotteryMT = $this->getLatest('MT');
        $lotteryMN = $this->getLatest('MN');

        return view('components.shortcodes.kqxs-mt-mn', compact('lotteryMT', 'lotteryMN'))->render();
    }

    private function renderThongKeLo(array $attrs): string
    {
        $days = (int) ($attrs['days'] ?? 30);
        $stats = $this->getStatsData($days);

        return view('components.shortcodes.thong-ke-lo', [
            'frequency' => $stats['frequency'],
            'waiting' => $stats['waiting'],
        ])->render();
    }

    private function renderBlogMoi(array $attrs): string
    {
        $limit = (int) ($attrs['limit'] ?? 6);

        $posts = Post::published()
            ->with('category')
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get();

        return view('components.shortcodes.blog-moi', compact('posts'))->render();
    }

    // ─────────────────────────────────────────────
    // Custom shortcodes (DB)
    // ─────────────────────────────────────────────

    private function renderCustom(Shortcode $shortcode, array $attrs): string
    {
        $html = $shortcode->content;
        foreach ($attrs as $key => $value) {
            $html = str_replace('{{' . $key . '}}', e($value), $html);
        }
        return $html;
    }
}
