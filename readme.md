# 🎬 Movie Catalog App - PT Aldmic COOPN Digital Technical Test

[![Laravel Version](https://img.shields.io/badge/Laravel-5.8.*-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%207.1.3-blue.svg)](https://php.net)
[![OMDb API](https://img.shields.io/badge/OMDb--API-Integrated-green.svg)](http://www.omdbapi.com/)
[![License](https://img.shields.io/badge/License-MIT-brightgreen.svg)](https://opensource.org/licenses/MIT)

Aplikasi katalog film responsif berbasis **Laravel 5.8** yang terintegrasi secara langsung dengan **OMDb API**. Aplikasi ini mengusung pendekatan modern, cepat, serta **Database-less** (tanpa database fisik), menjadikannya sangat portabel dan mudah dijalankan dalam lingkungan lokal.

Aplikasi ini dilengkapi dengan fitur pencarian film interaktif, penayangan detail lengkap, sistem bookmark favorit berbasis *Session Storage*, penjelajahan *Infinite Scroll*, *Lazy Loading* gambar poster, serta dukungan *Localization* (Multi-bahasa ID/EN).

---

## ✨ Fitur Utama (Key Features)

*   **🔍 OMDb API Live Search**: Pencarian katalog film secara *real-time* yang terhubung langsung dengan server OMDb API.
*   **♾️ Infinite Scroll (AJAX-Driven)**: Pemuatan halaman film berikutnya secara otomatis saat pengguna melakukan scroll ke bawah halaman utama (tanpa memuat ulang halaman).
*   **🖼️ Smart Image Lazy Loading**: Optimasi rendering gambar poster film menggunakan library `lazysizes.min.js` untuk meningkatkan kecepatan muat awal (*Page Load Speed*) dan menghemat kuota internet pengguna.
*   **🌍 Localization (Multi-Bahasa)**: Fitur pengalihan bahasa dinamis antara **Bahasa Indonesia (ID)** dan **Bahasa Inggris (EN)** di seluruh antarmuka sistem.
*   **💾 Database-less Session Favorites**: Sistem bookmark film favorit yang disimpan langsung pada memori sesi server (*PHP Session Array*), menghindari latency database dan menyederhanakan siklus deployment.
*   **🔑 Custom Database-less Auth**: Sistem masuk (login) terproteksi dengan middleware autentikasi statis untuk mengamankan data pengguna selama sesi aktif.
*   **💅 Modern Premium UI**: Didesain menggunakan Bootstrap 4.6.2, tata letak yang bersih, bayangan halus (*box-shadow*), efek transisi melayang (*card hover transition*), serta dialog notifikasi sukses/gagal yang elegan (*reusable AJAX alert toast*).

---

## 🏗️ Spesifikasi Teknologi & Library (Tech Stack)

### Backend (Sisi Server)
*   **Framework**: Laravel 5.8.38 (LTS)
*   **HTTP Client**: Guzzle HTTP Client v7.10 (Untuk integrasi server-to-server OMDb API)
*   **PHP Version Support**: PHP `>= 7.1.3` s.d. PHP `7.4` atau `8.0` (kompatibel dengan depedensi pendukung)

### Frontend (Sisi Klien)
*   **Layouting & CSS**: Bootstrap 4.6.2 (Via CDN untuk jaminan ketersediaan tinggi)
*   **JavaScript Library**: jQuery 3.5.1 (Untuk manipulasi DOM, manajemen request AJAX, dan animasi)
*   **Lazy Load**: `lazysizes.min.js` v5.3.2 (Native HTML5 Intersection Observer Wrapper)

---

## 💻 Panduan Instalasi (Installation Guide)

Karena aplikasi ini mengusung **arsitektur database-less**, Anda tidak perlu melakukan konfigurasi server MySQL, menjalankan database migration, ataupun seeding data. Cukup ikuti langkah-langkah mudah berikut untuk menjalankannya secara lokal:

### 📋 Prasyarat Sistem (Prerequisites)
Pastikan lingkungan lokal Anda sudah terpasang:
*   **PHP** (Minimal versi `7.1.3`, disarankan versi `7.4` atau versi PHP 7.x lainnya)
*   **Composer** (Manajer Dependensi PHP)
*   Koneksi internet aktif (untuk fetch API OMDb & CDN assets)

### 🛠️ Langkah-Langkah Instalasi

1.  **Ekstrak atau Clone Repositori**
    Ekstrak file ZIP proyek ini atau clone repositori ke dalam mesin lokal Anda:
    ```bash
    git clone <repository-url> movie-app
    cd movie-app
    ```

2.  **Instal Dependensi PHP (Composer)**
    Jalankan perintah berikut di terminal untuk memasang seluruh dependensi framework dan library yang dibutuhkan (seperti Guzzle):
    ```bash
    composer install
    ```

3.  **Konfigurasi Environment File (.env)**
    Salin file `.env.example` yang disediakan menjadi `.env`:
    ```bash
    cp .env.example .env
    ```

4.  **Membuat Kunci Enkripsi Aplikasi (Application Key)**
    Jalankan perintah bawaan Artisan untuk membuat `APP_KEY` unik pada file konfigurasi `.env` Anda:
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi OMDb API Key (Opsional)**
    Aplikasi ini sudah dilengkapi dengan API Key bawaan yang aktif (`6f525d05`) di dalam `MovieController.php`. Namun, jika Anda ingin menggunakan API Key milik pribadi, Anda bisa mendapatkan API Key gratis di [omdbapi.com](http://www.omdbapi.com/) dan mengonfigurasikannya jika diperlukan.

6.  **Jalankan Server Lokal**
    Mulai server pengembangan lokal Laravel dengan menjalankan perintah:
    ```bash
    php artisan serve
    ```
    Secara default, aplikasi akan berjalan pada alamat: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🔑 Kredensial Login Uji Coba (Login Credentials)

Untuk masuk dan mencoba seluruh fitur di dalam aplikasi, gunakan kredensial statis berikut pada halaman login:

| Field | Nilai Kredensial |
| :--- | :--- |
| **Username** | `aldmic` |
| **Password** | `123abc123` |

> [!IMPORTANT]
> Sistem autentikasi ini terlindungi sepenuhnya menggunakan middleware kustom `CustomAuth`. Jika Anda mencoba mengakses halaman utama (`/`), detail film (`/movie/{id}`), ataupun favorit (`/favorites`) secara langsung tanpa login, Anda akan secara otomatis dialihkan kembali ke form login dengan pesan kesalahan.

---

## 📂 Struktur Direktori Penting

Berikut adalah peta folder penting yang mengontrol fungsi utama aplikasi ini:

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php      # Mengatur login statis, sesi masuk & logout
│   │   ├── MovieController.php     # Integrasi OMDb API (Pencarian, Detail & AJAX Scroll)
│   │   ├── FavoriteController.php  # Manajemen simpan & hapus favorit via Session
│   │   └── LanguageController.php  # Fitur pengalihan bahasa dinamis (ID/EN)
│   └── Middleware/
│       ├── CustomAuth.php          # Middleware proteksi halaman internal (harus login)
│       └── Localization.php        # Middleware set locale bahasa aktif berdasarkan session
resources/
├── lang/
│   ├── en/
│   │   └── messages.php            # File kamus Bahasa Inggris (Default)
│   └── id/
│       └── messages.php            # File kamus Bahasa Indonesia
└── views/
    ├── layouts/
    │   └── app.blade.php           # Master layout HTML5, navbar & jQuery AJAX global setup
    ├── auth/
    │   └── login.blade.php         # Tampilan Halaman Login + Error Alert
    ├── movies/
    │   ├── index.blade.php         # Tampilan List Movie + Pencarian + Infinite Scroll
    │   ├── detail.blade.php        # Tampilan Detail Film lengkap (Sinopsis, Rating, dll)
    │   └── favorites.blade.php     # Tampilan Daftar Film Favorit Terpilih
    └── partials/
        └── empty.blade.php         # Layout fallback jika pencarian/favorit kosong
routes/
└── web.php                         # Definisi Rute Web utama aplikasi
```

---

## 🧪 Panduan Pengujian Fitur (Testing & Features Walkthrough)

Setelah menjalankan aplikasi di browser Anda, silakan ikuti skenario pengujian berikut untuk memverifikasi fitur:

1.  **Pengujian Keamanan Rute**: Coba buka langsung URL `http://127.0.0.1:8000/favorites`. Sistem harus mengembalikan Anda ke halaman login dengan notifikasi bahwa Anda wajib masuk terlebih dahulu.
2.  **Skenario Autentikasi**: Masukkan username `aldmic` dan password `123abc123`. Anda akan diarahkan ke halaman pencarian film utama.
3.  **Pencarian & Infinite Scroll**: Ketik judul film di kotak pencarian (contoh: `Avengers`) dan tekan tombol Cari. Scroll halaman ke paling bawah, spiner loading akan muncul dan secara dinamis film halaman berikutnya akan termuat tanpa reload halaman.
4.  **Lazy Loading**: Perhatikan bahwa poster film tidak akan langsung dimuat sekaligus saat pencarian selesai. Gambar hanya akan didownload ketika poster tersebut hampir muncul di layar Anda sewaktu di-scroll.
5.  **Daftar Favorit Asinkron (AJAX)**: Tekan tombol **⭐ Favorite** pada salah satu film. Popup Alert sukses akan muncul di sudut kanan atas layar tanpa ada kedipan/reload halaman.
6.  **Pengujian Lokalisasi**: Klik menu **EN** atau **ID** di bagian kanan navbar. Semua teks statis pada navigasi, tombol, placeholder pencarian, hingga label detail film akan langsung berganti bahasa secara instan.
7.  **Manajemen Favorit**: Buka halaman **Film Favorit Saya** melalui navbar. Tekan tombol **🗑️ Remove** pada film yang ingin Anda hapus. Elemen card film tersebut akan menghilang secara halus dengan efek visual *fadeOut*, dan jumlah data dalam session akan terpotong secara instan via request AJAX DELETE.

---

## 📄 Lisensi

Proyek ini dirilis di bawah lisensi MIT. Silakan gunakan dan modifikasi untuk keperluan pembelajaran atau pengujian teknis lebih lanjut.