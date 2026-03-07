<?php

namespace Database\Seeders;

use App\Models\Shortcode;
use Illuminate\Database\Seeder;

class BuiltinShortcodeSeeder extends Seeder
{
    public function run(): void
    {
        $builtins = [
            // ── Nhóm 1: KQXS & Tiện ích ──────────────────────────────────
            ['group' => 'kqxs',      'code' => 'welcome_banner',      'name' => 'Banner Chào Mừng',           'description' => 'Banner tiêu đề trang chủ + ngày hôm nay'],
            ['group' => 'kqxs',      'code' => 'kqxs',                'name' => 'KQXS Compact',               'description' => 'Bảng KQXS compact cho bài viết. Params: region (MB/MN/MT)'],
            ['group' => 'kqxs',      'code' => 'kqxs_full',           'name' => 'KQXS Đầy Đủ',               'description' => 'Bảng KQXS đầy đủ tất cả giải. Params: region (MB/MN/MT)'],
            ['group' => 'kqxs',      'code' => 'kqxs_mt_mn',          'name' => 'KQXS MT + MN',              'description' => '2 bảng KQXS Miền Trung + Miền Nam song song'],
            ['group' => 'kqxs',      'code' => 'ket_qua_xo_so',       'name' => 'Kết Quả Xổ Số',             'description' => 'Alias kqxs. Params: domain (1=MB/2=MT/3=MN), province, ngay'],
            ['group' => 'kqxs',      'code' => 'lrd_results',         'name' => 'KQXS MB Nhiều Kỳ',          'description' => 'Danh sách KQXS MB mới nhất. Params: limit'],
            ['group' => 'kqxs',      'code' => 'lrd_region_results',  'name' => 'KQXS Theo Miền',            'description' => 'KQXS theo miền. Params: region (bac/nam/trung), limit'],
            ['group' => 'kqxs',      'code' => 'lrd_xsmb_nhieu_ngay', 'name' => 'XSMB Nhiều Ngày',           'description' => 'Bảng KQXS MB dạng ngang nhiều ngày. Params: limit (max 200)'],
            ['group' => 'kqxs',      'code' => 'lrd_xsmn_theo_thu',   'name' => 'XSMN Theo Thứ',             'description' => 'KQXS MN lọc theo thứ. Params: thu (2-7/cn), limit'],
            ['group' => 'kqxs',      'code' => 'lrd_xsmt_theo_thu',   'name' => 'XSMT Theo Thứ',             'description' => 'KQXS MT lọc theo thứ. Params: thu (2-7/cn), limit'],
            ['group' => 'kqxs',      'code' => 'blog_moi',            'name' => 'Bài Viết Mới',              'description' => 'Grid bài viết blog mới nhất. Params: limit'],

            // ── Nhóm 2: Soi Cầu & Dự Đoán ───────────────────────────────
            ['group' => 'soicau',    'code' => 'soi_cau',             'name' => 'Soi Cầu AI Compact',        'description' => 'Bảng dự đoán AI top 10 cho bài viết'],
            ['group' => 'soicau',    'code' => 'soi_cau_mb',          'name' => 'Soi Cầu Miền Bắc',         'description' => 'Bảng soi cầu MB: bạch thủ, song thủ, xiên 2, lô kép, ĐB chạm, 3 càng'],
            ['group' => 'soicau',    'code' => 'cau_dep',             'name' => 'Cầu Đẹp XSMB',             'description' => 'Cầu lô tô, 2 nháy, đặc biệt đẹp'],
            ['group' => 'soicau',    'code' => 'du_doan_cards',       'name' => 'Cards Dự Đoán',             'description' => '3 cards: Lô VIP, Đề VIP, Nuôi Lô Khung'],
            ['group' => 'soicau',    'code' => 'du_doan_3_mien',      'name' => 'Dự Đoán 3 Miền',           'description' => 'Dự đoán bạch thủ, song thủ, đề, dàn lô cho MB/MT/MN'],
            ['group' => 'soicau',    'code' => 'chotsoxsmb',          'name' => 'Chốt Số XSMB',              'description' => 'Chốt số XSMB hôm nay: bạch thủ + song thủ + lô nóng'],
            ['group' => 'soicau',    'code' => 'soicauxsmb',          'name' => 'Soi Cầu XSMB',              'description' => 'Soi cầu XSMB: bạch thủ, xiên 2, cầu loto đẹp'],
            ['group' => 'soicau',    'code' => 'du_doan_xsmb',        'name' => 'Dự Đoán XSMB',              'description' => 'Dự đoán XSMB: AI prediction + bạch thủ + song thủ'],
            ['group' => 'soicau',    'code' => 'so_cau_xsmb',         'name' => 'Số Cầu XSMB',               'description' => 'Số cầu XSMB hôm nay: cầu chính + cầu bổ sung'],
            ['group' => 'soicau',    'code' => 'lrd_soi_cau_pascal',  'name' => 'Soi Cầu Pascal',            'description' => 'Soi cầu tam giác Pascal từ giải ĐB hôm qua. Params: region'],

            // ── Nhóm 3: Cầu Đẹp Hằng Ngày ───────────────────────────────
            ['group' => 'caudep',    'code' => 'caudephangngay_mb',   'name' => 'Cầu Đẹp MB Hằng Ngày',     'description' => 'Cầu lô đẹp, kép, tổng ĐB hằng ngày XSMB'],
            ['group' => 'caudep',    'code' => 'caudephangngay_mn',   'name' => 'Cầu Đẹp MN Hằng Ngày',     'description' => 'Cầu lô đẹp, kép, tổng ĐB hằng ngày XSMN'],
            ['group' => 'caudep',    'code' => 'caudephangngay_mt',   'name' => 'Cầu Đẹp MT Hằng Ngày',     'description' => 'Cầu lô đẹp, kép, tổng ĐB hằng ngày XSMT'],
            ['group' => 'caudep',    'code' => 'caudephangngay1_mn',  'name' => 'Cầu Đẹp MN v2',            'description' => 'Cầu đẹp MN biến thể 2'],
            ['group' => 'caudep',    'code' => 'caudephangngay1_mt',  'name' => 'Cầu Đẹp MT v2',            'description' => 'Cầu đẹp MT biến thể 2'],
            ['group' => 'caudep',    'code' => 'caudephangngay',      'name' => 'Cầu Đẹp Theo Tỉnh',        'description' => 'Cầu đẹp theo tỉnh. Params: dai (tỉnh), mien (1/2/3)'],

            // ── Nhóm 4: Bạch Thủ / Song Thủ ─────────────────────────────
            ['group' => 'bathu',     'code' => 'bach_thu_lo_vip',              'name' => 'Bạch Thủ Lô VIP',              'description' => 'Bạch Thủ Lô Hôm Nay - 1 số dự đoán cao nhất + số đảo'],
            ['group' => 'bathu',     'code' => 'bach_thu_lo_kep',              'name' => 'Bạch Thủ Lô Kép',             'description' => 'Bạch Thủ Lô Kép Hôm Nay - số kép dự đoán cao nhất'],
            ['group' => 'bathu',     'code' => 'bach_thu_lo_kep_vip',          'name' => 'Bạch Thủ Lô Kép VIP',         'description' => 'Alias của bach_thu_lo_kep'],
            ['group' => 'bathu',     'code' => 'bach_thu_lo_nuoi_khung_3_ngay','name' => 'Bạch Thủ Nuôi Khung 3 Ngày', 'description' => 'Bảng theo dõi bạch thủ lô 3 ngày'],
            ['group' => 'bathu',     'code' => 'bach_thu_lo_nuoi_khung_5_ngay','name' => 'Bạch Thủ Nuôi Khung 5 Ngày', 'description' => 'Bảng theo dõi bạch thủ lô 5 ngày'],
            ['group' => 'bathu',     'code' => 'song_thu_lo_vip',              'name' => 'Song Thủ Lô VIP',              'description' => 'Song Thủ Lô Hôm Nay - 2 số dự đoán + số đảo'],
            ['group' => 'bathu',     'code' => 'song_thu_lo_kep',              'name' => 'Song Thủ Lô Kép',              'description' => 'Song Thủ Lô Kép Hôm Nay - 2 số kép dự đoán cao nhất'],
            ['group' => 'bathu',     'code' => 'song_thu_lo_kep_vip',          'name' => 'Song Thủ Lô Kép VIP',         'description' => 'Alias của song_thu_lo_kep'],
            ['group' => 'bathu',     'code' => 'song_thu_lo_khung_2_ngay',     'name' => 'Song Thủ Nuôi Khung 2 Ngày',  'description' => 'Bảng theo dõi song thủ lô 2 ngày'],
            ['group' => 'bathu',     'code' => 'song_thu_lo_khung_3_ngay',     'name' => 'Song Thủ Nuôi Khung 3 Ngày',  'description' => 'Bảng theo dõi song thủ lô 3 ngày'],
            ['group' => 'bathu',     'code' => 'song_thu_lo_khung_5_ngay',     'name' => 'Song Thủ Nuôi Khung 5 Ngày',  'description' => 'Bảng theo dõi song thủ lô 5 ngày'],
            ['group' => 'bathu',     'code' => 'doc_thu_lo_vip',               'name' => 'Đọc Thủ Lô VIP',              'description' => 'Đọc thủ lô VIP hôm nay + lô nóng bổ sung'],
            ['group' => 'bathu',     'code' => 'doc_thu_de_vip',               'name' => 'Đọc Thủ Đề VIP',              'description' => 'Đọc thủ đề VIP hôm nay'],
            ['group' => 'bathu',     'code' => 'doc_thu_lo_kep_vip',           'name' => 'Đọc Thủ Lô Kép VIP',         'description' => 'Đọc thủ lô kép VIP + thống kê tất cả lô kép'],
            ['group' => 'bathu',     'code' => 'doc_thu_de_kep_vip',           'name' => 'Đọc Thủ Đề Kép VIP',         'description' => 'Dự đoán số kép xuất hiện trong giải đặc biệt'],

            // ── Nhóm 5: Lô Kép Nuôi Khung ────────────────────────────────
            ['group' => 'lokhung',   'code' => 'lo_kep_khung_2_ngay', 'name' => 'Lô Kép Khung 2 Ngày',      'description' => 'Nuôi lô kép khung 2 ngày + lịch sử về/không về'],
            ['group' => 'lokhung',   'code' => 'lo_kep_khung_3_ngay', 'name' => 'Lô Kép Khung 3 Ngày',      'description' => 'Nuôi lô kép khung 3 ngày + lịch sử về/không về'],
            ['group' => 'lokhung',   'code' => 'lo_kep_khung_5_ngay', 'name' => 'Lô Kép Khung 5 Ngày',      'description' => 'Nuôi lô kép khung 5 ngày + lịch sử về/không về'],

            // ── Nhóm 6: Thống Kê ─────────────────────────────────────────
            ['group' => 'thongke',   'code' => 'thong_ke',                     'name' => 'Thống Kê Tần Suất',          'description' => 'Thống kê tần suất compact. Params: days, region'],
            ['group' => 'thongke',   'code' => 'thong_ke_nhanh',               'name' => 'Thống Kê Nhanh',             'description' => '6 bảng: loto freq, ĐB freq, loto gan, đầu/đuôi/tổng ĐB'],
            ['group' => 'thongke',   'code' => 'thong_ke_lo',                  'name' => 'Thống Kê Lô Đề',            'description' => 'Lô hay về + lô gan. Params: days'],
            ['group' => 'thongke',   'code' => 'thong_ke_general',             'name' => 'Thống Kê Tổng Hợp',         'description' => 'Đầu số, đuôi số, top 20 lô. Params: domain (1/2/3)'],
            ['group' => 'thongke',   'code' => 'lrd_thong_ke_dau_duoi_loto',   'name' => 'TK Đầu Đuôi Loto',         'description' => 'Thống kê đầu và đuôi số loto. Params: region, days'],
            ['group' => 'thongke',   'code' => 'lrd_thong_ke_lo_kep',          'name' => 'TK Lô Kép',                 'description' => 'Tần suất 10 lô kép (00,11,...99). Params: region, days'],
            ['group' => 'thongke',   'code' => 'lrd_thong_ke_lo_roi',          'name' => 'TK Lô Rơi / Ít Về',        'description' => 'Lô ít về nhất trong N ngày. Params: region, days'],
            ['group' => 'thongke',   'code' => 'lrd_thong_ke_tan_suat_loto',   'name' => 'TK Tần Suất Đầy Đủ',       'description' => 'Tần suất tất cả 100 số (00-99). Params: region, days'],
            ['group' => 'thongke',   'code' => 'lrd_thong_ke_theo_tong',       'name' => 'TK Theo Tổng Số',           'description' => 'Tổng 2 chữ số cuối của lô (0-18). Params: region, days'],
            ['group' => 'thongke',   'code' => 'lrd_thong_ke_chu_ky_dac_biet', 'name' => 'TK Chu Kỳ Giải ĐB',        'description' => 'Chu kỳ trung bình mỗi số xuất hiện ở giải ĐB. Params: region'],
            ['group' => 'thongke',   'code' => 'lrd_thong_ke_giai_dac_biet_gan','name' => 'TK Đuôi ĐB Gan Nhất',    'description' => 'Đuôi giải ĐB lâu chưa về. Params: region, days'],
            ['group' => 'thongke',   'code' => 'lrd_thong_ke_quan_trong',      'name' => 'TK Quan Trọng',             'description' => 'Tổng hợp: lô hay, lô gan, lô kép, đầu/đuôi ĐB gan. Params: region'],
            ['group' => 'thongke',   'code' => 'lrd_thong_ke_tan_suat_cap_loto','name' => 'TK Cặp Loto Hay Ra',      'description' => 'Top cặp số cùng xuất hiện nhiều nhất. Params: region, days'],
            ['group' => 'thongke',   'code' => 'lrd_thong_ke_tong_hop',        'name' => 'TK Tổng Hợp Đầy Đủ',      'description' => 'Tổng hợp tất cả thống kê. Params: region, days'],
            ['group' => 'thongke',   'code' => 'lrd_sosanh_tansuat',           'name' => 'So Sánh Tần Suất',          'description' => 'So sánh tần suất lô hay/gan/kép/tổng ĐB. Params: region, days'],

            // ── Nhóm 7: Lô Gan ───────────────────────────────────────────
            ['group' => 'logan',     'code' => 'lo_gan',          'name' => 'Lô Gan Compact',              'description' => 'Bảng lô gan compact. Params: limit, region'],
            ['group' => 'logan',     'code' => 'lrd_logan',       'name' => 'Lô Gan Mở Rộng',             'description' => 'Lô gan theo miền/đài. Params: mien (1/2/3), type (normal/dropdown), dai'],
            ['group' => 'logan',     'code' => 'lrd_logan_full',  'name' => 'Lô Gan Đầy Đủ 00-99',       'description' => 'Bảng lô gan 100 số. Params: region (mb/mn/mt)'],

            // ── Nhóm 8: Bảng Giải Đặc Biệt ──────────────────────────────
            ['group' => 'bangdb',    'code' => 'lrd_bang_dac_biet_nam',   'name' => 'Bảng ĐB Theo Năm',   'description' => 'Giải đặc biệt theo năm. Params: year, region'],
            ['group' => 'bangdb',    'code' => 'lrd_bang_dac_biet_thang', 'name' => 'Bảng ĐB Theo Tháng', 'description' => 'Giải đặc biệt theo tháng. Params: month (YYYY-MM), region'],
            ['group' => 'bangdb',    'code' => 'lrd_bang_dac_biet_tuan',  'name' => 'Bảng ĐB Theo Tuần',  'description' => 'Giải đặc biệt theo tuần. Params: week (YYYY-WW), region'],

            // ── Nhóm 9: Lô Top & Cao Thủ ─────────────────────────────────
            ['group' => 'lotop',     'code' => 'lo_top',              'name' => 'Lô Top',                  'description' => 'Top lô chơi nhiều. Params: limit'],
            ['group' => 'lotop',     'code' => 'lrd_top_lo_dep_nhat', 'name' => 'Top Lô Đẹp Nhất',        'description' => 'Top lô đẹp nhất theo tần suất. Params: region, limit'],
            ['group' => 'lotop',     'code' => 'cao_thu_mo_bat',      'name' => 'Cao Thủ Mở Bát',         'description' => 'Dự đoán cao thủ mở bát lô/đề. Params: type (lo/de)'],
            ['group' => 'lotop',     'code' => 'lo_de_bac_nho',       'name' => 'Lô/Đề Bặc Nhớ',         'description' => 'Số ít về nhất (cơ hội quay lại). Params: type (lo/de), days'],

            // ── Nhóm 10: Dàn Đề & Dàn Lô ────────────────────────────────
            ['group' => 'dande',     'code' => 'lrd_du_doan_3_cang',     'name' => 'Dự Đoán 3 Càng',      'description' => 'Bảng dự đoán 3 càng hôm nay'],
            ['group' => 'dande',     'code' => 'lrd_dan_lo_6_so',         'name' => 'Dàn Lô 6 Số',         'description' => 'Dàn lô 6 số hôm nay + lịch sử 7 ngày'],
            ['group' => 'dande',     'code' => 'lrd_dan_3_cang_lo',       'name' => 'Dàn 3 Càng Lô',       'description' => 'Dàn 3 càng lô hôm nay - 15 số'],
            ['group' => 'dande',     'code' => 'lrd_dan_de_3_cang',       'name' => 'Dàn Đề 3 Càng',       'description' => 'Dàn đề 3 càng hôm nay - 50 số'],
            ['group' => 'dande',     'code' => 'dandehangngay',            'name' => 'Dàn Đề Hằng Ngày',   'description' => 'Dàn đề hằng ngày theo nhóm. Params: count'],
            ['group' => 'dande',     'code' => 'taodande',                 'name' => 'Công Cụ Tạo Dàn Đề', 'description' => 'Tương tác: tạo dàn theo đầu/đuôi/tổng/khoảng'],
            ['group' => 'dande',     'code' => 'lrd_ghep_lo_xien_tu_dong','name' => 'Ghép Lô Xiên',        'description' => 'Ghép lô xiên 2/3/4 từ danh sách số nhập vào'],

            // ── Nhóm 11: Vietlott & Keno ─────────────────────────────────
            ['group' => 'vietlott',  'code' => 'lrd_keno',           'name' => 'Kết Quả Keno',            'description' => 'Kết quả Keno mới nhất. Params: limit'],
            ['group' => 'vietlott',  'code' => 'lrd_xsmega645',      'name' => 'Vietlott Mega 6/45',      'description' => 'Kết quả Vietlott Mega 6/45. Params: limit'],
            ['group' => 'vietlott',  'code' => 'lrd_power655',       'name' => 'Vietlott Power 6/55',     'description' => 'Kết quả Vietlott Power 6/55. Params: limit'],
            ['group' => 'vietlott',  'code' => 'lrd_max3d',          'name' => 'Vietlott Max3D',          'description' => 'Kết quả Vietlott Max3D. Params: limit'],
            ['group' => 'vietlott',  'code' => 'lrd_max3dpro',       'name' => 'Vietlott Max3D Pro',      'description' => 'Kết quả Vietlott Max3D Pro. Params: limit'],
            ['group' => 'vietlott',  'code' => 'lrd_lotto_535',      'name' => 'Vietlott Lotto 5/35',     'description' => 'Kết quả Vietlott Lotto 5/35. Params: limit'],
            ['group' => 'vietlott',  'code' => 'lrd_bingo18',        'name' => 'Vietlott Bingo18',        'description' => 'Kết quả Vietlott Bingo18. Params: limit'],
            ['group' => 'vietlott',  'code' => 'dudoanvietlott_power','name' => 'Dự Đoán Vietlott Power', 'description' => 'Dự đoán bộ số Power 6/55 theo thống kê'],
            ['group' => 'vietlott',  'code' => 'dudoanvietlott_mega', 'name' => 'Dự Đoán Vietlott Mega',  'description' => 'Dự đoán bộ số Mega 6/45 theo thống kê'],

            // ── Nhóm 12: Quay Thử & Số Mơ ───────────────────────────────
            ['group' => 'congcu',    'code' => 'lrd_page_quay_thu',  'name' => 'Quay Thử Nâng Cao',       'description' => 'Mô phỏng quay thử có chọn tỉnh. Params: region, province, hard'],
            ['group' => 'congcu',    'code' => 'quay_thu',           'name' => 'Quay Thử Đơn Giản',       'description' => 'Quay thử XS ngẫu nhiên. Params: region'],
            ['group' => 'congcu',    'code' => 'lrd_so_mo',          'name' => 'Tra Cứu Số Mơ',           'description' => 'Công cụ tra số lô đề từ giấc mơ (client-side)'],
        ];

        foreach ($builtins as $item) {
            Shortcode::updateOrCreate(
                ['code' => $item['code']],
                [
                    'name'        => $item['name'],
                    'description' => $item['description'],
                    'content'     => '<!-- builtin: ' . $item['code'] . ' -->',
                    'is_active'   => true,
                    'is_builtin'  => true,
                    'group'       => $item['group'],
                ]
            );
        }

        $this->command->info('Seeded ' . count($builtins) . ' built-in shortcodes.');
    }
}
