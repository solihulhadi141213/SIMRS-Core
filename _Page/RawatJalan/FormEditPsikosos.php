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
        //Buka Detail
        //Membuka Detail Triase Dan IGD
        $id_pasien=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'id_pasien');
        $id_akses=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'id_akses');
        $tanggal=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'tanggal');
        $nama_pasien=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'nama_pasien');
        $nama_petugas=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'nama_petugas');
        $tanggal_entry=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'tanggal_entry');
        $tanggal_wawancara=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'tanggal_wawancara');
        $psikologi=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'psikologi');
        $sosial=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'sosial');
        $spiritual=getDataDetail($Conn,"psikosos",'id_kunjungan',$id_kunjungan,'spiritual');
        //Decode JSON
        $JsonNamaPetugas =json_decode($nama_petugas, true);
        $JsonPsikologi =json_decode($psikologi, true);
        $JsonSosial =json_decode($sosial, true);
        $JsonSpiritual =json_decode($spiritual, true);
        //Format Tanggal
        $strtotime=strtotime($tanggal_entry);
        $FormatTanggalEntry=date('Y-m-d', $strtotime);
        $FormatJamEntry=date('H:i', $strtotime);
        $strtotime2=strtotime($tanggal_wawancara);
        $FormatTanggalWawancara=date('Y-m-d', $strtotime2);
        $FormatJamWawancara=date('H:i', $strtotime2);
        //Buka Petugas Entry
        if(!empty($JsonNamaPetugas['petugas_entry'])){
            $petugas_entry=$JsonNamaPetugas['petugas_entry'];
        }else{
            $petugas_entry="";
        }
        //Buka penanya
        if(!empty($JsonNamaPetugas['penanya'])){
            $penanya=$JsonNamaPetugas['penanya'];
        }else{
            $penanya="";
        }
        //Buka objek
        if(!empty($JsonNamaPetugas['objek'])){
            $objek=$JsonNamaPetugas['objek'];
        }else{
            $objek="";
        }
        //Buka psikologi
        if(!empty($psikologi)){
            $status_psikologi=$JsonPsikologi['status_psikologi'];
            $keterangan_psikologi=$JsonPsikologi['keterangan_psikologi'];
        }else{
            $status_psikologi="";
            $keterangan_psikologi="";
        }
        //Buka sosial
        if(!empty($sosial)){
            $pendidikan=$JsonSosial['pendidikan'];
            $profesi=$JsonSosial['profesi'];
            $tempat_kerja=$JsonSosial['tempat_kerja'];
            $penghasilan=$JsonSosial['penghasilan'];
            $suku=$JsonSosial['suku'];
            $bahasa=$JsonSosial['bahasa'];
        }else{
            $pendidikan="";
            $profesi="";
            $tempat_kerja="";
            $penghasilan="";
            $suku="";
            $bahasa="";
        }
        //Buka spiritual
        if(!empty($spiritual)){
            $agama=$JsonSpiritual['agama'];
            $nilai=$JsonSpiritual['nilai'];
        }else{
            $agama="";
            $nilai="";
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
                <input type="date" readonly name="tanggal" id="tanggal" class="form-control" value="<?php echo "$FormatTanggalEntry"; ?>">
            </div>
            <div class="col-md-4 mb-2">B.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" readonly name="jam" id="jam" class="form-control" value="<?php echo "$FormatJamEntry"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>C. Tanggal & Waktu Wawancara</dt>
            </div>
            <div class="col-md-4 mb-2">C.1 Tanggal</div>
            <div class="col-md-8 mb-2">
                <input type="date" name="tanggal_wawancara" id="tanggal_wawancara" class="form-control" value="<?php echo "$FormatTanggalWawancara"; ?>">
            </div>
            <div class="col-md-4 mb-2">C.2 Jam</div>
            <div class="col-md-8 mb-2">
                <input type="time" name="jam_wawancara" id="jam_wawancara" class="form-control" value="<?php echo "$FormatJamWawancara"; ?>">
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>D. Informasi Petugas & Objek</dt>
            </div>
            <div class="col-md-4 mb-2">D.1 Petugas Entry</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="petugas_entry" id="petugas_entry" class="form-control" value="<?php echo "$petugas_entry"; ?>">
            </div>
            <div class="col-md-4 mb-2">D.2 Penanya</div>
            <div class="col-md-8 mb-2">
                <input type="text" name="penanya" id="penanya" class="form-control" value="<?php echo "$penanya"; ?>">
            </div>
            <div class="col-md-4 mb-2">D.2 Objek </div>
            <div class="col-md-8 mb-2">
                <input type="text" name="objek" id="objek" class="form-control" value="<?php echo "$objek"; ?>">
                <small>Pihak yang diwawancarai</small>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>E. Psikologi</dt>
            </div>
            <div class="col-md-12 mb-2">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">E.1 Status Psikologi</div>
                    <div class="col-md-8 mb-2">
                        <select name="status_psikologi" id="status_psikologi" class="form-control">
                            <option <?php if($status_psikologi==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($status_psikologi=="1. kelainan"){echo "selected";} ?> value="1. kelainan">1. kelainan</option>
                            <option <?php if($status_psikologi=="2.Cemas"){echo "selected";} ?> value="2.Cemas">2.Cemas</option>
                            <option <?php if($status_psikologi=="3.Takut"){echo "selected";} ?> value="3.Takut">3.Takut</option>
                            <option <?php if($status_psikologi=="4.Takut"){echo "selected";} ?> value="4.Takut">4.Marah</option>
                            <option <?php if($status_psikologi=="5.Sedih"){echo "selected";} ?> value="5.Sedih">5.Sedih</option>
                            <option <?php if($status_psikologi=="6.Lain-lain"){echo "selected";} ?> value="6.Lain-lain">6.Lain-lain</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">E.2 Keterangan</div>
                    <div class="col-md-8 mb-2">
                        <textarea name="keterangan_psikologi" id="keterangan_psikologi" class="form-control"><?php echo "$keterangan_psikologi"; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>F. Sosial</dt>
            </div>
            <div class="col-md-12 mb-2">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">F.1 Pendidikan</div>
                    <div class="col-md-8 mb-2">
                        <select name="pendidikan" id="pendidikan" class="form-control">
                            <option <?php if($pendidikan==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($pendidikan=="Tidak Sekolah"){echo "selected";} ?> value="Tidak Sekolah">Tidak Sekolah</option>
                            <option <?php if($pendidikan=="Pra TK"){echo "selected";} ?> value="Pra TK">Pra TK</option>
                            <option <?php if($pendidikan=="TK"){echo "selected";} ?> value="TK">TK</option>
                            <option <?php if($pendidikan=="SD"){echo "selected";} ?> value="SD">SD</option>
                            <option <?php if($pendidikan=="SMP"){echo "selected";} ?> value="SMP">SMP</option>
                            <option <?php if($pendidikan=="SMA"){echo "selected";} ?> value="SMA">SMA</option>
                            <option <?php if($pendidikan=="D1"){echo "selected";} ?> value="D1">D1</option>
                            <option <?php if($pendidikan=="D1"){echo "selected";} ?> value="D2">D2</option>
                            <option <?php if($pendidikan=="D3"){echo "selected";} ?> value="D3">D3</option>
                            <option <?php if($pendidikan=="S1"){echo "selected";} ?> value="S1">S1</option>
                            <option <?php if($pendidikan=="S2"){echo "selected";} ?> value="S2">S2</option>
                            <option <?php if($pendidikan=="S3"){echo "selected";} ?> value="S3">S3</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">F.2 Profesi</div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="profesi" id="profesi" class="form-control" value="<?php echo "$profesi"; ?>">
                        <small>Gambaran pekerjaan secara spesifik</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">F.3 Lokasi Kerja</div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="tempat_kerja" id="tempat_kerja" class="form-control" value="<?php echo "$tempat_kerja"; ?>">
                        <small>Penejelasan lokasi kerja/nama perusahaan</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">F.4 Penghasilan</div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="penghasilan" id="penghasilan" class="form-control" value="<?php echo "$penghasilan"; ?>">
                        <small>Penghasilan akumulasi bruto keluarga per bulan</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">F.5 Suku</div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="suku" id="suku" class="form-control" value="<?php echo "$suku"; ?>">
                        <small>Lebih dari 1 pisahkan dengan koma (,)</small>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">F.6 Bahasa</div>
                    <div class="col-md-8 mb-2">
                        <input type="text" name="bahasa" id="bahasa" class="form-control" value="<?php echo "$bahasa"; ?>">
                        <small>Lebih dari 1 pisahkan dengan koma (,)</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>G. Agama</dt>
            </div>
            <div class="col-md-12 mb-2">
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">G.1 Agama</div>
                    <div class="col-md-8 mb-2">
                        <select name="agama" id="agama" class="form-control">
                            <option <?php if($agama==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($agama=="Islam"){echo "selected";} ?> value="Islam">Islam</option>
                            <option <?php if($agama=="Kristen Protestan"){echo "selected";} ?> value="Kristen Protestan">Kristen Protestan</option>
                            <option <?php if($agama=="Katolik"){echo "selected";} ?> value="Katolik">Katolik</option>
                            <option <?php if($agama=="Hindu"){echo "selected";} ?> value="Hindu">Hindu</option>
                            <option <?php if($agama=="Buddha"){echo "selected";} ?> value="Buddha">Buddha</option>
                            <option <?php if($agama=="Khonghucu"){echo "selected";} ?> value="Khonghucu">Khonghucu</option>
                            <option <?php if($agama=="Lainnya"){echo "selected";} ?> value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-2">G.2 Nilai</div>
                    <div class="col-md-8 mb-2">
                        <textarea name="nilai" id="nilai" class="form-control"><?php echo "$nilai"; ?></textarea>
                        <small>Nilai keagamaan yang dianut keluarga/individu</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiEditPsikosos">
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