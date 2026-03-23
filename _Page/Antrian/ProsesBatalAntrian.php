<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    //Tangkap kodebookingantrian
    if(empty($_POST['kodebookingantrian'])){
        echo '<span class="text-danger">Kode Booking Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['keterangan_pembatalan'])){
            echo '<span class="text-danger">Keterangan/Alasan Pembatalan Tidak Boleh Kosong!</span>';
        }else{
            $keterangan_pembatalan=$_POST['keterangan_pembatalan'];
            $kodebooking=$_POST['kodebookingantrian'];
            $BatalkanAntrian=BatalkanAntrian($url_antrol,$consid,$secret_key,$user_key,$kodebooking,$keterangan_pembatalan);
            if(empty($BatalkanAntrian)){
                echo '<span class="text-danger">Terjadi kesalahan pada saat update pada bridging BPJS!</span>';
            }else{
                $ambil_json =json_decode($BatalkanAntrian, true);
                if(empty($ambil_json["metadata"])){
                    echo '<span class="text-danger">'.$BatalkanAntrian.'</span>';
                }else{
                    if($ambil_json["metadata"]["code"]!==200){
                        echo '<span class="text-danger">'.$ambil_json["metadata"]["message"].'</span>';
                    }else{
                        //Tangkap id_antrian
                        if(empty($_POST['id_antrian'])){
                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Batal Antrian Berhasil","Antrian",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                $_SESSION['NotifikasiSwal']="Batal Antrian Berhasil";
                            echo '<span class="text-success" id="NotifikasiBatalAntrianBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                            }
                        }else{
                            $id_antrian=$_POST['id_antrian'];
                            // Update Batal Antrian
                            $id_antrian=getDataDetail($Conn,'antrian','kodebooking',$kodebooking,'id_antrian');
                            $Update = mysqli_query($Conn,"UPDATE antrian SET 
                                status='Batal'
                            WHERE id_antrian='$id_antrian'") or die(mysqli_error($Conn)); 
                            if($Update){
                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Batal Antrian Berhasil","Antrian",$SessionIdAkses,$LogJsonFile);
                                if($MenyimpanLog=="Berhasil"){
                                    $_SESSION['NotifikasiSwal']="Batal Antrian Berhasil";
                                echo '<span class="text-success" id="NotifikasiBatalAntrianBerhasil">Success</span>';
                                }else{
                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                }
                            }else{
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Melakukan Update Pada Database Antrian SIMRS!</span>';
                            }
                        }
                    }
                }
            }
        }
    }
?>
