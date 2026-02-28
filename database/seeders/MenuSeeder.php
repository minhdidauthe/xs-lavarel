<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'Trang Chủ', 'url' => '/', 'icon' => 'fas fa-home', 'match_pattern' => '/', 'sort_order' => 0],
            ['title' => 'Lịch Sử KQ', 'url' => '/lich-su/north', 'icon' => 'fas fa-history', 'match_pattern' => 'lich-su*', 'sort_order' => 1],
            ['title' => 'Soi Cầu', 'url' => '/soi-cau', 'icon' => 'fas fa-robot', 'match_pattern' => 'soi-cau*', 'sort_order' => 2],
            ['title' => 'Thống Kê', 'url' => '/thong-ke', 'icon' => 'fas fa-chart-bar', 'match_pattern' => 'thong-ke*', 'sort_order' => 3],
            ['title' => 'Quay Thử', 'url' => '/quay-thu', 'icon' => 'fas fa-dice', 'match_pattern' => 'quay-thu*', 'sort_order' => 4],
            ['title' => 'Blog', 'url' => '/blog', 'icon' => 'fas fa-newspaper', 'match_pattern' => 'blog*', 'sort_order' => 5],
            ['title' => 'VIP', 'url' => '#', 'icon' => 'fas fa-crown', 'css_class' => 'vip', 'sort_order' => 6],
        ];

        foreach ($items as $item) {
            Menu::updateOrCreate(
                ['url' => $item['url'], 'title' => $item['title']],
                array_merge($item, ['is_active' => true])
            );
        }

        $this->command->info('Seeded ' . count($items) . ' menu items.');
    }
}
