<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    //Validasi id_kunjungan tidak boleh kosong
    if(empty($_POST['id_kunjungan'])){
        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
    }else{
        //Validasi id_pasien tidak boleh kosong
        if(empty($_POST['id_pasien'])){
            echo '<small class="text-danger">No.RM tidak boleh kosong</small>';
        }else{
            //Validasi nama_pasien tidak boleh kosong
            if(empty($_POST['nama_pasien'])){
                echo '<small class="text-danger">Nama pasien tidak boleh kosong</small>';
            }else{
                //Validasi tanggal_entry tidak boleh kosong
                if(empty($_POST['tanggal_entry'])){
                    echo '<small class="text-danger">Tanggal Entry tidak boleh kosong</small>';
                }else{
                    //Validasi jam_entry tidak boleh kosong
                    if(empty($_POST['jam_entry'])){
                        echo '<small class="text-danger">Jam entry tidak boleh kosong</small>';
                    }else{
                        //Validasi Petugas Entry  boleh kosong
                        if(empty($_POST['petugas_entry'])){
                            echo '<small class="text-danger">Petugas entry tidak boleh kosong</small>';
                        }else{
                            //Validasi tanggal penjelasan tidak boleh kosong
                            if(empty($_POST['tanggal_penjelasan'])){
                                echo '<small class="text-danger">Tanggal penjelasan tidak boleh kosong</small>';
                            }else{
                                //Validasi jam_penjelasan tidak boleh kosong
                                if(empty($_POST['jam_penjelasan'])){
                                    echo '<small class="text-danger">Jam penjelasan tidak boleh kosong</small>';
                                }else{
                                    //Validasi kategori_identitas_dokter tidak boleh kosong
                                    if(empty($_POST['kategori_identitas_dokter'])){
                                        echo '<small class="text-danger">Kategori identitas dokter tidak boleh kosong</small>';
                                    }else{
                                        //Validasi nomor_identitas_dokter tidak boleh kosong
                                        if(empty($_POST['nomor_identitas_dokter'])){
                                            echo '<small class="text-danger">Nomor identitas dokter tidak boleh kosong</small>';
                                        }else{
                                            //Validasi nama_dokter tidak boleh kosong
                                            if(empty($_POST['nama_dokter'])){
                                                echo '<small class="text-danger">Nama dokter tidak boleh kosong</small>';
                                            }else{
                                                 //Validasi pendaping_dokter tidak boleh kosong
                                                if(empty($_POST['pendaping_dokter'])){
                                                    echo '<small class="text-danger">Pendaping dokter tidak boleh kosong</small>';
                                                }else{
                                                    //Validasi pemberi_pernyataan tidak boleh kosong
                                                    if(empty($_POST['pemberi_pernyataan'])){
                                                        echo '<small class="text-danger">Pemberi pernyataan tidak boleh kosong</small>';
                                                    }else{
                                                        //Validasi identitas_pemberi_pernyataan tidak boleh kosong
                                                        if(empty($_POST['identitas_pemberi_pernyataan'])){
                                                            echo '<small class="text-danger">Identitas pemberi pernyataan tidak boleh kosong</small>';
                                                        }else{
                                                            //Validasi nomor_identitas_pemberi_pernyataan tidak boleh kosong
                                                            if(empty($_POST['nomor_identitas_pemberi_pernyataan'])){
                                                                echo '<small class="text-danger">Nomor identitas pemberi pernyataan tidak boleh kosong</small>';
                                                            }else{
                                                                //Validasi nama_pemberi_pernyataan tidak boleh kosong
                                                                if(empty($_POST['nama_pemberi_pernyataan'])){
                                                                    echo '<small class="text-danger">Nama pemberi pernyataan tidak boleh kosong</small>';
                                                                }else{
                                                                    //Validasi identitas_saksi1 tidak boleh kosong
                                                                    if(empty($_POST['identitas_saksi1'])){
                                                                        echo '<small class="text-danger">Identitas saksi1 tidak boleh kosong</small>';
                                                                    }else{
                                                                        //Validasi nomor_identitas_saksi1 tidak boleh kosong
                                                                        if(empty($_POST['nomor_identitas_saksi1'])){
                                                                            echo '<small class="text-danger">Nomor identitas saksi1 tidak boleh kosong</small>';
                                                                        }else{
                                                                            //Validasi nama_saksi1 tidak boleh kosong
                                                                            if(empty($_POST['nama_saksi1'])){
                                                                                echo '<small class="text-danger">Nama saksi1 tidak boleh kosong</small>';
                                                                            }else{
                                                                                //Validasi identitas_saksi2 tidak boleh kosong
                                                                                if(empty($_POST['identitas_saksi2'])){
                                                                                    echo '<small class="text-danger">Identitas saksi2 tidak boleh kosong</small>';
                                                                                }else{
                                                                                    //Validasi nomor_identitas_saksi2 tidak boleh kosong
                                                                                    if(empty($_POST['nomor_identitas_saksi2'])){
                                                                                        echo '<small class="text-danger">Nomor Identitas saksi2 tidak boleh kosong</small>';
                                                                                    }else{
                                                                                        //Validasi nama_saksi2 tidak boleh kosong
                                                                                        if(empty($_POST['nama_saksi2'])){
                                                                                            echo '<small class="text-danger">Nama saksi2 tidak boleh kosong</small>';
                                                                                        }else{
                                                                                            //Validasi isi_tindakan tidak boleh kosong
                                                                                            if(empty($_POST['isi_tindakan'])){
                                                                                                echo '<small class="text-danger">Nama-nama tindakan tidak boleh kosong</small>';
                                                                                            }else{
                                                                                                //Validasi konsekuensi tidak boleh kosong
                                                                                                if(empty($_POST['konsekuensi'])){
                                                                                                    echo '<small class="text-danger">Konsekuensi tidak boleh kosong</small>';
                                                                                                }else{
                                                                                                    //Validasi persetujuan tidak boleh kosong
                                                                                                    if(empty($_POST['persetujuan'])){
                                                                                                        echo '<small class="text-danger">Persetujuan tidak boleh kosong</small>';
                                                                                                    }else{
                                                                                                        //Membuat variabel wajib
                                                                                                        $id_kunjungan=$_POST['id_kunjungan'];
                                                                                                        //Validasi Duplikat
                                                                                                        $id_persetujuan_tindakan=getDataDetail($Conn,"persetujuan_tindakan",'id_kunjungan',$id_kunjungan,'id_persetujuan_tindakan');
                                                                                                        $id_pasien=$_POST['id_pasien'];
                                                                                                        $nama_pasien=$_POST['nama_pasien'];
                                                                                                        $tanggal_entry=$_POST['tanggal_entry'];
                                                                                                        $jam_entry=$_POST['jam_entry'];
                                                                                                        $tanggal_entry="$tanggal_entry $jam_entry";
                                                                                                        $petugas_entry=$_POST['petugas_entry'];
                                                                                                        $tanggal_penjelasan=$_POST['tanggal_penjelasan'];
                                                                                                        $jam_penjelasan=$_POST['jam_penjelasan'];
                                                                                                        $tanggal_penjelasan="$tanggal_penjelasan $jam_penjelasan";
                                                                                                        $kategori_identitas_dokter=$_POST['kategori_identitas_dokter'];
                                                                                                        $nomor_identitas_dokter=$_POST['nomor_identitas_dokter'];
                                                                                                        $nama_dokter=$_POST['nama_dokter'];
                                                                                                        $pendaping_dokter=$_POST['pendaping_dokter'];
                                                                                                        $pemberi_pernyataan=$_POST['pemberi_pernyataan'];
                                                                                                        $identitas_pemberi_pernyataan=$_POST['identitas_pemberi_pernyataan'];
                                                                                                        $nomor_identitas_pemberi_pernyataan=$_POST['nomor_identitas_pemberi_pernyataan'];
                                                                                                        $nama_pemberi_pernyataan=$_POST['nama_pemberi_pernyataan'];
                                                                                                        $identitas_saksi1=$_POST['identitas_saksi1'];
                                                                                                        $nomor_identitas_saksi1=$_POST['nomor_identitas_saksi1'];
                                                                                                        $nama_saksi1=$_POST['nama_saksi1'];
                                                                                                        $identitas_saksi2=$_POST['identitas_saksi2'];
                                                                                                        $nomor_identitas_saksi2=$_POST['nomor_identitas_saksi2'];
                                                                                                        $nama_saksi2=$_POST['nama_saksi2'];
                                                                                                        $isi_tindakan=$_POST['isi_tindakan'];
                                                                                                        $konsekuensi=$_POST['konsekuensi'];
                                                                                                        $persetujuan=$_POST['persetujuan'];
                                                                                                        //Array
                                                                                                        $DokterArry=Array (
                                                                                                            "kategori_identitas_dokter" => $kategori_identitas_dokter,
                                                                                                            "nomor_identitas_dokter" => $nomor_identitas_dokter,
                                                                                                            "nama_dokter" => $nama_dokter,
                                                                                                            "pendaping_dokter" => $pendaping_dokter,
                                                                                                            "ttd" => ""
                                                                                                        );
                                                                                                        $PemberiPernyataanArry=Array (
                                                                                                            "pemberi_pernyataan" => $pemberi_pernyataan,
                                                                                                            "nama_pemberi_pernyataan" => $nama_pemberi_pernyataan,
                                                                                                            "identitas_pemberi_pernyataan" => $identitas_pemberi_pernyataan,
                                                                                                            "nomor_identitas_pemberi_pernyataan" => $nomor_identitas_pemberi_pernyataan,
                                                                                                            "ttd" => ""
                                                                                                        );
                                                                                                        $Saksi1Arry=Array (
                                                                                                            "identitas_saksi1" => $identitas_saksi1,
                                                                                                            "nomor_identitas_saksi1" => $nomor_identitas_saksi1,
                                                                                                            "nama_saksi1" => $nama_saksi1,
                                                                                                            "ttd" => ""
                                                                                                        );
                                                                                                        $Saksi2Arry=Array (
                                                                                                            "identitas_saksi2" => $identitas_saksi2,
                                                                                                            "nomor_identitas_saksi2" => $nomor_identitas_saksi2,
                                                                                                            "nama_saksi2" => $nama_saksi2,
                                                                                                            "ttd" => ""
                                                                                                        );
                                                                                                        $SaksiArry=Array (
                                                                                                            "saksi1" => $Saksi1Arry,
                                                                                                            "saksi2" => $Saksi2Arry
                                                                                                        );
                                                                                                        $TindakanArry = array();
                                                                                                        if(!empty(count($isi_tindakan))){
                                                                                                            $JumlahTindakan=count($isi_tindakan);
                                                                                                            for($i=0; $i<$JumlahTindakan; $i++){
                                                                                                                $h['tindakan'] =$isi_tindakan[$i];
                                                                                                                array_push($TindakanArry, $h);
                                                                                                            }
                                                                                                        }
                                                                                                        //Json
                                                                                                        $JsonDokter= json_encode($DokterArry);
                                                                                                        $JsonPemberiPernyataan= json_encode($PemberiPernyataanArry);
                                                                                                        $JsonSaksi= json_encode($SaksiArry);
                                                                                                        $JsonTindakan= json_encode($TindakanArry);
                                                                                                        //Menyimpan Kedalam Database
                                                                                                        $entry="INSERT INTO persetujuan_tindakan (
                                                                                                            id_pasien,
                                                                                                            id_kunjungan,
                                                                                                            id_akses,
                                                                                                            nama_pasien,
                                                                                                            nama_petugas,
                                                                                                            dokter,
                                                                                                            pemberi_pernyataan,
                                                                                                            tanggal_entry,
                                                                                                            tanggal_penjelasan,
                                                                                                            persetujuan,
                                                                                                            tindakan,
                                                                                                            konsekuensi,
                                                                                                            saksi
                                                                                                        ) VALUES (
                                                                                                            '$id_pasien',
                                                                                                            '$id_kunjungan',
                                                                                                            '$SessionIdAkses',
                                                                                                            '$nama_pasien',
                                                                                                            '$petugas_entry',
                                                                                                            '$JsonDokter',
                                                                                                            '$JsonPemberiPernyataan',
                                                                                                            '$tanggal_entry',
                                                                                                            '$tanggal_penjelasan',
                                                                                                            '$persetujuan',
                                                                                                            '$JsonTindakan',
                                                                                                            '$konsekuensi',
                                                                                                            '$JsonSaksi'
                                                                                                        )";
                                                                                                        $hasil=mysqli_query($Conn, $entry);
                                                                                                        if($hasil){
                                                                                                            $LogJsonFile="../../_Page/Log/Log.json";
                                                                                                            $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Persetujuan","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                                                            if($MenyimpanLog=="Berhasil"){
                                                                                                                echo '<span class="text-success" id="NotifikasiTambahPersetujuanTindakanBerhasil">Success</span>';
                                                                                                            }else{
                                                                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                                            }
                                                                                                        }else{
                                                                                                            echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan persetujuan tindakan</span>';
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
            }
        }
    }
?>
