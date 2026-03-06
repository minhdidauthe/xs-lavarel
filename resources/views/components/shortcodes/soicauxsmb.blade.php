<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-eye"></i> Soi Cầu XSMB Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-stats-row">
            <div class="sc-stats-box">
                <h3 class="sc-stats-title red">Bạch Thủ / Song Thủ</h3>
                <div class="sc-nums">
                    <span class="sc-badge sc-badge-hot" title="Bạch thủ">{{ $soiCauMB['bachThu'] ?? '?' }}</span>
                    @foreach($soiCauMB['songThu'] ?? [] as $n)
                        <span class="sc-badge" title="Song thủ">{{ $n }}</span>
                    @endforeach
                </div>
            </div>
            <div class="sc-stats-box">
                <h3 class="sc-stats-title blue">Xiên 2 / Xiên 3</h3>
                <div class="sc-tk-grid">
                    @foreach($soiCauMB['xienHai'] ?? [] as $pair)
                        <div class="sc-tk-item">{{ is_array($pair) ? implode('-',$pair) : $pair }}</div>
                    @endforeach
                </div>
            </div>
            <div class="sc-stats-box">
                <h3 class="sc-stats-title">Cầu Loto Đẹp</h3>
                <div class="sc-nums">
                    @foreach($cauDep['lotoCau'] ?? [] as $pair)
                        @foreach((array)$pair as $n)
                            <span class="sc-badge sc-badge-kep">{{ $n }}</span>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Chỉ mang tính tham khảo.</div>
    </div>
</section>
