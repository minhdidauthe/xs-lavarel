<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-robot"></i> Dự Đoán XSMB Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        @if(!empty($predictionAI))
        <div style="margin:12px 0">
            <strong><i class="fas fa-microchip"></i> AI Dự Đoán:</strong>
            <div class="sc-nums" style="margin-top:8px">
                @foreach($predictionAI as $num)
                    <span class="sc-badge sc-badge-hot">{{ $num }}</span>
                @endforeach
            </div>
        </div>
        @endif
        <div style="margin:12px 0">
            <strong>Bạch Thủ:</strong>
            <span class="sc-btl-num green" style="font-size:1.6rem; font-weight:900; margin-left:10px">{{ $soiCauMB['bachThu'] ?? '?' }}</span>
        </div>
        <div style="margin:12px 0">
            <strong>Song Thủ:</strong>
            <div class="sc-nums" style="margin-top:8px">
                @foreach($soiCauMB['songThu'] ?? [] as $n)
                    <span class="sc-badge sc-badge-hot">{{ $n }}</span>
                @endforeach
            </div>
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Chỉ mang tính tham khảo.</div>
    </div>
</section>
