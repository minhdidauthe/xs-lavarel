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
        // Bạch thủ / Song thủ shortcodes
        'bach_thu_lo_vip' => 'renderBachThuLoVip',
        'bach_thu_lo_kep' => 'renderBachThuLoKep',
        'bach_thu_lo_nuoi_khung_3_ngay' => 'renderBachThuLoNuoiKhung3Ngay',
        'bach_thu_lo_nuoi_khung_5_ngay' => 'renderBachThuLoNuoiKhung5Ngay',
        'song_thu_lo_vip' => 'renderSongThuLoVip',
        'song_thu_lo_kep' => 'renderSongThuLoKep',
        'song_thu_lo_khung_2_ngay' => 'renderSongThuLoKhung2Ngay',
        'song_thu_lo_khung_3_ngay' => 'renderSongThuLoKhung3Ngay',
        'song_thu_lo_khung_5_ngay' => 'renderSongThuLoKhung5Ngay',
        // LRD shortcodes
        'lrd_du_doan_3_cang' => 'renderLrdDuDoan3Cang',
        'lrd_dan_lo_6_so' => 'renderLrdDanLo6So',
        'lrd_dan_3_cang_lo' => 'renderLrdDan3CangLo',
        'lrd_dan_de_3_cang' => 'renderLrdDanDe3Cang',
        // Cầu đẹp hằng ngày
        'caudephangngay_mb' => 'renderCauDepHangNgayMB',
        // Dự đoán 3 miền
        'du_doan_3_mien' => 'renderDuDoan3Mien',
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
    // Bạch thủ / Song thủ shortcodes
    // ─────────────────────────────────────────────

    private function renderBachThuLoVip(array $attrs): string
    {
        $data = $this->getPredictionData();
        $bachThu = $data['soiCauMB']['bach_thu'] ?? null;
        $mirror  = $bachThu ? strrev($bachThu) : null;

        return view('components.shortcodes.bach-thu-lo-vip', compact('bachThu', 'mirror'))->render();
    }

    private function renderBachThuLoKep(array $attrs): string
    {
        $data   = $this->getPredictionData();
        $loKep  = $data['soiCauMB']['lo_kep'] ?? [];
        $bachKep = $loKep[0] ?? null;

        return view('components.shortcodes.bach-thu-lo-kep', compact('bachKep', 'loKep'))->render();
    }

    private function renderBachThuLoNuoiKhung3Ngay(array $attrs): string
    {
        return $this->renderNuoiKhung(3, 'single');
    }

    private function renderBachThuLoNuoiKhung5Ngay(array $attrs): string
    {
        return $this->renderNuoiKhung(5, 'single');
    }

    private function renderSongThuLoVip(array $attrs): string
    {
        $data    = $this->getPredictionData();
        $songThu = $data['soiCauMB']['song_thu'] ?? [null, null];
        $pairs   = array_map(function ($n) {
            if (!$n) return ['so' => null, 'dao' => null];
            $dao = strrev($n);
            return ['so' => $n, 'dao' => ($dao !== $n) ? $dao : null];
        }, $songThu);

        return view('components.shortcodes.song-thu-lo-vip', compact('pairs'))->render();
    }

    private function renderSongThuLoKep(array $attrs): string
    {
        $data    = $this->getPredictionData();
        $loKep   = $data['soiCauMB']['lo_kep'] ?? [];
        $songKep = array_slice($loKep, 0, 2);

        return view('components.shortcodes.song-thu-lo-kep', compact('songKep', 'loKep'))->render();
    }

    private function renderSongThuLoKhung2Ngay(array $attrs): string
    {
        return $this->renderNuoiKhung(2, 'double');
    }

    /**
     * Shared helper: render bảng nuôi khung N ngày
     * mode: 'single' = bạch thủ, 'double' = song thủ (với mirror pairs)
     */
    private function renderNuoiKhung(int $days, string $mode): string
    {
        $data    = $this->getPredictionData();
        $songThu = $data['soiCauMB']['song_thu'] ?? [null, null];
        $bachThu = $data['soiCauMB']['bach_thu'] ?? null;

        $results = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->limit($days)
            ->get();

        $todayStr = now()->timezone('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $khungData = [];

        foreach ($results as $r) {
            $dateStr = $r->date->format('Y-m-d');
            $nums    = array_map(fn($n) => str_pad(substr($n, -2), 2, '0', STR_PAD_LEFT), $r->numbers);
            $hasResults = count($nums) > 0;
            $isToday = ($dateStr === $todayStr);

            if ($mode === 'single') {
                $status = (!$hasResults || $isToday && !$hasResults)
                    ? 'cho'
                    : (in_array($bachThu, $nums) ? 've' : 'khong_ve');
                // Nếu hôm nay nhưng đã có kết quả → hiện kết quả thật
                if ($isToday && $hasResults) {
                    $status = in_array($bachThu, $nums) ? 've' : 'khong_ve';
                }

                $khungData[] = [
                    'date'    => $r->date->format('d/m/Y'),
                    'so_nuoi' => $bachThu,
                    'status'  => $status,
                ];
            } else {
                // double mode: song thủ với mirror pairs
                $pairs = [];
                foreach ($songThu as $so) {
                    if (!$so) continue;
                    $dao = strrev($so);
                    $hit = in_array($so, $nums) || ($dao !== $so && in_array($dao, $nums));
                    $pairs[] = ['so' => $so, 'dao' => ($dao !== $so) ? $dao : null, 'hit' => $hit];
                }

                $allHit = count(array_filter($pairs, fn($p) => $p['hit'])) > 0;
                $status = (!$hasResults || ($isToday && !$hasResults)) ? 'cho'
                    : ($allHit ? 've' : 'khong_ve');
                if ($isToday && $hasResults) {
                    $status = $allHit ? 've' : 'khong_ve';
                }

                $khungData[] = [
                    'date'   => $r->date->format('d/m/Y'),
                    'pairs'  => $pairs,
                    'status' => $status,
                ];
            }
        }

        $template = match ($mode) {
            'double' => 'components.shortcodes.song-thu-lo-khung-2-ngay',
            default  => 'components.shortcodes.bach-thu-lo-nuoi-khung',
        };

        return view($template, compact('khungData', 'days', 'bachThu', 'songThu'))->render();
    }

    private function renderSongThuLoKhung3Ngay(array $attrs): string
    {
        $now   = now()->timezone('Asia/Ho_Chi_Minh');
        $today = $now->toDateString();

        // Lấy kết quả MB từ 29 ngày trước đến hôm nay (index theo ngày)
        $allResults = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', $now->copy()->subDays(29)->toDateString())
            ->orderBy('date')
            ->get()
            ->keyBy(fn($r) => $r->date->format('Y-m-d'));

        // Tần suất lô MB (30 ngày) để làm pool chọn số theo seed
        $freq = [];
        foreach ($allResults as $r) {
            foreach ($r->numbers as $num) {
                $last2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $freq[$last2] = ($freq[$last2] ?? 0) + 1;
            }
        }
        arsort($freq);
        $pool = array_keys($freq);
        if (empty($pool)) {
            for ($i = 0; $i <= 99; $i++) $pool[] = str_pad((string) $i, 2, '0', STR_PAD_LEFT);
        }

        $khungData = [];

        for ($k = 0; $k < 10; $k++) {
            $winStart = $now->copy()->subDays($k * 3);

            // Sinh cặp số riêng cho khung này (seed theo ngày bắt đầu)
            $seed = crc32($winStart->format('Ymd') . 'stl3');
            mt_srand($seed);
            $so1 = null;
            for ($att = 0; $att < 100; $att++) {
                $c = $pool[mt_rand(0, min(count($pool) - 1, 49))];
                if (strrev($c) !== $c) { $so1 = $c; break; }
            }
            if (!$so1) $so1 = '27';
            $dao1 = strrev($so1);

            // Kiểm tra từng ngày trong khung
            $trungDays = [];
            $truotDays = [];
            $hasPending = false;

            for ($d = 0; $d < 3; $d++) {
                $dayDate = $winStart->copy()->addDays($d)->toDateString();

                if ($dayDate > $today) {
                    $hasPending = true;
                    continue; // Ngày tương lai
                }

                $r = $allResults->get($dayDate);
                if (!$r) {
                    // Hôm nay chưa có kết quả
                    if ($dayDate === $today) { $hasPending = true; }
                    continue;
                }

                $nums = array_map(fn($n) => str_pad(substr($n, -2), 2, '0', STR_PAD_LEFT), $r->numbers);
                $hit  = in_array($so1, $nums) || in_array($dao1, $nums);
                if ($hit) {
                    $trungDays[] = 'ngày ' . ($d + 1);
                } else {
                    $truotDays[] = 'ngày ' . ($d + 1);
                }
            }

            $isCurrent = ($k === 0);
            $dateRange = $winStart->format('d/m') . ' – ' . $winStart->copy()->addDays(2)->format('d/m/Y');

            if ($hasPending && empty($trungDays) && empty($truotDays)) {
                $status = 'cho';
            } elseif ($hasPending && !empty($trungDays)) {
                $status = 've'; // Đã về ít nhất 1 ngày
            } elseif (!empty($trungDays)) {
                $status = 've';
            } else {
                $status = 'khong_ve';
            }

            $khungData[] = [
                'date_range' => $dateRange,
                'so1'        => $so1,
                'dao1'       => $dao1,
                'trung'      => $trungDays,
                'truot'      => $truotDays,
                'status'     => $status,
                'is_current' => $isCurrent,
            ];
        }

        $days = 3;
        return view('components.shortcodes.song-thu-lo-khung-3-ngay', compact('khungData', 'days'))->render();
    }

    private function renderSongThuLoKhung5Ngay(array $attrs): string
    {
        return $this->renderNuoiKhung(5, 'double');
    }

    private function renderLrdDuDoan3Cang(array $attrs): string
    {
        $data = $this->getPredictionData();
        $predictionAI = $data['predictionAI'] ?? [];

        // Tần suất đầu số (hàng trăm) từ giải đặc biệt 30 ngày
        $results = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays(30)->toDateString())
            ->orderByDesc('date')
            ->get();

        $headFreq = [];
        foreach ($results as $r) {
            $special = $r->prizes['special'] ?? null;
            if (!$special) continue;
            $spStr = is_array($special) ? ($special[0] ?? '') : $special;
            if (strlen($spStr) >= 3) {
                $h = substr($spStr, -3, 1);
                $headFreq[$h] = ($headFreq[$h] ?? 0) + 1;
            }
        }
        arsort($headFreq);
        $topHeads = array_keys(array_slice($headFreq, 0, 5, true));

        $seed = crc32(date('Ymd') . 'du_doan_3_cang');
        mt_srand($seed);

        $predictions = [];
        if (count($predictionAI) >= 5) {
            foreach ($topHeads as $h) {
                foreach (array_slice($predictionAI, 0, 4) as $item) {
                    $n = str_pad((string) $item['number'], 2, '0', STR_PAD_LEFT);
                    $num3 = $h . $n;
                    $prob = max(15, min(45, 20 + mt_rand(-5, 25)));
                    $predictions[] = ['number' => $num3, 'prob' => $prob];
                    if (count($predictions) >= 10) break 2;
                }
            }
        } else {
            $seen = [];
            while (count($predictions) < 10) {
                $n = str_pad((string) mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
                if (!in_array($n, $seen)) {
                    $seen[] = $n;
                    $predictions[] = ['number' => $n, 'prob' => mt_rand(15, 45)];
                }
            }
        }

        return view('components.shortcodes.lrd-du-doan-3-cang', compact('predictions'))->render();
    }

    private function renderLrdDanLo6So(array $attrs): string
    {
        $data = $this->getPredictionData();
        $predictionAI = $data['predictionAI'] ?? [];

        if (count($predictionAI) >= 6) {
            $danLo = array_map(
                fn($item) => str_pad((string) $item['number'], 2, '0', STR_PAD_LEFT),
                array_slice($predictionAI, 0, 6)
            );
        } else {
            $seed = crc32(date('Ymd') . 'dan_lo_6');
            mt_srand($seed);
            $danLo = [];
            $seen = [];
            while (count($danLo) < 6) {
                $n = str_pad((string) mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
                if (!in_array($n, $seen)) {
                    $seen[] = $n;
                    $danLo[] = $n;
                }
            }
        }

        $results = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->limit(7)
            ->get();

        $history = [];
        foreach ($results as $r) {
            $nums = array_map(fn($n) => str_pad(substr($n, -2), 2, '0', STR_PAD_LEFT), $r->numbers);
            $ve = array_values(array_filter($danLo, fn($n) => in_array($n, $nums)));
            $history[] = [
                'date' => $r->date->format('d/m'),
                'hits' => count($ve),
                've'   => $ve,
            ];
        }

        return view('components.shortcodes.lrd-dan-lo-6-so', compact('danLo', 'history'))->render();
    }

    private function renderLrdDan3CangLo(array $attrs): string
    {
        $data = $this->getPredictionData();
        $predictionAI = $data['predictionAI'] ?? [];

        $results = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays(30)->toDateString())
            ->orderByDesc('date')
            ->get();

        $headFreq = [];
        foreach ($results as $r) {
            $special = $r->prizes['special'] ?? null;
            if (!$special) continue;
            $spStr = is_array($special) ? ($special[0] ?? '') : $special;
            if (strlen($spStr) >= 3) {
                $h = substr($spStr, -3, 1);
                $headFreq[$h] = ($headFreq[$h] ?? 0) + 1;
            }
        }
        arsort($headFreq);
        $topHeads = array_keys(array_slice($headFreq, 0, 3, true));

        $dan3Cang = [];
        if (count($predictionAI) >= 5) {
            foreach ($topHeads as $h) {
                foreach (array_slice($predictionAI, 0, 5) as $item) {
                    $n = $h . str_pad((string) $item['number'], 2, '0', STR_PAD_LEFT);
                    if (!in_array($n, $dan3Cang)) $dan3Cang[] = $n;
                }
            }
        } else {
            $seed = crc32(date('Ymd') . 'dan_3_cang');
            mt_srand($seed);
            while (count($dan3Cang) < 15) {
                $n = str_pad((string) mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
                if (!in_array($n, $dan3Cang)) $dan3Cang[] = $n;
            }
        }

        $dan3Cang = array_slice($dan3Cang, 0, 15);

        return view('components.shortcodes.lrd-dan-3-cang-lo', compact('dan3Cang'))->render();
    }

    private function renderLrdDanDe3Cang(array $attrs): string
    {
        $results = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays(60)->toDateString())
            ->orderByDesc('date')
            ->get();

        $danDe = [];
        foreach ($results as $r) {
            $special = $r->prizes['special'] ?? null;
            if (!$special) continue;
            $spStr = is_array($special) ? ($special[0] ?? '') : $special;
            if (strlen($spStr) >= 3) {
                $last3 = substr($spStr, -3);
                if (!in_array($last3, $danDe)) $danDe[] = $last3;
            }
        }

        // Điền đủ 50 số với seeded random
        $seed = crc32(date('Ymd') . 'dan_de_3_cang');
        mt_srand($seed);
        while (count($danDe) < 50) {
            $n = str_pad((string) mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
            if (!in_array($n, $danDe)) $danDe[] = $n;
        }

        $danDe = array_slice($danDe, 0, 50);
        sort($danDe);

        return view('components.shortcodes.lrd-dan-de-3-cang', compact('danDe'))->render();
    }

    private function renderCauDepHangNgayMB(array $attrs): string
    {
        $data = $this->getPredictionData();
        $predictionAI = $data['predictionAI'] ?? [];

        $dayOfYear = (int) date('z'); // 0–365, xoay vòng theo ngày

        if (count($predictionAI) >= 10) {
            $topNums = array_slice($predictionAI, 0, 10);

            // Nhóm 1: Cầu lô đẹp (top 5 + mirror)
            $cauLoto = [];
            foreach (array_slice($topNums, 0, 5) as $item) {
                $n = str_pad((string) $item['number'], 2, '0', STR_PAD_LEFT);
                $mirror = strrev($n);
                $cauLoto[] = ($n === $mirror) ? [$n] : [$n, $mirror];
            }

            // Nhóm 2: Cầu kép xoay theo ngày
            $kepAll = ['00','11','22','33','44','55','66','77','88','99'];
            $cauKep = [
                $kepAll[$dayOfYear % 10],
                $kepAll[($dayOfYear + 3) % 10],
                $kepAll[($dayOfYear + 7) % 10],
            ];

            // Nhóm 3: Tổng đặc biệt
            $cauTong = array_unique([
                $dayOfYear % 10,
                ($dayOfYear + 4) % 10,
                ($dayOfYear + 7) % 10,
            ]);
        } else {
            // Fallback: seeded random
            $seed = crc32(date('Ymd') . 'cau_dep_mb');
            mt_srand($seed);
            $cauLoto = [];
            $seen = [];
            while (count($cauLoto) < 5) {
                $n = str_pad((string) mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
                if (!in_array($n, $seen)) {
                    $seen[] = $n;
                    $mirror = strrev($n);
                    $cauLoto[] = ($n === $mirror) ? [$n] : [$n, $mirror];
                }
            }
            $cauKep = ['11', '22', '33'];
            $cauTong = [1, 5, 8];
        }

        return view('components.shortcodes.caudephangngay-mb', compact('cauLoto', 'cauKep', 'cauTong'))->render();
    }

    // ─────────────────────────────────────────────
    // Dự đoán 3 miền
    // ─────────────────────────────────────────────

    /**
     * Sinh dự đoán cho một miền dựa trên tần suất lịch sử + seed theo ngày/giờ.
     */
    private function getRegionPrediction(string $region, int $seed): array
    {
        $results = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->limit(20)
            ->get();

        $freq = [];
        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $last2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $freq[$last2] = ($freq[$last2] ?? 0) + 1;
            }
        }
        arsort($freq);

        $pool = array_keys(array_slice($freq, 0, 30, true));
        if (empty($pool)) {
            for ($i = 0; $i <= 99; $i++) {
                $pool[] = str_pad((string) $i, 2, '0', STR_PAD_LEFT);
            }
        }

        mt_srand($seed);
        $selected = [];
        $seen = [];
        $attempts = 0;
        while (count($selected) < 5 && $attempts < 300) {
            $n = $pool[mt_rand(0, count($pool) - 1)];
            if (!in_array($n, $seen)) {
                $seen[] = $n;
                $selected[] = $n;
            }
            $attempts++;
        }
        // Đảm bảo đủ 5 số
        while (count($selected) < 5) {
            $n = str_pad((string) mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
            if (!in_array($n, $seen)) {
                $seen[] = $n;
                $selected[] = $n;
            }
        }

        $mirror = strrev($selected[0]);

        return [
            'bach_thu'    => $selected[0],
            'bach_mirror' => ($mirror !== $selected[0]) ? $mirror : null,
            'song_thu'    => [$selected[0], $selected[1]],
            'de'          => $selected[2],
            'dan'         => $selected,
        ];
    }

    private function renderDuDoan3Mien(array $attrs): string
    {
        $now  = now()->timezone('Asia/Ho_Chi_Minh');
        $hour = (int) $now->format('H');
        $date = $now->format('Ymd');

        // Seed thay đổi theo giờ cập nhật: MT 17h, MN 18h, MB 19h
        $seeds = [
            'MB' => crc32($date . 'MB' . ($hour >= 19 ? '1' : '0')),
            'MT' => crc32($date . 'MT' . ($hour >= 17 ? '1' : '0')),
            'MN' => crc32($date . 'MN' . ($hour >= 18 ? '1' : '0')),
        ];

        $data   = $this->getPredictionData();
        $predAI = $data['predictionAI'] ?? [];

        $regionsMeta = [
            'MB' => ['name' => 'Miền Bắc',  'draw' => '18:10', 'update_hour' => 19, 'color' => 'red',   'updated' => $hour >= 19],
            'MT' => ['name' => 'Miền Trung', 'draw' => '17:15', 'update_hour' => 17, 'color' => 'blue',  'updated' => $hour >= 17],
            'MN' => ['name' => 'Miền Nam',   'draw' => '16:30', 'update_hour' => 18, 'color' => 'green', 'updated' => $hour >= 18],
        ];

        $predictions = [];
        foreach ($regionsMeta as $code => $meta) {
            if ($code === 'MB' && count($predAI) >= 5) {
                mt_srand($seeds[$code]);
                $bach   = str_pad((string) $predAI[0]['number'], 2, '0', STR_PAD_LEFT);
                $mirror = strrev($bach);
                $pred = [
                    'bach_thu'    => $bach,
                    'bach_mirror' => ($mirror !== $bach) ? $mirror : null,
                    'song_thu'    => [
                        str_pad((string) $predAI[0]['number'], 2, '0', STR_PAD_LEFT),
                        str_pad((string) $predAI[1]['number'], 2, '0', STR_PAD_LEFT),
                    ],
                    'de'  => str_pad((string) $predAI[2]['number'], 2, '0', STR_PAD_LEFT),
                    'dan' => array_map(
                        fn($x) => str_pad((string) $x['number'], 2, '0', STR_PAD_LEFT),
                        array_slice($predAI, 0, 5)
                    ),
                ];
            } else {
                $pred = $this->getRegionPrediction($code, $seeds[$code]);
            }

            $predictions[$code] = array_merge($meta, $pred);
        }

        return view('components.shortcodes.du-doan-3-mien', compact('predictions'))->render();
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
