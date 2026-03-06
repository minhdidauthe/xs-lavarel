<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-link"></i> Thống Kê Cặp Loto Hay Ra {{ $region }} — {{ $days }} Ngày</h2>
    <table class="sc-table">
        <thead><tr><th>#</th><th>Cặp số</th><th>Cùng xuất hiện</th></tr></thead>
        <tbody>
            @forelse($topCap as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    <span class="sc-badge">{{ $item['cap'][0] ?? '' }}</span>
                    <span class="sc-badge">{{ $item['cap'][1] ?? '' }}</span>
                </td>
                <td><strong>{{ $item['count'] }}</strong> lần</td>
            </tr>
            @empty
            <tr><td colspan="3" class="sc-no-data">Chưa có dữ liệu.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
