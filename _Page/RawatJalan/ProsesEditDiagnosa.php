<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_diagnosis_pasien tidak boleh kosong
    if(empty($_POST['id_diagnosis_pasien'])){
        echo '<small class="text-danger">ID Diagnosa tidak boleh kosong</small>';
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
                            //Validasi kategori tidak boleh kosong
                            if(empty($_POST['kategori'])){
                                echo '<small class="text-danger">Kategori Diagnosa tidak boleh kosong</small>';
                            }else{
                                //Validasi referensi tidak boleh kosong
                                if(empty($_POST['referensi'])){
                                    echo '<small class="text-danger">Referensi tidak boleh kosong</small>';
                                }else{
                                    //Validasi diagnosa tidak boleh kosong
                                    if(empty($_POST['diagnosa'])){
                                        echo '<small class="text-danger">Diagnosa tidak boleh kosong</small>';
                                    }else{
                                        //Membuat variabel wajib
                                        $id_diagnosis_pasien=$_POST['id_diagnosis_pasien'];
                                        $id_pasien=$_POST['id_pasien'];
                                        $nama_pasien=$_POST['nama_pasien'];
                                        $tanggal=$_POST['tanggal'];
                                        $jam=$_POST['jam'];
                                        $TanggalJam="$tanggal $jam";
                                        $petugas_entry=$_POST['petugas_entry'];
                                        $kategori=$_POST['kategori'];
                                        $referensi=$_POST['referensi'];
                                        $diagnosa=$_POST['diagnosa'];
                                        //Pecah Diagnosa
                                        $Explode = explode("|" , $diagnosa);
                                        if(empty($Explode[0])){
                                            echo '<small class="text-danger">Format diagnosa yang anda gunakan tidak sesuai.</small>';
                                        }else{
                                            if(empty($Explode[1])){
                                                echo '<small class="text-danger">Format diagnosa yang anda gunakan tidak sesuai.</small>';
                                            }else{
                                                $KodeDiagnosa=$Explode[0];
                                                $NamaDiagnosa=$Explode[1];
                                                //Menyimpan Kedalam Database
                                                $UpdateDiagnosa= mysqli_query($Conn,"UPDATE diagnosis_pasien SET 
                                                    tanggal='$TanggalJam',
                                                    kategori='$kategori',
                                                    kode='$KodeDiagnosa',
                                                    diagnosis='$NamaDiagnosa',
                                                    referensi='$referensi'
                                                WHERE id_diagnosis_pasien='$id_diagnosis_pasien'") or die(mysqli_error($Conn));
                                                if($UpdateDiagnosa){
                                                    $LogJsonFile="../../_Page/Log/Log.json";
                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Diagnosa Pasien","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                    if($MenyimpanLog=="Berhasil"){
                                                        echo '<span class="text-success" id="NotifikasiEditDiagnosaBerhasil">Success</span>';
                                                    }else{
                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                    }
                                                }else{
                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Diagnosa Pasien</span>';
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
