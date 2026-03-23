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
        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
    }else{
        //Validasi kategori tidak boleh kosong
        if(empty($_POST['kategori'])){
            echo '<small class="text-danger">Kategori Pemeriksaan tidak boleh kosong</small>';
        }else{
            //Variabel Lainnya
            $id_kunjungan=$_POST['id_kunjungan'];
            $kategori=$_POST['kategori'];
            if(empty($_POST['PemeriksaanFisikUmum'])){
                $PemeriksaanFisikUmum="";
            }else{
                $PemeriksaanFisikUmum=$_POST['PemeriksaanFisikUmum'];
                $PemeriksaanFisikUmum=str_replace('"'," ",$PemeriksaanFisikUmum);
                $PemeriksaanFisikUmum=addslashes($PemeriksaanFisikUmum);
                $PemeriksaanFisikUmum = str_replace(array("\r","\n"),"",$PemeriksaanFisikUmum);
            }
            
            //Buka Data Lama
            $pemeriksaan_fisik=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'pemeriksaan_fisik');
            if(!empty($pemeriksaan_fisik)){
                $JsonPemeriksaanFisik =json_decode($pemeriksaan_fisik, true);
                if($kategori=="Kepala"){
                    $Kepala=$PemeriksaanFisikUmum;
                }else{
                    $Kepala=$JsonPemeriksaanFisik['Kepala'];
                }
                if($kategori=="Leher"){
                    $Leher=$PemeriksaanFisikUmum;
                }else{
                    $Leher=$JsonPemeriksaanFisik['Leher'];
                }
                if($kategori=="Thorax"){
                    $Thorax=$PemeriksaanFisikUmum;
                }else{
                    $Thorax=$JsonPemeriksaanFisik['Thorax'];
                }
                if($kategori=="Abdomen"){
                    $Abdomen=$PemeriksaanFisikUmum;
                }else{
                    $Abdomen=$JsonPemeriksaanFisik['Abdomen'];
                }
                if($kategori=="Extremitas"){
                    $Extremitas=$PemeriksaanFisikUmum;
                }else{
                    $Extremitas=$JsonPemeriksaanFisik['Extremitas'];
                }
                if($kategori=="Genitourinaria"){
                    $Genitourinaria=$PemeriksaanFisikUmum;
                }else{
                    $Genitourinaria=$JsonPemeriksaanFisik['Genitourinaria'];
                }
                $HasilPemeriksaanFisik=Array (
                    "Kepala" => $Kepala,
                    "Leher" => $Leher,
                    "Thorax" => $Thorax,
                    "Abdomen" => $Abdomen,
                    "Extremitas" => $Extremitas,
                    "Genitourinaria" => $Genitourinaria,
                );
            }else{
                $HasilPemeriksaanFisik=Array (
                    "$kategori" => $PemeriksaanFisikUmum,
                );
            }
            $JsonDataBaru= json_encode($HasilPemeriksaanFisik);
            $UpdatePemeriksaanFisik= mysqli_query($Conn,"UPDATE pemeriksaan_fisik SET 
                pemeriksaan_fisik='$JsonDataBaru'
            WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
            if($UpdatePemeriksaanFisik){
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Pemeriksaan Fisik","Kunjungan",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    echo '<span class="text-success" id="NotifikasiEditPemeriksaanFisikUmumBerhasil">Success</span>';
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update pemeriksaan Fisik!</span><br>';
            }
        }
    }
?>
