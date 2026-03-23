<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingBridging.php";
    include "../../vendor/autoload.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['KodePoli'])){
        echo '<option value="">Pilih</option>';
    }else{
        if(empty($_POST['KodeDokter'])){
            echo '<option value="">Pilih</option>';
        }else{
            if(empty($_POST['KodeHari'])){
                echo '<option value="">Pilih</option>';
            }else{
                $KodePoli=$_POST['KodePoli'];
                $KodeDokter=$_POST['KodeDokter'];
                $KodeHari=$_POST['KodeHari'];
                if($KodeHari=="1"){
                    $NamaHari="Senin";
                }else{
                    if($KodeHari=="2"){
                        $NamaHari="Selasa";
                    }else{
                        if($KodeHari=="3"){
                            $NamaHari="Rabu";
                        }else{
                            if($KodeHari=="4"){
                                $NamaHari="Kamis";
                            }else{
                                if($KodeHari=="5"){
                                    $NamaHari="Jumat";
                                }else{
                                    if($KodeHari=="6"){
                                        $NamaHari="Sabtu";
                                    }else{
                                        if($KodeHari=="7"){
                                            $NamaHari="Minggu";
                                        }else{
                                            $NamaHari="";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                //Buka Kode Poli
                $id_poliklinik=getDataDetail($Conn,'poliklinik','kode',$KodePoli,'id_poliklinik');
                $id_dokter=getDataDetail($Conn,'dokter','kode',$KodeDokter,'id_dokter');
                $QryJadwal = mysqli_query($Conn, "SELECT * FROM jadwal_dokter WHERE id_poliklinik='$id_poliklinik' AND id_dokter='$id_dokter' AND hari='$NamaHari' ORDER BY id_jadwal ASC");
                while ($DataJadwal = mysqli_fetch_array($QryJadwal)) {
                    $id_jadwal = $DataJadwal['id_jadwal'];
                    $jam = $DataJadwal['jam'];
                    echo '      <option value="'.$jam.'">'.$jam.'</option>';
                }
            }
        }
    }
?>