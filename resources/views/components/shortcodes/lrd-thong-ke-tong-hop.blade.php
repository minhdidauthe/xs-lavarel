<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-chart-pie"></i> Thống Kê Tổng Hợp {{ $region ?? 'MB' }} — {{ $days ?? 30 }} Ngày</h2>
    <div class="sc-stats-row">
        <div class="sc-stats-box">
            <h3 class="sc-stats-title red"><i class="fas fa-fire-alt"></i> Lô Về Nhiều Nhất</h3>
            <div class="sc-tk-grid">
                @foreach($frequency ?? [] as $item)
                    <div class="sc-tk-item"><strong>{{ $item['number'] }}</strong>: {{ $item['count'] }}x</div>
                @endforeach
            </div>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title blue"><i class="fas fa-hourglass-half"></i> Lô Gan Lâu Nhất</h3>
            <div class="sc-tk-grid">
                @foreach($waiting ?? [] as $item)
                    <div class="sc-tk-item"><strong>{{ $item['number'] }}</strong>: {{ $item['days'] }}n</div>
                @endforeach
            </div>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title">Giải ĐB Hay Về</h3>
            <div class="sc-tk-grid">
                @foreach($frequencyDB ?? [] as $item)
                    <div class="sc-tk-item"><strong>{{ $item['number'] }}</strong>: {{ $item['count'] }}x</div>
                @endforeach
            </div>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title">Đầu / Đuôi / Tổng ĐB Gan</h3>
            <div class="sc-tk-grid">
                @foreach($ganHead ?? [] as $d => $g) <div class="sc-tk-item">Đầu <strong>{{ $d }}</strong>: {{ $g }}n</div> @endforeach
                @foreach($ganTail ?? [] as $d => $g) <div class="sc-tk-item">Đuôi <strong>{{ $d }}</strong>: {{ $g }}n</div> @endforeach
                @foreach($ganSum ?? [] as $d => $g)  <div class="sc-tk-item">Tổng <strong>{{ $d }}</strong>: {{ $g }}n</div> @endforeach
            </div>
        </div>
    </div>
</section>
