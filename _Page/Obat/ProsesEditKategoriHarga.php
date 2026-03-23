<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $Updatetime=date("Y-m-d H:i:s");
    $now=date("Y-m-d H:i:s");
    if(empty($SessionNama)){
        echo '<span class="text-danger">Silahkan login ulang terlebih dulu!</span>';
    }else{
        if(empty($_POST['kategori_harga'])){
            echo '<span class="text-danger">Kategori Harga Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['id_kategori_harga'])){
                echo '<span class="text-danger">ID Kategori Harga Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['keterangan'])){
                    $keterangan="";
                }else{
                    $keterangan=$_POST['keterangan'];
                }
                $kategori_harga=$_POST['kategori_harga'];
                $id_kategori_harga=$_POST['id_kategori_harga'];
                //Validasi Karakter
                if(preg_match('/[#@]/', $kategori_harga)) {
                    echo '<span class="text-danger">Nama kategori harga tidak valid, atau mengandung karakter ilegal</span>';
                }else{
                    //Validasi Karakter
                    if(preg_match('/[#@]/', $keterangan)) {
                        echo '<span class="text-danger">Keterangan kategori harga tidak valid, atau mengandung karakter ilegal</span>';
                    }else{
                        $keterangan = htmlspecialchars($keterangan, ENT_QUOTES, 'UTF-8');
                        //Simpan data
                        $UpdateKategoriHarga=mysqli_query($Conn, "UPDATE obat_kategori_harga SET 
                            kategori_harga='$kategori_harga', 
                            keterangan='$keterangan'
                        WHERE id_kategori_harga='$id_kategori_harga'");
                        if($UpdateKategoriHarga){
                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit kategori Harga Obat","Obat",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                echo '<span class="text-success" id="NotifikasiEditKategoriHargaBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data log</span>';
                            }
                        }else{
                            echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data ke database</span>';
                        }
                    }
                }
            }
        }
    }
?>