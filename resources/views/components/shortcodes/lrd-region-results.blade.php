<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-map-marker-alt"></i> KQXS {{ $region }} — {{ $limit }} Kỳ Gần Nhất</h2>
    @forelse($results as $r)
    <div class="sc-kqxs-item">
        <div class="sc-kqxs-date">
            <strong>{{ $r->province }}</strong> — {{ $r->date->format('d/m/Y') }}
        </div>
        <div class="sc-kqxs-db">
            ĐB: <span class="sc-badge sc-badge-hot">{{ $r->prizes['special'] ?? '---' }}</span>
        </div>
        <div class="sc-nums">
            @foreach(array_slice($r->numbers ?? [], 0, 18) as $num)
                <span class="sc-badge">{{ str_pad(substr($num,-2),2,'0',STR_PAD_LEFT) }}</span>
            @endforeach
        </div>
    </div>
    @empty
    <p class="sc-no-data">Chưa có dữ liệu.</p>
    @endforelse
</section>
