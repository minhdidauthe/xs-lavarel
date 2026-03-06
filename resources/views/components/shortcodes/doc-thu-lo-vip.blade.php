<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-crown"></i> Đọc Thủ Lô VIP Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-stats-row">
            <div class="sc-stats-box">
                <h3 class="sc-stats-title red">Số Đọc Thủ</h3>
                <div class="sc-nums" style="justify-content:center">
                    @forelse($docThu as $item)
                        <div style="text-align:center; margin:0 8px">
                            <span class="sc-badge sc-badge-hot" style="font-size:1.3rem; width:44px; height:44px; line-height:44px">{{ $item['so'] }}</span>
                            <div style="font-size:11px; color:#aaa; margin-top:4px">{{ $item['label'] ?? '' }}</div>
                        </div>
                    @empty
                        <p class="sc-no-data">Đang cập nhật...</p>
                    @endforelse
                </div>
            </div>
            @if(!empty($topLo))
            <div class="sc-stats-box">
                <h3 class="sc-stats-title blue">Hỗ Trợ — Lô Nóng</h3>
                <div class="sc-nums">
                    @foreach(array_slice($topLo, 0, 5) as $item)
                        <span class="sc-badge" title="{{ $item['count'] ?? '' }} lần">{{ $item['so'] }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Chỉ mang tính tham khảo.</div>
    </div>
</section>
