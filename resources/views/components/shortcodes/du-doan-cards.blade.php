<section class="container sc-section">
    <h2 class="sc-section-title"><i class="fas fa-fire"></i> Dự Đoán Xổ Số Miền Bắc Hôm Nay</h2>
    <div class="sc-prediction-grid">
        <div class="sc-pred-card">
            <div class="sc-pred-header bg-red">
                <i class="fas fa-crown"></i> Soi Cầu Lô VIP
            </div>
            <div class="sc-pred-body">
                @if($predictionAI && count($predictionAI) >= 3)
                    <div class="sc-pred-numbers">
                        @foreach(array_slice($predictionAI, 0, 3) as $item)
                            <span class="sc-num-ball red">{{ $item['number'] }}</span>
                        @endforeach
                    </div>
                    <p class="sc-pred-note">Tỉ lệ trúng cao nhất hôm nay</p>
                @else
                    <p class="sc-pred-note">Đang phân tích dữ liệu...</p>
                @endif
                <a href="/soi-cau" class="sc-pred-btn">Xem chi tiết <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <div class="sc-pred-card">
            <div class="sc-pred-header bg-green">
                <i class="fas fa-gem"></i> Soi Cầu Đề VIP
            </div>
            <div class="sc-pred-body">
                @if($predictionAI && count($predictionAI) >= 6)
                    <div class="sc-pred-numbers">
                        @foreach(array_slice($predictionAI, 3, 3) as $item)
                            <span class="sc-num-ball green">{{ $item['number'] }}</span>
                        @endforeach
                    </div>
                    <p class="sc-pred-note">Dự đoán đề chuẩn xác</p>
                @else
                    <p class="sc-pred-note">Đang phân tích dữ liệu...</p>
                @endif
                <a href="/soi-cau" class="sc-pred-btn green">Xem chi tiết <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <div class="sc-pred-card">
            <div class="sc-pred-header bg-orange">
                <i class="fas fa-bullseye"></i> Nuôi Lô Khung
            </div>
            <div class="sc-pred-body">
                @if($predictionAI && count($predictionAI) >= 10)
                    <div class="sc-pred-numbers">
                        @foreach(array_slice($predictionAI, 6, 4) as $item)
                            <span class="sc-num-ball orange">{{ $item['number'] }}</span>
                        @endforeach
                    </div>
                    <p class="sc-pred-note">Dàn lô khung hôm nay</p>
                @else
                    <p class="sc-pred-note">Đang phân tích dữ liệu...</p>
                @endif
                <a href="/soi-cau" class="sc-pred-btn orange">Xem chi tiết <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>
