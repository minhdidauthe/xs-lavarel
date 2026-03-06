<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-crown"></i> Đọc Thủ Lô Kép VIP Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-stats-row">
            <div class="sc-stats-box">
                <h3 class="sc-stats-title red">Lô Kép Đọc Thủ</h3>
                <div class="sc-nums" style="justify-content:center">
                    @forelse($docKep as $num)
                        <span class="sc-badge sc-badge-kep" style="font-size:1.2rem; width:42px; height:42px; line-height:42px">{{ $num }}</span>
                    @empty
                        <p class="sc-no-data">Đang cập nhật...</p>
                    @endforelse
                </div>
            </div>
            @if(!empty($loKep))
            <div class="sc-stats-box">
                <h3 class="sc-stats-title blue">Tất Cả Lô Kép (Thống Kê)</h3>
                <div class="sc-nums">
                    @foreach($loKep as $num => $count)
                        <span class="sc-badge sc-badge-kep" title="{{ $count }} lần">{{ $num }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Lô kép (00, 11, 22...99). Chỉ tham khảo.</div>
    </div>
</section>
