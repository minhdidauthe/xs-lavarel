<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-layer-group"></i> Dàn Đề Hằng Ngày — {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-stats-row">
            @forelse($dande as $item)
            <div class="sc-stats-box">
                <h3 class="sc-stats-title">{{ $item['dan'] }}</h3>
                <div class="sc-nums">
                    @foreach($item['numbers'] as $n)
                        <span class="sc-badge">{{ $n }}</span>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="sc-stats-box">
                <h3 class="sc-stats-title red">Dàn {{ $count }} số hôm nay</h3>
                <div class="sc-nums">
                    @foreach($numbers as $n)
                        <span class="sc-badge sc-badge-hot">{{ $n }}</span>
                    @endforeach
                </div>
            </div>
            @endforelse
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Chỉ mang tính tham khảo.</div>
    </div>
</section>
