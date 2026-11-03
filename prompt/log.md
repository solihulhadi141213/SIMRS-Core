Buatkan script PHP untuk `_Page\Log\FormPeriode.php` yang berfungsi untuk menentukan form lanjutan dari `_Page\Log\ModalLog.php`
Apabila Tahunan maka sistem tidak akan menampilkan form lanjutan apapun (kosong)
Apabila bulanan maka akan menampilkan form input number yang secara default berisikan tahun sekarang.
Apabila Harian maka akan menampilkan form tahun input number dan select option nomor bulan.

# Log Pengguna dan Kategori
Sebelum lanjut pelajari `.agentrules` dan `README.md`
Buatkan script Jquery yang ditulis pada block `// Menampilkan List Log Pengguna` dengan nama function `showLogPengguna` dan `// Menampilkan List Log Kategori` dengan nama function `showLogKategori`. 
Berfungsi untuk menampilkan data list pada element id `list_pengguna` dan `list_kategori`.
Buatkan Script PHP `_Page\Log\TabelLogPengguna.php` dan `_Page\Log\TabelLogKategori.php` yang berfungsi sebagai backend yang meenampilkan data dari database.
## Log Pengguna 'list_pengguna'
Berfungsi menampilkan data list jumlah log Berdasrkan 'nama_petugas'.
- Jquery akan mengisi konten di dalam 'list_pengguna'
- Function Jquery ditulis pada block '// Menampilkan List Log Pengguna'
- Jquery bertugas menampilkan data dari backend `_Page\Log\TabelLogPengguna.php` menggunakan Ajax dengan filter dari modal 'id="ModalFilterPengguna"'.
- Data ditampilkan berdasarkan filter dari 'id="ProsesFilterPengguna"'.
## Log Kategori 'list_kategori'
Berfungsi menampilkan data list jumlah log berdasarkan category_log.
- Jquery akan mengisi konten di dalam 'list_kategori'
- Function Jquery ditulis pada block '// Menampilkan List Log Kategori'
- Jquery bertugas menampilkan data dari backend `_Page\Log\TabelLogKategori.php` menggunakan Ajax dengan filter dari modal 'id="ModalFilterKategori"'.
- Data ditampilkan berdasarkan filter dari 'id="ProsesFilterKategori"'.
