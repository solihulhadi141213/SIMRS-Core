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
    if(empty($_POST['id_persetujuan_tindakan'])){
        echo '<small class="text-danger">ID Persetujuan Tindakan tidak boleh kosong</small>';
    }else{
        //Validasi kategori tidak boleh kosong
        if(empty($_POST['kategori'])){
            echo '<small class="text-danger">Kategori tidak boleh kosong</small>';
        }else{
            if(empty($_POST['TandaTangan'])){
                echo '<small class="text-danger">Tanda tangan tidak boleh kosong</small>';
            }else{
                //Variabel Lainnya
                $id_persetujuan_tindakan=$_POST['id_persetujuan_tindakan'];
                $kategori=$_POST['kategori'];
                $data_uri=$_POST['TandaTangan'];
                $encoded_image = explode(",", $data_uri)[1];
                $decoded_image = base64_decode($encoded_image);
                if($kategori=="Dokter"){
                    //Buka Data Lama
                    $dokter=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'dokter');
                    $JsonDokter =json_decode($dokter, true);
                    //Buat Data Lama
                    $kategori_identitas_dokter=$JsonDokter['kategori_identitas_dokter'];
                    $nomor_identitas_dokter=$JsonDokter['nomor_identitas_dokter'];
                    $nama_dokter=$JsonDokter['nama_dokter'];
                    $pendaping_dokter=$JsonDokter['pendaping_dokter'];
                    $ttd=$encoded_image;
                    $DokterArry=Array (
                        "kategori_identitas_dokter" => $kategori_identitas_dokter,
                        "nomor_identitas_dokter" => $nomor_identitas_dokter,
                        "nama_dokter" => $nama_dokter,
                        "pendaping_dokter" => $pendaping_dokter,
                        "ttd" => $ttd
                    );
                    $DokterEncode= json_encode($DokterArry);
                    $Update= mysqli_query($Conn,"UPDATE persetujuan_tindakan SET 
                        dokter='$DokterEncode'
                    WHERE id_persetujuan_tindakan='$id_persetujuan_tindakan'") or die(mysqli_error($Conn));
                    if($Update){
                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Persetujuan Tindakan","Kunjungan",$SessionIdAkses,$LogJsonFile);
                        if($MenyimpanLog=="Berhasil"){
                            echo '<span class="text-success" id="NotifikasiTandaTanganPersetujuanTindakanBerhasil">Success</span>';
                        }else{
                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                        }
                    }else{
                        echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update!</span><br>';
                    }
                }else{
                    if($kategori=="Pernyataan"){
                        //Buka Data Lama
                        $Pernyataan=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'pemberi_pernyataan');
                        $JsonPernyataan=json_decode($Pernyataan, true);
                        //Buat Data Lama
                        $pemberi_pernyataan=$JsonPernyataan['pemberi_pernyataan'];
                        $nama_pemberi_pernyataan=$JsonPernyataan['nama_pemberi_pernyataan'];
                        $identitas_pemberi_pernyataan=$JsonPernyataan['identitas_pemberi_pernyataan'];
                        $nomor_identitas_pemberi_pernyataan=$JsonPernyataan['nomor_identitas_pemberi_pernyataan'];
                        $ttd=$encoded_image;
                        $PemberiPernyataanArry=Array (
                            "pemberi_pernyataan" => $pemberi_pernyataan,
                            "nama_pemberi_pernyataan" => $nama_pemberi_pernyataan,
                            "identitas_pemberi_pernyataan" => $identitas_pemberi_pernyataan,
                            "nomor_identitas_pemberi_pernyataan" => $nomor_identitas_pemberi_pernyataan,
                            "ttd" => $ttd
                        );
                        $PemberiPernyataanEncode= json_encode($PemberiPernyataanArry);
                        $Update= mysqli_query($Conn,"UPDATE persetujuan_tindakan SET 
                            pemberi_pernyataan='$PemberiPernyataanEncode'
                        WHERE id_persetujuan_tindakan='$id_persetujuan_tindakan'") or die(mysqli_error($Conn));
                        if($Update){
                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Persetujuan Tindakan","Kunjungan",$SessionIdAkses,$LogJsonFile);
                            if($MenyimpanLog=="Berhasil"){
                                echo '<span class="text-success" id="NotifikasiTandaTanganPersetujuanTindakanBerhasil">Success</span>';
                            }else{
                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                            }
                        }else{
                            echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update!</span><br>';
                        }
                    }else{
                        if($kategori=="Saksi1"){
                            //Buka Data Lama
                            $Saksi=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'saksi');
                            $JsonSaksi=json_decode($Saksi, true);
                            //Buat Data Lama
                            //Saksi1
                            $identitas_saksi1=$JsonSaksi['saksi1']['identitas_saksi1'];
                            $nomor_identitas_saksi1=$JsonSaksi['saksi1']['nomor_identitas_saksi1'];
                            $nama_saksi1=$JsonSaksi['saksi1']['nama_saksi1'];
                            $ttd_saksi1=$JsonSaksi['saksi1']['ttd'];
                            //Saksi 2
                            $identitas_saksi2=$JsonSaksi['saksi2']['identitas_saksi2'];
                            $nomor_identitas_saksi2=$JsonSaksi['saksi2']['nomor_identitas_saksi2'];
                            $nama_saksi2=$JsonSaksi['saksi2']['nama_saksi2'];
                            $ttd_saksi2=$JsonSaksi['saksi2']['ttd'];
                            //Buat Array
                            $Saksi1Arry=Array (
                                "identitas_saksi1" => $identitas_saksi1,
                                "nomor_identitas_saksi1" => $nomor_identitas_saksi1,
                                "nama_saksi1" => $nama_saksi1,
                                "ttd" => $encoded_image
                            );
                            $Saksi2Arry=Array (
                                "identitas_saksi2" => $identitas_saksi2,
                                "nomor_identitas_saksi2" => $nomor_identitas_saksi2,
                                "nama_saksi2" => $nama_saksi2,
                                "ttd" => $ttd_saksi2
                            );
                            $SaksiArry=Array (
                                "saksi1" => $Saksi1Arry,
                                "saksi2" => $Saksi2Arry
                            );
                            $SaksiEncode= json_encode($SaksiArry);
                            $Update= mysqli_query($Conn,"UPDATE persetujuan_tindakan SET 
                                saksi='$SaksiEncode'
                            WHERE id_persetujuan_tindakan='$id_persetujuan_tindakan'") or die(mysqli_error($Conn));
                            if($Update){
                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Persetujuan Tindakan","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                if($MenyimpanLog=="Berhasil"){
                                    echo '<span class="text-success" id="NotifikasiTandaTanganPersetujuanTindakanBerhasil">Success</span>';
                                }else{
                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                }
                            }else{
                                echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update!</span><br>';
                            }
                        }else{
                            if($kategori=="Saksi2"){
                                //Buka Data Lama
                                $Saksi=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'saksi');
                                $JsonSaksi=json_decode($Saksi, true);
                                //Buat Data Lama
                                //Saksi1
                                $identitas_saksi1=$JsonSaksi['saksi1']['identitas_saksi1'];
                                $nomor_identitas_saksi1=$JsonSaksi['saksi1']['nomor_identitas_saksi1'];
                                $nama_saksi1=$JsonSaksi['saksi1']['nama_saksi1'];
                                $ttd_saksi1=$JsonSaksi['saksi1']['ttd'];
                                //Saksi 2
                                $identitas_saksi2=$JsonSaksi['saksi2']['identitas_saksi2'];
                                $nomor_identitas_saksi2=$JsonSaksi['saksi2']['nomor_identitas_saksi2'];
                                $nama_saksi2=$JsonSaksi['saksi2']['nama_saksi2'];
                                $ttd_saksi2=$JsonSaksi['saksi2']['ttd'];
                                //Buat Array
                                $Saksi1Arry=Array (
                                    "identitas_saksi1" => $identitas_saksi1,
                                    "nomor_identitas_saksi1" => $nomor_identitas_saksi1,
                                    "nama_saksi1" => $nama_saksi1,
                                    "ttd" => $ttd_saksi1
                                );
                                $Saksi2Arry=Array (
                                    "identitas_saksi2" => $identitas_saksi2,
                                    "nomor_identitas_saksi2" => $nomor_identitas_saksi2,
                                    "nama_saksi2" => $nama_saksi2,
                                    "ttd" => $encoded_image
                                );
                                $SaksiArry=Array (
                                    "saksi1" => $Saksi1Arry,
                                    "saksi2" => $Saksi2Arry
                                );
                                $SaksiEncode= json_encode($SaksiArry);
                                $Update= mysqli_query($Conn,"UPDATE persetujuan_tindakan SET 
                                    saksi='$SaksiEncode'
                                WHERE id_persetujuan_tindakan='$id_persetujuan_tindakan'") or die(mysqli_error($Conn));
                                if($Update){
                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Persetujuan Tindakan","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                    if($MenyimpanLog=="Berhasil"){
                                        echo '<span class="text-success" id="NotifikasiTandaTanganPersetujuanTindakanBerhasil">Success</span>';
                                    }else{
                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                    }
                                }else{
                                    echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update!</span><br>';
                                }
                            }else{
                                echo '<span class="text-danger">Kategori Tanda Tangan Tidak Valid!</span><br>';
                            }
                        }
                    }
                }
            }
        }
    }
?>
