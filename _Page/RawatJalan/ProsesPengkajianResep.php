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
        $id_resep=$_POST['id_resep'];
        //Variabel Pengkajian
        if(empty($_POST['pengkajian1'])){
            $pengkajian1="";
        }else{
            $pengkajian1=$_POST['pengkajian1'];
        }
        if(empty($_POST['pengkajian2'])){
            $pengkajian2="";
        }else{
            $pengkajian2=$_POST['pengkajian2'];
        }
        if(empty($_POST['pengkajian3'])){
            $pengkajian3="";
        }else{
            $pengkajian3=$_POST['pengkajian3'];
        }
        if(empty($_POST['pengkajian4'])){
            $pengkajian4="";
        }else{
            $pengkajian4=$_POST['pengkajian4'];
        }
        if(empty($_POST['pengkajian5'])){
            $pengkajian5="";
        }else{
            $pengkajian5=$_POST['pengkajian5'];
        }
        if(empty($_POST['pengkajian6'])){
            $pengkajian6="";
        }else{
            $pengkajian6=$_POST['pengkajian6'];
        }
        if(empty($_POST['pengkajian7'])){
            $pengkajian7="";
        }else{
            $pengkajian7=$_POST['pengkajian7'];
        }
        if(empty($_POST['pengkajian8'])){
            $pengkajian8="";
        }else{
            $pengkajian8=$_POST['pengkajian8'];
        }
        if(empty($_POST['pengkajian9'])){
            $pengkajian9="";
        }else{
            $pengkajian9=$_POST['pengkajian9'];
        }
        if(empty($_POST['pengkajian10'])){
            $pengkajian10="";
        }else{
            $pengkajian10=$_POST['pengkajian10'];
        }
        if(empty($_POST['pengkajian11'])){
            $pengkajian11="";
        }else{
            $pengkajian11=$_POST['pengkajian11'];
        }
        if(empty($_POST['pengkajian12'])){
            $pengkajian12="";
        }else{
            $pengkajian12=$_POST['pengkajian12'];
        }
        if(empty($_POST['pengkajian13'])){
            $pengkajian13="";
        }else{
            $pengkajian13=$_POST['pengkajian13'];
        }
        //Keterangan
        if(empty($_POST['keterangan_pengkajian1'])){
            $keterangan_pengkajian1="";
        }else{
            $keterangan_pengkajian1=$_POST['keterangan_pengkajian1'];
        }
        if(empty($_POST['keterangan_pengkajian2'])){
            $keterangan_pengkajian2="";
        }else{
            $keterangan_pengkajian2=$_POST['keterangan_pengkajian2'];
        }
        if(empty($_POST['keterangan_pengkajian3'])){
            $keterangan_pengkajian3="";
        }else{
            $keterangan_pengkajian3=$_POST['keterangan_pengkajian3'];
        }
        if(empty($_POST['keterangan_pengkajian4'])){
            $keterangan_pengkajian4="";
        }else{
            $keterangan_pengkajian4=$_POST['keterangan_pengkajian4'];
        }
        if(empty($_POST['keterangan_pengkajian5'])){
            $keterangan_pengkajian5="";
        }else{
            $keterangan_pengkajian5=$_POST['keterangan_pengkajian5'];
        }
        if(empty($_POST['keterangan_pengkajian6'])){
            $keterangan_pengkajian6="";
        }else{
            $keterangan_pengkajian6=$_POST['keterangan_pengkajian6'];
        }
        if(empty($_POST['keterangan_pengkajian7'])){
            $keterangan_pengkajian7="";
        }else{
            $keterangan_pengkajian7=$_POST['keterangan_pengkajian7'];
        }
        if(empty($_POST['keterangan_pengkajian8'])){
            $keterangan_pengkajian8="";
        }else{
            $keterangan_pengkajian8=$_POST['keterangan_pengkajian8'];
        }
        if(empty($_POST['keterangan_pengkajian9'])){
            $keterangan_pengkajian9="";
        }else{
            $keterangan_pengkajian9=$_POST['keterangan_pengkajian9'];
        }
        if(empty($_POST['keterangan_pengkajian10'])){
            $keterangan_pengkajian10="";
        }else{
            $keterangan_pengkajian10=$_POST['keterangan_pengkajian10'];
        }
        if(empty($_POST['keterangan_pengkajian11'])){
            $keterangan_pengkajian11="";
        }else{
            $keterangan_pengkajian11=$_POST['keterangan_pengkajian11'];
        }
        if(empty($_POST['keterangan_pengkajian12'])){
            $keterangan_pengkajian12="";
        }else{
            $keterangan_pengkajian12=$_POST['keterangan_pengkajian12'];
        }
        if(empty($_POST['keterangan_pengkajian13'])){
            $keterangan_pengkajian13="";
        }else{
            $keterangan_pengkajian13=$_POST['keterangan_pengkajian13'];
        }
        if(empty($_POST['petugas_pengkajian'])){
            $petugas_pengkajian="";
        }else{
            $petugas_pengkajian=$_POST['petugas_pengkajian'];
        }
        //Membuat Json
        $PengkajianArray1 = array(
            "value"=>"$pengkajian1",
            "keterangan"=>"$keterangan_pengkajian1"
        );
        $PengkajianArray2 = array(
            "value"=>"$pengkajian2",
            "keterangan"=>"$keterangan_pengkajian2"
        );
        $PengkajianArray3 = array(
            "value"=>"$pengkajian3",
            "keterangan"=>"$keterangan_pengkajian3"
        );
        $PengkajianArray4 = array(
            "value"=>"$pengkajian4",
            "keterangan"=>"$keterangan_pengkajian4"
        );
        $PengkajianArray5 = array(
            "value"=>"$pengkajian5",
            "keterangan"=>"$keterangan_pengkajian5"
        );
        $PengkajianArray6 = array(
            "value"=>"$pengkajian6",
            "keterangan"=>"$keterangan_pengkajian6"
        );
        $PengkajianArray7 = array(
            "value"=>"$pengkajian7",
            "keterangan"=>"$keterangan_pengkajian7"
        );
        $PengkajianArray8 = array(
            "value"=>"$pengkajian8",
            "keterangan"=>"$keterangan_pengkajian8"
        );
        $PengkajianArray9 = array(
            "value"=>"$pengkajian9",
            "keterangan"=>"$keterangan_pengkajian9"
        );
        $PengkajianArray10 = array(
            "value"=>"$pengkajian10",
            "keterangan"=>"$keterangan_pengkajian10"
        );
        $PengkajianArray11 = array(
            "value"=>"$pengkajian11",
            "keterangan"=>"$keterangan_pengkajian11"
        );
        $PengkajianArray12 = array(
            "value"=>"$pengkajian12",
            "keterangan"=>"$keterangan_pengkajian12"
        );
        $PengkajianArray13 = array(
            "value"=>"$pengkajian13",
            "keterangan"=>"$keterangan_pengkajian13"
        );
        $PengkajianArray = array(
            "pengkajian1"=>$PengkajianArray1,
            "pengkajian2"=>$PengkajianArray2,
            "pengkajian3"=>$PengkajianArray3,
            "pengkajian4"=>$PengkajianArray4,
            "pengkajian5"=>$PengkajianArray5,
            "pengkajian6"=>$PengkajianArray6,
            "pengkajian7"=>$PengkajianArray7,
            "pengkajian8"=>$PengkajianArray8,
            "pengkajian9"=>$PengkajianArray9,
            "pengkajian10"=>$PengkajianArray10,
            "pengkajian11"=>$PengkajianArray11,
            "pengkajian12"=>$PengkajianArray12,
            "pengkajian13"=>$PengkajianArray13,
            "petugas_pengkajian"=>$petugas_pengkajian
        );
        $PengkajianJson= json_encode($PengkajianArray);
        $UpdateResep= mysqli_query($Conn,"UPDATE resep SET 
            pengkajian='$PengkajianJson'
        WHERE id_resep='$id_resep'") or die(mysqli_error($Conn));
        if($UpdateResep){
            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Pengkajian Resep Obat","Kunjungan",$SessionIdAkses,$LogJsonFile);
            if($MenyimpanLog=="Berhasil"){
                echo '<span class="text-success" id="NotifikasiPengkajianResepBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
            }
        }else{
            echo '<span class="text-danger">Terjadi kesalahan pada saat update data!</span><br>';
        }
    }
?>