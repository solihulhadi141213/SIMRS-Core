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
    if(empty($_POST['id_shk'])){
        echo '  <div class="text-danger">';
        echo '      ID SHK Tidak Boleh Kosong';
        echo '  </div>';
    }else{
        if(empty($_POST['id_hasil'])){
            echo '  <div class="text-danger">';
            echo '      ID SHK Tidak Boleh Kosong';
            echo '  </div>';
        }else{
            $id_shk=$_POST['id_shk'];
            $id_hasil=$_POST['id_hasil'];
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
                    //Hapus Lab SHK
                    $response=HapusLabPasienShk($x_id_rs,$password_sirs_online,$url_sirs_online,$id_shk,$id_hasil);
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
                            if(!is_array($data['shk'])){
                                echo '  <div class="text-danger">';
                                echo '      '.$data['shk'].'';
                                echo '  </div>';
                            }else{
                                $Code = $data['shk']['0']['status'];
                                if($Code=="200"){
                                    echo '<div class="text-succes" id="NotifikasiHapusLabPasienShkBerhhasil">Success</div>';
                                }else{
                                    echo '  <div class="text-danger">';
                                    echo '      '.$data['shk'].'';
                                    echo '  </div>';
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>