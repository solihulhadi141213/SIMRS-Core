<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $tanggal=date('Y-m-d');
        $jam=date('H:i');
        $id_kunjungan=$_POST['id_kunjungan'];
        //Buka Detail Pasien
        $id_pasien=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'id_pasien');
        $nama=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'nama');
        $noRujukan=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'noRujukan');
        $rujukan_dari=getDataDetail($Conn,"kunjungan_utama",'id_kunjungan',$id_kunjungan,'rujukan_dari');
        $id_triase_igd=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'id_kunjungan');
        if(empty($id_triase_igd)){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          ID Triase IGD Tidak Valid!';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
            echo '      <i class="ti ti-close"></i> Tutup';
            echo '  </div>';
            echo '</div>';
        }else{
            //Membuka Detail Triase Dan IGD
            $id_pasien=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'id_pasien');
            $id_akses=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'id_akses');
            $tanggal=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'tanggal');
            $nama_pasien=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'nama_pasien');
            $nama_petugas=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'nama_petugas');
            $tanggal_jam_masuk=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'tanggal_jam_masuk');
            $triase_igd=getDataDetail($Conn,"triase_igd",'id_kunjungan',$id_kunjungan,'triase_igd');
            //Decode JSON
            $JsonTriaseIgd =json_decode($triase_igd, true);
            //Format Tanggal
            $strtotime=strtotime($tanggal);
            $FormatTanggal=date('Y-m-d', $strtotime);
            $FormatJam=date('H:i', $strtotime);
            //Format Tanggal Masuk
            $strtotime2=strtotime($tanggal_jam_masuk);
            $FormatTanggalMasuk=date('Y-m-d', $strtotime2);
            $FormatJamMasuk=date('H:i', $strtotime2);
            //Buka Petugas
            $sarana_transportasi=$JsonTriaseIgd['sarana_transportasi'];
            $surat_pengantar_rujukan=$JsonTriaseIgd['surat_pengantar_rujukan'];
            $kondisi_pasien_tiba=$JsonTriaseIgd['kondisi_pasien_tiba'];
            $pengantar_pasien=$JsonTriaseIgd['pengantar_pasien'];
            $asesmen_nyeri=$JsonTriaseIgd['asesmen_nyeri'];
            $kajian_resiko_jatuh=$JsonTriaseIgd['kajian_resiko_jatuh'];
            $kesadaran_pasien=$JsonTriaseIgd['kesadaran_pasien'];
            //Sarana Transportasi
            if(!empty($sarana_transportasi)){
                $KategoriSaranaTransportasi=$sarana_transportasi['kategori'];
                $KeteranganSaranaTransportasi=$sarana_transportasi['keterangan'];
            }else{
                $KategoriSaranaTransportasi="";
                $KeteranganSaranaTransportasi="";
            }
            //Surat Pengantar Rujukan
            if(!empty($surat_pengantar_rujukan)){
                $SuratRujukan=$surat_pengantar_rujukan['surat_rujukan'];
                $NomorSuratRujukan=$surat_pengantar_rujukan['no_surat_rujukan'];
                $AsalSuratRujukan=$surat_pengantar_rujukan['asal_rujukan'];
            }else{
                $SuratRujukan="";
                $NomorSuratRujukan="";
                $AsalSuratRujukan="";
            }
            //Kondisi Pasien Saat Tiba
            if(!empty($kondisi_pasien_tiba)){
                $kategori_kondisi_pasien=$kondisi_pasien_tiba['kategori_kondisi_pasien'];
                $penjelasan_kondisi_pasien=$kondisi_pasien_tiba['penjelasan_kondisi_pasien'];
            }else{
                $kategori_kondisi_pasien="";
                $penjelasan_kondisi_pasien="";
            }
            //Pengantar Pasien
            if(!empty($pengantar_pasien)){
                $nama_pengantar_pasien=$pengantar_pasien['nama_pengantar_pasien'];
                $kontak_pengantar_pasien=$pengantar_pasien['kontak_pengantar_pasien'];
            }else{
                $nama_pengantar_pasien="";
                $kontak_pengantar_pasien="";
            }
            //Assesmen Nyeri
            if(!empty($asesmen_nyeri)){
                $asesmen_nyeri_ada_tidak=$asesmen_nyeri['asesmen_nyeri'];
                $lokasi_nyeri=$asesmen_nyeri['lokasi_nyeri'];
                $penyebab_nyeri=$asesmen_nyeri['penyebab_nyeri'];
                $durasi_nyeri=$asesmen_nyeri['durasi_nyeri'];
                $frekuensi_nyeri=$asesmen_nyeri['frekuensi_nyeri'];
                $skala_vas=$asesmen_nyeri['skala_vas']['skor'];
                $skala_nrs=$asesmen_nyeri['skala_nrs']['skor'];
                $skala_vrs=$asesmen_nyeri['skala_vrs']['skor'];
                $skala_nips1=$asesmen_nyeri['skala_nips']['skala_nips1'];
                $skala_nips2=$asesmen_nyeri['skala_nips']['skala_nips2'];
                $skala_nips3=$asesmen_nyeri['skala_nips']['skala_nips3'];
                $skala_nips4=$asesmen_nyeri['skala_nips']['skala_nips4'];
                $skala_nips5=$asesmen_nyeri['skala_nips']['skala_nips5'];
                $skala_nips6=$asesmen_nyeri['skala_nips']['skala_nips6'];
                $skala_wbps=$asesmen_nyeri['skala_wbps']['skor'];
                $nakes_nyeri=$asesmen_nyeri['nakes_nyeri'];
            }else{
                $asesmen_nyeri_ada_tidak="";
                $lokasi_nyeri="";
                $lokasi_nyeri="";
                $penyebab_nyeri="";
                $durasi_nyeri="";
                $frekuensi_nyeri="";
                $skala_vas="0";
                $skala_nrs="0";
                $skala_vrs="0";
                $skala_nips1="";
                $skala_nips2="";
                $skala_nips3="";
                $skala_nips4="";
                $skala_nips5="";
                $skala_nips6="";
                $skala_wbps="";
                $nakes_nyeri="";
            }
            if(!empty($kajian_resiko_jatuh)){
                $pemeriksa=$kajian_resiko_jatuh['pemeriksa'];
                if(!empty($kajian_resiko_jatuh['mfs'])){
                    $skor_mfs=$kajian_resiko_jatuh['mfs']['skor'];
                    $kategori_mfs=$kajian_resiko_jatuh['mfs']['kategori'];
                    $mfs1=$kajian_resiko_jatuh['mfs']['mfs1'];
                    $mfs2=$kajian_resiko_jatuh['mfs']['mfs2'];
                    $mfs3=$kajian_resiko_jatuh['mfs']['mfs3'];
                    $mfs4=$kajian_resiko_jatuh['mfs']['mfs4'];
                    $mfs5=$kajian_resiko_jatuh['mfs']['mfs5'];
                    $mfs6=$kajian_resiko_jatuh['mfs']['mfs6'];
                }else{
                    $skor_mfs="";
                    $kategori_mfs="";
                    $mfs1="";
                    $mfs2="";
                    $mfs3="";
                    $mfs4="";
                    $mfs5="";
                    $mfs6="";
                }
                if(!empty($kajian_resiko_jatuh['hds'])){
                    $skor_hds=$kajian_resiko_jatuh['hds']['skor'];
                    $kategori_hds=$kajian_resiko_jatuh['hds']['kategori'];
                    $hds1=$kajian_resiko_jatuh['hds']['hds1'];
                    $hds2=$kajian_resiko_jatuh['hds']['hds2'];
                    $hds3=$kajian_resiko_jatuh['hds']['hds3'];
                    $hds4=$kajian_resiko_jatuh['hds']['hds4'];
                    $hds5=$kajian_resiko_jatuh['hds']['hds5'];
                    $hds6=$kajian_resiko_jatuh['hds']['hds6'];
                    $hds7=$kajian_resiko_jatuh['hds']['hds7'];
                }else{
                    $skor_hds="";
                    $kategori_hds="";
                    $hds1="";
                    $hds2="";
                    $hds3="";
                    $hds4="";
                    $hds5="";
                    $hds6="";
                    $hds7="";
                }
                if(!empty($kajian_resiko_jatuh['epfra'])){
                    $skor_epfra=$kajian_resiko_jatuh['epfra']['skor'];
                    $kategori_epfra=$kajian_resiko_jatuh['epfra']['kategori'];
                    $epfra1=$kajian_resiko_jatuh['epfra']['epfra1'];
                    $epfra2=$kajian_resiko_jatuh['epfra']['epfra2'];
                    $epfra3=$kajian_resiko_jatuh['epfra']['epfra3'];
                    $epfra4=$kajian_resiko_jatuh['epfra']['epfra4'];
                    $epfra5=$kajian_resiko_jatuh['epfra']['epfra5'];
                    $epfra6=$kajian_resiko_jatuh['epfra']['epfra6'];
                    $epfra7=$kajian_resiko_jatuh['epfra']['epfra7'];
                    $epfra8=$kajian_resiko_jatuh['epfra']['epfra8'];
                    $epfra9=$kajian_resiko_jatuh['epfra']['epfra9'];
                }else{
                    $skor_epfra="";
                    $kategori_epfra="";
                    $epfra1="";
                    $epfra2="";
                    $epfra3="";
                    $epfra4="";
                    $epfra5="";
                    $epfra6="";
                    $epfra7="";
                    $epfra8="";
                    $epfra9="";
                }
            }else{
                $pemeriksa="";
                $skor_mfs="";
                $kategori_mfs="";
                $mfs1="";
                $mfs2="";
                $mfs3="";
                $mfs4="";
                $mfs5="";
                $mfs6="";
                $skor_hds="";
                $kategori_hds="";
                $hds1="";
                $hds2="";
                $hds3="";
                $hds4="";
                $hds5="";
                $hds6="";
                $hds7="";
                $skor_epfra="";
                $kategori_epfra="";
                $epfra1="";
                $epfra2="";
                $epfra3="";
                $epfra4="";
                $epfra5="";
                $epfra6="";
                $epfra7="";
                $epfra8="";
                $epfra9="";
            }
?>
    <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>A. Informasi Pasien & Kunjungan</dt>
            </div>
            <div class="col-md-4 mb-2">A.1 ID.Kunjungan</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="id_kunjungan" id="id_kunjungan" class="form-control" value="<?php echo "$id_kunjungan"; ?>">
            </div>
            <div class="col-md-4 mb-2">A.2 No.RM</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="id_pasien" id="id_pasien" class="form-control" value="<?php echo "$id_pasien"; ?>">
            </div>
            <div class="col-md-4 mb-2">A.3 Nama Pasien</div>
            <div class="col-md-8 mb-2">
                <input type="text" readonly name="nama_pasien" id="nama_pasien" class="form-control" value="<?php echo "$nama"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>B. Tanggal & Waktu Pencatatan</dt>
            </div>
            <div class="col-md-4 mb-2">B.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" name="tanggal_catat" id="tanggal_catat" class="form-control" value="<?php echo "$FormatTanggal"; ?>">
            </div>
            <div class="col-md-4 mb-2">B.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" name="jam_catat" id="jam_catat" class="form-control" value="<?php echo "$FormatJam"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>C. Tanggal & Waktu Pasien Masuk</dt>
            </div>
            <div class="col-md-4 mb-2">C.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" value="<?php echo "$FormatTanggalMasuk"; ?>">
            </div>
            <div class="col-md-4 mb-2">C.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" value="<?php echo "$FormatJamMasuk"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>D. Sarana Transportasi</dt>
            </div>
            <div class="col-md-4 mb-2">D.1 Kategori</div>
            <div class="col-md-8 mb-2">
                <select name="sarana_transportasi" id="sarana_transportasi" class="form-control">
                    <option <?php if($KategoriSaranaTransportasi==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($KategoriSaranaTransportasi=="Ambulans"){echo "selected";} ?> value="Ambulans">Ambulans</option>
                    <option <?php if($KategoriSaranaTransportasi=="Mobil"){echo "selected";} ?> value="Mobil">Mobil</option>
                    <option <?php if($KategoriSaranaTransportasi=="Motor"){echo "selected";} ?> value="Motor">Motor</option>
                    <option <?php if($KategoriSaranaTransportasi=="Lainnya"){echo "selected";} ?> value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">D.2 Keterangan</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="keterangan_sarana_transportasi" id="keterangan_sarana_transportasi" class="form-control" value="<?php echo "$KeteranganSaranaTransportasi"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>E. Surat Pengantar Rujukan</dt>
                <small>Apabila pada pendaftaran kunjungan terdapat data rujukan maka sistem akan mengisi form ini secara otomatis</small>
            </div>
            <div class="col-md-4 mb-2">E.1 Ada/Tidak</div>
            <div class="col-md-8 mb-2">
                <select name="surat_rujukan" id="surat_rujukan" class="form-control">
                    <option value="Pilih">Pilih</option>
                    <option <?php if($SuratRujukan=="Ada"){echo "selected";} ?> value="Ada">Ada</option>
                    <option <?php if($SuratRujukan=="Tidak"){echo "selected";} ?> value="Tidak">Tidak</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">E.2 Asal Rujukan</div>
            <div class="col-md-8 mb-2">
                <input type="text" <?php if($SuratRujukan=="Tidak"){echo "readonly";} ?> name="asal_rujukan" id="asal_rujukan" class="form-control" value="<?php echo $AsalSuratRujukan;?>">
            </div>
            <div class="col-md-4 mb-2">E.3 Nomor Surat</div>
            <div class="col-md-8 mb-2">
                <input type="text" <?php if($SuratRujukan=="Tidak"){echo "readonly";} ?> name="no_surat_rujukan" id="no_surat_rujukan" class="form-control" value="<?php echo $NomorSuratRujukan;?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>F. Kondisi Pasien Tiba</dt>
            </div>
            <div class="col-md-4 mb-2">F.1 Kategori</div>
            <div class="col-md-8 mb-2">
                <select name="kategori_kondisi_pasien" id="kategori_kondisi_pasien" class="form-control">
                    <option <?php if($kategori_kondisi_pasien==""){echo "selected";} ?> value="Pilih">Pilih</option>
                    <option <?php if($kategori_kondisi_pasien=="Resusitasi"){echo "selected";} ?> value="Resusitasi">Resusitasi</option>
                    <option <?php if($kategori_kondisi_pasien=="Emergency"){echo "selected";} ?> value="Emergency">Emergency</option>
                    <option <?php if($kategori_kondisi_pasien=="Urgent"){echo "selected";} ?> value="Urgent">Urgent</option>
                    <option <?php if($kategori_kondisi_pasien=="Less Urgent"){echo "selected";} ?> value="Less Urgent">Less Urgent</option>
                    <option <?php if($kategori_kondisi_pasien=="Non Urgent"){echo "selected";} ?> value="Non Urgent">Non Urgent</option>
                    <option <?php if($kategori_kondisi_pasien=="Death on Arrival"){echo "selected";} ?> value="Death on Arrival">Death on Arrival</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">F.2 Penjelasan</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="penjelasan_kondisi_pasien" id="penjelasan_kondisi_pasien" class="form-control" value="<?php echo $penjelasan_kondisi_pasien;?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>G. Pengantar Pasien</dt>
            </div>
            <div class="col-md-4 mb-2">G.1 Nama</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="nama_pengantar_pasien" id="nama_pengantar_pasien" class="form-control" value="<?php echo "$nama_pengantar_pasien"; ?>">
            </div>
            <div class="col-md-4 mb-2">G.2 No.Kontak</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="kontak_pengantar_pasien" id="kontak_pengantar_pasien" class="form-control" value="<?php echo "$kontak_pengantar_pasien"; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 mb-2">
                <dt>H. Asesmen Nyeri</dt>
            </div>
            <div class="col-md-4 mb-2">H.1 Ada/Tidak</div>
            <div class="col-md-8 mb-2">
                <select name="asesmen_nyeri" id="asesmen_nyeri" class="form-control">
                    <option <?php if($asesmen_nyeri_ada_tidak==""){echo "selected";} ?> value="Pilih">Pilih</option>
                    <option <?php if($asesmen_nyeri_ada_tidak=="Ada"){echo "selected";} ?> value="Ada">Ada</option>
                    <option <?php if($asesmen_nyeri_ada_tidak=="Tidak"){echo "selected";} ?> value="Tidak">Tidak</option>
                </select>
            </div>
        </div>
        <div id="FormAsesmenNyeri">
            <?php if($asesmen_nyeri_ada_tidak=="Ada"){ ?>
                <div class="row mb-3">
                    <div class="col-md-4 mb-2">
                        H.2 Lokasi Nyeri<br>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" class="form-control" id="lokasi_nyeri" name="lokasi_nyeri" value="<?php echo "$lokasi_nyeri"; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 mb-2">
                        H.3 Penyebab Nyeri<br>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" class="form-control" id="penyebab_nyeri" name="penyebab_nyeri" value="<?php echo "$penyebab_nyeri"; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 mb-2">
                        H.4 Durasi Nyeri<br>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" class="form-control" id="durasi_nyeri" name="durasi_nyeri" value="<?php echo "$durasi_nyeri"; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 mb-2">
                        H.5 Frekuensi Nyeri<br>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" class="form-control" id="frekuensi_nyeri" name="frekuensi_nyeri" value="<?php echo "$frekuensi_nyeri"; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12 mb-2">
                        H.3 Skala Nyeri
                    </div>
                    <div class="col-md-4 mb-2">
                        H.3.1 Skala VAS<br>
                        <small><i>Visual Analog Scale</i></small>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="range" class="form-control form-range" min="0" max="10" step="0.1" id="skala_vas" name="skala_vas" value="<?php echo "$skala_vas"; ?>">
                        <small>Skor: <span id="ValueSkalaVas">0</span></small>
                    </div>
                    <div class="col-md-4 mb-2">
                        H.3.2 Skala NRS<br>
                        <small><i>Numeric Rating Scale</i></small>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="range" class="form-control form-range" min="0" max="10" step="1" id="skala_nrs" name="skala_nrs" value="<?php echo "$skala_nrs"; ?>">
                        <small>Skor: <span id="ValueSkalaNrs">0</span></small>
                    </div>
                    <div class="col-md-4 mb-2">
                        H.3.3 Skala VRS<br>
                        <small><i>Verbal Rating Scale</i></small>
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="range" class="form-control form-range" min="0" max="10" step="2" id="skala_vrs" name="skala_vrs" value="<?php echo "$skala_vrs"; ?>">
                        <small>Skor: <span id="ValueSkalaVrs">0</span></small>
                    </div>
                    <div class="col-md-4 mb-2">
                        H.3.4 Skala WBPRS<br>
                        <small><i>Wong Baker Pain Rating Scale</i></small>
                    </div>
                    <div class="col-md-8 mb-2">
                        <ul>
                            <li>
                                <input type="radio" <?php if($skala_wbps=="0"){echo "checked";} ?> name="skala_wbps" id="skala_wbps0" value="0">
                                <label for="skala_wbps0"><i class="icofont-wink-smile icofont-2x"></i> <small>0 Tidak Sakit</small></label>
                            </li>
                            <li>
                                <input type="radio" <?php if($skala_wbps=="2"){echo "checked";} ?> name="skala_wbps" id="skala_wbps2" value="2">
                                <label for="skala_wbps2"><i class="icofont-slightly-smile icofont-2x"></i> <small>2 Sedikit Sakit</small></label>
                            </li>
                            <li>
                                <input type="radio"<?php if($skala_wbps=="4"){echo "checked";} ?>  name="skala_wbps" id="skala_wbps4" value="4">
                                <label for="skala_wbps4"><i class="icofont-expressionless icofont-2x"></i> <small>4 Agak Mengganggu</small></label>
                            </li>
                            <li>
                                <input type="radio" <?php if($skala_wbps=="6"){echo "checked";} ?> name="skala_wbps" id="skala_wbps6" value="6">
                                <label for="skala_wbps6"><i class="icofont-sad icofont-2x"></i> <small>6 Mengganggu Aktivitas</small></label>
                            </li>
                            <li>
                                <input type="radio" <?php if($skala_wbps=="8"){echo "checked";} ?> name="skala_wbps" id="skala_wbps8" value="8">
                                <label for="skala_wbps8"><i class="icofont-worried icofont-2x"></i> <small>8 Sangat Mengganggu</small></label>
                            </li>
                            <li>
                                <input type="radio" <?php if($skala_wbps=="10"){echo "checked";} ?> name="skala_wbps" id="skala_wbps10" value="10">
                                <label for="skala_wbps10"><i class="icofont-crying icofont-2x"></i> <small>10 Tak Tertahankan</small></label>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        H.3.5 Skala NIPS<br>
                        <small><i>Neonatal Infant Pain Scale</i></small>
                    </div>
                    <div class="col-md-4"> <label for="skala_nips1"><small>Facial Expression</small></label></div>
                    <div class="col-md-8">
                        <select name="skala_nips1" id="skala_nips1" class="form-control">
                            <option <?php if($skala_nips1=="0"){echo "selected";} ?> value="0">Relaxed</option>
                            <option <?php if($skala_nips1=="1"){echo "selected";} ?> value="1">Grimace</option>
                        </select>
                    </div>
                    <div class="col-md-4"> <label for="skala_nips2"><small>Cry</small></label></div>
                    <div class="col-md-8">
                        <select name="skala_nips2" id="skala_nips2" class="form-control">
                            <option <?php if($skala_nips2=="0"){echo "selected";} ?> value="0">No Cry</option>
                            <option <?php if($skala_nips2=="1"){echo "selected";} ?> value="1">Whimper (mild moaning or intermittent)</option>
                            <option <?php if($skala_nips2=="2"){echo "selected";} ?> value="2">Vigorous crying or silent cry (based on facial movements if intubated)</option>
                        </select>
                    </div>
                    <div class="col-md-4"> <label for="skala_nips3"><small>Breathing Pattern</small></label></div>
                    <div class="col-md-8">
                        <select name="skala_nips3" id="skala_nips3" class="form-control">
                            <option <?php if($skala_nips3=="0"){echo "selected";} ?> value="0">Relaxed</option>
                            <option <?php if($skala_nips3=="1"){echo "selected";} ?> value="1">Change in breathing (irregular, increased, gagging, breath holding)</option>
                        </select>
                    </div>
                    <div class="col-md-4"><label for="skala_nips4"><small>Arms</small></label></div>
                    <div class="col-md-8">
                        <select name="skala_nips4" id="skala_nips4" class="form-control">
                            <option <?php if($skala_nips4=="0"){echo "selected";} ?> value="0">Relaxed</option>
                            <option <?php if($skala_nips4=="1"){echo "selected";} ?> value="1">Flexed/extended (tense straight arms, rigid and/or rapid extension)</option>
                        </select>
                    </div>
                    <div class="col-md-4"><label for="skala_nips5"><small>Legs</small></label></div>
                    <div class="col-md-8">
                        <select name="skala_nips5" id="skala_nips5" class="form-control">
                            <option <?php if($skala_nips5=="0"){echo "selected";} ?> value="0">Relaxed</option>
                            <option <?php if($skala_nips5=="1"){echo "selected";} ?> value="1">Flexed/extended (tense straight legs, rigid and/or rapid extension)</option>
                        </select>
                    </div>
                    <div class="col-md-4"><label for="skala_nips6"><small>State Of Arousal</small></label></div>
                    <div class="col-md-8">
                        <select name="skala_nips6" id="skala_nips6" class="form-control">
                            <option <?php if($skala_nips6=="0"){echo "selected";} ?> value="0">Sleeping/awake (quiet, peaceful, settled)</option>
                            <option <?php if($skala_nips6=="1"){echo "selected";} ?> value="1">Fussy (alert, restless, and thrashing)</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        H.3.6 Pemeriksa
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="nakes_nyeri" name="nakes_nyeri" class="form-control" value="<?php echo "$nakes_nyeri"; ?>">
                        <small>Nama Nakes Yang Memeriksa</small>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <dt>I. Kajian Risiko Jatuh</dt>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 mb-2">
                        I.1 MFS <i>(Morse Fall Scale)</i>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Riwayat jatuh: baru saja atau dalam 3 bulan</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_mfs1" id="resikoi_jatuh_mfs1" class="form-control">
                                    <option <?php if($mfs1=="0"){echo "selected";} ?> value="0">Tidak (0)</option>
                                    <option <?php if($mfs1=="25"){echo "selected";} ?> value="25">Ya (25)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Diagnosis Lain</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_mfs2" id="resikoi_jatuh_mfs2" class="form-control">
                                    <option <?php if($mfs2=="0"){echo "selected";} ?> value="0">Tidak (0)</option>
                                    <option <?php if($mfs2=="15"){echo "selected";} ?> value="15">Ya (15)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Bantuan Berjalan</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_mfs3" id="resikoi_jatuh_mfs3" class="form-control">
                                    <option <?php if($mfs3=="0"){echo "selected";} ?> value="0">Tidak Ada (0)</option>
                                    <option <?php if($mfs3=="15"){echo "selected";} ?> value="15">Tongkat/alat bantu (15)</option>
                                    <option <?php if($mfs3=="30"){echo "selected";} ?> value="30">Furnitur (30)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Heparin Lock</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_mfs4" id="resikoi_jatuh_mfs4" class="form-control">
                                    <option <?php if($mfs4=="0"){echo "selected";} ?> value="0">Tidak (0)</option>
                                    <option <?php if($mfs4=="20"){echo "selected";} ?> value="20">Ya (20)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Cara Berjalan/Berpindah</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_mfs5" id="resikoi_jatuh_mfs5" class="form-control">
                                    <option <?php if($mfs5=="0"){echo "selected";} ?> value="0">Normal (0)</option>
                                    <option <?php if($mfs5=="10"){echo "selected";} ?> value="10">Lemah (10)</option>
                                    <option <?php if($mfs5=="20"){echo "selected";} ?> value="20">Terganggu (20)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Status Mental</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_mfs6" id="resikoi_jatuh_mfs6" class="form-control">
                                    <option <?php if($mfs6=="0"){echo "selected";} ?> value="0">Mengetahui kemampuan diri (0)</option>
                                    <option <?php if($mfs6=="15"){echo "selected";} ?> value="15">Lupa Keterbatasan (15)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Skor/Kategori</small>
                            </div>
                            <div class="col-md-8" id="resikoi_jatuh_mfs_skor_kategori"><?php echo "$skor_mfs ($kategori_mfs)"; ?></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 mb-2">
                        I.2 HDS <i>(Humpty Dumpty Scale)</i>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Umur</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds1" id="resikoi_jatuh_hds1" class="form-control">
                                    <option <?php if($hds1==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($hds1=="4"){echo "selected";} ?> value="4">< 3 tahun (4)</option>
                                    <option <?php if($hds1=="3"){echo "selected";} ?> value="3">3-7 tahun (3)</option>
                                    <option <?php if($hds1=="2"){echo "selected";} ?> value="2">7-13 tahun (2)</option>
                                    <option <?php if($hds1=="1"){echo "selected";} ?> value="1">13-18 tahun (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Jenis Kelamin</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds2" id="resikoi_jatuh_hds2" class="form-control">
                                    <option <?php if($hds2==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($hds2=="2"){echo "selected";} ?> value="2">Laki-laki (2)</option>
                                    <option <?php if($hds2=="1"){echo "selected";} ?> value="1">Perempuan (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Diagnosis</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds3" id="resikoi_jatuh_hds3" class="form-control">
                                    <option <?php if($hds3==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($hds3=="4"){echo "selected";} ?>  value="4">Kelainan neurologi (4)</option>
                                    <option <?php if($hds3=="3"){echo "selected";} ?>  value="3">Gangguan oksigenasi (3)</option>
                                    <option <?php if($hds3=="2"){echo "selected";} ?>  value="2">Kelemahan fisik/kelainan psikis (2)</option>
                                    <option <?php if($hds3=="1"){echo "selected";} ?>  value="1">Ada diagnosis tambahan (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Gangguan kognitif</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds4" id="resikoi_jatuh_hds4" class="form-control">
                                    <option <?php if($hds4==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($hds4=="3"){echo "selected";} ?> value="3">Tidak memahami keterbatasan (3)</option>
                                    <option <?php if($hds4=="2"){echo "selected";} ?> value="2">Lupa keterbatasan (2)</option>
                                    <option <?php if($hds4=="1"){echo "selected";} ?> value="1">Orientasi terhadap kelemahan (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Faktor lingkungan</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds5" id="resikoi_jatuh_hds5" class="form-control">
                                    <option <?php if($hds5==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($hds5=="4"){echo "selected";} ?> value="4">Riwayat jatuh dari tempat tidur (4)</option>
                                    <option <?php if($hds5=="3"){echo "selected";} ?> value="3">Pasien menggunakan alat bantu (3)</option>
                                    <option <?php if($hds5=="2"){echo "selected";} ?> value="2">Pasien berada di tempat tidur (2)</option>
                                    <option <?php if($hds5=="1"){echo "selected";} ?> value="1">Pasien berada di luar area ruang perawatan (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Respon terhadap obat</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds6" id="resikoi_jatuh_hds6" class="form-control">
                                    <option <?php if($hds6==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($hds6=="3"){echo "selected";} ?> value="3">Kurang dari 24 jam (3)</option>
                                    <option <?php if($hds6=="2"){echo "selected";} ?> value="2">Kurang dari 48 jam (2)</option>
                                    <option <?php if($hds6=="1"){echo "selected";} ?> value="1">Lebih dari 48 jam (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Penggunaan obat</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_hds7" id="resikoi_jatuh_hds7" class="form-control">
                                    <option <?php if($hds7==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($hds7=="3"){echo "selected";} ?> value="3">Penggunaan obat sedative (3)</option>
                                    <option <?php if($hds7=="2"){echo "selected";} ?> value="2">Hiponotik, barbitural, fenotazin, antidepresan, laksatif/diuretik, narotik/metadon (2)</option>
                                    <option <?php if($hds7=="1"){echo "selected";} ?> value="1">Pengobatan lain (1)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Skor/Kategori</small>
                            </div>
                            <div class="col-md-8" id="resikoi_jatuh_hds_skor_kategori"><?php echo "$skor_hds ($kategori_hds)"; ?></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 mb-2">
                        I.3 EPFRA <i>(Edmonson Psychiatric Fall Risk Assessment)</i>
                    </div>
                    <div class="col-md-12 mb-2">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Umur</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra1" id="resikoi_jatuh_epfra1" class="form-control">
                                    <option <?php if($epfra1==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($epfra1=="8"){echo "selected";} ?> value="8">< 50 tahun (8)</option>
                                    <option <?php if($epfra1=="10"){echo "selected";} ?> value="10">3-7 tahun (10)</option>
                                    <option <?php if($epfra1=="26"){echo "selected";} ?> value="26">7-13 tahun (26)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Status Mental</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra2" id="resikoi_jatuh_epfra2" class="form-control">
                                    <option <?php if($epfra2==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($epfra2=="-4"){echo "selected";} ?> value="-4">Sadar Penuh Dan Orientasi Waktu Baik (-4)</option>
                                    <option <?php if($epfra2=="13"){echo "selected";} ?> value="13">Agitasi (Cemas) (13)</option>
                                    <option <?php if($epfra2=="12"){echo "selected";} ?> value="12">Sering Bingung (12)</option>
                                    <option <?php if($epfra2=="14"){echo "selected";} ?> value="14">Bingung dan Disorientasi (14)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Eliminasi</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra3" id="resikoi_jatuh_epfra3" class="form-control">
                                    <option <?php if($epfra3==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($epfra3=="8"){echo "selected";} ?> value="8">Mandiri untuk BAB dan BAK (8)</option>
                                    <option <?php if($epfra3=="12"){echo "selected";} ?> value="12">Memakai kateter/ostomy (12)</option>
                                    <option <?php if($epfra3=="10"){echo "selected";} ?> value="10">BAB dan BAK dengan Bantuan (10)</option>
                                    <option <?php if($epfra3=="12"){echo "selected";} ?> value="12">Gangguan Eliminasi (12)</option>
                                    <option <?php if($epfra3=="12"){echo "selected";} ?> value="12">Inkontinesia tetapi bisa ambulasi mandiri (12)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Medikasi</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra4" id="resikoi_jatuh_epfra4" class="form-control">
                                    <option <?php if($epfra4==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($epfra4=="10"){echo "selected";} ?> value="10">Tidak ada pengobatan yang diberikan(10)</option>
                                    <option <?php if($epfra4=="10"){echo "selected";} ?> value="10">Obat-obatan jantung (10)</option>
                                    <option <?php if($epfra4=="8"){echo "selected";} ?> value="8">Obat psikiatri (8)</option>
                                    <option <?php if($epfra4=="12"){echo "selected";} ?> value="12">Meningkatnya dosis obat yang dikonsumsi (12)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Diagnosis</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra5" id="resikoi_jatuh_epfra5" class="form-control">
                                    <option <?php if($epfra5==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($epfra5=="10"){echo "selected";} ?> value="10">Bipolar / Gangguan Scizo Affective (10)</option>
                                    <option <?php if($epfra5=="8"){echo "selected";} ?> value="8">Penyalah gunaan zat terlarang dan alkohol (8)</option>
                                    <option <?php if($epfra5=="10"){echo "selected";} ?> value="10">Gangguan depresi mayor (10)</option>
                                    <option <?php if($epfra5=="12"){echo "selected";} ?> value="12">Dimensia/Delirium (12)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Ambulasi/Keseimbangan</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra6" id="resikoi_jatuh_epfra6" class="form-control">
                                    <option <?php if($epfra6==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($epfra6=="7"){echo "selected";} ?> value="7">Ambulasi Mandiri (7)</option>
                                    <option <?php if($epfra6=="8"){echo "selected";} ?> value="8">Penggunaan Alat Bantu (8)</option>
                                    <option <?php if($epfra6=="10"){echo "selected";} ?> value="10">Vertigo (10)</option>
                                    <option <?php if($epfra6=="8"){echo "selected";} ?> value="8">Langkah stabil dan Menyadari Kemampuan (8)</option>
                                    <option <?php if($epfra6=="15"){echo "selected";} ?> value="15">Langkah stabil dan  Tidak Menyadari Kemampuan (15)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Nutrisi</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra7" id="resikoi_jatuh_epfra7" class="form-control">
                                    <option <?php if($epfra7==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($epfra7=="12"){echo "selected";} ?> value="12">Sedikit mendapatkan asupan makanan/minum (12)</option>
                                    <option <?php if($epfra7=="0"){echo "selected";} ?> value="0">Nafsu Makan Baik (0)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Gangguan Tidur</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra8" id="resikoi_jatuh_epfra8" class="form-control">
                                    <option <?php if($epfra8==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($epfra8=="8"){echo "selected";} ?> value="8">Tidak Ada Gangguan Tidur(8)</option>
                                    <option <?php if($epfra8=="12"){echo "selected";} ?> value="12">Ada Gangguan Tidur (12)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Riwayat Jatuh</small>
                            </div>
                            <div class="col-md-8">
                                <select name="resikoi_jatuh_epfra9" id="resikoi_jatuh_epfra9" class="form-control">
                                    <option <?php if($epfra9==""){echo "selected";} ?> value="">Pilih</option>
                                    <option <?php if($epfra9=="8"){echo "selected";} ?> value="8">Tidak Ada Riwayat Jatuh(8)</option>
                                    <option <?php if($epfra9=="14"){echo "selected";} ?> value="14">Ada Riwayat Jatuh Dalam 3 Bulan (14)</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <small>Skor/Kategori</small>
                            </div>
                            <div class="col-md-8" id="resikoi_jatuh_epfra_skor_kategori"><?php echo "$skor_epfra ($kategori_epfra)"; ?></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        I.4 Pemeriksa
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="nakes_resiko_jatuh" name="nakes_resiko_jatuh" class="form-control" value="<?php echo "$pemeriksa"; ?>">
                        <small>Nama Nakes Yang Memeriksa Resiko Jatuh</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4 mb-2">
                <dt>J. Kesadaran</dt>
            </div>
            <div class="col-md-8 mb-2">
                <select name="kesadaran_pasien" id="kesadaran_pasien" class="form-control">
                    <option <?php if($kesadaran_pasien==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($kesadaran_pasien=="0.Sadar Baik"){echo "selected";} ?> value="0.Sadar Baik">Sadar Baik</option>
                    <option <?php if($kesadaran_pasien=="1.Berespon Dengan Kata-Kata"){echo "selected";} ?> value="1.Berespon Dengan Kata-Kata">Berespon Dengan Kata-Kata</option>
                    <option <?php if($kesadaran_pasien=="2.Hanya Berespon Jika Dirangsang"){echo "selected";} ?> value="2.Hanya Berespon Jika Dirangsang">Hanya Berespon Jika Dirangsang</option>
                    <option <?php if($kesadaran_pasien=="3.Pasien Tidak Sadar"){echo "selected";} ?> value="3.Pasien Tidak Sadar">Pasien Tidak Sadar</option>
                    <option <?php if($kesadaran_pasien=="4.Gelisah Atau Bingung"){echo "selected";} ?> value="4.Gelisah Atau Bingung">Gelisah Atau Bingung</option>
                    <option <?php if($kesadaran_pasien=="5.Acute Confusional States"){echo "selected";} ?> value="5.Acute Confusional States">Acute Confusional States</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiEditTriaseDanIgd">
                <span class="text-primary">Pastikan informasi triase dan IGD sudah terisi dengan lengkap dan benar.</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary mr-3">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php }} ?>