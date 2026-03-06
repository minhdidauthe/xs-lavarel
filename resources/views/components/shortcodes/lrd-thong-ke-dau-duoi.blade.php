<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-sort-amount-up"></i> Thống Kê Đầu Đuôi {{ $region }} — {{ $days }} Ngày</h2>
    <div class="sc-stats-row">
        <div class="sc-stats-box">
            <h3 class="sc-stats-title red">Thống Kê Đầu Số Loto</h3>
            <table class="sc-stats-table">
                <thead><tr><th>Đầu</th><th>Lần xuất hiện</th></tr></thead>
                <tbody>
                    @foreach($dau as $digit => $count)
                    <tr><td><span class="sc-num-badge">{{ $digit }}</span></td><td>{{ $count }} lần</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title blue">Thống Kê Đuôi Số Loto</h3>
            <table class="sc-stats-table">
                <thead><tr><th>Đuôi</th><th>Lần xuất hiện</th></tr></thead>
                <tbody>
                    @foreach($duoi as $digit => $count)
                    <tr><td><span class="sc-num-badge">{{ $digit }}</span></td><td>{{ $count }} lần</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
