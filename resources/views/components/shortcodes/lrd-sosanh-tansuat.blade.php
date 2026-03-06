<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-balance-scale"></i> So Sánh Tần Suất {{ $region ?? 'MB' }} — {{ $days ?? 30 }} Ngày</h2>
    <div class="sc-stats-row">
        <div class="sc-stats-box">
            <h3 class="sc-stats-title red">Lô Về Nhiều Nhất</h3>
            <table class="sc-stats-table">
                <thead><tr><th>Số</th><th>Lần</th></tr></thead>
                <tbody>
                    @foreach(array_slice($frequency ?? [], 0, 10) as $item)
                    <tr>
                        <td><span class="sc-badge sc-badge-hot">{{ $item['number'] }}</span></td>
                        <td>{{ $item['count'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title blue">Lô Gan Nhất</h3>
            <table class="sc-stats-table">
                <thead><tr><th>Số</th><th>Ngày</th></tr></thead>
                <tbody>
                    @foreach(array_slice($waiting ?? [], 0, 10) as $item)
                    <tr>
                        <td><span class="sc-badge sc-badge-cold">{{ $item['number'] }}</span></td>
                        <td>{{ $item['days'] }}n</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title yellow">Lô Kép Thống Kê</h3>
            <div class="sc-tk-grid">
                @foreach($kepFreq ?? [] as $num => $count)
                    <div class="sc-tk-item"><span class="sc-badge sc-badge-kep">{{ $num }}</span> {{ $count }}x</div>
                @endforeach
            </div>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title">Tổng ĐB Hay Về</h3>
            <div class="sc-tk-grid">
                @foreach(array_slice($tongFreq ?? [], 0, 10, true) as $tong => $count)
                    <div class="sc-tk-item">Tổng <strong>{{ $tong }}</strong>: {{ $count }}x</div>
                @endforeach
            </div>
        </div>
    </div>
</section>
