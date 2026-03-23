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
            if(empty($_POST['id_jadwal_operasi'])){
                echo '<span class="text-danger">ID Jadwal Operasi Tidak Boleh Kosong!</span>';
            }else{
                if(empty($_POST['tanggal_entry'])){
                    echo '<span class="text-danger">Tanggal Entry Tidak Boleh Kosong!</span>';
                }else{
                    if(empty($_POST['jam_entry'])){
                        echo '<span class="text-danger">Jam Entry Tidak Boleh Kosong!</span>';
                    }else{
                        if(empty($_POST['tanggal_mulai'])){
                            echo '<span class="text-danger">Tanggal Mulai Operasi Tidak Boleh Kosong!</span>';
                        }else{
                            if(empty($_POST['jam_mulai'])){
                                echo '<span class="text-danger">Jam Mulai Operasi Tidak Boleh Kosong!</span>';
                            }else{
                                if(empty($_POST['tanggal_selesai'])){
                                    echo '<span class="text-danger">Tanggal Selesai Tidak Boleh Kosong!</span>';
                                }else{
                                    if(empty($_POST['jam_selesai'])){
                                        echo '<span class="text-danger">Jam Selesai Tidak Boleh Kosong!</span>';
                                    }else{
                                        if(empty($_POST['petugas_entry'])){
                                            echo '<span class="text-danger">Petugas entry Tidak Boleh Kosong!</span>';
                                        }else{
                                            if(empty($_POST['hubungan_dengan_pasien'])){
                                                echo '<span class="text-danger">Hubungan Dengan Pasien Tidak Boleh Kosong!</span>';
                                            }else{
                                                if(empty($_POST['kontak_persetujuan'])){
                                                    echo '<span class="text-danger">Informasi Hubungan Dengan Pasien Tidak Boleh Kosong!</span>';
                                                }else{
                                                    if(empty($_POST['nama_persetujuan'])){
                                                        echo '<span class="text-danger">Nama Persetujuan Tidak Boleh Kosong!</span>';
                                                    }else{
                                                        if(empty($_POST['kategori_identitas_persetujuan'])){
                                                            echo '<span class="text-danger">Kategori Identitas Persetujuan Tidak Boleh Kosong!</span>';
                                                        }else{
                                                            if(empty($_POST['nomor_identitas_persetujuan'])){
                                                                echo '<span class="text-danger">Nomor Identitas Persetujuan Tidak Boleh Kosong!</span>';
                                                            }else{
                                                                //Membuat Variabel
                                                                $id_kunjungan=$_POST['id_kunjungan'];
                                                                $id_pasien=$_POST['id_pasien'];
                                                                $id_jadwal_operasi=$_POST['id_jadwal_operasi'];
                                                                $tanggal_entry=$_POST['tanggal_entry'];
                                                                $jam_entry=$_POST['jam_entry'];
                                                                $tanggal_mulai=$_POST['tanggal_mulai'];
                                                                $jam_mulai=$_POST['jam_mulai'];
                                                                $tanggal_selesai=$_POST['tanggal_selesai'];
                                                                $jam_selesai=$_POST['jam_selesai'];
                                                                $petugas_entry=$_POST['petugas_entry'];
                                                                $hubungan_dengan_pasien=$_POST['hubungan_dengan_pasien'];
                                                                $kontak_persetujuan=$_POST['kontak_persetujuan'];
                                                                $nama_persetujuan=$_POST['nama_persetujuan'];
                                                                $kategori_identitas_persetujuan=$_POST['kategori_identitas_persetujuan'];
                                                                $nomor_identitas_persetujuan=$_POST['nomor_identitas_persetujuan'];
                                                                //Gabungkan Tanggal
                                                                $TanggalEntry="$tanggal_entry $jam_entry";
                                                                $TanggalMulai="$tanggal_mulai $jam_mulai";
                                                                $TanggalSelesai="$tanggal_selesai $jam_selesai";
                                                                //Anastesi
                                                                if(!empty($_POST['durasi_anastesi'])){
                                                                    $durasi_anastesi=$_POST['durasi_anastesi'];
                                                                }else{
                                                                    $durasi_anastesi="";
                                                                }
                                                                if(!empty($_POST['diagnosis_kerja_operasi'])){
                                                                    $diagnosis_kerja_operasi=$_POST['diagnosis_kerja_operasi'];
                                                                }else{
                                                                    $diagnosis_kerja_operasi="";
                                                                }
                                                                if(!empty($_POST['diagnosis_banding_operasi'])){
                                                                    $diagnosis_banding_operasi=$_POST['diagnosis_banding_operasi'];
                                                                }else{
                                                                    $diagnosis_banding_operasi="";
                                                                }
                                                                if(!empty($_POST['tindakan_anastesi'])){
                                                                    $TindakanAnastesiArray = array();
                                                                    foreach($_POST['tindakan_anastesi'] as $GetTindakanAnastesi){
                                                                        $j['tindakan_anastesi'] =$GetTindakanAnastesi;
                                                                        array_push($TindakanAnastesiArray, $j);
                                                                    }
                                                                }else{
                                                                    $TindakanAnastesiArray="";
                                                                }
                                                                if(!empty($_POST['tata_cara'])){
                                                                    $TataCaraArray = array();
                                                                    foreach($_POST['tata_cara'] as $GetTataCaraAnastesi){
                                                                        $k['tata_cara'] =$GetTataCaraAnastesi;
                                                                        array_push($TataCaraArray, $k);
                                                                    }
                                                                }else{
                                                                    $TataCaraArray="";
                                                                }
                                                                if(!empty($_POST['tujuan_anastesi'])){
                                                                    $TujuanAnastesiArray = array();
                                                                    foreach($_POST['tujuan_anastesi'] as $GetTujuanAnastesi){
                                                                        $L['tujuan_anastesi'] =$GetTujuanAnastesi;
                                                                        array_push($TujuanAnastesiArray, $L);
                                                                    }
                                                                }else{
                                                                    $TujuanAnastesiArray="";
                                                                }
                                                                if(!empty($_POST['resiko_tindakan'])){
                                                                    $ResikoTindakanArray = array();
                                                                    foreach($_POST['resiko_tindakan'] as $GetResikoTindakan){
                                                                        $M['resiko_tindakan'] =$GetResikoTindakan;
                                                                        array_push($ResikoTindakanArray, $M);
                                                                    }
                                                                }else{
                                                                    $ResikoTindakanArray="";
                                                                }
                                                                if(!empty($_POST['komplikasi'])){
                                                                    $KomplikasiArray = array();
                                                                    foreach($_POST['komplikasi'] as $GetKomplikasi){
                                                                        $N['komplikasi'] =$GetKomplikasi;
                                                                        array_push($KomplikasiArray, $N);
                                                                    }
                                                                }else{
                                                                    $KomplikasiArray="";
                                                                }
                                                                if(!empty($_POST['prognosis'])){
                                                                    $prognosis =$_POST['prognosis'];
                                                                }else{
                                                                    $prognosis="";
                                                                }
                                                                if(!empty($_POST['alternatif'])){
                                                                    $alternatif =$_POST['alternatif'];
                                                                }else{
                                                                    $alternatif="";
                                                                }
                                                                if(!empty($_POST['lain_lain'])){
                                                                    $lain_lain =$_POST['lain_lain'];
                                                                }else{
                                                                    $lain_lain="";
                                                                }
                                                                $AnastesiArray = array(
                                                                    "durasi"=>"$durasi_anastesi",
                                                                    "diagnosis_kerja"=>"$diagnosis_kerja_operasi",
                                                                    "diagnosis_banding"=>"$diagnosis_banding_operasi",
                                                                    "tindakan"=>$TindakanAnastesiArray,
                                                                    "tata_cara"=>$TataCaraArray,
                                                                    "tujuan"=>$TujuanAnastesiArray,
                                                                    "resiko"=>$ResikoTindakanArray,
                                                                    "komplikasi"=>$KomplikasiArray,
                                                                    "prognosis"=>$prognosis,
                                                                    "alternatif"=>"$alternatif",
                                                                    "lainnya"=>$lain_lain
                                                                );
                                                                $JsonAnastesi = json_encode($AnastesiArray);
                                                                //Persetujuan
                                                                if(!empty($_POST['nama_persetujuan'])){
                                                                    $nama_persetujuan =$_POST['nama_persetujuan'];
                                                                }else{
                                                                    $nama_persetujuan="";
                                                                }
                                                                if(!empty($_POST['hubungan_dengan_pasien'])){
                                                                    $hubungan_dengan_pasien =$_POST['hubungan_dengan_pasien'];
                                                                }else{
                                                                    $hubungan_dengan_pasien="";
                                                                }
                                                                if(!empty($_POST['kontak_persetujuan'])){
                                                                    $kontak_persetujuan =$_POST['kontak_persetujuan'];
                                                                }else{
                                                                    $kontak_persetujuan="";
                                                                }
                                                                if(!empty($_POST['kategori_identitas_persetujuan'])){
                                                                    $kategori_identitas_persetujuan =$_POST['kategori_identitas_persetujuan'];
                                                                }else{
                                                                    $kategori_identitas_persetujuan="";
                                                                }
                                                                if(!empty($_POST['nomor_identitas_persetujuan'])){
                                                                    $nomor_identitas_persetujuan =$_POST['nomor_identitas_persetujuan'];
                                                                }else{
                                                                    $nomor_identitas_persetujuan="";
                                                                }
                                                                $PersetujuanArray = array(
                                                                    "hubungan"=>"$hubungan_dengan_pasien",
                                                                    "nama"=>"$nama_persetujuan",
                                                                    "kontak"=>"$kontak_persetujuan",
                                                                    "kategori_identitas"=>"$kategori_identitas_persetujuan",
                                                                    "nomor_identitas"=>"$nomor_identitas_persetujuan",
                                                                    "ttd"=>"",
                                                                );
                                                                $JsonPersetujuan = json_encode($PersetujuanArray);
                                                                //Tenaga Kesehatan
                                                                if(!empty($_POST['KategoriNakesOperasi'])){
                                                                    $JumlahNakes =count($_POST['KategoriNakesOperasi']);
                                                                    if(!empty($JumlahNakes)){
                                                                        $KategoriNakesOperasi =$_POST['KategoriNakesOperasi'];
                                                                        $NamaNakesOperasi =$_POST['NamaNakesOperasi'];
                                                                        $SipNakesOperasi =$_POST['SipNakesOperasi'];
                                                                        $KontakNakesOperasi =$_POST['KontakNakesOperasi'];
                                                                        $KategoriIdentitasNakesOperasi =$_POST['KategoriIdentitasNakesOperasi'];
                                                                        $NomorIdentitasNakesOperasi =$_POST['NomorIdentitasNakesOperasi'];
                                                                        $NakesOperasiArray = array();
                                                                        for($i=0; $i<$JumlahNakes; $i++){
                                                                            $id_nakse_operasi=rand(1000,9999);
                                                                            $o['id_nakes_operasi'] =$id_nakse_operasi;
                                                                            $o['kategori'] =$KategoriNakesOperasi[$i];
                                                                            $o['nama'] =$NamaNakesOperasi[$i];
                                                                            $o['sip'] =$SipNakesOperasi[$i];
                                                                            $o['kontak'] =$KontakNakesOperasi[$i];
                                                                            $o['kategori_identitas'] =$KategoriIdentitasNakesOperasi[$i];
                                                                            $o['nomor_identitas'] =$NomorIdentitasNakesOperasi[$i];
                                                                            $o['ttd'] ="";
                                                                            array_push($NakesOperasiArray, $o);
                                                                        }
                                                                        $JsonNakesOperasi= json_encode($NakesOperasiArray);
                                                                    }
                                                                }else{
                                                                    $JsonNakesOperasi="";
                                                                }
                                                                //Diagnosasi Operasi
                                                                if(!empty($_POST['KategoriDiagnosaOperasi'])){
                                                                    $JumlahKategoriDiagnosis =count($_POST['KategoriDiagnosaOperasi']);
                                                                    if(!empty($JumlahKategoriDiagnosis)){
                                                                        $KategoriDiagnosaOperasi =$_POST['KategoriDiagnosaOperasi'];
                                                                        $KodeDiagnosaOperasi =$_POST['KodeDiagnosaOperasi'];
                                                                        $NamaDiagnosaOperasi =$_POST['NamaDiagnosaOperasi'];
                                                                        $DiagnosisOperasiArray = array();
                                                                        for($i=0; $i<$JumlahKategoriDiagnosis; $i++){
                                                                            $p['kategori'] =$KategoriDiagnosaOperasi[$i];
                                                                            $p['kode'] =$KodeDiagnosaOperasi[$i];
                                                                            $p['deskripsi'] =$NamaDiagnosaOperasi[$i];
                                                                            array_push($DiagnosisOperasiArray, $p);
                                                                        }
                                                                        $JsonDiagnosisOperasi= json_encode($DiagnosisOperasiArray);
                                                                    }
                                                                }else{
                                                                    $JsonDiagnosisOperasi="";
                                                                }
                                                                //Body Site
                                                                if(!empty($_POST['BodySiteOperasi'])){
                                                                    $JumlahBodySiteOperasi =count($_POST['BodySiteOperasi']);
                                                                    if(!empty($JumlahBodySiteOperasi)){
                                                                        $BodySiteOperasi =$_POST['BodySiteOperasi'];
                                                                        $KeteranganBodySiteOperasi =$_POST['KeteranganBodySiteOperasi'];
                                                                        $BodySiteArray = array();
                                                                        for($i=0; $i<$JumlahBodySiteOperasi; $i++){
                                                                            $q['body_site']=$BodySiteOperasi[$i];
                                                                            $q['keterangan']=$KeteranganBodySiteOperasi[$i];
                                                                            array_push($BodySiteArray, $q);
                                                                        }
                                                                        $JsonBodySiteOperasi= json_encode($BodySiteArray);
                                                                    }
                                                                }else{
                                                                    $JsonBodySiteOperasi="";
                                                                }
                                                                //Tindakan Operasi
                                                                if(!empty($_POST['KodeTindakan'])){
                                                                    $JumlahTindakanOperasi =count($_POST['KodeTindakan']);
                                                                    if(!empty($JumlahTindakanOperasi)){
                                                                        $KodeTindakan =$_POST['KodeTindakan'];
                                                                        $NamaTindakan =$_POST['NamaTindakan'];
                                                                        $TindakanOperasiArray = array();
                                                                        for($i=0; $i<$JumlahTindakanOperasi; $i++){
                                                                            $r['kode']=$KodeTindakan[$i];
                                                                            $r['deskripsi']=$NamaTindakan[$i];
                                                                            array_push($TindakanOperasiArray, $r);
                                                                        }
                                                                        $JsonTindakanOperasi= json_encode($TindakanOperasiArray);
                                                                    }
                                                                }else{
                                                                    $JsonTindakanOperasi="";
                                                                }
                                                                //Instrumen Operasi
                                                                if(!empty($_POST['GetInstrumenOperasi'])){
                                                                    $JumlahInstrumen =count($_POST['GetInstrumenOperasi']);
                                                                    if(!empty($JumlahInstrumen)){
                                                                        $GetInstrumenOperasi =$_POST['GetInstrumenOperasi'];
                                                                        $InstrumenOperasiArray = array();
                                                                        for($i=0; $i<$JumlahInstrumen; $i++){
                                                                            $s['instrumen']=$GetInstrumenOperasi[$i];
                                                                            array_push($InstrumenOperasiArray, $s);
                                                                        }
                                                                        $JsonInstrumen= json_encode($InstrumenOperasiArray);
                                                                    }
                                                                }else{
                                                                    $JsonInstrumen="";
                                                                }
                                                                //Keterangan Dokter
                                                                if(!empty($_POST['GetNamaKeteranganDokterOperasi'])){
                                                                    $JumlahKeteranganDokter =count($_POST['GetNamaKeteranganDokterOperasi']);
                                                                    if(!empty($JumlahKeteranganDokter)){
                                                                        $GetNamaKeteranganDokterOperasi =$_POST['GetNamaKeteranganDokterOperasi'];
                                                                        $GetKeteranganDokterOperasi =$_POST['GetKeteranganDokterOperasi'];
                                                                        $KeteranganDokterArray = array();
                                                                        for($i=0; $i<$JumlahKeteranganDokter; $i++){
                                                                            $t['dokter']=$GetNamaKeteranganDokterOperasi[$i];
                                                                            $t['catatan']=$GetKeteranganDokterOperasi[$i];
                                                                            array_push($KeteranganDokterArray, $t);
                                                                        }
                                                                        $JsonKeteranganDokter= json_encode($KeteranganDokterArray);
                                                                    }
                                                                }else{
                                                                    $JsonKeteranganDokter="";
                                                                }
                                                                //Buka Data Operasi
                                                                $GetIdOperasi=getDataDetail($Conn,"operasi",'id_kunjungan',$id_kunjungan,'id_operasi');
                                                                if(empty($GetIdOperasi)){
                                                                    //Simpan Data Ke Database
                                                                    $entry="INSERT INTO operasi (
                                                                        id_jadwal_operasi,
                                                                        id_kunjungan,
                                                                        id_pasien,
                                                                        id_akses,
                                                                        tanggal_entry,
                                                                        tanggal_mulai,
                                                                        tanggal_selesai,
                                                                        petugas_entry,
                                                                        pelaksana,
                                                                        diagnosa_operasi,
                                                                        body_site,
                                                                        tindakan_operasi,
                                                                        instrumen,
                                                                        keterangan_dokter,
                                                                        anastesi,
                                                                        persetujuan
                                                                    ) VALUES (
                                                                        '$id_jadwal_operasi',
                                                                        '$id_kunjungan',
                                                                        '$id_pasien',
                                                                        '$SessionIdAkses',
                                                                        '$TanggalEntry',
                                                                        '$TanggalMulai',
                                                                        '$TanggalSelesai',
                                                                        '$petugas_entry',
                                                                        '$JsonNakesOperasi',
                                                                        '$JsonDiagnosisOperasi',
                                                                        '$JsonBodySiteOperasi',
                                                                        '$JsonTindakanOperasi',
                                                                        '$JsonInstrumen',
                                                                        '$JsonKeteranganDokter',
                                                                        '$JsonAnastesi',
                                                                        '$JsonPersetujuan'
                                                                    )";
                                                                    $hasil=mysqli_query($Conn, $entry);
                                                                }else{
                                                                    //Simpan Data Ke Database
                                                                    $hasil= mysqli_query($Conn,"UPDATE operasi SET 
                                                                        id_jadwal_operasi='$id_jadwal_operasi',
                                                                        id_kunjungan='$id_kunjungan',
                                                                        id_pasien='$id_pasien',
                                                                        id_akses='$SessionIdAkses',
                                                                        tanggal_entry='$TanggalEntry',
                                                                        tanggal_mulai='$TanggalMulai',
                                                                        tanggal_selesai='$TanggalSelesai',
                                                                        petugas_entry='$petugas_entry',
                                                                        pelaksana='$JsonNakesOperasi',
                                                                        diagnosa_operasi='$JsonDiagnosisOperasi',
                                                                        body_site='$JsonBodySiteOperasi',
                                                                        tindakan_operasi='$JsonTindakanOperasi',
                                                                        instrumen='$JsonInstrumen',
                                                                        keterangan_dokter='$JsonKeteranganDokter',
                                                                        anastesi='$JsonAnastesi',
                                                                        persetujuan='$JsonPersetujuan'
                                                                    WHERE id_operasi='$GetIdOperasi'") or die(mysqli_error($Conn));
                                                                }
                                                                if($hasil){
                                                                    $MenyimpanLog=getSaveLog($Conn,$now,$SessionNama,"Tambah Operasi","Kunjungan",$SessionIdAkses,$LogJsonFile);
                                                                    if($MenyimpanLog=="Berhasil"){
                                                                        echo '<span class="text-success" id="NotifikasiTambahStatusOperasiBerhasil">Success</span>';
                                                                        echo '<span class="text-success" id="UrlBackOperasi">index.php?Page=RawatJalan&Sub=Operasi&ms_sub=PreviewOperasi&id='.$id_kunjungan.'</span>';
                                                                    }else{
                                                                        echo '<span class="text-danger">Terjadi Kesalahan Pada Saat Menyimpan Log!</span>';
                                                                    }
                                                                }else{
                                                                    echo '<span class="text-danger">Terjadi Kesalahan Pada Saat menyimpan Data Operasi</span>';
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