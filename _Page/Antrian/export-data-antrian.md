# Export Data Antrian
Fitur export data antrian dilakukan pada form yang ada di '_Page\Antrian\ModalAntrian.php' pada bagian 'MODAL EXPORT ANTRIAN'.
Secara default, 'periode_data' akan bernilai 'Semua' dan pada saat modal form export muncul pertama kali, sistem akan menghitung jumlah semua data antrian dan menampilkannya pada element dengan id 'NotifikasiJumlahDataAntrian'
Button 'ButtonExport' secara default 'disabled', ketika sistem mengetahui bahwa data antrian ada, maka jquery akan mengubah tombol tersebut menjadi enable.

## Ketika select option 'periode_data' diubah :
1. Apabila bernilai 'Semua' maka element id 'FormLanjutanExport' kosong.
2. Apabila bernilai 'Tahun' maka element id 'FormLanjutanExport' akan menampilkan form input number yang sudah terisi dengan tahun sekarang.
3. Apabila bernilai 'Bulan' maka element id 'FormLanjutanExport' akan menampilkan form input number yang sudah terisi dengan tahun sekarang dan select option list bulan dengan value 01-12.
4. Apabila bernilai 'Periodik' maka element id 'FormLanjutanExport' akan menampilkan form periode awal dan periode akhir dengan type input date.

## Proses Export
Proses export akan dilakukan oleh file '_Page\Antrian\ProsesExportAntrian.php' dengan metode POST.
Pada proses export, sistem melakukan validasi mandatory sesuai 'periode_data', melakukan validasi sesi akses dan metode pengiriman data harus POST.
Sistem melakukan filter data dari tabel antrian serta melakukan join dengan tabel lain yang berelasi.
Sistem akan melakukan download file excel dengan menggunakan pustaka PHPoffice yang sudah ada pada project ini.