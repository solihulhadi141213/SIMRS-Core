# Cara Kerja Login pada SIMRS
## 1. Halaman Login (`login.php`)

Halaman utama login terletak di `_Page/Login/login.php`. Halaman ini terdiri dari:

- **Form masuk** untuk email, password, dan captcha
- **Opsi Login Google** melalui OAuth2
- **Link Pengajuan Akses** untuk pengguna baru
- **Link Lupa Password** untuk recuperasi password
## 2. Alur Proses Login

### 2.1. Inisialisasi (Ketika halaman dimuat)

Saat halaman login dimuat, `Login.js` melakukan:

1. Mengambil zona waktu browser menggunakan `GetBrowserTimezone()`
2. Menghasilkan ID captcha acak (`GenerateCaptchaId`)
3. Menyimpan ID captcha ke hidden field `#id_captcha`
4. Menampilkan captcha pertama kali melalui `GenerateCaptchaLogin()`
## 3. Login via Google OAuth2

### 3.1. Memulai alur Google (`LoginGoogle.php`)

Ketika user klik "Login Dengan Google":
1. `LoginGoogle.php` mengambil credential Google dari tabel `setting_google`
2. Memvalidasi timezone user yang dikirim
3. membangun URL otentikasi Google dengan scope `email profile`
4. Redirect user ke halaman otentikasi Google

### 3.2. Callback dari Google (`GoogleCallback.php`)

## 4. Pengajuan Akses Baru

Untuk pengguna yang belum memiliki akun, mereka dapat mengajukan permintaan akses melalui:

### 4.1. Modal Pengajuan Akses

Dibuka dari halaman login dengan tombol "Belum Punya Akun? Kirim Pengajuan Akses". Modal ini berisi form untuk:
- Nama lengkap
- NIK/KTP
- Nomor kontak
- Email
- Alamat
## 5. Reset Password

### 5.1. Memulai reset (`login.php`)

Ketika user klik "Lupa Password", menampilkan modal `#ModalResetPassword` yang meminta email pengguna.

### 5.2. Proses reset password (`ProsesResetPassword.php`)

1. **Validasi email** apakah terdaftar di database
2. **Cek setting email gateway** di tabel `setting_email_gateway`
3. **Generate token acak** (32 karakter) dan hash-nya menggunakan `password_hash`
4. **Simpan ke tabel `akses_reset`** dengan:
   - `id_akses` (dari tabel `akses`)
   - `datetime_creat` (waktu UTC)
## 6. Struktur Database yang Terlibat

Tabel-tabel utama yang digunakan dalam proses login:

| Tabel | Deskripsi |
|-------|-----------|
| `akses` | Data pengguna (id_akses, email, password_hash, nama, dll) |
| `akses_login` | Token login aktif (id_akses, login_token, expired_at, timezone) |
| `captcha` | Kode captcha yang masih valid (id_captcha, code_captcha, expired_at) |
| `setting_google` | Credential OAuth Google (client_id, client_secret) |
| `akses_pengajuan` | Permintaan akses baru (menunggu verifikasi admin) |
| `akses_reset` | Token reset password (id_akses, token_hash, expired) |

## 7. Kesimpulan

Sistem login SIMRS menggunakan pendekatan layered security:
1. **Captcha** untuk mencegah bot
2. **Waktu UTC** untuk konsistensi timestamp
3. **Password hashing** dengan `password_hash/`password_verify`
4. **Token-based login** dengan cookie yang memiliki masa berlaku 1 jam
5. **OAuth2 Google** sebagai opsi login alternatif
6. **Token reset password** dengan masa berlaku 1 jam dan satu pakai

Setiap proses divalidasi secara berkala dan memiliki mekanisme anti-expired serta one-time use untuk token.
   - `datetime_expired` (1 jam dari now UTC)
   - `token` (hash token)
5. **Buat link reset password**:
   - `$base_url/_Page/Login/ResetPassword.php?token=$plain_token&id=$id_akses_reset`
6. **Kirim email** ke pengguna melalui `SendEmail` yang berisi:
   - Link untuk reset password
   - Informasi bahwa link hanya berlaku 1 jam
   - Pesan keamanan jangan bagikan link

### 5.3. Halaman reset password (`ResetPassword.php`)

User diakses melalui link dari email yang mengandung parameter `?token=` dan `?id=`:
1. **Validasi id dan token** dari query string
2. **Verifikasi token** dengan `password_verify($token, $data['token'])`
3. Jika valid, menampilkan form untuk memasukkan password baru
4. Setelah password baru dimasukkan, menyimpan password baru ke database
5. **Hapus token** yang sudah digunakan dari tabel `akses_reset`
6. **Kirim email konfirmasi** tentang password berhasil di-reset
- Deskripsi kebutuhan akses
- Foto lampiran

### 4.2. Proses Pengajuan (`ProsesPengajuanAkses.php`)

Ketika form dikirim:
1. **Validasi field wajib** (nama, email, kontak, NIK, alamat, deskripsi, id_captcha, captcha)
2. **Validasi format email** dan kontak/NIK harus berupa angka
3. **Validasi captcha** (sama seperti proses login)
4. **Validasi upload foto**:
   - File wajib diupload
   - Maksimal ukuran 2MB
   - Ekstensi file yang diizinkan: jpg, jpeg, png, gif
   - Validasi MIME type
5. **Cek duplikat** email atau NIK di tabel `akses_pengajuan`
6. **Simpan pengajuan** ke tabel `akses_pengajuan` dengan status 'Pending'
7. **Kirim notifikasi sukses** atau error

Pengajuan diakses admin untuk diverifikasi dan diverifikasi sebelum user mendapatkan akun aktif.
Setelah user mengotorisasi di Google, sistem diterima di `GoogleCallback.php`:

1. **Ambil authorization code** dari parameter `code` di URL
2. **Ambil credential Google** (client_id, client_secret) dari database
3. **Tukar authorization code menjadi access token** dengan POST ke `https://oauth2.googleapis.com/token`
4. **Ambil info user Google** dari `https://www.googleapis.com/oauth2/v2/userinfo`
5. **Cek apakah email user terdaftar** di tabel `akses`
6. **Hapus token login lama** untuk `id_akses` yang sama
7. **Buat token login baru** dengan durasi 1 jam
8. **Set cookie** `id_akses` dan `login_token`
9. **Bersihkan session timezone** dan set notifikasi "Login Berhasil"
10. **Redirect ke halaman utama** (`../../index.php`)

Jika email Google tidak terdaftar di sistem, menampilkan pesan "Email Google tidak terdaftar pada sistem".

### 2.2. User Mengisi Form

User memasukkan:
- Email
- Password
- Kode Captcha (dari gambar yang ditampilkan)

### 2.3. Submit Form (dihandle oleh `Login.js`)

Ketika tombol login diklik, `Login.js` mengirim data form ke `ProsesLogin.php` melalui AJAX dengan metode POST. Data yang dikirim meliputi:
- email
- password
- captcha
- id_captcha
- timezone_user

### 2.4. Validasi di `ProsesLogin.php`

Proses `ProsesLogin.php` melakukan validasi berurutan:

1. **Validasi input wajib**: Memeriksa apakah email, password, captcha, dan id_captcha telah diisi
2. **Validasi captcha**: 
   - Mengecek apakah `id_captcha` ada di tabel `captcha`
   - Memastikan captcha belum expired (melalui `expired_at >= current_utc`)
   - Memverifikasi kode captcha menggunakan `password_verify($captcha, $DataCaptcha['code_captcha'])`
3. **Validasi format email**: Memastikan email memiliki format yang valid menggunakan `FILTER_VALIDATE_EMAIL`
4. **Validasi user di database**: Mencari user berdasarkan email dari tabel `akses`
5. **Validasi password**: Memverifikasi password menggunakan `password_verify($password, $DataAkses['password'])`

Jika validasi berhasil, lanjut ke pembuatan token. Jika gagal, mengembalikan respons JSON dengan pesan error.

### 2.5. Pembuatan Token Login

Setelah validasi lulus, `ProsesLogin.php`:

1. **Hapus captcha** setelah digunakan (sekali pakai) dari tabel `captcha`
2. **Hapus token lama** dari tabel `akses_login` untuk `id_akses` yang sama
3. **Generate token baru** menggunakan `generateStrongCode(36)`
4. **Simpan token ke database** ke tabel `akses_login` dengan:
   - `id_akses`
   - `login_token`
   - `creat_at` (waktu UTC)
   - `expired_at` (1 jam dari now UTC)
   - `local_timezone_user`
5. **Set cookie** untuk `id_akses` dan `login_token` dengan masa berlaku 1 jam
6. **Simpan log aktivitas** login berhasil melalui `SaveLog()`
7. **Kembalikan respons JSON** `{'status': 'success', 'message': 'Login Berhasil'}`

### 2.6. Respons dan Redirect

Setelah `login.php` menerima respons sukses dari `ProsesLogin.php`, terjadi:
- Menyimpan `NotifikasiSwal` di session
- Redirect ke halaman utama (`../../index.php`)

Jika login gagal, menampilkan pesan error di div `#NotifikasiLogin`.
- **Captcha** yang digenerate melalui `GenerateCaptcha.php`

### Komponen utama di `login.php`:
- Form `#ProsesLogin` yang dikirimkan via AJAX ke `ProsesLogin.php`
- Element `#GetUrlCaptcha` yang menampilkan gambar captcha
- Tombol `#ReloadCaptcha` untuk merefresh gambar captcha
- Tombol `#login_google` untuk login via Google
- Modal `#ModalPengajuanAkses` untuk pengajuan akses baru
- Modal `#ModalResetPassword` untuk reset password

Halaman ini menjelaskan alur kerja autentikasi dan proses login dalam aplikasi SIMRS, mulai dari halaman login hingga validasi dan pembuatan sesi token.