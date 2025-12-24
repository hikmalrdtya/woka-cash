# 📓 WokaCash

**Sistem Pengelolaan Pengeluaran Keuangan dengan OCR & AI Chat Terintegrasi**

WokaCash adalah aplikasi manajemen pengeluaran berbasis web yang dibangun menggunakan **Laravel**, dilengkapi dengan fitur **OCR (Optical Character Recognition)** menggunakan **Tesseract** untuk membaca nota belanja, serta integrasi **Chat AI (Grok API)** untuk membantu analisis dan konsultasi keuangan secara cerdas.

---

## 🚀 Fitur Utama

### 🔍 OCR Nota (Tesseract)

* Upload foto nota (struk belanja)
* Ekstraksi otomatis:

  * Nama toko
  * Nomor nota
  * Tanggal transaksi
  * Total pengeluaran
* Preview hasil OCR sebelum data disimpan
* Menyimpan teks OCR mentah (raw text) ke database

### 🤖 Chat AI (Grok API)

* Chat interaktif untuk konsultasi keuangan
* Analisis data pengeluaran
* Membantu user memahami kondisi budget dan expense

### 📊 Manajemen Pengeluaran

* CRUD data pengeluaran
* Relasi dengan cabang dan project
* Upload & penyimpanan file nota
* Status pengajuan budget (pending / approved / rejected)

---

## 🛠️ Teknologi yang Digunakan

* **Backend**: Laravel
* **Frontend**: Blade + Tailwind CSS
* **Database**: MySQL
* **OCR Engine**: Tesseract OCR
* **AI Chat**: Grok API

---

## 📥 Instalasi Project

### 1️⃣ Clone Repository

```bash
git clone https://github.com/hikmalrdtya/woka-cash.git
cd woka-cash
```

### 2️⃣ Setup Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Atur konfigurasi berikut di `.env`:

```env
APP_NAME=WokaCash
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wokacash
DB_USERNAME=root
DB_PASSWORD=

GROK_API_KEY=your_grok_api_key_here
```

### 3️⃣ Install Dependency

```bash
composer install
npm install
npm run dev
```

### 4️⃣ Generate App Key

```bash
php artisan key:generate
```

### 5️⃣ Migrasi Database

```bash
php artisan migrate
```

### 6️⃣ Jalankan Server

```bash
php artisan serve
```

---

## 🧠 Konfigurasi OCR (Tesseract)

### 🔹 Install Tesseract

Pastikan Tesseract sudah terinstall:

```bash
tesseract --version
```

Install bahasa Indonesia (opsional):

```bash
sudo apt install tesseract-ocr-ind
```

### 🔹 Path Tesseract

Jika PHP tidak mendeteksi Tesseract, gunakan path absolut:

```bash
which tesseract
```

Contoh di controller:

```php
$process = new Process([
    '/usr/bin/tesseract',
    $fullPath,
    'stdout',
    '-l',
    'eng+ind'
]);
```

---

## 💬 Integrasi Chat AI (Grok API)

### Setting API Key

Tambahkan di `.env`:

```env
GROK_API_KEY=your_api_key
```

### Contoh Pemanggilan API

```php
Http::withHeaders([
    'Authorization' => 'Bearer ' . env('GROK_API_KEY'),
])->post('https://api.openai.com/v1/grok', [
    'prompt' => $message,
]);
```

---

## 🗂️ Struktur Folder Penting

```
app/Http/Controllers/Finance
resources/views/finance/expenses
routes/web.php
database/migrations
```

---

## 🧪 Testing OCR

* Gunakan foto nota yang jelas
* Hindari blur dan cahaya rendah
* Gunakan nota dengan teks kontras tinggi

---

## 📄 Lisensi

Project ini menggunakan lisensi **MIT**.

---

## 🙌 Kontribusi

1. Fork repository
2. Buat branch fitur baru
3. Commit perubahan
4. Ajukan Pull Request

---

## ✨ Penutup

WokaCash dibuat untuk membantu pencatatan dan analisis keuangan secara modern dengan dukungan AI dan OCR.

Happy Coding 🚀
