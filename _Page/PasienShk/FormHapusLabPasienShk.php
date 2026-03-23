<?php
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Tangkap GetContent
    if(empty($_POST['GetContent'])){
        echo '  <div class="text-danger">';
        echo '      ID SHK dan ID Hasil Tidak Boleh Kosong';
        echo '  </div>';
    }else{
        $GetContent=$_POST['GetContent'];
        //Pecah Kontnetn
        $Explode=explode(",", $GetContent);
        $id_shk=$Explode[0];
        $id_hasil=$Explode[1];
        //Validasi Data
        if(ctype_digit($id_shk)){
            echo '  <div class="text-danger">';
            echo '      ID SHK '.$id_shk.' Tidak Valid';
            echo '  </div>';
        }else{
            if(!preg_match("/^[0-9]*$/",$id_hasil)){
                echo '  <div class="text-danger">';
                echo '      ID Hasil Tidak Valid';
                echo '  </div>';
            }else{
                //Buka Data Pasien SHK
                $response=DetailLabPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$id_shk);
                if(empty($response)){
                    echo '  <div class="text-danger">';
                    echo '      Tidak ada Response Dari SIRS Online';
                    echo '  </div>';
                }else{
                    $data = json_decode($response, true);
                    if(empty($data['shk'])){
                        echo '  <div class="text-danger">';
                        echo '      Tidak ada Response Dari SIRS Online <br> Response: <textarea class="form-control">'.$response.'</textarea>';
                        echo '  </div>';
                    }else{
                        if(empty($data['shk'])){
                            echo '  <div class="text-danger">';
                            echo '      Tidak ada hasil lab untuk pasien SHK tersebut';
                            echo '  </div>';
                        }else{
                            if(!is_array($data['shk'])){
                                echo '  <div class="text-danger">';
                                echo '      '.$data['shk'].'';
                                echo '  </div>';
                            }else{
                                echo '<input type="hidden" name="id_hasil" value="'.$id_hasil.'">';
                                echo '<input type="hidden" name="id_shk" value="'.$id_shk.'">';
                                echo 'Proses hapus hasil lab SHK akan langsung dilakukan melalui service SIRS online.';
                                echo "<dt>Apakah Anda Yakin Akan Menghapus Data ID Hasil Lab SHK $id_hasil Ini?</dt>";
                            }
                        }
                    }
                }
            }
        }
    }
?>