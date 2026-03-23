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
    if(empty($_POST['id_kunjungan'])){
        echo '<span class="text-danger">ID Kunjungan Tidak Boleh Kosong!</span>';
    }else{
        if(empty($_POST['id_pasien'])){
            echo '<span class="text-danger">ID/No.RM Pasien Tidak Boleh Kosong!</span>';
        }else{
            if(empty($_POST['nama_pasien'])){
                echo '<span class="text-danger">Nama Pasien Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['tanggal_entry'])){
                    echo '<span class="text-danger">Tanggal Entry Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['jam_entry'])){
                        echo '<span class="text-danger">Jam Entry Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['petugas_entry'])){
                            echo '<span class="text-danger">Petugas Entry Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['tanggal_pelaksanaan'])){
                                echo '<span class="text-danger">Tanggal Pelaksanaan Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['jam_mulai'])){
                                    echo '<span class="text-danger">Jam Mulai Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['jam_selesai'])){
                                        echo '<span class="text-danger">Jam Selesai Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['KeywordProcedur'])){
                                            echo '<span class="text-danger">Tindakan Tidak Boleh Kosong!</span>';
                                        }else{
                                            if(empty($_POST['isi_alat_medis'])){
                                                echo '<span class="text-danger">Alat Medis Tidak Boleh Kosong!</span>';
                                            }else{
                                                if(empty($_POST['isi_BMHP'])){
                                                    echo '<span class="text-danger">Isi BMHP Tidak Boleh Kosong!</span>';
                                                }else{
                                                    if(empty($_POST['isi_nama_nakes'])){
                                                        echo '<span class="text-danger">Nama Nakes Tidak Boleh Kosong!</span>';
                                                    }else{
                                                        if(empty($_POST['isi_kategori_nakes'])){
                                                            echo '<span class="text-danger">Kategori Tindakan Tidak Boleh Kosong!</span>';
                                                        }else{
                                                            //Membuat Variabel
                                                            $id_kunjungan=$_POST['id_kunjungan'];
                                                            $id_pasien=$_POST['id_pasien'];
                                                            $nama_pasien=$_POST['nama_pasien'];
                                                            $tanggal_entry=$_POST['tanggal_entry'];
                                                            $jam_entry=$_POST['jam_entry'];
                                                            $petugas_entry=$_POST['petugas_entry'];
                                                            $tanggal_pelaksanaan=$_POST['tanggal_pelaksanaan'];
                                                            $jam_mulai=$_POST['jam_mulai'];
                                                            $jam_selesai=$_POST['jam_selesai'];
                                                            $isi_tindakan=$_POST['KeywordProcedur'];
                                                            $isi_alat_medis=$_POST['isi_alat_medis'];
                                                            $isi_BMHP=$_POST['isi_BMHP'];
                                                            $isi_kategori_nakes=$_POST['isi_kategori_nakes'];
                                                            $isi_nama_nakes=$_POST['isi_nama_nakes'];
                                                            //Gabungkan Tanggal
                                                            $tanggal_entry="$tanggal_entry $jam_entry";
                                                            //Pecah Karakter Tindakan
                                                            $Explode = explode("|" , $isi_tindakan);
                                                            $kode_tindakan=$Explode[0];
                                                            $nama_tindakan=$Explode[1];
                                                            //Membuat JSON Alkes
                                                            $alat_medis_array = array();
                                                            if(!empty(count($isi_alat_medis))){
                                                                $JumlahAlkes=count($isi_alat_medis);
                                                                for($i=0; $i<$JumlahAlkes; $i++){
                                                                    $j['alkes'] =$isi_alat_medis[$i];
                                                                    array_push($alat_medis_array, $j);
                                                                }
                                                            }
                                                            $JsonAlkes = json_encode($alat_medis_array);
                                                            //Membuat JSON BMHP
                                                            $BMHPArray = array();
                                                            if(!empty(count($isi_BMHP))){
                                                                $JumlahBMHP=count($isi_BMHP);
                                                                for($i=0; $i<$JumlahBMHP; $i++){
                                                                    $k['bmhp'] =$isi_BMHP[$i];
                                                                    array_push($BMHPArray, $k);
                                                                }
                                                            }
                                                            $JsonBmhp = json_encode($BMHPArray);
                                                             //Membuat JSON Nakes
                                                            $NakesArray = array();
                                                            if(!empty(count($isi_kategori_nakes))){
                                                                $JumlahNakes=count($isi_kategori_nakes);
                                                                for($i=0; $i<$JumlahNakes; $i++){
                                                                    $l['kategori'] =$isi_kategori_nakes[$i];
                                                                    $l['nama'] =$isi_nama_nakes[$i];
                                                                    array_push($NakesArray, $l);
                                                                }
                                                            }
                                                            $JsonNakes = json_encode($NakesArray);
                                                            //Simpan Data Ke Database
                                                            $entry="INSERT INTO tindakan (
                                                                id_kunjungan,
                                                                id_pasien,
                                                                id_akses,
                                                                nama_pasien,
                                                                nama_petugas,
                                                                tanggal_entry,
                                                                tanggal_pelaksanaan,
                                                                waktu_mulai,
                                                                waktu_selesai,
                                                                kode_tindakan,
                                                                nama_tindakan,
                                                                alat_medis,
                                                                bmhp,
                                                                nakes
                                                            ) VALUES (
                                                                '$id_kunjungan',
                                                                '$id_pasien',
                                                                '$SessionIdAkses',
                                                                '$nama_pasien',
                                                                '$petugas_entry',
                                                                '$tanggal_entry',
                                                                '$tanggal_pelaksanaan',
                                                                '$jam_mulai',
                                                                '$jam_selesai',
                                                                '$kode_tindakan',
                                                                '$nama_tindakan',
                                                                '$JsonAlkes',
                                                                '$JsonBmhp',
                                                                '$JsonNakes'
                                                            )";
                                                            $hasil=mysqli_query($Conn, $entry);
                                                            if($hasil){
                                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Tindakan","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                if($MenyimpanLog=="Berhasil"){
                                                                    echo '<span class="text-success" id="NotifikasiTambahTindakanBerhasil">Success</span>';
                                                                }else{
                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                }
                                                            }else{
                                                                echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Tindakan</span>';
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