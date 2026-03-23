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
            if(empty($_POST['keterangan'])){
                $keterangan="";
            }else{
                $keterangan=$_POST['keterangan'];
            }
            $kategori_harga=$_POST['kategori_harga'];
            //validasi kode obat tidak boleh sama
            $ValidasiDuplikat = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM obat_kategori_harga WHERE kategori_harga='$kategori_harga'"));
            if(!empty($ValidasiDuplikat)){
                echo '<span class="text-danger">Kategori tersebut sudah ada</span>';
            }else{
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
                        $sql=mysqli_query($Conn,"INSERT INTO obat_kategori_harga (
                            kategori_harga,
                            keterangan
                        ) VALUES (
                            '$kategori_harga',
                            '$keterangan'
                        )");
                        if($sql){
                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Input kategori Harga Obat","Obat",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                echo '<span class="text-success" id="NotifikasiTambahKategoriHargaBerhasil">Success</span>';
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