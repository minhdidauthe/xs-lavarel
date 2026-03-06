<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-equals"></i> Thống Kê Lô Kép {{ $region }} — {{ $days }} Ngày</h2>
    <table class="sc-table">
        <thead><tr><th>Lô Kép</th><th>Số lần về</th><th>Xếp hạng</th></tr></thead>
        <tbody>
            @php $rank = 1; @endphp
            @forelse($kepFreq as $num => $count)
            <tr>
                <td><span class="sc-badge sc-badge-kep">{{ $num }}</span></td>
                <td><strong>{{ $count }}</strong> lần</td>
                <td>#{{ $rank++ }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="sc-no-data">Chưa có dữ liệu.</td></tr>
            @endforelse
        </tbody>
    </table>
</section>
