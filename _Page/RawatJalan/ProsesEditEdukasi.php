<?php
    //Time Zone
    date_default_timezone_set('Asia/Jakarta');
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Time Now Tmp
    $now=date('Y-m-d H:i:s');
    $Updatetime=date('Y-m-d H:i');
    //Validasi ProsesEditEdukasi tidak boleh kosong
    if(empty($_POST['ProsesEditEdukasi'])){
        echo '<small class="text-danger">Data Form tidak boleh kosong</small>';
    }else{
        if(empty($_POST['materi_edukasi'])){
            echo '<small class="text-danger">Materi Edukasi tidak boleh kosong</small>';
        }else{
            //Membuat variabel wajib
            $ProsesEditEdukasi=$_POST['ProsesEditEdukasi'];
            $materi_edukasi=$_POST['materi_edukasi'];
            //Parameter
            parse_str($ProsesEditEdukasi, $params);
            //Validasi Kelengkapan Data
            if(empty($params['id_edukasi'])){
                echo '<small class="text-danger">ID Edukasi tidak boleh kosong</small>';
            }else{
                if(empty($params['id_pasien'])){
                    echo '<small class="text-danger">No.RM tidak boleh kosong</small>';
                }else{
                    if(empty($params['id_kunjungan'])){
                        echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
                    }else{
                        if(empty($params['petugas_entry'])){
                            echo '<small class="text-danger">Petugas entry tidak boleh kosong</small>';
                        }else{
                            if(empty($params['tanggal_edukasi'])){
                                echo '<small class="text-danger">Tanggal Edukasi tidak boleh kosong</small>';
                            }else{
                                if(empty($params['jam_edukasi'])){
                                    echo '<small class="text-danger">Jam Edukasi tidak boleh kosong</small>';
                                }else{
                                    if(empty($params['kategori_edukasi'])){
                                        echo '<small class="text-danger">Kategori Edukasi tidak boleh kosong</small>';
                                    }else{
                                        if(empty($params['nama_pemberi_edukasi'])){
                                            echo '<small class="text-danger">Nama pemberi edukasi tidak boleh kosong</small>';
                                        }else{
                                            if(empty($params['kontak_pemberi_edukasi'])){
                                                echo '<small class="text-danger">Kontak pemberi edukasi tidak boleh kosong</small>';
                                            }else{
                                                if(empty($params['identitas_pemberi_edukasi'])){
                                                    echo '<small class="text-danger">Kategori identitas pemberi edukasi tidak boleh kosong</small>';
                                                }else{
                                                    if(empty($params['no_identitas_pemberi_edukasi'])){
                                                        echo '<small class="text-danger">Nomor identitas pemberi edukasi tidak boleh kosong</small>';
                                                    }else{
                                                        if(empty($params['nama_penerima_edukasi'])){
                                                            echo '<small class="text-danger">Nama penerima edukasi tidak boleh kosong</small>';
                                                        }else{
                                                            if(empty($params['kontak_penerima_edukasi'])){
                                                                echo '<small class="text-danger">Kontak penerima edukasi tidak boleh kosong</small>';
                                                            }else{
                                                                if(empty($params['identitas_penerima_edukasi'])){
                                                                    echo '<small class="text-danger">Kategori identitas penerima edukasi tidak boleh kosong</small>';
                                                                }else{
                                                                    if(empty($params['no_identitas_penerima_edukasi'])){
                                                                        echo '<small class="text-danger">Nomor identitas penerima edukasi tidak boleh kosong</small>';
                                                                    }else{
                                                                        if(empty($params['kemampuan_bahasa'])){
                                                                            echo '<small class="text-danger">Kemampuan bahasa penerima edukasi tidak boleh kosong</small>';
                                                                        }else{
                                                                            if(empty($params['perlu_penerjemah'])){
                                                                                echo '<small class="text-danger">Keterangan keperluan penerjemah penerima edukasi tidak boleh kosong</small>';
                                                                            }else{
                                                                                if(empty($params['hambatan_komunikasi'])){
                                                                                    echo '<small class="text-danger">Keterangan hambatan penerima edukasi tidak boleh kosong</small>';
                                                                                }else{
                                                                                    if(empty($params['kesediaan_edukasi'])){
                                                                                        echo '<small class="text-danger">Kesediaan penerima edukasi tidak boleh kosong</small>';
                                                                                    }else{
                                                                                        if(empty($params['status_edukasi'])){
                                                                                            echo '<small class="text-danger">Status Edukasi tidak boleh kosong</small>';
                                                                                        }else{
                                                                                            if(empty($params['durasi_edukasi'])){
                                                                                                echo '<small class="text-danger">Durasi Edukasi tidak boleh kosong</small>';
                                                                                            }else{
                                                                                                $id_edukasi = $params['id_edukasi'];
                                                                                                $id_pasien = $params['id_pasien'];
                                                                                                $id_kunjungan = $params['id_kunjungan'];
                                                                                                $petugas_entry = $params['petugas_entry'];
                                                                                                $tanggal_edukasi = $params['tanggal_edukasi'];
                                                                                                $jam_edukasi = $params['jam_edukasi'];
                                                                                                $kategori_edukasi = $params['kategori_edukasi'];
                                                                                                $nama_pemberi_edukasi = $params['nama_pemberi_edukasi'];
                                                                                                $kontak_pemberi_edukasi = $params['kontak_pemberi_edukasi'];
                                                                                                $identitas_pemberi_edukasi = $params['identitas_pemberi_edukasi'];
                                                                                                $no_identitas_pemberi_edukasi = $params['no_identitas_pemberi_edukasi'];
                                                                                                $nama_penerima_edukasi = $params['nama_penerima_edukasi'];
                                                                                                $kontak_penerima_edukasi = $params['kontak_penerima_edukasi'];
                                                                                                $identitas_penerima_edukasi = $params['identitas_penerima_edukasi'];
                                                                                                $no_identitas_penerima_edukasi = $params['no_identitas_penerima_edukasi'];
                                                                                                $kemampuan_bahasa = $params['kemampuan_bahasa'];
                                                                                                $perlu_penerjemah = $params['perlu_penerjemah'];
                                                                                                $hambatan_komunikasi = $params['hambatan_komunikasi'];
                                                                                                $kesediaan_edukasi = $params['kesediaan_edukasi'];
                                                                                                $status_edukasi = $params['status_edukasi'];
                                                                                                $durasi_edukasi = $params['durasi_edukasi'];
                                                                                                if(!empty($params['jenis_hambatan'])){
                                                                                                    $JenisHambatan=$params['jenis_hambatan'];
                                                                                                    $JsonJenisHambatan = array();
                                                                                                    foreach($JenisHambatan as $Data){
                                                                                                        $h['jenis']=$Data;
                                                                                                        array_push($JsonJenisHambatan, $h);
                                                                                                    }
                                                                                                    $JenisHambatan=$JsonJenisHambatan;
                                                                                                }else{
                                                                                                    $JenisHambatan="";
                                                                                                }
                                                                                                //Bersihkan Ilegal String
                                                                                                $materi_edukasi= addslashes($materi_edukasi);
                                                                                                $materi_edukasi = str_replace(array("\r","\n"),"",$materi_edukasi);
                                                                                                //Buka Data Lama
                                                                                                $pemberi_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'pemberi_edukasi');
                                                                                                $penerima_edukasi=getDataDetail($Conn,"edukasi",'id_edukasi',$id_edukasi,'penerima_edukasi');
                                                                                                $JsonPemberiEdukasi =json_decode($pemberi_edukasi, true);
                                                                                                $JsonPenerimaEdukasi =json_decode($penerima_edukasi, true);
                                                                                                $TtdPemberiEdukasi=$JsonPemberiEdukasi['ttd'];
                                                                                                $TtdPenerimaEdukasi=$JsonPenerimaEdukasi['ttd'];
                                                                                                //Membuat JSON Pemberi Edukasi
                                                                                                $PemberiEdukasiArray = array(
                                                                                                    "nama"=>"$nama_pemberi_edukasi",
                                                                                                    "kontak"=>"$kontak_pemberi_edukasi",
                                                                                                    "kategori_identitas"=>"$identitas_pemberi_edukasi",
                                                                                                    "no_identitas"=>"$no_identitas_pemberi_edukasi",
                                                                                                    "ttd"=>"$TtdPemberiEdukasi",
                                                                                                );
                                                                                                $JsonPemberiEdukasi= json_encode($PemberiEdukasiArray);
                                                                                                //Membuat JSON Penerima Edukasi
                                                                                                $PenerimaEdukasiArray = array(
                                                                                                    "nama"=>"$nama_penerima_edukasi",
                                                                                                    "kontak"=>"$kontak_penerima_edukasi",
                                                                                                    "kategori_identitas"=>"$identitas_penerima_edukasi",
                                                                                                    "no_identitas"=>"$no_identitas_penerima_edukasi",
                                                                                                    "ttd"=>"$TtdPenerimaEdukasi"
                                                                                                );
                                                                                                $JsonPenerimaEdukasi= json_encode($PenerimaEdukasiArray);
                                                                                                //Membuat JSON Keterangan Edukasi
                                                                                                $KeteranganEdukasiArray = array(
                                                                                                    "bahasa"=>"$kemampuan_bahasa",
                                                                                                    "penerjemah"=>"$perlu_penerjemah",
                                                                                                    "hambatan"=>"$hambatan_komunikasi",
                                                                                                    "jenis_hambatan"=>$JenisHambatan,
                                                                                                    "kesediaan_edukasi"=>"$kesediaan_edukasi",
                                                                                                    "durasi"=>"$durasi_edukasi"
                                                                                                );
                                                                                                $JsonKeteranganEdukasi= json_encode($KeteranganEdukasiArray);
                                                                                                //Format Tanggal
                                                                                                $TanggalEdukasi="$tanggal_edukasi $jam_edukasi";
                                                                                                //Simpan Data
                                                                                                $UpdateEdukasi= mysqli_query($Conn,"UPDATE edukasi SET 
                                                                                                    petugas_entry='$petugas_entry',
                                                                                                    tanggal_edukasi='$TanggalEdukasi',
                                                                                                    kategori_edukasi='$kategori_edukasi',
                                                                                                    materi_edukasi='$materi_edukasi',
                                                                                                    pemberi_edukasi='$JsonPemberiEdukasi',
                                                                                                    penerima_edukasi='$JsonPenerimaEdukasi',
                                                                                                    keterangan_edukasi='$JsonKeteranganEdukasi',
                                                                                                    status_edukasi='$status_edukasi'
                                                                                                WHERE id_edukasi='$id_edukasi'") or die(mysqli_error($Conn));
                                                                                                if($UpdateEdukasi){
                                                                                                    $LogJsonFile="../../_Page/Log/Log.json";
                                                                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Update Edukasi","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                                                    if($MenyimpanLog=="Berhasil"){
                                                                                                        echo '<span class="text-success" id="NotifikasiEditEdukasiBerhasil">Success</span>';
                                                                                                    }else{
                                                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                                                    }
                                                                                                }else{
                                                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan data</span>';
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
