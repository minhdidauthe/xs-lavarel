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
        'caudephangngay_mb'              => 'renderCauDepHangNgayMB',
        'caudephangngay_mn'              => 'renderCauDepHangNgayMN',
        'caudephangngay_mt'              => 'renderCauDepHangNgayMT',
        'caudephangngay1_mn'             => 'renderCauDepHangNgay1MN',
        'caudephangngay1_mt'             => 'renderCauDepHangNgay1MT',
        'caudephangngay'                 => 'renderCauDepHangNgayTinh',
        // Dự đoán 3 miền
        'du_doan_3_mien'                 => 'renderDuDoan3Mien',
        // KQXS mở rộng
        'ket_qua_xo_so'                  => 'renderKetQuaXoSo',
        'lrd_results'                    => 'renderLrdResults',
        'lrd_region_results'             => 'renderLrdRegionResults',
        'thong_ke_general'               => 'renderThongKeGeneral',
        // Lô gan mở rộng
        'lrd_logan'                      => 'renderLrdLoGan',
        'lrd_logan_full'                 => 'renderLrdLoGanFull',
        // Bảng đặc biệt
        'lrd_bang_dac_biet_nam'          => 'renderLrdBangDacBietNam',
        'lrd_bang_dac_biet_thang'        => 'renderLrdBangDacBietThang',
        'lrd_bang_dac_biet_tuan'         => 'renderLrdBangDacBietTuan',
        // Thống kê chuyên sâu
        'lrd_thong_ke_dau_duoi_loto'     => 'renderLrdThongKeDauDuoiLoto',
        'lrd_thong_ke_lo_kep'            => 'renderLrdThongKeLoKep',
        'lrd_thong_ke_lo_roi'            => 'renderLrdThongKeLoRoi',
        'lrd_thong_ke_tan_suat_loto'     => 'renderLrdThongKeTanSuatLoto',
        'lrd_thong_ke_theo_tong'         => 'renderLrdThongKeTheoTong',
        'lrd_thong_ke_chu_ky_dac_biet'   => 'renderLrdThongKeChuKyDacBiet',
        'lrd_thong_ke_giai_dac_biet_gan' => 'renderLrdThongKeGiaiDacBietGan',
        'lrd_thong_ke_quan_trong'        => 'renderLrdThongKeQuanTrong',
        'lrd_thong_ke_tan_suat_cap_loto' => 'renderLrdThongKeTanSuatCapLoto',
        'lrd_thong_ke_tong_hop'          => 'renderLrdThongKeTongHop',
        'lrd_soi_cau_pascal'             => 'renderLrdSoiCauPascal',
        // Kết quả nhiều ngày & theo thứ
        'lrd_xsmb_nhieu_ngay'            => 'renderLrdXsmbNhieuNgay',
        'lrd_xsmn_theo_thu'              => 'renderLrdXsmnTheoThu',
        'lrd_xsmt_theo_thu'              => 'renderLrdXsmtTheoThu',
        // Soi cầu MB aliases
        'chotsoxsmb'                     => 'renderChotSoXsMB',
        'soicauxsmb'                     => 'renderSoiCauXsMB',
        'du_doan_xsmb'                   => 'renderDuDoanXsMB',
        'so_cau_xsmb'                    => 'renderSoCauXsMB',
        // Cao thủ / top lô
        'cao_thu_mo_bat'                 => 'renderCaoThuMoBat',
        'lo_de_bac_nho'                  => 'renderLoDeBacNho',
        'lrd_top_lo_dep_nhat'            => 'renderLrdTopLoDepNhat',
        // Dàn đề / công cụ
        'dandehangngay'                  => 'renderDanDeHangNgay',
        'taodande'                       => 'renderTaoDande',
        'lrd_ghep_lo_xien_tu_dong'       => 'renderGhepLoXienTuDong',
        // VIP đọc thủ (aliases + new)
        'bach_thu_lo_kep_vip'            => 'renderBachThuLoKep',
        'song_thu_lo_kep_vip'            => 'renderSongThuLoKep',
        'doc_thu_lo_vip'                 => 'renderDocThuLoVip',
        'doc_thu_de_vip'                 => 'renderDocThuDeVip',
        'doc_thu_lo_kep_vip'             => 'renderDocThuLoKepVip',
        'doc_thu_de_kep_vip'             => 'renderDocThuDeKepVip',
        // Lô kép nuôi khung
        'lo_kep_khung_2_ngay'            => 'renderLoKepKhung2Ngay',
        'lo_kep_khung_3_ngay'            => 'renderLoKepKhung3Ngay',
        'lo_kep_khung_5_ngay'            => 'renderLoKepKhung5Ngay',
        // Vietlott & Keno
        'lrd_keno'                       => 'renderLrdKeno',
        'lrd_xsmega645'                  => 'renderLrdXsMega645',
        'lrd_power655'                   => 'renderLrdPower655',
        'lrd_max3d'                      => 'renderLrdMax3d',
        'lrd_max3dpro'                   => 'renderLrdMax3dPro',
        'lrd_lotto_535'                  => 'renderLrdLotto535',
        'lrd_bingo18'                    => 'renderLrdBingo18',
        'dudoanvietlott_power'           => 'renderDuDoanVietlottPower',
        'dudoanvietlott_mega'            => 'renderDuDoanVietlottMega',
        // Quay thử & số mơ
        'lrd_page_quay_thu'              => 'renderLrdPageQuayThu',
        'quay_thu'                       => 'renderQuayThu',
        'lrd_so_mo'                      => 'renderLrdSoMo',
        'lrd_sosanh_tansuat'             => 'renderLrdSoSanhTanSuat',
    ];

    /** Cache prediction data (shared by soi_cau_mb, cau_dep, lo_top, du_doan_cards) */
    private ?array $predictionCache = null;

    /** Cache stats data (shared by thong_ke_nhanh, thong_ke_lo) */
    private ?array $statsCache = null;

    public function parse(string $content): string
    {
        $pattern = '/\[([a-z_][a-z0-9_]*)((?:\s+[a-z_]+=(?:"[^"]*"|[^\s\]]+))*)\]/i';

        return preg_replace_callback($pattern, function ($matches) {
            $tag = strtolower($matches[1]);
            $attrs = $this->parseAttributes($matches[2] ?? '');

            try {
                if (isset($this->builtins[$tag])) {
                    $dbRecord = Shortcode::where('code', $tag)->where('is_builtin', true)->first();
                    if ($dbRecord && !$dbRecord->is_active) {
                        return '';
                    }
                    $method = $this->builtins[$tag];
                    return $this->$method($attrs);
                }

                $custom = Shortcode::where('code', $tag)->where('is_active', true)->first();
                if ($custom) {
                    return $this->renderCustom($custom, $attrs);
                }
            } catch (\Throwable $e) {
                \Log::error("Shortcode [$tag] error: " . $e->getMessage());
                return "<!-- shortcode [$tag] error -->";
            }

            return $matches[0];
        }, $content);
    }

    private function parseAttributes(string $attrString): array
    {
        $attrs = [];
        preg_match_all('/([a-z_]+)=(?:"([^"]*)"|([^\s\]]+))/i', $attrString, $m, PREG_SET_ORDER);
        foreach ($m as $match) {
            $attrs[$match[1]] = $match[2] !== '' ? $match[2] : ($match[3] ?? '');
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
        $now      = now()->timezone('Asia/Ho_Chi_Minh');
        $todayStr = $now->toDateString();
        $service  = new PredictionService();

        // Hôm nay: predict dùng data trước hôm nay (predict cho hôm nay)
        $todayPred   = $service->predict($todayStr, 'MB');
        $todayTop    = $todayPred['top10'] ?? [];
        $bachThuToday = isset($todayTop[0]) ? str_pad($todayTop[0]['number'], 2, '0', STR_PAD_LEFT) : null;
        $songThuToday = [
            isset($todayTop[0]) ? str_pad($todayTop[0]['number'], 2, '0', STR_PAD_LEFT) : null,
            isset($todayTop[1]) ? str_pad($todayTop[1]['number'], 2, '0', STR_PAD_LEFT) : null,
        ];

        // Lấy kết quả $days ngày gần nhất (không tính hôm nay nếu chưa có KQ)
        $results = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->limit($days + 1) // lấy thêm 1 để cover hôm nay
            ->get();

        $khungData = [];

        // Row 1: Hôm nay (dự đoán cho hôm nay, chờ KQ hoặc đã có)
        $todayResult = $results->first(fn($r) => $r->date->format('Y-m-d') === $todayStr);
        if ($todayResult) {
            $todayNums = array_map(fn($n) => str_pad(substr($n, -2), 2, '0', STR_PAD_LEFT), $todayResult->numbers);
        }
        $hasTodayResults = $todayResult && count($todayResult->numbers) > 0;

        if ($mode === 'single') {
            $khungData[] = [
                'date'    => $now->format('d/m/Y'),
                'so_nuoi' => $bachThuToday,
                'status'  => $hasTodayResults
                    ? (in_array($bachThuToday, $todayNums) ? 've' : 'khong_ve')
                    : 'cho',
            ];
        } else {
            $pairs = [];
            foreach ($songThuToday as $so) {
                if (!$so) continue;
                $dao = strrev($so);
                $hit = $hasTodayResults && (in_array($so, $todayNums) || ($dao !== $so && in_array($dao, $todayNums)));
                $pairs[] = ['so' => $so, 'dao' => ($dao !== $so) ? $dao : null, 'hit' => $hit];
            }
            $anyHit = count(array_filter($pairs, fn($p) => $p['hit'])) > 0;
            $khungData[] = [
                'date'   => $now->format('d/m/Y'),
                'pairs'  => $pairs,
                'status' => $hasTodayResults ? ($anyHit ? 've' : 'khong_ve') : 'cho',
            ];
        }

        // Rows 2..N: Các ngày trước (predict cho ngày đó bằng data trước ngày đó → check KQ thực tế)
        $pastResults = $results->filter(fn($r) => $r->date->format('Y-m-d') !== $todayStr)
            ->take($days - 1)->values();

        foreach ($pastResults as $r) {
            $dateStr = $r->date->format('Y-m-d');
            $nums    = array_map(fn($n) => str_pad(substr($n, -2), 2, '0', STR_PAD_LEFT), $r->numbers);

            // Chạy predict cho ngày $dateStr (dùng data trước ngày đó)
            $pred = $service->predict($dateStr, 'MB');
            $top  = $pred['top10'] ?? [];

            if ($mode === 'single') {
                $bachThuDay = isset($top[0]) ? str_pad($top[0]['number'], 2, '0', STR_PAD_LEFT) : '--';
                $khungData[] = [
                    'date'    => $r->date->format('d/m/Y'),
                    'so_nuoi' => $bachThuDay,
                    'status'  => in_array($bachThuDay, $nums) ? 've' : 'khong_ve',
                ];
            } else {
                $songDay = [
                    isset($top[0]) ? str_pad($top[0]['number'], 2, '0', STR_PAD_LEFT) : null,
                    isset($top[1]) ? str_pad($top[1]['number'], 2, '0', STR_PAD_LEFT) : null,
                ];
                $pairs = [];
                foreach ($songDay as $so) {
                    if (!$so) continue;
                    $dao = strrev($so);
                    $hit = in_array($so, $nums) || ($dao !== $so && in_array($dao, $nums));
                    $pairs[] = ['so' => $so, 'dao' => ($dao !== $so) ? $dao : null, 'hit' => $hit];
                }
                $anyHit = count(array_filter($pairs, fn($p) => $p['hit'])) > 0;
                $khungData[] = [
                    'date'   => $r->date->format('d/m/Y'),
                    'pairs'  => $pairs,
                    'status' => $anyHit ? 've' : 'khong_ve',
                ];
            }
        }

        // Lấy bach/song thủ hôm nay cho header display
        $bachThu = $bachThuToday;
        $songThu = $songThuToday;

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

        // Tần suất đuôi 2 chữ số từ lô thực tế (dùng cho cả AI lẫn fallback)
        $tailFreq = [];
        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $last2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $tailFreq[$last2] = ($tailFreq[$last2] ?? 0) + 1;
            }
        }
        arsort($tailFreq);
        $topTails = array_keys(array_slice($tailFreq, 0, 5, true));
        $totalTail = array_sum($tailFreq) ?: 1;

        $predictions = [];
        if (count($predictionAI) >= 5) {
            foreach ($topHeads as $h) {
                foreach (array_slice($predictionAI, 0, 4) as $item) {
                    $tail  = str_pad((string) $item['number'], 2, '0', STR_PAD_LEFT);
                    $num3  = $h . $tail;
                    // Tỉ lệ dựa trên tần suất đuôi thực tế
                    $prob  = isset($tailFreq[$tail])
                        ? max(15, min(45, (int) round($tailFreq[$tail] / $totalTail * 1000)))
                        : mt_rand(15, 30);
                    $predictions[] = ['number' => $num3, 'prob' => $prob];
                    if (count($predictions) >= 10) break 2;
                }
            }
        } else {
            // Fallback: kết hợp top heads với top tails từ tần suất thực
            foreach ($topHeads as $h) {
                foreach ($topTails as $t) {
                    $num3 = $h . $t;
                    $prob = max(15, min(45, (int) round($tailFreq[$t] / $totalTail * 1000)));
                    $predictions[] = ['number' => $num3, 'prob' => $prob];
                    if (count($predictions) >= 10) break 2;
                }
            }
        }

        return view('components.shortcodes.lrd-du-doan-3-cang', compact('predictions'))->render();
    }

    private function renderLrdDanLo6So(array $attrs): string
    {
        $now   = now()->timezone('Asia/Ho_Chi_Minh');
        $today = $now->toDateString();

        // Lấy kết quả MB 30 ngày để xây frequency pool
        $allResults = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', $now->copy()->subDays(30)->toDateString())
            ->orderByDesc('date')
            ->get();

        $freq = [];
        foreach ($allResults as $r) {
            foreach ($r->numbers as $num) {
                $last2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $freq[$last2] = ($freq[$last2] ?? 0) + 1;
            }
        }
        arsort($freq);
        // Top 30 số xuất hiện nhiều nhất làm pool chọn số
        $freqPool = array_keys(array_slice($freq, 0, 30, true));
        if (empty($freqPool)) {
            for ($i = 0; $i <= 99; $i++) $freqPool[] = str_pad((string) $i, 2, '0', STR_PAD_LEFT);
        }

        $dbResults = $allResults->keyBy(fn($r) => $r->date->format('Y-m-d'));

        // AI prediction cho hôm nay
        $data = $this->getPredictionData();
        $predictionAI = $data['predictionAI'] ?? [];

        $history = [];
        for ($i = 0; $i < 7; $i++) {
            $date    = $now->copy()->subDays($i);
            $dateKey = $date->format('Y-m-d');

            if ($i === 0 && count($predictionAI) >= 6) {
                // Hôm nay: dùng AI prediction nếu có
                $danLo = array_map(
                    fn($item) => str_pad((string) $item['number'], 2, '0', STR_PAD_LEFT),
                    array_slice($predictionAI, 0, 6)
                );
            } else {
                // Các ngày khác: chọn từ frequency pool bằng seed theo ngày
                $seed = crc32($dateKey . 'dan_lo_6');
                mt_srand($seed);
                $danLo = [];
                $seen  = [];
                while (count($danLo) < 6) {
                    $n = $freqPool[mt_rand(0, count($freqPool) - 1)];
                    if (!in_array($n, $seen)) {
                        $seen[]  = $n;
                        $danLo[] = $n;
                    }
                }
            }
            sort($danLo);

            if (isset($dbResults[$dateKey])) {
                $r    = $dbResults[$dateKey];
                $nums = array_map(fn($n) => str_pad(substr($n, -2), 2, '0', STR_PAD_LEFT), $r->numbers);
                $ve   = array_values(array_filter($danLo, fn($n) => in_array($n, $nums)));
                $history[] = [
                    'date'     => $date->format('d/m'),
                    'danLo'    => $danLo,
                    'hits'     => count($ve),
                    've'       => $ve,
                    'status'   => count($ve) > 0 ? 've' : 'khong_ve',
                    'is_today' => $i === 0,
                ];
            } else {
                // No result yet (today before 19h or future)
                $history[] = [
                    'date'     => $date->format('d/m'),
                    'danLo'    => $danLo,
                    'hits'     => 0,
                    've'       => [],
                    'status'   => 'cho',
                    'is_today' => $i === 0,
                ];
            }
        }

        return view('components.shortcodes.lrd-dan-lo-6-so', compact('history'))->render();
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

        // Tần suất đuôi 2 chữ số từ lô thực tế
        $tailFreq = [];
        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $last2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $tailFreq[$last2] = ($tailFreq[$last2] ?? 0) + 1;
            }
        }
        arsort($tailFreq);
        $topTails = array_keys(array_slice($tailFreq, 0, 5, true));

        $dan3Cang = [];
        if (count($predictionAI) >= 5) {
            foreach ($topHeads as $h) {
                foreach (array_slice($predictionAI, 0, 5) as $item) {
                    $n = $h . str_pad((string) $item['number'], 2, '0', STR_PAD_LEFT);
                    if (!in_array($n, $dan3Cang)) $dan3Cang[] = $n;
                }
            }
        } else {
            // Fallback: kết hợp top heads với top tails từ tần suất thực
            foreach ($topHeads as $h) {
                foreach ($topTails as $t) {
                    $n = $h . $t;
                    if (!in_array($n, $dan3Cang)) $dan3Cang[] = $n;
                }
            }
            // Nếu chưa đủ 15, bổ sung bằng top tails + heads còn lại
            $allHeads = array_keys($headFreq);
            foreach ($allHeads as $h) {
                foreach ($topTails as $t) {
                    if (count($dan3Cang) >= 15) break 2;
                    $n = $h . $t;
                    if (!in_array($n, $dan3Cang)) $dan3Cang[] = $n;
                }
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

        // Lấy kết quả MB 30 ngày cho phân tích lô gan và tần suất tổng
        $results30 = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays(30)->toDateString())
            ->orderByDesc('date')
            ->get();

        // ── Cầu kép: tìm kép lô gan (lâu không về nhất) ──────────────
        $kepAll = ['00','11','22','33','44','55','66','77','88','99'];
        $kepLastSeen = array_fill_keys($kepAll, null); // null = chưa về lần nào
        foreach ($results30 as $r) {
            $nums = array_map(fn($n) => str_pad(substr($n, -2), 2, '0', STR_PAD_LEFT), $r->numbers);
            $dateStr = $r->date->format('Y-m-d');
            foreach ($kepAll as $k) {
                if ($kepLastSeen[$k] === null && in_array($k, $nums)) {
                    $kepLastSeen[$k] = $dateStr;
                }
            }
        }
        // Sắp xếp: null (chưa về) trước, rồi đến ngày về cũ nhất
        uasort($kepLastSeen, fn($a, $b) => match(true) {
            $a === null && $b === null => 0,
            $a === null => -1,
            $b === null => 1,
            default => strcmp($a, $b),
        });
        $cauKep = array_slice(array_keys($kepLastSeen), 0, 3);

        // ── Tổng ĐB: tần suất tổng 2 chữ số cuối giải đặc biệt ────────
        $tongFreq = [];
        foreach ($results30 as $r) {
            $special = $r->prizes['special'] ?? null;
            if (!$special) continue;
            $spStr = is_array($special) ? ($special[0] ?? '') : $special;
            if (strlen($spStr) >= 2) {
                $last2 = substr($spStr, -2);
                $tong  = (int)$last2[0] + (int)$last2[1];
                $tongFreq[$tong] = ($tongFreq[$tong] ?? 0) + 1;
            }
        }
        arsort($tongFreq);
        $cauTong = array_keys(array_slice($tongFreq, 0, 3, true));
        if (empty($cauTong)) $cauTong = [3, 7, 8]; // fallback tĩnh nếu không có data

        // ── Cầu lô đẹp: AI prediction hoặc frequency pool ─────────────
        if (count($predictionAI) >= 5) {
            $cauLoto = [];
            foreach (array_slice($predictionAI, 0, 5) as $item) {
                $n = str_pad((string) $item['number'], 2, '0', STR_PAD_LEFT);
                $mirror = strrev($n);
                $cauLoto[] = ($n === $mirror) ? [$n] : [$n, $mirror];
            }
        } else {
            // Fallback: top 5 số xuất hiện nhiều nhất 30 ngày gần đây
            $loFreq = [];
            foreach ($results30 as $r) {
                foreach ($r->numbers as $num) {
                    $last2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                    $loFreq[$last2] = ($loFreq[$last2] ?? 0) + 1;
                }
            }
            arsort($loFreq);
            $cauLoto = [];
            foreach (array_keys(array_slice($loFreq, 0, 5, true)) as $n) {
                $mirror = strrev($n);
                $cauLoto[] = ($n === $mirror) ? [$n] : [$n, $mirror];
            }
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

    // ═══════════════════════════════════════════════
    // NHÓM: KQXS & Thống kê mở rộng
    // ═══════════════════════════════════════════════

    private function renderKetQuaXoSo(array $attrs): string
    {
        $domainMap = ['1' => 'MB', '2' => 'MT', '3' => 'MN'];
        $region    = $domainMap[$attrs['domain'] ?? '1'] ?? 'MB';
        $province  = $attrs['province'] ?? null;
        $ngay      = $attrs['ngay'] ?? null;

        $query = LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI');
        if ($province) $query->where('province', $province);
        if ($ngay)     $query->whereDate('date', \Carbon\Carbon::createFromFormat('d-m-Y', $ngay));
        $result = $query->orderByDesc('date')->first();

        return view('components.shortcodes.kqxs', compact('result', 'region'))->render();
    }

    private function renderLrdResults(array $attrs): string
    {
        $region = 'MB';
        $limit  = (int) ($attrs['limit'] ?? 10);
        $results = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')->limit($limit)->get();
        return view('components.shortcodes.lrd-results', compact('results'))->render();
    }

    private function renderLrdRegionResults(array $attrs): string
    {
        $regionMap = ['bac' => 'MB', 'nam' => 'MN', 'trung' => 'MT'];
        $region    = $regionMap[$attrs['region'] ?? 'nam'] ?? 'MN';
        $limit     = (int) ($attrs['limit'] ?? 10);

        $results = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')->limit($limit)->get();

        return view('components.shortcodes.lrd-region-results', compact('results', 'region', 'limit'))->render();
    }

    private function renderThongKeGeneral(array $attrs): string
    {
        $domainMap = ['1' => 'MB', '2' => 'MT', '3' => 'MN'];
        $region    = $domainMap[$attrs['domain'] ?? '1'] ?? 'MB';
        $days      = 30;

        $results = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays($days)->toDateString())
            ->orderByDesc('date')->get();

        $dau = array_fill(0, 10, 0);
        $duoi = array_fill(0, 10, 0);
        $freq = [];
        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $last2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $dau[(int)$last2[0]]++;
                $duoi[(int)$last2[1]]++;
                $freq[$last2] = ($freq[$last2] ?? 0) + 1;
            }
        }
        arsort($freq);
        $loTop = array_slice($freq, 0, 20, true);

        return view('components.shortcodes.thong-ke-general', compact('dau', 'duoi', 'loTop', 'region', 'days'))->render();
    }

    private function renderLrdLoGan(array $attrs): string
    {
        $mienMap = ['1' => 'MB', '2' => 'MN', '3' => 'MT'];
        $region  = $mienMap[$attrs['mien'] ?? '1'] ?? 'MB';
        $type    = $attrs['type'] ?? 'normal';
        $dai     = $attrs['dai'] ?? null;
        $limit   = 20;

        $query = LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI');
        if ($dai) $query->where('province', $dai);
        $results = $query->orderByDesc('date')->limit(60)->get();

        $today    = now()->startOfDay();
        $lastSeen = [];
        foreach ($results as $r) {
            $daysAgo = (int) $r->date->startOfDay()->diffInDays($today);
            foreach ($r->numbers as $num) {
                $last2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                if (!isset($lastSeen[$last2])) $lastSeen[$last2] = $daysAgo;
            }
        }
        arsort($lastSeen);
        $loGan = array_slice($lastSeen, 0, $limit, true);

        // Danh sách tỉnh cho dropdown
        $provinces = $type === 'dropdown'
            ? LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI')
                ->distinct()->pluck('province')->toArray()
            : [];

        return view('components.shortcodes.lrd-logan', compact('loGan', 'region', 'mienMap', 'type', 'dai', 'provinces'))->render();
    }

    private function renderLrdLoGanFull(array $attrs): string
    {
        $region = $attrs['region'] ?? 'mb';
        $regionMap = ['mb' => 'MB', 'mn' => 'MN', 'mt' => 'MT'];
        $reg = $regionMap[$region] ?? 'MB';

        $results = LotteryResult::where('region', $reg)
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')->limit(90)->get();

        $today = now()->startOfDay();
        $loGanAll = [];
        foreach ($results as $r) {
            $daysAgo = (int) $r->date->startOfDay()->diffInDays($today);
            foreach ($r->numbers as $num) {
                $last2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                if (!isset($loGanAll[$last2])) $loGanAll[$last2] = $daysAgo;
            }
        }
        // Điền những số chưa về
        for ($i = 0; $i <= 99; $i++) {
            $n = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            if (!isset($loGanAll[$n])) $loGanAll[$n] = 90;
        }
        arsort($loGanAll);

        return view('components.shortcodes.lrd-logan-full', compact('loGanAll', 'region', 'reg'))->render();
    }

    // ── Bảng đặc biệt ───────────────────────────────────────────────────

    private function renderLrdBangDacBietNam(array $attrs): string
    {
        $year   = (int) ($attrs['year'] ?? date('Y'));
        $region = $attrs['region'] ?? 'MB';

        $results = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->whereYear('date', $year)
            ->orderByDesc('date')->get();

        $bangDB = [];
        foreach ($results as $r) {
            $sp = $r->prizes['special'] ?? null;
            if ($sp) {
                $bangDB[] = [
                    'date'     => $r->date->format('d/m'),
                    'province' => $r->province,
                    'so'       => is_array($sp) ? ($sp[0] ?? '') : $sp,
                ];
            }
        }

        $title = "Giải ĐB Năm $year";
        return view('components.shortcodes.lrd-bang-db', compact('bangDB', 'year', 'region', 'title'))->render();
    }

    private function renderLrdBangDacBietThang(array $attrs): string
    {
        $month  = (int) ($attrs['month'] ?? date('m'));
        $year   = (int) ($attrs['year'] ?? date('Y'));
        $region = $attrs['region'] ?? 'MB';

        $results = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->whereYear('date', $year)->whereMonth('date', $month)
            ->orderByDesc('date')->get();

        $bangDB = [];
        foreach ($results as $r) {
            $sp = $r->prizes['special'] ?? null;
            if ($sp) {
                $bangDB[] = [
                    'date'     => $r->date->format('d/m'),
                    'province' => $r->province,
                    'so'       => is_array($sp) ? ($sp[0] ?? '') : $sp,
                ];
            }
        }

        return view('components.shortcodes.lrd-bang-db', compact('bangDB', 'year', 'region'))
            ->with('title', "Giải ĐB Tháng $month/$year")->render();
    }

    private function renderLrdBangDacBietTuan(array $attrs): string
    {
        $region = $attrs['region'] ?? 'MB';

        $results = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays(7)->toDateString())
            ->orderByDesc('date')->get();

        $bangDB = [];
        foreach ($results as $r) {
            $sp = $r->prizes['special'] ?? null;
            if ($sp) {
                $bangDB[] = [
                    'date'     => $r->date->format('d/m'),
                    'province' => $r->province,
                    'so'       => is_array($sp) ? ($sp[0] ?? '') : $sp,
                ];
            }
        }

        $year = date('Y');
        return view('components.shortcodes.lrd-bang-db', compact('bangDB', 'year', 'region'))
            ->with('title', '7 Ngày Gần Nhất')->render();
    }

    // ── Thống kê chuyên sâu ────────────────────────────────────────────

    private function renderLrdThongKeDauDuoiLoto(array $attrs): string
    {
        $days   = (int) ($attrs['days'] ?? 30);
        $region = $attrs['region'] ?? 'MB';
        $results = LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays($days)->toDateString())
            ->orderByDesc('date')->get();

        $dau = array_fill(0, 10, 0);
        $duoi = array_fill(0, 10, 0);
        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $l2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $dau[(int)$l2[0]]++;
                $duoi[(int)$l2[1]]++;
            }
        }

        return view('components.shortcodes.lrd-thong-ke-dau-duoi', compact('dau', 'duoi', 'days', 'region'))->render();
    }

    private function renderLrdThongKeLoKep(array $attrs): string
    {
        $days   = (int) ($attrs['days'] ?? 30);
        $region = $attrs['region'] ?? 'MB';
        $results = LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays($days)->toDateString())
            ->get();

        $kepFreq = [];
        $kepAll  = ['00','11','22','33','44','55','66','77','88','99'];
        foreach ($kepAll as $k) $kepFreq[$k] = 0;

        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $l2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                if (in_array($l2, $kepAll)) $kepFreq[$l2]++;
            }
        }
        arsort($kepFreq);

        return view('components.shortcodes.lrd-thong-ke-lo-kep', compact('kepFreq', 'days', 'region'))->render();
    }

    private function renderLrdThongKeLoRoi(array $attrs): string
    {
        $days   = (int) ($attrs['days'] ?? 30);
        $region = $attrs['region'] ?? 'MB';
        $results = LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays($days)->toDateString())
            ->orderByDesc('date')->get();

        $today   = now()->startOfDay();
        $lastSeen = [];
        foreach ($results as $r) {
            $daysAgo = (int) $r->date->startOfDay()->diffInDays($today);
            foreach ($r->numbers as $num) {
                $l2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                if (!isset($lastSeen[$l2])) $lastSeen[$l2] = $daysAgo;
            }
        }
        // Số chưa về → gan tối đa
        for ($i = 0; $i <= 99; $i++) {
            $n = str_pad((string)$i, 2, '0', STR_PAD_LEFT);
            if (!isset($lastSeen[$n])) $lastSeen[$n] = $days + 1;
        }
        arsort($lastSeen);
        $loRoi = array_slice($lastSeen, 0, 20, true);

        return view('components.shortcodes.lrd-thong-ke-lo-roi', compact('loRoi', 'days', 'region'))->render();
    }

    private function renderLrdThongKeTanSuatLoto(array $attrs): string
    {
        $days   = (int) ($attrs['days'] ?? 30);
        $region = $attrs['region'] ?? 'MB';
        $results = LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays($days)->toDateString())->get();

        $freq = [];
        for ($i = 0; $i <= 99; $i++) $freq[str_pad((string)$i, 2, '0', STR_PAD_LEFT)] = 0;
        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $l2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $freq[$l2]++;
            }
        }
        arsort($freq);

        return view('components.shortcodes.lrd-thong-ke-tan-suat-loto', compact('freq', 'days', 'region'))->render();
    }

    private function renderLrdThongKeTheoTong(array $attrs): string
    {
        $days   = (int) ($attrs['days'] ?? 30);
        $region = $attrs['region'] ?? 'MB';
        $results = LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays($days)->toDateString())->get();

        $tongFreq = array_fill(0, 19, 0); // tổng 2 chữ số: 0..18
        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $l2   = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $tong = (int)$l2[0] + (int)$l2[1];
                $tongFreq[$tong]++;
            }
        }

        return view('components.shortcodes.lrd-thong-ke-theo-tong', compact('tongFreq', 'days', 'region'))->render();
    }

    private function renderLrdThongKeChuKyDacBiet(array $attrs): string
    {
        $region = $attrs['region'] ?? 'MB';
        $results = LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')->limit(60)->get();

        $spNums = [];
        foreach ($results as $r) {
            $sp = $r->prizes['special'] ?? null;
            if ($sp) {
                $spStr = is_array($sp) ? ($sp[0] ?? '') : $sp;
                $last2 = substr($spStr, -2);
                if (strlen($last2) === 2 && ctype_digit($last2)) {
                    $spNums[] = ['date' => $r->date->format('d/m'), 'so' => $last2, 'full' => $spStr];
                }
            }
        }

        // Tính chu kỳ lặp lại
        $chuKy = [];
        $seen  = [];
        foreach ($spNums as $idx => $item) {
            $n = $item['so'];
            if (isset($seen[$n])) {
                $gap = $idx - $seen[$n];
                $chuKy[$n] = ($chuKy[$n] ?? []);
                $chuKy[$n][] = $gap;
            }
            $seen[$n] = $idx;
        }

        return view('components.shortcodes.lrd-thong-ke-chu-ky-db', compact('spNums', 'chuKy', 'region'))->render();
    }

    private function renderLrdThongKeGiaiDacBietGan(array $attrs): string
    {
        $region = $attrs['region'] ?? 'MB';
        $days   = (int) ($attrs['days'] ?? 30);
        $results = LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')->limit($days)->get();

        $today    = now()->startOfDay();
        $dbLastSeen = [];
        foreach ($results as $r) {
            $sp = $r->prizes['special'] ?? null;
            if (!$sp) continue;
            $spStr = is_array($sp) ? ($sp[0] ?? '') : $sp;
            $l2 = substr($spStr, -2);
            if (strlen($l2) === 2 && ctype_digit($l2)) {
                $daysAgo = (int) $r->date->startOfDay()->diffInDays($today);
                if (!isset($dbLastSeen[$l2])) $dbLastSeen[$l2] = $daysAgo;
            }
        }
        arsort($dbLastSeen);
        $dbGan = array_slice($dbLastSeen, 0, 15, true);

        return view('components.shortcodes.lrd-thong-ke-db-gan', compact('dbGan', 'region', 'days'))->render();
    }

    private function renderLrdThongKeQuanTrong(array $attrs): string
    {
        $region = $attrs['region'] ?? 'MB';
        $data   = $this->getStatsData();
        $pred   = $this->getPredictionData();

        return view('components.shortcodes.lrd-thong-ke-quan-trong', [
            'frequency'   => $data['frequency'],
            'waiting'     => $data['waiting'],
            'ganHead'     => $data['ganHead'],
            'ganTail'     => $data['ganTail'],
            'predictionAI' => $pred['predictionAI'],
            'region'      => $region,
        ])->render();
    }

    private function renderLrdThongKeTanSuatCapLoto(array $attrs): string
    {
        $days   = (int) ($attrs['days'] ?? 30);
        $region = $attrs['region'] ?? 'MB';
        $results = LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays($days)->toDateString())->get();

        // Tần suất cặp lô (2 số xuất hiện cùng ngày)
        $capFreq = [];
        foreach ($results as $r) {
            $nums = array_unique(array_map(
                fn($n) => str_pad(substr($n, -2), 2, '0', STR_PAD_LEFT),
                $r->numbers
            ));
            sort($nums);
            for ($i = 0; $i < count($nums); $i++) {
                for ($j = $i + 1; $j < count($nums); $j++) {
                    $key = $nums[$i] . '-' . $nums[$j];
                    $capFreq[$key] = ($capFreq[$key] ?? 0) + 1;
                }
            }
        }
        arsort($capFreq);
        $topCap = array_slice($capFreq, 0, 20, true);

        return view('components.shortcodes.lrd-thong-ke-cap-loto', compact('topCap', 'days', 'region'))->render();
    }

    private function renderLrdThongKeTongHop(array $attrs): string
    {
        $days   = (int) ($attrs['days'] ?? 30);
        $region = $attrs['region'] ?? 'MB';
        $stats  = $this->getStatsData($days);
        $pred   = $this->getPredictionData();

        return view('components.shortcodes.lrd-thong-ke-tong-hop', array_merge($stats, [
            'days'        => $days,
            'region'      => $region,
            'predictionAI' => $pred['predictionAI'],
        ]))->render();
    }

    private function renderLrdSoiCauPascal(array $attrs): string
    {
        $region = $attrs['region'] ?? 'MB';
        $rows   = (int) ($attrs['rows'] ?? 6);

        // Lấy giải ĐB gần nhất làm seed Pascal
        $latest = LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')->first();

        $spStr  = '';
        if ($latest) {
            $sp     = $latest->prizes['special'] ?? null;
            $spStr  = is_array($sp) ? ($sp[0] ?? '') : $sp;
        }

        // Xây tam giác Pascal từ số ĐB
        $digits  = array_map('intval', str_split(preg_replace('/\D/', '', $spStr)));
        $pascal  = [$digits];
        for ($r = 1; $r < $rows; $r++) {
            $prev = $pascal[$r - 1];
            $row  = [];
            for ($c = 0; $c < count($prev) - 1; $c++) {
                $row[] = ($prev[$c] + $prev[$c + 1]) % 10;
            }
            if (empty($row)) break;
            $pascal[] = $row;
        }

        // Rút ra số dự đoán từ hàng cuối
        $lastRow = end($pascal);
        $duDoan  = [];
        for ($i = 0; $i < count($lastRow) - 1; $i++) {
            $n = str_pad($lastRow[$i] . $lastRow[$i + 1], 2, '0', STR_PAD_LEFT);
            if (!in_array($n, $duDoan)) $duDoan[] = $n;
        }

        return view('components.shortcodes.lrd-soi-cau-pascal', compact('pascal', 'duDoan', 'region', 'spStr'))->render();
    }

    // ═══════════════════════════════════════════════
    // NHÓM: Kết quả nhiều ngày & theo thứ
    // ═══════════════════════════════════════════════

    private function renderLrdXsmbNhieuNgay(array $attrs): string
    {
        $limit = min((int) ($attrs['limit'] ?? 30), 200);

        $results = LotteryResult::where('region', 'MB')
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->limit($limit)
            ->get();

        return view('components.shortcodes.lrd-xsmb-nhieu-ngay', compact('results', 'limit'))->render();
    }

    private function renderLrdXsmnTheoThu(array $attrs): string
    {
        return $this->renderXsTheoThu('MN', $attrs);
    }

    private function renderLrdXsmtTheoThu(array $attrs): string
    {
        return $this->renderXsTheoThu('MT', $attrs);
    }

    private function renderXsTheoThu(string $region, array $attrs): string
    {
        $thuMap  = ['2' => 1, '3' => 2, '4' => 3, '5' => 4, '6' => 5, '7' => 6, 'cn' => 0];
        $thu     = $attrs['thu'] ?? '3';
        $dayOfWeek = $thuMap[$thu] ?? 2;
        $limit   = (int) ($attrs['limit'] ?? 10);

        $results = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->orderByDesc('date')
            ->get()
            ->filter(fn($r) => $r->date->dayOfWeek === $dayOfWeek)
            ->take($limit)
            ->values();

        $thuLabel = ['cn' => 'Chủ Nhật', '2' => 'Thứ 2', '3' => 'Thứ 3', '4' => 'Thứ 4',
                     '5'  => 'Thứ 5',    '6' => 'Thứ 6', '7' => 'Thứ 7'];
        $label = $thuLabel[$thu] ?? "Thứ $thu";

        return view('components.shortcodes.lrd-xs-theo-thu', compact('results', 'region', 'thu', 'label', 'limit'))->render();
    }

    // ═══════════════════════════════════════════════
    // NHÓM: Soi cầu MB aliases
    // ═══════════════════════════════════════════════

    private function renderChotSoXsMB(array $attrs): string
    {
        $data = $this->getPredictionData();
        return view('components.shortcodes.chotsoxsmb', ['soiCauMB' => $data['soiCauMB'], 'loTop' => $data['loTop']])->render();
    }

    private function renderSoiCauXsMB(array $attrs): string
    {
        $data = $this->getPredictionData();
        return view('components.shortcodes.soicauxsmb', ['soiCauMB' => $data['soiCauMB'], 'cauDep' => $data['cauDep']])->render();
    }

    private function renderDuDoanXsMB(array $attrs): string
    {
        $data = $this->getPredictionData();
        return view('components.shortcodes.du-doan-xsmb', ['predictionAI' => $data['predictionAI'], 'soiCauMB' => $data['soiCauMB']])->render();
    }

    private function renderSoCauXsMB(array $attrs): string
    {
        $data = $this->getPredictionData();
        return view('components.shortcodes.so-cau-xsmb', ['soiCauMB' => $data['soiCauMB'], 'freq' => $data['freq']])->render();
    }

    // ═══════════════════════════════════════════════
    // NHÓM: Cầu đẹp hằng ngày (MN / MT)
    // ═══════════════════════════════════════════════

    private function renderCauDepHangNgayRegion(string $region, string $regionLabel): string
    {
        $results30 = LotteryResult::where('region', $region)
            ->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays(30)->toDateString())
            ->orderByDesc('date')->get();

        $loFreq = [];
        foreach ($results30 as $r) {
            foreach ($r->numbers as $num) {
                $l2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $loFreq[$l2] = ($loFreq[$l2] ?? 0) + 1;
            }
        }
        arsort($loFreq);

        $cauLoto = [];
        foreach (array_keys(array_slice($loFreq, 0, 5, true)) as $n) {
            $mirror  = strrev($n);
            $cauLoto[] = ($n === $mirror) ? [$n] : [$n, $mirror];
        }

        // Lô kép gan nhất trong miền
        $kepAll  = ['00','11','22','33','44','55','66','77','88','99'];
        $kepLast = array_fill_keys($kepAll, null);
        foreach ($results30 as $r) {
            $nums = array_map(fn($n) => str_pad(substr($n, -2), 2, '0', STR_PAD_LEFT), $r->numbers);
            foreach ($kepAll as $k) {
                if ($kepLast[$k] === null && in_array($k, $nums)) $kepLast[$k] = $r->date->format('Y-m-d');
            }
        }
        uasort($kepLast, fn($a, $b) => match(true) {
            $a === null && $b === null => 0, $a === null => -1, $b === null => 1,
            default => strcmp($a, $b),
        });
        $cauKep = array_slice(array_keys($kepLast), 0, 3);

        // Tổng ĐB hay xuất hiện nhất
        $tongFreq = [];
        foreach ($results30 as $r) {
            $sp = $r->prizes['special'] ?? null;
            if (!$sp) continue;
            $spStr = is_array($sp) ? ($sp[0] ?? '') : $sp;
            if (strlen($spStr) >= 2) {
                $l2   = substr($spStr, -2);
                $tong = (int)$l2[0] + (int)$l2[1];
                $tongFreq[$tong] = ($tongFreq[$tong] ?? 0) + 1;
            }
        }
        arsort($tongFreq);
        $cauTong = array_keys(array_slice($tongFreq, 0, 3, true));
        if (empty($cauTong)) $cauTong = [3, 7, 8];

        return view('components.shortcodes.caudephangngay-region',
            compact('cauLoto', 'cauKep', 'cauTong', 'region', 'regionLabel'))->render();
    }

    private function renderCauDepHangNgayMN(array $attrs): string
    {
        return $this->renderCauDepHangNgayRegion('MN', 'Miền Nam');
    }

    private function renderCauDepHangNgayMT(array $attrs): string
    {
        return $this->renderCauDepHangNgayRegion('MT', 'Miền Trung');
    }

    private function renderCauDepHangNgay1MN(array $attrs): string
    {
        return $this->renderCauDepHangNgayRegion('MN', 'Miền Nam');
    }

    private function renderCauDepHangNgay1MT(array $attrs): string
    {
        return $this->renderCauDepHangNgayRegion('MT', 'Miền Trung');
    }

    private function renderCauDepHangNgayTinh(array $attrs): string
    {
        $matinh = $attrs['matinh'] ?? 'xshcm';
        // Convert xs prefix → province name
        $province = strtoupper(str_replace('xs', '', $matinh));
        $region   = 'MN'; // mặc định MN, có thể mở rộng sau

        $results30 = LotteryResult::where('region', $region)
            ->where('province', 'LIKE', "%$province%")
            ->orderByDesc('date')->limit(30)->get();

        if ($results30->isEmpty()) {
            return $this->renderCauDepHangNgayMN($attrs);
        }

        $loFreq = [];
        foreach ($results30 as $r) {
            foreach ($r->numbers as $num) {
                $l2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $loFreq[$l2] = ($loFreq[$l2] ?? 0) + 1;
            }
        }
        arsort($loFreq);
        $cauLoto = [];
        foreach (array_keys(array_slice($loFreq, 0, 5, true)) as $n) {
            $mirror = strrev($n);
            $cauLoto[] = ($n === $mirror) ? [$n] : [$n, $mirror];
        }
        $cauKep  = [];
        $cauTong = [3, 7, 8];

        $regionLabel = $results30->first()?->province ?? $province;
        return view('components.shortcodes.caudephangngay-region',
            compact('cauLoto', 'cauKep', 'cauTong', 'region', 'regionLabel'))->render();
    }

    // ═══════════════════════════════════════════════
    // NHÓM: Cao thủ / top lô / bạc nhớ
    // ═══════════════════════════════════════════════

    private function renderCaoThuMoBat(array $attrs): string
    {
        $type = $attrs['type'] ?? '1';
        $data = $this->getPredictionData();
        $pred = $data['predictionAI'] ?? [];
        $freq = $data['freq'];

        // Tạo danh sách "cao thủ" dựa trên top prediction/freq
        $caoThu = [];
        if ($type === '1') {
            // Lô + Đề style
            foreach (array_slice($freq, 0, 8, true) as $n => $c) {
                $caoThu[] = ['lo' => str_pad($n, 2, '0', STR_PAD_LEFT), 'de' => str_pad($n, 2, '0', STR_PAD_LEFT), 'freq' => $c];
            }
        } else {
            // BTL/STL/Đề chạm style
            $stats  = $this->getStatsData();
            $topDau = array_key_first($stats['ganHead']);
            $topDuoi = array_key_first($stats['ganTail']);
            foreach (array_slice($freq, 0, 8, true) as $n => $c) {
                $n = str_pad($n, 2, '0', STR_PAD_LEFT);
                $caoThu[] = ['lo' => $n, 'btl' => "$topDau$n", 'stl' => "$n$topDuoi", 'freq' => $c];
            }
        }

        return view('components.shortcodes.cao-thu-mo-bat', compact('caoThu', 'type'))->render();
    }

    private function renderLoDeBacNho(array $attrs): string
    {
        $type   = $attrs['type'] ?? '1';
        $days   = (int) ($attrs['days'] ?? 30);
        $region = 'MB';

        $results = LotteryResult::where('region', $region)->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays($days)->toDateString())
            ->orderByDesc('date')->get();

        $freq = [];
        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $l2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $freq[$l2] = ($freq[$l2] ?? 0) + 1;
            }
        }

        if ($type === '1') {
            asort($freq);
            $bacNho = array_slice($freq, 0, 20, true);
        } else {
            // type=2: Đề bạc nhớ (dựa trên giải ĐB)
            $dbFreq = [];
            foreach ($results as $r) {
                $sp = $r->prizes['special'] ?? null;
                if (!$sp) continue;
                $spStr = is_array($sp) ? ($sp[0] ?? '') : $sp;
                $l2 = substr($spStr, -2);
                if (strlen($l2) === 2 && ctype_digit($l2)) {
                    $dbFreq[$l2] = ($dbFreq[$l2] ?? 0) + 1;
                }
            }
            asort($dbFreq);
            $bacNho = array_slice($dbFreq, 0, 20, true);
        }

        return view('components.shortcodes.lo-de-bac-nho', compact('bacNho', 'type', 'days'))->render();
    }

    private function renderLrdTopLoDepNhat(array $attrs): string
    {
        $attrs['limit'] = $attrs['limit'] ?? 10;
        return $this->renderLoTop($attrs);
    }

    // ═══════════════════════════════════════════════
    // NHÓM: Dàn đề / Công cụ
    // ═══════════════════════════════════════════════

    private function renderDanDeHangNgay(array $attrs): string
    {
        $dande = $attrs['dande'] ?? 'dd90';
        $hard  = ($attrs['hard'] ?? 'false') === 'true';

        preg_match('/dd(\d+)/', $dande, $m);
        $count = min((int) ($m[1] ?? 90), 99);

        // Pool từ tần suất lịch sử
        $results = LotteryResult::where('region', 'MB')->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', now()->subDays(30)->toDateString())->get();
        $freq = [];
        for ($i = 0; $i <= 99; $i++) $freq[str_pad((string)$i, 2, '0', STR_PAD_LEFT)] = 1;
        foreach ($results as $r) {
            foreach ($r->numbers as $num) {
                $l2 = str_pad(substr($num, -2), 2, '0', STR_PAD_LEFT);
                $freq[$l2] = ($freq[$l2] ?? 0) + 2;
            }
        }
        arsort($freq);
        $pool = array_keys($freq);

        $seed = crc32(date('Ymd') . 'dandehangngay' . $dande);
        mt_srand($seed);

        if ($hard) {
            // Cố định: lấy top-N theo tần suất
            $numbers = array_slice($pool, 0, $count);
        } else {
            // Random từ top 50
            $subPool = array_slice($pool, 0, 50);
            $numbers = [];
            $seen    = [];
            while (count($numbers) < $count) {
                $n = $subPool[mt_rand(0, count($subPool) - 1)];
                if (!in_array($n, $seen)) { $seen[] = $n; $numbers[] = $n; }
            }
        }
        sort($numbers);

        return view('components.shortcodes.dandehangngay', compact('numbers', 'count', 'dande'))->render();
    }

    private function renderTaoDande(array $attrs): string
    {
        return view('components.shortcodes.taodande')->render();
    }

    private function renderGhepLoXienTuDong(array $attrs): string
    {
        return view('components.shortcodes.ghep-lo-xien')->render();
    }

    // ═══════════════════════════════════════════════
    // NHÓM: VIP Đọc thủ
    // ═══════════════════════════════════════════════

    private function renderDocThuLoVip(array $attrs): string
    {
        $data   = $this->getPredictionData();
        $freq   = $data['freq'];
        arsort($freq);
        $topLo  = array_keys(array_slice($freq, 0, 3, true));
        $docThu = $topLo[0] ?? '27';

        return view('components.shortcodes.doc-thu-lo-vip', compact('docThu', 'topLo'))->render();
    }

    private function renderDocThuDeVip(array $attrs): string
    {
        $data  = $this->getStatsData();
        $docDe = $data['frequencyDB'][0]['number'] ?? '27';

        return view('components.shortcodes.doc-thu-de-vip', compact('docDe'))->render();
    }

    private function renderDocThuLoKepVip(array $attrs): string
    {
        $data   = $this->getPredictionData();
        $loKep  = $data['soiCauMB']['lo_kep'] ?? ['11', '77'];
        $docKep = $loKep[0] ?? '11';

        return view('components.shortcodes.doc-thu-lo-kep-vip', compact('docKep', 'loKep'))->render();
    }

    private function renderDocThuDeKepVip(array $attrs): string
    {
        $data   = $this->getStatsData();
        $dbFreq = $data['frequencyDB'];
        $docDeKep = null;
        foreach ($dbFreq as $item) {
            $n = $item['number'];
            if ($n[0] === $n[1]) { $docDeKep = $n; break; }
        }
        if (!$docDeKep) $docDeKep = '77';

        return view('components.shortcodes.doc-thu-de-kep-vip', compact('docDeKep'))->render();
    }

    // ═══════════════════════════════════════════════
    // NHÓM: Lô kép nuôi khung
    // ═══════════════════════════════════════════════

    private function renderLoKepKhungN(int $days): string
    {
        $data    = $this->getPredictionData();
        $loKep   = $data['soiCauMB']['lo_kep'] ?? ['11', '77'];
        $now     = now()->timezone('Asia/Ho_Chi_Minh');
        $today   = $now->toDateString();

        $results = LotteryResult::where('region', 'MB')->where('province', '!=', 'ĐUÔI')
            ->where('date', '>=', $now->copy()->subDays($days - 1)->toDateString())
            ->orderBy('date')->get()->keyBy(fn($r) => $r->date->format('Y-m-d'));

        $khungData = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i)->toDateString();
            $r    = $results->get($date);
            $isToday = ($date === $today);

            if (!$r || ($isToday && !$r)) {
                $status = 'cho';
                $nums   = [];
            } else {
                $nums   = array_map(fn($n) => str_pad(substr($n, -2), 2, '0', STR_PAD_LEFT), $r->numbers);
                $hit    = !empty(array_intersect($loKep, $nums));
                $status = $hit ? 've' : 'khong_ve';
            }

            $khungData[] = [
                'date'   => \Carbon\Carbon::parse($date)->format('d/m/Y'),
                'soNuoi' => $loKep,
                'nums'   => $nums,
                'status' => $status,
                'isToday' => $isToday,
            ];
        }

        return view('components.shortcodes.lo-kep-khung', compact('khungData', 'days', 'loKep'))->render();
    }

    private function renderLoKepKhung2Ngay(array $attrs): string { return $this->renderLoKepKhungN(2); }
    private function renderLoKepKhung3Ngay(array $attrs): string { return $this->renderLoKepKhungN(3); }
    private function renderLoKepKhung5Ngay(array $attrs): string { return $this->renderLoKepKhungN(5); }

    // ═══════════════════════════════════════════════
    // NHÓM: Vietlott & Keno (fetch ngoài + dự đoán)
    // ═══════════════════════════════════════════════

    private function fetchVietlott(string $type, int $limit = 10): array
    {
        try {
            $url = "https://api.minhchinh.com/vietlott/$type?limit=$limit";
            $res = \Illuminate\Support\Facades\Http::timeout(5)->get($url);
            if ($res->ok()) return $res->json('data') ?? [];
        } catch (\Exception $e) {}
        return [];
    }

    private function renderLrdKeno(array $attrs): string
    {
        $limit   = (int) ($attrs['limit'] ?? 10);
        $results = $this->fetchVietlott('keno', $limit);
        return view('components.shortcodes.lrd-keno', compact('results', 'limit'))->render();
    }

    private function renderLrdXsMega645(array $attrs): string
    {
        $limit   = (int) ($attrs['limit'] ?? 10);
        $results = $this->fetchVietlott('mega645', $limit);
        return view('components.shortcodes.lrd-vietlott', compact('results', 'limit'))
            ->with('title', 'Vietlott Mega 6/45')->with('type', 'mega645')->render();
    }

    private function renderLrdPower655(array $attrs): string
    {
        $limit   = (int) ($attrs['limit'] ?? 10);
        $results = $this->fetchVietlott('power655', $limit);
        return view('components.shortcodes.lrd-vietlott', compact('results', 'limit'))
            ->with('title', 'Vietlott Power 6/55')->with('type', 'power655')->render();
    }

    private function renderLrdMax3d(array $attrs): string
    {
        $limit   = (int) ($attrs['limit'] ?? 10);
        $results = $this->fetchVietlott('max3d', $limit);
        return view('components.shortcodes.lrd-vietlott', compact('results', 'limit'))
            ->with('title', 'Vietlott Max 3D')->with('type', 'max3d')->render();
    }

    private function renderLrdMax3dPro(array $attrs): string
    {
        $limit   = (int) ($attrs['limit'] ?? 10);
        $results = $this->fetchVietlott('max3dpro', $limit);
        return view('components.shortcodes.lrd-vietlott', compact('results', 'limit'))
            ->with('title', 'Vietlott Max 3D Pro')->with('type', 'max3dpro')->render();
    }

    private function renderLrdLotto535(array $attrs): string
    {
        $limit   = (int) ($attrs['limit'] ?? 10);
        $results = $this->fetchVietlott('lotto535', $limit);
        return view('components.shortcodes.lrd-vietlott', compact('results', 'limit'))
            ->with('title', 'Xổ Số Lotto 5/35')->with('type', 'lotto535')->render();
    }

    private function renderLrdBingo18(array $attrs): string
    {
        $limit   = (int) ($attrs['limit'] ?? 10);
        $results = $this->fetchVietlott('bingo18', $limit);
        return view('components.shortcodes.lrd-vietlott', compact('results', 'limit'))
            ->with('title', 'Xổ Số Bingo18')->with('type', 'bingo18')->render();
    }

    private function renderDuDoanVietlottPower(array $attrs): string
    {
        $sets = (int) ($attrs['sets'] ?? 6);
        $seed = crc32(date('Ymd') . 'power655');
        mt_srand($seed);

        $predictions = [];
        for ($i = 0; $i < $sets; $i++) {
            $nums = []; $seen = [];
            while (count($nums) < 6) {
                $n = mt_rand(1, 55);
                if (!in_array($n, $seen)) { $seen[] = $n; $nums[] = $n; }
            }
            sort($nums);
            $extra = mt_rand(1, 55);
            while (in_array($extra, $nums)) $extra = mt_rand(1, 55);
            $predictions[] = ['main' => $nums, 'extra' => $extra];
        }

        return view('components.shortcodes.dudoan-vietlott', compact('predictions'))
            ->with('title', 'Dự Đoán Power 6/55')->with('type', 'power')->render();
    }

    private function renderDuDoanVietlottMega(array $attrs): string
    {
        $sets = (int) ($attrs['sets'] ?? 6);
        $seed = crc32(date('Ymd') . 'mega645');
        mt_srand($seed);

        $predictions = [];
        for ($i = 0; $i < $sets; $i++) {
            $nums = []; $seen = [];
            while (count($nums) < 6) {
                $n = mt_rand(1, 45);
                if (!in_array($n, $seen)) { $seen[] = $n; $nums[] = $n; }
            }
            sort($nums);
            $predictions[] = ['main' => $nums, 'extra' => null];
        }

        return view('components.shortcodes.dudoan-vietlott', compact('predictions'))
            ->with('title', 'Dự Đoán Mega 6/45')->with('type', 'mega')->render();
    }

    // ═══════════════════════════════════════════════
    // NHÓM: Quay thử & Số mơ
    // ═══════════════════════════════════════════════

    private function renderLrdPageQuayThu(array $attrs): string
    {
        $domainMap = ['1' => 'MB', '2' => 'MT', '3' => 'MN'];
        $region    = $domainMap[$attrs['domain'] ?? '2'] ?? 'MT';
        $province  = $attrs['province'] ?? null;
        $hard      = ($attrs['hard'] ?? 'false') === 'true';

        return view('components.shortcodes.lrd-quay-thu', compact('region', 'province', 'hard'))->render();
    }

    private function renderQuayThu(array $attrs): string
    {
        $domainMap = ['1' => 'MB', '2' => 'MT', '3' => 'MN'];
        $region    = $domainMap[$attrs['domain'] ?? '1'] ?? 'MB';
        return view('components.shortcodes.quay-thu', compact('region'))->render();
    }

    private function renderLrdSoMo(array $attrs): string
    {
        return view('components.shortcodes.lrd-so-mo')->render();
    }

    private function renderLrdSoSanhTanSuat(array $attrs): string
    {
        $days   = (int) ($attrs['days'] ?? 30);
        $region = $attrs['region'] ?? 'MB';
        $stats  = $this->getStatsData($days);

        return view('components.shortcodes.lrd-sosanh-tansuat', [
            'frequency' => $stats['frequency'],
            'waiting'   => $stats['waiting'],
            'days'      => $days,
            'region'    => $region,
        ])->render();
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
