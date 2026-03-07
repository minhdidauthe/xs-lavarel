<?php

namespace Database\Seeders;

use App\Models\Shortcode;
use Illuminate\Database\Seeder;

class BuiltinShortcodeSeeder extends Seeder
{
    public function run(): void
    {
        $builtins = [
            // ═══════════════════════════════════════════════
            // NHÓM 1: KQXS & Tiện ích cơ bản
            // ═══════════════════════════════════════════════
            ['code' => 'welcome_banner',    'name' => 'Banner Chào Mừng',              'description' => 'Banner tiêu đề trang chủ + ngày hôm nay'],
            ['code' => 'kqxs',              'name' => 'KQXS (Compact)',                'description' => 'Bảng KQXS compact cho bài viết. Params: region (MB/MN/MT)'],
            ['code' => 'kqxs_full',         'name' => 'KQXS Đầy Đủ',                  'description' => 'Bảng KQXS đầy đủ tất cả giải. Params: region (MB/MN/MT)'],
            ['code' => 'kqxs_mt_mn',        'name' => 'KQXS MT + MN',                 'description' => '2 bảng KQXS Miền Trung + Miền Nam song song'],
            ['code' => 'ket_qua_xo_so',     'name' => 'Kết Quả Xổ Số (Alias)',        'description' => 'Alias của kqxs. Params: domain (1=MB, 2=MT, 3=MN), province, ngay'],
            ['code' => 'lrd_results',        'name' => 'KQXS MB Nhiều Kỳ',             'description' => 'Danh sách KQXS MB mới nhất. Params: limit'],
            ['code' => 'lrd_region_results', 'name' => 'KQXS Theo Miền',              'description' => 'Danh sách KQXS theo miền. Params: region (bac/nam/trung), limit'],
            ['code' => 'blog_moi',           'name' => 'Bài Viết Mới',                 'description' => 'Grid bài viết blog mới nhất. Params: limit'],

            // ═══════════════════════════════════════════════
            // NHÓM 2: Soi cầu & Dự đoán MB
            // ═══════════════════════════════════════════════
            ['code' => 'soi_cau',           'name' => 'Soi Cầu AI (Compact)',          'description' => 'Bảng dự đoán AI top 10 cho bài viết'],
            ['code' => 'soi_cau_mb',        'name' => 'Soi Cầu Miền Bắc',             'description' => 'Bảng soi cầu MB: bạch thủ, song thủ, xiên 2, lô kép, ĐB chạm, 3 càng'],
            ['code' => 'cau_dep',           'name' => 'Cầu Đẹp XSMB',                 'description' => 'Cầu lô tô, 2 nháy, đặc biệt đẹp'],
            ['code' => 'du_doan_cards',     'name' => 'Cards Dự Đoán',                 'description' => '3 cards: Lô VIP, Đề VIP, Nuôi Lô Khung'],
            ['code' => 'du_doan_3_mien',    'name' => 'Dự Đoán 3 Miền',               'description' => 'Bảng dự đoán bạch thủ, song thủ, đề, dàn lô cho MB/MT/MN'],
            ['code' => 'chotsoxsmb',        'name' => 'Chốt Số XSMB',                  'description' => 'Chốt số XSMB hôm nay: bạch thủ + song thủ + lô nóng'],
            ['code' => 'soicauxsmb',        'name' => 'Soi Cầu XSMB',                  'description' => 'Soi cầu XSMB: bạch thủ, xiên 2, cầu loto đẹp'],
            ['code' => 'du_doan_xsmb',      'name' => 'Dự Đoán XSMB',                  'description' => 'Dự đoán XSMB: AI prediction + bạch thủ + song thủ'],
            ['code' => 'so_cau_xsmb',       'name' => 'Số Cầu XSMB',                   'description' => 'Số cầu XSMB hôm nay: cầu chính + cầu bổ sung từ tần suất'],
            ['code' => 'lrd_soi_cau_pascal', 'name' => 'Soi Cầu Pascal',               'description' => 'Soi cầu tam giác Pascal từ giải ĐB hôm qua. Params: region'],

            // ═══════════════════════════════════════════════
            // NHÓM 3: Bạch Thủ / Song Thủ
            // ═══════════════════════════════════════════════
            ['code' => 'bach_thu_lo_vip',           'name' => 'Bạch Thủ Lô VIP',              'description' => 'Bạch Thủ Lô Hôm Nay - hiển thị 1 số dự đoán cao nhất + số đảo'],
            ['code' => 'bach_thu_lo_kep',            'name' => 'Bạch Thủ Lô Kép',             'description' => 'Bạch Thủ Lô Kép Hôm Nay - số kép (00 11 22...99) dự đoán cao nhất'],
            ['code' => 'bach_thu_lo_kep_vip',        'name' => 'Bạch Thủ Lô Kép VIP (Alias)', 'description' => 'Alias của bach_thu_lo_kep'],
            ['code' => 'bach_thu_lo_nuoi_khung_3_ngay', 'name' => 'Bạch Thủ Nuôi Khung 3 Ngày', 'description' => 'Bảng theo dõi bạch thủ lô 3 ngày'],
            ['code' => 'bach_thu_lo_nuoi_khung_5_ngay', 'name' => 'Bạch Thủ Nuôi Khung 5 Ngày', 'description' => 'Bảng theo dõi bạch thủ lô 5 ngày'],
            ['code' => 'song_thu_lo_vip',            'name' => 'Song Thủ Lô VIP',              'description' => 'Song Thủ Lô Hôm Nay - 2 số dự đoán + số đảo'],
            ['code' => 'song_thu_lo_kep',            'name' => 'Song Thủ Lô Kép',              'description' => 'Song Thủ Lô Kép Hôm Nay - 2 số kép dự đoán cao nhất'],
            ['code' => 'song_thu_lo_kep_vip',        'name' => 'Song Thủ Lô Kép VIP (Alias)', 'description' => 'Alias của song_thu_lo_kep'],
            ['code' => 'song_thu_lo_khung_2_ngay',   'name' => 'Song Thủ Nuôi Khung 2 Ngày',  'description' => 'Bảng theo dõi song thủ lô 2 ngày'],
            ['code' => 'song_thu_lo_khung_3_ngay',   'name' => 'Song Thủ Nuôi Khung 3 Ngày',  'description' => 'Bảng theo dõi song thủ lô 3 ngày'],
            ['code' => 'song_thu_lo_khung_5_ngay',   'name' => 'Song Thủ Nuôi Khung 5 Ngày',  'description' => 'Bảng theo dõi song thủ lô 5 ngày'],

            // ═══════════════════════════════════════════════
            // NHÓM 4: Đọc Thủ VIP
            // ═══════════════════════════════════════════════
            ['code' => 'doc_thu_lo_vip',     'name' => 'Đọc Thủ Lô VIP',              'description' => 'Đọc thủ lô VIP hôm nay + lô nóng bổ sung'],
            ['code' => 'doc_thu_de_vip',     'name' => 'Đọc Thủ Đề VIP',              'description' => 'Đọc thủ đề VIP hôm nay'],
            ['code' => 'doc_thu_lo_kep_vip', 'name' => 'Đọc Thủ Lô Kép VIP',         'description' => 'Đọc thủ lô kép VIP hôm nay + thống kê tất cả lô kép'],
            ['code' => 'doc_thu_de_kep_vip', 'name' => 'Đọc Thủ Đề Kép VIP',         'description' => 'Dự đoán số kép xuất hiện trong giải đặc biệt hôm nay'],

            // ═══════════════════════════════════════════════
            // NHÓM 5: Cầu đẹp hằng ngày (MB / MN / MT)
            // ═══════════════════════════════════════════════
            ['code' => 'caudephangngay_mb',  'name' => 'Cầu Đẹp Hằng Ngày MB',       'description' => 'Cầu lô đẹp, kép, tổng ĐB hằng ngày XSMB'],
            ['code' => 'caudephangngay_mn',  'name' => 'Cầu Đẹp Hằng Ngày MN',       'description' => 'Cầu lô đẹp, kép, tổng ĐB hằng ngày XSMN'],
            ['code' => 'caudephangngay_mt',  'name' => 'Cầu Đẹp Hằng Ngày MT',       'description' => 'Cầu lô đẹp, kép, tổng ĐB hằng ngày XSMT'],
            ['code' => 'caudephangngay1_mn', 'name' => 'Cầu Đẹp Hằng Ngày MN (v2)',  'description' => 'Cầu đẹp MN biến thể 2'],
            ['code' => 'caudephangngay1_mt', 'name' => 'Cầu Đẹp Hằng Ngày MT (v2)',  'description' => 'Cầu đẹp MT biến thể 2'],
            ['code' => 'caudephangngay',     'name' => 'Cầu Đẹp Theo Tỉnh',          'description' => 'Cầu đẹp hằng ngày theo tỉnh. Params: dai (tên tỉnh), mien (1=MB/2=MN/3=MT)'],

            // ═══════════════════════════════════════════════
            // NHÓM 6: Thống kê
            // ═══════════════════════════════════════════════
            ['code' => 'thong_ke',                    'name' => 'Thống Kê Tần Suất (Compact)',  'description' => 'Bảng thống kê tần suất compact. Params: days, region'],
            ['code' => 'thong_ke_nhanh',              'name' => 'Thống Kê Nhanh',               'description' => '6 bảng: loto freq, ĐB freq, loto gan, đầu/đuôi/tổng ĐB'],
            ['code' => 'thong_ke_lo',                 'name' => 'Thống Kê Lô Đề',               'description' => '2 bảng: lô hay về + lô gan. Params: days'],
            ['code' => 'thong_ke_general',            'name' => 'Thống Kê Tổng Hợp',            'description' => 'Thống kê đầu số, đuôi số, top 20 lô. Params: domain (1/2/3)'],
            ['code' => 'lrd_thong_ke_dau_duoi_loto',  'name' => 'Thống Kê Đầu Đuôi Loto',      'description' => 'Bảng thống kê đầu và đuôi số loto. Params: region, days'],
            ['code' => 'lrd_thong_ke_lo_kep',         'name' => 'Thống Kê Lô Kép',              'description' => 'Tần suất 10 lô kép (00,11,...99). Params: region, days'],
            ['code' => 'lrd_thong_ke_lo_roi',         'name' => 'Lô Rơi / Ít Về Nhất',         'description' => 'Bảng lô ít về nhất trong N ngày. Params: region, days'],
            ['code' => 'lrd_thong_ke_tan_suat_loto',  'name' => 'Tần Suất Loto Đầy Đủ',        'description' => 'Tần suất tất cả 100 số (00-99) dạng biểu đồ. Params: region, days'],
            ['code' => 'lrd_thong_ke_theo_tong',      'name' => 'Thống Kê Theo Tổng Số',       'description' => 'Tổng 2 chữ số cuối của lô (0-18). Params: region, days'],
            ['code' => 'lrd_thong_ke_chu_ky_dac_biet','name' => 'Chu Kỳ Giải Đặc Biệt',       'description' => 'Chu kỳ trung bình mỗi số xuất hiện ở giải ĐB. Params: region'],
            ['code' => 'lrd_thong_ke_giai_dac_biet_gan','name' => 'Đuôi ĐB Gan Lâu Nhất',     'description' => 'Đuôi giải ĐB lâu chưa về. Params: region, days'],
            ['code' => 'lrd_thong_ke_quan_trong',     'name' => 'Thống Kê Quan Trọng',         'description' => 'Tổng hợp: lô hay, lô gan, lô kép, đầu/đuôi ĐB gan. Params: region'],
            ['code' => 'lrd_thong_ke_tan_suat_cap_loto','name' => 'Thống Kê Cặp Loto Hay Ra', 'description' => 'Top cặp số cùng xuất hiện nhiều nhất. Params: region, days'],
            ['code' => 'lrd_thong_ke_tong_hop',       'name' => 'Thống Kê Tổng Hợp Đầy Đủ',  'description' => 'Tổng hợp tất cả thống kê: lô hay, lô gan, ĐB freq, đầu/đuôi/tổng. Params: region, days'],
            ['code' => 'lrd_sosanh_tansuat',          'name' => 'So Sánh Tần Suất',            'description' => 'So sánh tần suất lô hay, lô gan, lô kép, tổng ĐB. Params: region, days'],

            // ═══════════════════════════════════════════════
            // NHÓM 7: Lô Gan
            // ═══════════════════════════════════════════════
            ['code' => 'lo_gan',         'name' => 'Lô Gan (Compact)',          'description' => 'Bảng lô gan compact. Params: limit, region'],
            ['code' => 'lrd_logan',      'name' => 'Lô Gan Mở Rộng',           'description' => 'Lô gan theo miền/đài. Params: mien (1/2/3), type (normal/dropdown), dai'],
            ['code' => 'lrd_logan_full', 'name' => 'Lô Gan Đầy Đủ (00-99)',    'description' => 'Bảng lô gan đầy đủ 100 số. Params: region (mb/mn/mt)'],

            // ═══════════════════════════════════════════════
            // NHÓM 8: Bảng Giải Đặc Biệt
            // ═══════════════════════════════════════════════
            ['code' => 'lrd_bang_dac_biet_nam',   'name' => 'Bảng ĐB Theo Năm',    'description' => 'Giải đặc biệt theo năm. Params: year, region'],
            ['code' => 'lrd_bang_dac_biet_thang', 'name' => 'Bảng ĐB Theo Tháng',  'description' => 'Giải đặc biệt theo tháng. Params: month (YYYY-MM), region'],
            ['code' => 'lrd_bang_dac_biet_tuan',  'name' => 'Bảng ĐB Theo Tuần',   'description' => 'Giải đặc biệt theo tuần. Params: week (YYYY-WW), region'],

            // ═══════════════════════════════════════════════
            // NHÓM 9: Lô Top & Cao Thủ
            // ═══════════════════════════════════════════════
            ['code' => 'lo_top',          'name' => 'Bảng Lô Top',             'description' => 'Top lô chơi nhiều. Params: limit'],
            ['code' => 'lrd_top_lo_dep_nhat', 'name' => 'Top Lô Đẹp Nhất',    'description' => 'Top lô đẹp nhất theo tần suất. Params: region, limit'],
            ['code' => 'cao_thu_mo_bat',  'name' => 'Cao Thủ Mở Bát',         'description' => 'Dự đoán cao thủ mở bát lô/đề hôm nay. Params: type (lo/de)'],
            ['code' => 'lo_de_bac_nho',   'name' => 'Lô/Đề Bặc Nhớ',         'description' => 'Số lô/đề ít về nhất (cơ hội quay lại). Params: type (lo/de), days'],

            // ═══════════════════════════════════════════════
            // NHÓM 10: Dàn Đề & Dàn Lô
            // ═══════════════════════════════════════════════
            ['code' => 'lrd_du_doan_3_cang',      'name' => 'Dự Đoán 3 Càng',       'description' => 'Bảng dự đoán 3 càng hôm nay'],
            ['code' => 'lrd_dan_lo_6_so',          'name' => 'Dàn Lô 6 Số',          'description' => 'Dàn lô 6 số hôm nay + lịch sử 7 ngày'],
            ['code' => 'lrd_dan_3_cang_lo',        'name' => 'Dàn 3 Càng Lô',        'description' => 'Dàn 3 càng lô hôm nay'],
            ['code' => 'lrd_dan_de_3_cang',        'name' => 'Dàn Đề 3 Càng 50 Số', 'description' => 'Dàn đề 3 càng hôm nay - 50 số'],
            ['code' => 'dandehangngay',             'name' => 'Dàn Đề Hằng Ngày',    'description' => 'Dàn đề hằng ngày theo nhóm (đầu/đuôi/tổng). Params: count'],
            ['code' => 'taodande',                  'name' => 'Công Cụ Tạo Dàn Đề',  'description' => 'Công cụ tạo dàn đề tương tác: theo đầu, đuôi, tổng, khoảng'],
            ['code' => 'lrd_ghep_lo_xien_tu_dong',  'name' => 'Ghép Lô Xiên Tự Động', 'description' => 'Công cụ ghép lô xiên 2/3/4 từ danh sách số nhập vào'],

            // ═══════════════════════════════════════════════
            // NHÓM 11: Lô Kép Nuôi Khung
            // ═══════════════════════════════════════════════
            ['code' => 'lo_kep_khung_2_ngay', 'name' => 'Lô Kép Nuôi Khung 2 Ngày', 'description' => 'Bảng nuôi lô kép khung 2 ngày'],
            ['code' => 'lo_kep_khung_3_ngay', 'name' => 'Lô Kép Nuôi Khung 3 Ngày', 'description' => 'Bảng nuôi lô kép khung 3 ngày'],
            ['code' => 'lo_kep_khung_5_ngay', 'name' => 'Lô Kép Nuôi Khung 5 Ngày', 'description' => 'Bảng nuôi lô kép khung 5 ngày'],

            // ═══════════════════════════════════════════════
            // NHÓM 12: XSMB Nhiều Ngày & Theo Thứ
            // ═══════════════════════════════════════════════
            ['code' => 'lrd_xsmb_nhieu_ngay', 'name' => 'XSMB Nhiều Ngày',       'description' => 'Bảng KQXS MB nhiều ngày dạng ngang. Params: limit (max 200)'],
            ['code' => 'lrd_xsmn_theo_thu',   'name' => 'XSMN Theo Thứ',         'description' => 'KQXS MN lọc theo thứ. Params: thu (2-7/cn), limit'],
            ['code' => 'lrd_xsmt_theo_thu',   'name' => 'XSMT Theo Thứ',         'description' => 'KQXS MT lọc theo thứ. Params: thu (2-7/cn), limit'],

            // ═══════════════════════════════════════════════
            // NHÓM 13: Vietlott & Keno
            // ═══════════════════════════════════════════════
            ['code' => 'lrd_keno',           'name' => 'Kết Quả Keno',           'description' => 'Kết quả Keno mới nhất. Params: limit'],
            ['code' => 'lrd_xsmega645',      'name' => 'Vietlott Mega 6/45',     'description' => 'Kết quả Vietlott Mega 6/45. Params: limit'],
            ['code' => 'lrd_power655',       'name' => 'Vietlott Power 6/55',    'description' => 'Kết quả Vietlott Power 6/55. Params: limit'],
            ['code' => 'lrd_max3d',          'name' => 'Vietlott Max3D',         'description' => 'Kết quả Vietlott Max3D. Params: limit'],
            ['code' => 'lrd_max3dpro',       'name' => 'Vietlott Max3D Pro',     'description' => 'Kết quả Vietlott Max3D Pro. Params: limit'],
            ['code' => 'lrd_lotto_535',      'name' => 'Vietlott Lotto 5/35',    'description' => 'Kết quả Vietlott Lotto 5/35. Params: limit'],
            ['code' => 'lrd_bingo18',        'name' => 'Vietlott Bingo18',       'description' => 'Kết quả Vietlott Bingo18. Params: limit'],
            ['code' => 'dudoanvietlott_power','name' => 'Dự Đoán Vietlott Power', 'description' => 'Dự đoán bộ số Vietlott Power 6/55 theo thống kê'],
            ['code' => 'dudoanvietlott_mega', 'name' => 'Dự Đoán Vietlott Mega', 'description' => 'Dự đoán bộ số Vietlott Mega 6/45 theo thống kê'],

            // ═══════════════════════════════════════════════
            // NHÓM 14: Quay Thử & Số Mơ
            // ═══════════════════════════════════════════════
            ['code' => 'lrd_page_quay_thu', 'name' => 'Quay Thử Nâng Cao',       'description' => 'Mô phỏng quay thử XS có chọn tỉnh. Params: region, province, hard'],
            ['code' => 'quay_thu',          'name' => 'Quay Thử Đơn Giản',       'description' => 'Quay thử XS đơn giản ngẫu nhiên. Params: region'],
            ['code' => 'lrd_so_mo',         'name' => 'Tra Cứu Số Mơ',           'description' => 'Công cụ tra cứu số lô đề từ giấc mơ (client-side)'],
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
                ]
            );
        }

        $this->command->info('Seeded ' . count($builtins) . ' built-in shortcodes.');
    }
}
