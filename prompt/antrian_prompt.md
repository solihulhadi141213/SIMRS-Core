Saya sudah memperbaharuii struktur database pada `_Database\schema.sql`.
Buatkan fitur 'Antrian' pada directory `_Page\Antrian` dengan gaya coding dan pola interaksi seperti pada fitur lain. 
Baca `.agentrules` sebelum memulai.
1. Pahami beberapa hal berikut :
  - Handdling javascript ditulis pada `_Page\Antrian\Antrian.js`
  - Form dibuat dalam bentuk modal `_Page\Antrian\ModalAntrian.php`
  - Data dibuat dalam bentuk tabel dengan pagging, filter dan action handle pada `_Page\Antrian\TabelAntrian.php`
  - Tabel antrian memiliki pagging.
  - Nomor antrian menyesuaikan jadwal dokter.
  
2. Penjelasan Atribut Tabel:
  - No               : Nomor urut tabel
  - Nama             : Nama lengkap pasien. Apabila belum ada id_pasien maka text berwarna abu-abu dan tidak bisa click. Sebaliknya jika ada maka clickable dan data ditampilkan dalam bentuk card.
  - Kode Booking     : Kode booking antrian
  - Daftar           : Tanggal daftar antrian (Ditampilkan sesuai zona waktu user)
  - Rencana Kunjungan: Tanggal rencana kunjungan (Ditampilkan sesuai zona waktu user)
  - Poliklinik       : Nama Poliklinik,               jika id_poliklinik tidak ada maka data poliklinik sudah dihapus dan tampilkan text berwarna merah. Sebaliknya jika ada maka text clickable dan menampilkan. detail poliklinik.
  - Dokter           : Nama Dokter,                   jika id_dokter tidak ada maka data dokter sudah dihapus dan tampilkan text berwarna merah. Sebaliknya jika ada maka text clickable dan menampilkan. detail dokter.
  - Jadwal           : menampilkan jam mulai dan jam berakhir
  - RM               : Apabila sudah memiliki id_pasien maka data tersebut menampilkan label hijau
  - Kunjungan        : pabila sudah memiliki id_kunjungan maka data tersebut menampilkan label hijau
  - Sumber           : Dari mana data antrian datang, secara default antrian yang dibuat manual akan berisikan Manual.
  - Status           : Status antrian sesuai database
  - Opsi             : Tombol Action,                 untuk menampilkan detail, Edit, Delete
3. Filter
    - Ordfer By dan Keyword By sesuai kolom pada tabel
    - Form Dinamis pada keyword jika Ordfer ByOrdfer By diubah
4. Form Tambah
  - Proses tambah pada fitur ini adalah proses manual.
  - Data antrian yang diisi oleh modul lain menggunakan API, namun hal ini tidak perlu dipikirkan dulu.
  - Pada proses tambah antrian, user dapat memilih dari data pasien yang sudah ada atau membuat data pasien baru menggunakan select2.
5. Detail Data
  - Dapat menampilkan detail antrian
  - Dapat menampilkan Riwayat perubahan status antrian (Riwayat Pelayanan)
  - User dapat mendaftarkan pasien baru melalui data antrian dengan beberapa tambahan informasi pada form.
  - User dapat memperbaharui data antrian ini.