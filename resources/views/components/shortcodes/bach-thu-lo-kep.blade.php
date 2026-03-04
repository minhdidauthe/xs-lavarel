<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-gem"></i> Bạch Thủ Lô Kép Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        @if($bachKep)
        <div class="sc-btl-highlight">
            <div class="sc-btl-num-wrap">
                <span class="sc-btl-num red">{{ $bachKep }}</span>
            </div>
            <p class="sc-btl-label">Số kép may mắn Bạch Thủ Lô Kép hôm nay</p>
            @if(count($loKep) > 1)
            <div class="sc-kep-list">
                <span class="sc-kep-label">Dàn số kép:</span>
                @foreach(array_slice($loKep, 0, 6) as $k)
                <span class="sc-kep-badge {{ $loop->first ? 'active' : '' }}">{{ $k }}</span>
                @endforeach
            </div>
            @endif
        </div>
        @else
        <div class="sc-kep-all">
            <p class="sc-kep-label">Dàn số kép đầy đủ:</p>
            <div class="sc-kep-grid">
                @foreach(['00','11','22','33','44','55','66','77','88','99'] as $k)
                <span class="sc-kep-badge">{{ $k }}</span>
                @endforeach
            </div>
        </div>
        @endif
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Lưu ý: Con số chỉ dùng cho mục đích tham khảo. Chúc bạn may mắn!</em>
        </div>
    </div>
</section>
