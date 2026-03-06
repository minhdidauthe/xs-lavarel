<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-star"></i> Cầu Đẹp Hằng Ngày {{ $regionName ?? $region }} — {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-stats-row">
            <div class="sc-stats-box">
                <h3 class="sc-stats-title red"><i class="fas fa-fire-alt"></i> Cầu Loto Hot</h3>
                <div class="sc-nums">
                    @foreach($cauLoto as $pair)
                        @foreach($pair as $n)
                            <span class="sc-badge sc-badge-hot">{{ $n }}</span>
                        @endforeach
                    @endforeach
                </div>
            </div>
            <div class="sc-stats-box">
                <h3 class="sc-stats-title yellow"><i class="fas fa-equals"></i> Lô Kép Nên Chơi</h3>
                <div class="sc-nums">
                    @foreach($cauKep as $k)
                        <span class="sc-badge sc-badge-kep">{{ $k }}</span>
                    @endforeach
                </div>
            </div>
            <div class="sc-stats-box">
                <h3 class="sc-stats-title blue"><i class="fas fa-sigma"></i> Tổng ĐB Hay Về</h3>
                <div class="sc-nums">
                    @foreach($cauTong as $t)
                        <span class="sc-badge">{{ $t }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Chỉ mang tính tham khảo, chúc may mắn!</div>
    </div>
</section>
