<?php 
    include "_Config/SimrsFunction.php";
    if(empty($_GET['id'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <div class="card">';
        echo '          <div class="card-body text-center text-danger">';
        echo '              ID Operasi Tidak Boleh Kosong';
        echo '          </div>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_operasi=$_GET['id'];
        $id_operasi=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'id_operasi');
        if(empty($id_operasi)){
            echo '<div class="row">';
            echo '  <div class="col-md-12">';
            echo '      <div class="card">';
            echo '          <div class="card-body text-center text-danger">';
            echo '              ID Operasi Tidak Valid';
            echo '          </div>';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_pasien=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'id_pasien');
            $nama=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'nama');
            $nopeserta=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'nopeserta');
            $tanggal_daftar=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'tanggal_daftar');
            $jam_daftar=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'jam_daftar');
            $tanggaloperasi=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'tanggaloperasi');
            $jamoperasi=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'jamoperasi');
            $jenistindakan=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'jenistindakan');
            $kodepoli=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'kodepoli');
            $namapoli=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'namapoli');
            $keterangan=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'keterangan');
            $terlaksana=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'terlaksana');
            $kodebooking=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'kodebooking');
            $lastupdate=getDataDetail($Conn,'jadwal_operasi','id_operasi',$id_operasi,'lastupdate');
            //Format Waktu
            $TanggalWaktuDaftar="$tanggal_daftar $jam_daftar";
            $TanggalWaktuOperasi="$tanggaloperasi $jamoperasi";
            //Strtotime
            $strtotime1=strtotime($TanggalWaktuDaftar);
            $strtotime2=strtotime($TanggalWaktuOperasi);
            $strtotime3=strtotime($lastupdate);
            $TanggalWaktuDaftar=date('d/m/Y',$strtotime1);
            $TanggalWaktuOperasi=date('d/m/Y',$strtotime2);
            $LastUpdate=date('d/m/Y H:i',$strtotime3);
            //Routing Terlaksana
            if($terlaksana==1){
                $label_terlaksana='<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdateStatusJadwal" data-id="'.$id_operasi.'"><code class="text-success">Terlaksana <i class="ti ti-new-window"></i></code></a>';
            }else{
                $label_terlaksana='<a href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdateStatusJadwal" data-id="'.$id_operasi.'"><code class="text-danger">Belum/Tidak Terlaksana <i class="ti ti-new-window"></i></code></a>';
            }
            //Buka Data Lampiran
            $IdRincianLaporanOperasi=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'id_operasi');
            if(empty($IdRincianLaporanOperasi)){
                $LabelRincianOperasi='<code class="text-danger">Laporan Tidak Tersedia</code>';
            }else{
                $LabelRincianOperasi='<code class="text-success">Laporan Tersedia</code>';
            }
?>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 text-center mb-3">
                            <h4><i class="ti ti-info-alt"></i> Detail Jadwal Operasi</h4>
                        </div>
                        <div class="col-md-12 text-center mb-3">
                            <a href="index.php?Page=JadwalOperasi" class="btn btn-sm btn-dark btn-round btn-block">
                                <i class="ti ti-angle-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ol>
                                <li class="mb-3">ID.Jadwal : <code class="text-dark"><?php echo "$id_operasi"; ?></code></li>
                                <li class="mb-3">Kode Booking : <code class="text-dark"><?php echo "$kodebooking"; ?></code></li>
                                <li class="mb-3">
                                    No.RM : 
                                    <code class="text-primary">
                                        <a href="javascript:void(0);"class="text-primary" data-toggle="modal" data-target="#ModalDetailPasien" data-id="<?php echo "$id_pasien"; ?>">
                                            <?php echo "$id_pasien"; ?> <i class="ti ti-new-window"></i>
                                        </a>
                                    </code>
                                </li>
                                <li class="mb-3">Nama Pasien : <code class="text-dark"><?php echo "$nama"; ?></code></li>
                                <li class="mb-3">No.BPJS : <code class="text-dark"><?php echo "$nopeserta"; ?></code></li>
                                <li class="mb-3">Tgl.Daftar : <code class="text-dark"><?php echo "$TanggalWaktuDaftar"; ?></code></li>
                                <li class="mb-3">Tgl.Operasi : <code class="text-dark"><?php echo "$TanggalWaktuOperasi"; ?></code></li>
                                <li class="mb-3">Updatetime : <code class="text-dark"><?php echo "$LastUpdate"; ?></code></li>
                                <li class="mb-3">Jenis Tindakan : <code class="text-dark"><?php echo "$jenistindakan"; ?></code></li>
                                <li class="mb-3">Kode Poli : <code class="text-dark"><?php echo "$kodepoli"; ?></code></li>
                                <li class="mb-3">Nama Poli : <code class="text-dark"><?php echo "$namapoli"; ?></code></li>
                                <li class="mb-3">Keterangan : <code class="text-dark"><?php echo "$keterangan"; ?></code></li>
                                <li class="mb-3">Terlaksana : <?php echo "$label_terlaksana"; ?></li>
                                <li class="mb-3">Laporan : <?php echo "$LabelRincianOperasi"; ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row mb-2"> 
                        <div class="col-md-6 mb-3">
                            <button type="button" class="btn btn-sm btn-outline-success btn-round btn-block" data-toggle="modal" data-target="#ModalEditJadwalOperasi" data-id="<?php echo "$id_operasi"; ?>">
                                <i class="ti ti-pencil-alt"></i> Edit 
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="button" class="btn btn-sm btn-outline-danger btn-round btn-block" data-toggle="modal" data-target="#ModalHapusJadwalOperasi" data-id="<?php echo "$id_operasi"; ?>">
                                <i class="ti ti-trash"></i> Hapus 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-12 text-center mb-3">
                            <h4><i class="icofont-ui-note"></i> Laporan Operasi</h4>
                        </div>
                        <div class="col-md-12 text-center mb-3">
                            <button type="button" class="btn btn-sm btn-block btn-info btn-round" data-toggle="modal" data-target="#ModalLaporanOperasi" data-id="<?php echo "$id_operasi"; ?>">
                                Selengkapnya <i class="ti ti-more-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?php
                    $id_laporan_operasi=getDataDetail($Conn,'operasi','id_jadwal_operasi',$id_operasi,'id_operasi');
                    if(empty($id_laporan_operasi)){ 
                        echo '<div class="card-body">';
                        echo '  <div class="row">';
                        echo '      <div class="col-md-12 mb-3 text-center text-danger">';
                        echo '          Belum ada hasil laporan operasi untuk jadwal ini.<br>';
                        echo '          Pengisian laporan operasi hanya dilakukan pada data kunjungan (encounter) pasien.<br>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</div>';
                    }else{
                        $id_jadwal_operasi=getDataDetail($Conn,'operasi','id_jadwal_operasi',$id_operasi,'id_jadwal_operasi');
                        $id_kunjungan=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'id_kunjungan');
                        $id_pasien=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'id_pasien');
                        $id_akses=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'id_akses');
                        $tanggal_entry=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'tanggal_entry');
                        $tanggal_mulai=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'tanggal_mulai');
                        $tanggal_selesai=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'tanggal_selesai');
                        $petugas_entry=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'petugas_entry');
                        $pelaksana=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'pelaksana');
                        $diagnosa_operasi=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'diagnosa_operasi');
                        $body_site=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'body_site');
                        $tindakan_operasi=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'tindakan_operasi');
                        $instrumen=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'instrumen');
                        $keterangan_dokter=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'keterangan_dokter');
                        $anastesi=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'anastesi');
                        $persetujuan=getDataDetail($Conn,"operasi",'id_jadwal_operasi',$id_operasi,'persetujuan');
                        //Nama
                        $nama_pasien=getDataDetail($Conn,"pasien",'id_pasien',$id_pasien,'nama');
                        //Format Tanggal
                        $strtotime1=strtotime($tanggal_entry);
                        $strtotime2=strtotime($tanggal_mulai);
                        $strtotime3=strtotime($tanggal_selesai);
                        $TanggalEntry=date('d/m/Y H:i T',$strtotime1);
                        $TanggalMulai=date('d/m/Y H:i T',$strtotime2);
                        $TanggalSelesai=date('d/m/Y H:i T',$strtotime3);
                        //Buka Data Anastesi
                        if(!empty($anastesi)){
                            $JsonAnastesi =json_decode($anastesi, true);
                            $durasi=$JsonAnastesi['durasi'];
                            $diagnosis_kerja=$JsonAnastesi['diagnosis_kerja'];
                            $diagnosis_banding=$JsonAnastesi['diagnosis_banding'];
                            $tindakan=$JsonAnastesi['tindakan'];
                            $tata_cara=$JsonAnastesi['tata_cara'];
                            $tujuan=$JsonAnastesi['tujuan'];
                            $resiko=$JsonAnastesi['resiko'];
                            $komplikasi=$JsonAnastesi['komplikasi'];
                            $prognosis=$JsonAnastesi['prognosis'];
                            $alternatif=$JsonAnastesi['alternatif'];
                            $lainnya=$JsonAnastesi['lainnya'];
                        }else{
                            $durasi="";
                            $diagnosis_kerja="";
                            $diagnosis_banding="";
                            $tindakan="";
                            $tata_cara="";
                            $tujuan="";
                            $resiko="";
                            $komplikasi="";
                            $prognosis="";
                            $alternatif="";
                            $lainnya="";
                        }
                        
                        //Definisi
                        $DefinisiTataCara = array(
                            '1' => 'Obat disuntikan ke pembuluh darah, dihirup melalui paru-paru, atau dengan cara lain dan dilakukan pemasangan alat bantu nafas.',
                            '2' => 'Obat disuntikan melalui jarum atau kateter yang ditempatkan ke dalam rongga sumsum tulang belakang atau rongga didekatnya.',
                            '3' => 'Obat disuntikan ke jaringan sekitar saraf melalui kulit.',
                        );
                        $DefinisiTujuan = array(
                            '1' => 'Menghilangkan kesadaran selama tindakan pembedahan.',
                            '2' => 'Menghilangkan rasa nyeri selama tindakan pembedahan.',
                            '3' => 'Memberikan efek mati rasa sementara di daerah perut sampai ujung kaki.',
                            '4' => 'Memberikan efek mati rasa di sekitar daerah operasi',
                            '5' => 'Mengurangi kecemasan',
                        );
                        $DefinisiResiko = array(
                            '1' => 'Nyeri tenggorokan',
                            '2' => 'Suara serak/batuk',
                            '3' => 'Mual-mual',
                            '4' => 'Aspirasi',
                            '5' => 'Sumbatan Jalan Nafas',
                            '6' => 'Trauma pada mulut, daerah mata dan gigi',
                            '7' => 'Obat bius masuk ke alirah darah janin',
                            '8' => 'Gangguan pernafasan ringan sampe berat dan reaksi alergi',
                            '9' => 'Infeksi',
                            '10' => 'Kejang jalan nafas',
                            '11' => 'Hematoma',
                            '12' => 'Penurunan tekanan darah',
                            '13' => 'Peningkatan tekanan darah',
                            '14' => 'Nyeri ditempat suntikan',
                        );
                        $DefinisiKomplikasi = array(
                            '1' => 'Menghilangkan kesadaran selama tindakan pembedahan.',
                            '2' => 'Menghilangkan rasa nyeri selama tindakan pembedahan.',
                            '3' => 'Memberikan efek mati rasa sementara di daerah perut sampai ujung kaki.',
                            '4' => ' Memberikan efek mati rasa di sekitar daerah operasi',
                            '5' => 'Mengurangi kecemasan',
                            '6' => 'Infeksi saluran nafas berat-ringan',
                            '7' => 'Gangguan irama jantung',
                            '8' => 'Gagal Jantung',
                            '9' => 'Abses',
                            '10' => 'Kejang',
                        );
                        //Buka Persetujuan
                        if(!empty($persetujuan)){
                            $JsonPersetujuan =json_decode($persetujuan, true);
                            $HubunganDenganPasien=$JsonPersetujuan['hubungan'];
                            $NamaPenanggungjawab=$JsonPersetujuan['nama'];
                            $KontakPenanggungjawab=$JsonPersetujuan['kontak'];
                            $KategoriIdentitasPenanggungjawab=$JsonPersetujuan['kategori_identitas'];
                            $NomorIdentitasPenanggungjawab=$JsonPersetujuan['nomor_identitas'];
                            $TtdPenanggungJawab=$JsonPersetujuan['ttd'];
                            if(empty($TtdPenanggungJawab)){
                                $LabelTtd='<a href="javascript:void(0);" id="AddTtdPenanggungJawabOperasi" class="text-danger" value="'.$id_kunjungan.'">Belum Ada <i class="ti ti-pencil"></i></a>';
                            }else{
                                $LabelTtd='<br><img src="data:image/gif;base64,'. $TtdPenanggungJawab .'" width="150px">';            
                            }
                        }else{
                            $HubunganDenganPasien="";
                            $NamaPenanggungjawab="";
                            $KontakPenanggungjawab="";
                            $KategoriIdentitasPenanggungjawab="";
                            $NomorIdentitasPenanggungjawab="";
                            $TtdPenanggungJawab="";
                            $LabelTtd="";
                        }
                        //Menampilkan Data
                        echo '<div class="card-body">';
                        echo '<div class="row sub-title">';
                        echo '  <div class="col-md-12">';
                        echo '      <dt>A. Informasi Umum</dt>';
                        echo '      <ol>';
                        echo '          <li>No.RM : <code class="text-secondary">'.$id_pasien.'</code></li>';
                        echo '          <li>ID.Kunjungan : <code class="text-secondary" id="PutIdKunjunganOperasi">'.$id_kunjungan.'</code></li>';
                        echo '          <li>ID.Operasi : <code class="text-secondary">'.$id_operasi.'</code></li>';
                        echo '          <li>ID.Jadwal Operasi : <code class="text-secondary">'.$id_jadwal_operasi.'</code></li>';
                        echo '          <li>Nama Pasien : <code class="text-secondary">'.$nama_pasien.'</code></li>';
                        echo '          <li>Tgl/Jam Entry : <code class="text-secondary">'.$TanggalEntry.'</code></li>';
                        echo '          <li>Tgl/Jam Mulasi : <code class="text-secondary">'.$TanggalMulai.'</code></li>';
                        echo '          <li>Tgl/Jam Selesai : <code class="text-secondary">'.$TanggalSelesai.'</code></li>';
                        echo '          <li>Petugas Entry : <code class="text-secondary">'.$petugas_entry.'</code></li>';
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row sub-title">';
                        echo '  <div class="col-md-12">';
                        echo '      <dt>B. Anastesi</dt>';
                        echo '      <ol>';
                        echo '          <li>Durasi Anastesi : <code class="text-secondary">'.$durasi.'</code></li>';
                        echo '          <li>Diagnosis Kerja : <code class="text-secondary">'.$diagnosis_kerja.'</code></li>';
                        echo '          <li>Diagnosis Banding : <code class="text-secondary">'.$diagnosis_banding.'</code></li>';
                        echo '          <li>';
                        echo '              Tindakan : ';
                        echo '              <code class="text-secondary">';
                        echo '                  <ol>';
                                                    if(!empty($tindakan)){
                                                        foreach($tindakan as $ListTindakan){
                                                            $List=$ListTindakan['tindakan_anastesi'];
                                                            echo '<li>'.$List.'</li>';
                                                        }
                                                    }
                        echo '                  </ol>';
                        echo '              </code>';
                        echo '          </li>';
                        echo '          <li>';
                        echo '              Tata Cara : ';
                        echo '              <code class="text-secondary">';
                        echo '                  <ol>';
                                                    if(!empty($tata_cara)){
                                                        foreach($tata_cara as $ListTataCara){
                                                            $List=$ListTataCara['tata_cara'];
                                                            $DefinisiList=$DefinisiTataCara[$List];
                                                            echo '<li>'.$DefinisiList.'</li>';
                                                        }
                                                    }
                        echo '                  </ol>';
                        echo '              </code>';
                        echo '          </li>';
                        echo '          <li>';
                        echo '              Tujuan : ';
                        echo '              <code class="text-secondary">';
                        echo '                  <ol>';
                                                    if(!empty($tujuan)){
                                                        foreach($tujuan as $ListTujuan){
                                                            $List=$ListTujuan['tujuan_anastesi'];
                                                            $DefinisiList=$DefinisiTujuan[$List];
                                                            echo '<li>'.$DefinisiList.'</li>';
                                                        }
                                                    }
                        echo '                  </ol>';
                        echo '              </code>';
                        echo '          </li>';
                        echo '          <li>';
                        echo '              Resiko : ';
                        echo '              <code class="text-secondary">';
                        echo '                  <ol>';
                                                    if(!empty($resiko)){
                                                        foreach($resiko as $ListResiko){
                                                            $List=$ListResiko['resiko_tindakan'];
                                                            $DefinisiList=$DefinisiResiko[$List];
                                                            echo '<li>'.$DefinisiList.'</li>';
                                                        }
                                                    }
                        echo '                  </ol>';
                        echo '              </code>';
                        echo '          </li>';
                        echo '          <li>';
                        echo '              Komplikasi : ';
                        echo '              <code class="text-secondary">';
                        echo '                  <ol>';
                                                    if(!empty($komplikasi)){
                                                        foreach($komplikasi as $ListKomplikasi){
                                                            $List=$ListKomplikasi['komplikasi'];
                                                            $DefinisiList=$DefinisiKomplikasi[$List];
                                                            echo '<li>'.$DefinisiList.'</li>';
                                                        }
                                                    }
                        echo '                  </ol>';
                        echo '              </code>';
                        echo '          </li>';
                        echo '          <li>Prognosis : <code class="text-secondary">'.$prognosis.'</code></li>';
                        echo '          <li>Alternatif : <code class="text-secondary">'.$alternatif.'</code></li>';
                        echo '          <li>Lain-Lain : <code class="text-secondary">'.$lainnya.'</code></li>';
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row sub-title">';
                        echo '  <div class="col-md-12">';
                        echo '      <dt>C. Persetujuan Tindakan Operasi</dt>';
                        echo '      <ol>';
                        echo '          <li>Hubungan Dengan Pasien : <code class="text-secondary">'.$HubunganDenganPasien.'</code></li>';
                        echo '          <li>Nama : <code class="text-secondary">'.$NamaPenanggungjawab.'</code></li>';
                        echo '          <li>Kontak : <code class="text-secondary">'.$KontakPenanggungjawab.'</code></li>';
                        echo '          <li>Kategori Identitas : <code class="text-secondary">'.$KategoriIdentitasPenanggungjawab.'</code></li>';
                        echo '          <li>Nomor Identitas : <code class="text-secondary">'.$NomorIdentitasPenanggungjawab.'</code></li>';
                        echo '          <li>TTD : <code class="text-secondary">'.$LabelTtd.'</code><div id="FormTtdPenanggungJawab"></div</li>';
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row sub-title">';
                        echo '  <div class="col-md-12">';
                        echo '      <dt>D. Diagnosa Operasi</dt>';
                        echo '      <ol>';
                        if(!empty($diagnosa_operasi)){
                            $JsonDiagnosaOperasi =json_decode($diagnosa_operasi, true);
                            foreach($JsonDiagnosaOperasi as $ListDiagnosaOperasi){
                                $KategoriDiagnosaOperasi=$ListDiagnosaOperasi['kategori'];
                                $KodeDiagnosaOperasi=$ListDiagnosaOperasi['kode'];
                                $DeskripsiDiagnosaOperasi=$ListDiagnosaOperasi['deskripsi'];
                                echo '<li class="mb-3">';
                                echo '  <dt>'.$KategoriDiagnosaOperasi.'</dt>';
                                echo '  <ul>';
                                echo '      <li>Kode : <code class="text-secondary">'.$KodeDiagnosaOperasi.'</code></li>';
                                echo '      <li>Deskripsi : <code class="text-secondary">'.$DeskripsiDiagnosaOperasi.'</code></li>';
                                echo '  </ul>';
                                echo '</li>';
                            }
                        }
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row sub-title">';
                        echo '  <div class="col-md-12">';
                        echo '      <dt>E. Body Site</dt>';
                        echo '      <ol>';
                        if(!empty($body_site)){
                            $JsonBodySite =json_decode($body_site, true);
                            foreach($JsonBodySite as $ListBodySite){
                                $BodySite=$ListBodySite['body_site'];
                                $KeteranganBodySite=$ListBodySite['keterangan'];
                                echo '<li class="mb-3">';
                                echo '  <span class="text-dark">'.$BodySite.'</span><br>';
                                echo '  <code class="text-secondary">'.$KeteranganBodySite.'</code>';
                                echo '</li>';
                            }
                        }
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row sub-title">';
                        echo '  <div class="col-md-12">';
                        echo '      <dt>F. Tindakan Operasi</dt>';
                        echo '      <ol>';
                        if(!empty($tindakan_operasi)){
                            $JsonTindakanOperasi =json_decode($tindakan_operasi, true);
                            foreach($JsonTindakanOperasi as $ListTindakanOperasi){
                                $KodeTindakanOperasi=$ListTindakanOperasi['kode'];
                                $DeskripsiTindakanOperasi=$ListTindakanOperasi['deskripsi'];
                                echo '<li><code class="text-secondary">('.$KodeTindakanOperasi.') '.$DeskripsiTindakanOperasi.'</code></li>';
                            }
                        }
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row sub-title">';
                        echo '  <div class="col-md-12">';
                        echo '      <dt>G. Instrumen Operasi</dt>';
                        echo '      <ol>';
                        if(!empty($instrumen)){
                            $JsonInstrumen =json_decode($instrumen, true);
                            foreach($JsonInstrumen as $ListInstrumenOperasi){
                                $InstrumenOperasi=$ListInstrumenOperasi['instrumen'];
                                echo '<li><code class="text-secondary">'.$InstrumenOperasi.'</code></li>';
                            }
                        }
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row sub-title">';
                        echo '  <div class="col-md-12">';
                        echo '      <dt>H. Tenaga Kesehatan</dt>';
                        echo '      <ol>';
                                    if(!empty($pelaksana)){
                                        $JsonPelaksana =json_decode($pelaksana, true);
                                        foreach($JsonPelaksana as $ListPelaksana){
                                            $id_nakes_operasi=$ListPelaksana['id_nakes_operasi'];
                                            $kategori=$ListPelaksana['kategori'];
                                            $nama=$ListPelaksana['nama'];
                                            $sip=$ListPelaksana['sip'];
                                            $kontak=$ListPelaksana['kontak'];
                                            $kategori_identitas=$ListPelaksana['kategori_identitas'];
                                            $nomor_identitas=$ListPelaksana['nomor_identitas'];
                                            $TtdNakes=$ListPelaksana['ttd'];
                                            if(empty($TtdNakes)){
                                                $LabelTtdNakes='<a href="javascript:void(0);" id="AddTtdNakesOperasi'.$id_nakes_operasi.'" class="AddTtdNakesOperasi" value="'.$id_nakes_operasi.'"><span class="text-danger">Belum Ada <i class="ti ti-pencil"></span></i></a>';
                                            }else{
                                                $LabelTtdNakes='<br><img src="data:image/gif;base64,'. $TtdNakes .'" width="150px">';            
                                            }
                                            echo '<li class="mb-3">';
                                            echo '  <dt>ID. '.$id_nakes_operasi.'</dt>';
                                            echo '  <ul>';
                                            echo '      <li>Kategori : <code class="text-secondary">'.$kategori.'</code></li>';
                                            echo '      <li>Nama : <code class="text-secondary">'.$nama.'</code></li>';
                                            echo '      <li>SIP : <code class="text-secondary">'.$sip.'</code></li>';
                                            echo '      <li>Kontak : <code class="text-secondary">'.$kontak.'</code></li>';
                                            echo '      <li>Identitas : <code class="text-secondary">('.$kategori_identitas.') '.$nomor_identitas.'</code></li>';
                                            echo '      <li>TTD : <code class="text-secondary">'.$LabelTtdNakes.'</code><div id="FormTtdNakesOperasi'.$id_nakes_operasi.'"></div></li>';
                                            echo '  </ul>';
                                            echo '</li>';
                                        }
                                    }
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                        echo '<div class="row sub-title">';
                        echo '  <div class="col-md-12">';
                        echo '      <dt>I. Keterangan/Catatan Dokter</dt>';
                        echo '      <ol>';
                        if(!empty($keterangan_dokter)){
                            $JsonKeteranganDokter =json_decode($keterangan_dokter, true);
                            foreach($JsonKeteranganDokter as $ListKeteranganDokter){
                                $NamaDokterCatatan=$ListKeteranganDokter['dokter'];
                                $CatatanDokterCatatan=$ListKeteranganDokter['catatan'];
                                echo '<li class="mb-3">'.$NamaDokterCatatan.' <br><code class="text-secondary">'.$CatatanDokterCatatan.'</code></li>';
                            }
                        }
                        echo '      </ol>';
                        echo '  </div>';
                        echo '</div>';
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
    </div>
<?php }} ?>