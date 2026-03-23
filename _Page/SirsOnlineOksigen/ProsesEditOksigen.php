<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi ke database
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $WaktuLog=date('Y-m-d H:i:s');
    //Buka Pengaturan SIRS Online
    $x_id_rs=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','id_rs');
    $url_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','url_sirs_online');
    $password_sirs_online=getDataDetail($Conn,'setting_sirs_online','status','Aktiv','password_sirs_online');
    //Tanggal Lapor
    $tgllapor=date('Y-m-d H:i:s');
    $strtotime=strtotime($tgllapor);
    //Buat Variabel
    if(empty($_POST['id_sirs_online_task'])){
        echo '<span class="text-danger">ID Task Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['tanggal'])){
            echo '<span class="text-danger">Tanggal Laporan Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['satuan'])){
                echo '<span class="text-danger">Satuan Tidak Boleh Kosong!</span>';
            }else{
                $id_sirs_online_task=$_POST['id_sirs_online_task'];
                $tanggal=$_POST['tanggal'];
                $satuan=$_POST['satuan'];
                if(empty($_POST['p_cair'])){
                    $p_cair="0";
                }else{
                    $p_cair=$_POST['p_cair'];
                }
                if(empty($_POST['p_tabung_kecil'])){
                    $p_tabung_kecil="0";
                }else{
                    $p_tabung_kecil=$_POST['p_tabung_kecil'];
                }
                if(empty($_POST['p_tabung_sedang'])){
                    $p_tabung_sedang="0";
                }else{
                    $p_tabung_sedang=$_POST['p_tabung_sedang'];
                }
                if(empty($_POST['p_tabung_besar'])){
                    $p_tabung_besar="0";
                }else{
                    $p_tabung_besar=$_POST['p_tabung_besar'];
                }
                if(empty($_POST['k_isi_cair'])){
                    $k_isi_cair="0";
                }else{
                    $k_isi_cair=$_POST['k_isi_cair'];
                }
                if(empty($_POST['k_isi_tabung_kecil'])){
                    $k_isi_tabung_kecil="0";
                }else{
                    $k_isi_tabung_kecil=$_POST['k_isi_tabung_kecil'];
                }
                if(empty($_POST['k_isi_tabung_sedang'])){
                    $k_isi_tabung_sedang="0";
                }else{
                    $k_isi_tabung_sedang=$_POST['k_isi_tabung_sedang'];
                }
                if(empty($_POST['k_isi_tabung_besar'])){
                    $k_isi_tabung_besar="0";
                }else{
                    $k_isi_tabung_besar=$_POST['k_isi_tabung_besar'];
                }
                //Validasi angka dan desimal
                if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $p_cair)){
                    echo '<span class="text-danger">Isi Angka Jumlah Oksigen Hanya Boleh Angka dan Desimal</span>';
                }else{
                    if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $p_tabung_kecil)){
                        echo '<span class="text-danger">Isi Angka Jumlah Oksigen Hanya Boleh Angka dan Desimal</span>';
                    }else{
                        if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $p_tabung_sedang)){
                            echo '<span class="text-danger">Isi Angka Jumlah Oksigen Hanya Boleh Angka dan Desimal</span>';
                        }else{
                            if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $p_tabung_besar)){
                                echo '<span class="text-danger">Isi Angka Jumlah Oksigen Hanya Boleh Angka dan Desimal</span>';
                            }else{
                                if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $k_isi_cair)){
                                    echo '<span class="text-danger">Isi Angka Jumlah Oksigen Hanya Boleh Angka dan Desimal</span>';
                                }else{
                                    if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $k_isi_tabung_kecil)){
                                        echo '<span class="text-danger">Isi Angka Jumlah Oksigen Hanya Boleh Angka dan Desimal</span>';
                                    }else{
                                        if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $k_isi_tabung_sedang)){
                                            echo '<span class="text-danger">Isi Angka Jumlah Oksigen Hanya Boleh Angka dan Desimal</span>';
                                        }else{
                                            if(!preg_match('/^[0-9]+(?:\.[0-9]+)?$/', $k_isi_tabung_besar)){
                                                echo '<span class="text-danger">Isi Angka Jumlah Oksigen Hanya Boleh Angka dan Desimal</span>';
                                            }else{
                                                //Buat JSON
                                                $data = array(
                                                    'tanggal' => $tanggal,
                                                    'p_cair' => $p_cair,
                                                    'p_tabung_kecil' => $p_tabung_kecil,
                                                    'p_tabung_sedang' => $p_tabung_sedang,
                                                    'p_tabung_besar' => $p_tabung_besar,
                                                    'k_isi_cair' => $k_isi_cair,
                                                    'k_isi_tabung_kecil' => $k_isi_tabung_kecil,
                                                    'k_isi_tabung_sedang' => $k_isi_tabung_sedang,
                                                    'k_isi_tabung_besar' => $k_isi_tabung_besar
                                                );
                                                $json_data = json_encode($data);
                                                //Kirim Data
                                                $KirimData=UpdateLaporanOksigen($x_id_rs,$password_sirs_online,$url_sirs_online,$json_data);
                                                if(empty($KirimData)){
                                                    echo '<span class="text-danger">Tidak ada response dari service SIRS Online</span>';
                                                }else{
                                                    $response = json_decode($KirimData, true);
                                                    $status=$response['Oksigenasi'][0]['status'];
                                                    if($status=="200"){
                                                        $UpdateLaporanOksigen = mysqli_query($Conn,"UPDATE sirs_online_task SET 
                                                            tanggal='$tanggal',
                                                            updatetime='$strtotime',
                                                            keterangan='$json_data'
                                                        WHERE id_sirs_online_task='$id_sirs_online_task'") or die(mysqli_error($Conn)); 
                                                        if($UpdateLaporanOksigen){
                                                            $MenyimpanLog=getSaveLog($Conn,$WaktuLog,$SessionNama,"Edit Laporan Oksigen","Oksigen SIRS Online",$SessionIdAkses,$LogJsonFile);
                                                            if($MenyimpanLog=="Berhasil"){
                                                                echo '<span class="text-success" id="NotifikasiEditLaporanOksigenBerhasil">Success</span>';
                                                            }else{
                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                            }
                                                        }else{
                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan data ke database!</span>';
                                                        }
                                                    }else{
                                                        $message=$response['Oksigenasi'][0]['message'];
                                                        echo '<span class="text-danger">Terjadi kesalahan pada saat kirim service SIRS online<textarea class="form-control">'.$message.'</textarea></span>';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>