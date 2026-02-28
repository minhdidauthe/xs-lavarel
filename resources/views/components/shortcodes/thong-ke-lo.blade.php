<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-chart-bar"></i> Thống Kê Lô Đề Miền Bắc</h2>
    <div class="sc-stats-row">
        <div class="sc-stats-box">
            <h3 class="sc-stats-title red"><i class="fas fa-fire-alt"></i> 10 Lô Về Nhiều Nhất (30 ngày)</h3>
            <table class="sc-stats-table">
                <thead><tr><th>Số</th><th>Số lần</th></tr></thead>
                <tbody>
                    @forelse($frequency ?? [] as $item)
                    <tr>
                        <td><span class="sc-num-badge red">{{ $item['number'] }}</span></td>
                        <td>{{ $item['count'] }} lần</td>
                    </tr>
                    @empty
                    <tr><td colspan="2">Chưa có dữ liệu</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="sc-stats-box">
            <h3 class="sc-stats-title blue"><i class="fas fa-hourglass-half"></i> 10 Lô Gan Lâu Chưa Về</h3>
            <table class="sc-stats-table">
                <thead><tr><th>Số</th><th>Gan</th></tr></thead>
                <tbody>
                    @forelse($waiting ?? [] as $item)
                    <tr>
                        <td><span class="sc-num-badge blue">{{ $item['number'] }}</span></td>
                        <td>{{ $item['days'] }} ngày</td>
                    </tr>
                    @empty
                    <tr><td colspan="2">Chưa có dữ liệu</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div style="text-align:center; margin-top:16px;">
        <a href="/thong-ke" class="sc-btn-more">Xem thống kê đầy đủ <i class="fas fa-arrow-right"></i></a>
    </div>
</section>
