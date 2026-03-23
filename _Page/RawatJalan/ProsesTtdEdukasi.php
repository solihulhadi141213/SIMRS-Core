<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_konsultasi tidak boleh kosong
    if(empty($_POST['id_edukasi'])){
        echo '<small class="text-danger">ID Edukasi Tindakan tidak boleh kosong</small>';
    }else{
        if(empty($_POST['kategori'])){
            echo '<small class="text-danger">Kategori Edukasi Tindakan tidak boleh kosong</small>';
        }else{
            if(empty($_POST['signature'])){
                echo '<small class="text-danger">Tanda tangan tidak boleh kosong</small>';
            }else{
                //Variabel Lainnya
                $id_edukasi=$_POST['id_edukasi'];
                $kategori=$_POST['kategori'];
                $data_uri=$_POST['signature'];
                $encoded_image = explode(",", $data_uri)[1];
                //Buka Data Lama
                if($kategori=="Pemberi"){
                    $kolom="pemberi_edukasi";
                    $PemberiPenerima=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'pemberi_edukasi');
                }else{
                    $kolom="penerima_edukasi";
                    $PemberiPenerima=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'penerima_edukasi');
                }
                $JsonPemberiPenerima=json_decode($PemberiPenerima, true);
                $nama=$JsonPemberiPenerima['nama'];
                $kontak=$JsonPemberiPenerima['kontak'];
                $kategori_identitas=$JsonPemberiPenerima['kategori_identitas'];
                $no_identitas=$JsonPemberiPenerima['no_identitas'];
                $ttd=$encoded_image;
                $DataArray = array(
                    "nama"=>"$nama",
                    "kontak"=>"$kontak",
                    "kategori_identitas"=>"$kategori_identitas",
                    "no_identitas"=>"$no_identitas",
                    "ttd"=>"$ttd"
                );
                $DataUpdate= json_encode($DataArray);
                $Update= mysqli_query($Conn,"UPDATE edukasi SET 
                    $kolom='$DataUpdate'
                WHERE id_edukasi='$id_edukasi'") or die(mysqli_error($Conn));
                if($Update){
                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update TTD Edukasi","Kunjungan",$SessionIdAkses,$LogJsonFile);
                    if($MenyimpanLog=="Berhasil"){
                        echo '<span class="text-success" id="NotifikasiTtdEdukasiBerhasil'.$kategori.''.$id_edukasi.'">Success</span>';
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                    }
                }else{
                    echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update!</span><br>';
                }
            }
        }
    }
?>
