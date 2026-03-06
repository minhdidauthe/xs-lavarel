<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-crown"></i> Đọc Thủ Đề VIP Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-btl-highlight">
            <div class="sc-nums" style="justify-content:center">
                @forelse($docDe as $item)
                    <div style="text-align:center; margin:0 10px">
                        <span class="sc-btl-num green">{{ $item['so'] }}</span>
                        <div style="font-size:12px; color:#aaa; margin-top:4px">{{ $item['label'] ?? 'Đề VIP' }}</div>
                    </div>
                @empty
                    <p class="sc-no-data">Đang cập nhật...</p>
                @endforelse
            </div>
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Số đề chính xác 2 số cuối giải đặc biệt. Chỉ tham khảo.</div>
    </div>
</section>
