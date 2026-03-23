<?php
    //koneksi dan session
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Page/WebFAQ/FungsiFAQ.php";
    $Url=urlService('Add Ruang Rawat');
    $updatetime=date('Y-m-d H:i');
    //Validasi Form Data
    if(empty($_POST['ruang_rawat'])){
        echo '<span class="text-danger">Nama Ruang Rawat Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['kelas'])){
            echo '<span class="text-danger">Kelas Ruang Rawat Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['kode'])){
                echo '<span class="text-danger">Kode Kelas Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['kapasitas'])){
                    echo '<span class="text-danger">Kapasitas Ruangan Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['status'])){
                        echo '<span class="text-danger">Status Ruang Rawat Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['pasien'])){
                            $pasien=0;
                        }else{
                            $pasien=$_POST['pasien'];
                        }
                        $ruang_rawat=$_POST['ruang_rawat'];
                        $kelas=$_POST['kelas'];
                        $kode=$_POST['kode'];
                        $kapasitas=$_POST['kapasitas'];
                        $status=$_POST['status'];
                        $KirimData = array(
                            'api_key' => $api_key,
                            'ruang_rawat' => $ruang_rawat,
                            'kelas' => $kelas,
                            'kode' => $kode,
                            'kapasitas' => $kapasitas,
                            'pasien_rawat' => $pasien,
                            'status' => $status
                        );
                        $json = json_encode($KirimData);
                        //Mulai CURL
                        $ch = curl_init();
                        curl_setopt($ch,CURLOPT_URL, "$Url");
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch,CURLOPT_HEADER, 0);
                        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $content = curl_exec($ch);
                        $err = curl_error($ch);
                        curl_close($ch);
                        if(!empty($err)){
                            echo '<span class="text-danger">'.$err.'</span>';
                        }else{
                            $JsonData =json_decode($content, true);
                            if(!empty($JsonData['metadata']['massage'])){
                                $massage=$JsonData['metadata']['massage'];
                            }else{
                                $massage="";
                            }
                            if(!empty($JsonData['metadata']['code'])){
                                $code=$JsonData['metadata']['code'];
                            }else{
                                $code="";
                            }
                            if($code==200){
                                echo '<span class="text-success" id="NotifikasiTambahRuanganBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">Simpan Ruang Rawat gagal<br>Pesan: '.$massage.'<br>URL: '.$Url.'</span>';
                            }
                        }
                    }
                }
            }
        }
    }
?>