<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    $taskid=2;
    $jenisresep="Tidak ada";
    //Tangkap KodeBooking
    if(empty($_POST['KodeBooking'])){
        echo '<span class="text-danger">';
        echo '  Kode Booking Tidak Boleh Kosong!!';
        echo '</span>';
    }else{
        $kodebooking=$_POST['KodeBooking'];
        $id_antrian=getDataDetail($Conn,'antrian','kodebooking',$kodebooking,'id_antrian');
        $UpdateWaktuTaskId=UpdateWaktuTaskId($url_antrol,$consid,$secret_key,$user_key,$kodebooking,$taskid,$jenisresep);
        if(empty($UpdateWaktuTaskId)){
            echo '<span class="text-danger">Terjadi kesalahan pada saat update pada bridging BPJS!</span>';
        }else{
            $ambil_json =json_decode($UpdateWaktuTaskId, true);
            if(empty($ambil_json["metadata"])){
                echo '<span class="text-danger">'.$UpdateWaktuTaskId.'</span>';
            }else{
                if($ambil_json["metadata"]["code"]!==200){
                    echo '<span class="text-danger">'.$ambil_json["metadata"]["message"].'</span>';
                }else{
                    if(empty($id_antrian)){
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Task ID 2 Antrian Berhasil","Antrian",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            $_SESSION['NotifikasiSwal']="Update Antrian Berhasil";
                        echo '<span class="text-success" id="NotifikasiProsesUpdatePanggilAntrianBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        $Update = mysqli_query($Conn,"UPDATE antrian SET 
                            status='Panggil'
                        WHERE id_antrian='$id_antrian'") or die(mysqli_error($Conn)); 
                        if($Update){
                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Task ID 2 Antrian Berhasil","Antrian",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                $_SESSION['NotifikasiSwal']="Update Antrian Berhasil";
                            echo '<span class="text-success" id="NotifikasiProsesUpdatePanggilAntrianBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                            }
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Update Data Antrian Pada SIMRS!</span>';
                        }
                    }
                }
            }
        }
    }
?>
