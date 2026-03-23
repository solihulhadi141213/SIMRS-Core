<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Log
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    if(empty($_POST['tanggal'])){
        echo '<span class="text-danger">Tanggal Rekapitulasi Tidak Boleh Kosong!</span>';
    }else{
        $tanggal=$_POST['tanggal'];
        if(empty($_POST['co_ass'])){
            $co_ass="0";
        }else{
            $co_ass=$_POST['co_ass'];
        }
        if(empty($_POST['co_ass_sembuh'])){
            $co_ass_sembuh="0";
        }else{
            $co_ass_sembuh=$_POST['co_ass_sembuh'];
        }
        if(empty($_POST['co_ass_isoman'])){
            $co_ass_isoman="0";
        }else{
            $co_ass_isoman=$_POST['co_ass_isoman'];
        }
        if(empty($_POST['co_ass_dirawat'])){
            $co_ass_dirawat="0";
        }else{
            $co_ass_dirawat=$_POST['co_ass_dirawat'];
        }
        if(empty($_POST['co_ass_meninggal'])){
            $co_ass_meninggal="0";
        }else{
            $co_ass_meninggal=$_POST['co_ass_meninggal'];
        }
        if(empty($_POST['residen'])){
            $residen="0";
        }else{
            $residen=$_POST['residen'];
        }
        if(empty($_POST['residen_sembuh'])){
            $residen_sembuh="0";
        }else{
            $residen_sembuh=$_POST['residen_sembuh'];
        }
        if(empty($_POST['residen_isoman'])){
            $residen_isoman="0";
        }else{
            $residen_isoman=$_POST['residen_isoman'];
        }
        if(empty($_POST['residen_dirawat'])){
            $residen_dirawat="0";
        }else{
            $residen_dirawat=$_POST['residen_dirawat'];
        }
        if(empty($_POST['residen_meninggal'])){
            $residen_meninggal="0";
        }else{
            $residen_meninggal=$_POST['residen_meninggal'];
        }
        if(empty($_POST['intership'])){
            $intership="0";
        }else{
            $intership=$_POST['intership'];
        }
        if(empty($_POST['intership_sembuh'])){
            $intership_sembuh="0";
        }else{
            $intership_sembuh=$_POST['intership_sembuh'];
        }
        if(empty($_POST['intership_isoman'])){
            $intership_isoman="0";
        }else{
            $intership_isoman=$_POST['intership_isoman'];
        }
        if(empty($_POST['intership_dirawat'])){
            $intership_dirawat="0";
        }else{
            $intership_dirawat=$_POST['intership_dirawat'];
        }
        if(empty($_POST['intership_meninggal'])){
            $intership_meninggal="0";
        }else{
            $intership_meninggal=$_POST['intership_meninggal'];
        }
        if(empty($_POST['dokter_spesialis'])){
            $dokter_spesialis="0";
        }else{
            $dokter_spesialis=$_POST['dokter_spesialis'];
        }
        if(empty($_POST['dokter_spesialis_sembuh'])){
            $dokter_spesialis_sembuh="0";
        }else{
            $dokter_spesialis_sembuh=$_POST['dokter_spesialis_sembuh'];
        }
        if(empty($_POST['dokter_spesialis_isoman'])){
            $dokter_spesialis_isoman="0";
        }else{
            $dokter_spesialis_isoman=$_POST['dokter_spesialis_isoman'];
        }
        if(empty($_POST['dokter_spesialis_dirawat'])){
            $dokter_spesialis_dirawat="0";
        }else{
            $dokter_spesialis_dirawat=$_POST['dokter_spesialis_dirawat'];
        }
        if(empty($_POST['dokter_spesialis_meninggal'])){
            $dokter_spesialis_meninggal="0";
        }else{
            $dokter_spesialis_meninggal=$_POST['dokter_spesialis_meninggal'];
        }
        if(empty($_POST['dokter_umum'])){
            $dokter_umum="0";
        }else{
            $dokter_umum=$_POST['dokter_umum'];
        }
        if(empty($_POST['dokter_umum_sembuh'])){
            $dokter_umum_sembuh="0";
        }else{
            $dokter_umum_sembuh=$_POST['dokter_umum_sembuh'];
        }
        if(empty($_POST['dokter_umum_isoman'])){
            $dokter_umum_isoman="0";
        }else{
            $dokter_umum_isoman=$_POST['dokter_umum_isoman'];
        }
        if(empty($_POST['dokter_umum_dirawat'])){
            $dokter_umum_dirawat="0";
        }else{
            $dokter_umum_dirawat=$_POST['dokter_umum_dirawat'];
        }
        if(empty($_POST['dokter_umum_meninggal'])){
            $dokter_umum_meninggal="0";
        }else{
            $dokter_umum_meninggal=$_POST['dokter_umum_meninggal'];
        }
        if(empty($_POST['dokter_gigi'])){
            $dokter_gigi="0";
        }else{
            $dokter_gigi=$_POST['dokter_gigi'];
        }
        if(empty($_POST['dokter_gigi_sembuh'])){
            $dokter_gigi_sembuh="0";
        }else{
            $dokter_gigi_sembuh=$_POST['dokter_gigi_sembuh'];
        }
        if(empty($_POST['dokter_gigi_isoman'])){
            $dokter_gigi_isoman="0";
        }else{
            $dokter_gigi_isoman=$_POST['dokter_gigi_isoman'];
        }
        if(empty($_POST['dokter_gigi_dirawat'])){
            $dokter_gigi_dirawat="0";
        }else{
            $dokter_gigi_dirawat=$_POST['dokter_gigi_dirawat'];
        }
        if(empty($_POST['dokter_gigi_meninggal'])){
            $dokter_gigi_meninggal="0";
        }else{
            $dokter_gigi_meninggal=$_POST['dokter_gigi_meninggal'];
        }
        if(empty($_POST['perawat'])){
            $perawat="0";
        }else{
            $perawat=$_POST['perawat'];
        }
        if(empty($_POST['perawat_sembuh'])){
            $perawat_sembuh="0";
        }else{
            $perawat_sembuh=$_POST['perawat_sembuh'];
        }
        if(empty($_POST['perawat_isoman'])){
            $perawat_isoman="0";
        }else{
            $perawat_isoman=$_POST['perawat_isoman'];
        }
        if(empty($_POST['perawat_dirawat'])){
            $perawat_dirawat="0";
        }else{
            $perawat_dirawat=$_POST['perawat_dirawat'];
        }
        if(empty($_POST['perawat_meninggal'])){
            $perawat_meninggal="0";
        }else{
            $perawat_meninggal=$_POST['perawat_meninggal'];
        }
        if(empty($_POST['bidan'])){
            $bidan="0";
        }else{
            $bidan=$_POST['bidan'];
        }
        if(empty($_POST['bidan_sembuh'])){
            $bidan_sembuh="0";
        }else{
            $bidan_sembuh=$_POST['bidan_sembuh'];
        }
        if(empty($_POST['bidan_isoman'])){
            $bidan_isoman="0";
        }else{
            $bidan_isoman=$_POST['bidan_isoman'];
        }
        if(empty($_POST['bidan_dirawat'])){
            $bidan_dirawat="0";
        }else{
            $bidan_dirawat=$_POST['bidan_dirawat'];
        }
        if(empty($_POST['bidan_meninggal'])){
            $bidan_meninggal="0";
        }else{
            $bidan_meninggal=$_POST['bidan_meninggal'];
        }
        if(empty($_POST['apoteker'])){
            $apoteker="0";
        }else{
            $apoteker=$_POST['apoteker'];
        }
        if(empty($_POST['apoteker_sembuh'])){
            $apoteker_sembuh="0";
        }else{
            $apoteker_sembuh=$_POST['apoteker_sembuh'];
        }
        if(empty($_POST['apoteker_isoman'])){
            $apoteker_isoman="0";
        }else{
            $apoteker_isoman=$_POST['apoteker_isoman'];
        }
        if(empty($_POST['apoteker_dirawat'])){
            $apoteker_dirawat="0";
        }else{
            $apoteker_dirawat=$_POST['apoteker_dirawat'];
        }
        if(empty($_POST['apoteker_meninggal'])){
            $apoteker_meninggal="0";
        }else{
            $apoteker_meninggal=$_POST['apoteker_meninggal'];
        }
        if(empty($_POST['radiografer'])){
            $radiografer="0";
        }else{
            $radiografer=$_POST['radiografer'];
        }
        if(empty($_POST['radiografer_sembuh'])){
            $radiografer_sembuh="0";
        }else{
            $radiografer_sembuh=$_POST['radiografer_sembuh'];
        }
        if(empty($_POST['radiografer_isoman'])){
            $radiografer_isoman="0";
        }else{
            $radiografer_isoman=$_POST['radiografer_isoman'];
        }
        if(empty($_POST['radiografer_dirawat'])){
            $radiografer_dirawat="0";
        }else{
            $radiografer_dirawat=$_POST['radiografer_dirawat'];
        }
        if(empty($_POST['radiografer_meninggal'])){
            $radiografer_meninggal="0";
        }else{
            $radiografer_meninggal=$_POST['radiografer_meninggal'];
        }
        if(empty($_POST['analis_lab'])){
            $analis_lab="0";
        }else{
            $analis_lab=$_POST['analis_lab'];
        }
        if(empty($_POST['analis_lab_sembuh'])){
            $analis_lab_sembuh="0";
        }else{
            $analis_lab_sembuh=$_POST['analis_lab_sembuh'];
        }
        if(empty($_POST['analis_lab_isoman'])){
            $analis_lab_isoman="0";
        }else{
            $analis_lab_isoman=$_POST['analis_lab_isoman'];
        }
        if(empty($_POST['analis_lab_dirawat'])){
            $analis_lab_dirawat="0";
        }else{
            $analis_lab_dirawat=$_POST['analis_lab_dirawat'];
        }
        if(empty($_POST['analis_lab_meninggal'])){
            $analis_lab_meninggal="0";
        }else{
            $analis_lab_meninggal=$_POST['analis_lab_meninggal'];
        }
        if(empty($_POST['nakes_lainnya'])){
            $nakes_lainnya="0";
        }else{
            $nakes_lainnya=$_POST['nakes_lainnya'];
        }
        if(empty($_POST['nakes_lainnya_sembuh'])){
            $nakes_lainnya_sembuh="0";
        }else{
            $nakes_lainnya_sembuh=$_POST['nakes_lainnya_sembuh'];
        }
        if(empty($_POST['nakes_lainnya_isoman'])){
            $nakes_lainnya_isoman="0";
        }else{
            $nakes_lainnya_isoman=$_POST['nakes_lainnya_isoman'];
        }
        if(empty($_POST['nakes_lainnya_dirawat'])){
            $nakes_lainnya_dirawat="0";
        }else{
            $nakes_lainnya_dirawat=$_POST['nakes_lainnya_dirawat'];
        }
        if(empty($_POST['nakes_lainnya_meninggal'])){
            $nakes_lainnya_meninggal="0";
        }else{
            $nakes_lainnya_meninggal=$_POST['nakes_lainnya_meninggal'];
        }
        //Buat json
        $data = array(
            'tanggal' => $tanggal,
            'co_ass' => $co_ass,
            'residen' => $residen,
            'intership' => $intership,
            'dokter_spesialis' => $dokter_spesialis,
            'dokter_umum' => $dokter_umum,
            'dokter_gigi' => $dokter_gigi,
            'perawat' => $perawat,
            'bidan' => $bidan,
            'apoteker' => $apoteker,
            'radiografer' => $radiografer,
            'analis_lab' => $analis_lab,
            'radiografer' => $radiografer,
            'nakes_lainnya' => $nakes_lainnya,
            'co_ass_meninggal' => $co_ass_meninggal,
            'residen_meninggal' => $residen_meninggal,
            'intership_meninggal' => $intership_meninggal,
            'dokter_spesialis_meninggal' => $dokter_spesialis_meninggal,
            'dokter_umum_meninggal' => $dokter_umum_meninggal,
            'dokter_gigi_meninggal' => $dokter_gigi_meninggal,
            'perawat_meninggal' => $perawat_meninggal,
            'bidan_meninggal' => $bidan_meninggal,
            'apoteker_meninggal' => $apoteker_meninggal,
            'radiografer_meninggal' => $radiografer_meninggal,
            'analis_lab_meninggal' => $analis_lab_meninggal,
            'nakes_lainnya_meninggal' => $nakes_lainnya_meninggal,
            'co_ass_dirawat' => $co_ass_dirawat,
            'co_ass_isoman' => $co_ass_isoman,
            'co_ass_sembuh' => $co_ass_sembuh,
            'residen_dirawat' => $residen_dirawat,
            'residen_isoman' => $residen_isoman,
            'residen_sembuh' => $residen_sembuh,
            'intership_dirawat' => $intership_dirawat,
            'intership_isoman' => $intership_isoman,
            'intership_sembuh' => $intership_sembuh,
            'dokter_spesialis_dirawat' => $dokter_spesialis_dirawat,
            'dokter_spesialis_isoman' => $dokter_spesialis_isoman,
            'dokter_spesialis_sembuh' => $dokter_spesialis_sembuh,
            'dokter_umum_dirawat' => $dokter_umum_dirawat,
            'dokter_umum_isoman' => $dokter_umum_isoman,
            'dokter_umum_sembuh' => $dokter_umum_sembuh,
            'dokter_gigi_dirawat' => $dokter_gigi_dirawat,
            'dokter_gigi_isoman' => $dokter_gigi_isoman,
            'dokter_gigi_sembuh' => $dokter_gigi_sembuh,
            'bidan_dirawat' => $bidan_dirawat,
            'bidan_isoman' => $bidan_isoman,
            'bidan_sembuh' => $bidan_sembuh,
            'apoteker_dirawat' => $apoteker_dirawat,
            'apoteker_isoman' => $apoteker_isoman,
            'apoteker_sembuh' => $apoteker_sembuh,
            'radiografer_dirawat' => $radiografer_dirawat,
            'radiografer_isoman' => $radiografer_isoman,
            'radiografer_sembuh' => $radiografer_sembuh,
            'analis_lab_dirawat' => $analis_lab_dirawat,
            'analis_lab_isoman' => $analis_lab_isoman,
            'analis_lab_sembuh' => $analis_lab_sembuh,
            'nakes_lainnya_dirawat' => $nakes_lainnya_dirawat,
            'nakes_lainnya_isoman' => $nakes_lainnya_isoman,
            'nakes_lainnya_sembuh' => $nakes_lainnya_sembuh,
            'perawat_dirawat' => $perawat_dirawat,
            'perawat_isoman' => $perawat_isoman,
            'perawat_sembuh' => $perawat_sembuh
        );
        $json_data = json_encode($data);
        //Kirim Data
        $KirimData=AddNakesTerinfeksi($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data);
        if(empty($KirimData)){
            echo '<span class="text-danger">Tidak ada respon dari service SIRS online</span>';
        }else{
            $response = json_decode($KirimData, true);
            $status=$response['HarianNakesTerinfeksi'][0]['status'];
            if($status=="200"){
                //Simpan Log
                $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Tambah Nakes Terinfeksi","Nakes Terinfeksi SIRS Online",$SessionIdAkses,$LogJsonFile);
                if($MenyimpanLog=="Berhasil"){
                    //Cek Task
                    $CekTaskSirsOnline = mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM sirs_online_task WHERE kategori='Nakes Terinfeksi' AND tanggal='$tanggal'"));
                    if(empty($CekTaskSirsOnline )){
                        $tgllapor=date('Y-m-d H:i:s');
                        $strtotime=strtotime($tgllapor);
                        //Simpan Task
                        $entry="INSERT INTO sirs_online_task (
                            tanggal,
                            updatetime,
                            kategori,
                            keterangan,
                            id_akses
                        ) VALUES (
                            '$tanggal',
                            '$strtotime',
                            'Nakes Terinfeksi',
                            '$json_data',
                            '$SessionIdAkses'
                        )";
                        $Input=mysqli_query($Conn, $entry);
                        if($Input){
                            $ProsesSimpantask="Berhasil";
                        }else{
                            $ProsesSimpantask="Gagal";
                        }
                    }else{
                        //Update Task
                        $UpdateLaporanOksigen = mysqli_query($Conn,"UPDATE sirs_online_task SET 
                            updatetime='$strtotime',
                            keterangan='$json_data'
                        WHERE kategori='Nakes Terinfeksi' AND tanggal='$tanggal'") or die(mysqli_error($Conn)); 
                        if($UpdateLaporanOksigen){
                            $ProsesSimpantask="Berhasil";
                        }else{
                            $ProsesSimpantask="Gagal";
                        }
                    }
                    if( $ProsesSimpantask=="Berhasil"){
                        echo '<span class="text-success" id="NotifikasiRekapNakesTerinfeksiBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Task SIRS Online!</span>';
                    }
                }else{
                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                }
            }else{
                echo '<span class="text-danger">Kirim Data Naker Terinfeksi Gagal!</span><br>';
                echo '<span class="text-danger">Keterangan : '.$KirimData.'</span>';
            }
        }
    }
?>