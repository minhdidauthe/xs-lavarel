<section class="container sc-section">
    <div class="sc-soicau-box">
        <div class="sc-soicau-header">
            <i class="fas fa-tools"></i> Công Cụ Tạo Dàn Đề
        </div>
        <div class="sc-tool-wrap">
            <div class="sc-tool-row">
                <label class="sc-label">Loại dàn:</label>
                <select id="td-type" class="sc-select">
                    <option value="head">Theo đầu số</option>
                    <option value="tail">Theo đuôi số</option>
                    <option value="sum">Theo tổng</option>
                    <option value="range">Theo khoảng</option>
                </select>
                <input type="number" id="td-value" class="sc-input" placeholder="Nhập giá trị (0-9)" min="0" max="9">
                <button onclick="taodan()" class="sc-btn">Tạo Dàn</button>
            </div>
            <div id="td-result" class="sc-nums" style="margin-top:12px; flex-wrap:wrap"></div>
        </div>
    </div>
</section>
<script>
function taodan() {
    const type = document.getElementById('td-type').value;
    const val  = parseInt(document.getElementById('td-value').value);
    const el   = document.getElementById('td-result');
    if (isNaN(val) || val < 0 || val > 9) { el.innerHTML='<span style="color:red">Nhập giá trị 0-9</span>'; return; }
    const nums = [];
    for (let i = 0; i <= 99; i++) {
        const n  = String(i).padStart(2, '0');
        const h  = parseInt(n[0]), t = parseInt(n[1]);
        if (type==='head' && h===val) nums.push(n);
        else if (type==='tail' && t===val) nums.push(n);
        else if (type==='sum'  && (h+t)===val) nums.push(n);
        else if (type==='range') nums.push(n);
    }
    el.innerHTML = nums.map(n=>`<span class="sc-badge">${n}</span>`).join('');
}
</script>
