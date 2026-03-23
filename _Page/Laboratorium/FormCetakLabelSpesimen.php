<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_radiologi_file
    if(empty($_POST['id_laboratorium_sample'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Spesimen Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_laboratorium_sample=$_POST['id_laboratorium_sample'];
        $id_lab=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'id_lab');
        $sumber=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'sumber');
        $waktu_pengambilan=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'waktu_pengambilan');
        $lokasi_pengambilan=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'lokasi_pengambilan');
        $jumlah_sample=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'jumlah_sample');
        $volume_sample=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'volume_sample');
        $metode=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'metode');
        $kondisi=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'kondisi');
        $waktu_fiksasi=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'waktu_fiksasi');
        $cairan_fiksasi=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'cairan_fiksasi');
        $volume_fiksasi=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'volume_fiksasi');
        $petugas_sample=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'petugas_sample');
        $petugas_pengantar=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'petugas_pengantar');
        $petugas_penerima=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'petugas_penerima');
        $status=getDataDetail($Conn,'laboratorium_sample','id_laboratorium_sample',$id_laboratorium_sample,'status');
        //Membuka Setting
        $nama_font=getDinamicSetting($Conn,$SessionIdAkses,'Laboratorium','nama_font');
        $ukuran_font=getDinamicSetting($Conn,$SessionIdAkses,'Laboratorium','ukuran_font');
        $warna_font=getDinamicSetting($Conn,$SessionIdAkses,'Laboratorium','warna_font');
        $satuan=getDinamicSetting($Conn,$SessionIdAkses,'Laboratorium','satuan');
        $panjang_x=getDinamicSetting($Conn,$SessionIdAkses,'Laboratorium','panjang_x');
        $lebar_y=getDinamicSetting($Conn,$SessionIdAkses,'Laboratorium','lebar_y');
        $margin=getDinamicSetting($Conn,$SessionIdAkses,'Laboratorium','margin');
        $padding=getDinamicSetting($Conn,$SessionIdAkses,'Laboratorium','padding');
        $tampilkan_barcode=getDinamicSetting($Conn,$SessionIdAkses,'Laboratorium','tampilkan_barcode');
        $format=getDinamicSetting($Conn,$SessionIdAkses,'Laboratorium','format');
        if(empty($warna_font)){
            $warna_font="#000000";
        }
?>
    <input type="hidden" name="id_laboratorium_sample" id="id_laboratorium_sample" value="<?php echo "$id_laboratorium_sample"; ?>">
    <div class="row mb-3"> 
        <div class="col-md-3 mb-2">
            <label for="nama_font">
                <dt>Nama Font</dt>
            </label>
        </div>
        <div class="col-md-9 mb-2">
            <select name="nama_font" id="nama_font" class="form-control">
                <option <?php if($nama_font=="Arial"){echo "selected";} ?> value="Arial">Arial</option>
                <option <?php if($nama_font=="Sans Serif"){echo "selected";} ?> value="Sans Serif">Sans Serif</option>
                <option <?php if($nama_font=="Times New Roman"){echo "selected";} ?> value="Times New Roman">Times New Roman</option>
                <option <?php if($nama_font=="Verdana"){echo "selected";} ?> value="Verdana">Verdana</option>
            </select>
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-3">
            <label for="ukuran_font">
                <dt>Ukuran Font</dt>
            </label>
        </div>
        <div class="col-md-9">
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
        <div class="col-md-3">
            <label for="warna_font">
                <dt>Warna Font</dt>
            </label>
        </div>
        <div class="col-md-9">
            <input type="color" id="warna_font" name="warna_font" class="form-control" value="<?php echo "$warna_font"; ?>">
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-3">
            <label for="satuan">
                <dt>Unit</dt>
            </label>
        </div>
        <div class="col-md-9">
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
        <div class="col-md-3">
            <label for="margin">
                <dt>Margin</dt>
            </label>
        </div>
        <div class="col-md-9">
            <input type="text" id="margin" name="margin" class="form-control" value="<?php echo "$margin"; ?>">
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-3">
            <label for="padding">
                <dt>Padding</dt>
            </label>
        </div>
        <div class="col-md-9">
            <input type="text" id="padding" name="padding" class="form-control" value="<?php echo "$padding"; ?>">
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-3">
            <label for="panjang_x">
                <dt>Panjang (X)</dt>
            </label>
        </div>
        <div class="col-md-9">
            <input type="text" id="panjang_x" name="panjang_x" class="form-control" value="<?php echo "$panjang_x"; ?>">
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-3">
            <label for="lebar_y">
                <dt>Lebar (Y)</dt>
            </label>
        </div>
        <div class="col-md-9">
            <input type="text" id="lebar_y" name="lebar_y" class="form-control" value="<?php echo "$lebar_y"; ?>">
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-3">
            <label for="tampilkan_barcode">
                <dt>Barcode</dt>
            </label>
        </div>
        <div class="col-md-9 mb-3">
            <select name="tampilkan_barcode" id="tampilkan_barcode" class="form-control">
                <option <?php if($tampilkan_barcode=="Ya"){echo "selected";} ?> value="Ya">Tampilkan</option>
                <option <?php if($tampilkan_barcode=="Tidak"){echo "selected";} ?> value="Tidak">Jangan Tampilkan</option>
            </select>
        </div>
    </div>
    <div class="row mb-3"> 
        <div class="col-md-3">
            <label for="format">
                <dt>Format</dt>
            </label>
        </div>
        <div class="col-md-9 mb-3">
            <select name="format" id="format" class="form-control">
                <option <?php if($format=="PDF"){echo "selected";} ?> value="PDF">PDF</option>
                <option <?php if($format=="HTML"){echo "selected";} ?> value="HTML">HTML</option>
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <input type="checkbox" checked value="Simpan" id="SimpanPengaturan" name="SimpanPengaturan">
            <label class="form-check-label" for="SimpanPengaturan">
                Simpan Pengaturan
            </label>
        </div>
    </div>
<?php } ?>