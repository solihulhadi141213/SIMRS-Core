<?php
    //Koneksi
    include "../../_Config/Connection.php";
    //Menangkap data wilayah
    if(empty($_POST['id_wilayah'])){
        echo "<div class='text-danger'>ID Wilayah tidak boleh kosong!!</div>";
    }else{
        $id_wilayah=$_POST['id_wilayah'];
        if(empty($_POST['propinsi'])){
            echo "<div class='text-danger'>Propinsi tidak boleh kosong!!</div>";
        }else{
            $propinsi=$_POST['propinsi'];
            if(empty($_POST['kabupaten'])){
                $kabupaten="";
            }else{
                $kabupaten=$_POST['kabupaten'];
            }
            if(empty($_POST['kecamatan'])){
                $kecamatan="";
            }else{
                $kecamatan=$_POST['kecamatan'];
            }
            if(empty($_POST['desa'])){
                $desa="";
            }else{
                $desa=$_POST['desa'];
            }
            //Proses melakukan inisiasi kategori
            if(!empty($desa)&&!empty($kecamatan)&&!empty($kabupaten)){
                $kategori="desa";
            }else{
                if(empty($desa)&&!empty($kecamatan)&&!empty($kabupaten)){
                    $kategori="Kecamatan";
                }else{
                    if(empty($desa)&&empty($kecamatan)&&!empty($kabupaten)){
                        $kategori="Kabupaten";
                    }else{
                        if(empty($desa)&&empty($kecamatan)&&empty($kabupaten)){
                            $kategori="Propinsi";
                        }else{
                            $kategori="";
                        }
                    }
                }
            }
            //Melakukan input data
            if(empty($kategori)){
                echo "<div class='text-danger'>Masukan informasi wilayah dengan benar!!</div>";
            }else{
                $UpdateWilayah = mysqli_query($Conn,"UPDATE wilayah SET 
                    kategori='$kategori',
                    propinsi='$propinsi',
                    kabupaten='$kabupaten',
                    kecamatan='$kecamatan',
                    desa='$desa'
                WHERE id_wilayah='$id_wilayah'") or die(mysqli_error($Conn)); 
                if($UpdateWilayah){
                    echo '<span id="NotifikasiEditWilyah">Berhasil</span>';
                }else{
                    echo "<div class='text-danger'>Input Data Wilayah Gagal!!</div>";
                }
            }
        }
    }
?>

