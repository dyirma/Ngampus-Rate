# Dokumentasi Presentasi — Ngampus_Rate

Dokumen ini disiapkan untuk bahan presentasi ke pihak kampus. Berisi ringkasan arsitektur, komponen penting, langkah setup, alur demo, dan slide outline.

**Ringkasan Proyek**:
- **Nama**: Ngampus_Rate
- **Tujuan**: Sistem kuisioner penilaian dosen dan layanan kampus berbasis Laravel + Livewire.
- **Fungsi utama**: Mahasiswa mengisi kuisioner (kategori umum atau per-dosen), admin melihat laporan dan meng-export hasil.

**Teknologi & Dependensi Utama**:
- Backend: PHP ^8.2, Laravel Framework ^12.0 ([composer.json](composer.json))
- Frontend & tooling: Vite, TailwindCSS, AlpineJS ([package.json](package.json))
- Livewire ^3.7 untuk komponen interaktif
- Excel export: maatwebsite/excel
- Dev tools: Laravel Breeze, Pint, Sail, PHPUnit

**Instalasi & Setup Singkat**
1. Clone repository dan masuk folder: `cd Ngampus_Rate`
2. Salin environment: `cp .env.example .env` lalu sesuaikan DB dan konfigurasi lain.
3. Install PHP dependensi: `composer install`
4. Generate key: `php artisan key:generate`
5. Jalankan migrasi & seeder: `php artisan migrate --seed`
6. Install npm: `npm install` lalu jalankan `npm run dev` untuk development atau `npm run build` untuk produksi.
7. Jalankan server: `php artisan serve`

Catatan: ada script composer `setup` yang otomatis menjalankan beberapa langkah di atas (lihat `composer.json` -> `scripts`).

**Struktur Data & Migrasi Penting**
- Tabel user: `database/migrations/0001_01_01_000000_create_users_table.php`
- Dosen: `2025_11_24_173739_create_dosens_table.php`
- Kuisioner & Pertanyaan: `2025_11_24_173744_create_kuisioners_table.php`, `2025_11_24_173750_create_pertanyaans_table.php`
- Sub-kategori dan questions: `2026_01_09_032027_create_sub_categories_table.php`, `2026_01_09_032051_create_questions_table.php`
- Jawaban: `2026_01_09_042744_recreate_jawabans_table.php`

**Model Utama (ringkasan)**
- `App\\Models\\Kuisioner` — merepresentasikan kategori kuisioner; relasi `children`, `parent`, `pertanyaan`.
- `App\\Models\\SubCategory` — sub-bagian dari kategori; relasi `questions`.
- `App\\Models\\Question` — pertanyaan per-subkategori (disimpan di `questions` table), tipe jawaban (`likert`/`text`/`dropdown`).
- `App\\Models\\Jawaban` — menyimpan jawaban: `user_id`, `question_id`, `dosen_id`, `nilai_jawaban`, `teks_jawaban`, metadata responden.
- `App\\Models\\Dosen` — daftar dosen, relasi `jawaban`.
- `App\\Models\\Category` — kategori tingkat atas; relasi `subCategories`.

Lihat implementasi model di `app/Models/` untuk detail properti `$fillable` dan relasi.

**Komponen Livewire**
- `App\\Livewire\\KuisionerForm` (resources/views/livewire/kuisioner-form.blade.php)
  - Fungsi: menampilkan alur multi-step untuk mengisi kuisioner.
  - Alur: landing (step 0) → data diri (step 1) → sub-kategori pertanyaan (step 2..n) → review → submit.
  - Validasi dinamis dilakukan per sub-kategori. Jawaban disimpan ke `jawabans` pada `submit()`.
  - Menggunakan computed properties `currentSubCategory()` dan `summaryData()`.
- `App\\Livewire\\AdminDashboard` — komponen dashboard admin (lihat file terkait dan view `resources/views/livewire/admin-dashboard.blade.php`).

**Controller & Routes Penting**
- `routes/web.php`:
  - `/` — halaman welcome
  - `/dashboard` — dashboard umum (`auth`, `verified` middleware)
  - `/kuisioner/{kategori}` — route Livewire untuk pengisian kuisioner (`auth`, `verified`)
  - `/thank-you` — halaman terima kasih setelah submit
  - `admin/*` prefix — route untuk dashboard admin (middleware `auth`)

**View Penting**
- Form kuisioner: `resources/views/livewire/kuisioner-form.blade.php` (UI multi-step, styling Tailwind)
- Dashboard admin: `resources/views/admin/dashboard.blade.php`
- CRUD admin untuk `dosen`, `pertanyaan`, `kuisioner`: folder `resources/views/admin/*`

**Export & Laporan**
- `App\\Exports\\LaporanPenilaianExport` — helper untuk export hasil penilaian ke Excel (pakai Maatwebsite/Excel).

**Cara Demo (alur singkat untuk presentasi)**
1. Tampilkan dashboard utama (`/dashboard`) — jelaskan struktur kategori & subkategori.
2. Masuk sebagai user mahasiswa (gunakan akun seeder jika ada) → buka `/kuisioner/dosen`.
3. Tunjukkan alur multi-step: pilih dosen → isi skala likert untuk setiap sub-bagian → beri komentar untuk pertanyaan open-text.
4. Review dan submit → tampilkan `thank-you`.
5. Masuk sebagai admin → buka `admin/dashboard` → tampilkan fitur export laporan ke Excel.

**Slide Outline (saran 10 slide)**
1. Judul & Tim — nama proyek, tujuan singkat.
2. Masalah & Solusi — latar kebutuhan evaluasi dosen.
3. Arsitektur teknis — stack (Laravel, Livewire, Tailwind, Vite).
4. Alur data — ER diagram sederhana (Users, Dosen, Kuisioner, Question, Jawaban).
5. Demo: Mengisi Kuisioner — screenshot / live demo (step-by-step).
6. Demo: Dashboard Admin & Export — contoh file Excel.
7. Keamanan & Validasi — autentikasi, middleware, validasi dinamis pada Livewire.
8. Skalabilitas & Pengembangan ke depan — fitur yang bisa ditambahkan (analitik, grafik, peran lebih detail).
9. Setup dan deployment singkat — perintah penting untuk menjalankan aplikasi.
10. Tanya Jawab & Kontak — tautan repo dan kontak pembuat.

**File yang direkomendasikan ditampilkan saat presentasi**
- [app/Livewire/KuisionerForm.php](app/Livewire/KuisionerForm.php)
- [resources/views/livewire/kuisioner-form.blade.php](resources/views/livewire/kuisioner-form.blade.php)
- [app/Models/Jawaban.php](app/Models/Jawaban.php)
- [app/Exports/LaporanPenilaianExport.php](app/Exports/LaporanPenilaianExport.php)
- [routes/web.php](routes/web.php)

