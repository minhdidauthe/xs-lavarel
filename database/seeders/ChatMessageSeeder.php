<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ChatMessageSeeder extends Seeder
{
    public function run(): void
    {
        $colors = ['#e74c3c', '#3498db', '#2ecc71', '#f39c12', '#9b59b6', '#1abc9c', '#e67e22', '#34495e', '#d35400', '#27ae60'];

        $usernames = [
            'SoiCauPro88', 'LottoKing', 'BạchThủVIP', 'ThầnTài247', 'CầuĐẹpHN',
            'LôĐềSG', 'MasterLô99', 'VuaXổSố', 'CầuVàng88', 'DựĐoánAI',
            'HighWin365', 'LôTop1', 'ThầnSố', 'ĐạiGia68', 'CầuSiêu',
            'LôĐẹpMB', 'SốĐỏ777', 'ChuyênGia88', 'BắcNinh68', 'HàNội36',
            'SàiGòn99', 'ĐàNẵng55', 'TháiBình77', 'HảiPhòng88', 'NghệAn45',
            'ThanhHóa01', 'QuảngNinh92', 'VĩnhPhúc38', 'BắcGiang56', 'NamĐịnh27',
        ];

        // Pool of realistic messages
        $messages = [
            // Predictions & analysis
            'Hôm nay bạch thủ lô 38, tin tưởng ae ơi!',
            'Song thủ 27-72 khung 3 ngày, theo đi ae',
            'MB hôm nay đề về 56, cảm giác mạnh lắm',
            'Xiên 2: 15-51 chắc kèo hôm nay',
            'Lô kép 33 gan 5 ngày rồi, sắp nổ',
            'Cầu đẹp hôm nay: 28 - 82 - 38',
            'Dàn đề 36 số hôm nay: 01,05,10,14,19,23,28,32,37,41,46,50,55,59,64,68,73,77,82,86,91,95,00,04,09,13,18,22,27,31,36,40,45,49,54,58',
            'Bạch thủ đề 47, nuôi khung 3 ngày',
            'Lô về 38 rồi ae ơi, đúng bạch thủ!',
            'Song thủ 15-51 ăn rồi, quá đỉnh!',
            'Cầu lô 67 đẹp quá, nuôi tiếp ae',
            'Hôm qua đề 89, ai theo có lãi ko?',
            'Thống kê: Lô 27 đã gan 12 ngày',
            'AI dự đoán hôm nay đề MB: 45',
            'Lô top hôm nay: 56, 38, 72, 15',
            'Xiên 3: 27-38-56 thơm lắm ae',
            '3 càng đẹp: 456, 789',
            'Cầu đầu 3 hôm nay chạy tốt',
            'Đuôi 8 về nhiều mấy hôm rồi, canh đi',

            // Results & reactions
            'Trúng bạch thủ lô 72 rồi ae! Quá sướng',
            'Ăn xiên 2 rồi bà con ơi!!!',
            'Hôm qua lô 38 về đúng, ăn ngon',
            'Ai theo song thủ 27-72 trúng cả 2 ko?',
            'Đề MB 56 về rồi, ai có?',
            'Ăn đề rồi ae ơi, thanks admin!',
            'Hôm nay trúng 3 lô, hời quá',
            'Thần tài phù hộ, trúng lô kép 88!',
            'Kết quả MB đã ra, ai check chưa?',
            'Trượt bạch thủ rồi, buồn ghê',
            'Lô 45 về ngon ơi là ngon!',

            // Questions & discussion
            'Admin ơi, lô nào đẹp nhất hôm nay?',
            'Có ai theo dàn 40 số ko ae?',
            'Hỏi ae: Lô gan 15 ngày nên nuôi ko?',
            'Bao giờ KQXS MB ra vậy ae?',
            'Cầu nào chạy đẹp nhất tuần này?',
            'Ai có dàn đề VIP chia sẻ với',
            'Admin cho xin cầu đẹp MB tối nay',
            'Ae cho hỏi: Soi cầu Pascal là gì?',
            'Lô top AI hôm nay sao chưa cập nhật?',

            // Greetings & general
            'Chào ae, mới vào nhóm xin chỉ giáo!',
            'Chúc ae may mắn tối nay!',
            'Good luck cả nhà!',
            'Tối nay ăn lớn ae ơi!',
            'Admin site này phân tích chuẩn quá',
            'Theo Soi Cầu 24h chưa bao giờ thất vọng',
            'Cảm ơn admin, data rất chuẩn',
            'Ae cập nhật KQXS nhanh thật',
            'Site soi cầu tốt nhất mà tôi dùng',
            'Cầu AI ngày càng chính xác, hay lắm!',
        ];

        // Bot response messages
        $botMessages = [
            'Chào bạn! Hệ thống đang phân tích dữ liệu KQXS hôm nay...',
            'Bạch thủ lô MB hôm nay theo AI: 38. Tỷ lệ: 73%',
            'Song thủ lô đẹp: 27 - 72. Nuôi khung 3 ngày.',
            'KQXS MB đã cập nhật! Xem ngay tại trang Kết Quả.',
            'Thống kê: Lô 56 đã gan 8 ngày. Xác suất về: Cao.',
            'Dàn đề 10 số VIP: 12, 27, 38, 45, 51, 63, 72, 84, 90, 06',
            'Cầu lô chạy đẹp nhất tuần: Đầu 3, Đuôi 8',
            'Chúc mừng! Bạch thủ hôm qua đã về đúng.',
            'Lưu ý: Nội dung chỉ mang tính tham khảo. Chơi có trách nhiệm.',
            'AI phân tích: Cầu đầu 5 đang chạy đẹp, canh lô 50-59.',
        ];

        $now = Carbon::now('Asia/Ho_Chi_Minh');
        $records = [];

        // Generate 200 fake messages spread over last 7 days
        for ($i = 0; $i < 200; $i++) {
            $minutesAgo = rand(0, 7 * 24 * 60); // up to 7 days ago
            $createdAt = $now->copy()->subMinutes($minutesAgo);

            // Only generate messages between 6:00 - 23:59
            $hour = $createdAt->hour;
            if ($hour < 6) {
                $createdAt->setHour(rand(6, 23));
            }

            $isBot = rand(1, 100) <= 15; // 15% bot messages
            $username = $isBot ? 'Soi Cầu AI' : $usernames[array_rand($usernames)];
            $message = $isBot ? $botMessages[array_rand($botMessages)] : $messages[array_rand($messages)];
            $color = $isBot ? '#e74c3c' : $colors[array_rand($colors)];

            $records[] = [
                'username' => $username,
                'avatar_color' => $color,
                'message' => $message,
                'type' => $isBot ? 'bot' : 'user',
                'is_fake' => true,
                'site' => null, // show on both sites
                'likes' => rand(0, 25),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        // Sort by created_at
        usort($records, fn($a, $b) => $a['created_at'] <=> $b['created_at']);

        // Insert in chunks
        foreach (array_chunk($records, 50) as $chunk) {
            ChatMessage::insert($chunk);
        }
    }
}
