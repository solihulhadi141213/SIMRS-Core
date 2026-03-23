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
        //Validasi id_pasien tidak boleh kosong
        if(empty($_POST['id_pasien'])){
            echo '<small class="text-danger">No.RM tidak boleh kosong</small>';
        }else{
            //Validasi nama_pasien tidak boleh kosong
            if(empty($_POST['nama_pasien'])){
                echo '<small class="text-danger">Nama pasien tidak boleh kosong</small>';
            }else{
                //Validasi tanggal tidak boleh kosong
                if(empty($_POST['tanggal'])){
                    echo '<small class="text-danger">Tanggal tidak boleh kosong</small>';
                }else{
                    //Validasi jam tidak boleh kosong
                    if(empty($_POST['jam'])){
                        echo '<small class="text-danger">Jam tidak boleh kosong</small>';
                    }else{
                        //Validasi tanggal wawancara tidak boleh kosong
                        if(empty($_POST['tanggal_wawancara'])){
                            echo '<small class="text-danger">Tanggal wawancara tidak boleh kosong</small>';
                        }else{
                            //Validasi jam wawancara tidak boleh kosong
                            if(empty($_POST['jam_wawancara'])){
                                echo '<small class="text-danger">Jam wawancara tidak boleh kosong</small>';
                            }else{
                                //Validasi petugas_entry tidak boleh kosong
                                if(empty($_POST['petugas_entry'])){
                                    echo '<small class="text-danger">Petugas Entry tidak boleh kosong</small>';
                                }else{
                                    //Validasi penanya tidak boleh kosong
                                    if(empty($_POST['penanya'])){
                                        echo '<small class="text-danger">Penanya/pemeriksa tidak boleh kosong</small>';
                                    }else{
                                        //Validasi objek tidak boleh kosong
                                        if(empty($_POST['objek'])){
                                            echo '<small class="text-danger">Nama objek tidak boleh kosong</small>';
                                        }else{
                                            //Validasi status_psikologi tidak boleh kosong
                                            if(empty($_POST['status_psikologi'])){
                                                echo '<small class="text-danger">Status psikologis tidak boleh kosong</small>';
                                            }else{
                                                 //Membuat variabel wajib
                                                $id_kunjungan=$_POST['id_kunjungan'];
                                                $id_pasien=$_POST['id_pasien'];
                                                $nama_pasien=$_POST['nama_pasien'];
                                                $tanggal=$_POST['tanggal'];
                                                $jam=$_POST['jam'];
                                                $tanggal_wawancara=$_POST['tanggal_wawancara'];
                                                $jam_wawancara=$_POST['jam_wawancara'];
                                                $petugas_entry=$_POST['petugas_entry'];
                                                $penanya=$_POST['penanya'];
                                                $objek=$_POST['objek'];
                                                $status_psikologi=$_POST['status_psikologi'];
                                                //Validasi Data Tidak Wajib
                                                if(empty($_POST['keterangan_psikologi'])){
                                                    $keterangan_psikologi="";
                                                }else{
                                                    $keterangan_psikologi=$_POST['keterangan_psikologi'];
                                                }
                                                if(empty($_POST['pendidikan'])){
                                                    $pendidikan="";
                                                }else{
                                                    $pendidikan=$_POST['pendidikan'];
                                                }
                                                if(empty($_POST['profesi'])){
                                                    $profesi="";
                                                }else{
                                                    $profesi=$_POST['profesi'];
                                                }
                                                if(empty($_POST['tempat_kerja'])){
                                                    $tempat_kerja="";
                                                }else{
                                                    $tempat_kerja=$_POST['tempat_kerja'];
                                                }
                                                if(empty($_POST['penghasilan'])){
                                                    $penghasilan="";
                                                }else{
                                                    $penghasilan=$_POST['penghasilan'];
                                                }
                                                if(empty($_POST['suku'])){
                                                    $suku="";
                                                }else{
                                                    $suku=$_POST['suku'];
                                                }
                                                if(empty($_POST['bahasa'])){
                                                    $bahasa="";
                                                }else{
                                                    $bahasa=$_POST['bahasa'];
                                                }
                                                if(empty($_POST['agama'])){
                                                    $agama="";
                                                }else{
                                                    $agama=$_POST['agama'];
                                                }
                                                if(empty($_POST['nilai'])){
                                                    $nilai="";
                                                }else{
                                                    $nilai=$_POST['nilai'];
                                                }
                                                //Assamble Tanggal
                                                $tanggal_entry="$tanggal $jam";
                                                $tanggal_wawancara="$tanggal_wawancara $jam_wawancara";
                                                //Validasi Duplikat
                                                $id_psikosos=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'id_psikosos');
                                                if(empty($id_psikosos)){
                                                    echo '<small class="text-danger">Data Tidak Valid Atau Tidak Ditemukan</small>';
                                                }else{
                                                    //Json Nama Petugas
                                                    $nama_petugas=Array (
                                                        "petugas_entry" => $petugas_entry,
                                                        "penanya" => $penanya,
                                                        "objek" => $objek
                                                    );
                                                    //Json Psikologi
                                                    $psikologi=Array (
                                                        "status_psikologi" => $status_psikologi,
                                                        "keterangan_psikologi" => $keterangan_psikologi
                                                    );
                                                    //Json Sosial
                                                    $sosial=Array (
                                                        "pendidikan" => $pendidikan,
                                                        "profesi" => $profesi,
                                                        "tempat_kerja" => $tempat_kerja,
                                                        "penghasilan" => $penghasilan,
                                                        "suku" => $suku,
                                                        "bahasa" => $bahasa
                                                    );
                                                    //Json spiritual
                                                    $spiritual=Array (
                                                        "agama" => $agama,
                                                        "nilai" => $nilai
                                                    );
                                                    //Json Encode
                                                    $nama_petugas= json_encode($nama_petugas);
                                                    $psikologi= json_encode($psikologi);
                                                    $sosial= json_encode($sosial);
                                                    $spiritual= json_encode($spiritual);
                                                    //Menyimpan Kedalam Database
                                                    $UpdatePsikosos= mysqli_query($Conn,"UPDATE psikosos SET 
                                                        tanggal_wawancara='$tanggal_wawancara',
                                                        nama_petugas='$nama_petugas',
                                                        psikologi='$psikologi',
                                                        sosial='$sosial',
                                                        spiritual='$spiritual'
                                                    WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                                                    if($UpdatePsikosos){
                                                        $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Edit Psikososial","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                        if($MenyimpanLog=="Berhasil"){
                                                            echo '<span class="text-success" id="NotifikasiEditPsikososBerhasil">Success</span>';
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
?>
