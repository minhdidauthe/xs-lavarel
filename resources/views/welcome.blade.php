@extends('layouts.app')

@section('title', 'SOICAU7777.CLICK - Soi Cầu Xổ Số 3 Miền - Kết Quả Xổ Số Hôm Nay')

@section('content')
    {{-- ====== WELCOME BANNER ====== --}}
    <section class="sc-welcome">
        <div class="container">
            <h1><i class="fas fa-star"></i> Soi Cầu 7777 - Dự Đoán Xổ Số Miễn Phí Hôm Nay</h1>
            <p>Chào mừng bạn đến với <strong>SOICAU7777.CLICK</strong> — trang soi cầu lô đề miễn phí chính xác nhất. Cập nhật KQXS 3 miền hàng ngày, dự đoán AI thông minh.</p>
            <div class="sc-welcome-date">
                <i class="fas fa-calendar-alt"></i>
                {{ now()->timezone('Asia/Ho_Chi_Minh')->locale('vi')->isoFormat('dddd, D [tháng] M, Y') }}
            </div>
        </div>
    </section>

    {{-- ====== BẢNG 1: SOI CẦU MIỀN BẮC ====== --}}
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

    {{-- ====== BẢNG 2: CẦU ĐẸP XSMB ====== --}}
    @if($cauDep)
    <section class="container sc-section">
        <div class="sc-caudep-box">
            <h2 class="sc-caudep-title"><i class="fas fa-gem"></i> Cầu đẹp XSMB Hôm Nay</h2>

            <div class="sc-caudep-section">
                <p class="sc-caudep-label">Cầu lô tô đẹp nhất cho ngày {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}</p>
                <div class="sc-caudep-grid">
                    @foreach($cauDep['loto'] as $pair)
                        <span class="sc-caudep-pair">{{ $pair }}</span>
                    @endforeach
                </div>
            </div>

            <div class="sc-caudep-section">
                <p class="sc-caudep-label">Cầu loto 2 nháy đẹp nhất ngày {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}</p>
                <div class="sc-caudep-grid">
                    @foreach($cauDep['nhay2'] as $pair)
                        <span class="sc-caudep-pair">{{ $pair }}</span>
                    @endforeach
                </div>
            </div>

            <div class="sc-caudep-section">
                <p class="sc-caudep-label">Cầu đặc biệt đẹp nhất ngày {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}</p>
                <div class="sc-caudep-grid">
                    @foreach($cauDep['db'] as $pair)
                        <span class="sc-caudep-pair">{{ $pair }}</span>
                    @endforeach
                </div>
            </div>

            <div class="sc-soicau-note">
                <em>"SOICAU7777" kết quả trên được hệ thống tự động tính toán theo một số liệu thu thập được dựa trên các kết quả trước. Các bạn nên tham khảo thêm các công cụ phân tích để tìm ra cặp số tốt nhất.</em>
            </div>
        </div>
    </section>
    @endif

    {{-- ====== BẢNG 3: LÔ TOP CHƠI NHIỀU ====== --}}
    @if(count($loTop ?? []) > 0)
    <section class="container sc-section">
        <div class="sc-lotop-box">
            <h2 class="sc-lotop-title"><i class="fas fa-trophy"></i> Bảng lô top chơi nhiều</h2>
            <div class="sc-lotop-tabs">
                <span class="sc-lotop-tab active">Hôm nay</span>
                <span class="sc-lotop-tab">Hôm qua</span>
                <span class="sc-lotop-tab">Hôm kia</span>
            </div>
            <p class="sc-lotop-date">Bảng lô top ngày {{ now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}</p>
            <div class="sc-lotop-numbers">
                @foreach($loTop as $num)
                    <span class="sc-lotop-num">{{ $num }}</span>
                @endforeach
            </div>
            <div style="text-align:center; margin-top:12px;">
                <a href="/thong-ke" class="sc-btn-more red">Xem đầy đủ <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>
    @endif

    {{-- ====== SOI CẦU CARDS ====== --}}
    <section class="container sc-section">
        <h2 class="sc-section-title"><i class="fas fa-fire"></i> Dự Đoán Xổ Số Miền Bắc Hôm Nay</h2>
        <div class="sc-prediction-grid">
            {{-- Card 1: Lô VIP --}}
            <div class="sc-pred-card">
                <div class="sc-pred-header bg-red">
                    <i class="fas fa-crown"></i> Soi Cầu Lô VIP
                </div>
                <div class="sc-pred-body">
                    @if($predictionAI && count($predictionAI) >= 3)
                        <div class="sc-pred-numbers">
                            @foreach(array_slice($predictionAI, 0, 3) as $item)
                                <span class="sc-num-ball red">{{ $item['number'] }}</span>
                            @endforeach
                        </div>
                        <p class="sc-pred-note">Tỉ lệ trúng cao nhất hôm nay</p>
                    @else
                        <p class="sc-pred-note">Đang phân tích dữ liệu...</p>
                    @endif
                    <a href="/soi-cau" class="sc-pred-btn">Xem chi tiết <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            {{-- Card 2: Đề VIP --}}
            <div class="sc-pred-card">
                <div class="sc-pred-header bg-green">
                    <i class="fas fa-gem"></i> Soi Cầu Đề VIP
                </div>
                <div class="sc-pred-body">
                    @if($predictionAI && count($predictionAI) >= 6)
                        <div class="sc-pred-numbers">
                            @foreach(array_slice($predictionAI, 3, 3) as $item)
                                <span class="sc-num-ball green">{{ $item['number'] }}</span>
                            @endforeach
                        </div>
                        <p class="sc-pred-note">Dự đoán đề chuẩn xác</p>
                    @else
                        <p class="sc-pred-note">Đang phân tích dữ liệu...</p>
                    @endif
                    <a href="/soi-cau" class="sc-pred-btn green">Xem chi tiết <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            {{-- Card 3: Nuôi Khung --}}
            <div class="sc-pred-card">
                <div class="sc-pred-header bg-orange">
                    <i class="fas fa-bullseye"></i> Nuôi Lô Khung
                </div>
                <div class="sc-pred-body">
                    @if($predictionAI && count($predictionAI) >= 10)
                        <div class="sc-pred-numbers">
                            @foreach(array_slice($predictionAI, 6, 4) as $item)
                                <span class="sc-num-ball orange">{{ $item['number'] }}</span>
                            @endforeach
                        </div>
                        <p class="sc-pred-note">Dàn lô nuôi 3 ngày</p>
                    @else
                        <p class="sc-pred-note">Đang phân tích dữ liệu...</p>
                    @endif
                    <a href="/soi-cau" class="sc-pred-btn orange">Xem chi tiết <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    {{-- ====== KẾT QUẢ XỔ SỐ MIỀN BẮC ====== --}}
    <section class="container sc-section">
        <div class="sc-kqxs-box">
            <div class="sc-kqxs-header">
                <div>
                    <i class="fas fa-trophy"></i>
                    <strong>Kết Quả Xổ Số Miền Bắc</strong>
                </div>
                <span>{{ $lotteryMB['date'] ?? now()->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y') }}</span>
            </div>

            @if($lotteryMB && isset($lotteryMB['prizes']))
            <table class="sc-kqxs-table">
                <tbody>
                    <tr class="sc-row-db">
                        <td class="sc-prize-label">ĐẶC BIỆT</td>
                        <td class="sc-prize-value sc-db">
                            @php
                                $sp = $lotteryMB['prizes']['special'] ?? ['-----'];
                                $spStr = is_array($sp) ? ($sp[0] ?? '-----') : $sp;
                            @endphp
                            {{ $spStr }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sc-prize-label">Giải Nhất</td>
                        <td class="sc-prize-value sc-g1">
                            {{ is_array($lotteryMB['prizes']['first'] ?? null) ? ($lotteryMB['prizes']['first'][0] ?? '-----') : ($lotteryMB['prizes']['first'] ?? '-----') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sc-prize-label">Giải Nhì</td>
                        <td class="sc-prize-value">
                            {{ implode('    ', array_map(fn($v) => is_array($v)?$v[0]:$v, (array)($lotteryMB['prizes']['second'] ?? ['-----','-----']))) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="sc-prize-label">Giải Ba</td>
                        <td class="sc-prize-value">
                            <div class="sc-nums-grid g6">
                                @foreach((array)($lotteryMB['prizes']['third'] ?? []) as $p)
                                    <span>{{ is_array($p)?$p[0]:$p }}</span>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="sc-prize-label">Giải Tư</td>
                        <td class="sc-prize-value">
                            <div class="sc-nums-grid g4">
                                @foreach((array)($lotteryMB['prizes']['fourth'] ?? []) as $p)
                                    <span>{{ is_array($p)?$p[0]:$p }}</span>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="sc-prize-label">Giải Năm</td>
                        <td class="sc-prize-value">
                            <div class="sc-nums-grid g6">
                                @foreach((array)($lotteryMB['prizes']['fifth'] ?? []) as $p)
                                    <span>{{ is_array($p)?$p[0]:$p }}</span>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="sc-prize-label">Giải Sáu</td>
                        <td class="sc-prize-value sc-g6">
                            <div class="sc-nums-grid g3">
                                @foreach((array)($lotteryMB['prizes']['sixth'] ?? []) as $p)
                                    <span>{{ is_array($p)?$p[0]:$p }}</span>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="sc-prize-label">Giải Bảy</td>
                        <td class="sc-prize-value sc-g7">
                            <div class="sc-nums-grid g4">
                                @foreach((array)($lotteryMB['prizes']['seventh'] ?? []) as $p)
                                    <span>{{ is_array($p)?$p[0]:$p }}</span>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            @else
            <div class="sc-kqxs-waiting">
                <i class="fas fa-sync-alt fa-spin"></i>
                <p>Đang chờ kết quả xổ số lúc 18:15...</p>
            </div>
            @endif

            <div class="sc-kqxs-footer">
                <a href="/lich-su/north">Xem lịch sử KQXS Miền Bắc <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        {{-- Bảng Đầu/Đuôi --}}
        @if(!empty($dauDuoiMB))
        <div class="sc-kqxs-box" style="margin-top: 16px;">
            <div class="sc-kqxs-header" style="background: linear-gradient(135deg, #1e3a5f 0%, #0f2b46 100%);">
                <div><i class="fas fa-table"></i> <strong>Bảng Lô Tô - Đầu Đuôi</strong></div>
                <span>{{ $lotteryMB['date'] ?? '' }}</span>
            </div>
            <table class="sc-dauduoi-table">
                <thead>
                    <tr>
                        <th class="sc-dd-head">Đầu</th>
                        <th class="sc-dd-tail">Đuôi</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i <= 9; $i++)
                    <tr>
                        <td class="sc-dd-head">{{ $i }}</td>
                        <td class="sc-dd-tail">
                            @foreach($dauDuoiMB[$i] ?? [] as $tail)
                                <span class="sc-dd-num">{{ $tail }}</span>
                            @endforeach
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        @endif
    </section>

    {{-- ====== THỐNG KÊ NHANH XSMB ====== --}}
    <section class="container sc-section">
        <div class="sc-tk-box">
            <div class="sc-tk-header">
                <i class="fas fa-chart-line"></i> Thống Kê Nhanh Xổ Số Miền Bắc Hôm Nay
            </div>

            {{-- 10 bộ loto về nhiều nhất --}}
            <div class="sc-tk-section">
                <div class="sc-tk-label">10 bộ số loto về <strong class="sc-red">nhiều</strong> nhất trong 30 lần quay</div>
                <div class="sc-tk-grid">
                    @foreach($frequency as $item)
                        <div class="sc-tk-item"><strong>{{ $item['number'] }}</strong>: {{ $item['count'] }} lần</div>
                    @endforeach
                </div>
            </div>

            {{-- Giải ĐB về nhiều nhất --}}
            <div class="sc-tk-section">
                <div class="sc-tk-label">Giải đặc biệt về <strong class="sc-red">nhiều</strong> nhất trong 30 lần quay</div>
                <div class="sc-tk-grid">
                    @foreach($frequencyDB ?? [] as $item)
                        <div class="sc-tk-item"><strong>{{ $item['number'] }}</strong>: {{ $item['count'] }} lần</div>
                    @endforeach
                </div>
            </div>

            {{-- Bộ số loto gan --}}
            <div class="sc-tk-section">
                <div class="sc-tk-label">Bộ số <strong class="sc-red">loto gan</strong> lâu chưa ra</div>
                <div class="sc-tk-grid">
                    @foreach($waiting as $item)
                        <div class="sc-tk-item"><strong>{{ $item['number'] }}</strong>: {{ $item['days'] }} ngày</div>
                    @endforeach
                </div>
            </div>

            {{-- Đầu ĐB lâu chưa về --}}
            <div class="sc-tk-section">
                <div class="sc-tk-label"><strong class="sc-red">Đầu</strong> đặc biệt miền Bắc lâu chưa về nhất</div>
                <div class="sc-tk-grid">
                    @foreach($ganHead ?? [] as $digit => $gap)
                        <div class="sc-tk-item"><strong>{{ $digit }}</strong>: {{ $gap }} lần</div>
                    @endforeach
                </div>
            </div>

            {{-- Đuôi ĐB lâu chưa về --}}
            <div class="sc-tk-section">
                <div class="sc-tk-label"><strong class="sc-red">Đuôi</strong> đặc biệt miền Bắc lâu chưa về</div>
                <div class="sc-tk-grid">
                    @foreach($ganTail ?? [] as $digit => $gap)
                        <div class="sc-tk-item"><strong>{{ $digit }}</strong>: {{ $gap }} lần</div>
                    @endforeach
                </div>
            </div>

            {{-- Tổng ĐB lâu chưa về --}}
            <div class="sc-tk-section">
                <div class="sc-tk-label"><strong class="sc-red">Tổng</strong> đặc biệt miền Bắc lâu chưa về</div>
                <div class="sc-tk-grid">
                    @foreach($ganSum ?? [] as $digit => $gap)
                        <div class="sc-tk-item"><strong>{{ $digit }}</strong>: {{ $gap }} lần</div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ====== KẾT QUẢ XỔ SỐ MIỀN NAM ====== --}}
    <section class="container sc-section">
        <div class="sc-kqxs-box">
            <div class="sc-kqxs-header orange">
                <div><i class="fas fa-map-marker-alt"></i> <strong>Kết Quả Xổ Số Miền Nam</strong></div>
                <span>{{ $allMN[0]['date'] ?? '16:15' }}</span>
            </div>
            @if(count($allMN ?? []) > 0)
            <div class="sc-region-provinces">
                <table class="sc-kqxs-table sc-multi-province">
                    <thead>
                        <tr>
                            <th class="sc-prize-label">Giải</th>
                            @foreach($allMN as $prov)
                                <th class="sc-province-name">{{ $prov['province'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $prizeKeys = [
                                'eighth' => 'G8',
                                'seventh' => 'G7',
                                'sixth' => 'G6',
                                'fifth' => 'G5',
                                'fourth' => 'G4',
                                'third' => 'G3',
                                'second' => 'G2',
                                'first' => 'G1',
                                'special' => 'ĐB',
                            ];
                        @endphp
                        @foreach($prizeKeys as $key => $label)
                        <tr class="{{ $key === 'special' ? 'sc-row-db' : '' }}">
                            <td class="sc-prize-label">{{ $label }}</td>
                            @foreach($allMN as $prov)
                                <td class="sc-prize-value {{ $key === 'special' ? 'sc-db' : '' }}">
                                    @php
                                        $val = $prov['prizes'][$key] ?? [];
                                        if (!is_array($val)) $val = [$val];
                                    @endphp
                                    @foreach($val as $v)
                                        <span>{{ is_array($v) ? $v[0] : $v }}</span>
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="sc-kqxs-footer"><a href="/lich-su/south">Xem lịch sử KQXS Miền Nam <i class="fas fa-arrow-right"></i></a></div>
            @else
            <div class="sc-kqxs-waiting sm"><i class="fas fa-clock"></i> Đang chờ kết quả lúc 16:15...</div>
            @endif
        </div>
    </section>

    {{-- ====== KẾT QUẢ XỔ SỐ MIỀN TRUNG ====== --}}
    <section class="container sc-section">
        <div class="sc-kqxs-box">
            <div class="sc-kqxs-header blue">
                <div><i class="fas fa-map-marker-alt"></i> <strong>Kết Quả Xổ Số Miền Trung</strong></div>
                <span>{{ $allMT[0]['date'] ?? '17:15' }}</span>
            </div>
            @if(count($allMT ?? []) > 0)
            <div class="sc-region-provinces">
                <table class="sc-kqxs-table sc-multi-province">
                    <thead>
                        <tr>
                            <th class="sc-prize-label">Giải</th>
                            @foreach($allMT as $prov)
                                <th class="sc-province-name">{{ $prov['province'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prizeKeys as $key => $label)
                        <tr class="{{ $key === 'special' ? 'sc-row-db' : '' }}">
                            <td class="sc-prize-label">{{ $label }}</td>
                            @foreach($allMT as $prov)
                                <td class="sc-prize-value {{ $key === 'special' ? 'sc-db' : '' }}">
                                    @php
                                        $val = $prov['prizes'][$key] ?? [];
                                        if (!is_array($val)) $val = [$val];
                                    @endphp
                                    @foreach($val as $v)
                                        <span>{{ is_array($v) ? $v[0] : $v }}</span>
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="sc-kqxs-footer"><a href="/lich-su/central">Xem lịch sử KQXS Miền Trung <i class="fas fa-arrow-right"></i></a></div>
            @else
            <div class="sc-kqxs-waiting sm"><i class="fas fa-clock"></i> Đang chờ kết quả lúc 17:15...</div>
            @endif
        </div>
    </section>

    {{-- ====== THỐNG KÊ NHANH ====== --}}
    <section class="container sc-section">
        <h2 class="sc-section-title"><i class="fas fa-chart-bar"></i> Thống Kê Lô Đề Miền Bắc</h2>
        <div class="sc-stats-row">
            {{-- Lô về nhiều --}}
            <div class="sc-stats-box">
                <h3 class="sc-stats-title red"><i class="fas fa-fire-alt"></i> 10 Lô Về Nhiều Nhất (30 ngày)</h3>
                <table class="sc-stats-table">
                    <thead><tr><th>Số</th><th>Số lần</th></tr></thead>
                    <tbody>
                        @forelse($frequency ?? [] as $item)
                        <tr>
                            <td><span class="sc-num-badge red">{{ $item['number'] }}</span></td>
                            <td>{{ $item['count'] }} lần</td>
                        </tr>
                        @empty
                        <tr><td colspan="2">Chưa có dữ liệu</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Lô gan --}}
            <div class="sc-stats-box">
                <h3 class="sc-stats-title blue"><i class="fas fa-hourglass-half"></i> 10 Lô Gan Lâu Chưa Về</h3>
                <table class="sc-stats-table">
                    <thead><tr><th>Số</th><th>Gan</th></tr></thead>
                    <tbody>
                        @forelse($waiting ?? [] as $item)
                        <tr>
                            <td><span class="sc-num-badge blue">{{ $item['number'] }}</span></td>
                            <td>{{ $item['days'] }} ngày</td>
                        </tr>
                        @empty
                        <tr><td colspan="2">Chưa có dữ liệu</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div style="text-align:center; margin-top:16px;">
            <a href="/thong-ke" class="sc-btn-more">Xem thống kê đầy đủ <i class="fas fa-arrow-right"></i></a>
        </div>
    </section>

    {{-- ====== BÀI VIẾT MỚI ====== --}}
    @if(isset($latestPosts) && $latestPosts->count() > 0)
    <section class="container sc-section">
        <h2 class="sc-section-title"><i class="fas fa-newspaper"></i> Kinh Nghiệm Lô Đề - Bài Viết Mới</h2>
        <div class="sc-blog-grid">
            @foreach($latestPosts as $post)
            <a href="/blog/{{ $post->slug }}" class="sc-blog-card">
                @if($post->featured_image)
                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="sc-blog-img">
                @else
                    <div class="sc-blog-img-placeholder"><i class="fas fa-image"></i></div>
                @endif
                <div class="sc-blog-info">
                    @if($post->category)
                        <span class="sc-blog-cat">{{ $post->category->name }}</span>
                    @endif
                    <h3>{{ $post->title }}</h3>
                    <p>{{ Str::limit($post->excerpt ?? strip_tags($post->content), 80) }}</p>
                    <span class="sc-blog-date"><i class="fas fa-clock"></i> {{ $post->published_at?->format('d/m/Y') }}</span>
                </div>
            </a>
            @endforeach
        </div>
        <div style="text-align:center; margin-top:16px;">
            <a href="/blog" class="sc-btn-more">Xem tất cả bài viết <i class="fas fa-arrow-right"></i></a>
        </div>
    </section>
    @endif
@endsection
