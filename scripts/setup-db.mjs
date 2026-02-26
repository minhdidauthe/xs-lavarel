import mysql from 'mysql2/promise';
import dotenv from 'dotenv';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

const __dirname = dirname(fileURLToPath(import.meta.url));
dotenv.config({ path: join(__dirname, '.env') });

const { DB_HOST, DB_PORT, DB_USER, DB_PASSWORD, DB_NAME } = process.env;

async function setup() {
  console.log(`Connecting to MySQL at ${DB_HOST}:${DB_PORT}...`);

  const connection = await mysql.createConnection({
    host: DB_HOST,
    port: Number(DB_PORT),
    user: DB_USER,
    password: DB_PASSWORD,
    database: DB_NAME,
  });

  console.log('Connected to MySQL.');

  await connection.execute(`
    CREATE TABLE IF NOT EXISTS lottery_results (
      id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      date DATE NOT NULL,
      region VARCHAR(5) NOT NULL,
      province VARCHAR(100) NOT NULL,
      prizes JSON NOT NULL,
      numbers JSON NOT NULL,
      source VARCHAR(100) DEFAULT 'xskt.com.vn',
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      UNIQUE KEY unique_result (date, region, province)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  `);

  console.log('Table `lottery_results` created (or already exists).');

  await connection.end();
  console.log('Done!');
}

setup().catch(err => {
  console.error('Setup failed:', err);
  process.exit(1);
});
