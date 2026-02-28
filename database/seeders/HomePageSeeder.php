<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('role', 'admin')->first();

        if (!$author) {
            $this->command->warn('No admin user found. Skipping homepage seed.');
            return;
        }

        Page::updateOrCreate(
            ['slug' => 'home'],
            [
                'author_id' => $author->id,
                'title' => 'Trang Chủ',
                'content' => $this->getDefaultContent(),
                'rendered_content' => null,
                'meta_title' => 'SOICAU7777.CLICK - Soi Cầu Xổ Số 3 Miền - Kết Quả Xổ Số Hôm Nay',
                'meta_description' => 'Soi cầu lô đề miễn phí chính xác nhất. Cập nhật KQXS 3 miền hàng ngày, dự đoán AI thông minh.',
                'template' => 'homepage',
                'status' => 'published',
                'sort_order' => 0,
            ]
        );

        $this->command->info('Homepage seeded successfully (slug: home).');
    }

    private function getDefaultContent(): string
    {
        return <<<'SHORTCODES'
[welcome_banner]

[soi_cau_mb]

[cau_dep]

[lo_top]

[du_doan_cards]

[kqxs_full region="MB"]

[thong_ke_nhanh]

[kqxs_mt_mn]

[thong_ke_lo]

[blog_moi]
SHORTCODES;
    }
}
