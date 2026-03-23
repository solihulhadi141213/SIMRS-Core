<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    //Validasi kelengkapan data
    if(empty($_POST['id_kunjungan'])){
        echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['id_pasien'])){
            echo '<span class="text-danger">ID/No.RM Pasien Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['petugas_entry'])){
                echo '<span class="text-danger">Petugas Entry Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['tanggal_permintaan'])){
                    echo '<span class="text-danger">Tanggal Permintaan Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['jam_permintaan'])){
                        echo '<span class="text-danger">Jam Permintaan Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['unit_asal'])){
                            echo '<span class="text-danger">Unit Asal Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['id_dokter_asal'])){
                                echo '<span class="text-danger">ID Dokter Asal Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['unit_tujuan'])){
                                    echo '<span class="text-danger">Unit Tujuan Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['id_dokter_tujuan'])){
                                        echo '<span class="text-danger">ID Dokter Tujuan Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['status_konsultasi'])){
                                            echo '<span class="text-danger">Status Konsultasi Tidak Boleh Kosong!</span>';
                                        }else{
                                            //Membuat Variabel
                                            $id_kunjungan=$_POST['id_kunjungan'];
                                            $id_pasien=$_POST['id_pasien'];
                                            $petugas_entry=$_POST['petugas_entry'];
                                            $tanggal_permintaan=$_POST['tanggal_permintaan'];
                                            $jam_permintaan=$_POST['jam_permintaan'];
                                            $unit_asal=$_POST['unit_asal'];
                                            $unit_tujuan=$_POST['unit_tujuan'];
                                            $id_dokter_asal=$_POST['id_dokter_asal'];
                                            $id_dokter_tujuan=$_POST['id_dokter_tujuan'];
                                            $status_konsultasi=$_POST['status_konsultasi'];
                                            //Buka Data Dokter
                                            $NamaDokterAsal=getDataDetail($Conn,"dokter",'id_dokter',$id_dokter_asal,'nama');
                                            $NamaDokterTujuan=getDataDetail($Conn,"dokter",'id_dokter',$id_dokter_tujuan,'nama');
                                            //Validasi Dokter
                                            if(empty($NamaDokterAsal)){
                                                echo '<span class="text-danger">ID Dokter Asal Tidak Valid/Tidak Ditemukan Pada Database!</span>';
                                            }else{
                                                if(empty($NamaDokterTujuan)){
                                                    echo '<span class="text-danger">ID Dokter Tujuan Tidak Valid/Tidak Ditemukan Pada Database!</span>';
                                                }else{
                                                    //Explode Unit Asal
                                                    $Explode1 = explode("-", $unit_asal);
                                                    $IdUnitAsal=$Explode1['0'];
                                                    $NamaUnitAsal=$Explode1['1'];
                                                    //Explode Unit Tujuan
                                                    $Explode2 = explode("-", $unit_tujuan);
                                                    $IdUnitTujuan=$Explode1['0'];
                                                    $NamaUnitTujuan=$Explode1['1'];
                                                    //Gabungkan Tanggal
                                                    $TanggalPermintaan="$tanggal_permintaan $jam_permintaan";
                                                    //Membuat JSON
                                                    $UnitAsalArray = array(
                                                        "id_unit"=>"$IdUnitAsal",
                                                        "nama"=>"$NamaUnitAsal"
                                                    );
                                                    $UnitTujuanArray = array(
                                                        "id_unit"=>"$IdUnitTujuan",
                                                        "nama"=>"$NamaUnitTujuan"
                                                    );
                                                    $DokterAsalArray = array(
                                                        "unit"=>$UnitAsalArray,
                                                        "id_dokter"=>"$id_dokter_asal",
                                                        "nama"=>"$NamaDokterAsal",
                                                        "ttd"=>""
                                                    );
                                                    $DokterTujuanArray = array(
                                                        "unit"=>$UnitTujuanArray,
                                                        "id_dokter"=>"$id_dokter_tujuan",
                                                        "nama"=>"$NamaDokterTujuan",
                                                        "ttd"=>""
                                                    );
                                                    $JsonDokterAsal = json_encode($DokterAsalArray);
                                                    $JsonDokterTujuan = json_encode($DokterTujuanArray);
                                                    //Simpan Data Ke Database
                                                    $entry="INSERT INTO konsultasi (
                                                        id_pasien,
                                                        id_kunjungan,
                                                        id_akses,
                                                        petugas_entry,
                                                        tanggal_entry,
                                                        tanggal_permintaan,
                                                        tanggal_jawaban,
                                                        dokter_asal,
                                                        dokter_tujuan,
                                                        permintaan_konsultasi,
                                                        jawaban_konsultasi,
                                                        status_konsultasi
                                                    ) VALUES (
                                                        '$id_pasien',
                                                        '$id_kunjungan',
                                                        '$SessionIdAkses',
                                                        '$petugas_entry',
                                                        '$updatetime',
                                                        '$TanggalPermintaan',
                                                        '',
                                                        '$JsonDokterAsal',
                                                        '$JsonDokterTujuan',
                                                        '',
                                                        '',
                                                        '$status_konsultasi'
                                                    )";
                                                    $hasil=mysqli_query($Conn, $entry);
                                                    if($hasil){
                                                        $LogJsonFile="../../_Page/Log/Log.json";
                                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Konsultasi","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                        if($MenyimpanLog=="Berhasil"){
                                                            echo '<span class="text-success" id="NotifikasiTambahKonsuiltasiBerhasil">Success</span>';
                                                        }else{
                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                        }
                                                    }else{
                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Konsultasi</span>';
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
    }
?>