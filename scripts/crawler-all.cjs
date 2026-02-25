const axios = require('axios');
const cheerio = require('cheerio');
const mongoose = require('mongoose');

// Connect MongoDB
const MONGODB_URI = "mongodb://root:examplepassword@xs-mongo:27017/xs-lottery?authSource=admin";
mongoose.connect(MONGODB_URI)
  .then(() => console.log('✅ Connected to MongoDB'))
  .catch(err => { console.error('❌ MongoDB Error:', err); process.exit(1); });

// Schema KQXS
const LotterySchema = new mongoose.Schema({
    date: String, region: String, province: String, prizes: Object, numbers: [String], source: String
}, { collection: 'lottery_results' });
const Lottery = mongoose.model('Lottery', LotterySchema);

async function crawlRegion(regionCode, dateStr) {
    try {
        const url = `https://xskt.com.vn/${regionCode}/ngay-${dateStr}`;
        console.log(`Crawling ${regionCode} from: ${url}`);
        
        const response = await axios.get(url, {
            headers: { 'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36' }
        });

        const $ = cheerio.load(response.data);
        const tableId = regionCode === 'xsmb' ? '#MB0' : (regionCode === 'xsmn' ? '#MN0' : '#MT0');
        const table = $(tableId);

        if (table.length === 0) {
            console.log(`No table found for ${regionCode}`);
            return;
        }

        // Parse Date
        let dateText = table.find('i.dockq').attr('title')?.replace(/.*ngày /, '');
        if (!dateText) return;
        const [d, m, y] = dateText.split('-').map(Number);
        const formattedDate = `${y}-${m.toString().padStart(2, '0')}-${d.toString().padStart(2, '0')}`;

        // Get Provinces
        const provinces = [];
        table.find('tr').first().find('th').each((i, el) => {
            if (i > 0) provinces.push($(el).text().trim());
        });
        if (provinces.length === 0 && regionCode === 'xsmb') provinces.push('Miền Bắc');

        // Init results
        const results = provinces.map(() => ({
            special: [], first: [], second: [], third: [], fourth: [], fifth: [], sixth: [], seventh: [], eighth: []
        }));

        // Parse Prizes
        table.find('tr').each((i, row) => {
            const $row = $(row);
            const prizeName = $row.find('td').first().attr('title') || $row.find('td').first().text().trim();
            let key = null;
            if (prizeName.includes('ĐB')) key = 'special';
            else if (prizeName.includes('nhất')) key = 'first';
            else if (prizeName.includes('nhì')) key = 'second';
            else if (prizeName.includes('ba')) key = 'third';
            else if (prizeName.includes('tư')) key = 'fourth';
            else if (prizeName.includes('năm')) key = 'fifth';
            else if (prizeName.includes('sáu')) key = 'sixth';
            else if (prizeName.includes('bảy')) key = 'seventh';
            else if (prizeName.includes('tám')) key = 'eighth';

            if (key) {
                $row.find('td').each((col, cell) => {
                    if (col > 0) {
                        const text = $(cell).text().trim().split(/[\s-]+/).filter(n => n.length > 0);
                        if (results[col-1]) results[col-1][key].push(...text);
                    }
                });
            }
        });

        // Save to DB
        for (let i = 0; i < provinces.length; i++) {
            const regMap = { 'xsmb': 'MB', 'xsmn': 'MN', 'xsmt': 'MT' };
            const payload = {
                date: formattedDate,
                region: regMap[regionCode],
                province: provinces[i],
                prizes: results[i],
                numbers: Object.values(results[i]).flat(),
                source: 'xskt.com.vn'
            };
            await Lottery.findOneAndUpdate(
                { date: payload.date, region: payload.region, province: payload.province },
                payload,
                { upsert: true }
            );
            console.log(`✅ Saved ${payload.region} - ${payload.province} for ${payload.date}`);
        }

    } catch (error) {
        console.error(`Error crawling ${regionCode}:`, error.message);
    }
}

async function run() {
    const today = new Date();
    for (let i = 0; i < 3; i++) { // Crawl today and last 2 days
        const d = new Date(today);
        d.setDate(d.getDate() - i);
        const dStr = `${d.getDate()}-${d.getMonth() + 1}-${d.getFullYear()}`;
        await crawlRegion('xsmb', dStr);
        await crawlRegion('xsmn', dStr);
        await crawlRegion('xsmt', dStr);
    }
    console.log('Done!');
    process.exit(0);
}

run();
