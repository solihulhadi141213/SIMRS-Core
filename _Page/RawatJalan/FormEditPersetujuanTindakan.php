<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_persetujuan_tindakan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Persetujuan Tindakan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_persetujuan_tindakan=$_POST['id_persetujuan_tindakan'];
        //Buka Detail Pasien
        $id_persetujuan_tindakan=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'id_persetujuan_tindakan');
        if(empty($id_persetujuan_tindakan)){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          ID Persetujuan Tindakan Tidak Valid!';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
            echo '      <i class="ti ti-close"></i> Tutup';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_kunjungan=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'id_kunjungan');
            $id_pasien=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'id_pasien');
            $nama_pasien=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'nama_pasien');
            $nama_petugas=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'nama_petugas');
            $dokter=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'dokter');
            $pemberi_pernyataan=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'pemberi_pernyataan');
            $tanggal_entry=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'tanggal_entry');
            $tanggal_penjelasan=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'tanggal_penjelasan');
            $persetujuan=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'persetujuan');
            $tindakan=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'tindakan');
            $konsekuensi=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'konsekuensi');
            $saksi=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'saksi');
            //Json Decode
            $JsonDokter=json_decode($dokter, true);
            $JsonPemberiPernyataan =json_decode($pemberi_pernyataan, true);
            $JsonTindakan=json_decode($tindakan, true);
            $JsonSaksi=json_decode($saksi, true);
            //Dokter
            $kategori_identitas_dokter=$JsonDokter['kategori_identitas_dokter'];
            $nomor_identitas_dokter=$JsonDokter['nomor_identitas_dokter'];
            $nama_dokter=$JsonDokter['nama_dokter'];
            $pendaping_dokter=$JsonDokter['pendaping_dokter'];
            $TtdDokter=$JsonDokter['ttd'];
            //Pemberi Pernyataan
            $pemberi_pernyataan=$JsonPemberiPernyataan['pemberi_pernyataan'];
            $nama_pemberi_pernyataan=$JsonPemberiPernyataan['nama_pemberi_pernyataan'];
            $identitas_pemberi_pernyataan=$JsonPemberiPernyataan['identitas_pemberi_pernyataan'];
            $nomor_identitas_pemberi_pernyataan=$JsonPemberiPernyataan['nomor_identitas_pemberi_pernyataan'];
            $TtdPemberiPernyataan=$JsonPemberiPernyataan['ttd'];
            //Saksi1
            $identitas_saksi1=$JsonSaksi['saksi1']['identitas_saksi1'];
            $nomor_identitas_saksi1=$JsonSaksi['saksi1']['nomor_identitas_saksi1'];
            $nama_saksi1=$JsonSaksi['saksi1']['nama_saksi1'];
            $ttd_saksi1=$JsonSaksi['saksi1']['ttd'];
            //Saksi 2
            $identitas_saksi2=$JsonSaksi['saksi2']['identitas_saksi2'];
            $nomor_identitas_saksi2=$JsonSaksi['saksi2']['nomor_identitas_saksi2'];
            $nama_saksi2=$JsonSaksi['saksi2']['nama_saksi2'];
            $ttd_saksi2=$JsonSaksi['saksi2']['ttd'];
            //Format Tanggal Entry
            $StrtotimeEntry=strtotime($tanggal_entry);
            $TanggalEntry=date('Y-m-d',$StrtotimeEntry);
            $JamEntry=date('H:i',$StrtotimeEntry);
            //Format Tanggal Penjelasan
            $StrtotimePenjelasan=strtotime($tanggal_penjelasan);
            $TanggalPenjelasan=date('Y-m-d',$StrtotimePenjelasan);
            $JamPenjelasan=date('H:i',$StrtotimePenjelasan);
?>
    <input type="hidden" name="id_persetujuan_tindakan" id="id_persetujuan_tindakan" class="form-control" value="<?php echo "$id_persetujuan_tindakan"; ?>">
    <div class="modal-body">
        <div class="row mb-4">
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
                <input type="text" readonly name="nama_pasien" id="nama_pasien" class="form-control" value="<?php echo "$nama_pasien"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>B. Pencatatan Persetujuan Tindakan</dt>
            </div>
            <div class="col-md-12 mb-2">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">B.1 Tanggal</div>
                    <div class="col-md-8 mb-2">
                        <input type="date" readonly name="tanggal_entry" id="tanggal_entry" class="form-control" value="<?php echo "$TanggalEntry"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">B.2 Jam</div>
                    <div class="col-md-8 mb-2">
                        <input type="time" readonly name="jam_entry" id="jam_entry" class="form-control" value="<?php echo "$JamEntry"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">B.3 Petugas Entry</div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$nama_petugas"; ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>C. Tanggal & Waktu Penjelasan Pada Pasien/Pendaping</dt>
            </div>
            <div class="col-md-4 mb-2">C.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" name="tanggal_penjelasan" id="tanggal_penjelasan" class="form-control" value="<?php echo "$TanggalPenjelasan"; ?>">
            </div>
            <div class="col-md-4 mb-2">C.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" name="jam_penjelasan" id="jam_penjelasan" class="form-control" value="<?php echo "$JamPenjelasan"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>E. Identitas Dokter Yang Memberikan Penjelasan</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        E.1 Kategori Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <select name="kategori_identitas_dokter" id="kategori_identitas_dokter" class="form-control">
                            <option <?php if($kategori_identitas_dokter==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($kategori_identitas_dokter=="NIK"){echo "selected";} ?> value="NIK">NIK</option>
                            <option <?php if($kategori_identitas_dokter=="SIM"){echo "selected";} ?> value="SIM">SIM</option>
                            <option <?php if($kategori_identitas_dokter=="Passport"){echo "selected";} ?> value="Passport">Passport</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        E.2 Nomor Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nomor_identitas_dokter" id="nomor_identitas_dokter" class="form-control" value="<?php echo "$nomor_identitas_dokter"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        E.3 Nama Dokter
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nama_dokter" id="nama_dokter" class="form-control" value="<?php echo "$nama_dokter"; ?>">
                        <small>Nama Harus Sesuai Identitas</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        E.4 Pendaping Dokter
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="pendaping_dokter" id="pendaping_dokter" class="form-control" value="<?php echo "$pendaping_dokter"; ?>">
                        <small>Nama petugas yang mendapingi dokter saat memberikan penjelasan</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>F. Identitas Pemberi Pernyataan</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        F.1 Pasien/Pendaping
                    </div>
                    <div class="col-md-8 mb-2">
                        <select name="pemberi_pernyataan" id="pemberi_pernyataan" class="form-control">
                            <option <?php if($pemberi_pernyataan==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($pemberi_pernyataan=="Pasien"){echo "selected";} ?> value="Pasien">Pasien</option>
                            <option <?php if($pemberi_pernyataan=="Pendaping/Keluarga"){echo "selected";} ?> value="Pendaping/Keluarga">Pendaping/Keluarga</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        F.2 Kategori Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <select name="identitas_pemberi_pernyataan" id="identitas_pemberi_pernyataan" class="form-control">
                            <option <?php if($identitas_pemberi_pernyataan==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($identitas_pemberi_pernyataan=="NIK"){echo "selected";} ?> value="NIK">NIK</option>
                            <option <?php if($identitas_pemberi_pernyataan=="SIM"){echo "selected";} ?> value="SIM">SIM</option>
                            <option <?php if($identitas_pemberi_pernyataan=="Passport"){echo "selected";} ?> value="Passport">Passport</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        F.3 Nomor Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nomor_identitas_pemberi_pernyataan" id="nomor_identitas_pemberi_pernyataan" class="form-control" value="<?php echo "$nomor_identitas_pemberi_pernyataan"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        F.4 Nama
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nama_pemberi_pernyataan" id="nama_pemberi_pernyataan" class="form-control" value="<?php echo "$nama_pemberi_pernyataan"; ?>">
                        <small>Nama Harus Sesuai Identitas</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>G. Saksi 1 (Dari Pihak RS)</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        G.1 Kategori Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <select name="identitas_saksi1" id="identitas_saksi1" class="form-control">
                            <option <?php if($identitas_saksi1==""){echo "selected";} ?>  value="">Pilih</option>
                            <option <?php if($identitas_saksi1=="NIK"){echo "selected";} ?>  value="NIK">NIK</option>
                            <option <?php if($identitas_saksi1=="SIM"){echo "selected";} ?>  value="SIM">SIM</option>
                            <option <?php if($identitas_saksi1=="Passport"){echo "selected";} ?>  value="Passport">Passport</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        G.2 Nomor Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nomor_identitas_saksi1" id="nomor_identitas_saksi1" class="form-control" value="<?php echo "$nomor_identitas_saksi1"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        G.3 Nama
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nama_saksi1" id="nama_saksi1" class="form-control" value="<?php echo "$nama_saksi1"; ?>">
                        <small>Nama Harus Sesuai Identitas</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>H. Saksi 2 (Dari Pihak Pasien)</dt>
            </div>
            <div class="col-md-12">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        H.1 Kategori Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <select name="identitas_saksi2" id="identitas_saksi2" class="form-control">
                            <option <?php if($identitas_saksi2==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($identitas_saksi2=="NIK"){echo "selected";} ?> value="NIK">NIK</option>
                            <option <?php if($identitas_saksi2=="SIM"){echo "selected";} ?> value="SIM">SIM</option>
                            <option <?php if($identitas_saksi2=="Passport"){echo "selected";} ?> value="Passport">Passport</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        H.2 Nomor Identitas
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nomor_identitas_saksi2" id="nomor_identitas_saksi2" class="form-control" value="<?php echo "$nomor_identitas_saksi2"; ?>">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        H.3 Nama
                    </div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="nama_saksi2" id="nama_saksi2" class="form-control" value="<?php echo "$nama_saksi2"; ?>">
                        <small>Nama Harus Sesuai Identitas</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>I. Tindakan</dt>
            </div>
            <div class="col-md-12">
                <!-- <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        I.1.Tindakan
                    </div>
                    <div class="col-md-8 mb-2">
                        <ol>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama1" name="isi_tindakan_utama" value="Cateterisasi Vena (Pemasangan Infus)">
                                <label for="isi_tindakan_utama1">Cateterisasi Vena (Pemasangan Infus)</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama2" name="isi_tindakan_utama" value="Pemasangan transfusi darah">
                                <label for="isi_tindakan_utama2">Pemasangan transfusi darah</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama3" name="isi_tindakan_utama" value="Pemasangan NGT">
                                <label for="isi_tindakan_utama3">Pemasangan NGT</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama4" name="isi_tindakan_utama" value="Pemberian Suntikan (IV, Im, Ic)">
                                <label for="isi_tindakan_utama4">Pemberian Suntikan (IV, Im, Ic)</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama5" name="isi_tindakan_utama" value="Pemasangan Cateterisasi Urine (Dower Cateter)">
                                <label for="isi_tindakan_utama5">Pemasangan Cateterisasi Urine (Dower Cateter)</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama6" name="isi_tindakan_utama" value="Resusitasi Jantung Paru (RJP)">
                                <label for="isi_tindakan_utama6">Resusitasi Jantung Paru (RJP)</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama7" name="isi_tindakan_utama" value="Suction">
                                <label for="isi_tindakan_utama7">Suction</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama8" name="isi_tindakan_utama" value="Hecting">
                                <label for="isi_tindakan_utama8">Hecting</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama9" name="isi_tindakan_utama" value="Pengambilan Sample Darah">
                                <label for="isi_tindakan_utama9">Pengambilan Sample Darah</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama10" name="isi_tindakan_utama" value="Perawatan Luka">
                                <label for="isi_tindakan_utama10">Perawatan Luka</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama11" name="isi_tindakan_utama" value="Pemasangan Oxygen">
                                <label for="isi_tindakan_utama11">Pemasangan Oxygen</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama12" name="isi_tindakan_utama" value="Pemberian Obat Oral">
                                <label for="isi_tindakan_utama12">Pemberian Obat Oral</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama13" name="isi_tindakan_utama" value="Pemberian Nutrisi Enternal">
                                <label for="isi_tindakan_utama13">Pemberian Nutrisi Enternal</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama14" name="isi_tindakan_utama" value="Pemeriksaan Dalam (PD) Vagina">
                                <label for="isi_tindakan_utama14">Pemeriksaan Dalam (PD) Vagina</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama15" name="isi_tindakan_utama" value="Pemeriksaan Detak Jantung Janin">
                                <label for="isi_tindakan_utama15">Pemeriksaan Detak Jantung Janin</label>
                            </li>
                            <li>
                                <input type="checkbox" id="isi_tindakan_utama16" name="isi_tindakan_utama" value="Pemasangan CTG/EKG">
                                <label for="isi_tindakan_utama16">Pemasangan CTG/EKG</label>
                            </li>
                        </ol>
                    </div>
                </div> -->
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        I.1.Tindakan
                    </div>
                    <div class="col-md-8 mb-2">
                        <div class="row mb-2">
                            <div class="col-md-12 mb-2">
                                <button type="button" id="tambahkan_form_tindakan" class="btn btn-sm btn-outline-dark btn-block" title="Tambah Form Tindakan">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div id="MultiForm">
                            <?php
                                if(!empty(count($JsonTindakan))){
                                    $JumlahTindakan=count($JsonTindakan);
                                    for($i=0; $i<$JumlahTindakan; $i++){
                                        $tindakan_list=$JsonTindakan[$i]["tindakan"];
                                        echo '<div class="row mb-3" id="row'.$i.'"><div class="col-md-10 mb-2"><input type="text" class="form-control" id="isi_tindakan[]" name="isi_tindakan[]" list="ReferensiTindakanList" placeholder="Tindakan" value="'.$tindakan_list.'"></div><div class="col-md-2"><button type="button" class="btn btn-sm btn-danger btn-block hapus_form_tindakan" id="'.$i.'"><i class="ti ti-close"></i></button></div></div>';
                                    }
                                }
                            ?>
                        </div>
                        <datalist id="ReferensiTindakanList">
                            <option value="Cateterisasi Vena (Pemasangan Infus)">
                            <option value="Pemasangan transfusi darah">
                            <option value="Pemasangan NGT">
                            <option value="Pemberian Suntikan (IV, Im, Ic)">
                            <option value="Pemasangan Cateterisasi Urine (Dower Cateter)">
                            <option value="Resusitasi Jantung Paru (RJP)">
                            <option value="Suction">
                            <option value="Hecting">
                            <option value="Pengambilan Sample Darah">
                            <option value="Perawatan Luka">
                            <option value="Pemasangan Oxygen">
                            <option value="Pemberian Obat Oral">
                            <option value="Pemberian Nutrisi Enternal">
                            <option value="Pemeriksaan Dalam (PD) Vagina">
                            <option value="Pemeriksaan Detak Jantung Janin">
                            <option value="Pemasangan CTG/EKG">
                        </datalist>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">
                        <label for="konsekuensi">I.2.Konsekuensi</label>
                    </div>
                    <div class="col-md-8 mb-2">
                        <textarea name="konsekuensi" id="konsekuensi" class="form-control"><?php echo $konsekuensi; ?></textarea>
                        <small>Konsekuensi yang mungkin timbul setelah tindakan</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <dt>J. Persetujuan Tindakan</dt>
            </div>
            <div class="col-md-8 mb-2">
                <select name="persetujuan" id="persetujuan" class="form-control">
                    <option <?php if($persetujuan==""){echo "selected";} ?> value="">Pilih</option>
                    <option <?php if($persetujuan=="Setuju"){echo "selected";} ?> value="Setuju">Setuju</option>
                    <option <?php if($persetujuan=="Menolak"){echo "selected";} ?> value="Menolak">Menolak</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiEditPersetujuanTindakan">
                <span class="text-primary">Pastikan informasi sudah terisi dengan lengkap dan benar.</span>
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
<script>
    $(document).ready(function(){
        var no =1;
        $('#tambahkan_form_tindakan').click(function(){
            no++;
            $('#MultiForm').append('<div class="row mb-3" id="row'+no+'"><div class="col-md-10 mb-2"><input type="text" class="form-control" id="isi_tindakan[]" name="isi_tindakan[]" list="ReferensiTindakanList" placeholder="Tindakan"></div><div class="col-md-2"><button type="button" class="btn btn-sm btn-danger btn-block hapus_form_tindakan" id="'+no+'"><i class="ti ti-close"></i></button></div>');
        });

        $(document).on('click', '.hapus_form_tindakan', function(){
            var button_id = $(this).attr("id"); 
            $('#row'+button_id+'').remove();
        });
    });
</script>