# Hướng dẫn tạo Shortcode mới trong xs-lavarel

## Tổng quan kiến trúc

```
[shortcode_name attr="value"]
        ↓
ShortcodeParser::parse()           ← regex bắt tag
        ↓
ShortcodeParser::renderXxx()       ← method PHP xử lý data
        ↓
view('components.shortcodes.xxx')  ← blade template render HTML
        ↓
HTML string trả về vào nội dung bài viết
```

**File quan trọng:**
- `app/Services/ShortcodeParser.php` — toàn bộ logic
- `resources/views/components/shortcodes/*.blade.php` — giao diện

---

## 3 bước tạo shortcode mới

### Bước 1: Đăng ký tag trong `$builtins`

Mở `ShortcodeParser.php`, thêm 1 dòng vào mảng `$builtins`:

```php
private array $builtins = [
    // ... các shortcode hiện có ...

    'ten_shortcode_moi' => 'renderTenShortcodeMoi',  // ← thêm dòng này
];
```

**Quy tắc đặt tên:**
- Tag: `snake_case` — ví dụ: `bach_thu_lo_vip`, `lo_gan`, `du_doan_3_mien`
- Method: `renderCamelCase` — ví dụ: `renderBachThuLoVip`, `renderLoGan`

---

### Bước 2: Viết render method

Thêm method vào cuối class `ShortcodeParser`:

```php
private function renderTenShortcodeMoi(array $attrs): string
{
    // 1. Đọc attributes từ tag (nếu có)
    $region = $attrs['region'] ?? 'MB';   // [ten_shortcode_moi region="MT"]
    $days   = (int) ($attrs['days'] ?? 30);

    // 2. Truy vấn dữ liệu từ DB
    $results = LotteryResult::where('region', $region)
        ->where('province', '!=', 'ĐUÔI')
        ->where('date', '>=', now()->subDays($days)->toDateString())
        ->orderByDesc('date')
        ->get();

    // 3. Xử lý / tính toán
    if ($results->isEmpty()) {
        return '<p class="text-gray-400 italic">Chưa có dữ liệu.</p>';
    }

    $data = []; // mảng dữ liệu truyền vào view
    foreach ($results as $r) {
        foreach ($r->numbers as $num) {
            $last2 = substr($num, -2);
            // ... tính toán ...
        }
    }

    // 4. Render blade template
    return view('components.shortcodes.ten-shortcode-moi', compact('data', 'region'))->render();
}
```

**Trả về lỗi khi không có data:**
```php
return '<p class="text-gray-400 italic">Thông báo lỗi</p>';
```

---

### Bước 3: Tạo blade template

Tạo file `resources/views/components/shortcodes/ten-shortcode-moi.blade.php`:

```blade
{{-- CSS class gốc dùng chung: sc-table, sc-header, sc-badge, sc-badge-* --}}
<div class="sc-wrap sc-ten-shortcode-moi">
    <div class="sc-header">
        <span class="sc-header-icon">🎯</span>
        <h3 class="sc-header-title">Tên Bảng Của Bạn</h3>
        <span class="sc-header-date">{{ now()->format('d/m/Y') }}</span>
    </div>

    <div class="sc-body">
        <table class="sc-table">
            <thead>
                <tr>
                    <th>Cột 1</th>
                    <th>Cột 2</th>
                    <th>Kết quả</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item['field1'] }}</td>
                    <td>{{ $item['field2'] }}</td>
                    <td>
                        @if($item['status'] === 've')
                            <span class="sc-kq-ve">✓ Về</span>
                        @elseif($item['status'] === 'cho')
                            <span class="sc-kq-cho">⏳ Đang chờ</span>
                        @else
                            <span class="sc-kq-khongve">✗ Không về</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
```

---

## CSS classes có sẵn (từ `public/css/shortcodes.css`)

| Class | Dùng cho |
|-------|----------|
| `.sc-wrap` | Container ngoài cùng |
| `.sc-header` | Thanh tiêu đề bảng |
| `.sc-header-title` | Tên bảng |
| `.sc-header-date` | Ngày hiển thị |
| `.sc-body` | Nội dung bảng |
| `.sc-table` | Bảng dữ liệu |
| `.sc-badge` | Badge số (ô vuông) |
| `.sc-badge-hot` | Badge đỏ — số nóng |
| `.sc-badge-cold` | Badge xanh — số lạnh |
| `.sc-badge-kep` | Badge vàng — số kép |
| `.sc-kq-ve` | Kết quả "Về" (xanh lá) |
| `.sc-kq-khongve` | Kết quả "Không về" (đỏ) |
| `.sc-kq-cho` | Kết quả "Đang chờ" (vàng) |
| `.sc-nums` | Dãy số nằm ngang |
| `.sc-num` | 1 ô số |

---

## Dùng shared data helpers (tránh query trùng)

Nếu shortcode cần dữ liệu **tần suất / AI prediction**, dùng cache sẵn:

```php
// Dùng getPredictionData() — cache chung cho soi_cau_mb, cau_dep, lo_top...
private function renderXxx(array $attrs): string
{
    $cache = $this->getPredictionData();
    $freq        = $cache['freq'];         // tần suất 30 ngày
    $predictionAI = $cache['predictionAI']; // top10 AI (có thể null)
    $loTop       = $cache['loTop'];        // top 20 lô
    $soiCauMB    = $cache['soiCauMB'];     // bạch thủ, song thủ, xiên...
    $cauDep      = $cache['cauDep'];       // cầu loto, 2 nháy, ĐB
}

// Dùng getStatsData() — cache chung cho thong_ke_nhanh, thong_ke_lo...
private function renderXxx(array $attrs): string
{
    $stats = $this->getStatsData();
    $frequency   = $stats['frequency'];    // [{number, count}, ...]
    $waiting     = $stats['waiting'];      // lô gan [{number, days}, ...]
    $frequencyDB = $stats['frequencyDB'];  // tần suất giải ĐB
    $ganHead     = $stats['ganHead'];      // đầu gan nhất
    $ganTail     = $stats['ganTail'];      // đuôi gan nhất
    $ganSum      = $stats['ganSum'];       // tổng gan nhất
}
```

---

## Hỗ trợ attributes trong tag

Người dùng viết trong bài: `[ten_shortcode_moi region="MT" days="7"]`

Trong method PHP, đọc qua `$attrs`:
```php
$region = $attrs['region'] ?? 'MB';   // mặc định MB nếu không truyền
$days   = (int) ($attrs['days'] ?? 30);
$limit  = (int) ($attrs['limit'] ?? 10);
$title  = $attrs['title'] ?? 'Dự Đoán Hôm Nay';
```

---

## Ví dụ hoàn chỉnh: shortcode `lo_hot_mb`

**Mục tiêu:** Hiển thị top 5 lô xuất hiện nhiều nhất trong N ngày gần đây.

**Bước 1** — Đăng ký:
```php
'lo_hot_mb' => 'renderLoHotMB',
```

**Bước 2** — Method:
```php
private function renderLoHotMB(array $attrs): string
{
    $days  = (int) ($attrs['days'] ?? 30);
    $limit = (int) ($attrs['limit'] ?? 5);

    $cache = $this->getPredictionData();
    $freq  = $cache['freq'];

    $topLo = [];
    foreach (array_slice($freq, 0, $limit, true) as $num => $count) {
        $topLo[] = ['so' => str_pad($num, 2, '0', STR_PAD_LEFT), 'count' => $count];
    }

    return view('components.shortcodes.lo-hot-mb', compact('topLo', 'days', 'limit'))->render();
}
```

**Bước 3** — Blade `lo-hot-mb.blade.php`:
```blade
<div class="sc-wrap sc-lo-hot-mb">
    <div class="sc-header">
        <span class="sc-header-icon">🔥</span>
        <h3 class="sc-header-title">Top {{ $limit }} Lô Nóng {{ $days }} Ngày</h3>
        <span class="sc-header-date">{{ now()->format('d/m/Y') }}</span>
    </div>
    <div class="sc-body">
        <div class="sc-nums">
            @foreach($topLo as $item)
            <span class="sc-badge sc-badge-hot" title="Về {{ $item['count'] }} lần">
                {{ $item['so'] }}
            </span>
            @endforeach
        </div>
    </div>
</div>
```

**Dùng trong bài viết:**
```
[lo_hot_mb days="7" limit="5"]
```

---

## Deploy sau khi thêm shortcode

```bash
# Không cần migration (không thêm DB table mới)
git add app/Services/ShortcodeParser.php resources/views/components/shortcodes/
git commit -m "feat: add shortcode lo_hot_mb"
git push origin master
python run_deploy.py
```

> **Lưu ý:** Không cần chạy `php artisan migrate` hay clear cache thủ công vì ShortcodeParser không dùng cache framework (chỉ có `$predictionCache` và `$statsCache` là in-memory, reset sau mỗi request).
