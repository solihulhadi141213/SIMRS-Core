<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_POST['id_nakes_pcr'])){
        echo '<span class="text-danger">ID PCR Nakes Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nama_nakes'])){
            echo '<span class="text-danger">Nama Nakes Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['kategori_nakes'])){
                echo '<span class="text-danger">Kategori Nakes Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['hasil_pcr'])){
                    echo '<span class="text-danger">Hasil PCR Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['tanggal'])){
                        echo '<span class="text-danger">Tanggal Hasil PCR Tidak Boleh Kosong!</span>';
                    }else{
                        $id_nakes_pcr=$_POST['id_nakes_pcr'];
                        $tanggal=$_POST['tanggal'];
                        $nama_nakes=$_POST['nama_nakes'];
                        $kategori_nakes=$_POST['kategori_nakes'];
                        $hasil_pcr=$_POST['hasil_pcr'];
                        if(!preg_match('/^[a-zA-Z\s]+$/', $nama_nakes)) {
                            echo '<span class="text-danger">Nama Nakes Hanya Boleh Huruf dan Spasi!</span>';
                        }else{
                            if(!preg_match('/^[a-zA-Z\s]+$/', $kategori_nakes)) {
                                echo '<span class="text-danger">Kategori Nakes Hanya Boleh Huruf dan Spasi!</span>';
                            }else{
                                if(!preg_match('/^[a-zA-Z\s]+$/', $hasil_pcr)) {
                                    echo '<span class="text-danger">Hasil PCR Hanya Boleh Huruf dan Spasi!</span>';
                                }else{
                                    $UpdatePcrNakes = mysqli_query($Conn,"UPDATE nakes_pcr SET 
                                        tanggal='$tanggal',
                                        nama_nakes='$nama_nakes',
                                        kategori_nakes='$kategori_nakes',
                                        hasil_pcr='$hasil_pcr'
                                    WHERE id_nakes_pcr='$id_nakes_pcr'") or die(mysqli_error($Conn)); 
                                    if($UpdatePcrNakes){
                                        $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Edit Hasil PCR nakes","PCR Nakes",$SessionIdAkses,$LogJsonFile);
                                        if($MenyimpanLog=="Berhasil"){
                                            echo '<span class="text-success" id="NotifikasiEditHasilPcrNakesBerhasil">Success</span>';
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                        }
                                    }else{
                                        echo '<span class="text-danger">Update Data Hasil PCR Gagal!</span>';
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