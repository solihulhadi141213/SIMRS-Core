# Workflow 'Pendaftaran Kunjungan Melalui Antrian'
User dapat mendaftarkan pasien yang berasal dari data antrian (tabel 'antrian') yang sudah ada ke dalam data kunjungan (tabel 'kunjungan'). Proses insert pendaftaran kunjungan dilakukan oleh script PHP `_Page\Antrian\ProsesPendaftaranKunjungan.php`. Agent perlu memahami struktur tabel 'kunjungan' pada directory `_Database\schema.sql`
Adapun script tersebut melakukan hal berikut ini :

## Validasi Sessiion Akses
Memastikan bahwa user telah melakukan login sebelumnya dengan adanya nilai pada $'SessionIdAkses'.

## Validasi mandatori
1. Memastikan form hidden 'id_antrian' tidak kosong.
2. Memstikan data 'id_antrian' valid atau ada pada tabel 'antrian'
3. Memastikan data 'id_pasien' tidak kosong dan melakukan validasi bahwa 'id_pasien' ada pada tabel pasien.
4. memastikan data 'prioritas' tidak kosong.
5. Memastikan 'jenis_kunjungan' tidak kosong, dimana dalam hal ini data antrian untuk 'jenis_kunjungan' selalu bernilai 'Rajal'.
6. Memastikan 'id_dokter' tidak kosong. dalam hal ini, sistem membuka tabel 'antrian' dan memastikan id_dokter sudah ada pada tabel tersebut.
7. Memastikan 'kode_dokter' ada pada tabel 'dokter' berdasarkan 'id_dokter' yang terdaftar.
8. Memastikan 'nama' terdaftar pada tabel dokter berdasarkan 'id_dokter' sebagai 'nama_dokter' (yang nantinya akan disimpan sebagai 'dokter' pada tabel kunjungan)
9. 'dpjp_id' diisi dengan nilai 'id_dokter'
10. 'dpjp_kode' diisi dengan nilai 'kode_dokter'
11. 'dpjp_nama' diisi dengan nilai 'nama_dokter'
12. Sistem membuka tabel poliklinik berdasarkan 'id_poliklinik' pada tabel antrian, memastikan data ditemukan dan menyiapkan 'poliklinik' dan 'nama'
13. 'kelas', 'ruang_rawat', 'tempat_tidur' dikosongkan atau tidak perlu diinput.
14. Memastikan 'pembayaran_metode' diisi pada form.
15. 'status' secara default bernilai 'Terdaftar'
16. 'petugas_id' dan 'petugas_nama' menyesuaikan nilai yang berasal dari '_Config\Session.php'
17. 'datetime_daftar' diisi dengan tanggal dan waktu sekarang dalam format UTC.
18. datetime_pelayanan dan datetime_selesai boleh dikosongkan.

## Debuging
Setiap kesalahan harus diterangkan penyebabnya dengan jelas. Apakah kesalahan script PHP, query database atau data yang tidak valid.