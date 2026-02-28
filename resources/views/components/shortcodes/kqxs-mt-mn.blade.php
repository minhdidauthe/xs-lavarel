<section class="container sc-section">
    <div class="sc-kqxs-row">
        <div class="sc-kqxs-box sc-kqxs-half">
            <div class="sc-kqxs-header blue">
                <div><i class="fas fa-map-marker-alt"></i> <strong>XS Miền Trung</strong></div>
                <span>{{ $lotteryMT['date'] ?? '17:15' }}</span>
            </div>
            @if(isset($lotteryMT) && $lotteryMT && isset($lotteryMT['prizes']))
            <table class="sc-kqxs-table compact">
                <tbody>
                    <tr class="sc-row-db">
                        <td class="sc-prize-label">ĐB</td>
                        <td class="sc-prize-value sc-db">
                            @php $mt_sp = $lotteryMT['prizes']['special'] ?? []; $mt_sp = is_array($mt_sp) ? ($mt_sp[0] ?? '-----') : $mt_sp; @endphp
                            {{ $mt_sp }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sc-prize-label">G1</td>
                        <td class="sc-prize-value">
                            @php $mt_1 = $lotteryMT['prizes']['first'] ?? []; $mt_1 = is_array($mt_1) ? ($mt_1[0] ?? '-----') : $mt_1; @endphp
                            {{ $mt_1 }}
                        </td>
                    </tr>
                    @if(!empty($lotteryMT['prizes']['second']))
                    <tr>
                        <td class="sc-prize-label">G2</td>
                        <td class="sc-prize-value">{{ is_array($lotteryMT['prizes']['second']) ? implode('  ', $lotteryMT['prizes']['second']) : $lotteryMT['prizes']['second'] }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="sc-kqxs-footer"><a href="/lich-su/central">Xem đầy đủ <i class="fas fa-arrow-right"></i></a></div>
            @else
            <div class="sc-kqxs-waiting sm"><i class="fas fa-clock"></i> Đang chờ kết quả lúc 17:15...</div>
            @endif
        </div>

        <div class="sc-kqxs-box sc-kqxs-half">
            <div class="sc-kqxs-header orange">
                <div><i class="fas fa-map-marker-alt"></i> <strong>XS Miền Nam</strong></div>
                <span>{{ $lotteryMN['date'] ?? '16:15' }}</span>
            </div>
            @if(isset($lotteryMN) && $lotteryMN && isset($lotteryMN['prizes']))
            <table class="sc-kqxs-table compact">
                <tbody>
                    <tr class="sc-row-db">
                        <td class="sc-prize-label">ĐB</td>
                        <td class="sc-prize-value sc-db">
                            @php $mn_sp = $lotteryMN['prizes']['special'] ?? []; $mn_sp = is_array($mn_sp) ? ($mn_sp[0] ?? '-----') : $mn_sp; @endphp
                            {{ $mn_sp }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sc-prize-label">G1</td>
                        <td class="sc-prize-value">
                            @php $mn_1 = $lotteryMN['prizes']['first'] ?? []; $mn_1 = is_array($mn_1) ? ($mn_1[0] ?? '-----') : $mn_1; @endphp
                            {{ $mn_1 }}
                        </td>
                    </tr>
                    @if(!empty($lotteryMN['prizes']['second']))
                    <tr>
                        <td class="sc-prize-label">G2</td>
                        <td class="sc-prize-value">{{ is_array($lotteryMN['prizes']['second']) ? implode('  ', $lotteryMN['prizes']['second']) : $lotteryMN['prizes']['second'] }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="sc-kqxs-footer"><a href="/lich-su/south">Xem đầy đủ <i class="fas fa-arrow-right"></i></a></div>
            @else
            <div class="sc-kqxs-waiting sm"><i class="fas fa-clock"></i> Đang chờ kết quả lúc 16:15...</div>
            @endif
        </div>
    </div>
</section>
