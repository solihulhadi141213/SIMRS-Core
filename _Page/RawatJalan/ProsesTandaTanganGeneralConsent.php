<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_kunjungan tidak boleh kosong
    if(empty($_POST['id_kunjungan'])){
        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
    }else{
        //Validasi KategoriTandaTangan tidak boleh kosong
        if(empty($_POST['KategoriTandaTangan'])){
            echo '<small class="text-danger">Kategori tidak boleh kosong</small>';
        }else{
            if(empty($_POST['signature'])){
                echo '<small class="text-danger">Tanda tangan tidak boleh kosong</small>';
            }else{
                //Variabel Lainnya
                $id_kunjungan=$_POST['id_kunjungan'];
                $KategoriTandaTangan=$_POST['KategoriTandaTangan'];
                $data_uri=$_POST['signature'];
                $encoded_image = explode(",", $data_uri)[1];
                $decoded_image = base64_decode($encoded_image);
                if($KategoriTandaTangan=="Petugas"){
                    $nama_petugas=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'nama_petugas');
                    if(empty($nama_petugas)){
                        echo '<small class="text-danger">Data Petugas Tidak Ditemukan</small>';
                    }else{
                        $JsonPetugas =json_decode($nama_petugas, true);
                        $NamaPetugas=$JsonPetugas['nama'];
                        $NikPetugas=$JsonPetugas['nik'];
                        $KontakPetugas=$JsonPetugas['kontak'];
                        $AlamatPetugas=$JsonPetugas['alamat'];
                        $NamaPetugasNew=Array (
                            "nama" => $NamaPetugas,
                            "nik" => $NikPetugas,
                            "kontak" => $KontakPetugas,
                            "alamat" => $AlamatPetugas,
                            "ttd" => $encoded_image,
                        );
                        $NamaPetugasNewEncode= json_encode($NamaPetugasNew);
                        $UpdateGeneralConsent= mysqli_query($Conn,"UPDATE general_consent SET 
                            nama_petugas='$NamaPetugasNewEncode'
                        WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                        if($UpdateGeneralConsent){
                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Nama Petugas General Consent","Kunjungan",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                echo '<span class="text-success" id="NotifikasiTandaTanganGeneralConsentBerhasil">Success</span>';
                                echo '<span class="text-success" id="NotifikasiUrlBack">index.php?Page=RawatJalan&Sub=DetailKunjungan&id='.$id_kunjungan.'</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                            }
                        }else{
                            echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update petugas general consent!</span><br>';
                        }
                    }
                }else{
                    if($KategoriTandaTangan=="Penanggung Jawab"){
                        $penanggung_jawab=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'penanggung_jawab');
                        if(empty($penanggung_jawab)){
                            echo '<small class="text-danger">Data Penanggung Jawab Tidak Ditemukan</small>';
                        }else{
                            $JsonPenanggungJawab =json_decode($penanggung_jawab, true);
                            $NamaPenanggungJawab=$JsonPenanggungJawab['nama'];
                            $NikPenanggungJawab=$JsonPenanggungJawab['nik'];
                            $KontakPenanggungJawab=$JsonPenanggungJawab['kontak'];
                            $AlamatPenanggungJawab=$JsonPenanggungJawab['alamat'];
                            $PenanggungJawabNew=Array (
                                "nama" => $NamaPenanggungJawab,
                                "nik" => $NikPenanggungJawab,
                                "kontak" => $KontakPenanggungJawab,
                                "alamat" => $AlamatPenanggungJawab,
                                "ttd" => $encoded_image,
                            );
                            $PenanggungJawabNewEncode= json_encode($PenanggungJawabNew);
                            $UpdateGeneralConsent= mysqli_query($Conn,"UPDATE general_consent SET 
                                penanggung_jawab='$PenanggungJawabNewEncode'
                            WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                            if($UpdateGeneralConsent){
                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Nama Petugas General Consent","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                if($MenyimpanLog=="Berhasil"){
                                    echo '<span class="text-success" id="NotifikasiTandaTanganGeneralConsentBerhasil">Success</span>';
                                    echo '<span class="text-success" id="NotifikasiUrlBack">index.php?Page=RawatJalan&Sub=DetailKunjungan&id='.$id_kunjungan.'</span>';
                                }else{
                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                }
                            }else{
                                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update petugas general consent!</span><br>';
                            }
                        }
                    }else{
                        echo '<small class="text-danger">Kategori Signature Tidak Valid</small>';
                    }
                }
            }
        }
    }
?>
