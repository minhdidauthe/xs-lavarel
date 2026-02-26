<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@soicau7777.click'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Default categories
        $categories = [
            ['name' => 'Soi Cầu', 'slug' => 'soi-cau', 'description' => 'Bài viết về soi cầu, dự đoán xổ số', 'sort_order' => 1],
            ['name' => 'Thống Kê', 'slug' => 'thong-ke', 'description' => 'Phân tích thống kê xổ số', 'sort_order' => 2],
            ['name' => 'KQXS', 'slug' => 'kqxs', 'description' => 'Kết quả xổ số 3 miền', 'sort_order' => 3],
            ['name' => 'Mẹo Chơi', 'slug' => 'meo-choi', 'description' => 'Kinh nghiệm và mẹo chơi xổ số', 'sort_order' => 4],
            ['name' => 'Tin Tức', 'slug' => 'tin-tuc', 'description' => 'Tin tức xổ số mới nhất', 'sort_order' => 5],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
