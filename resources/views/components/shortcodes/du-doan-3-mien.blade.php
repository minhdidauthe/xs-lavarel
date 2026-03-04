<div class="sc-d3m-wrap">
    @foreach($predictions as $code => $pred)
    <div class="sc-d3m-card">
        <div class="sc-d3m-header sc-d3m-{{ $pred['color'] }}">
            <span class="sc-d3m-region"><i class="fas fa-map-marker-alt"></i> {{ $pred['name'] }}</span>
            <span class="sc-d3m-time">
                <i class="fas fa-clock"></i> {{ $pred['draw'] }}
                @if($pred['updated'])
                <span class="sc-d3m-tag">✓ Mới</span>
                @endif
            </span>
        </div>
        <div class="sc-d3m-body">
            <div class="sc-d3m-row">
                <span class="sc-d3m-label">Bạch Thủ</span>
                <div class="sc-d3m-nums">
                    <span class="sc-d3m-main sc-d3m-{{ $pred['color'] }}">{{ $pred['bach_thu'] }}</span>
                    @if($pred['bach_mirror'])
                    <span class="sc-d3m-sep">↔</span>
                    <span class="sc-d3m-sub">{{ $pred['bach_mirror'] }}</span>
                    @endif
                </div>
            </div>
            <div class="sc-d3m-row">
                <span class="sc-d3m-label">Song Thủ</span>
                <div class="sc-d3m-nums">
                    @foreach($pred['song_thu'] as $n)
                    <span class="sc-d3m-num">{{ $n }}</span>
                    @if(!$loop->last)<span class="sc-d3m-sep">—</span>@endif
                    @endforeach
                </div>
            </div>
            <div class="sc-d3m-row">
                <span class="sc-d3m-label">Đề ĐB</span>
                <div class="sc-d3m-nums">
                    <span class="sc-d3m-num">{{ $pred['de'] }}</span>
                </div>
            </div>
            <div class="sc-d3m-row sc-d3m-row-last">
                <span class="sc-d3m-label">Dàn Lô</span>
                <div class="sc-d3m-dan">
                    @foreach($pred['dan'] as $n)
                    <span class="sc-d3m-badge">{{ $n }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="sc-soicau-note" style="margin:6px 0 0">
    <i class="fas fa-info-circle"></i> <em>Số cập nhật: MT lúc 17h — MN lúc 18h — MB lúc 19h. Chỉ mang tính tham khảo.</em>
</div>
