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
    //Validasi id_kunjungan tidak boleh kosong
    if(empty($_POST['id_kunjungan'])){
        echo '<small class="text-danger">ID Kunjungan Tindakan tidak boleh kosong</small>';
    }else{
        if(empty($_POST['signature'])){
            echo '<small class="text-danger">Tanda tangan tidak boleh kosong</small>';
        }else{
            //Variabel Lainnya
            $id_kunjungan=$_POST['id_kunjungan'];
            $data_uri=$_POST['signature'];
            $encoded_image = explode(",", $data_uri)[1];
            $decoded_image = base64_decode($encoded_image);
            //Buka Data Lama
            $dokter=getDataDetail($Conn,"resume",'id_kunjungan',$id_kunjungan,'dokter');
            $JsonDokter=json_decode($dokter, true);
            $nama=$JsonDokter['nama'];
            $SIP=$JsonPetugas['SIP'];
            $kontak=$JsonPetugas['kontak'];
            $kategori_identitas=$JsonPetugas['kategori_identitas'];
            $no_identitas=$JsonPetugas['no_identitas'];
            $ttd=$encoded_image;
            $DokterArray = array(
                "nama"=>"$nama",
                "SIP"=>"$SIP",
                "kontak"=>"$kontak",
                "kategori_identitas"=>"$kategori_identitas",
                "no_identitas"=>"$no_identitas",
                "ttd"=>"$ttd"
            );
            $JsonDokterBaru= json_encode($DokterArray);
            $Update= mysqli_query($Conn,"UPDATE resume SET 
                dokter='$JsonDokterBaru'
            WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
            if($Update){
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tanda Tangan Dokter Resume","Kunjungan",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiTtdDokterResumeBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update!</span><br>';
            }
        }
    }
?>
