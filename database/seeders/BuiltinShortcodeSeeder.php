<?php

namespace Database\Seeders;

use App\Models\Shortcode;
use Illuminate\Database\Seeder;

class BuiltinShortcodeSeeder extends Seeder
{
    public function run(): void
    {
        $builtins = [
            ['code' => 'welcome_banner', 'name' => 'Banner Chào Mừng', 'description' => 'Banner tiêu đề trang chủ + ngày hôm nay'],
            ['code' => 'soi_cau_mb', 'name' => 'Soi Cầu Miền Bắc', 'description' => 'Bảng soi cầu MB: bạch thủ, song thủ, xiên 2, lô kép, ĐB chạm, 3 càng'],
            ['code' => 'cau_dep', 'name' => 'Cầu Đẹp XSMB', 'description' => 'Cầu lô tô, 2 nháy, đặc biệt đẹp'],
            ['code' => 'lo_top', 'name' => 'Bảng Lô Top', 'description' => 'Top lô chơi nhiều. Params: limit'],
            ['code' => 'du_doan_cards', 'name' => 'Cards Dự Đoán', 'description' => '3 cards: Lô VIP, Đề VIP, Nuôi Lô Khung'],
            ['code' => 'kqxs_full', 'name' => 'KQXS Đầy Đủ', 'description' => 'Bảng KQXS đầy đủ tất cả giải. Params: region (MB/MN/MT)'],
            ['code' => 'thong_ke_nhanh', 'name' => 'Thống Kê Nhanh', 'description' => '6 bảng: loto freq, ĐB freq, loto gan, đầu/đuôi/tổng ĐB. Params: days'],
            ['code' => 'kqxs_mt_mn', 'name' => 'KQXS MT + MN', 'description' => '2 bảng KQXS Miền Trung + Miền Nam song song'],
            ['code' => 'thong_ke_lo', 'name' => 'Thống Kê Lô Đề', 'description' => '2 bảng: lô hay + lô gan. Params: days'],
            ['code' => 'blog_moi', 'name' => 'Bài Viết Mới', 'description' => 'Grid bài viết blog mới nhất. Params: limit'],
            ['code' => 'kqxs', 'name' => 'KQXS (Compact)', 'description' => 'Bảng KQXS compact cho bài viết. Params: region (MB/MN/MT)'],
            ['code' => 'soi_cau', 'name' => 'Soi Cầu AI (Compact)', 'description' => 'Bảng dự đoán AI top 10 cho bài viết'],
            ['code' => 'thong_ke', 'name' => 'Thống Kê Tần Suất (Compact)', 'description' => 'Bảng thống kê tần suất compact. Params: days, region'],
            ['code' => 'lo_gan', 'name' => 'Lô Gan (Compact)', 'description' => 'Bảng lô gan compact. Params: limit, region'],
        ];

        foreach ($builtins as $item) {
            Shortcode::updateOrCreate(
                ['code' => $item['code']],
                [
                    'name' => $item['name'],
                    'description' => $item['description'],
                    'content' => '<!-- builtin: ' . $item['code'] . ' -->',
                    'is_active' => true,
                    'is_builtin' => true,
                ]
            );
        }

        $this->command->info('Seeded ' . count($builtins) . ' built-in shortcodes.');
    }
}
