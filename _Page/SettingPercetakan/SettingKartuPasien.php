<div class="col-md-12">
    <div class="card">
        <form action="javasript:void(0);" id="ProsesSimpanSetingCetakKartuPasien">
            <div class="card-header">
                <div class="card-title">
                    <dt>
                        <i class="icofont-ui-v-card"></i> Pengaturan Kartu Pasien
                    </dt>
                </div>
            </div>
            <div class="card-body bg-white">
                <diw class="row">
                    <div class="col-md-12 mb-4">
                        <iframe src="<?php echo $BaseUrl;?>/_Page/SettingPercetakan/PreviewKartuPasien.php" frameborder="1" width="100%" height="300px"></iframe>
                    </div>
                </diw>
                <div class="row">
                    <div class="col-md-3 mt-3">
                        <label for="tanggal_setting">Tanggal</label>
                        <input type="date" readonly name="tanggal_setting" id="tanggal_setting" class="form-control" value="<?php echo "$TanggalSettingKartuPasien";?>" required>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="nama_font">Nama Font</label>
                        <input type="text" name="nama_font" id="nama_font" list="NamaFont" class="form-control"  value="<?php echo "$NamaFornSettingKartuPasien";?>" required>
                        <datalist id="NamaFont">
                            <option value="Arial">
                            <option value="Comic Sans MS Bold">
                            <option value="Courier New">
                            <option value="Georgia">
                            <option value="Impact">
                            <option value="Lucida Console">
                            <option value="Marlett">
                            <option value="Minion Web">
                            <option value="Times New Roman">
                            <option value="Tahoma">
                        </datalist>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="ukuran_font">Ukuran Font</label>
                        <input type="text" name="ukuran_font" id="ukuran_font" list="UkuranFont" class="form-control"  value="<?php echo "$UkuranFornSettingKartuPasien";?>" required>
                        <datalist id="UkuranFont">
                            <option value="4pt">
                            <option value="6pt">
                            <option value="12pt">
                            <option value="14pt">
                            <option value="16pt">
                            <option value="18pt">
                            <option value="20pt">
                            <option value="22pt">
                            <option value="24pt">
                            <option value="28pt">
                        </datalist>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="warna_font">Warna Font</label>
                        <input type="color" name="warna_font" id="warna_font" class="form-control form-control-color" value="<?php echo "$WarnaFornSettingKartuPasien";?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="panjang_x">Panjang X</label>
                        <input type="text" name="panjang_x" id="panjang_x" list="PanjangKertas" class="form-control" value="<?php echo "$PanjangSettingKartuPasien";?>" required>
                        <datalist id="PanjangKertas">
                            <option value="50mm">
                            <option value="60mm">
                            <option value="70mm">
                            <option value="80mm">
                            <option value="90mm">
                            <option value="100mm">
                            <option value="120mm">
                            <option value="130mm">
                            <option value="150mm">
                            <option value="160mm">
                        </datalist>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="lebar_y">Lebar Y</label>
                        <input type="text" name="lebar_y" id="lebar_y" list="LebarKertas" class="form-control" value="<?php echo "$LebarSettingKartuPasien";?>" required>
                        <datalist id="LebarKertas">
                            <option value="50mm">
                            <option value="60mm">
                            <option value="70mm">
                            <option value="80mm">
                            <option value="90mm">
                            <option value="100mm">
                            <option value="120mm">
                            <option value="130mm">
                            <option value="150mm">
                            <option value="160mm">
                        </datalist>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mt-3">
                        <label for="margin_atas">Margin Atas</label>
                        <input type="text" name="margin_atas" id="margin_atas" list="MarginAtas" class="form-control" value="<?php echo "$MarginAtasSettingKartuPasien";?>">
                        <datalist id="MarginAtas">
                            <option value="1mm">
                            <option value="2mm">
                            <option value="3mm">
                            <option value="4mm">
                            <option value="5mm">
                            <option value="6mm">
                            <option value="7mm">
                            <option value="8mm">
                            <option value="9mm">
                            <option value="10mm">
                        </datalist>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="margin_bawah">Margin Bawah</label>
                        <input type="text" name="margin_bawah" id="margin_bawah" list="MarginBawah" class="form-control form-control-color" value="<?php echo "$MarginBawahKartuPasien";?>">
                        <datalist id="MarginBawah">
                            <option value="1mm">
                            <option value="2mm">
                            <option value="3mm">
                            <option value="4mm">
                            <option value="5mm">
                            <option value="6mm">
                            <option value="7mm">
                            <option value="8mm">
                            <option value="9mm">
                            <option value="10mm">
                        </datalist>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="margin_kiri">Margin Kiri</label>
                        <input type="text" name="margin_kiri" id="margin_kiri" list="MarginKiri" class="form-control" value="<?php echo "$MarginKiriKartuPasien";?>">
                        <datalist id="MarginKiri">
                            <option value="1mm">
                            <option value="2mm">
                            <option value="3mm">
                            <option value="4mm">
                            <option value="5mm">
                            <option value="6mm">
                            <option value="7mm">
                            <option value="8mm">
                            <option value="9mm">
                            <option value="10mm">
                        </datalist>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="margin_kanan">Margin Kanan</label>
                        <input type="text" name="margin_kanan" id="margin_kanan" list="MarginKanan" class="form-control" value="<?php echo "$MarginKananKartuPasien";?>">
                        <datalist id="MarginKanan">
                            <option value="1mm">
                            <option value="2mm">
                            <option value="3mm">
                            <option value="4mm">
                            <option value="5mm">
                            <option value="6mm">
                            <option value="7mm">
                            <option value="8mm">
                            <option value="9mm">
                            <option value="10mm">
                        </datalist>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mt-3">
                        <label for="tampilkan_logo">Logo Faskes</label>
                        <select name="tampilkan_logo" id="tampilkan_logo" class="form-control" required>
                            <option <?php if($LogoKartuPasien==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($LogoKartuPasien=="Tidak"){echo "selected";} ?> value="Tidak">Tidak</option>
                            <option <?php if($LogoKartuPasien=="Ya"){echo "selected";} ?> value="Ya">Ya</option>
                        </select>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="tampilkan_foto">Tampilkan Foto Pasien</label>
                        <select name="tampilkan_foto" id="tampilkan_foto" class="form-control" required>
                            <option <?php if($FotoKartuPasien==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($FotoKartuPasien=="Tidak"){echo "selected";} ?> value="Tidak">Tidak</option>
                            <option <?php if($FotoKartuPasien=="Ya"){echo "selected";} ?> value="Ya">Ya</option>
                        </select>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="tampilkan_barcode">Barcode Pasien</label>
                        <select name="tampilkan_barcode" id="tampilkan_barcode" class="form-control" required>
                            <option <?php if($BarcodeKartuPasien==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($BarcodeKartuPasien=="Tidak"){echo "selected";} ?> value="Tidak">Tidak</option>
                            <option <?php if($BarcodeKartuPasien=="Ya"){echo "selected";} ?> value="Ya">Ya</option>
                        </select>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="kutipan_bawah">Tampilkan Kutipan</label>
                        <select name="kutipan_bawah" id="kutipan_bawah" class="form-control" required>
                            <option <?php if($KutipanBawahKartuPasien==""){echo "selected";} ?> value="">Pilih</option>
                            <option <?php if($KutipanBawahKartuPasien=="Tidak"){echo "selected";} ?> value="Tidak">Tidak</option>
                            <option <?php if($KutipanBawahKartuPasien=="Ya"){echo "selected";} ?> value="Ya">Ya</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mt-3">
                        <label for="panjang_logo">Panjang Logo</label>
                        <input type="text" name="panjang_logo" id="panjang_logo" list="PanjangLogo" class="form-control" value="<?php echo "$PanjangLogoKartuPasien";?>">
                        <datalist id="PanjangLogo">
                            <option value="5mm">
                            <option value="10mm">
                            <option value="15mm">
                            <option value="20mm">
                            <option value="25mm">
                            <option value="30mm">
                            <option value="35mm">
                            <option value="40mm">
                            <option value="45mm">
                            <option value="50mm">
                        </datalist>
                        
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="lebar_logo">Lebar Logo</label>
                        <input type="text" name="lebar_logo" id="lebar_logo" list="LebarLogo" class="form-control" value="<?php echo "$LebarLogoKartuPasien";?>">
                        <datalist id="LebarLogo">
                            <option value="5mm">
                            <option value="10mm">
                            <option value="15mm">
                            <option value="20mm">
                            <option value="25mm">
                            <option value="30mm">
                            <option value="35mm">
                            <option value="40mm">
                            <option value="45mm">
                            <option value="50mm">
                        </datalist>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="panjang_foto">Panjang Foto</label>
                        <input type="text" name="panjang_foto" id="panjang_foto" list="PanjangFoto" class="form-control" value="<?php echo "$PanjangFotoKartuPasien";?>">
                        <datalist id="PanjangFoto">
                            <option value="5mm">
                            <option value="10mm">
                            <option value="15mm">
                            <option value="20mm">
                            <option value="25mm">
                            <option value="30mm">
                            <option value="35mm">
                            <option value="40mm">
                            <option value="45mm">
                            <option value="50mm">
                        </datalist>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="lebar_foto">Lebar Foto</label>
                        <input type="text" name="lebar_foto" id="lebar_foto" list="LebarFoto" class="form-control" value="<?php echo "$LebarFotoKartuPasien";?>">
                        <datalist id="LebarFoto">
                            <option value="5mm">
                            <option value="10mm">
                            <option value="15mm">
                            <option value="20mm">
                            <option value="25mm">
                            <option value="30mm">
                            <option value="35mm">
                            <option value="40mm">
                            <option value="45mm">
                            <option value="50mm">
                        </datalist>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-3">
                        <label for="ukuran_barcode">Ukuran Barcode</label>
                        <input type="text" name="ukuran_barcode" id="ukuran_barcode" list="UkuranBarcode" class="form-control" value="<?php echo "$UkuranBarcodeKartuPasien";?>">
                        <datalist id="UkuranBarcode">
                            <option value="5">
                            <option value="10">
                            <option value="15">
                            <option value="20">
                            <option value="25">
                            <option value="30">
                            <option value="35">
                            <option value="40">
                            <option value="45">
                            <option value="50">
                        </datalist>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label for="isi_kutipan">Isi Kutipan</label>
                        <input type="text" name="isi_kutipan" id="isi_kutipan" class="form-control" value="<?php echo "$IsiKutipanKartuPasien";?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-4" id="NotifikasiSimpanSettingKartuPasien">
                        <span class="text-info">Pastikan anda mengisi form pengaturan dengan benar</span>
                    </div>
                </div>
            </div>
            <div class="card-footer mt-4 mb-4">
                <button type="submit" class="btn btn-md btn-info">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>