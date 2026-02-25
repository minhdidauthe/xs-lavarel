@extends('layouts.app')

@section('title', 'Quay Thử Xổ Số Miền Bắc - SOICAU7777.CLICK')

@section('styles')
<style>
    /* ─── QUAY THỬ PAGE STYLES ─── */
    .qt-card {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.07);
        border-radius: 16px;
        overflow: hidden;
    }
    .qt-card-header {
        background: linear-gradient(135deg, #C30000 0%, #FF3D3D 100%);
        color: #fff;
        text-align: center;
        font-size: 13px;
        font-weight: 700;
        padding: 12px 18px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    /* ─── DAY TABS ─── */
    .day-tab {
        border: 1px solid rgba(255,255,255,0.12);
        background: rgba(255,255,255,0.04);
        padding: 5px 14px;
        font-size: 12px;
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.15s;
        color: #aaa;
        white-space: nowrap;
    }
    .day-tab:hover { border-color: #FF3D3D; color: #FF3D3D; }
    .day-tab.active { background: linear-gradient(135deg, #C30000, #FF3D3D); color: #fff; border-color: transparent; }

    /* ─── RESULT TABLE ─── */
    .result-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .result-table td {
        border: 1px solid rgba(255,255,255,0.06);
        padding: 8px 10px;
        vertical-align: middle;
        text-align: center;
    }
    .prize-label {
        background: rgba(255,255,255,0.04);
        font-weight: 700;
        color: #888;
        width: 48px;
        font-size: 12px;
        text-align: center;
    }
    .result-row-alt { background: rgba(255,255,255,0.015); }
    .result-row-white { background: transparent; }

    .num-cell {
        font-weight: 800;
        font-size: 18px;
        color: #f0f0f0;
        letter-spacing: 1.5px;
        display: inline-block;
        text-align: center;
    }
    .db-cell .num-cell {
        font-size: 28px;
        background: linear-gradient(135deg, #FF3D3D, #FF8A00);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* ─── SPINNER ─── */
    .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2.5px solid rgba(74,222,128,0.6);
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
        vertical-align: middle;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    @keyframes rollIn {
        0%   { opacity: 0; transform: translateY(-6px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .num-revealed { animation: rollIn 0.2s ease-out; }

    /* ─── MAIN BUTTON ─── */
    #btnQuay {
        background: linear-gradient(135deg, #C30000, #FF3D3D);
        color: #fff;
        border: none;
        padding: 11px 40px;
        font-size: 14px;
        font-weight: 800;
        border-radius: 999px;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        transition: all 0.2s;
        box-shadow: 0 4px 20px rgba(255,61,61,0.35);
    }
    #btnQuay:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 6px 28px rgba(255,61,61,0.5);
    }
    #btnQuay:disabled {
        background: rgba(255,255,255,0.08);
        color: #666;
        box-shadow: none;
        cursor: not-allowed;
        transform: none;
    }

    /* ─── VIEW OPTIONS ─── */
    .view-options { display: flex; gap: 18px; align-items: center; flex-wrap: wrap; }
    .view-options label {
        display: flex; align-items: center; gap: 6px;
        cursor: pointer; font-size: 13px; color: #aaa;
    }
    .view-options input[type="radio"] { accent-color: #FF3D3D; cursor: pointer; }

    /* ─── LÔ TÔ ─── */
    .loto-head-row { display: flex; }
    .loto-head-cell {
        flex: 1;
        background: rgba(255,248,220,0.05);
        border: 1px solid rgba(255,255,255,0.06);
        padding: 7px;
        font-size: 12px;
        text-align: center;
        font-weight: 700;
        color: #aaa;
    }
    .loto-section-title {
        background: rgba(255,232,128,0.07);
        text-align: center;
        font-weight: 700;
        color: #aaa;
        padding: 7px;
        border: 1px solid rgba(255,255,255,0.06);
        font-size: 12px;
    }
    .loto-grid-table { width: 100%; border-collapse: collapse; }
    .loto-grid-table td {
        border: 1px solid rgba(255,255,255,0.06);
        padding: 6px 8px;
        font-size: 12px;
        text-align: center;
        vertical-align: top;
    }
    .loto-prefix {
        font-weight: 700;
        background: rgba(255,255,255,0.04);
        color: #888;
        width: 28px;
    }
    .loto-numbers { text-align: left; color: #ddd; font-weight: 600; }
    .loto-numbers span { display: inline-block; margin: 1px 4px; }

    /* ─── SIDEBAR ─── */
    .sidebar-box { margin-bottom: 14px; }
    .sidebar-box .qt-card-header { font-size: 12px; border-radius: 12px 12px 0 0; }
    .sidebar-box ul { list-style: none; padding: 10px 14px; }
    .sidebar-box ul li { margin-bottom: 4px; }
    .sidebar-box ul li a {
        color: #60a5fa;
        text-decoration: none;
        font-size: 13px;
        line-height: 1.9;
        transition: color 0.15s;
    }
    .sidebar-box ul li::before { content: "› "; color: #555; }
    .sidebar-box ul li a:hover { color: #FF3D3D; }

    /* ─── DATETIME ─── */
    .qt-datetime {
        font-size: 13px;
        color: #888;
        text-align: right;
        font-weight: 400;
    }
</style>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- Page heading --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-6">
        <div>
            <h1 class="text-xl font-black uppercase tracking-tight">
                <span class="text-gradient">Quay Thử</span>
                <span class="text-white"> Xổ Số</span>
            </h1>
            <p class="text-gray-500 text-xs mt-1">Mô phỏng kết quả xổ số miền Bắc ngẫu nhiên</p>
        </div>
        <div class="qt-datetime" id="datetime"></div>
    </div>

    <div class="flex flex-col lg:flex-row gap-5 items-start">

        {{-- ═══ MAIN CARD ═══ --}}
        <div class="flex-1 min-w-0">
            <div class="qt-card">
                <div class="qt-card-header">Quay Thử Xổ Số Miền Bắc Hôm Nay</div>

                {{-- Controls --}}
                <div class="p-5 text-center space-y-4">
                    <button id="btnQuay" onclick="startSpin()">Bắt Đầu Quay</button>

                    {{-- Day tabs --}}
                    <div class="flex flex-wrap gap-2 justify-center pt-1">
                        <div class="day-tab active" onclick="selectDay(this,'mb')">Miền Bắc</div>
                        <div class="day-tab" onclick="selectDay(this,'t2')">Thứ 2</div>
                        <div class="day-tab" onclick="selectDay(this,'t3')">Thứ 3</div>
                        <div class="day-tab" onclick="selectDay(this,'t4')">Thứ 4</div>
                        <div class="day-tab" onclick="selectDay(this,'t5')">Thứ 5</div>
                        <div class="day-tab" onclick="selectDay(this,'t6')">Thứ 6</div>
                        <div class="day-tab" onclick="selectDay(this,'t7')">Thứ 7</div>
                        <div class="day-tab" onclick="selectDay(this,'cn')">Chủ Nhật</div>
                    </div>
                </div>

                {{-- Result Table --}}
                <div class="overflow-x-auto">
                    <table class="result-table" id="resultTable">
                        <tbody>
                            {{-- ĐB --}}
                            <tr class="result-row-white">
                                <td class="prize-label">ĐB</td>
                                <td class="db-cell" colspan="6">
                                    <span class="cell-content" data-prize="db"><span class="spinner"></span></span>
                                </td>
                            </tr>
                            {{-- G1 --}}
                            <tr class="result-row-alt">
                                <td class="prize-label">G1</td>
                                <td colspan="6">
                                    <span class="cell-content" data-prize="g1"><span class="spinner"></span></span>
                                </td>
                            </tr>
                            {{-- G2 --}}
                            <tr class="result-row-white">
                                <td class="prize-label">G2</td>
                                <td colspan="3"><span class="cell-content" data-prize="g2a"><span class="spinner"></span></span></td>
                                <td colspan="3"><span class="cell-content" data-prize="g2b"><span class="spinner"></span></span></td>
                            </tr>
                            {{-- G3 row 1 --}}
                            <tr class="result-row-alt">
                                <td class="prize-label" rowspan="2">G3</td>
                                <td><span class="cell-content" data-prize="g3a"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g3b"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g3c"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g3d"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g3e"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g3f"><span class="spinner"></span></span></td>
                            </tr>
                            <tr class="result-row-alt"></tr>
                            {{-- G4 --}}
                            <tr class="result-row-white">
                                <td class="prize-label">G4</td>
                                <td><span class="cell-content" data-prize="g4a"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g4b"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g4c"><span class="spinner"></span></span></td>
                                <td colspan="3"><span class="cell-content" data-prize="g4d"><span class="spinner"></span></span></td>
                            </tr>
                            {{-- G5 row 1 --}}
                            <tr class="result-row-alt">
                                <td class="prize-label" rowspan="2">G5</td>
                                <td><span class="cell-content" data-prize="g5a"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g5b"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g5c"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g5d"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g5e"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g5f"><span class="spinner"></span></span></td>
                            </tr>
                            <tr class="result-row-alt"></tr>
                            {{-- G6 --}}
                            <tr class="result-row-white">
                                <td class="prize-label">G6</td>
                                <td colspan="2"><span class="cell-content" data-prize="g6a"><span class="spinner"></span></span></td>
                                <td colspan="2"><span class="cell-content" data-prize="g6b"><span class="spinner"></span></span></td>
                                <td colspan="2"><span class="cell-content" data-prize="g6c"><span class="spinner"></span></span></td>
                            </tr>
                            {{-- G7 --}}
                            <tr class="result-row-alt">
                                <td class="prize-label">G7</td>
                                <td><span class="cell-content" data-prize="g7a"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g7b"><span class="spinner"></span></span></td>
                                <td><span class="cell-content" data-prize="g7c"><span class="spinner"></span></span></td>
                                <td colspan="3"><span class="cell-content" data-prize="g7d"><span class="spinner"></span></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- View options --}}
                <div class="view-options px-5 py-3">
                    <label><input type="radio" name="viewMode" value="full" checked onchange="applyViewMode(this.value)"> Đầy đủ</label>
                    <label><input type="radio" name="viewMode" value="2" onchange="applyViewMode(this.value)"> 2 số</label>
                    <label><input type="radio" name="viewMode" value="3" onchange="applyViewMode(this.value)"> 3 số</label>
                </div>

                {{-- Lô tô --}}
                <div class="loto-section" id="lotoSection">
                    <div class="flex">
                        @for ($i = 0; $i <= 9; $i++)
                        <div class="loto-head-cell">{{ $i }}</div>
                        @endfor
                    </div>
                    <div class="loto-section-title">Lô tô</div>
                    <table class="loto-grid-table">
                        <tbody id="lotoBody"></tbody>
                    </table>
                </div>
            </div>{{-- /qt-card --}}
        </div>

        {{-- ═══ SIDEBAR ═══ --}}
        <div class="w-full lg:w-64 flex-shrink-0">
            <div class="sidebar-box qt-card">
                <div class="qt-card-header">Quay Thử Theo Thứ</div>
                <ul>
                    <li><a href="#">Quay Thử Miền Bắc Thứ 2</a></li>
                    <li><a href="#">Quay Thử Miền Bắc Thứ 3</a></li>
                    <li><a href="#">Quay Thử Miền Bắc Thứ 4</a></li>
                    <li><a href="#">Quay Thử Miền Bắc Thứ 5</a></li>
                    <li><a href="#">Quay Thử Miền Bắc Thứ 6</a></li>
                    <li><a href="#">Quay Thử Miền Bắc Thứ 7</a></li>
                    <li><a href="#">Quay Thử Miền Bắc Chủ Nhật</a></li>
                </ul>
            </div>
            <div class="sidebar-box qt-card">
                <div class="qt-card-header">Quay Thử Theo Tỉnh</div>
                <ul>
                    <li><a href="#">Quay Thử Xổ Số Hà Nội</a></li>
                    <li><a href="#">Quay Thử Xổ Số Bắc Ninh</a></li>
                    <li><a href="#">Quay Thử Xổ Số Thái Bình</a></li>
                    <li><a href="#">Quay Thử Xổ Số Hải Phòng</a></li>
                    <li><a href="#">Quay Thử Xổ Số Nam Định</a></li>
                    <li><a href="#">Quay Thử Xổ Số Quảng Ninh</a></li>
                    <li><a href="#">Quay Thử Xổ Số Hải Dương</a></li>
                    <li><a href="#">Quay Thử Xổ Số Tuyên Quang</a></li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
/* ═══════════════════════════════════ DATETIME ═══ */
function updateDatetime() {
    const days = ['Chủ Nhật','Thứ Hai','Thứ Ba','Thứ Tư','Thứ Năm','Thứ Sáu','Thứ Bảy'];
    const n = new Date();
    const pad = v => String(v).padStart(2,'0');
    const d = document.getElementById('datetime');
    if (d) d.textContent = `${pad(n.getHours())}:${pad(n.getMinutes())}:${pad(n.getSeconds())}  ${days[n.getDay()]}, ${pad(n.getDate())}/${pad(n.getMonth()+1)}/${n.getFullYear()}`;
}
updateDatetime();
setInterval(updateDatetime, 1000);

/* ═══════════════════════════════════ DAY TAB ═══ */
function selectDay(el) {
    document.querySelectorAll('.day-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

/* ═══════════════════════════════════ RANDOM ═══ */
function rndPad(digits) {
    return String(Math.floor(Math.random() * Math.pow(10, digits))).padStart(digits, '0');
}

/* ═══════════════════════════════════ PRIZES ═══ */
const PRIZES = [
    {prize:'g7a',digits:2},{prize:'g7b',digits:2},{prize:'g7c',digits:2},{prize:'g7d',digits:2},
    {prize:'g6a',digits:3},{prize:'g6b',digits:3},{prize:'g6c',digits:3},
    {prize:'g5a',digits:4},{prize:'g5b',digits:4},{prize:'g5c',digits:4},
    {prize:'g5d',digits:4},{prize:'g5e',digits:4},{prize:'g5f',digits:4},
    {prize:'g4a',digits:4},{prize:'g4b',digits:4},{prize:'g4c',digits:4},{prize:'g4d',digits:4},
    {prize:'g3a',digits:5},{prize:'g3b',digits:5},{prize:'g3c',digits:5},
    {prize:'g3d',digits:5},{prize:'g3e',digits:5},{prize:'g3f',digits:5},
    {prize:'g2a',digits:5},{prize:'g2b',digits:5},
    {prize:'g1', digits:5},
    {prize:'db', digits:5},
];

let results = {}, currentViewMode = 'full', isSpinning = false, spinTimers = [];

/* ═══════════════════════════════════ RESET ═══ */
function resetAll() {
    document.querySelectorAll('.cell-content').forEach(el => {
        el.innerHTML = '<span class="spinner"></span>';
        el.dataset.value = '';
    });
    results = {};
    document.getElementById('lotoBody').innerHTML = '';
}

/* ═══════════════════════════════════ REVEAL ═══ */
function getDisplayVal(val) {
    if (!val) return '';
    if (currentViewMode === '2') return val.slice(-2);
    if (currentViewMode === '3') return val.slice(-3);
    return val;
}

function revealCell(prizeKey, digits) {
    const val = rndPad(digits);
    results[prizeKey] = val;
    const el = document.querySelector(`.cell-content[data-prize="${prizeKey}"]`);
    if (!el) return;
    el.dataset.value = val;
    el.innerHTML = `<span class="num-cell num-revealed">${getDisplayVal(val)}</span>`;
}

function applyViewMode(mode) {
    currentViewMode = mode;
    document.querySelectorAll('.cell-content').forEach(el => {
        const val = el.dataset.value;
        if (val) {
            const numEl = el.querySelector('.num-cell');
            if (numEl) numEl.textContent = getDisplayVal(val);
        }
    });
    updateLoto();
}

/* ═══════════════════════════════════ LÔ TÔ ═══ */
function updateLoto() {
    const tbody = document.getElementById('lotoBody');
    if (Object.keys(results).length === 0) { tbody.innerHTML = ''; return; }
    const groups = {};
    for (let i = 0; i <= 9; i++) groups[i] = [];
    Object.values(results).map(v => v.slice(-2)).forEach(t => {
        groups[parseInt(t[0], 10)].push(t);
    });
    let html = '';
    for (let d = 0; d <= 4; d++) {
        const d2 = d + 5;
        html += `<tr>
            <td class="loto-prefix">${d}</td>
            <td class="loto-numbers">${groups[d].map(n=>`<span>${n}</span>`).join(' ')}</td>
            <td class="loto-prefix">${d2}</td>
            <td class="loto-numbers">${groups[d2].map(n=>`<span>${n}</span>`).join(' ')}</td>
        </tr>`;
    }
    tbody.innerHTML = html;
}

/* ═══════════════════════════════════ SPIN ═══ */
function startSpin() {
    if (isSpinning) return;
    spinTimers.forEach(clearTimeout);
    spinTimers = [];
    resetAll();
    isSpinning = true;
    const btn = document.getElementById('btnQuay');
    btn.textContent = 'ĐANG QUAY...';
    btn.disabled = true;
    PRIZES.forEach((p, i) => {
        const t = setTimeout(() => {
            revealCell(p.prize, p.digits);
            updateLoto();
            if (i === PRIZES.length - 1) {
                isSpinning = false;
                btn.textContent = 'QUAY LẠI';
                btn.disabled = false;
            }
        }, (i + 1) * 220);
        spinTimers.push(t);
    });
}
</script>
@endsection
