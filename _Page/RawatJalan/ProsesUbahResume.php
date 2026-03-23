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
    $Updatetime=date('Y-m-d H:i');
    //Validasi id_pasien tidak boleh kosong
    if(empty($_POST['ProsesUbahResume'])){
        echo '<small class="text-danger">Data Form tidak boleh kosong</small>';
    }else{
        $ProsesUbahResume=$_POST['ProsesUbahResume'];
        //Parameter
        parse_str($ProsesUbahResume, $params);
        //Validasi Kelengkapan Data
        if(empty($params['id_pasien'])){
            echo '<small class="text-danger">No.RM tidak boleh kosong</small>';
        }else{
            if(empty($params['id_kunjungan'])){
                echo '<small class="text-danger">ID Kunjungan tidak boleh kosong</small>';
            }else{
                if(empty($params['tanggal_entry'])){
                    echo '<small class="text-danger">Tanggal Entry tidak boleh kosong</small>';
                }else{
                    if(empty($params['jam_entry'])){
                        echo '<small class="text-danger">Jam Entry tidak boleh kosong</small>';
                    }else{
                        if(empty($params['tanggal_pulang'])){
                            echo '<small class="text-danger">Tanggal Pulang tidak boleh kosong</small>';
                        }else{
                            if(empty($params['jam_pulang'])){
                                echo '<small class="text-danger">Jam pulang tidak boleh kosong</small>';
                                }else{
                                if(empty($params['resume'])){
                                    echo '<small class="text-danger">Status resume tidak boleh kosong</small>';
                                }else{
                                    if(empty($params['pasca_pulang'])){
                                        echo '<small class="text-danger">Status Pasca Pulang tidak boleh kosong</small>';
                                    }else{
                                        if(empty($params['nama_petugas_entry'])){
                                            echo '<small class="text-danger">Nama petugas entry tidak boleh kosong</small>';
                                        }else{
                                            if(empty($params['kategori_petugas_entry'])){
                                                echo '<small class="text-danger">Kategori petugas tidak boleh kosong</small>';
                                            }else{
                                                if(empty($params['kontak_petugas_entry'])){
                                                    echo '<small class="text-danger">Kontak petugas entry tidak boleh kosong</small>';
                                                }else{
                                                    if(empty($params['kategori_identitas_petugas'])){
                                                        echo '<small class="text-danger">Kategori identitas petugas entry tidak boleh kosong</small>';
                                                    }else{
                                                        if(empty($params['no_identitas_petugas'])){
                                                            echo '<small class="text-danger">Nomor identitas petugas entry tidak boleh kosong</small>';
                                                        }else{
                                                            if(empty($params['nama_dokter'])){
                                                                echo '<small class="text-danger">Nama dokter DPJP tidak boleh kosong</small>';
                                                            }else{
                                                                if(empty($params['sip_dokter'])){
                                                                    echo '<small class="text-danger">SIP dokter DPJP tidak boleh kosong</small>';
                                                                }else{
                                                                    if(empty($params['kategori_identitas_dokter'])){
                                                                        echo '<small class="text-danger">Kategori identitas dokter DPJP tidak boleh kosong</small>';
                                                                    }else{
                                                                        if(empty($params['no_identitas_dokter'])){
                                                                            echo '<small class="text-danger">Nomor identitas dokter DPJP tidak boleh kosong</small>';
                                                                        }else{
                                                                            $id_pasien = $params['id_pasien'];
                                                                            $id_kunjungan = $params['id_kunjungan'];
                                                                            $tanggal_entry = $params['tanggal_entry'];
                                                                            $jam_entry = $params['jam_entry'];
                                                                            $tanggal_pulang = $params['tanggal_pulang'];
                                                                            $jam_pulang = $params['jam_pulang'];
                                                                            $resume = $params['resume'];
                                                                            $pasca_pulang = $params['pasca_pulang'];
                                                                            //Format Tanggal
                                                                            $TanggalEntry="$tanggal_entry $jam_entry";
                                                                            $TanggalPulang="$tanggal_pulang $jam_pulang";
                                                                            //Cek apakah ID Kunjungan Sudah Punya Resume
                                                                            $id_resume=getDataDetail($Conn,"resume",'id_kunjungan',$id_kunjungan,'id_resume');
                                                                            //Petugas Entry
                                                                            $nama_petugas_entry = $params['nama_petugas_entry'];
                                                                            $kategori_petugas_entry = $params['kategori_petugas_entry'];
                                                                            $kontak_petugas_entry = $params['kontak_petugas_entry'];
                                                                            $kategori_identitas_petugas = $params['kategori_identitas_petugas'];
                                                                            $no_identitas_petugas = $params['no_identitas_petugas'];
                                                                            //Dokter DPJP
                                                                            $nama_dokter = $params['nama_dokter'];
                                                                            $sip_dokter = $params['sip_dokter'];
                                                                            if(empty($params['kontak_dokter'])){
                                                                                $kontak_dokter="";
                                                                            }else{
                                                                                $kontak_dokter=$params['kontak_dokter'];
                                                                            }
                                                                            if(empty($params['kategori_identitas_dokter'])){
                                                                                $kategori_identitas_dokter="";
                                                                            }else{
                                                                                $kategori_identitas_dokter=$params['kategori_identitas_dokter'];
                                                                            }
                                                                            if(empty($params['no_identitas_dokter'])){
                                                                                $no_identitas_dokter="";
                                                                            }else{
                                                                                $no_identitas_dokter=$params['no_identitas_dokter'];
                                                                            }
                                                                            //Pasien Meninggal
                                                                            if(empty($params['no_surat_meninggal'])){
                                                                                $no_surat_meninggal="";
                                                                            }else{
                                                                                $no_surat_meninggal=$params['no_surat_meninggal'];
                                                                            }
                                                                            if(empty($params['UpdateStatusPasien'])){
                                                                                $UpdateStatusPasien="";
                                                                            }else{
                                                                                $UpdateStatusPasien=$params['UpdateStatusPasien'];
                                                                            }
                                                                            if(empty($params['UpdateStatusKunjungan'])){
                                                                                $UpdateStatusKunjungan="";
                                                                            }else{
                                                                                $UpdateStatusKunjungan=$params['UpdateStatusKunjungan'];
                                                                            }
                                                                            if(empty($params['tanggal_meninggal'])){
                                                                                $tanggal_meninggal="";
                                                                            }else{
                                                                                $tanggal_meninggal=$params['tanggal_meninggal'];
                                                                            }
                                                                            if(empty($params['jam_meninggal'])){
                                                                                $jam_meninggal="";
                                                                            }else{
                                                                                $jam_meninggal=$params['jam_meninggal'];
                                                                            }
                                                                            $TanggalMeninggal="$tanggal_meninggal $jam_meninggal";
                                                                            //Rencana Kontrol
                                                                            if(empty($params['no_surat_kontrol'])){
                                                                                $no_surat_kontrol="";
                                                                            }else{
                                                                                $no_surat_kontrol=$params['no_surat_kontrol'];
                                                                            }
                                                                            if(empty($params['tanggal_rencana_kontrol'])){
                                                                                $tanggal_rencana_kontrol="";
                                                                            }else{
                                                                                $tanggal_rencana_kontrol=$params['tanggal_rencana_kontrol'];
                                                                            }
                                                                            if(empty($params['nama_poli_kontrol'])){
                                                                                $nama_poli_kontrol="";
                                                                            }else{
                                                                                $nama_poli_kontrol=$params['nama_poli_kontrol'];
                                                                            }
                                                                            if(empty($params['nama_dokter_kontrol'])){
                                                                                $nama_dokter_kontrol="";
                                                                            }else{
                                                                                $nama_dokter_kontrol=$params['nama_dokter_kontrol'];
                                                                            }
                                                                            //Lampiran
                                                                            if(!empty($params['lampiran'])){
                                                                                $lampiran=$params['lampiran'];
                                                                                $LampiranArray = array();
                                                                                foreach($params['lampiran'] as $Data){
                                                                                    $h['lampiran']=$Data;
                                                                                    array_push($LampiranArray, $h);
                                                                                }
                                                                                $Lampiran= json_encode($LampiranArray);
                                                                            }else{
                                                                                $Lampiran="";
                                                                            }
                                                                            //Form Rich Text
                                                                            if(empty($_POST['evaluasi'])){
                                                                                $evaluasi="";
                                                                            }else{
                                                                                $evaluasi=$_POST['evaluasi'];
                                                                            }
                                                                            if(empty($_POST['nasehat'])){
                                                                                $nasehat="";
                                                                            }else{
                                                                                $nasehat=$_POST['nasehat'];
                                                                            }
                                                                            if(empty($_POST['terapi_pulang'])){
                                                                                $terapi_pulang="";
                                                                            }else{
                                                                                $terapi_pulang=$_POST['terapi_pulang'];
                                                                            }
                                                                            //Bersihkan Ilegal String
                                                                            $evaluasi= addslashes($evaluasi);
                                                                            $evaluasi = str_replace(array("\r","\n"),"",$evaluasi);
                                                                            $nasehat= addslashes($nasehat);
                                                                            $nasehat = str_replace(array("\r","\n"),"",$nasehat);
                                                                            $terapi_pulang= addslashes($terapi_pulang);
                                                                            $terapi_pulang = str_replace(array("\r","\n"),"",$terapi_pulang);
                                                                            //Membuat JSON Petugas Entry
                                                                            $PetugasArray = array(
                                                                                "nama"=>"$nama_petugas_entry",
                                                                                "kategori"=>"$kategori_petugas_entry",
                                                                                "kontak"=>"$kontak_petugas_entry",
                                                                                "kategori_identitas"=>"$kategori_identitas_petugas",
                                                                                "no_identitas"=>"$no_identitas_petugas",
                                                                                "ttd"=>"",
                                                                            );
                                                                            $JsonPetugas= json_encode($PetugasArray);
                                                                            //Membuat JSON Dokter
                                                                            $DokterArray = array(
                                                                                "nama"=>"$nama_dokter",
                                                                                "SIP"=>"$sip_dokter",
                                                                                "kontak"=>"$kontak_dokter",
                                                                                "kategori_identitas"=>"$kategori_identitas_dokter",
                                                                                "no_identitas"=>"$no_identitas_dokter",
                                                                                "ttd"=>""
                                                                            );
                                                                            $JsonDokter= json_encode($DokterArray);
                                                                            //Membuat JSON Meninggal
                                                                            if($resume=="Meninggal"){
                                                                                $MeninggalArray = array(
                                                                                    "no_surat_meninggal"=>"$no_surat_meninggal",
                                                                                    "tanggal_meninggal"=>"$TanggalMeninggal"
                                                                                );
                                                                                $JsonMeninggal= json_encode($MeninggalArray);
                                                                            }else{
                                                                                $JsonMeninggal="";
                                                                            }
                                                                            //Membuat Json Rencana Kontrol
                                                                            $KontrolArray = array(
                                                                                "no_surat"=>"$no_surat_kontrol",
                                                                                "tanggal"=>"$tanggal_rencana_kontrol",
                                                                                "nama_poli"=>"$nama_poli_kontrol",
                                                                                "nama_dokter"=>"$nama_dokter_kontrol"
                                                                            );
                                                                            $JsonKontrol= json_encode($KontrolArray);
                                                                            //Simpan Data
                                                                            if(empty($id_resume)){
                                                                                //Insert
                                                                                $entry="INSERT INTO resume (
                                                                                    id_pasien,
                                                                                    id_kunjungan,
                                                                                    id_akses,
                                                                                    tanggal_entry,
                                                                                    tanggal_pulang,
                                                                                    petugas,
                                                                                    dokter,
                                                                                    resume,
                                                                                    pasca_pulang,
                                                                                    nasehat,
                                                                                    evaluasi,
                                                                                    terapi_pulang,
                                                                                    rencana_kontrol,
                                                                                    meninggal,
                                                                                    pengaturan_lampiran
                                                                                ) VALUES (
                                                                                    '$id_pasien',
                                                                                    '$id_kunjungan',
                                                                                    '$SessionIdAkses',
                                                                                    '$TanggalEntry',
                                                                                    '$TanggalPulang',
                                                                                    '$JsonPetugas',
                                                                                    '$JsonDokter',
                                                                                    '$resume',
                                                                                    '$pasca_pulang',
                                                                                    '$nasehat',
                                                                                    '$evaluasi',
                                                                                    '$terapi_pulang',
                                                                                    '$JsonKontrol',
                                                                                    '$JsonMeninggal',
                                                                                    '$Lampiran'
                                                                                )";
                                                                                $hasil=mysqli_query($Conn, $entry);
                                                                            }else{
                                                                                //Update
                                                                                $hasil= mysqli_query($Conn,"UPDATE resume SET 
                                                                                    tanggal_entry='$TanggalEntry',
                                                                                    tanggal_pulang='$TanggalPulang',
                                                                                    petugas='$JsonPetugas',
                                                                                    dokter='$JsonDokter',
                                                                                    resume='$resume',
                                                                                    pasca_pulang='$pasca_pulang',
                                                                                    nasehat='$nasehat',
                                                                                    evaluasi='$evaluasi',
                                                                                    terapi_pulang='$terapi_pulang',
                                                                                    rencana_kontrol='$JsonKontrol',
                                                                                    meninggal='$JsonMeninggal',
                                                                                    pengaturan_lampiran='$Lampiran'
                                                                                WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                                                                            }
                                                                            if($hasil){
                                                                                $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Atur Resume","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                                if($MenyimpanLog=="Berhasil"){
                                                                                    //Update Kunjungan
                                                                                    if($UpdateStatusKunjungan=="Ya"){
                                                                                        if(!empty($resume)){
                                                                                            //Routing Status
                                                                                            if($resume=="Meninggal"){
                                                                                                $StatusKunjungan="Meninggal";
                                                                                            }else{
                                                                                                $StatusKunjungan="Pulang";
                                                                                            }
                                                                                            //Update Kunjungan
                                                                                            $UpdateKunjungan= mysqli_query($Conn,"UPDATE kunjungan_utama SET 
                                                                                                cara_keluar='$resume',
                                                                                                tanggal_keluar='$TanggalPulang',
                                                                                                status='$StatusKunjungan',
                                                                                                updatetime='$now'
                                                                                            WHERE id_kunjungan='$id_kunjungan'") or die(mysqli_error($Conn));
                                                                                        }
                                                                                    }
                                                                                    //Update Pasien
                                                                                    if($UpdateStatusPasien=="Ya"){
                                                                                        if(!empty($resume)){
                                                                                            //Routing Status
                                                                                            if($resume=="Meninggal"){
                                                                                                $StatusPasien="Meninggal";
                                                                                                //Update Status Pasien Apabila Meninggal
                                                                                                $UpdatePasien= mysqli_query($Conn,"UPDATE pasien SET 
                                                                                                    status='$StatusPasien',
                                                                                                    updatetime='$now'
                                                                                                WHERE id_pasien='$id_pasien'") or die(mysqli_error($Conn));
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    echo '<span class="text-success" id="NotifikasiResumeBerhasil">Success</span>';
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
?>
