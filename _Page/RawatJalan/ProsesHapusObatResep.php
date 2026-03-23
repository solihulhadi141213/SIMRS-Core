<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    //Validasi kelengkapan data
    if(empty($_POST['id_resep'])){
        echo '<span class="text-danger">ID Resep Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['id'])){
            echo '<span class="text-danger">ID Data Tidak Boleh Kosong!</span>';
        }else{
            //Membuat Variabel
            $id=$_POST['id'];
            $id_resep=$_POST['id_resep'];
            //Buka Data Lama
            $obat=getDataDetail($Conn,"resep",'id_resep',$id_resep,'obat');
            $JsonObat =json_decode($obat, true);
            $ObatBaru = array();
            foreach ($JsonObat as $row){
                if($row["id"]!==$id){
                    $h['id'] = $row["id"];
                    $h['id_obat'] = $row["id_obat"];
                    $h['nama_obat'] = $row["nama_obat"];
                    $h['bentuk_sediaan'] = $row["bentuk_sediaan"];
                    $h['jumlah_obat'] = $row["jumlah_obat"];
                    $h['metode'] = $row["metode"];
                    $h['dosis'] = $row["dosis"];
                    $h['unit'] = $row["unit"];
                    $h['frekuensi'] = $row["frekuensi"];
                    $h['aturan_tambahan'] = $row["aturan_tambahan"];
                    array_push($ObatBaru, $h);
                }
            }
            $ObatBaruJson= json_encode($ObatBaru);
            $UpdateResep= mysqli_query($Conn,"UPDATE resep SET 
                obat='$ObatBaruJson'
            WHERE id_resep='$id_resep'") or die(mysqli_error($Conn));
            if($UpdateResep){
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Hapus Obat Resep","Kunjungan",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiHapusObatResepBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat menghapus data!</span><br>';
            }
        }
    }
?>