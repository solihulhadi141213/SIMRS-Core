<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $now=date('Y-m-d H:i:s');
    if(empty($_POST['id_kunjungan'])){
        echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['id_pasien'])){
            echo '<span class="text-danger">ID Pasien Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['nama_pasien'])){
                echo '<span class="text-danger">Nama Pasien Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['tanggal'])){
                    echo '<span class="text-danger">Tanggal Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['jam'])){
                        echo '<span class="text-danger">Jam Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['nama_penanggung_jawab'])){
                            echo '<span class="text-danger">Nama Penanggung Jawab Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['nik_penanggung_jawab'])){
                                echo '<span class="text-danger">NIK Penanggung Jawab Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['alamat'])){
                                    echo '<span class="text-danger"> Alamat Penanggung Jawab Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['nama_petugas'])){
                                        echo '<span class="text-danger"> Nama Petugas Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['nik_petugas'])){
                                            echo '<span class="text-danger"> NIK Petugas Tidak Boleh Kosong!</span>';
                                        }else{
                                            if(empty($_POST['alamat_petugas'])){
                                                echo '<span class="text-danger"> Alamat Petugas Tidak Boleh Kosong!</span>';
                                            }else{
                                                if(empty($_POST['PernyataanPasien'])){
                                                    echo '<span class="text-danger"> Pernyataan 1 Tidak Boleh Kosong!</span>';
                                                }else{
                                                    if(empty($_POST['InformasiPembayaran'])){
                                                        echo '<span class="text-danger"> Pernyataan 2 Tidak Boleh Kosong!</span>';
                                                    }else{
                                                        if(empty($_POST['InformasiHakDanKewajiban'])){
                                                            echo '<span class="text-danger"> Pernyataan 3 Tidak Boleh Kosong!</span>';
                                                        }else{
                                                            if(empty($_POST['InformasiTataTertib'])){
                                                                echo '<span class="text-danger"> Pernyataan 4 Tidak Boleh Kosong!</span>';
                                                            }else{
                                                                if(empty($_POST['KebutuhanPenterjemah'])){
                                                                    echo '<span class="text-danger"> Pernyataan 5 Tidak Boleh Kosong!</span>';
                                                                }else{
                                                                    if(empty($_POST['KebutuhanRohaniawan'])){
                                                                        echo '<span class="text-danger"> Pernyataan 6 Tidak Boleh Kosong!</span>';
                                                                    }else{
                                                                        if(empty($_POST['PelepasanInformasi'])){
                                                                            echo '<span class="text-danger"> Pernyataan 7 Tidak Boleh Kosong!</span>';
                                                                        }else{
                                                                            if(empty($_POST['HasilPemeriksaanPenunjang'])){
                                                                                echo '<span class="text-danger"> Pernyataan 8 Tidak Boleh Kosong!</span>';
                                                                            }else{
                                                                                if(empty($_POST['HasilPemeriksaanPenunjang2'])){
                                                                                    echo '<span class="text-danger"> Pernyataan 9 Tidak Boleh Kosong!</span>';
                                                                                }else{
                                                                                    if(empty($_POST['FasyankesRujukan'])){
                                                                                        echo '<span class="text-danger"> Pernyataan 10 Tidak Boleh Kosong!</span>';
                                                                                    }else{
                                                                                        //Buat Variabel
                                                                                        $id_kunjungan=$_POST['id_kunjungan'];
                                                                                        //Cek Duplikat
                                                                                        $id_general_consent=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'id_general_consent');
                                                                                        if(empty($id_general_consent)){
                                                                                            echo '<span class="text-danger"> Data Tidak Ditemukan</span>';
                                                                                        }else{
                                                                                            $id_pasien=$_POST['id_pasien'];
                                                                                            $nama_pasien=$_POST['nama_pasien'];
                                                                                            $tanggal=$_POST['tanggal'];
                                                                                            $jam=$_POST['jam'];
                                                                                            $nama_penanggung_jawab=$_POST['nama_penanggung_jawab'];
                                                                                            $nik_penanggung_jawab=$_POST['nik_penanggung_jawab'];
                                                                                            $alamat=$_POST['alamat'];
                                                                                            $nama_petugas=$_POST['nama_petugas'];
                                                                                            $nik_petugas=$_POST['nik_petugas'];
                                                                                            $alamat_petugas=$_POST['alamat_petugas'];
                                                                                            $Pernyataan1=$_POST['PernyataanPasien'];
                                                                                            $Pernyataan2=$_POST['InformasiPembayaran'];
                                                                                            $Pernyataan3=$_POST['InformasiHakDanKewajiban'];
                                                                                            $Pernyataan4=$_POST['InformasiTataTertib'];
                                                                                            $Pernyataan5=$_POST['KebutuhanPenterjemah'];
                                                                                            $Pernyataan6=$_POST['KebutuhanRohaniawan'];
                                                                                            $Pernyataan7=$_POST['PelepasanInformasi'];
                                                                                            $Pernyataan8=$_POST['HasilPemeriksaanPenunjang'];
                                                                                            $Pernyataan9=$_POST['HasilPemeriksaanPenunjang2'];
                                                                                            $Pernyataan10=$_POST['FasyankesRujukan'];
                                                                                            //Form tidak wajib
                                                                                            if(empty($_POST['nomor_kontak'])){
                                                                                                $kontak_penanggung_jawab="";
                                                                                            }else{
                                                                                                $kontak_penanggung_jawab=$_POST['nomor_kontak'];
                                                                                            }
                                                                                            if(empty($_POST['nomor_kontak_petugas'])){
                                                                                                $nomor_kontak_petugas="";
                                                                                            }else{
                                                                                                $nomor_kontak_petugas=$_POST['nomor_kontak_petugas'];
                                                                                            }
                                                                                            //Format Tanggal
                                                                                            $tanggal="$tanggal $jam";
                                                                                            //Membuka Data Lama
                                                                                            $nama_petugasJson=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'nama_petugas');
                                                                                            $penanggung_jawab=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'penanggung_jawab');
                                                                                            $general_consent=getDataDetail($Conn,"general_consent",'id_kunjungan',$id_kunjungan,'general_consent');
                                                                                            //Decode JSON
                                                                                            $JsonPetugas =json_decode($nama_petugasJson, true);
                                                                                            $JsonPenanggungJawab =json_decode($penanggung_jawab, true);
                                                                                            $JsonGeneralConsent =json_decode($general_consent, true);
                                                                                            //TTD Petugas
                                                                                            $TtdPetugas=$JsonPetugas['ttd'];
                                                                                            $TtdPenanggungJawab=$JsonPenanggungJawab['ttd'];
                                                                                            $privasi=$JsonGeneralConsent['privasi'];
                                                                                            $pihak_lain=$JsonGeneralConsent['pihak_lain'];
                                                                                            //Membuat JSON
                                                                                            $PenanggungJawab=Array (
                                                                                                "nama" => "$nama_penanggung_jawab",
                                                                                                "nik" => "$nik_penanggung_jawab",
                                                                                                "kontak" => "$kontak_penanggung_jawab",
                                                                                                "alamat" => "$alamat",
                                                                                                "ttd" => "$TtdPenanggungJawab",
                                                                                            );
                                                                                            $JsonEncodePenanggungJawab = json_encode($PenanggungJawab);
                                                                                            $Petugas=Array (
                                                                                                "nama" => "$nama_petugas",
                                                                                                "nik" => "$nik_petugas",
                                                                                                "kontak" => "$nomor_kontak_petugas",
                                                                                                "alamat" => "$alamat_petugas",
                                                                                                "ttd" => "$TtdPetugas"
                                                                                            );
                                                                                            $JsonEncodePetugas = json_encode($Petugas);
                                                                                            $GeneralConsent=Array (
                                                                                                "pernyataan_1" => "$Pernyataan1",
                                                                                                "pernyataan_2" => "$Pernyataan2",
                                                                                                "pernyataan_3" => "$Pernyataan3",
                                                                                                "pernyataan_4" => "$Pernyataan4",
                                                                                                "pernyataan_5" => "$Pernyataan5",
                                                                                                "pernyataan_6" => "$Pernyataan6",
                                                                                                "pernyataan_7" => "$Pernyataan7",
                                                                                                "pernyataan_8" => "$Pernyataan8",
                                                                                                "pernyataan_9" => "$Pernyataan9",
                                                                                                "pernyataan_10" => "$Pernyataan10",
                                                                                                "privasi" => $privasi,
                                                                                                "pihak_lain" => $pihak_lain
                                                                                            );
                                                                                            $JsonEncodeGeneralConsent= json_encode($GeneralConsent);
                                                                                            //Simpan Data
                                                                                            $UpdateGeneralConsent= mysqli_query($Conn,"UPDATE general_consent SET 
                                                                                                nama_petugas='$JsonEncodePetugas',
                                                                                                penanggung_jawab='$JsonEncodePenanggungJawab',
                                                                                                tanggal='$tanggal',
                                                                                                general_consent='$JsonEncodeGeneralConsent'
                                                                                            WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                                                                                            if($UpdateGeneralConsent){
                                                                                                $LogJsonFile="../../_Page/Log/Log.json";
                                                                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update General Consent","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                                                if($MenyimpanLog=="Berhasil"){
                                                                                                    echo '<span class="text-success" id="NotifikasiEditGeneralConsentBerhasil">Success</span>';
                                                                                                }else{
                                                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                                }
                                                                                            }else{
                                                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data General Consent</span>';
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