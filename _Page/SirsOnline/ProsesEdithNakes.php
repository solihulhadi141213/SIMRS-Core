<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_POST['nama'])){
        echo '<span class="text-danger">Nama Nakes Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['kategori'])){
            echo '<span class="text-danger">Kategori Nakes Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['referensi_sdm'])){
                echo '<span class="text-danger">Referensi SDM Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['id_nakes'])){
                    echo '<span class="text-danger">ID Nakes Tidak Boleh Kosong!</span>';
                }else{
                    $id_nakes=$_POST['id_nakes'];
                    //Buka Data Lama
                    $ihs_lama=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'ihs');
                    $nik_lama=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'nik');
                    $kode_lama=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'kode');
                    if(empty($_POST['nik'])){
                        $nik="";
                        $ValidasiDuplikatNik=0;
                    }else{
                        $nik=$_POST['nik'];
                        if($nik_lama==$nik){
                            $ValidasiDuplikatNik="0";
                        }else{
                            $ValidasiDuplikatNik = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE nik='$nik'"));
                        }
                    }
                    if(empty($_POST['ihs'])){
                        $ihs="";
                        $ValidasiDuplikatIhs="0";
                    }else{
                        $ihs=$_POST['ihs'];
                        if($ihs_lama==$ihs){
                            $ValidasiDuplikatIhs="0";
                        }else{
                            $ValidasiDuplikatIhs= mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE ihs='$ihs'"));
                        }
                    }
                    if(empty($_POST['kode'])){
                        $kode="";
                        $ValidasiDuplikatKode="0";
                    }else{
                        $kode=$_POST['kode'];
                        if($kode_lama==$kode){
                            $ValidasiDuplikatKode="0";
                        }else{
                            $ValidasiDuplikatKode= mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM nakes WHERE kode='$kode'"));
                        }
                    }
                    $nama=$_POST['nama'];
                    $kategori=$_POST['kategori'];
                    $referensi_sdm=$_POST['referensi_sdm'];
                    if(!preg_match('/^[a-zA-Z\s]+$/', $nama)) {
                        echo '<span class="text-danger">Nama Nakes Hanya Boleh Huruf dan Spasi!</span>';
                    }else{
                        if(!empty($ValidasiDuplikatNik)){
                            echo '<span class="text-danger">NIK Tersebut sudah terdaftar!</span>';
                        }else{
                            if(!empty($ValidasiDuplikatIhs)){
                                echo '<span class="text-danger">ID Satu Sehat Tersebut sudah terdaftar!</span>';
                            }else{
                                if(!empty($ValidasiDuplikatKode)){
                                    echo '<span class="text-danger">Kode Tersebut sudah terdaftar!</span>';
                                }else{
                                    $UpdateNakes = mysqli_query($Conn,"UPDATE nakes SET 
                                        ihs='$ihs',
                                        nik='$nik',
                                        kode='$kode',
                                        nama='$nama',
                                        kategori='$kategori',
                                        referensi_sdm='$referensi_sdm',
                                        id_akses='$SessionIdAkses'
                                    WHERE id_nakes='$id_nakes'") or die(mysqli_error($Conn)); 
                                    if($UpdateNakes){
                                        $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Edit data nakes","Nakes",$SessionIdAkses,$LogJsonFile);
                                        if($MenyimpanLog=="Berhasil"){
                                            echo '<span class="text-success" id="NotifikasiEditNakesBerhasil">Success</span>';
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                        }
                                    }else{
                                        echo '<span class="text-danger">Edit Data Nakes Gagal!</span>';
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