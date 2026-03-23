<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    $updatetime=date('Y-m-d H:i');
    //Validasi kelengkapan data
    if(empty($_POST['id_kunjungan'])){
        echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nama_pengunjung'])){
            echo '<span class="text-danger">Nama Pengunjung Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['status_pengunjung'])){
                echo '<span class="text-danger">Status Pengunjung Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['id_privasi'])){
                    echo '<span class="text-danger">ID Privasi Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['nik_pengunjung'])){
                        $nikBaru="";
                    }else{
                        $nikBaru=$_POST['nik_pengunjung'];
                    }
                    if(empty($_POST['alamat_pengunjung'])){
                        $alamat_pengunjungBaru="";
                    }else{
                        $alamat_pengunjungBaru=$_POST['alamat_pengunjung'];
                    }
                    if(empty($_POST['kontak_pengunjung'])){
                        $kontak_pengunjungBaru="";
                    }else{
                        $kontak_pengunjungBaru=$_POST['kontak_pengunjung'];
                    }
                    if(empty($_POST['keterangan_pengunjung'])){
                        $keterangan_pengunjungBaru="";
                    }else{
                        $keterangan_pengunjungBaru=$_POST['keterangan_pengunjung'];
                    }
                    //Membuat Variabel
                    $id_privasi=$_POST['id_privasi'];
                    $id_kunjungan=$_POST['id_kunjungan'];
                    $nama_pengunjungBaru=$_POST['nama_pengunjung'];
                    $status_pengunjungBaru=$_POST['status_pengunjung'];
                    //Buka Data Lama
                    $general_consent=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'general_consent');
                    $JsonGeneralConsent =json_decode($general_consent, true);
                    $pernyataan_1=$JsonGeneralConsent['pernyataan_1'];
                    $pernyataan_2=$JsonGeneralConsent['pernyataan_2'];
                    $pernyataan_3=$JsonGeneralConsent['pernyataan_3'];
                    $pernyataan_4=$JsonGeneralConsent['pernyataan_4'];
                    $pernyataan_5=$JsonGeneralConsent['pernyataan_5'];
                    $pernyataan_6=$JsonGeneralConsent['pernyataan_6'];
                    $pernyataan_7=$JsonGeneralConsent['pernyataan_7'];
                    $pernyataan_8=$JsonGeneralConsent['pernyataan_8'];
                    $pernyataan_9=$JsonGeneralConsent['pernyataan_9'];
                    $pernyataan_10=$JsonGeneralConsent['pernyataan_10'];
                    $pihak_lain=$JsonGeneralConsent['pihak_lain'];
                    $PrivasiList=$JsonGeneralConsent['privasi'];
                    $JumlahPrivasi=count($PrivasiList);
                    $Privasi = array();
                    $no_list=1;
                    foreach ($JsonGeneralConsent['privasi'] as $row){
                        if($row['id_privasi']==$id_privasi){
                            $h['id_privasi'] = $id_privasi;
                            $h['nama'] = $nama_pengunjungBaru;
                            $h['nik'] =$nikBaru;
                            $h['kontak'] =$kontak_pengunjungBaru;
                            $h['alamat'] =$alamat_pengunjungBaru;
                            $h['status'] =$status_pengunjungBaru;
                            $h['keterangan'] =$keterangan_pengunjungBaru;
                        }else{
                            $h['id_privasi'] = $row["id_privasi"];
                            $h['nama'] = $row["nama"];
                            $h['nik'] = $row["nik"];
                            $h['kontak'] = $row["kontak"];
                            $h['alamat'] = $row["alamat"];
                            $h['status'] = $row["status"];
                            $h['keterangan'] = $row["keterangan"];
                        }
                        array_push($Privasi, $h);
                        $no_list++;
                    }
                    $GeneralConsent=Array (
                        "pernyataan_1" => "$pernyataan_1",
                        "pernyataan_2" => "$pernyataan_2",
                        "pernyataan_3" => "$pernyataan_3",
                        "pernyataan_4" => "$pernyataan_4",
                        "pernyataan_5" => "$pernyataan_5",
                        "pernyataan_6" => "$pernyataan_6",
                        "pernyataan_7" => "$pernyataan_7",
                        "pernyataan_8" => "$pernyataan_8",
                        "pernyataan_9" => "$pernyataan_9",
                        "pernyataan_10" => "$pernyataan_10",
                        "privasi" => $Privasi,
                        "pihak_lain" => $pihak_lain
                    );
                    $GeneralConsentEncode= json_encode($GeneralConsent);
                    $UpdateGeneralConsent= mysqli_query($Conn,"UPDATE general_consent SET 
                        general_consent='$GeneralConsentEncode'
                    WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                    if($UpdateGeneralConsent){
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit General Consent","Kunjungan",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            echo '<span class="text-success" id="NotifikasiEditPrivasiGeneralConsentBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update general consent!</span><br>';
                    }
                }
            }
        }
    }
?>