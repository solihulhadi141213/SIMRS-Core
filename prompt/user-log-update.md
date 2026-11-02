Saya telah memperbaharui struktur database, pada tabel 'log'. 
Menambahkan atribut 'category_log' yang berfungsi mencatat nama fitur. 
Nama fitur biasanya sama dengan nama folder script tersebut berada, misalnya '_Page/Akses' maka nama fiturnya adalah 'Akses'.
Saya juga melakukan pembaharuan pada `_Config\SimrsFunction.php` pada bagian function 'SaveLog' yang berfungsi menyimpan log aktivitas user.
Periksa  satu per satu semua script PHP yang ada pada directory `_Page`. 
Cari script yang bertugas menyimpan data ke tabel 'log' baik menggunakan function 'SaveLog' atau menyimpan log secara langsung.
Tambahkan parameter 'category_log' sesuai nama fiturnya.


Perbaiki script PHP `_Page\Login\ProsesLogin.php`, `_Page\Login\ProsesPengajuanAkses.php`, `_Page\Login\ProsesResetPassword.php`, `_Page\Login\ResetPassword.php` catat log pada tabel log menggunakan function 'SaveLog' yang ada di `_Config\SimrsFunction.php` dengan syarat jika 'id_akses', proses berhasil dan memenuhi syarat kelengkapan data sesuai atribut tabel 'log'