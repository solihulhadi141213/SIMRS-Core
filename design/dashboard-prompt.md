Baca `.agentrules` Kemudian perbaiki halaman dashboard agar sesuai desain `design\dashboard.png` dengan ketentuan sebagai berikut :
1. Pada bagian kanan judul halaman terdapat Breadcrumb.
2. Hanya text Judul halaman `clickabled` dan Breadcrumb induk.
3. Chart menggunakan apexchart.
4. Simple Donut pada kategori pelayanan menampilkan jumlah total kunjungan berdasarkan jenis_kunjungan Ranap atau Rajal hingga sekarang.
5. Pembiayaan menampilkan jumlah total kunjungan berdasarkan pembayaran_metode
6. Pasien Existing menampilkan list kunjungan terbaru berdasarkan datetime_daftar dengan status Terdaftar. Data ditampilkan menggunakan infinity scroll menggunakan jquery.
7. Jumlah dokter, poiliklinik, tempat tidur dan data pasien dihitung pada `_Page\Dashboard\GetCount.php` dan ditampilkan dengan jquery.
8. Grafik kunjungan pasien menampilkan grafik dengan apexchart. Secara default menampilkan data kunjungan dengan periode tahun sekarang yang menampilkan bulan Januari sampai desember. Tombol 'Periode' yang ada pada pojok kanan card, berfungsi merubah periode data. Apabila user memilih tombol tersebut maka sistem akan membuka modal yang menampilkan form pilihan periode 'Tahun, atau Bulan' kemudian jika memilih tahun maka user akan disuruh memasukan angka tahun dengan default tahun sekarang. Sebaliknya, jika bulan, maka user akan disuruh memasukan angka tahun dan memilih nama bulan.
