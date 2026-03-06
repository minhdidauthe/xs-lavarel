<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-bullseye"></i> Chốt Số XSMB Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-stats-row">
            <div class="sc-stats-box">
                <h3 class="sc-stats-title red">Bạch Thủ</h3>
                <div class="sc-btl-highlight">
                    <span class="sc-btl-num green">{{ $soiCauMB['bachThu'] ?? '?' }}</span>
                </div>
            </div>
            <div class="sc-stats-box">
                <h3 class="sc-stats-title blue">Song Thủ</h3>
                <div class="sc-nums">
                    @foreach($soiCauMB['songThu'] ?? [] as $n)
                        <span class="sc-badge sc-badge-hot">{{ $n }}</span>
                    @endforeach
                </div>
            </div>
            <div class="sc-stats-box">
                <h3 class="sc-stats-title">Top Lô Nóng</h3>
                <div class="sc-nums">
                    @foreach(array_slice($loTop, 0, 5) as $item)
                        <span class="sc-badge sc-badge-hot" title="{{ $item['count'] }} lần">{{ $item['so'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Chỉ mang tính tham khảo.</div>
    </div>
</section>
