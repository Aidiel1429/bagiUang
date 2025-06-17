# 💰 BagiUang – Aplikasi Pembagian Uang Otomatis (Laravel + Livewire)

**BagiUang** adalah aplikasi web berbasis Laravel dan Livewire yang membantu pengguna membagi pemasukan tidak tetap ke dalam beberapa kategori penting seperti:
- Uang sehari-hari (jajan)
- Dana darurat
- Tabungan umum
- Dan Lain Lain

Kamu sebagai pengguna bebas menentukan sendiri **kategori dan persentase pembagian uang** sesuai kebutuhan. Setiap kali ada pemasukan, sistem akan secara otomatis membagi uang ke kategori berdasarkan pengaturanmu.

---

## 🚀 Fitur Utama

- ✅ Login & Register pengguna
- 💸 Tambah pemasukan
- 🧩 Buat kategori sendiri (contoh: jajan, tabungan HP, dll)
- ⚙️ Atur persentase alokasi untuk tiap kategori
- 🔄 Pembagian uang otomatis sesuai persentase kategori yang ditentukan pengguna
- 🗂️ Riwayat pemasukan & distribusi per kategori
- 📈 Statistik ringkas & laporan visual

---

## 🧰 Teknologi yang Digunakan

- Laravel 10+
- Livewire 3
- Blade Templates
- Tailwind CSS / DaisyUi
- MySQL

---

## 📦 Instalasi

### Persyaratan
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL

### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/username/bagiuang.git
cd bagiuang

# 2. Install dependency backend
composer install

# 3. Install dependency frontend
npm install && npm run dev

# 4. Copy file .env
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Konfigurasi database di file .env

# 7. Jalankan migrasi database
php artisan migrate

# 8. Jalankan server lokal
php artisan serve
