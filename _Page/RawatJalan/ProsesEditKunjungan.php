<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    //validasi variabel wajib
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="text-danger">ID Kunjungan tidak boleh kosong</div>';
    }else{
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
                                            $id_kunjungan=$_POST['id_kunjungan'];
                                            $id_pasien=$_POST['id_pasien'];
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
                                            $nama=$_POST['nama'];
                                            $tanggal=$_POST['tanggal'];
                                            $waktu=$_POST['waktu'];
                                            $TanggalWaktu="$tanggal $waktu";
                                            $DiagAwal=$_POST['DiagAwal'];
                                            $keluhan=$_POST['keluhan'];
                                            $id_poliklinik=$_POST['id_poliklinik'];
                                            $id_dokter=$_POST['id_dokter'];
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
                                            $QryPasien = mysqli_query($Conn,"SELECT * FROM pasien WHERE id_pasien='$id_pasien'")or die(mysqli_error($Conn));
                                            $DataPasien = mysqli_fetch_array($QryPasien);
                                            $propinsi= $DataPasien['propinsi'];
                                            $kabupaten= $DataPasien['kabupaten'];
                                            $kecamatan= $DataPasien['kecamatan'];
                                            $desa= $DataPasien['desa'];
                                            $alamat= $DataPasien['alamat'];
                                            //Buka nama dokter
                                            $qry_dokter= mysqli_query($Conn, "SELECT * FROM dokter WHERE id_dokter='$id_dokter'")or die(mysqli_error());
                                            $data_dokter = mysqli_fetch_array($qry_dokter);
                                            $kode_dokter= $data_dokter['kode'];
                                            $nama_dokter= $data_dokter['nama'];
                                            //Buka nama poliklinik
                                            $qry_poli= mysqli_query($Conn, "SELECT * FROM poliklinik WHERE id_poliklinik='$id_poliklinik'")or die(mysqli_error());
                                            $data_poli = mysqli_fetch_array($qry_poli);
                                            $kode_poliklinik = $data_poli['kode'];
                                            $nama_poli = $data_poli['nama'];
                                            //Buka nama ruang_kelas
                                            $QryRuang= mysqli_query($Conn, "SELECT * FROM ruang_rawat WHERE id_ruang_rawat='$id_kasur'")or die(mysqli_error());
                                            $DataRuang = mysqli_fetch_array($QryRuang);
                                            if(!empty($DataRuang['id_ruang_rawat'])){
                                                $id_ruang_rawat = $DataRuang['id_ruang_rawat'];
                                                $kelas = $DataRuang['kelas'];
                                                $ruangan = $DataRuang['ruangan'];
                                                $bed = $DataRuang['bed'];
                                            }else{
                                                $id_ruang_rawat = "";
                                                $kelas ="";
                                                $ruangan = "";
                                                $bed = "";
                                            }
                                            //Updatetime
                                            $updatetime=date('Y-m-d H:i:s');
                                            //Lakukan input ke database
                                            $UpdateKunjungan= mysqli_query($Conn,"UPDATE kunjungan_utama SET 
                                                id_pasien='$id_pasien',
                                                no_antrian='$no_antrian',
                                                nik='$nik',
                                                no_bpjs='$no_bpjs',
                                                sep='$sep',
                                                noRujukan='$noRujukan',
                                                skdp='$skdp',
                                                nama='$nama',
                                                tanggal='$TanggalWaktu',
                                                propinsi='$propinsi',
                                                kabupaten='$kabupaten',
                                                kecamatan='$kecamatan',
                                                desa='$desa',
                                                alamat='$alamat',
                                                keluhan='$keluhan',
                                                tujuan='$tujuan',
                                                id_dokter='$id_dokter',
                                                dokter='$nama_dokter',
                                                id_poliklinik='$id_poliklinik',
                                                poliklinik='$nama_poli',
                                                kelas='$kelas',
                                                ruangan='$ruangan',
                                                id_kasur='$id_ruang_rawat',
                                                DiagAwal='$DiagAwal',
                                                rujukan_dari='$rujukan_dari',
                                                pembayaran='$pembayaran',
                                                status='$status',
                                                updatetime='$updatetime'
                                            WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                                            if($UpdateKunjungan){
                                                if(empty($id_antrian)){
                                                    $LogJsonFile="../../_Page/Log/Log.json";
                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Kunjungan","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                    if($MenyimpanLog=="Berhasil"){
                                                        $_SESSION['NotifikasiSwal']="Edit Kunjungan Berhasil";
                                                        echo '<div id="NotifikasiEditKunjunganRajalBerhasil">Success</div>';
                                                        echo '<div id="NotifikasiUrlBack">index.php?Page=RawatJalan&Sub=DetailKunjungan&id='.$id_kunjungan.'</div>';
                                                    }else{
                                                        echo '<div class="text-danger">Terjadi kesalahan saat menyimpan log</div>';
                                                    }
                                                }else{
                                                    //Update Antrian Apabila Ada
                                                    $Update = mysqli_query($Conn,"UPDATE antrian SET 
                                                        id_kunjungan='$id_kunjungan'
                                                    WHERE id_antrian='$id_antrian'") or die(mysqli_error($Conn)); 
                                                    if($Update){
                                                        $LogJsonFile="../../_Page/Log/Log.json";
                                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Kunjungan","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                        if($MenyimpanLog=="Berhasil"){
                                                            $_SESSION['NotifikasiSwal']="Edit Kunjungan Berhasil";
                                                            echo '<div id="NotifikasiEditKunjunganRajalBerhasil">Success</div>';
                                                            echo '<div id="NotifikasiUrlBack">index.php?Page=RawatJalan&Sub=DetailKunjungan&id='.$id_kunjungan.'</div>';
                                                        }else{
                                                            echo '<div class="text-danger">Terjadi kesalahan saat menyimpan log</div>';
                                                        }
                                                    }else{
                                                        echo '<span class="text-danger">Proses Tambah Kunjungan Mungkin Berhasil, Namun Update Antrian Gagal!</span>';
                                                    }
                                                }
                                            }else{
                                                echo '<span class="text-danger">Maaf, Update data kunjungan gagal!!</span>';
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