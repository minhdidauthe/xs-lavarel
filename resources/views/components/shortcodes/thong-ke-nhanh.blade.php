<section class="container sc-section">
    <div class="sc-tk-box">
        <div class="sc-tk-header">
            <i class="fas fa-chart-line"></i> Thống Kê Nhanh Xổ Số Miền Bắc Hôm Nay
        </div>

        <div class="sc-tk-section">
            <div class="sc-tk-label">10 bộ số loto về <strong class="sc-red">nhiều</strong> nhất trong 30 lần quay</div>
            <div class="sc-tk-grid">
                @foreach($frequency as $item)
                    <div class="sc-tk-item"><strong>{{ $item['number'] }}</strong>: {{ $item['count'] }} lần</div>
                @endforeach
            </div>
        </div>

        <div class="sc-tk-section">
            <div class="sc-tk-label">Giải đặc biệt về <strong class="sc-red">nhiều</strong> nhất trong 30 lần quay</div>
            <div class="sc-tk-grid">
                @foreach($frequencyDB ?? [] as $item)
                    <div class="sc-tk-item"><strong>{{ $item['number'] }}</strong>: {{ $item['count'] }} lần</div>
                @endforeach
            </div>
        </div>

        <div class="sc-tk-section">
            <div class="sc-tk-label">Bộ số <strong class="sc-red">loto gan</strong> lâu chưa ra</div>
            <div class="sc-tk-grid">
                @foreach($waiting as $item)
                    <div class="sc-tk-item"><strong>{{ $item['number'] }}</strong>: {{ $item['days'] }} ngày</div>
                @endforeach
            </div>
        </div>

        <div class="sc-tk-section">
            <div class="sc-tk-label"><strong class="sc-red">Đầu</strong> đặc biệt miền Bắc lâu chưa về nhất</div>
            <div class="sc-tk-grid">
                @foreach($ganHead ?? [] as $digit => $gap)
                    <div class="sc-tk-item"><strong>{{ $digit }}</strong>: {{ $gap }} lần</div>
                @endforeach
            </div>
        </div>

        <div class="sc-tk-section">
            <div class="sc-tk-label"><strong class="sc-red">Đuôi</strong> đặc biệt miền Bắc lâu chưa về</div>
            <div class="sc-tk-grid">
                @foreach($ganTail ?? [] as $digit => $gap)
                    <div class="sc-tk-item"><strong>{{ $digit }}</strong>: {{ $gap }} lần</div>
                @endforeach
            </div>
        </div>

        <div class="sc-tk-section">
            <div class="sc-tk-label"><strong class="sc-red">Tổng</strong> đặc biệt miền Bắc lâu chưa về</div>
            <div class="sc-tk-grid">
                @foreach($ganSum ?? [] as $digit => $gap)
                    <div class="sc-tk-item"><strong>{{ $digit }}</strong>: {{ $gap }} lần</div>
                @endforeach
            </div>
        </div>
    </div>
</section>
