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
    if(empty($_POST['PutIdKunjungan'])){
        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
    }else{
        //Validasi NamaData tidak boleh kosong
        if(empty($_POST['NamaData'])){
            echo '<small class="text-danger">Nama Data tidak boleh kosong</small>';
        }else{
            if(empty($_POST['RichText'])){
                $RichText="";
            }else{
                $RichText=$_POST['RichText'];
                $RichText=addslashes($RichText);
                $RichText = str_replace(array("\r","\n"),"",$RichText);
            }
            //Membuat variabel wajib
            $id_kunjungan=$_POST['PutIdKunjungan'];
            $NamaData=$_POST['NamaData'];
            //Proses Berdasarkan nama data
            if($NamaData=="keluhan_utama"){
                $UpdateKeluhanUtama= mysqli_query($Conn,"UPDATE anamnesis SET 
                    keluhan_utama='$RichText'
                WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                if($UpdateKeluhanUtama){
                    $ValidasiProses="Berhasil";
                }else{
                    $ValidasiProses="Terjadi kesalahan pada saat menyimpan data keluhan utama";
                }
            }else{
                if($NamaData=="riwayat_pengobatan"){
                    $UpdateKeluhanUtama= mysqli_query($Conn,"UPDATE anamnesis SET 
                        riwayat_pengobatan='$RichText'
                    WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                    if($UpdateKeluhanUtama){
                        $ValidasiProses="Berhasil";
                    }else{
                        $ValidasiProses="Terjadi kesalahan pada saat menyimpan data riwayat pengobatan";
                    }
                }else{
                    if($NamaData=="habitus_kebiasaan"){
                        $UpdateKeluhanUtama= mysqli_query($Conn,"UPDATE anamnesis SET 
                            habitus_kebiasaan='$RichText'
                        WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                        if($UpdateKeluhanUtama){
                            $ValidasiProses="Berhasil";
                        }else{
                            $ValidasiProses="Terjadi kesalahan pada saat menyimpan data habitus kebiasaan";
                        }
                    }else{
                        if($NamaData=="riwayat_penyakit_sekarang"){
                            //Membuka Riwayat Penyakit
                            $riwayat_penyakit=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_penyakit');
                            $JsonRiwayatPenyakit =json_decode($riwayat_penyakit, true);
                            $RiwayatPenyakitSekarang=$JsonRiwayatPenyakit['sekarang'];
                            $RiwayatPenyakitDahulu=$JsonRiwayatPenyakit['dahulu'];
                            $riwayat_penyakit=Array (
                                "sekarang" => "$RichText",
                                "dahulu" => "$RiwayatPenyakitDahulu"
                            );
                            $JsonRiwayatPenyakit= json_encode($riwayat_penyakit);
                            $UpdateRiwayatPenyakit= mysqli_query($Conn,"UPDATE anamnesis SET 
                                riwayat_penyakit='$JsonRiwayatPenyakit'
                            WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                            if($UpdateRiwayatPenyakit){
                                $ValidasiProses="Berhasil";
                            }else{
                                $ValidasiProses="Terjadi kesalahan pada saat menyimpan data Riwayat Penyakit Sekarang";
                            }
                        }else{
                            if($NamaData=="riwayat_penyakit_dahulu"){
                                //Membuka Riwayat Penyakit
                                $riwayat_penyakit=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'riwayat_penyakit');
                                $JsonRiwayatPenyakit =json_decode($riwayat_penyakit, true);
                                $RiwayatPenyakitSekarang=$JsonRiwayatPenyakit['sekarang'];
                                $RiwayatPenyakitDahulu=$JsonRiwayatPenyakit['dahulu'];
                                $riwayat_penyakit=Array (
                                    "sekarang" => "$RiwayatPenyakitSekarang",
                                    "dahulu" => "$RichText"
                                );
                                $JsonRiwayatPenyakit= json_encode($riwayat_penyakit);
                                $UpdateRiwayatPenyakit= mysqli_query($Conn,"UPDATE anamnesis SET 
                                    riwayat_penyakit='$JsonRiwayatPenyakit'
                                WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                                if($UpdateRiwayatPenyakit){
                                    $ValidasiProses="Berhasil";
                                }else{
                                    $ValidasiProses="Terjadi kesalahan pada saat menyimpan data Riwayat Penyakit Dahulu";
                                }
                            }else{
                                
                            }
                        }
                    }
                }
            }
            //Kondisi Apabila Proses Berhasil
            if($ValidasiProses=="Berhasil"){
                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Ubah Anamnesis ","Kunjungan",$SessionIdAkses,$LogJsonFile);
                echo '<span class="text-success" id="NotifikasiSimpanRichTextBerhasil">Success</span>';
            }else{
                echo '<span class="text-danger">'. $ValidasiProses.'</span>';
            }
        }
    }
?>
