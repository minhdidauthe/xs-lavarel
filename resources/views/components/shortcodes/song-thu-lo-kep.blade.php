<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-gem"></i> Song Thủ Lô Kép Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        @if(count($songKep) > 0)
        <div class="sc-stl-wrap">
            @foreach($songKep as $k)
            <span class="sc-btl-num red">{{ $k }}</span>
            @if(!$loop->last)<span class="sc-stl-sep">—</span>@endif
            @endforeach
        </div>
        <p class="sc-btl-label">Hai số kép may mắn Song Thủ Lô Kép hôm nay</p>
        @if(count($loKep) > 2)
        <div class="sc-kep-list">
            <span class="sc-kep-label">Toàn bộ số kép hôm nay:</span>
            @foreach(array_slice($loKep, 0, 6) as $k)
            <span class="sc-kep-badge {{ $loop->index < 2 ? 'active' : '' }}">{{ $k }}</span>
            @endforeach
        </div>
        @endif
        @else
        <div class="sc-kep-all">
            <p class="sc-kep-label">Dàn số kép đầy đủ (chờ phân tích hôm nay):</p>
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
