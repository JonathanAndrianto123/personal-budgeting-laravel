# Personal Budgeting App (Laravel)

## 🚀 Deskripsi
Aplikasi pengelolaan keuangan pribadi berbasis Laravel.  
Tujuan aplikasi ini adalah membantu pengguna dalam mencatat **pendapatan (income)** dan **pengeluaran (expense)**, serta menyediakan laporan keuangan sederhana dalam bentuk **grafik dan file export**.

## ⚡ Fitur Utama
### 🔑 Autentikasi
- Register & Login
- Logout

### 📂 Kategori
- Tambah kategori (income/expense)
- Edit kategori
- Hapus kategori

### 💰 Transaksi
- Tambah transaksi (income/expense)
- Edit transaksi
- Hapus transaksi
- Filter transaksi berdasarkan kategori atau waktu
- Grafik interaktif (Chart.js)
- Export laporan keuangan ke **PDF/Excel**

### 📊 Dashboard
- Ringkasan saldo akhir
- Grafik income vs expense
- Progress per kategori
- Auto-scroll ke bagian ringkasan (user friendly ✨)

## 🛠️ Teknologi
- **Framework**: Laravel 10
- **Frontend**: Blade + Bootstrap / Tailwind
- **Database**: MySQL
- **Charting**: Chart.js
- **Export**: Laravel-Excel / DomPDF

## 📌 Routes (ringkasan)
Beberapa route penting:
- `/` → Halaman guest
- `/login`, `/register` → Autentikasi
- `/dashboard` → Dashboard utama
- `/dashboard/categories/*` → CRUD kategori
- `/dashboard/transactions/*` → CRUD transaksi + laporan
- `/chartData` → Data grafik transaksi

> Untuk detail lengkap, lihat file [`routes/web.php`](routes/web.php).

## 📷 Screenshot
*(tambahkan screenshot UI dashboard, form transaksi, laporan export di sini)*  

## 💡 Cara Menjalankan
1. Clone repo ini:
   ```bash
   git clone https://github.com/username/personal-budgeting-laravel.git
    cd personal-budgeting-laravel
2. Install dependencies:
   ```bash
   composer install
   npm install && npm run dev
3. Copy .env.example ke .env lalu sesuaikan database.
4. Generate key:
    ```bash
    php artisan key:generate
5. Migrasi database:
   ```bash
   php artisan migrate --seed
6. Jalankan server:
   ```bash
   php artisan serve

## ✨ Status
- **✅ Aplikasi sudah berjalan dengan fitur dasar.**
- **⚙️ Auto-scroll dashboard & laporan sedang dalam tahap pengembangan.**

## 👨‍💻 Kontributor
- **Jonathan Satriani Gracio Andrianto (Developer)**
