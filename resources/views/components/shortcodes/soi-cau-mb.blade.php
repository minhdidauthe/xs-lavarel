@if($soiCauMB)
<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-star"></i> Soi Cầu Miền Bắc {{ now()->timezone('Asia/Ho_Chi_Minh')->locale('vi')->isoFormat('dddd') }} - {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}
        </div>
        <table class="sc-soicau-table">
            <tr>
                <td class="sc-sc-label"><i class="fas fa-circle-dot"></i> Bạch thủ lô :</td>
                <td class="sc-sc-value green"><strong>{{ $soiCauMB['bach_thu'] }}</strong></td>
            </tr>
            <tr>
                <td class="sc-sc-label"><i class="fas fa-circle-dot"></i> Song thủ lô :</td>
                <td class="sc-sc-value green"><strong>{{ $soiCauMB['song_thu'][0] }} - {{ $soiCauMB['song_thu'][1] }}</strong></td>
            </tr>
            <tr>
                <td class="sc-sc-label"><i class="fas fa-circle-dot"></i> Lô Xiên 2 đẹp :</td>
                <td class="sc-sc-value blue">
                    @foreach($soiCauMB['xien2'] as $pair)
                        <strong>({{ $pair[0] }}-{{ $pair[1] }})</strong>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="sc-sc-label"><i class="fas fa-circle-dot"></i> Lô kép đẹp :</td>
                <td class="sc-sc-value green"><strong>{{ implode(' - ', $soiCauMB['lo_kep'] ?: ['--']) }}</strong></td>
            </tr>
            <tr>
                <td class="sc-sc-label"><i class="fas fa-circle-dot"></i> Đặc biệt chạm :</td>
                <td class="sc-sc-value red"><strong>Đầu {{ $soiCauMB['db_cham_dau'] }} - Đuôi {{ $soiCauMB['db_cham_duoi'] }}</strong></td>
            </tr>
            <tr>
                <td class="sc-sc-label"><i class="fas fa-circle-dot"></i> Dàn 3 càng :</td>
                <td class="sc-sc-value green"><strong>{{ implode(' . ', $soiCauMB['dan_3cang']) }}</strong></td>
            </tr>
        </table>
        <div class="sc-soicau-note">
            <i class="fas fa-info-circle"></i> <em>Lưu ý: Các bộ số chỉ dùng cho mục đích tham khảo, bạn nên cân nhắc trước khi chơi. Chúc bạn may mắn!</em>
        </div>
    </div>
</section>
@endif
