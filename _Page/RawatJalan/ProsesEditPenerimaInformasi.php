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
        if(empty($_POST['nama'])){
            echo '<span class="text-danger">Nama Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['hubungan'])){
                echo '<span class="text-danger">Hubungan Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['id'])){
                    echo '<span class="text-danger">ID Privasi Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['nik'])){
                        $nik="";
                    }else{
                        $nik=$_POST['nik'];
                    }
                    if(empty($_POST['alamat'])){
                        $alamat="";
                    }else{
                        $alamat=$_POST['alamat'];
                    }
                    if(empty($_POST['kontak'])){
                        $kontak="";
                    }else{
                        $kontak=$_POST['kontak'];
                    }
                    if(empty($_POST['keterangan'])){
                        $keterangan="";
                    }else{
                        $keterangan=$_POST['keterangan'];
                    }
                    //Membuat Variabel
                    $id=$_POST['id'];
                    $id_kunjungan=$_POST['id_kunjungan'];
                    $nama=$_POST['nama'];
                    $hubungan=$_POST['hubungan'];
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
                    $privasi=$JsonGeneralConsent['privasi'];
                    $pihak_lain = array();
                    foreach ($JsonGeneralConsent['pihak_lain'] as $row){
                        if($row['id']==$id){
                            $h['id'] = $id;
                            $h['nama'] = $nama;
                            $h['nik'] =$nik;
                            $h['kontak'] =$kontak;
                            $h['alamat'] =$alamat;
                            $h['hubungan'] =$hubungan;
                            $h['keterangan'] =$keterangan;
                        }else{
                            $h['id'] = $row["id"];
                            $h['nama'] = $row["nama"];
                            $h['nik'] = $row["nik"];
                            $h['kontak'] = $row["kontak"];
                            $h['alamat'] = $row["alamat"];
                            $h['hubungan'] = $row["hubungan"];
                            $h['keterangan'] = $row["keterangan"];
                        }
                        array_push($pihak_lain, $h);
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
                        "privasi" => $privasi,
                        "pihak_lain" => $pihak_lain
                    );
                    $GeneralConsentEncode= json_encode($GeneralConsent);
                    $UpdateGeneralConsent= mysqli_query($Conn,"UPDATE general_consent SET 
                        general_consent='$GeneralConsentEncode'
                    WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                    if($UpdateGeneralConsent){
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Penerima Informasi Berhasil","Kunjungan",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            echo '<span class="text-success" id="NotifikasiEditPenerimaInformasiBerhasil">Success</span>';
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