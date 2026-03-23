<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    //Tangkap id_antrian
    if(empty($_POST['id_antrian'])){
        echo '      <span class="text-danger">';
        echo '          Data ID Antrian Tidak Boleh Kosong.';
        echo '      </span>';
    }else{
        if(empty($_POST['id_kunjungan'])){
            echo '      <span class="text-danger">';
            echo '          Data ID Kunjungan Tidak Boleh Kosong.';
            echo '      </span>';
        }else{
            $id_antrian=$_POST['id_antrian'];
            $id_kunjungan=$_POST['id_kunjungan'];
            //Buka Data Kunjungan Web
            $url=getServiceUrl2('Detail Kunjungan');
            $KirimData = array(
                'api_key' => $api_key,
                'id_kunjungan' => $id_kunjungan
            );
            $json = json_encode($KirimData);
            //Mulai CURL
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, "$url");
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
                echo '      <span class="text-danger">';
                echo '          '.$err.'';
                echo '      </span>';
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
                if($code!==200){
                    echo '      <span class="text-danger">';
                    echo '          '.$massage.'';
                    echo '      </span>';
                }else{
                    $id_web_pasien=$JsonData['response']['id_web_pasien'];
                    if(empty($JsonData['response']['id_pasien'])){
                        $id_pasien="";
                    }else{
                        $id_pasien=$JsonData['response']['id_pasien'];
                    }
                    if(empty($JsonData['response']['nomorreferensi'])){
                        $nomorreferensi="";
                    }else{
                        $nomorreferensi=$JsonData['response']['nomorreferensi'];
                    }
                    $tanggal_daftar=$JsonData['response']['tanggal_daftar'];
                    $tanggal_kunjungan=$JsonData['response']['tanggal_kunjungan'];
                    $jam_kunjungan=$JsonData['response']['jam_kunjungan'];
                    $kode_dokter=$JsonData['response']['kode_dokter'];
                    $nama_dokter=$JsonData['response']['nama_dokter'];
                    $kodepoli=$JsonData['response']['kodepoli'];
                    $namapoli=$JsonData['response']['namapoli'];
                    $keluhan=$JsonData['response']['keluhan'];
                    $pembayaran=$JsonData['response']['pembayaran'];
                    $status=$JsonData['response']['status'];
                    $no_antrian="";
                    $kodebooking="";
                    if(empty($JsonData['response']['keterangan'])){
                        $keterangan="";
                    }else{
                        $keterangan=$JsonData['response']['keterangan'];
                    }
                    //Melakukan Update Ke website
                    $UrlUpdateKunjungan=getServiceUrl2('Edit Kunjungan');
                    $KirimDataKunjungan= array(
                        'api_key' => $api_key,
                        'id_kunjungan' => $id_kunjungan,
                        'id_web_pasien' => $id_web_pasien,
                        'id_pasien' => $id_pasien,
                        'tanggal_daftar' => $tanggal_daftar,
                        'tanggal_kunjungan' => $tanggal_kunjungan,
                        'jam_kunjungan' => $jam_kunjungan,
                        'kode_dokter' => $kode_dokter,
                        'kodepoli' => $kodepoli,
                        'keluhan' => $keluhan,
                        'pembayaran' => $pembayaran,
                        'status' => "Terdaftar",
                        'no_antrian' => "$no_antrian",
                        'kodebooking' => $kodebooking,
                        'keterangan' => "Peserta harap checkin di lokasi sebelum jam praktek"
                    );
                    $Metode ="POST";
                    $ResponseKunjungan=GetResponseApis($UrlUpdateKunjungan,$KirimDataKunjungan,$Metode);
                    if($ResponseKunjungan['metadata']['code']==200){
                        $HapusAntrianSimrs = mysqli_query($Conn, "DELETE FROM antrian WHERE id_antrian='$id_antrian'") or die(mysqli_error($Conn));
                        if($HapusAntrianSimrs){
                            $_SESSION['NotifikasiSwal']="Hapus Antrian Berhasil";
                            echo "<span class='text-success' id='NotifikasiHapusAntrianBerhasil'>Success</span><br>";
                        }else{
                            echo "<span class='text-danger'>Hapus Antrian SIMRS Gagal</span>";
                        }
                    }else{
                        if(empty($ResponseKunjungan['metadata']['massage'])){
                            echo "<span class='text-danger'>Kesalahan pada service website tidak diketahui</span>";
                        }else{
                            $massageResponse=$ResponseKunjungan['metadata']['massage'];
                            echo "<span class='text-danger'>$massageResponse</span><br>";
                        }
                    }
                }
            }
        }
    }
?>
