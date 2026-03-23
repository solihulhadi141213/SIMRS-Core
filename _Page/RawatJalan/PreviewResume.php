<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="card">';
        echo '  <div class="card-body text-center text-danger">';
        echo '      ID Kunjungan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_kunjungan=$_POST['id_kunjungan'];
        $id_resume=getDataDetail($Conn,"resume",'id_kunjungan',$id_kunjungan,'id_resume');
        if(empty($id_resume)){
            echo '<div class="row">';
            echo '  <div class="col col-md-12 text-center text-dange">';
            echo '       Belum ada Resume untuk kunjungan ini';
            echo '  </div>';
            echo '</div>';
        }else{
            //Membuka Data Resume
            $id_pasien=getDataDetail($Conn,"resume",'id_resume',$id_resume,'id_pasien');
            $tanggal_entry=getDataDetail($Conn,"resume",'id_resume',$id_resume,'tanggal_entry');
            $tanggal_pulang=getDataDetail($Conn,"resume",'id_resume',$id_resume,'tanggal_pulang');
            $petugas=getDataDetail($Conn,"resume",'id_resume',$id_resume,'petugas');
            $dokter=getDataDetail($Conn,"resume",'id_resume',$id_resume,'dokter');
            $resume=getDataDetail($Conn,"resume",'id_resume',$id_resume,'resume');
            $pasca_pulang=getDataDetail($Conn,"resume",'id_resume',$id_resume,'pasca_pulang');
            $nasehat=getDataDetail($Conn,"resume",'id_resume',$id_resume,'nasehat');
            $evaluasi=getDataDetail($Conn,"resume",'id_resume',$id_resume,'evaluasi');
            $kondisi_keluar=getDataDetail($Conn,"resume",'id_resume',$id_resume,'kondisi_keluar');
            $cara_keluar=getDataDetail($Conn,"resume",'id_resume',$id_resume,'cara_keluar');
            $terapi_pulang=getDataDetail($Conn,"resume",'id_resume',$id_resume,'terapi_pulang');
            $rencana_kontrol=getDataDetail($Conn,"resume",'id_resume',$id_resume,'rencana_kontrol');
            $meninggal=getDataDetail($Conn,"resume",'id_resume',$id_resume,'meninggal');
            $pengaturan_lampiran=getDataDetail($Conn,"resume",'id_resume',$id_resume,'pengaturan_lampiran');
            //Buka Pasien
            $nama_pasien=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
            //Buka Petugas
            if(!empty($petugas)){
                $JsonPetugas=json_decode($petugas, true);
                $NamaPetugas=$JsonPetugas['nama'];
                $KategoriPetugas=$JsonPetugas['kategori'];
                $KontakPetugas=$JsonPetugas['kontak'];
                $KategoriIdentitasPetugas=$JsonPetugas['kategori_identitas'];
                $NomorIdentitasPetugas=$JsonPetugas['no_identitas'];
                $TtdPetugas=$JsonPetugas['ttd'];
            }else{
                $NamaPetugas="";
                $KategoriPetugas="";
                $KontakPetugas="";
                $KategoriIdentitasPetugas="";
                $NomorIdentitasPetugas="";
                $TtdPetugas="";
            }
            if(empty($TtdPetugas)){
                $LabelTtdPetugas='<a href="javascript:void(0);" id="AddTtdPetugasEntryResume" class="AddTtdPetugasEntryResume" value="'.$id_resume.'"><span class="text-danger">Belum Ada <i class="ti ti-pencil"></i></span></a>';
            }else{
                $LabelTtdPetugas='<br><img src="data:image/gif;base64,'. $TtdPetugas .'" width="150px">';
            }
            //Buka Dokter
            if(!empty($petugas)){
                $JsonDokter =json_decode($dokter, true);
                $NamaDokter=$JsonDokter['nama'];
                $SipDokter=$JsonDokter['SIP'];
                $KontakDokter=$JsonDokter['kontak'];
                $KategoriIdentitasDokter=$JsonDokter['kategori_identitas'];
                $NomorIdentitasDokter=$JsonDokter['no_identitas'];
                $TtdDokter=$JsonDokter['ttd'];
            }else{
                $NamaDokter="";
                $SipDokter="";
                $KontakDokter="";
                $KategoriIdentitasDokter="";
                $NomorIdentitasDokter="";
                $TtdDokter="";
            }
            if(empty($TtdDokter)){
                $LabelTtdDokter='<a href="javascript:void(0);" id="AddTtdDokterResume" class="AddTtdDokterResume" value="'.$id_resume.'"><span class="text-danger">Belum Ada <i class="ti ti-pencil"></i></span></a>';
            }else{
                $LabelTtdDokter='<br><img src="data:image/gif;base64,'. $TtdDokter .'" width="150px">';
            }
            //Rencana Kontrol
            if(!empty($rencana_kontrol)){
                $JsonRencanaKontrol =json_decode($rencana_kontrol, true);
                $NomorSuratRencanaKontrol=$JsonRencanaKontrol['no_surat'];
                $TanggalRencanaKontrol=$JsonRencanaKontrol['tanggal'];
                $NamaPoliRencanaKontrol=$JsonRencanaKontrol['nama_poli'];
                $NamaDokterRencanaKontrol=$JsonRencanaKontrol['nama_dokter'];
                //Format Tanggal
                $strtotimeKontrol=strtotime($TanggalRencanaKontrol);
                $TanggalRencanaKontrol=date('d/m/Y', $strtotimeKontrol);
            }else{
                $NomorSuratRencanaKontrol="";
                $TanggalRencanaKontrol="";
                $NamaPoliRencanaKontrol="";
                $NamaDokterRencanaKontrol="";
            }
            //Meninggal
            if(!empty($meninggal)){
                $JsonMeninggal =json_decode($meninggal, true);
                $no_surat_meninggal=$JsonMeninggal['no_surat_meninggal'];
                $tanggal_meninggal=$JsonMeninggal['tanggal_meninggal'];
                $strtotime3=strtotime($tanggal_meninggal);
                $TanggalMeninggal=date('Y-m-d',$strtotime3);
                $JamMeninggal=date('H:i',$strtotime3);
                //Format Tanggal
                $TanggalJamMeninggal="$TanggalMeninggal $JamMeninggal";
                $strtotimeMeninggal=strtotime($TanggalJamMeninggal);
                $TanggalJamMeninggal=date('d/m/Y H:i T', $strtotimeMeninggal);
            }else{
                $no_surat_meninggal="";
                $tanggal_meninggal="";
                $TanggalMeninggal="";
                $JamMeninggal="";
                $TanggalJamMeninggal="";
            }
            //Lampiran
            if(!empty($pengaturan_lampiran)){
                $JsonLampiran =json_decode($pengaturan_lampiran, true);
            }else{
                $JsonLampiran="";
            }
            //Format Tanggal
            $strtotime1=strtotime($tanggal_entry);
            $strtotime2=strtotime($tanggal_pulang);
            $TanggalEntry=date('d/m/Y H:i T',$strtotime1);
            $TanggalPulang=date('d/m/Y H:i T',$strtotime2);
            //Menampilkan Data
            echo '<div class="row sub-title">';
            echo '  <div class="col-md-12">';
            echo '      <dt>A. Informasi Umum</dt>';
            echo '      <ol>';
            echo '          <li>No.RM : <code class="text-secondary">'.$id_pasien.'</code></li>';
            echo '          <li>ID.Kunjungan : <code class="text-secondary">'.$id_kunjungan.'</code></li>';
            echo '          <li>ID.Resume : <code class="text-secondary">'.$id_resume.'</code></li>';
            echo '          <li>Nama Pasien : <code class="text-secondary">'.$nama_pasien.'</code></li>';
            echo '          <li>Tgl/Jam Entry : <code class="text-secondary">'.$TanggalEntry.'</code></li>';
            echo '          <li>Tgl/Jam Pulang : <code class="text-secondary">'.$TanggalPulang.'</code></li>';
            echo '          <li>Resume : <code class="text-secondary">'.$resume.'</code></li>';
            echo '          <li>Pasca Pulang : <code class="text-secondary">'.$pasca_pulang.'</code></li>';
            echo '      </ol>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row sub-title">';
            echo '  <div class="col-md-12">';
            echo '      <dt>B. Petugas Entry</dt>';
            echo '      <ol>';
            echo '          <li>Nama Petugas : <code class="text-secondary">'.$NamaPetugas.'</code></li>';
            echo '          <li>Kategori Petugas : <code class="text-secondary">'.$KategoriPetugas.'</code></li>';
            echo '          <li>Kontak Petugas : <code class="text-secondary">'.$KontakPetugas.'</code></li>';
            echo '          <li>Kategori Identitas : <code class="text-secondary">'.$KategoriIdentitasPetugas.'</code></li>';
            echo '          <li>Nomor Identitas : <code class="text-secondary">'.$NomorIdentitasPetugas.'</code></li>';
            echo '          <li>Ttd : <code class="text-secondary">'.$LabelTtdPetugas.'</code> <div id="FormTtdPetugasEntryResume"></div></li>';
            echo '      </ol>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row sub-title">';
            echo '  <div class="col-md-12">';
            echo '      <dt>D. Dokter DPJP</dt>';
            echo '      <ol>';
            echo '          <li>Nama Dokter : <code class="text-secondary">'.$NamaDokter.'</code></li>';
            echo '          <li>SIP Dokter : <code class="text-secondary">'.$SipDokter.'</code></li>';
            echo '          <li>Kontak Dokter : <code class="text-secondary">'.$KontakDokter.'</code></li>';
            echo '          <li>Kategori Identitas : <code class="text-secondary">'.$KategoriIdentitasDokter.'</code></li>';
            echo '          <li>Nomor Identitas : <code class="text-secondary">'.$NomorIdentitasDokter.'</code></li>';
            echo '          <li>Ttd : <code class="text-secondary">'.$LabelTtdDokter.'</code> <div id="FormTtdDokterResume"></div></li>';
            echo '      </ol>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row sub-title">';
            echo '  <div class="col-md-12">';
            echo '      <dt>E. Rencana Kontrol</dt>';
            echo '      <i class="text-danger">* Informasi ini hanya untuk pasien yang direncanakan melakukan kontrol</i>';
            if(!empty($NomorSuratRencanaKontrol)){
            echo '      <ol>';
            echo '          <li>No.Surat Kontrol : <code class="text-secondary">'.$NomorSuratRencanaKontrol.'</code></li>';
            echo '          <li>Tgl.Kontrol : <code class="text-secondary">'.$TanggalRencanaKontrol.'</code></li>';
            echo '          <li>Poliklinik : <code class="text-secondary">'.$NamaPoliRencanaKontrol.'</code></li>';
            echo '          <li>Dokter : <code class="text-secondary">'.$NamaDokterRencanaKontrol.'</code></li>';
            echo '      </ol>';
            }
            echo '  </div>';
            echo '</div>';
            echo '<div class="row sub-title">';
            echo '  <div class="col-md-4">';
            echo '      <dt>F. Pasien Meninggal</dt>';
            echo '      <i class="text-danger">* Informasi ini hanya untuk pasien yang meninggal</i>';
            if(!empty($no_surat_meninggal)){
            echo '      <ol>';
            echo '          <li>No.Surat : <code class="text-secondary">'.$no_surat_meninggal.'</code></li>';
            echo '          <li>Tgl/Jam : <code class="text-secondary">'.$TanggalJamMeninggal.'</code></li>';
            echo '      </ol>';
            }
            echo '  </div>';
            echo '</div>';
            echo '<div class="row sub-title">';
            echo '  <div class="col-md-12">';
            echo '      <dt>G. Evaluasi Kepulangan</dt>';
            echo '      <code class="text-secondary">'.$evaluasi.'</code>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row sub-title">';
            echo '  <div class="col-md-12">';
            echo '      <dt>H. Nasihat Dokter</dt>';
            echo '      <code class="text-secondary">'.$nasehat.'</code>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row sub-title">';
            echo '  <div class="col-md-12">';
            echo '      <dt>I. Terapi Pulang</dt>';
            echo '      <code class="text-secondary">'.$terapi_pulang.'</code>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="row">';
            echo '  <div class="col-md-12 mb-4">';
            echo '      <dt>J. Informasi/Lampiran Lain</dt>';
            echo '  </div>';
            if(!empty($pengaturan_lampiran)){
                $JsonLampiran=json_decode($pengaturan_lampiran, true);
                $no_lampiran=1;
                foreach($JsonLampiran as $Lampiran){
                    //DIAGNOSA
                    if($Lampiran['lampiran']=="Diagnosa"){
                        $id_diagnosis_pasien=getDataDetail($Conn,"diagnosis_pasien",'id_kunjungan',$id_kunjungan,'id_diagnosis_pasien');
                        echo '  <div class="col-md-12">';
                        echo '      <span>J.'.$no_lampiran.' Ringkasan Diagnosa</span>';
                        if(empty($id_diagnosis_pasien)){
                            echo '<span class="text-danger">Belum Ada Data Diagnosa</span>';
                        }else{
                            echo '<ol>';
                            $query = mysqli_query($Conn, "SELECT DISTINCT kategori FROM diagnosis_pasien WHERE id_kunjungan='$id_kunjungan' ORDER BY kategori ASC");
                            while ($data = mysqli_fetch_array($query)) {
                                $kategori= $data['kategori'];
                                //Pecah kategori
                                $pecah = explode(".", $kategori);
                                $nomorKategori=$pecah[0];
                                $NamaKategori=$pecah[1];
                                echo '<li>';
                                echo '  '.$NamaKategori.' :';
                                echo '  <code class="text-secondary">';
                                $query2 = mysqli_query($Conn, "SELECT * FROM diagnosis_pasien WHERE id_kunjungan='$id_kunjungan' AND kategori='$kategori'");
                                while ($data2 = mysqli_fetch_array($query2)) {
                                    $id_diagnosis_pasien= $data2['id_diagnosis_pasien'];
                                    $kode= $data2['kode'];
                                    $diagnosis= $data2['diagnosis'];
                                    echo '('.$kode.'-'.$diagnosis.'),';
                                }
                                echo '  </code>';
                                echo '</li>';
                            }
                            echo '</ol>';
                        }
                        echo '  </div>';
                    }else{
                        //OPERASI
                        if($Lampiran['lampiran']=="Operasi"){
                            //Buka Data Operasi
                            $id_operasi=getDataDetail($Conn,"operasi",'id_kunjungan',$id_kunjungan,'id_operasi');
                            echo '<div class="col-md-12">';
                            echo '  <span>J.'.$no_lampiran.' Laporan Operasi</span>';
                                    if(!empty($id_operasi)){
                                        $id_jadwal_operasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'id_jadwal_operasi');
                                        $TanggalEntryOperasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'tanggal_entry');
                                        $TanggalMulaiOperasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'tanggal_mulai');
                                        $TanggalSelesaiOperasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'tanggal_selesai');
                                        $pelaksana=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'pelaksana');
                                        $diagnosa_operasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'diagnosa_operasi');
                                        $body_site=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'body_site');
                                        $tindakan_operasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'tindakan_operasi');
                                        $instrumen=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'instrumen');
                                        $keterangan_dokter=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'keterangan_dokter');
                                        $anastesi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'anastesi');
                                        $PersetujuanOperasi=getDataDetail($Conn,"operasi",'id_operasi',$id_operasi,'persetujuan');
                                        //Format Tanggal
                                        $strtotime1=strtotime($TanggalEntryOperasi);
                                        $strtotime2=strtotime($TanggalMulaiOperasi);
                                        $strtotime3=strtotime($TanggalSelesaiOperasi);
                                        $TanggalEntryOperasi=date('d/m/Y H:i T',$strtotime1);
                                        $TanggalMulaiOperasi=date('d/m/Y H:i T',$strtotime2);
                                        $TanggalSelesaiOperasi=date('d/m/Y H:i T',$strtotime3);
                                        echo '<ol>';
                                        echo '  <li>Tgl/Jam Mulai : <code class="text-secondary">'.$TanggalMulaiOperasi.'</code></li>';
                                        echo '  <li>Tgl/Jam Selesai : <code class="text-secondary">'.$TanggalSelesaiOperasi.'</code></li>';
                                        echo '  <li>';
                                        echo '      Nakes Operasi :';
                                                    if(!empty($pelaksana)){
                                                        echo '<code class="text-secondary">';
                                                        echo '  <ol>';
                                                        $JsonPelaksana =json_decode($pelaksana, true);
                                                        foreach($JsonPelaksana as $ListPelaksana){
                                                            $id_nakes_operasi=$ListPelaksana['id_nakes_operasi'];
                                                            $kategori=$ListPelaksana['kategori'];
                                                            $nama=$ListPelaksana['nama'];
                                                            echo '<li>('.$kategori.') '.$nama.'</li>';
                                                        }
                                                        echo '  </ol>';
                                                        echo '</code>';
                                                    }
                                        echo '  </li>';
                                        echo '  <li>';
                                        echo '      Diagnosa Operasi :';
                                                    if(!empty($diagnosa_operasi)){
                                                        echo '<code class="text-secondary">';
                                                        echo '  <ol>';
                                                        $JsonDiagnosaOperasi =json_decode($diagnosa_operasi, true);
                                                        foreach($JsonDiagnosaOperasi as $ListDiagnosaOperasi){
                                                            $KategoriDiagnosaOperasi=$ListDiagnosaOperasi['kategori'];
                                                            $KodeDiagnosaOperasi=$ListDiagnosaOperasi['kode'];
                                                            $DeskripsiDiagnosaOperasi=$ListDiagnosaOperasi['deskripsi'];
                                                            echo '<li>('.$KodeDiagnosaOperasi.') '.$DeskripsiDiagnosaOperasi.'</li>';
                                                        }
                                                        echo '  </ol>';
                                                        echo '</code>';
                                                    }
                                        echo '  </li>';
                                        echo '  <li>';
                                        echo '      Body Site :';
                                                    if(!empty($body_site)){
                                                        echo '<code class="text-secondary">';
                                                        echo '  <ol>';
                                                        $JsonBodySite =json_decode($body_site, true);
                                                        foreach($JsonBodySite as $ListBodySite){
                                                            $BodySite=$ListBodySite['body_site'];
                                                            $KeteranganBodySite=$ListBodySite['keterangan'];
                                                            echo '<li>'.$BodySite.'</li>';
                                                        }
                                                        echo '  </ol>';
                                                        echo '</code>';
                                                    }
                                        echo '  </li>';
                                        echo '  <li>';
                                        echo '      Tindakan Operasi :';
                                                    if(!empty($tindakan_operasi)){
                                                        echo '<code class="text-secondary">';
                                                        echo '  <ol>';
                                                        $JsonTindakanOperasi =json_decode($tindakan_operasi, true);
                                                        foreach($JsonTindakanOperasi as $ListTindakanOperasi){
                                                            $KodeTindakanOperasi=$ListTindakanOperasi['kode'];
                                                            $DeskripsiTindakanOperasi=$ListTindakanOperasi['deskripsi'];
                                                            echo '<li><code class="text-secondary">('.$KodeTindakanOperasi.') '.$DeskripsiTindakanOperasi.'</code></li>';
                                                        }
                                                        echo '  </ol>';
                                                        echo '</code>';
                                                    }
                                        echo '  </li>';
                                        echo '</ol>';
                                    }
                            echo '</div>';
                        }else{
                            // PEMERIKSAAN FISIK
                            if($Lampiran['lampiran']=="pemeriksaan_fisik"){
                                //Buka Data Pemeriksaan Fisik
                                $id_pemeriksaan_fisik=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'id_pemeriksaan_fisik');
                                echo '<div class="col-md-12">';
                                echo '  <span>J.'.$no_lampiran.' Pemeriksaan Fisik</span>';
                                if(empty($id_pemeriksaan_fisik)){
                                    echo '<span class="text-danger">Tidak Ada Data Pemeriksaan Fisik</span>';
                                }else{
                                    echo '<ol>';
                                    $pemeriksaan_fisik=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'pemeriksaan_fisik');
                                    $JsonPemeriksaanFisik =json_decode($pemeriksaan_fisik, true);
                                    if(!empty($JsonPemeriksaanFisik)){
                                        if(!empty($JsonPemeriksaanFisik['Kepala'])){
                                            echo '<li>Kepala :<code class="text-secondary">'.$JsonPemeriksaanFisik['Kepala'].'</code></li>';
                                        }
                                        if(!empty($JsonPemeriksaanFisik['Leher'])){
                                            echo '<li>Leher :<code class="text-secondary">'.$JsonPemeriksaanFisik['Leher'].'</code></li>';
                                        }
                                        if(!empty($JsonPemeriksaanFisik['Thorax'])){
                                            echo '<li>Thorax :<code class="text-secondary">'.$JsonPemeriksaanFisik['Thorax'].'</code></li>';
                                        }
                                        if(!empty($JsonPemeriksaanFisik['Abdomen'])){
                                            echo '<li>Abdomen :<code class="text-secondary">'.$JsonPemeriksaanFisik['Abdomen'].'</code></li>';
                                        }
                                        if(!empty($JsonPemeriksaanFisik['Extremitas'])){
                                            echo '<li>Extremitas :<code class="text-secondary">'.$JsonPemeriksaanFisik['Extremitas'].'</code></li>';
                                        }
                                        if(!empty($JsonPemeriksaanFisik['Genitourinaria'])){
                                            echo '<li>Genitourinaria :<code class="text-secondary">'.$JsonPemeriksaanFisik['Genitourinaria'].'</code></li>';
                                        }
                                    }
                                    echo '</ol>';
                                }
                                echo '</div>';
                            }else{
                                //TANDA VITAL
                                if($Lampiran['lampiran']=="tanda_vital"){
                                    $tanda_vital=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'tanda_vital');
                                    echo '<div class="col-md-12">';
                                    echo '  <span>J.'.$no_lampiran.' Tanda Vital</span>';
                                    if(empty($tanda_vital)){
                                        echo '<span class="text-danger">Belum Ada Riwayat Tindakan</span>';
                                    }else{
                                        $JsonTandaVital =json_decode($tanda_vital, true);
                                        echo '  <ol>';
                                        if(!empty($JsonTandaVital['denyut_jantung'])){
                                            $denyut_jantung=$JsonTandaVital['denyut_jantung'];
                                            echo '<li>Denyut Jantung :<code class="text-secondary">'.$denyut_jantung.' X/Menit</code></li>';
                                        }
                                        if(!empty($JsonTandaVital['pernapasan'])){
                                            $pernapasan =$JsonTandaVital['pernapasan'];
                                            echo '<li>Pernapasan :<code class="text-secondary">'.$pernapasan.' X/Menit</code></li>';
                                        }
                                        if(!empty($JsonTandaVital['sistole'])){
                                            $sistole =$JsonTandaVital['sistole'];
                                            echo '      <li>Sistole :<code class="text-secondary">'.$sistole.' /mmHg</code></li>';
                                        }
                                        if(!empty($JsonTandaVital['diastole'])){
                                            $diastole =$JsonTandaVital['diastole'];
                                            echo '<li>Diastole :<code class="text-secondary">'.$diastole.' /mmHg</code></li>';
                                        }
                                        if(!empty($JsonTandaVital['suhu'])){
                                            $suhu =$JsonTandaVital['suhu'];
                                            echo '<li>Suhu :<code class="text-secondary">'.$suhu.' &#176;C</code></li>';
                                        }
                                        if(!empty($JsonTandaVital['SpO2'])){
                                            $SpO2 =$JsonTandaVital['SpO2'];
                                            echo '<li>SpO2 :<code class="text-secondary">'.$SpO2.' %</code></li>';
                                        }
                                        if(!empty($JsonTandaVital['tinggi_badan'])){
                                            $tinggi_badan =$JsonTandaVital['tinggi_badan'];
                                            echo '<li>Tinggi Badan :<code class="text-secondary">'.$tinggi_badan.' Cm</code></li>';
                                        }
                                        if(!empty($JsonTandaVital['berat_badan'])){
                                            $berat_badan =$JsonTandaVital['berat_badan'];
                                            echo '<li>Berat Badan :<code class="text-secondary">'.$berat_badan.' Kg</code></li>';
                                        }
                                        echo '  </ol>';
                                    }
                                    echo '</div>';
                                }else{
                                    if($Lampiran['lampiran']=="riwayat_tindakan"){
                                        //RIWAYAT TINDAKAN
                                        $id_tindakan=getDataDetail($Conn,"tindakan",'id_kunjungan',$id_kunjungan,'id_tindakan');
                                        echo '<div class="col-md-12">';
                                        echo '  <span>J.'.$no_lampiran.' Riwayat Tindakan</span>';
                                        if(empty($id_tindakan)){
                                            echo '<span class="text-danger">Belum Ada Riwayat Tindakan</span>';
                                        }else{
                                            echo '  <ol>';
                                            $no = 1;
                                            $query = mysqli_query($Conn, "SELECT * FROM tindakan WHERE id_kunjungan='$id_kunjungan' ORDER BY id_tindakan ASC");
                                            while ($data = mysqli_fetch_array($query)) {
                                                $id_tindakan= $data['id_tindakan'];
                                                $tanggal_pelaksanaan= $data['tanggal_pelaksanaan'];
                                                $waktu_mulai= $data['waktu_mulai'];
                                                $waktu_selesai= $data['waktu_selesai'];
                                                $kode_tindakan= $data['kode_tindakan'];
                                                $nama_tindakan= $data['nama_tindakan'];
                                                $alat_medis= $data['alat_medis'];
                                                $bmhp= $data['bmhp'];
                                                $nakes= $data['nakes'];
                                                //Json Decode
                                                $JsonAlatMedis=json_decode($alat_medis, true);
                                                $JsonBmhp =json_decode($bmhp, true);
                                                $JsonNakes=json_decode($nakes, true);
                                                //Format Tanggal
                                                $strtotime2=strtotime($tanggal_pelaksanaan);
                                                $FormatTanggalPelaksanaan=date('d/m/Y',$strtotime2);
                                                echo '<li> '.$FormatTanggalPelaksanaan.' ('.$waktu_mulai.' s/d '.$waktu_selesai.') :<code class="text-secondary">'.$kode_tindakan.'-'.$nama_tindakan.'</code></li>';
                                            }
                                            echo '  </ol>';
                                        }
                                        echo '</div>';
                                    }else{
                                        if($Lampiran['lampiran']=="riwayat_obat"){
                                            //RIWAYAT Obat
                                            $id_riwayat_penggunaan_obat=getDataDetail($Conn,"riwayat_penggunaan_obat",'id_kunjungan',$id_kunjungan,'id_riwayat_penggunaan_obat');
                                            echo '<div class="col-md-12">';
                                            echo '  <span>J.'.$no_lampiran.' Riwayat Obat</span>';
                                            if(empty($id_riwayat_penggunaan_obat)){
                                                echo '<span class="text-danger">Belum Ada Riwayat Obat</span>';
                                            }else{
                                                echo '  <ol>';
                                                $no = 1;
                                                $query = mysqli_query($Conn, "SELECT * FROM riwayat_penggunaan_obat WHERE id_kunjungan='$id_kunjungan' ORDER BY id_riwayat_penggunaan_obat ASC");
                                                while ($data = mysqli_fetch_array($query)) {
                                                    $id_riwayat_penggunaan_obat= $data['id_riwayat_penggunaan_obat'];
                                                    $id_obat= $data['id_obat'];
                                                    $nama_obat= $data['nama_obat'];
                                                    $waktu_penggunaan= $data['waktu_penggunaan'];
                                                    //Json Decode
                                                    $JsonObat=json_decode($nama_obat, true);
                                                    //Buka Obat
                                                    $NamaObat=$JsonObat['nama_obat'];
                                                    $Sediaan=$JsonObat['sediaan'];
                                                    $dosis=$JsonObat['dosis'];
                                                    $aturan_pakai=$JsonObat['aturan_pakai'];
                                                    $WaktuPenggunaan=$JsonObat['waktu_penggunaan'];
                                                    //Format Tanggal
                                                    $strtotime2=strtotime($waktu_penggunaan);
                                                    $FormatWaktuPenggunaan=date('d/m/Y H:i T',$strtotime2);
                                                    echo '<li> '.$FormatWaktuPenggunaan.' :<code class="text-secondary">'.$NamaObat.', Sediaan: '.$Sediaan.', Dosis: '.$dosis.', Aturan: '.$aturan_pakai.'</code></li>';
                                                }
                                                echo '  </ol>';
                                            }
                                            echo '</div>';
                                        }else{
                                            if($Lampiran['lampiran']=="laboratorium"){
                                                //LABORATORIUM
                                                $id_rincian_lab=getDataDetail($Conn,"laboratorium_rincian",'id_kunjungan',$id_kunjungan,'id_rincian_lab');
                                                echo '<div class="col-md-12">';
                                                echo '  <span>J.'.$no_lampiran.' Pemeriksaan Laboratorium</span>';
                                                if(empty($id_rincian_lab)){
                                                    echo '<span class="text-danger">Belum Ada Hasil Ringkasan Laboratorium</span>';
                                                }else{
                                                    echo '  <ol>';
                                                    $no = 1;
                                                    $query = mysqli_query($Conn, "SELECT * FROM laboratorium_rincian WHERE id_kunjungan='$id_kunjungan' ORDER BY id_rincian_lab ASC");
                                                    while ($data = mysqli_fetch_array($query)) {
                                                        $id_rincian_lab= $data['id_rincian_lab'];
                                                        $parameter= $data['parameter'];
                                                        $kategori_parameter= $data['kategori_parameter'];
                                                        $hasil= $data['hasil'];
                                                        $interpertasi= $data['interpertasi'];
                                                        $keterangan= $data['keterangan'];
                                                        echo '<li> '.$parameter.' :<code class="text-secondary">'.$hasil.' ('.$interpertasi.'), Ket: '.$keterangan.'</code></li>';
                                                    }
                                                    echo '  </ol>';
                                                }
                                                echo '</div>';
                                            }else{
                                                if($Lampiran['lampiran']=="radiologi"){
                                                    //LAMPIRAN RADIOLOGI
                                                    $id_rad=getDataDetail($Conn,"radiologi",'id_kunjungan',$id_kunjungan,'id_rad');
                                                    echo '<div class="col-md-12">';
                                                    echo '  <span>J.'.$no_lampiran.' Radiologi</span>';
                                                    if(empty($id_rad)){
                                                        echo '<p class="text-danger">Belum Ada Data Pemeriksaan Radiologi</p>';
                                                    }else{
                                                        echo '  <ol>';
                                                        $no = 1;
                                                        $query = mysqli_query($Conn, "SELECT * FROM radiologi WHERE id_kunjungan='$id_kunjungan' ORDER BY id_rad ASC");
                                                        while ($data = mysqli_fetch_array($query)) {
                                                            $id_rad= $data['id_rad'];
                                                            $asal_kiriman= $data['asal_kiriman'];
                                                            $permintaan_pemeriksaan= $data['permintaan_pemeriksaan'];
                                                            echo '<li>ID.Radiologi : <code class="text-secondary">'.$id_rad.'</code></li>';
                                                            echo '<li>Asal Kiriman : <code class="text-secondary">'.$asal_kiriman.'</code></li>';
                                                            echo '<li>Permintaan Pemeriksaan : <code class="text-secondary">'.$permintaan_pemeriksaan.'</code></li>';
                                                            echo '<li>';
                                                            echo '  Hasil Pemeriksaan:';
                                                            echo '  <ol>';
                                                            $query_rad = mysqli_query($Conn, "SELECT * FROM radiologi_rincian WHERE id_rad='$id_rad' ORDER BY id_rad ASC");
                                                            while ($data_rad = mysqli_fetch_array($query_rad)) {
                                                                $kategori= $data_rad['kategori'];
                                                                $pemeriksaan= $data_rad['pemeriksaan'];
                                                                $hasil= $data_rad['hasil'];
                                                                $keterangan= $data_rad['keterangan'];
                                                                echo '<li>'.$pemeriksaan.' : <code class="text-secondary">'.$hasil.'</code></li>';
                                                            }
                                                            echo '  </ol>';
                                                            echo '</li>';
                                                        }
                                                        echo '  </ol>';
                                                    }
                                                    echo '</div>';
                                                }else{
                                                    if($Lampiran['lampiran']=="konsultasi"){
                                                        //LAMPIRAN KONSULTASI
                                                        $id_konsultasi=getDataDetail($Conn,"konsultasi",'id_kunjungan',$id_kunjungan,'id_konsultasi');
                                                        echo '<div class="col-md-12">';
                                                        echo '  <span>J.'.$no_lampiran.' Konsultasi</span>';
                                                        if(empty($id_konsultasi)){
                                                            echo '<p class="text-danger">Belum Ada Data Konsultasi</p>';
                                                        }else{
                                                            echo '  <ol>';
                                                            $no = 1;
                                                            $query = mysqli_query($Conn, "SELECT * FROM konsultasi WHERE id_kunjungan='$id_kunjungan' ORDER BY id_konsultasi ASC");
                                                            while ($data = mysqli_fetch_array($query)) {
                                                                $id_konsultasi= $data['id_konsultasi'];
                                                                $tanggal_permintaan= $data['tanggal_permintaan'];
                                                                $tanggal_jawaban= $data['tanggal_jawaban'];
                                                                $dokter_asal= $data['dokter_asal'];
                                                                $dokter_tujuan= $data['dokter_tujuan'];
                                                                $permintaan_konsultasi= $data['permintaan_konsultasi'];
                                                                $jawaban_konsultasi= $data['jawaban_konsultasi'];
                                                                $status_konsultasi= $data['status_konsultasi'];
                                                                //Json Decode
                                                                $JsonDokterAsal=json_decode($dokter_asal, true);
                                                                $JsonDokterTujuan=json_decode($dokter_tujuan, true);
                                                                //Buka Dokter Asal
                                                                $IdUnitAsal=$JsonDokterAsal['unit']['id_unit'];
                                                                $NamaUnitAsal=$JsonDokterAsal['unit']['nama'];
                                                                $IdDokterAsal=$JsonDokterAsal['id_dokter'];
                                                                $NamaDokterAsal=$JsonDokterAsal['nama'];
                                                                //Buka Dokter Tujuan
                                                                $IdUnitTujuan=$JsonDokterTujuan['unit']['id_unit'];
                                                                $NamaUnitTujuan=$JsonDokterTujuan['unit']['nama'];
                                                                $IdDokterTujuan=$JsonDokterTujuan['id_dokter'];
                                                                $NamaDokterTujuan=$JsonDokterTujuan['nama'];
                                                                //Format Tanggal
                                                                $strtotime1=strtotime($tanggal_entry);
                                                                $strtotime2=strtotime($tanggal_permintaan);
                                                                $strtotime3=strtotime($tanggal_jawaban);
                                                                $FormatTanggalEntry=date('d/m/Y H:i T',$strtotime1);
                                                                $FormatTanggalPermintaan=date('d/m/Y H:i T',$strtotime2);
                                                                $FormatTanggalJawaban=date('d/m/Y H:i T',$strtotime3);
                                                                //Buka Permintaan Konsultasi
                                                                if(!empty($data['permintaan_konsultasi'])){
                                                                    $permintaan_konsultasi=$data['permintaan_konsultasi'];
                                                                    $JsonPermintaanKonsultasi=json_decode($permintaan_konsultasi, true);
                                                                    $diagnosa_kerja=$JsonPermintaanKonsultasi['diagnosa_kerja'];
                                                                    $ikhtisar_klinis=$JsonPermintaanKonsultasi['ikhtisar_klinis'];
                                                                    $konsul_diminta=$JsonPermintaanKonsultasi['konsul_diminta'];
                                                                }else{
                                                                    $permintaan_konsultasi="";
                                                                    $diagnosa_kerja="";
                                                                    $ikhtisar_klinis="";
                                                                    $konsul_diminta="";
                                                                }
                                                                //Buka Jawaban Konsultasi
                                                                if(!empty($data['jawaban_konsultasi'])){
                                                                    $jawaban_konsultasi= $data['jawaban_konsultasi'];
                                                                    $JsonJawabanKonsultasi=json_decode($jawaban_konsultasi, true);
                                                                    $penemuan=$JsonJawabanKonsultasi['penemuan'];
                                                                    $diagnosa=$JsonJawabanKonsultasi['diagnosa'];
                                                                    $saran=$JsonJawabanKonsultasi['saran'];
                                                                }else{
                                                                    $penemuan="";
                                                                    $diagnosa="";
                                                                    $saran="";
                                                                }
                                                                echo '<li>';
                                                                echo ' ID.Konsultasi : <code class="text-secondary">'.$id_konsultasi.'</code>';
                                                                echo '  <ol>';
                                                                echo '      <li>Tgl/Jam Entry : <code class="text-secondary">'.$FormatTanggalEntry.'</code></li>';
                                                                echo '      <li>Tgl/Jam Permintaan Konsultasi : <code class="text-secondary">'.$FormatTanggalPermintaan.'</code></li>';
                                                                echo '      <li>Tgl/Jam Jawaban : <code class="text-secondary">'.$FormatTanggalJawaban.'</code></li>';
                                                                echo '      <li>Status Konsultasi : <code class="text-secondary">'.$status_konsultasi.'</code></li>';
                                                                echo '      <li>Asal Permintaan Konsultasi : <code class="text-secondary">'.$NamaUnitAsal.' ('.$NamaDokterAsal.')</code></li>';
                                                                echo '      <li>Tujuan Permintaan : <code class="text-secondary">'.$NamaUnitTujuan.' ('.$NamaDokterTujuan.')</code></li>';
                                                                echo '      <li>';
                                                                echo '          Permintaan Konsultasi';
                                                                echo '          <ol>';
                                                                echo '              <li>Diagnosa Kerja : <code class="text-secondary">'.$diagnosa_kerja.'</code></li>';
                                                                echo '              <li>Ikhtisar Klinis : <code class="text-secondary">'.$ikhtisar_klinis.'</code></li>';
                                                                echo '              <li>Konsul yang Diminta : <code class="text-secondary">'.$konsul_diminta.'</code></li>';
                                                                echo '          </ol>';
                                                                echo '      </li>';
                                                                echo '      <li>';
                                                                echo '          Jawaban Konsultasi';
                                                                echo '          <ol>';
                                                                echo '              <li>Penemuan : <code class="text-secondary">'.$penemuan.'</code></li>';
                                                                echo '              <li>Diagnosa : <code class="text-secondary">'.$diagnosa.'</code></li>';
                                                                echo '              <li>Saran : <code class="text-secondary">'.$saran.'</code></li>';
                                                                echo '          </ol>';
                                                                echo '      </li>';
                                                                echo '  </ol>';
                                                                echo '</li>';
                                                            }
                                                            echo '  </ol>';
                                                        }
                                                        echo '</div>';
                                                    }else{
                                                        
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $no_lampiran++;
                }
            }
            echo '</>';
        }
    }
?>

<script>
    //Ketika TTD Petugas Entry Resume Di Click
    $('#AddTtdPetugasEntryResume').click(function(){
        $('#FormTtdPetugasEntryResume').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormTtdPetugasEntryResume.php',
            data        : {id_kunjungan: GetIdKunjunganResume},
            success     : function(data){
                $('#FormTtdPetugasEntryResume').html(data);
            }
        });
    });
    //Ketika TTD Dokter Resume Di Click
    $('#AddTtdDokterResume').click(function(){
        $('#FormTtdDokterResume').html("Loading...");
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/RawatJalan/FormTtdDokterResume.php',
            data        : {id_kunjungan: GetIdKunjunganResume},
            success     : function(data){
                $('#FormTtdDokterResume').html(data);
            }
        });
    });
</script>