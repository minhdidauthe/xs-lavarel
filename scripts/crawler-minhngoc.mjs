#!/usr/bin/env node
/**
 * Backup Crawler — minhngoc.net.vn
 * Crawls lottery results from minhngoc.net.vn as backup source.
 *
 * Usage:
 *   node scripts/crawler-minhngoc.mjs          # crawl last 7 days
 *   node scripts/crawler-minhngoc.mjs 30       # crawl last 30 days
 *   node scripts/crawler-minhngoc.mjs 180      # crawl 180 days for prediction
 *   node scripts/crawler-minhngoc.mjs 7 mb     # crawl only Mien Bac
 */

import axios from 'axios';
import * as cheerio from 'cheerio';
import mysql from 'mysql2/promise';
import dotenv from 'dotenv';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

const __dirname = dirname(fileURLToPath(import.meta.url));
dotenv.config({ path: join(__dirname, '.env') });

const { DB_HOST, DB_PORT, DB_USER, DB_PASSWORD, DB_NAME } = process.env;

const pool = mysql.createPool({
  host: DB_HOST,
  port: Number(DB_PORT),
  user: DB_USER,
  password: DB_PASSWORD,
  database: DB_NAME,
  waitForConnections: true,
  connectionLimit: 5,
});

const UA =
  'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36';

// ── Province code → display name mapping ──
// These should match province names from xskt.com.vn crawler for consistency
const PROVINCE_MAP = {
  // Miền Nam
  XSHCM: 'TP HCM',
  XSDT: 'Đồng Tháp',
  XSCM: 'Cà Mau',
  XSBTR: 'Bến Tre',
  XSVT: 'Vũng Tàu',
  XSBL: 'Bạc Liêu',
  XSDN: 'Đồng Nai',
  XSST: 'Sóc Trăng',
  XSTN: 'Tây Ninh',
  XSAG: 'An Giang',
  XSBTH: 'Bình Thuận',
  XSVL: 'Vĩnh Long',
  XSBD: 'Bình Dương',
  XSTV: 'Trà Vinh',
  XSLA: 'Long An',
  XSBP: 'Bình Phước',
  XSHG: 'Hậu Giang',
  XSTG: 'Tiền Giang',
  XSKG: 'Kiên Giang',
  XSDL: 'Đà Lạt',
  XSCT: 'Cần Thơ',
  // Miền Trung
  XSGL: 'Gia Lai',
  XSNT: 'Ninh Thuận',
  XSH: 'Thừa Thiên Huế',
  XSBDI: 'Bình Định',
  XSQT: 'Quảng Trị',
  XSQB: 'Quảng Bình',
  XSDNO: 'Đắk Nông',
  XSQNM: 'Quảng Nam',
  XSDNG: 'Đà Nẵng',
  XSKH: 'Khánh Hòa',
  XSPY: 'Phú Yên',
  XSQNG: 'Quảng Ngãi',
  XSDLK: 'Đắk Lắk',
  XSKT: 'Kon Tum',
};

// ── Helpers ──

async function fetchPage(url) {
  const response = await axios.get(url, {
    headers: { 'User-Agent': UA },
    responseType: 'arraybuffer',
    timeout: 15000,
  });
  return new TextDecoder('utf-8').decode(response.data);
}

function parseProvinceCode(loaiveText) {
  // "XSTN - Loai ve: 2K4" → "XSTN"
  // "XSTN - 2K4" → "XSTN"
  const match = loaiveText.match(/^(XS\w+)/);
  return match ? match[1].toUpperCase() : null;
}

function formatDateForUrl(d) {
  const dd = d.getDate().toString().padStart(2, '0');
  const mm = (d.getMonth() + 1).toString().padStart(2, '0');
  return `${dd}-${mm}-${d.getFullYear()}`;
}

function formatDateForDb(d) {
  const dd = d.getDate().toString().padStart(2, '0');
  const mm = (d.getMonth() + 1).toString().padStart(2, '0');
  return `${d.getFullYear()}-${mm}-${dd}`;
}

async function saveToDB(date, region, province, prizes, numbers) {
  await pool.execute(
    `INSERT INTO lottery_results (date, region, province, prizes, numbers, source)
     VALUES (?, ?, ?, ?, ?, ?)
     ON DUPLICATE KEY UPDATE
       prizes = VALUES(prizes),
       numbers = VALUES(numbers),
       source = VALUES(source),
       updated_at = CURRENT_TIMESTAMP`,
    [
      date,
      region,
      province,
      JSON.stringify(prizes),
      JSON.stringify(numbers),
      'minhngoc.net.vn',
    ]
  );
  console.log(
    `  ✅ ${region} — ${province} [${date}] (${numbers.length} numbers)`
  );
}

// ── Helpers for date matching ──

function displayDate(formattedDate) {
  // "2026-02-26" → "26/02/2026"
  const [y, m, d] = formattedDate.split('-');
  return `${d}/${m}/${y}`;
}

function parseDisplayDate(dateText) {
  // "26/02/2026" → "2026-02-26"
  const match = dateText.match(/(\d{2})\/(\d{2})\/(\d{4})/);
  return match ? `${match[3]}-${match[2]}-${match[1]}` : null;
}

// ── Crawl Miền Bắc ──
// URL: /kqxs/mien-bac/DD-MM-YYYY.html
// Page returns ~7 days of results in table.bkqtinhmienbac
// Date is in div.ngay a inside each table
// MB has no giai8. Only 1 province per day.

async function crawlMB(dateStr, formattedDate) {
  try {
    const url = `https://www.minhngoc.net.vn/kqxs/mien-bac/${dateStr}.html`;
    console.log(`  [MB] ${url}`);

    const html = await fetchPage(url);
    const $ = cheerio.load(html);

    const tables = $('table.bkqtinhmienbac');
    if (tables.length === 0) {
      console.log(`  ⚠️  MB — no table found`);
      return 0;
    }

    // Find the table matching our target date
    const targetDisplay = displayDate(formattedDate);
    let targetTable = null;

    tables.each((i, tbl) => {
      const dateText = $(tbl).find('div.ngay a').first().text().trim();
      if (dateText === targetDisplay) {
        targetTable = $(tbl);
        return false; // break
      }
    });

    // Fallback: use first table (most recent = requested date)
    if (!targetTable) {
      targetTable = $(tables.first());
    }

    const get = (cls) =>
      targetTable
        .find(`td.${cls} div`)
        .map((i, el) => $(el).text().trim())
        .get()
        .filter((n) => /^\d+$/.test(n));

    const prizes = {
      special: get('giaidb'),
      first: get('giai1'),
      second: get('giai2'),
      third: get('giai3'),
      fourth: get('giai4'),
      fifth: get('giai5'),
      sixth: get('giai6'),
      seventh: get('giai7'),
    };

    const numbers = Object.values(prizes).flat();
    if (numbers.length === 0) {
      console.log(`  ⚠️  MB — no numbers found`);
      return 0;
    }

    await saveToDB(formattedDate, 'MB', 'Miền Bắc', prizes, numbers);
    return 1;
  } catch (err) {
    if (err.response?.status === 404) {
      console.log(`  ⚠️  MB — no data (404)`);
    } else {
      console.error(`  ❌ MB error: ${err.message}`);
    }
    return 0;
  }
}

// ── Crawl Miền Nam / Miền Trung ──
// URL: /kqxs/mien-nam/DD-MM-YYYY.html or /kqxs/mien-trung/DD-MM-YYYY.html
// Structure: multiple table.bkqtinhmiennam (one per province)
//   → span.loaive has province code (XSTN, XSHCM, etc.)
//   → table.box_kqxs_content → td.giaidb ... td.giai8

async function crawlMNMT(regionSlug, regionCode, dateStr, formattedDate) {
  try {
    const url = `https://www.minhngoc.net.vn/kqxs/${regionSlug}/${dateStr}.html`;
    console.log(`  [${regionCode}] ${url}`);

    const html = await fetchPage(url);
    const $ = cheerio.load(html);

    // Per-province tables (class is bkqtinhmiennam for both MN and MT)
    let tables = $('table.bkqtinhmiennam');
    if (tables.length === 0) {
      tables = $('table.bkqtinhmientrung');
    }
    if (tables.length === 0) {
      console.log(`  ⚠️  ${regionCode} — no tables found`);
      return 0;
    }

    const targetDisplay = displayDate(formattedDate);
    let count = 0;

    for (let i = 0; i < tables.length; i++) {
      const tbl = $(tables[i]);

      // Filter by date — page may contain multiple days
      const dateText = tbl.find('div.ngay a').first().text().trim();
      if (dateText && dateText !== targetDisplay) continue;

      // Extract province name from loaive
      const loaiveText = tbl.find('span.loaive').text().trim();
      const code = parseProvinceCode(loaiveText);
      const province = code
        ? PROVINCE_MAP[code] || code.replace(/^XS/, '')
        : `Province_${i + 1}`;

      const get = (cls) =>
        tbl
          .find(`td.${cls} div`)
          .map((j, el) => $(el).text().trim())
          .get()
          .filter((n) => /^\d+$/.test(n));

      const prizes = {
        special: get('giaidb'),
        first: get('giai1'),
        second: get('giai2'),
        third: get('giai3'),
        fourth: get('giai4'),
        fifth: get('giai5'),
        sixth: get('giai6'),
        seventh: get('giai7'),
        eighth: get('giai8'),
      };

      const numbers = Object.values(prizes).flat();
      if (numbers.length === 0) continue;

      await saveToDB(formattedDate, regionCode, province, prizes, numbers);
      count++;
    }

    if (count === 0) {
      console.log(`  ⚠️  ${regionCode} — no data for this date`);
    }
    return count;
  } catch (err) {
    if (err.response?.status === 404) {
      console.log(`  ⚠️  ${regionCode} — no data (404)`);
    } else {
      console.error(`  ❌ ${regionCode} error: ${err.message}`);
    }
    return 0;
  }
}

// ── Main ──

async function run() {
  const days = parseInt(process.argv[2]) || 7;
  const regionFilter = (process.argv[3] || 'all').toLowerCase();
  const doMB = regionFilter === 'all' || regionFilter === 'mb';
  const doMN = regionFilter === 'all' || regionFilter === 'mn';
  const doMT = regionFilter === 'all' || regionFilter === 'mt';

  console.log(`🚀 Minhngoc.net.vn backup crawler`);
  console.log(`   Days: ${days} | Regions: ${regionFilter}`);
  console.log(`   Database: ${DB_HOST}:${DB_PORT}/${DB_NAME}\n`);

  let totalSaved = 0;
  const today = new Date();

  for (let i = 0; i < days; i++) {
    const d = new Date(today);
    d.setDate(d.getDate() - i);

    const dateStr = formatDateForUrl(d);
    const formattedDate = formatDateForDb(d);

    console.log(`\n📅 ${dateStr}`);

    if (doMB) totalSaved += await crawlMB(dateStr, formattedDate);
    if (doMN) totalSaved += await crawlMNMT('mien-nam', 'MN', dateStr, formattedDate);
    if (doMT) totalSaved += await crawlMNMT('mien-trung', 'MT', dateStr, formattedDate);

    // Rate limiting — be gentle with the server
    if (i < days - 1) {
      await new Promise((r) => setTimeout(r, 800));
    }
  }

  console.log(`\n🏁 Done! Saved ${totalSaved} records.`);
  await pool.end();
  process.exit(0);
}

run();
