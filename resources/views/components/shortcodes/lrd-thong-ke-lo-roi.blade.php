<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-exclamation-triangle"></i> Lô Rơi / Ít Về Nhất {{ $region }} — {{ $days }} Ngày</h2>
    <table class="sc-table">
        <thead><tr><th>Số lô</th><th>Lần về</th><th>Ngày cuối</th><th>Gan</th></tr></thead>
        <tbody>
            @forelse($loRoi as $item)
            <tr>
                <td><span class="sc-badge sc-badge-cold">{{ $item['number'] }}</span></td>
                <td>{{ $item['count'] ?? 0 }} lần</td>
                <td>{{ $item['lastSeen'] ? \Carbon\Carbon::parse($item['lastSeen'])->format('d/m/Y') : 'Chưa về' }}</td>
                <td>{{ $item['daysSince'] ?? '—' }} ngày</td>
            </tr>
            @empty
            <tr><td colspan="4" class="sc-no-data">Không có dữ liệu.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
