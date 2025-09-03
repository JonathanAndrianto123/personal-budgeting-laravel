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
<img width="1366" height="608" alt="image" src="https://github.com/user-attachments/assets/7dacf67a-497e-43b6-9413-f4a8ee175002" />
<img width="1366" height="610" alt="image" src="https://github.com/user-attachments/assets/11eec2cf-957c-4778-9f3e-416676fe5fa9" />
<img width="1366" height="610" alt="image" src="https://github.com/user-attachments/assets/f93ef099-c584-499e-b57b-a4299534c837" />
<img width="1366" height="608" alt="image" src="https://github.com/user-attachments/assets/9223e6b1-e0ce-48b8-9c1d-bb5ee701b7e3" />
<img width="1366" height="608" alt="image" src="https://github.com/user-attachments/assets/7f97f9a9-10d5-46f1-873c-db30ab9d5e7c" />
<img width="1366" height="612" alt="image" src="https://github.com/user-attachments/assets/03d6b4fd-6764-49f6-9b6d-93c78ebf4c88" />
<img width="1366" height="609" alt="image" src="https://github.com/user-attachments/assets/1e9651a4-015c-4363-bd6a-2e9647097350" />


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
