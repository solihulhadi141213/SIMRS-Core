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
    if(empty($_POST['id_konsultasi'])){
        echo '<small class="text-danger">ID Konsultasi Tindakan tidak boleh kosong</small>';
    }else{
        if(empty($_POST['signature'])){
            echo '<small class="text-danger">Tanda tangan tidak boleh kosong</small>';
        }else{
            //Variabel Lainnya
            $id_konsultasi=$_POST['id_konsultasi'];
            $data_uri=$_POST['signature'];
            $encoded_image = explode(",", $data_uri)[1];
            $decoded_image = base64_decode($encoded_image);
            //Buka Data Lama
            $dokter_asal=getDataDetail($Conn,"konsultasi",'id_konsultasi',$id_konsultasi,'dokter_asal');
            $JsonDokterAsal=json_decode($dokter_asal, true);
            $IdUnitAsal=$JsonDokterAsal['unit']['id_unit'];
            $NamaUnitAsal=$JsonDokterAsal['unit']['nama'];
            $IdDokterAsal=$JsonDokterAsal['id_dokter'];
            $NamaDokterAsal=$JsonDokterAsal['nama'];
            $TtdDokterAsal=$encoded_image;
            $UnitAsalArray = array(
                "id_unit"=>"$IdUnitAsal",
                "nama"=>"$NamaUnitAsal"
            );
            $DokterAsalArray = array(
                "unit"=>$UnitAsalArray,
                "id_dokter"=>"$IdDokterAsal",
                "nama"=>"$NamaDokterAsal",
                "ttd"=>"$TtdDokterAsal"
            );
            $DokterEncode= json_encode($DokterAsalArray);
            $Update= mysqli_query($Conn,"UPDATE konsultasi SET 
                dokter_asal='$DokterEncode'
            WHERE id_konsultasi='$id_konsultasi'") or die(mysqli_error($Conn));
            if($Update){
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Asal Konsultasi","Kunjungan",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiTtdAsalKonsultasiBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update!</span><br>';
            }
        }
    }
?>
