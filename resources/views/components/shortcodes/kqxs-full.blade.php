<section class="container sc-section">
    <div class="sc-kqxs-box">
        <div class="sc-kqxs-header">
            <div>
                <i class="fas fa-trophy"></i>
                <strong>Kết Quả Xổ Số {{ $region === 'MB' ? 'Miền Bắc' : ($region === 'MT' ? 'Miền Trung' : 'Miền Nam') }}</strong>
            </div>
            <span>{{ $lottery['date'] ?? now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}</span>
        </div>

        @if($lottery && isset($lottery['prizes']))
        <table class="sc-kqxs-table">
            <tbody>
                <tr class="sc-row-db">
                    <td class="sc-prize-label">ĐẶC BIỆT</td>
                    <td class="sc-prize-value sc-db">
                        @php
                            $sp = $lottery['prizes']['special'] ?? ['-----'];
                            $spStr = is_array($sp) ? ($sp[0] ?? '-----') : $sp;
                        @endphp
                        {{ $spStr }}
                    </td>
                </tr>
                <tr>
                    <td class="sc-prize-label">Giải Nhất</td>
                    <td class="sc-prize-value sc-g1">
                        {{ is_array($lottery['prizes']['first'] ?? null) ? ($lottery['prizes']['first'][0] ?? '-----') : ($lottery['prizes']['first'] ?? '-----') }}
                    </td>
                </tr>
                <tr>
                    <td class="sc-prize-label">Giải Nhì</td>
                    <td class="sc-prize-value">
                        {{ implode('    ', array_map(fn($v) => is_array($v)?$v[0]:$v, (array)($lottery['prizes']['second'] ?? ['-----','-----']))) }}
                    </td>
                </tr>
                <tr>
                    <td class="sc-prize-label">Giải Ba</td>
                    <td class="sc-prize-value">
                        <div class="sc-nums-grid g6">
                            @foreach((array)($lottery['prizes']['third'] ?? []) as $p)
                                <span>{{ is_array($p)?$p[0]:$p }}</span>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sc-prize-label">Giải Tư</td>
                    <td class="sc-prize-value">
                        <div class="sc-nums-grid g4">
                            @foreach((array)($lottery['prizes']['fourth'] ?? []) as $p)
                                <span>{{ is_array($p)?$p[0]:$p }}</span>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sc-prize-label">Giải Năm</td>
                    <td class="sc-prize-value">
                        <div class="sc-nums-grid g6">
                            @foreach((array)($lottery['prizes']['fifth'] ?? []) as $p)
                                <span>{{ is_array($p)?$p[0]:$p }}</span>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sc-prize-label">Giải Sáu</td>
                    <td class="sc-prize-value sc-g6">
                        <div class="sc-nums-grid g3">
                            @foreach((array)($lottery['prizes']['sixth'] ?? []) as $p)
                                <span>{{ is_array($p)?$p[0]:$p }}</span>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="sc-prize-label">Giải Bảy</td>
                    <td class="sc-prize-value sc-g7">
                        <div class="sc-nums-grid g4">
                            @foreach((array)($lottery['prizes']['seventh'] ?? []) as $p)
                                <span>{{ is_array($p)?$p[0]:$p }}</span>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @if(!empty($lottery['prizes']['eighth']))
                <tr>
                    <td class="sc-prize-label">Giải Tám</td>
                    <td class="sc-prize-value sc-g8">
                        <div class="sc-nums-grid g4">
                            @foreach((array)($lottery['prizes']['eighth']) as $p)
                                <span>{{ is_array($p)?$p[0]:$p }}</span>
                            @endforeach
                        </div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        @else
        <div class="sc-kqxs-waiting">
            <i class="fas fa-sync-alt fa-spin"></i>
            <p>Đang chờ kết quả xổ số lúc 18:15...</p>
        </div>
        @endif

        <div class="sc-kqxs-footer">
            <a href="/lich-su/{{ $region === 'MB' ? 'north' : ($region === 'MT' ? 'central' : 'south') }}">Xem lịch sử KQXS {{ $region === 'MB' ? 'Miền Bắc' : ($region === 'MT' ? 'Miền Trung' : 'Miền Nam') }} <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>
