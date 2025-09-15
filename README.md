# Project Monitoring Volume Sampah (DEVO)

Aplikasi Monitoring Volume Sampah berbasis **Laravel** untuk memantau, mencatat, dan menganalisis volume sampah secara real time.  
Project ini bertujuan membantu pengelolaan sampah agar lebih efektif dan efisien.

---

## 🚀 Fitur Utama

- 📊 Dashboard monitoring volume sampah  
- 🔔 Notifikasi saat volume melebihi ambang batas  
- 📂 Penyimpanan data historis  
- 👥 Manajemen pengguna & autentikasi  
- 📈 Visualisasi data dalam bentuk grafik & tabel  

---

## 🛠️ Teknologi yang Digunakan

- **Backend** : Laravel (PHP)  
- **Frontend** : Blade Template, Bootstrap/Tailwind, JavaScript  
- **Database** : MySQL / MariaDB (dump: `devo.sql`)  
- **Realtime** : Laravel Echo / WebSocket (`laravel-echo-server.json`)  

---

## ⚙️ Instalasi & Setup (GitHub Desktop)

### 1. Clone Repo dengan GitHub Desktop
1. Buka **GitHub Desktop**  
2. Klik **File > Clone Repository**  
3. Pilih tab **URL**  
4. Masukkan URL repo ini:  
```

[https://github.com/ghozahimma65/Project-Monitoring-Volume-Sampah\_DEVO.git]
````
5. Tentukan folder penyimpanan lokal di komputer  
6. Klik **Clone**  
7. Setelah berhasil, buka folder project di **Code Editor** (misalnya VS Code atau PhpStorm)  

---

### 2. Setup Project
1. Install dependency PHP
composer install

2. Install dependency JavaScript

   npm install

3. Copy file `.env.example` menjadi `.env` lalu sesuaikan konfigurasi (database, app key, dsb).

4. Import database `devo.sql` ke MySQL

5. Generate key Laravel

   php artisan key:generate

6. Migrasi & seeding (opsional)

   php artisan migrate --seed

7. Jalankan server

   php artisan serve

Akses di browser: **[http://localhost:8000](http://localhost:8000)**

---

## 📂 Struktur Direktori

| Folder       | Deskripsi                                |
| ------------ | ---------------------------------------- |
| `app/`       | Logic utama aplikasi (Controller, Model) |
| `resources/` | View (Blade), CSS, JS, asset frontend    |
| `routes/`    | File route web & API                     |
| `database/`  | Migration, seeder, dan dump SQL          |
| `public/`    | File publik (index.php, asset build)     |
| `config/`    | File konfigurasi aplikasi                |

---

## 📤 Cara Push dengan GitHub Desktop

1. Buka project di **GitHub Desktop**
2. Lakukan perubahan di code editor (misalnya VS Code)
3. Kembali ke GitHub Desktop, tulis **summary commit** (contoh: `update dashboard view`)
4. Klik **Commit to main**
5. Klik tombol **Push origin** untuk mengirim perubahan ke GitHub