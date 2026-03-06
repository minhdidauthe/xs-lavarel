<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-search-plus"></i> Số Cầu XSMB Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-stats-row">
            <div class="sc-stats-box">
                <h3 class="sc-stats-title red">Cầu Chính</h3>
                <div class="sc-btl-highlight">
                    <span class="sc-btl-num green">{{ $soiCauMB['bachThu'] ?? '?' }}</span>
                </div>
                <p style="text-align:center; color:#aaa; font-size:12px">Bạch Thủ Lô</p>
            </div>
            <div class="sc-stats-box">
                <h3 class="sc-stats-title blue">Số Cầu Bổ Sung</h3>
                <div class="sc-nums">
                    @foreach($soiCauMB['songThu'] ?? [] as $n)
                        <span class="sc-badge sc-badge-hot">{{ $n }}</span>
                    @endforeach
                    @foreach(array_keys(array_slice($freq, 0, 3, true)) as $n)
                        <span class="sc-badge">{{ str_pad($n, 2, '0', STR_PAD_LEFT) }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Chỉ mang tính tham khảo.</div>
    </div>
</section>
