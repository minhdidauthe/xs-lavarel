<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-star"></i> {{ $title ?? 'Bảng Giải Đặc Biệt' }} — {{ $region }}</h2>
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
                $sp = is_array($item['special']) ? ($item['special'][0] ?? '---') : ($item['special'] ?? '---');
                $last2 = str_pad(substr($sp, -2), 2, '0', STR_PAD_LEFT);
            @endphp
            <tr>
                <td>{{ \Carbon\Carbon::parse($item['date'])->format('d/m/Y') }}</td>
                <td>{{ $item['province'] ?? '—' }}</td>
                <td><span class="sc-badge sc-badge-hot">{{ $sp }}</span></td>
                <td>{{ $last2[0] }}</td>
                <td>{{ $last2[1] }}</td>
            </tr>
            @empty
            <tr><td colspan="5" class="sc-no-data">Chưa có dữ liệu.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
