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
                                    $id_resep=$_POST['id_resep'];
                                    $id=date("YmdHis");
                                    //Buka Data resep
                                    $ValidasiIdResep=getDataDetail($Conn,"resep",'id_resep',$id_resep,'id_resep');
                                    if(empty($ValidasiIdResep)){
                                        echo '<span class="text-danger">ID Resep Tidak Valid</span>';
                                    }else{
                                        //Buka Resep Sebelumnya
                                        $obat=getDataDetail($Conn,"resep",'id_resep',$id_resep,'obat');
                                        if(!empty($obat)){
                                            $JsonObat =json_decode($obat, true);
                                            $JumlahObat=count($JsonObat);
                                            $ObatArray = array();
                                            for($i=0; $i<$JumlahObat; $i++){
                                                $h['id'] =$JsonObat[$i]['id'];
                                                $h['id_obat'] =$JsonObat[$i]['id_obat'];
                                                $h['nama_obat'] =$JsonObat[$i]['nama_obat'];
                                                $h['bentuk_sediaan'] =$JsonObat[$i]['bentuk_sediaan'];
                                                $h['jumlah_obat'] =$JsonObat[$i]['jumlah_obat'];
                                                $h['metode'] =$JsonObat[$i]['metode'];
                                                $h['dosis'] =$JsonObat[$i]['dosis'];
                                                $h['unit'] =$JsonObat[$i]['unit'];
                                                $h['frekuensi'] =$JsonObat[$i]['frekuensi'];
                                                $h['aturan_tambahan'] =$JsonObat[$i]['aturan_tambahan'];
                                                array_push($ObatArray, $h);
                                            }
                                            $ObatArray2 = array(
                                                "id"=>"$id",
                                                "id_obat"=>"$id_obat",
                                                "nama_obat"=>"$nama_obat",
                                                "bentuk_sediaan"=>"$bentuk_sediaan",
                                                "jumlah_obat"=>"$jumlah_obat",
                                                "metode"=>"$metode",
                                                "dosis"=>"$dosis",
                                                "unit"=>"$unit",
                                                "frekuensi"=>"$frekuensi",
                                                "aturan_tambahan"=>"$aturan_tambahan"
                                            );
                                            array_push($ObatArray, $ObatArray2);
                                            $JsonObat = json_encode($ObatArray);
                                        }else{
                                            $ObatArray=Array (
                                                "0" => Array (
                                                    "id"=>"$id",
                                                    "id_obat"=>"$id_obat",
                                                    "nama_obat"=>"$nama_obat",
                                                    "bentuk_sediaan"=>"$bentuk_sediaan",
                                                    "jumlah_obat"=>"$jumlah_obat",
                                                    "metode"=>"$metode",
                                                    "dosis"=>"$dosis",
                                                    "unit"=>"$unit",
                                                    "frekuensi"=>"$frekuensi",
                                                    "aturan_tambahan"=>"$aturan_tambahan"
                                                )
                                            );
                                            $JsonObat = json_encode($ObatArray);
                                        }
                                        //Simpan Data Ke Database
                                        $UpdateResep= mysqli_query($Conn,"UPDATE resep SET 
                                            obat='$JsonObat'
                                        WHERE id_resep='$id_resep'") or die(mysqli_error($Conn));
                                        if($UpdateResep){
                                            $LogJsonFile="../../_Page/Log/Log.json";
                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Resep","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                            if($MenyimpanLog=="Berhasil"){
                                                echo '<span class="text-success" id="NotifikasiTambahObatResepBerhasil">Success</span>';
                                            }else{
                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                            }
                                        }else{
                                            echo '<span class="text-danger">Terjadi kesalahan pada saat melakukan update!</span><br>';
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