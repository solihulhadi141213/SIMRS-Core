<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    $LogJsonFile="../../_Page/Log/Log.json";
    $now=date('Y-m-d H:i');
    if(empty($_POST['id_laboratorium_sample'])){
        echo '<span class="text-danger">ID Spesimen Tidak Boleh Kosong</span>';
    }else{
        if(empty($_POST['id_laboratorium_parameter'])){
            echo '<span class="text-danger">ID Parameter Tidak Boleh Kosong</span>';
        }else{
            if(empty($_POST['id_lab'])){
                echo '<span class="text-danger">ID Lab Tidak Boleh Kosong</span>';
            }else{
                if(empty($_POST['id_permintaan'])){
                    echo '<span class="text-danger">ID Permintaan Tidak Boleh Kosong</span>';
                }else{
                    if(empty($_POST['id_pasien'])){
                        echo '<span class="text-danger">ID Pasien Tidak Boleh Kosong</span>';
                    }else{
                        if(empty($_POST['id_kunjungan'])){
                            echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong</span>';
                        }else{
                            if(empty($_POST['hasil'])){
                                echo '<span class="text-danger">Hasil Pemeriksaan Tidak Boleh Kosong</span>';
                            }else{
                                if(empty($_POST['parameter'])){
                                    echo '<span class="text-danger">Parameter Pemeriksaan Tidak Boleh Kosong</span>';
                                }else{
                                    if(empty($_POST['kategori_parameter'])){
                                        echo '<span class="text-danger">Kategori Parameter Pemeriksaan Tidak Boleh Kosong</span>';
                                    }else{
                                        if(empty($_POST['id_rincian_lab'])){
                                            $id_rincian_lab="";
                                        }else{
                                            $id_rincian_lab=$_POST['id_rincian_lab'];
                                        }
                                        $id_laboratorium_sample=$_POST['id_laboratorium_sample'];
                                        $id_laboratorium_parameter=$_POST['id_laboratorium_parameter'];
                                        $id_lab=$_POST['id_lab'];
                                        $id_permintaan=$_POST['id_permintaan'];
                                        $id_pasien=$_POST['id_pasien'];
                                        $id_kunjungan=$_POST['id_kunjungan'];
                                        $parameter=$_POST['parameter'];
                                        $kategori_parameter=$_POST['kategori_parameter'];
                                        $hasil=$_POST['hasil'];
                                        if(empty($_POST['interpertasi'])){
                                            $interpertasi="";
                                        }else{
                                            $interpertasi=$_POST['interpertasi'];
                                        }
                                        if(empty($_POST['keterangan'])){
                                            $keterangan="";
                                        }else{
                                            $keterangan=$_POST['keterangan'];
                                        }
                                        //simpan  data
                                        $ValidasiDuplikatData=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM laboratorium_rincian WHERE id_permintaan='$id_permintaan' AND id_lab='$id_lab' AND id_laboratorium_sample='$id_laboratorium_sample' AND parameter='$parameter' AND kategori_parameter='$kategori_parameter'"));
                                        if(!empty($id_rincian_lab)){
                                            //Update Data Hasil Pemeriksaan
                                            $UpdateHasilPemeriksaan= mysqli_query($Conn,"UPDATE laboratorium_rincian SET 
                                                hasil='$hasil',
                                                interpertasi='$interpertasi',
                                                keterangan='$keterangan'
                                            WHERE id_rincian_lab='$id_rincian_lab'") or die(mysqli_error($Conn));
                                            if($UpdateHasilPemeriksaan){
                                                //menyimpan Log
                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Hasil Pemeriksaan","Laboratorium",$SessionIdAkses,$LogJsonFile);
                                                if($MenyimpanLog=="Berhasil"){
                                                    $_SESSION['NotifikasiSwal']="Update Hasil Pemeriksaan Berhasil";
                                                    echo '<span class="text-success" id="NotifikasiTambahHasilPemeriksaanBerhasil">Success</span>';
                                                }else{
                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                }
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
                                            }
                                        }else{
                                            //Insert Data Hasil Pemeriksaan
                                            $entry="INSERT INTO laboratorium_rincian (
                                                id_permintaan,
                                                id_lab,
                                                id_laboratorium_sample,
                                                id_pasien,
                                                id_kunjungan,
                                                parameter,
                                                kategori_parameter,
                                                hasil,
                                                interpertasi,
                                                keterangan
                                            )VALUES (
                                                '$id_permintaan',
                                                '$id_lab',
                                                '$id_laboratorium_sample',
                                                '$id_pasien',
                                                '$id_kunjungan',
                                                '$parameter',
                                                '$kategori_parameter',
                                                '$hasil',
                                                '$interpertasi',
                                                '$keterangan'
                                            )";
                                            $hasil=mysqli_query($Conn, $entry);
                                            if($hasil){
                                                //menyimpan Log
                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Hasil Pemeriksaan","Laboratorium",$SessionIdAkses,$LogJsonFile);
                                                if($MenyimpanLog=="Berhasil"){
                                                    $_SESSION['NotifikasiSwal']="Tambah Hasil Pemeriksaan Berhasil";
                                                    echo '<span class="text-success" id="NotifikasiTambahHasilPemeriksaanBerhasil">Success</span>';
                                                }else{
                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                }
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Data!</span>';
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