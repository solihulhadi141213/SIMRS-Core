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
    //Validasi GetIdRad tidak boleh kosong
    if(empty($_POST['GetIdRad'])){
        echo '<small class="text-danger">ID Radiologi tidak boleh kosong</small>';
    }else{
        if(empty($_POST['signature'])){
            echo '<small class="text-danger">Tanda tangan tidak boleh kosong</small>';
        }else{
            //Variabel Lainnya
            $id_rad=$_POST['GetIdRad'];
            $data_uri=$_POST['signature'];
            $encoded_image = explode(",", $data_uri)[1];
            $decoded_image = base64_decode($encoded_image);
            $entry="INSERT INTO radiologi_sig (
                id_rad,
                id_askes,
                tanggal,
                nama,
                kategori,
                signature
            ) VALUES (
                '$id_rad',
                '$SessionIdAkses',
                '$now',
                '$SessionNama',
                'Dokter Spesialis',
                '$encoded_image'
            )";
            $Input=mysqli_query($Conn, $entry);
            if($Input){
                //Update data radiologi
                $UpdateRadiologi = mysqli_query($Conn,"UPDATE radiologi SET 
                    status_pemeriksaan='Selesai',
                    selesai='$now'
                WHERE id_rad='$id_rad'") or die(mysqli_error($Conn)); 
                if($UpdateRadiologi){
                    //Input Log
                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Verifikasi Dokter Radiologi","Radiologi",$SessionIdAkses,$LogJsonFile);
                    if($MenyimpanLog=="Berhasil"){
                        $_SESSION['NotifikasiSwal']="Verifikasi Dokter Radiologi Berhasil";
                        echo '<input type="hidden" name="GetBackUrl" id="GetBackUrl" value="index.php?Page=Radiologi&Sub=DetailRadiologi&id='.$id_rad.'">';
                        echo '<span class="text-success" id="NotifikasiVerifikasiDokterBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                    }
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Melakukan Update Data radiologi!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat menyimpan data</span>';
            }
        }
    }
?>
