import axios from 'axios';
import * as cheerio from 'cheerio';
import mysql from 'mysql2/promise';
import dotenv from 'dotenv';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

const __dirname = dirname(fileURLToPath(import.meta.url));
dotenv.config({ path: join(__dirname, '.env') });

const { DB_HOST, DB_PORT, DB_USER, DB_PASSWORD, DB_NAME } = process.env;

// Create MySQL connection pool
const pool = mysql.createPool({
  host: DB_HOST,
  port: Number(DB_PORT),
  user: DB_USER,
  password: DB_PASSWORD,
  database: DB_NAME,
  waitForConnections: true,
  connectionLimit: 5,
});

async function crawlRegion(regionCode, dateStr) {
  try {
    const url = `https://xskt.com.vn/${regionCode}/ngay-${dateStr}`;
    console.log(`Crawling ${regionCode} from: ${url}`);

    const response = await axios.get(url, {
      headers: {
        'User-Agent':
          'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
      },
      responseType: 'arraybuffer',
    });

    const html = new TextDecoder('utf-8').decode(response.data);
    const $ = cheerio.load(html);
    const tableId =
      regionCode === 'xsmb' ? '#MB0' : regionCode === 'xsmn' ? '#MN0' : '#MT0';
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
    if (regionCode === 'xsmb') {
      // XSMB always has a single result set — ignore ĐẦU/ĐUÔI column headers
      provinces.push('Miền Bắc');
    } else {
      table
        .find('tr')
        .first()
        .find('th')
        .each((i, el) => {
          if (i > 0) provinces.push($(el).text().trim());
        });
    }

    // Init results
    const results = provinces.map(() => ({
      special: [],
      first: [],
      second: [],
      third: [],
      fourth: [],
      fifth: [],
      sixth: [],
      seventh: [],
      eighth: [],
    }));

    // Parse Prizes
    table.find('tr').each((i, row) => {
      const $row = $(row);
      const prizeName =
        $row.find('td').first().attr('title') || $row.find('td').first().text().trim();
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
            const text = $(cell)
              .text()
              .trim()
              .split(/[\s-]+/)
              .filter((n) => n.length > 0);
            if (results[col - 1]) results[col - 1][key].push(...text);
          }
        });
      }
    });

    // Save to MySQL
    const regMap = { xsmb: 'MB', xsmn: 'MN', xsmt: 'MT' };
    for (let i = 0; i < provinces.length; i++) {
      const prizes = results[i];
      const numbers = Object.values(prizes).flat();

      await pool.execute(
        `INSERT INTO lottery_results (date, region, province, prizes, numbers, source)
         VALUES (?, ?, ?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE
           prizes = VALUES(prizes),
           numbers = VALUES(numbers),
           updated_at = CURRENT_TIMESTAMP`,
        [
          formattedDate,
          regMap[regionCode],
          provinces[i],
          JSON.stringify(prizes),
          JSON.stringify(numbers),
          'xskt.com.vn',
        ]
      );
      console.log(
        `✅ Saved ${regMap[regionCode]} - ${provinces[i]} for ${formattedDate}`
      );
    }
  } catch (error) {
    console.error(`Error crawling ${regionCode}:`, error.message);
  }
}

async function run() {
  console.log('🚀 Starting lottery crawler...');
  console.log(`Database: ${DB_HOST}:${DB_PORT}/${DB_NAME}`);

  const today = new Date();
  for (let i = 0; i < 3; i++) {
    const d = new Date(today);
    d.setDate(d.getDate() - i);
    const dStr = `${d.getDate()}-${d.getMonth() + 1}-${d.getFullYear()}`;
    await crawlRegion('xsmb', dStr);
    await crawlRegion('xsmn', dStr);
    await crawlRegion('xsmt', dStr);
  }

  console.log('🏁 Done!');
  await pool.end();
  process.exit(0);
}

run();
