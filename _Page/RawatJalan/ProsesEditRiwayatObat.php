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
    if(empty($_POST['id_riwayat_penggunaan_obat'])){
        echo '<span class="text-danger">ID Riwayat Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['nama_obat'])){
            echo '<span class="text-danger">Nama Obat Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['bentuk_sediaan'])){
                echo '<span class="text-danger">Bentuk Sediaan Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['dosis'])){
                    echo '<span class="text-danger">Dosis Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['aturan_pakai'])){
                        echo '<span class="text-danger">Aturan Pakai Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['waktu_penggunaan'])){
                            echo '<span class="text-danger">Keterangan waktu penggunaan Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['tanggal'])){
                                echo '<span class="text-danger">Tanggal Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['jam'])){
                                    echo '<span class="text-danger">Jam Tidak Boleh Kosong!</span>';
                                }else{
                                    //Membuat Variabel
                                    $id_riwayat_penggunaan_obat=$_POST['id_riwayat_penggunaan_obat'];
                                    $nama_obat=$_POST['nama_obat'];
                                    $bentuk_sediaan=$_POST['bentuk_sediaan'];
                                    $dosis=$_POST['dosis'];
                                    $aturan_pakai=$_POST['aturan_pakai'];
                                    $waktu_penggunaan=$_POST['waktu_penggunaan'];
                                    $tanggal=$_POST['tanggal'];
                                    $jam=$_POST['jam'];
                                    //Data Tidak Wajib
                                    if(!empty($_POST['id_obat'])){
                                        $id_obat=$_POST['id_obat'];
                                    }else{
                                        $id_obat=0;
                                    }
                                    //Format Tanggal dan Jam
                                    $TanggalJam="$tanggal $jam";
                                    //Array Obat
                                    $obat_array = array(
                                        "nama_obat"=>"$nama_obat",
                                        "sediaan"=>"$bentuk_sediaan",
                                        "dosis"=>"$dosis",
                                        "aturan_pakai"=>"$aturan_pakai",
                                        "waktu_penggunaan"=>"$waktu_penggunaan"
                                    );
                                    $JsonObat = json_encode($obat_array);
                                    //Simpan Data Ke Database
                                    $UpdateRiwayat= mysqli_query($Conn,"UPDATE riwayat_penggunaan_obat SET 
                                        id_obat='$id_obat',
                                        nama_obat='$JsonObat',
                                        waktu_penggunaan='$TanggalJam'
                                    WHERE id_riwayat_penggunaan_obat='$id_riwayat_penggunaan_obat'") or die(mysqli_error($Conn));
                                    if($UpdateRiwayat){
                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Riwayat Penggunaan Obat","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                        if($MenyimpanLog=="Berhasil"){
                                            echo '<span class="text-success" id="NotifikasiEditRiwayatObatBerhasil">Success</span>';
                                        }else{
                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                        }
                                    }else{
                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Riwayat Penggunaan Obat</span>';
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