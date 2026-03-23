<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Cek Session
    if(empty($SessionIdAkses)){
        echo '<div class="text-danger">Mohon maaf, anda telah logout. Silahkan login kembali untuk menambahkan data kunjungan!</div>';
    }else{
        $now=date('Y-m-d H:i');
        $LogJsonFile="../../_Page/Log/Log.json";
        //validasi variabel wajib
        if(empty($_POST['id_pasien'])){
            echo '<div class="text-danger">No.RM pasien tidak boleh kosong</div>';
        }else{
            if(empty($_POST['nama'])){
                echo '<div class="text-danger">Nama pasien tidak boleh kosong</div>';
            }else{
                if(empty($_POST['tanggal'])){
                    echo '<div class="text-danger">Tanggal pendaftaran tidak boleh kosong</div>';
                }else{
                    if(empty($_POST['waktu'])){
                        echo '<div class="text-danger">Waktu/Jam pendaftaran tidak boleh kosong</div>';
                    }else{
                        if(empty($_POST['DiagAwal'])){
                            echo '<div class="text-danger">Diagnosa awal tidak boleh kosong</div>';
                        }else{
                            if(empty($_POST['keluhan'])){
                                echo '<div class="text-danger">Keluhan pasien tidak boleh kosong</div>';
                            }else{
                                if(empty($_POST['id_dokter'])){
                                    echo '<div class="text-danger">Dokter tujuan tidak boleh kosong</div>';
                                }else{
                                    if(empty($_POST['pembayaran'])){
                                        echo '<div class="text-danger">Metode Pembayaran tidak boleh kosong</div>';
                                    }else{
                                        if(empty($_POST['status'])){
                                            echo '<div class="text-danger">Status Pendaftaran tidak boleh kosong</div>';
                                        }else{
                                            //Inisiasi masing-masing variabel
                                            $id_pasien=$_POST['id_pasien'];
                                            $nama=$_POST['nama'];
                                            $tanggal=$_POST['tanggal'];
                                            $waktu=$_POST['waktu'];
                                            $TanggalWaktu="$tanggal $waktu";
                                            $DiagAwal=$_POST['DiagAwal'];
                                            $keluhan=$_POST['keluhan'];
                                            $id_poliklinik=$_POST['id_poliklinik'];
                                            $id_dokter=$_POST['id_dokter'];
                                            if(empty($_POST['id_encounter'])){
                                                $id_encounter="";
                                            }else{
                                                $id_encounter=$_POST['id_encounter'];
                                            }
                                            if(empty($_POST['id_poliklinik'])){
                                                $id_poliklinik="";
                                            }else{
                                                $id_poliklinik=$_POST['id_poliklinik'];
                                            }
                                            if(empty($_POST['id_antrian'])){
                                                $id_antrian="";
                                            }else{
                                                $id_antrian=$_POST['id_antrian'];
                                            }
                                            if(empty($_POST['no_antrian'])){
                                                $no_antrian="";
                                            }else{
                                                $no_antrian=$_POST['no_antrian'];
                                            }
                                            if(empty($_POST['nik'])){
                                                $nik="";
                                            }else{
                                                $nik=$_POST['nik'];
                                            }
                                            if(empty($_POST['no_bpjs'])){
                                                $no_bpjs="";
                                            }else{
                                                $no_bpjs=$_POST['no_bpjs'];
                                            }
                                            if(empty($_POST['sep'])){
                                                $sep="";
                                            }else{
                                                $sep=$_POST['sep'];
                                            }
                                            if(empty($_POST['noRujukan'])){
                                                $noRujukan="";
                                            }else{
                                                $noRujukan=$_POST['noRujukan'];
                                            }
                                            if(empty($_POST['skdp'])){
                                                $skdp="";
                                            }else{
                                                $skdp=$_POST['skdp'];
                                            }
                                            if(empty($_POST['UrlForBack'])){
                                                $UrlForBack="index.php?Page=RawatJalan";
                                            }else{
                                                $UrlForBack=$_POST['UrlForBack'];
                                            }
                                            
                                            if(empty($_POST['rujukan_dari'])){
                                                $rujukan_dari="";
                                            }else{
                                                $rujukan_dari=$_POST['rujukan_dari'];
                                            }
                                            if(empty($_POST['rujukan_ke'])){
                                                $rujukan_ke="";
                                            }else{
                                                $rujukan_ke=$_POST['rujukan_ke'];
                                            }
                                            $pembayaran=$_POST['pembayaran'];
                                            $status=$_POST['status'];
                                            if(empty($_POST['cara_keluar'])){
                                                $cara_keluar="";
                                            }else{
                                                $cara_keluar=$_POST['cara_keluar'];
                                            }
                                            if(empty($_POST['tanggal_keluar'])){
                                                $tanggal_keluar="";
                                            }else{
                                                $tanggal_keluar=$_POST['tanggal_keluar'];
                                            }
                                            if(empty($_POST['tujuan'])){
                                                $tujuan="";
                                            }else{
                                                $tujuan=$_POST['tujuan'];
                                            }
                                            if(empty($_POST['id_kasur'])){
                                                $id_kasur="";
                                            }else{
                                                $id_kasur=$_POST['id_kasur'];
                                            }
                                            //Buka data pasien
                                            $propinsi=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'propinsi');
                                            $kabupaten=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kabupaten');
                                            $kecamatan=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'kecamatan');
                                            $desa=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'desa');
                                            $alamat=getDataDetail($Conn,'pasien','id_pasien',$id_pasien,'alamat');
                                            //Buka nama dokter
                                            $kode_dokter=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'kode');
                                            $nama_dokter=getDataDetail($Conn,'dokter','id_dokter',$id_dokter,'nama');
                                            //Buka nama poliklinik
                                            $kode_poliklinik=getDataDetail($Conn,'poliklinik','id_poliklinik',$id_poliklinik,'kode');
                                            $nama_poli=getDataDetail($Conn,'poliklinik','id_poliklinik',$id_poliklinik,'nama');
                                            //Buka nama ruang_kelas
                                            $id_ruang_rawat=getDataDetail($Conn,'ruang_rawat','id_ruang_rawat',$id_kasur,'id_ruang_rawat');
                                            $kelas=getDataDetail($Conn,'ruang_rawat','id_ruang_rawat',$id_kasur,'kelas');
                                            $ruangan=getDataDetail($Conn,'ruang_rawat','id_ruang_rawat',$id_kasur,'ruangan');
                                            $bed=getDataDetail($Conn,'ruang_rawat','id_ruang_rawat',$id_kasur,'bed');
                                            //Updatetime
                                            $updatetime=date('Y-m-d H:i:s');

                                            //Khusus Untuk Rajal Tidak Boleh Duplikat Kunjungan Di hari Yang sama ke poli yang sama
                                            $ValidasiDuplikatData = mysqli_num_rows(mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan_utama WHERE (id_pasien='$id_pasien' AND id_poliklinik='$id_poliklinik' AND tujuan='Rajal') AND (tanggal like '%$tanggal%')"));
                                            if(!empty($ValidasiDuplikatData)){
                                                echo '<div class="text-danger">Tidak bisa melakukan pendaftaran untuk pasien dan poliklinik yang sama di hari yang sama</div>';
                                            }else{
                                                //Lakukan input ke database
                                                $entry="INSERT INTO kunjungan_utama (
                                                    id_encounter,
                                                    id_pasien,
                                                    no_antrian,
                                                    nik,
                                                    no_bpjs,
                                                    sep,
                                                    noRujukan,
                                                    skdp,
                                                    nama,
                                                    tanggal,
                                                    propinsi,
                                                    kabupaten,
                                                    kecamatan,
                                                    desa,
                                                    alamat,
                                                    keluhan,
                                                    tujuan,
                                                    id_dokter,
                                                    dokter,
                                                    id_poliklinik,
                                                    poliklinik,
                                                    kelas,
                                                    ruangan,
                                                    id_kasur,
                                                    DiagAwal,
                                                    rujukan_dari,
                                                    rujukan_ke,
                                                    pembayaran,
                                                    cara_keluar,
                                                    tanggal_keluar,
                                                    status,
                                                    id_akses,
                                                    nama_petugas,
                                                    updatetime
                                                ) VALUES (
                                                    '$id_encounter',
                                                    '$id_pasien',
                                                    '$no_antrian',
                                                    '$nik',
                                                    '$no_bpjs',
                                                    '$sep',
                                                    '$noRujukan',
                                                    '$skdp',
                                                    '$nama',
                                                    '$TanggalWaktu',
                                                    '$propinsi',
                                                    '$kabupaten',
                                                    '$kecamatan',
                                                    '$desa',
                                                    '$alamat',
                                                    '$keluhan',
                                                    '$tujuan',
                                                    '$id_dokter',
                                                    '$nama_dokter',
                                                    '$id_poliklinik',
                                                    '$nama_poli',
                                                    '$kelas',
                                                    '$ruangan',
                                                    '$id_ruang_rawat',
                                                    '$DiagAwal',
                                                    '$rujukan_dari',
                                                    '$rujukan_ke',
                                                    '$pembayaran',
                                                    '$cara_keluar',
                                                    '$tanggal_keluar',
                                                    '$status',
                                                    '$SessionIdAkses',
                                                    '$SessionNama',
                                                    '$updatetime'
                                                )";
                                                $hasil=mysqli_query($Conn, $entry);
                                                if($hasil){
                                                    //Mencari id_kunjungan yang baru saja di input
                                                    $QryDetailKunjungan= mysqli_query($Conn, "SELECT * FROM kunjungan_utama WHERE id_akses='$SessionIdAkses' AND updatetime='$updatetime'")or die(mysqli_error());
                                                    $DataDetailKunjungan = mysqli_fetch_array($QryDetailKunjungan);
                                                    //Apabila Kunjungan Tidak ditemukan
                                                    if(empty($DataDetailKunjungan['id_kunjungan'])){
                                                        echo '<span class="text-danger">Maaf, Data kunjungan yang baru saja anda input tidak ditemukan</span>';
                                                    }else{
                                                        $id_kunjungan = $DataDetailKunjungan['id_kunjungan'];
                                                        
                                                        //INTEGRASI MIGRASI DENGAN SIMRS LAMA
                                                        //Cek apakah id_pasien ada di simrs lama
                                                        include "../../_Config/ConnectionSimLama.php";
                                                        include "../../_Config/ConnectionMigrasi.php";
                                                        $validasi_pasien_lama=mysqli_num_rows(mysqli_query($Conn2, "SELECT id_pasien FROM pasien WHERE id_pasien='$id_pasien'"));
                                                        if(!empty($validasi_pasien_lama)){
                                                            //Apabila Pasien Ditemukan
                                                            //Inisiasi Referensi Akses Dari Database Migrasi
                                                            $id_petugas=getDataDetail($Conn3,'referensi_akses','id_akses_tujuan',$SessionIdAkses,'id_akses_asal');
                                                            $nama_petugas=getDataDetail($Conn3,'referensi_akses','id_akses_tujuan',$SessionIdAkses,'nama_akses_asal');
                                                            if(empty($nama_petugas)){
                                                                $nama_petugas=$SessionNama;
                                                            }
                                                            //Inisiasi Referensi Poliklinik Dari Database Migrasi
                                                            $idPoli=getDataDetail($Conn3,'poliklinik_replacemnet','id_poliklinik_to',$id_poliklinik,'id_poliklinik_from');
                                                            $namaPoli=getDataDetail($Conn3,'poliklinik_replacemnet','id_poliklinik_to',$id_poliklinik,'nama_from');
                                                            if(empty($namaPoli)){
                                                                $namaPoli=$nama_poli;
                                                            }
                                                            //Inisiasi Referensi Dokter Dari Database Migrasi
                                                            $idDokter=getDataDetail($Conn3,'dokter_replacemnet','id_dokter_to',$id_dokter,'id_dokter_from');
                                                            $namaDokter=getDataDetail($Conn3,'dokter_replacemnet','id_dokter_to',$id_dokter,'nama_dokter_from');
                                                            if(empty($namaDokter)){
                                                                $namaDokter=$nama_dokter;
                                                            }
                                                            
                                                            //Simpan ke Kunjungan SIMRS Lama
                                                            $query = "INSERT INTO kunjungan (
                                                                id_pasien,
                                                                sep,
                                                                noRujukan,
                                                                skdp,
                                                                nama,
                                                                tanggal,
                                                                propinsi,
                                                                kabupaten,
                                                                kecamatan,
                                                                desa,
                                                                rt_rw,
                                                                keluhan,
                                                                tujuan,
                                                                id_dokter,
                                                                dokter,
                                                                id_poliklinik,
                                                                poli,
                                                                kelas,
                                                                ruangan,
                                                                id_kasur,
                                                                DiagAwal,
                                                                rujukan_dari,
                                                                rujukan_ke,
                                                                pembayaran,
                                                                cara_keluar,
                                                                tanggal_keluar,
                                                                status,
                                                                id_petugas,
                                                                nama_petugas,
                                                                updatetime
                                                            ) VALUES (
                                                                ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                                                            )";

                                                            // Mempersiapkan statement
                                                            $stmt = $Conn2->prepare($query);

                                                            // Periksa apakah statement berhasil dipersiapkan
                                                            if (!$stmt) {
                                                                $validasi_migrasi = "Gagal mempersiapkan statement: " . $Conn2->error;
                                                            } else {
                                                                // Bind parameter ke statement
                                                                $stmt->bind_param(
                                                                    "ssssssssssssssssssssssssssssss",
                                                                    $id_pasien,
                                                                    $sep,
                                                                    $noRujukan,
                                                                    $skdp,
                                                                    $nama,
                                                                    $tanggal,
                                                                    $propinsi,
                                                                    $kabupaten,
                                                                    $kecamatan,
                                                                    $desa,
                                                                    $rt_rw,
                                                                    $keluhan,
                                                                    $tujuan,
                                                                    $idDokter,
                                                                    $namaDokter,
                                                                    $idPoli,
                                                                    $namaPoli,
                                                                    $kelas,
                                                                    $ruangan,
                                                                    $id_kasur,
                                                                    $DiagAwal,
                                                                    $rujukan_dari,
                                                                    $rujukan_ke,
                                                                    $pembayaran,
                                                                    $cara_keluar,
                                                                    $tanggal_keluar,
                                                                    $status,
                                                                    $id_petugas,
                                                                    $nama_petugas,
                                                                    $updatetime
                                                                );

                                                                // Eksekusi statement
                                                                if ($stmt->execute()) {
                                                                    $validasi_migrasi = "Valid";
                                                                } else {
                                                                    $validasi_migrasi = "Gagal menambahkan data: " . $stmt->error;
                                                                }
                                                            }
                                                        }else{
                                                            $validasi_migrasi="Pasien Tidak Ditemukan Pada Database SIMRS Yang Lama. Pastikan SIMRS Terhubung Dengan Baik.";
                                                        }
                                                        if($validasi_migrasi!=="Valid"){
                                                            //Hapus Kunjungan Yang Sudah Diinput
                                                            $HapusKunjunganTidakValid = mysqli_query($Conn, "DELETE FROM kunjungan_utama WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                                                            echo '<span class="text-danger">'.$validasi_migrasi.'</span>';
                                                        }else{
                                                            if(empty($id_antrian)){
                                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Kunjungan","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                if($MenyimpanLog=="Berhasil"){
                                                                    $_SESSION['NotifikasiSwal']="Tambah Kunjungan Berhasil";
                                                                    echo '<div id="NotifikasiKunjunganBerhasil">Success</div><br>';
                                                                    echo '<div id="NotifikasiUrlBack">'.$UrlForBack.'</div>';
                                                                }else{
                                                                    echo '<span class="text-danger">Terjadi kesalahan saat menyimpan log</span>';
                                                                }
                                                            }else{
                                                                //Update Antrian Apabila Ada
                                                                $Update = mysqli_query($Conn,"UPDATE antrian SET 
                                                                    id_kunjungan='$id_kunjungan'
                                                                WHERE id_antrian='$id_antrian'") or die(mysqli_error($Conn)); 
                                                                if($Update){
                                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Kunjungan","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                    if($MenyimpanLog=="Berhasil"){
                                                                        $_SESSION['NotifikasiSwal']="Tambah Kunjungan Berhasil";
                                                                        echo '<div id="NotifikasiKunjunganBerhasil">Success</div><br>';
                                                                        echo '<div id="NotifikasiUrlBack">'.$UrlForBack.'</div>';
                                                                    }else{
                                                                        echo '<span class="text-danger">Terjadi kesalahan saat menyimpan log</span>';
                                                                    }
                                                                }else{
                                                                    echo '<span class="text-danger">Proses Tambah Kunjungan Mungkin Berhasil, Namun Update Antrian Gagal!</span>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                }else{
                                                    echo '<span class="text-danger">Maaf, Input data kunjungan  pada database kunjungan gagal dilakukan!!</span>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>