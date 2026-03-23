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
    if(empty($_POST['id_resep'])){
        echo '<span class="text-danger">ID Resep Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['id'])){
            echo '<span class="text-danger">ID Data Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['nama_obat'])){
                echo '<span class="text-danger">Nama Obat Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['bentuk_sediaan'])){
                    echo '<span class="text-danger">Bentuk Sediaan Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['jumlah_obat'])){
                        echo '<span class="text-danger">Jumlah Obat Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['metode'])){
                            echo '<span class="text-danger">Metode Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['dosis'])){
                                echo '<span class="text-danger">Dosis Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['unit'])){
                                    echo '<span class="text-danger">Unit/Satuan Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['frekuensi'])){
                                        echo '<span class="text-danger">Frekuanesi Tidak Boleh Kosong!</span>';
                                    }else{
                                        //Variabel Tidak wajib
                                        if(empty($_POST['aturan_tambahan'])){
                                            $aturan_tambahan="";
                                        }else{
                                            $aturan_tambahan=$_POST['aturan_tambahan'];
                                        }
                                        if(empty($_POST['id_obat'])){
                                            $id_obat="";
                                        }else{
                                            $id_obat=$_POST['id_obat'];
                                        }
                                        //Membuat Variabel
                                        $frekuensi=$_POST['frekuensi'];
                                        $unit=$_POST['unit'];
                                        $dosis=$_POST['dosis'];
                                        $metode=$_POST['metode'];
                                        $jumlah_obat=$_POST['jumlah_obat'];
                                        $bentuk_sediaan=$_POST['bentuk_sediaan'];
                                        $nama_obat=$_POST['nama_obat'];
                                        //Membuat Variabel
                                        $id=$_POST['id'];
                                        $id_resep=$_POST['id_resep'];
                                        //Buka Data Lama
                                        $obat=getDataDetail($Conn,"resep",'id_resep',$id_resep,'obat');
                                        $JsonObat =json_decode($obat, true);
                                        $ObatBaru = array();
                                        foreach ($JsonObat as $row){
                                            if($row["id"]==$id){
                                                $h['id'] =$id;
                                                $h['id_obat'] =$id_obat;
                                                $h['nama_obat'] =$nama_obat;
                                                $h['bentuk_sediaan'] =$bentuk_sediaan;
                                                $h['jumlah_obat'] =$jumlah_obat;
                                                $h['metode'] =$metode;
                                                $h['dosis'] =$dosis;
                                                $h['unit'] =$unit;
                                                $h['frekuensi'] =$frekuensi;
                                                $h['aturan_tambahan'] =$aturan_tambahan;
                                            }else{
                                                $h['id'] = $row["id"];
                                                $h['id_obat'] = $row["id_obat"];
                                                $h['nama_obat'] = $row["nama_obat"];
                                                $h['bentuk_sediaan'] = $row["bentuk_sediaan"];
                                                $h['jumlah_obat'] = $row["jumlah_obat"];
                                                $h['metode'] = $row["metode"];
                                                $h['dosis'] = $row["dosis"];
                                                $h['unit'] = $row["unit"];
                                                $h['frekuensi'] = $row["frekuensi"];
                                                $h['aturan_tambahan'] = $row["aturan_tambahan"];
                                            }
                                            array_push($ObatBaru, $h);
                                        }
                                        $ObatBaruJson= json_encode($ObatBaru);
                                        $UpdateResep= mysqli_query($Conn,"UPDATE resep SET 
                                            obat='$ObatBaruJson'
                                        WHERE id_resep='$id_resep'") or die(mysqli_error($Conn));
                                        if($UpdateResep){
                                            $LogJsonFile="../../_Page/Log/Log.json";
                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Resep Obat","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                            if($MenyimpanLog=="Berhasil"){
                                                echo '<span class="text-success" id="NotifikasiEditObatResepBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                            }
                                        }else{
                                            echo '<span class="text-danger">Terjadi kesalahan pada saat update data!</span><br>';
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