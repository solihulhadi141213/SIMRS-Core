Baca `.agentrules` sebagai pedoman awal. 
Struktur database saya ada di : `_Database\elsyifa_core.sql_Database\elsyifa_core.sql_Database\elsyifa_core.sql`
Buatkan sebuah file php yang akan di panggil menggunakan php CLI  dengan nama `instal.php` yang berfungsi mempersiapkan database agar bisa langsung digunakan satu kali pada saat pertama kali aplikasi diinstal pada server. 
Adapun record yang perlu dibentuk pertama kali tersebut diantaranya adalah :
1. Membuat record default untuk tabel `akses_entitas` (menambahkan level entitas akses default) untuk pertama kali. 
Record berisikan data berikut :
  - akses    : 'Admin',
  - deskripsi: 'User Default Level'
2. Membuat record pada tabel `akses_fitur` sesuai file `default_reference_feature_code.json`
3. Membuat record pada tabel `akses_entitas_acc` yang memasangkan `akses_entitas` yang dibuat tadi dengan semua daftar pada tabel `akses_fitur`.
4. Membuat record pada tabel `akses` dengan record :
  - id_akses_pengajuan :
  - tanggal : Default waktu sekarang dengan timezone UTC.
  - nama : berisi 'Admin Faskes'
  - nik : kosong
  - ihs : kosong
  - email : Sesuai input user
  - password : Sesuai input user
  - akses : Sesuai akses entitas ('Admin')
  - gambar : kosong
  - updatetime : Default waktu sekarang dengan timezone UTC.
5. Membuat record pada tabel 'akses_acc' dengan memasangkan semua `id_akses_fitur` ke `id_akses` yang telah dibuat.
