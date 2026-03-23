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
        $id_kunjungan=$_POST['id_kunjungan'];
        //Membuka Detail Triase Dan IGD
        $id_pasien=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'id_pasien');
        $id_akses=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'id_akses');
        $nama_pasien=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'nama_pasien');
        $nama_petugas=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'nama_petugas');
        $tanggal_entry=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'tanggal_entry');
        $tanggal_periksa=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'tanggal_periksa');
        $decubitus=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'decubitus');
        $batuk=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'batuk');
        $gizi=getDataDetail($Conn,"screening",'id_kunjungan',$id_kunjungan,'gizi');
        //Decode JSON
        $JsonPetugas =json_decode($nama_petugas, true);
        $JsonDecubitus =json_decode($decubitus, true);
        $JsonBatuk =json_decode($batuk, true);
        $JsonGizi =json_decode($gizi, true);
        //Format Tanggal
        $strtotime=strtotime($tanggal_entry);
        $FormatTanggalEntry=date('Y-m-d', $strtotime);
        $FormatJamEntry=date('H:i', $strtotime);
        $strtotime2=strtotime($tanggal_periksa);
        $FormatTanggalPeriksa=date('Y-m-d', $strtotime2);
        $FormatJamPeriksa=date('H:i', $strtotime2);
        //Buka Petugas Entry
        if(!empty($JsonPetugas['petugas_entry'])){
            $PetugasEntry=$JsonPetugas['petugas_entry'];
        }else{
            $PetugasEntry="";
        }
        //Buka Pemeriksa
        if(!empty($JsonPetugas['pemeriksa'])){
            $pemeriksa=$JsonPetugas['pemeriksa'];
        }else{
            $pemeriksa="";
        }
        //Buka dokter
        if(!empty($JsonPetugas['dokter'])){
            $dokter=$JsonPetugas['dokter'];
        }else{
            $dokter="";
        }
?>
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
                <dt>B. Tanggal & Waktu Pencatatan</dt>
            </div>
            <div class="col-md-4 mb-2">B.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" readonly name="tanggal_entry" id="tanggal_entry" class="form-control" value="<?php echo "$FormatTanggalEntry"; ?>">
            </div>
            <div class="col-md-4 mb-2">B.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" readonly name="jam_entry" id="jam_entry" class="form-control" value="<?php echo "$FormatJamEntry"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>C. Tanggal & Waktu Periksa</dt>
            </div>
            <div class="col-md-4 mb-2">C.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" name="tanggal_periksa" id="tanggal_periksa" class="form-control" value="<?php echo "$FormatTanggalPeriksa"; ?>">
            </div>
            <div class="col-md-4 mb-2">C.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" name="jam_periksa" id="jam_periksa" class="form-control" value="<?php echo "$FormatJamPeriksa"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>D. Informasi Petugas</dt>
            </div>
            <div class="col-md-4 mb-2">D.1 Petugas Entry</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$PetugasEntry"; ?>">
            </div>
            <div class="col-md-4 mb-2">D.2 Pemeriksa</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="pemeriksa" id="pemeriksa" class="form-control" value="<?php echo "$pemeriksa"; ?>">
            </div>
            <div class="col-md-4 mb-2">D.2 Dokter </div>
            <div class="col-md-8 mb-2">
                <input type="text" name="dokter" id="dokter" class="form-control" value="<?php echo "$dokter"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>E. Decubitus</dt>
            </div>
            <div class="col-md-12 mb-2">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">E.1 Status Decubitus</div>
                    <div class="col-md-8 mb-2">
                        <select name="status_decubitus" id="Edit_status_decubitus" class="form-control">
                            <option <?php if($JsonDecubitus['status_decubitus']==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($JsonDecubitus['status_decubitus']=="Ya"){echo "selected";} ?> value="Ya">Ya</option>
                            <option <?php if($JsonDecubitus['status_decubitus']=="Tidak"){echo "selected";} ?> value="Tidak">Tidak</option>
                        </select>
                        <small>Risiko Luka Decubitus</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">E.2 Keterangan</div>
                    <div class="col-md-8 mb-2">
                        <textarea <?php if($JsonDecubitus['status_decubitus']!=="Ya"){echo "readonly";} ?> name="keterangan_decubitus" id="Edit_keterangan_decubitus" class="form-control"><?php echo $JsonDecubitus['keterangan_decubitus']; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>F. Batuk</dt>
            </div>
            <div class="col-md-12 mb-2">
                <ol>
                    <li>
                        <input type="checkbox" <?php if($JsonBatuk['batuk1']=="Ya"){echo "checked";} ?> name="batuk1" id="Edit_batuk1" value="Ya">
                        <label for="Edit_batuk1">Riwayat demam</label>
                    </li>
                    <li>
                        <input type="checkbox" <?php if($JsonBatuk['batuk2']=="Ya"){echo "checked";} ?> name="batuk2" id="Edit_batuk2" value="Ya">
                        <label for="Edit_batuk2">Berkeringat pada malam hari tanpa aktivitas</label>
                    </li>
                    <li>
                        <input type="checkbox" <?php if($JsonBatuk['batuk3']=="Ya"){echo "checked";} ?> name="batuk3" id="Edit_batuk3" value="Ya">
                        <label for="Edit_batuk3">Riwayat berpergian dari daerah wabah</label>
                    </li>
                    <li>
                        <input type="checkbox" <?php if($JsonBatuk['batuk4']=="Ya"){echo "checked";} ?> name="batuk4" id="Edit_batuk4" value="Ya">
                        <label for="Edit_batuk4">Riwayat pemakaian obat jangka panjang</label>
                    </li>
                    <li>
                        <input type="checkbox" <?php if($JsonBatuk['batuk5']=="Ya"){echo "checked";} ?> name="batuk5" id="Edit_batuk5" value="Ya">
                        <label for="Edit_batuk5">Riwayat BB turun tanpa sebab yang diketahui</label>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>G. Gizi</dt>
            </div>
            <div class="col-md-12 mb-2">
                <div class="row mb-2">
                    <div class="col-md-12 mb-2">
                        <ol>
                            <li>
                                <input type="checkbox" <?php if($JsonGizi['gizi1']['value']=="Ya"){echo "checked";} ?> name="gizi1" id="Edit_gizi1" value="Ya">
                                <label for="Edit_gizi1">Penurunan BB dalam waktu 6 bulan terakhir</label>
                                <input <?php if($JsonGizi['gizi1']['value']!=="Ya"){echo "readonly";} ?> type="number" min="0" step="0.01" name="gizi1a" id="Edit_gizi1a" class="form-control" value="<?php echo $JsonGizi['gizi1']['keterangan']; ?>">
                                <label for="gizi1a">Jumlah rata-rata penurunan (Kg)</label>
                            </li>
                            <li>
                                <input type="checkbox" <?php if($JsonGizi['gizi1']['value']=="Ya"){echo "checked";} ?> name="gizi2" id="Edit_gizi2" value="Ya">
                                <label for="Edit_gizi2">Penurunan asupan makanan karena nafsu makan berkurang</label>
                                <input <?php if($JsonGizi['gizi2']['value']!=="Ya"){echo "readonly";} ?> type="text" name="gizi2a" id="Edit_gizi2a" class="form-control" value="<?php echo $JsonGizi['gizi2']['keterangan']; ?>">
                                <label for="gizi2a">Keterangan/Alasan</label>
                            </li>
                            <li>
                                <input type="checkbox" <?php if($JsonGizi['gizi3']['value']=="Ya"){echo "checked";} ?> name="gizi3" id="Edit_gizi3" value="Ya">
                                <label for="Edit_gizi3">Gejala gastrointestinal</label>
                                <input <?php if($JsonGizi['gizi3']['value']!=="Ya"){echo "readonly";} ?> type="text" name="gizi3a" id="Edit_gizi3a" class="form-control" value="<?php echo $JsonGizi['gizi3']['keterangan']; ?>">
                                <label for="gizi3a">Sebutkan (mual,muntah, diare, anorexia)</label>
                            </li>
                            <li>
                                <input type="checkbox" <?php if($JsonGizi['gizi4']['value']=="Ya"){echo "checked";} ?> name="gizi4" id="Edit_gizi4" value="Ya">
                                <label for="Edit_gizi4">Faktor pemberat (komorbid)</label>
                                <input <?php if($JsonGizi['gizi4']['value']!=="Ya"){echo "readonly";} ?> type="text" name="gizi4a" id="Edit_gizi4a" class="form-control" value="<?php echo $JsonGizi['gizi4']['keterangan']; ?>">
                                <label for="gizi3a">Keterangan/Sebutkan</label>
                            </li>
                            <li>
                                <input type="checkbox" <?php if($JsonGizi['gizi5']['value']=="Ya"){echo "checked";} ?> name="gizi5" id="Edit_gizi5" value="Ya">
                                <label for="Edit_gizi5">Penurunan kapasitas fungsional</label>
                                <input <?php if($JsonGizi['gizi5']['value']!=="Ya"){echo "readonly";} ?> type="text" name="gizi5a" id="Edit_gizi5a" class="form-control" value="<?php echo $JsonGizi['gizi5']['keterangan']; ?>">
                                <label for="gizi5a">Keterangan/Jelaskan</label>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiEditScreening">
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
<?php } ?>