<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingKoneksiWeb.php";
    include "../../_Config/WebFunction.php";
    $Url=urlService('Add Jadwal');
    $updatetime=date('Y-m-d H:i');
    if(empty($_POST['id_dokter'])){
        echo '<span class="text-danger">ID Dokter Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['IdJadwalSimrs'])){
            echo '<span class="text-danger">Id Jadwal Tidak Boleh Kosong!</span>';
        }else{
            $id_dokter=$_POST['id_dokter'];
            $IdJadwalSimrs=$_POST['IdJadwalSimrs'];
            $jumlah_dipilih = count($IdJadwalSimrs);
            if(empty($jumlah_dipilih)){
                echo '<span class="text-danger">Anda setidaknya harus memilih jadwal yang ingin di set</span>';
            }else{
                //Melakukan perulangan
                $no=1;
                for($x=0;$x<$jumlah_dipilih;$x++){
                    $IdJadwalSimrsList=$IdJadwalSimrs[$x];
                    //Buka uraian jadwal dari simrs
                    $QryJadwal = mysqli_query($Conn,"SELECT * FROM jadwal_dokter WHERE id_jadwal='$IdJadwalSimrsList'")or die(mysqli_error($Conn));
                    $DataJadwal = mysqli_fetch_array($QryJadwal);
                    $IdPoliSimrs= $DataJadwal['id_poliklinik'];
                    $hari= $DataJadwal['hari'];
                    $jam= $DataJadwal['jam'];
                    $kuota_non_jkn= $DataJadwal['kuota_non_jkn'];
                    $kuota_jkn= $DataJadwal['kuota_jkn'];
                    $time_max= $DataJadwal['time_max'];
                    //Mencari Kode Poli SIMRS
                    $QryPoli = mysqli_query($Conn,"SELECT * FROM poliklinik WHERE id_poliklinik='$IdPoliSimrs'")or die(mysqli_error($Conn));
                    $DataPoli = mysqli_fetch_array($QryPoli);
                    $KodePoliSimrs= $DataPoli['kode'];
                    //Apakah Kode poliklinik tersebut ada pada data web
                    $UrlListPoli=urlService('List Poliklinik');
                    $keyword_by="kode";
                    $keyword=$KodePoliSimrs;
                    $short_by="ASC";
                    $order_by="kode";
                    $ListPoli=GetListInline($api_key,$UrlListPoli,$keyword_by,$keyword,$short_by,$order_by);
                    foreach($ListPoli as $value){
                        $id_poliklinik=$value['id_poliklinik'];
                    }
                    //Mulai proses kirim data
                    $KirimData = array(
                        'api_key' => $api_key,
                        'id_dokter' => $id_dokter,
                        'id_poliklinik' => $id_poliklinik,
                        'hari' => $hari,
                        'jam' => $jam,
                        'kuota_non_jkn' => $kuota_non_jkn,
                        'kuota_jkn' => $kuota_jkn,
                        'time_max' => $time_max
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
                        echo '<span class="text-danger">'.$no.'. '.$err.'</span><br>';
                    }else{
                        $JsonData =json_decode($content, true);
                        if(!empty($JsonData['metadata']['massage'])){
                            $massage=$JsonData['metadata']['massage'];
                        }else{
                            $massage="Pesan Error Tidak Diketahui '.$Url.'";
                        }
                        if(!empty($JsonData['metadata']['code'])){
                            $code=$JsonData['metadata']['code'];
                        }else{
                            $code="";
                        }
                        if($code==200){
                            echo '<span class="text-success">'.$no.' Berhasil Disimpan</span><br>';
                        }else{
                            echo '<span class="text-danger">'.$no.'. '.$massage.'</span><br>';
                        }
                    }
                    $no++;
                }
                if($no==$jumlah_dipilih){
                    echo '<b class="text-success">Semua Data Berhasil Disimpan, Silahkan <a href="">Refresh Halaman</a> </b>';
                }else{
                    echo '<b class="text-success">Silahkan <a href="">Refresh Halaman</a> untuk mengetahui perubahan data</b>';
                }
            }
        }
    }
?>