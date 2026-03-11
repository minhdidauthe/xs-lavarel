<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-tools"></i> Công Cụ Tạo Dàn Đề
        </div>
        <div class="sc-tool-wrap">
            <div class="sc-tool-row">
                <label class="sc-label">Loại dàn:</label>
                <select id="td-type" class="sc-select" onchange="tdUpdateHint()">
                    <option value="head">Theo đầu số</option>
                    <option value="tail">Theo đuôi số</option>
                    <option value="sum">Theo tổng</option>
                    <option value="range">Theo khoảng</option>
                </select>
                <input type="number" id="td-value" class="sc-input" placeholder="Nhập giá trị (0-9)" min="0" max="9">
                <button onclick="taodan()" class="sc-btn">Tạo Dàn</button>
            </div>
            <div id="td-hint" style="font-size:12px;color:#888;margin-top:4px"></div>
            <div id="td-result" class="sc-nums" style="margin-top:12px; flex-wrap:wrap"></div>
        </div>
    </div>
</section>
<script>
function tdUpdateHint() {
    const type = document.getElementById('td-type').value;
    const input = document.getElementById('td-value');
    const hint = document.getElementById('td-hint');
    if (type === 'sum') {
        input.max = 18;
        input.placeholder = 'Nhập tổng (0-18)';
        hint.textContent = 'Tổng 2 chữ số: 00=0, 55=10, 99=18';
    } else if (type === 'range') {
        input.max = 99;
        input.placeholder = 'Nhập số bắt đầu';
        hint.textContent = 'Sẽ lấy 10 số liên tiếp từ giá trị nhập';
    } else {
        input.max = 9;
        input.placeholder = 'Nhập giá trị (0-9)';
        hint.textContent = '';
    }
}
function taodan() {
    const type = document.getElementById('td-type').value;
    const val  = parseInt(document.getElementById('td-value').value);
    const el   = document.getElementById('td-result');
    const maxVal = type === 'sum' ? 18 : (type === 'range' ? 99 : 9);
    if (isNaN(val) || val < 0 || val > maxVal) {
        el.innerHTML = '<span style="color:red">Nhập giá trị từ 0 đến ' + maxVal + '</span>';
        return;
    }
    const nums = [];
    for (let i = 0; i <= 99; i++) {
        const n  = String(i).padStart(2, '0');
        const h  = parseInt(n[0]), t = parseInt(n[1]);
        if (type === 'head' && h === val) nums.push(n);
        else if (type === 'tail' && t === val) nums.push(n);
        else if (type === 'sum' && (h + t) === val) nums.push(n);
        else if (type === 'range' && i >= val && i < val + 10) nums.push(n);
    }
    if (nums.length === 0) {
        el.innerHTML = '<span style="color:#999">Không có số nào phù hợp</span>';
        return;
    }
    el.innerHTML = '<strong>' + nums.length + ' số:</strong><br>' + nums.map(n => '<span class="sc-badge sc-badge-hot">' + n + '</span>').join('');
}
tdUpdateHint();
</script>
