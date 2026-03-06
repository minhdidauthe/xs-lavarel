<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-trophy"></i> Cao Thủ Mở Bát — {{ ucfirst($type ?? 'lô') }} Hôm Nay {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <div class="sc-nums" style="justify-content:center; margin:16px 0">
            @forelse($caoThu as $item)
                <div style="text-align:center; margin:0 8px">
                    <span class="sc-badge sc-badge-hot" style="font-size:1.4rem; width:48px; height:48px; line-height:48px">
                        {{ $item['so'] }}
                    </span>
                    <div style="font-size:11px; color:#aaa; margin-top:4px">{{ $item['label'] ?? '#'.$loop->iteration }}</div>
                </div>
            @empty
                <p class="sc-no-data">Đang cập nhật...</p>
            @endforelse
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Dự đoán theo thống kê. Chỉ mang tính tham khảo.</div>
    </div>
</section>
