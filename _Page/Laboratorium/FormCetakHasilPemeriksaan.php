<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_radiologi_file
    if(empty($_POST['id_lab'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Lab Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_lab=$_POST['id_lab'];
        //Membuka Setting
        $nama_font=getDinamicSetting($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','nama_font');
        $ukuran_font=getDinamicSetting($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','ukuran_font');
        $warna_font=getDinamicSetting($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','warna_font');
        $satuan=getDinamicSetting($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','satuan');
        $panjang_x=getDinamicSetting($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','panjang_x');
        $lebar_y=getDinamicSetting($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','lebar_y');
        $margin=getDinamicSetting($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','margin');
        $padding=getDinamicSetting($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','padding');
        $signature=getDinamicSetting($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','signature');
        $kop=getDinamicSetting($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','kop');
        $format=getDinamicSetting($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','format');
        $spesimen=getDinamicSetting($Conn,$SessionIdAkses,'Hasil Pemeriksaan Laboratorium','spesimen');
        if(empty($warna_font)){
            $warna_font="#000000";
        }
?>
    <input type="hidden" name="id_lab" id="id_lab" value="<?php echo "$id_lab"; ?>">
    <div class="row mb-3"> 
        <div class="col-md-6 mb-2">
            <label for="nama_font">
                <dt>Nama Font</dt>
            </label>
        </div>
        <div class="col-md-6 mb-2">
            <select name="nama_font" id="nama_font" class="form-control">
                <option <?php if($nama_font=="Arial"){echo "selected";} ?> value="Arial">Arial</option>
                <option <?php if($nama_font=="Sans Serif"){echo "selected";} ?> value="Sans Serif">Sans Serif</option>
                <option <?php if($nama_font=="Times New Roman"){echo "selected";} ?> value="Times New Roman">Times New Roman</option>
                <option <?php if($nama_font=="Verdana"){echo "selected";} ?> value="Verdana">Verdana</option>
            </select>
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6">
            <label for="ukuran_font">
                <dt>Ukuran Font</dt>
            </label>
        </div>
        <div class="col-md-6">
            <select name="ukuran_font" id="ukuran_font" class="form-control">
                <option <?php if($ukuran_font=="2pt"){echo "selected";} ?> value="2pt">2pt</option>
                <option <?php if($ukuran_font=="4pt"){echo "selected";} ?> value="4pt">4pt</option>
                <option <?php if($ukuran_font=="8pt"){echo "selected";} ?> value="8pt">8pt</option>
                <option <?php if($ukuran_font=="10pt"){echo "selected";} ?> value="10pt">10pt</option>
                <option <?php if($ukuran_font=="12pt"){echo "selected";} ?> value="12pt">12pt</option>
                <option <?php if($ukuran_font=="14pt"){echo "selected";} ?> value="14pt">14pt</option>
                <option <?php if($ukuran_font=="16pt"){echo "selected";} ?> value="16pt">16pt</option>
                <option <?php if($ukuran_font=="18pt"){echo "selected";} ?> value="18pt">18pt</option>
                <option <?php if($ukuran_font=="20pt"){echo "selected";} ?> value="20pt">20pt</option>
                <option <?php if($ukuran_font=="22pt"){echo "selected";} ?> value="22pt">22pt</option>
            </select>
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6">
            <label for="warna_font">
                <dt>Warna Font</dt>
            </label>
        </div>
        <div class="col-md-6">
            <input type="color" id="warna_font" name="warna_font" class="form-control" value="<?php echo "$warna_font"; ?>">
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6">
            <label for="satuan">
                <dt>Unit</dt>
            </label>
        </div>
        <div class="col-md-6">
            <select name="satuan" id="satuan" class="form-control">
                <option <?php if($satuan=="mm"){echo "selected";} ?> value="mm">mm</option>
                <option <?php if($satuan=="cm"){echo "selected";} ?> value="cm">cm</option>
                <option <?php if($satuan=="pt"){echo "selected";} ?> value="pt">pt</option>
                <option <?php if($satuan=="px"){echo "selected";} ?> value="px">px</option>
                <option <?php if($satuan=="in"){echo "selected";} ?> value="in">in</option>
                <option <?php if($satuan=="pc"){echo "selected";} ?> value="pc">pc</option>
            </select>
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6">
            <label for="margin">
                <dt>Margin</dt>
            </label>
        </div>
        <div class="col-md-6">
            <input type="text" id="margin" name="margin" class="form-control" value="<?php echo "$margin"; ?>">
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6">
            <label for="padding">
                <dt>Padding</dt>
            </label>
        </div>
        <div class="col-md-6">
            <input type="text" id="padding" name="padding" class="form-control" value="<?php echo "$padding"; ?>">
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6">
            <label for="panjang_x">
                <dt>Panjang (X)</dt>
            </label>
        </div>
        <div class="col-md-6">
            <input type="text" id="panjang_x" name="panjang_x" class="form-control" value="<?php echo "$panjang_x"; ?>">
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6">
            <label for="lebar_y">
                <dt>Lebar (Y)</dt>
            </label>
        </div>
        <div class="col-md-6">
            <input type="text" id="lebar_y" name="lebar_y" class="form-control" value="<?php echo "$lebar_y"; ?>">
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6">
            <label for="signature">
                <dt>Tanda Tangan</dt>
            </label>
        </div>
        <div class="col-md-6 mb-3">
            <select name="signature" id="signature" class="form-control">
                <option <?php if($signature=="Ya"){echo "selected";} ?> value="Ya">Tampilkan</option>
                <option <?php if($signature=="Tidak"){echo "selected";} ?> value="Tidak">Jangan Tampilkan</option>
            </select>
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6">
            <label for="kop">
                <dt>Kop Surat</dt>
            </label>
        </div>
        <div class="col-md-6 mb-3">
            <select name="kop" id="kop" class="form-control">
                <option <?php if($kop=="Ya"){echo "selected";} ?> value="Ya">Tampilkan</option>
                <option <?php if($kop=="Tidak"){echo "selected";} ?> value="Tidak">Jangan Tampilkan</option>
            </select>
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6">
            <label for="spesimen">
                <dt>Spesimen</dt>
            </label>
        </div>
        <div class="col-md-6 mb-3">
            <select name="spesimen" id="spesimen" class="form-control">
                <option <?php if($spesimen=="Ya"){echo "selected";} ?> value="Ya">Tampilkan</option>
                <option <?php if($spesimen=="Tidak"){echo "selected";} ?> value="Tidak">Jangan Tampilkan</option>
            </select>
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-6">
            <label for="format">
                <dt>Format</dt>
            </label>
        </div>
        <div class="col-md-6 mb-3">
            <select name="format" id="format" class="form-control">
                <option <?php if($format=="PDF"){echo "selected";} ?> value="PDF">PDF</option>
                <option <?php if($format=="HTML"){echo "selected";} ?> value="HTML">HTML</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="checkbox" checked value="selesai" id="status_selesai" name="status_selesai">
            <label class="form-check-label" for="status_selesai">
                Update Selesai
            </label>
        </div>
        <div class="col-md-6">
            <input type="checkbox" checked value="Simpan" id="SimpanPengaturan" name="SimpanPengaturan">
            <label class="form-check-label" for="SimpanPengaturan">
                Simpan Pengaturan
            </label>
        </div>
    </div>
<?php } ?>