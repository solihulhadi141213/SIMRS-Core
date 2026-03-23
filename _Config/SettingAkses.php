<?php
    // //setting_a
    // $QryAksesHalaman = mysqli_query($Conn,"SELECT * FROM setting_a WHERE akses='$SessionAkses'")or die(mysqli_error($Conn));
    // $DataAksesHalaman = mysqli_fetch_array($QryAksesHalaman);
    // //rincian Ijin Halaman
    // $id_setting_a= $DataAksesHalaman['id_setting_a'];
    // $bantuan= $DataAksesHalaman['bantuan'];
    // $aksesibilitas= $DataAksesHalaman['aksesibilitas'];
    // $SettingProfile= $DataAksesHalaman['SettingProfile'];
    // $Personalisasi= $DataAksesHalaman['Personalisasi'];
    // $SettingBridging= $DataAksesHalaman['SettingBridging'];
    // $LogAktivitas= $DataAksesHalaman['LogAktivitas'];
    // $RefPoli= $DataAksesHalaman['RefPoli'];
    // $RefDokter= $DataAksesHalaman['RefDokter'];
    // $JadwalPraktek= $DataAksesHalaman['JadwalPraktek'];
    // $Wilayah= $DataAksesHalaman['Wilayah'];
    // $KelasRuangan= $DataAksesHalaman['KelasRuangan'];
    // $MasterPasien= $DataAksesHalaman['MasterPasien'];
    // $Kunjungan= $DataAksesHalaman['Kunjungan'];
    // $Rujukan= $DataAksesHalaman['Rujukan'];
    // $SpriSkdp= $DataAksesHalaman['SpriSkdp'];
    // $FingerPrint= $DataAksesHalaman['FingerPrint'];
    // $Monitoring= $DataAksesHalaman['Monitoring'];
    // $Antrian= $DataAksesHalaman['Antrian'];
    // $JadwalOperasi= $DataAksesHalaman['JadwalOperasi'];
    // //setting_B
    // $QryAksesHalaman2 = mysqli_query($Conn,"SELECT * FROM setting_b WHERE akses='$SessionAkses'")or die(mysqli_error($Conn));
    // $DataAksesHalaman2 = mysqli_fetch_array($QryAksesHalaman2);
    // //rincian Ijin Halaman
    // $id_setting_b= $DataAksesHalaman2['id_setting_b'];
    // $DIG= $DataAksesHalaman2['DIG'];
    // $PG= $DataAksesHalaman2['PG'];
    // $DIS= $DataAksesHalaman2['DIS'];
    // $SA= $DataAksesHalaman2['SA'];
    // $PNB= $DataAksesHalaman2['PNB'];
    // $DA= $DataAksesHalaman2['DA'];
    // $DK= $DataAksesHalaman2['DK'];
    // $WK= $DataAksesHalaman2['WK'];
    // $SK= $DataAksesHalaman2['SK'];
    // $DP= $DataAksesHalaman2['DP'];
    // $JP= $DataAksesHalaman2['JP'];
    // $BP= $DataAksesHalaman2['BP'];
    // $SM= $DataAksesHalaman2['SM'];
    // $AP= $DataAksesHalaman2['AP'];
    // $BYP= $DataAksesHalaman2['BYP'];
    // $BT= $DataAksesHalaman2['BT'];
    // $TGH= $DataAksesHalaman2['TGH'];
    // $TSS= $DataAksesHalaman2['TSS'];
    // $JRK= $DataAksesHalaman2['JRK'];
    // $BKB= $DataAksesHalaman2['BKB'];
    // $NRS= $DataAksesHalaman2['NRS'];
    // $DTI= $DataAksesHalaman2['DTI'];
    // $KLMS= $DataAksesHalaman2['KLMS'];


    function GetStatusAccess($Conn,$id_akses,$kode_fitur){
        //Cari id_akses_ref
        $QryRef= mysqli_query($Conn,"SELECT * FROM akses_ref WHERE kode='$kode_fitur'")or die(mysqli_error($Conn));
        $DataRef = mysqli_fetch_array($QryRef);
        if(empty($DataRef['id_akses_ref'])){
            $Response="";
        }else{
            $id_akses_ref=$DataRef['id_akses_ref'];
            //Buka Akses ACC
            $QryAcc= mysqli_query($Conn,"SELECT * FROM akses_acc WHERE id_akses_ref='$id_akses_ref' AND id_akses='$id_akses'")or die(mysqli_error($Conn));
            $DataAcc = mysqli_fetch_array($QryAcc);
            if(empty($DataAcc['status'])){
                $Response="";
            }else{
                $Response=$DataAcc['status'];
            }
        }
        return $Response;
    }
?>