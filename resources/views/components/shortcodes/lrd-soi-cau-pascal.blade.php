<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-triangle"></i> Soi Cầu Pascal {{ $region }} — {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        @if($spStr)
        <div style="text-align:center; margin:8px 0; color:#aaa; font-size:13px;">
            Giải ĐB hôm qua: <span class="sc-badge sc-badge-hot">{{ $spStr }}</span>
        </div>
        @endif
        <div style="overflow-x:auto">
            <table class="sc-table" style="min-width:400px">
                <thead><tr><th colspan="10">Tam Giác Pascal</th></tr></thead>
                <tbody>
                    @foreach($pascal as $row)
                    <tr>
                        @foreach($row as $cell)
                        <td style="text-align:center">
                            <span class="sc-badge">{{ str_pad($cell % 100, 2, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:12px">
            <strong>Dự đoán hôm nay:</strong>
            <div class="sc-nums" style="margin-top:8px">
                @foreach($duDoan as $num)
                    <span class="sc-badge sc-badge-hot">{{ $num }}</span>
                @endforeach
            </div>
        </div>
        <div class="sc-soicau-note"><i class="fas fa-info-circle"></i> Soi cầu Pascal dựa trên giải ĐB ngày trước. Chỉ mang tính tham khảo.</div>
    </div>
</section>
