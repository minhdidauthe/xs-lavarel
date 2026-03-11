<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-star-half-alt"></i> Thống Kê Quan Trọng {{ $region }}
        </div>
        <div class="sc-stats-row">
            <div class="sc-stats-box">
                <h3 class="sc-stats-title red"><i class="fas fa-fire"></i> Lô Về Nhiều Nhất</h3>
                <div class="sc-nums" style="flex-wrap:wrap">
                    @foreach($frequency as $item)
                        <span class="sc-badge sc-badge-hot" title="{{ $item['count'] }} lần">{{ $item['number'] }} <small>({{ $item['count'] }})</small></span>
                    @endforeach
                </div>
            </div>
            <div class="sc-stats-box">
                <h3 class="sc-stats-title blue"><i class="fas fa-clock"></i> Lô Gan Lâu Nhất</h3>
                <div class="sc-nums" style="flex-wrap:wrap">
                    @foreach($waiting as $item)
                        <span class="sc-badge sc-badge-cold" title="{{ $item['days'] }} ngày">{{ $item['number'] }} <small>({{ $item['days'] }}n)</small></span>
                    @endforeach
                </div>
            </div>
            <div class="sc-stats-box">
                <h3 class="sc-stats-title"><i class="fas fa-arrow-up"></i> Đầu ĐB Gan Nhất</h3>
                <div class="sc-tk-grid">
                    @foreach(array_slice($ganHead, 0, 5, true) as $digit => $gap)
                        <div class="sc-tk-item"><span class="sc-badge sc-badge-cold">{{ $digit }}</span> : <strong>{{ $gap }}</strong> ngày</div>
                    @endforeach
                </div>
            </div>
            <div class="sc-stats-box">
                <h3 class="sc-stats-title"><i class="fas fa-arrow-down"></i> Đuôi ĐB Gan Nhất</h3>
                <div class="sc-tk-grid">
                    @foreach(array_slice($ganTail, 0, 5, true) as $digit => $gap)
                        <div class="sc-tk-item"><span class="sc-badge sc-badge-cold">{{ $digit }}</span> : <strong>{{ $gap }}</strong> ngày</div>
                    @endforeach
                </div>
            </div>
        </div>

        @if(!empty($predictionAI))
        <div style="margin-top:16px; padding:12px; background:#fff8e1; border-radius:8px; border:1px solid #ffe082">
            <strong><i class="fas fa-robot"></i> AI Dự Đoán:</strong>
            <div class="sc-nums" style="flex-wrap:wrap; margin-top:8px">
                @foreach($predictionAI as $num)
                    <span class="sc-badge sc-badge-hot">{{ $num }}</span>
                @endforeach
            </div>
        </div>
        @endif

        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Tổng hợp thống kê lô hay về, lô gan, đầu/đuôi ĐB gan nhất ({{ $region }}).</em>
        </div>
    </div>
</section>
