<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_kunjungan tidak boleh kosong
    if(empty($_POST['id_kunjungan'])){
        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
    }else{
        //Validasi id_pasien tidak boleh kosong
        if(empty($_POST['id_pasien'])){
            echo '<small class="text-danger">No.RM tidak boleh kosong</small>';
        }else{
            //Validasi nama_pasien tidak boleh kosong
            if(empty($_POST['nama_pasien'])){
                echo '<small class="text-danger">Nama pasien tidak boleh kosong</small>';
            }else{
                //Validasi tanggal tidak boleh kosong
                if(empty($_POST['tanggal'])){
                    echo '<small class="text-danger">Tanggal tidak boleh kosong</small>';
                }else{
                    //Validasi jam tidak boleh kosong
                    if(empty($_POST['jam'])){
                        echo '<small class="text-danger">Jam tidak boleh kosong</small>';
                    }else{
                        //Validasi petugas_entry tidak boleh kosong
                        if(empty($_POST['petugas_entry'])){
                            echo '<small class="text-danger">Petugas Entry tidak boleh kosong</small>';
                        }else{
                            //Validasi dokter tidak boleh kosong
                            if(empty($_POST['dokter'])){
                                echo '<small class="text-danger">Nama dokter pemeriksa tidak boleh kosong</small>';
                            }else{
                                //Validasi perawat tidak boleh kosong
                                if(empty($_POST['perawat'])){
                                    echo '<small class="text-danger">Perawat tidak boleh kosong</small>';
                                }else{
                                    //Membuat variabel wajib
                                    $id_kunjungan=$_POST['id_kunjungan'];
                                    //Validasi Duplikat
                                    $id_anamnesis=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'id_anamnesis');
                                    if(empty($id_anamnesis)){
                                        echo '<small class="text-danger">ID Anamnesis Tidak Valid</small>';
                                    }else{
                                        $id_pasien=$_POST['id_pasien'];
                                        $nama_pasien=$_POST['nama_pasien'];
                                        $tanggal_catat=$_POST['tanggal'];
                                        $jam_catat=$_POST['jam'];
                                        $TanggalJam="$tanggal_catat $jam_catat";
                                        $petugas_entry=$_POST['petugas_entry'];
                                        $dokter=$_POST['dokter'];
                                        $perawat=$_POST['perawat'];
                                        $keluhan_utama="";
                                        //Array Petugas
                                        $PetugasEntryArray=Array (
                                            "nama" => $petugas_entry,
                                            "tanda_tangan" => ""
                                        );
                                        $DokterArray=Array (
                                            "nama" => $dokter,
                                            "tanda_tangan" => ""
                                        );
                                        $PerawatArray=Array (
                                            "nama" => $perawat,
                                            "tanda_tangan" => ""
                                        );
                                        //Json Nama Petugas
                                        $nama_petugas=Array (
                                            "petugas_entry" => $PetugasEntryArray,
                                            "dokter" => $DokterArray,
                                            "perawat" => $PerawatArray
                                        );
                                        //Json Riwayat Penyakit
                                        $riwayat_penyakit=Array (
                                            "sekarang" => "",
                                            "dahulu" => ""
                                        );
                                        //Json Riwayat Alergi
                                        $riwayat_alergi=Array (
                                            "obat" => "",
                                            "makanan" => "",
                                            "minuman" => "",
                                            "lainnya" => ""
                                        );
                                        //Json Riwayat Pengobatan
                                        $riwayat_pengobatan="";
                                        $habitus_kebiasaan="";
                                        $JsonPetugas= json_encode($nama_petugas);
                                        $JsonRiwayatPenyakit= json_encode($riwayat_penyakit);
                                        $JsonRiwayatAlergi= json_encode($riwayat_alergi);
                                        //Update Database
                                        $UpdateRiwayatAlergi= mysqli_query($Conn,"UPDATE anamnesis SET 
                                            id_pasien='$id_pasien',
                                            id_kunjungan='$id_kunjungan',
                                            tanggal='$TanggalJam',
                                            nama_pasien='$nama_pasien',
                                            nama_petugas='$JsonPetugas'
                                        WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                                        if($UpdateRiwayatAlergi){
                                            $LogJsonFile="../../_Page/Log/Log.json";
                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Anamnesis","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                            if($MenyimpanLog=="Berhasil"){
                                                echo '<span class="text-success" id="NotifikasiEditAnamnesisBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                            }
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Anamnesis</span>';
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
