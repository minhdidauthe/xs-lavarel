<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-star-half-alt"></i> Thống Kê Quan Trọng {{ $region }}</h2>
    <div class="sc-stats-row">
        <div class="sc-stats-box">
            <h3 class="sc-stats-title red">Lô Về Nhiều Nhất</h3>
            <div class="sc-nums">
                @foreach($freq as $num => $count)
                    <span class="sc-badge sc-badge-hot" title="{{ $count }} lần">{{ $num }}</span>
                @endforeach
            </div>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title blue">Lô Gan Lâu Nhất</h3>
            <div class="sc-nums">
                @foreach($waiting as $item)
                    <span class="sc-badge sc-badge-cold" title="{{ $item['days'] }} ngày">{{ $item['number'] }}</span>
                @endforeach
            </div>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title yellow">Lô Kép Hay Về</h3>
            <div class="sc-nums">
                @foreach($kepFreq as $num => $count)
                    <span class="sc-badge sc-badge-kep" title="{{ $count }} lần">{{ $num }}</span>
                @endforeach
            </div>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title">Đầu ĐB Gan Nhất</h3>
            <div class="sc-tk-grid">
                @foreach($ganHead ?? [] as $digit => $gap)
                    <div class="sc-tk-item"><strong>{{ $digit }}</strong>: {{ $gap }}n</div>
                @endforeach
            </div>
        </div>
        <div class="sc-stats-box">
            <h3 class="sc-stats-title">Đuôi ĐB Gan Nhất</h3>
            <div class="sc-tk-grid">
                @foreach($ganTail ?? [] as $digit => $gap)
                    <div class="sc-tk-item"><strong>{{ $digit }}</strong>: {{ $gap }}n</div>
                @endforeach
            </div>
        </div>
    </div>
</section>
