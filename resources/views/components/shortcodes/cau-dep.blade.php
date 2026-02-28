@if($cauDep)
<section class="container sc-section">
    <div class="sc-caudep-box">
        <h2 class="sc-caudep-title"><i class="fas fa-gem"></i> Cầu đẹp XSMB Hôm Nay</h2>

        <div class="sc-caudep-section">
            <p class="sc-caudep-label">Cầu lô tô đẹp nhất cho ngày {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}</p>
            <div class="sc-caudep-grid">
                @foreach($cauDep['loto'] as $pair)
                    <span class="sc-caudep-pair">{{ $pair }}</span>
                @endforeach
            </div>
        </div>

        <div class="sc-caudep-section">
            <p class="sc-caudep-label">Cầu loto 2 nháy (về 2 ngày liên tiếp) ngày {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}</p>
            <div class="sc-caudep-grid">
                @forelse($cauDep['nhay2'] as $num)
                    <span class="sc-caudep-pair">{{ $num }}</span>
                @empty
                    <span class="sc-caudep-pair" style="opacity:0.5">Không có số 2 nháy</span>
                @endforelse
            </div>
        </div>

        <div class="sc-caudep-section">
            <p class="sc-caudep-label">Cầu đặc biệt đẹp nhất ngày {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}</p>
            <div class="sc-caudep-grid">
                @foreach($cauDep['db'] as $pair)
                    <span class="sc-caudep-pair">{{ $pair }}</span>
                @endforeach
            </div>
        </div>

        <div class="sc-soicau-note">
            <em>"SOICAU7777" kết quả trên được hệ thống tự động tính toán theo một số liệu thu thập được dựa trên các kết quả trước. Các bạn nên tham khảo thêm các công cụ phân tích để tìm ra cặp số tốt nhất.</em>
        </div>
    </div>
</section>
@endif
