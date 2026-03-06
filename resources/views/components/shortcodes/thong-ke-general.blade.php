<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-chart-bar"></i> Thống Kê Tổng Hợp {{ $region }} — {{ $days }} Ngày</h2>
    <div class="sc-stats-row">
        <div class="sc-stats-box">
            <h3 class="sc-stats-title red"><i class="fas fa-sort-numeric-up"></i> Thống Kê Đầu Số</h3>
            <table class="sc-stats-table">
                <thead><tr><th>Đầu</th><th>Số lần</th></tr></thead>
                <tbody>
                    @foreach($dau as $digit => $count)
                    <tr><td><span class="sc-num-badge">{{ $digit }}</span></td><td>{{ $count }} lần</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title blue"><i class="fas fa-sort-numeric-down"></i> Thống Kê Đuôi Số</h3>
            <table class="sc-stats-table">
                <thead><tr><th>Đuôi</th><th>Số lần</th></tr></thead>
                <tbody>
                    @foreach($duoi as $digit => $count)
                    <tr><td><span class="sc-num-badge">{{ $digit }}</span></td><td>{{ $count }} lần</td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title green"><i class="fas fa-fire-alt"></i> Top 20 Lô Về Nhiều Nhất</h3>
            <div class="sc-nums">
                @foreach($loTop as $num => $count)
                    <span class="sc-badge sc-badge-hot" title="{{ $count }} lần">{{ $num }}</span>
                @endforeach
            </div>
        </div>
    </div>
</section>
