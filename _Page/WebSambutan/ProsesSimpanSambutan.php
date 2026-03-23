<?php
    //Mengambil data sambutan dari service
    session_start();
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    if(empty($_POST['nama'])){
        echo '<small class="text-danger">Nama Tidak Boleh Kosong</small>';
    }else{
        if(empty($_POST['jabatan'])){
            echo '<small class="text-danger">Jabatan Tidak Boleh Kosong</small>';
        }else{
            if(empty($_POST['judul_sambutan'])){
                echo '<small class="text-danger">Judul Sambutan Tidak Boleh Kosong</small>';
            }else{
                if(empty($_POST['isi_sambutan'])){
                    echo '<small class="text-danger">Isi Sambutan Tidak Boleh Kosong</small>';
                }else{
                    $nama=$_POST['nama'];
                    $jabatan=$_POST['jabatan'];
                    $judul_sambutan=$_POST['judul_sambutan'];
                    $isi_sambutan=$_POST['isi_sambutan'];
                    //Tambahkan URL
                    $UrlSambutan=getServiceUrl2("Detail Sambutan");
                    $UrlSimpanSambutan=getServiceUrl2("Simpan Sambutan");
                    //Menentukan url dari setting
                    if(!empty($api_key)&&!empty($UrlSimpanSambutan)){
                        $KirimData = array(
                            'api_key' => $api_key,
                            'judul_sambutan' => $judul_sambutan,
                            'nama' => $nama,
                            'jabatan' => "$jabatan",
                            'isi_sambutan' => "$isi_sambutan",
                            'foto' => ""
                        );
                        $json = json_encode($KirimData);
                        //Mulai CURL
                        $ch = curl_init();
                        curl_setopt($ch,CURLOPT_URL, "$UrlSimpanSambutan");
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
                            echo '<small class="text-danger">'.$err.'</small>';
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
                                echo '<span class="text-success" id="NotifikasiSimpanSambutanBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">'.$massage.'</span>';
                            }
                        }
                    }else{
                        echo '<small class="text-danger">Terjadi kesalahan koneksi web</small>';
                    }
                }
            }
        }
    }
?>