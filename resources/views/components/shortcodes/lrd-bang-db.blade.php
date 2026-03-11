<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-star"></i> {{ $title ?? 'Bảng Giải Đặc Biệt' }} — {{ $region }}
        </div>
        <table class="sc-table">
            <thead>
                <tr>
                    <th>Ngày</th>
                    <th>Tỉnh/Đài</th>
                    <th>Giải Đặc Biệt</th>
                    <th>Đầu</th>
                    <th>Đuôi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bangDB as $item)
                @php
                    $sp = $item['so'] ?? '---';
                    $last2 = strlen($sp) >= 2 ? str_pad(substr($sp, -2), 2, '0', STR_PAD_LEFT) : '00';
                @endphp
                <tr>
                    <td style="white-space:nowrap">{{ $item['date'] }}</td>
                    <td>{{ $item['province'] ?? '—' }}</td>
                    <td><span class="sc-badge sc-badge-hot" style="font-size:14px;letter-spacing:1px">{{ $sp }}</span></td>
                    <td><span class="sc-badge">{{ $last2[0] }}</span></td>
                    <td><span class="sc-badge">{{ $last2[1] }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5" class="sc-no-data">Chưa có dữ liệu.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Tổng cộng {{ count($bangDB) }} kết quả giải ĐB ({{ $region }}).</em>
        </div>
    </div>
</section>
