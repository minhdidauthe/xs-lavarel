<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-wave-square"></i> Tần Suất Loto Đầy Đủ {{ $region }} — {{ $days }} Ngày</h2>
    <div class="sc-freq-grid">
        @foreach($freq as $num => $count)
        @php
            $max = max(array_values($freq));
            $pct = $max > 0 ? round($count / $max * 100) : 0;
            $cls = $pct >= 80 ? 'sc-badge-hot' : ($pct <= 30 ? 'sc-badge-cold' : '');
        @endphp
        <div class="sc-freq-item">
            <span class="sc-badge {{ $cls }}">{{ $num }}</span>
            <div class="sc-freq-bar" style="height:{{ $pct }}%" title="{{ $count }} lần"></div>
            <span class="sc-freq-count">{{ $count }}</span>
        </div>
        @endforeach
    </div>
</section>
