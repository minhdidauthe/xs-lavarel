<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-hourglass-half"></i> Lô Gan {{ $region }}
        @if($dai) — {{ $dai }} @endif
    </h2>
    @if($type === 'dropdown' && !empty($provinces))
    <div class="sc-filter-row">
        <form method="get">
            <select name="dai" class="sc-select" onchange="this.form.submit()">
                <option value="">-- Tất cả đài --</option>
                @foreach($provinces as $p)
                    <option value="{{ $p }}" {{ $dai === $p ? 'selected' : '' }}>{{ $p }}</option>
                @endforeach
            </select>
        </form>
    </div>
    @endif
    <div class="sc-grid-4">
        @forelse($loGan as $num => $days)
        <div class="sc-gan-item {{ $days >= 10 ? 'hot' : '' }}">
            <span class="sc-badge {{ $days >= 10 ? 'sc-badge-hot' : 'sc-badge-cold' }}">{{ $num }}</span>
            <span class="sc-gan-days">{{ $days }} ngày</span>
        </div>
        @empty
        <p class="sc-no-data">Không có dữ liệu lô gan.</p>
        @endforelse
    </div>
</section>
