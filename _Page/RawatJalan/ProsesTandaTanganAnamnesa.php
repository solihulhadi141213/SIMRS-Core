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
        //Validasi kategori tidak boleh kosong
        if(empty($_POST['kategori'])){
            echo '<small class="text-danger">Kategori tidak boleh kosong</small>';
        }else{
            if(empty($_POST['TandaTangan'])){
                echo '<small class="text-danger">Tanda tangan tidak boleh kosong</small>';
            }else{
                //Variabel Lainnya
                $id_kunjungan=$_POST['id_kunjungan'];
                $kategori=$_POST['kategori'];
                $data_uri=$_POST['TandaTangan'];
                $encoded_image = explode(",", $data_uri)[1];
                $decoded_image = base64_decode($encoded_image);
                $nama_petugas=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'nama_petugas');
                $JsonNamaPetugas =json_decode($nama_petugas, true);
                //Buat Data Lama
                $petugas_entry=$JsonNamaPetugas['petugas_entry'];
                $dokter=$JsonNamaPetugas['dokter'];
                $perawat=$JsonNamaPetugas['perawat'];

                if($kategori=="Petugas Entry"){
                    $DataBaru=Array (
                        "nama" => $petugas_entry['nama'],
                        "tanda_tangan" => $encoded_image
                    );
                    $NamaPetugasNew=Array (
                        "petugas_entry" => $DataBaru,
                        "dokter" => $dokter,
                        "perawat" => $perawat,
                    );
                    $NamaPetugasNewEncode= json_encode($NamaPetugasNew);
                }else{
                    if($kategori=="Dokter"){
                        $DataBaru=Array (
                            "nama" => $dokter['nama'],
                            "tanda_tangan" => $encoded_image
                        );
                        $NamaPetugasNew=Array (
                            "petugas_entry" => $petugas_entry,
                            "dokter" => $DataBaru,
                            "perawat" => $perawat,
                        );
                        $NamaPetugasNewEncode= json_encode($NamaPetugasNew);
                    }else{
                        if($kategori=="Perawat"){
                            $DataBaru=Array (
                                "nama" => $perawat['nama'],
                                "tanda_tangan" => $encoded_image
                            );
                            $NamaPetugasNew=Array (
                                "petugas_entry" => $petugas_entry,
                                "dokter" => $dokter,
                                "perawat" => $DataBaru,
                            );
                            $NamaPetugasNewEncode= json_encode($NamaPetugasNew);
                        }else{
                            $NamaPetugasNew=Array (
                                "petugas_entry" => $petugas_entry,
                                "dokter" => $dokter,
                                "perawat" => $perawat,
                            );
                            $NamaPetugasNewEncode= json_encode($NamaPetugasNew);
                        }
                    }
                }
                $UpdateAnamnesa= mysqli_query($Conn,"UPDATE anamnesis SET 
                    nama_petugas='$NamaPetugasNewEncode'
                WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                if($UpdateAnamnesa){
                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Anamnesa","Kunjungan",$SessionIdAkses,$LogJsonFile);
                    if($MenyimpanLog=="Berhasil"){
                        echo '<span class="text-success" id="NotifikasiTandaTanganAnamnesaBerhasil">Success</span>';
                    }else{
                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                    }
                }else{
                    echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update anamnesa!</span><br>';
                }
            }
        }
    }
?>
