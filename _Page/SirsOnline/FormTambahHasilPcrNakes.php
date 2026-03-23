<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['id_nakes'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Nakes Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_nakes=$_POST['id_nakes'];
        $ihs=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'ihs');
        $nik=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'nik');
        $kode=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'kode');
        $nama=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'nama');
        $kategori=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'kategori');
        $referensi_sdm=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'referensi_sdm');
        $id_akses=getDataDetail($Conn,'nakes','id_nakes',$id_nakes,'id_akses');
?>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="id_nakes">ID Nakes</label>
            <input type="text" name="id_nakes" id="id_nakes" class="form-control" value="<?php echo "$id_nakes"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="tanggal">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="nama_nakes">Nama Lengkap Nakes</label>
            <input type="text" name="nama_nakes" id="nama_nakes" class="form-control" value="<?php echo "$nama"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="kategori_nakes">Kategori Nakes</label>
            <input type="text" name="kategori_nakes" id="kategori_nakes" list="list_kategori_nakes"  value="<?php echo "$kategori"; ?>" class="form-control" autocomplete="off">
            <datalist id="list_kategori_nakes">
                <option value="Co Ass">
                <option value="Residen">
                <option value="Intership">
                <option value="Dokter Spesialis">
                <option value="Dokter Umum">
                <option value="Dokter Gigi">
                <option value="Perawat">
                <option value="Bidan">
                <option value="Apoteker">
                <option value="Radiografer">
                <option value="Analis Lab">
                <option value="Nakes Lainnya">
            </datalist>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="hasil_pcr">Hasil PCR</label>
            <select name="hasil_pcr" id="hasil_pcr" class="form-control">
                <option value="">Pilih</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Positif">Positif</option>
                <option value="Negatif">Negatif</option>
            </select>
        </div>
    </div>
<?php } ?>