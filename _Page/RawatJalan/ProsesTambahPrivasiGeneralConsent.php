<?php
    //Pengaturan waktu
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi dan akses
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
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
                if(empty($_POST['nik_pengunjung'])){
                    $nik="";
                }else{
                    $nik=$_POST['nik_pengunjung'];
                }
                if(empty($_POST['alamat_pengunjung'])){
                    $alamat_pengunjung="";
                }else{
                    $alamat_pengunjung=$_POST['alamat_pengunjung'];
                }
                if(empty($_POST['kontak_pengunjung'])){
                    $kontak_pengunjung="";
                }else{
                    $kontak_pengunjung=$_POST['kontak_pengunjung'];
                }
                if(empty($_POST['keterangan_pengunjung'])){
                    $keterangan_pengunjung="";
                }else{
                    $keterangan_pengunjung=$_POST['keterangan_pengunjung'];
                }
                //Membuat Variabel
                $id_kunjungan=$_POST['id_kunjungan'];
                $nama_pengunjung=$_POST['nama_pengunjung'];
                $status_pengunjung=$_POST['status_pengunjung'];
                //Membuat Kode Unik
                $milisecond=date('Y-m-d H:i:s');
                $strtotime=strtotime($milisecond);
                $id_privasi="Prv-$id_kunjungan-$strtotime";
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
                if(!empty($JsonGeneralConsent['privasi'])){
                    $PrivasiList=$JsonGeneralConsent['privasi'];
                    $JumlahPrivasi=count($PrivasiList);
                    $Privasi = array();
                    foreach ($JsonGeneralConsent['privasi'] as $row){
                        $h['id_privasi'] = $row["id_privasi"];
                        $h['nama'] = $row["nama"];
                        $h['nik'] = $row["nik"];
                        $h['kontak'] = $row["kontak"];
                        $h['alamat'] = $row["alamat"];
                        $h['status'] = $row["status"];
                        $h['keterangan'] = $row["keterangan"];
                        array_push($Privasi, $h);
                    }
                    $PrivasiNew=Array (
                        "id_privasi" => $id_privasi,
                        "nama" => $nama_pengunjung,
                        "nik" => $nik,
                        "kontak" => $kontak_pengunjung,
                        "alamat" => $alamat_pengunjung,
                        "status" => $status_pengunjung,
                        "keterangan" => $keterangan_pengunjung,
                    );
                    array_push($Privasi, $PrivasiNew);
                }else{
                    $Privasi=Array (
                        "0" => Array (
                            "id_privasi" => $id_privasi,
                            "nama" => $nama_pengunjung,
                            "nik" => $nik,
                            "kontak" => $kontak_pengunjung,
                            "alamat" => $alamat_pengunjung,
                            "status" => $status_pengunjung,
                            "keterangan" => $keterangan_pengunjung,
                        )
                    );
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
                    $LogJsonFile="../../_Page/Log/Log.json";
                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah General Consent","Kunjungan",$SessionIdAkses,$LogJsonFile);
                    if($MenyimpanLog=="Berhasil"){
                        echo '<span class="text-success" id="NotifikasiTambahPrivasiGeneralConsentBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                    }
                }else{
                    echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update general consent!</span><br>';
                }
            }
        }
    }
?>