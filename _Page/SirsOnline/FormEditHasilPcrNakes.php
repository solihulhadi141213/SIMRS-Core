<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    $tgllapor=date('Y-m-d H:i:s');
    if(empty($_POST['id_nakes_pcr'])){
        echo '<div class="row">';
        echo '  <div class="col-xl-12 col-md-12 text-danger text-center">';
        echo '      ID Laporan Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_nakes_pcr=$_POST['id_nakes_pcr'];
        $tanggal=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'tanggal');
        $nama_nakes=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'nama_nakes');
        $kategori_nakes=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'kategori_nakes');
        $hasil_pcr=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'hasil_pcr');
        $id_akses=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'id_akses');
        //Detail Petugas
        $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
?>
    <input type="hidden" name="id_nakes_pcr" id="id_nakes_pcr" value="<?php echo "$id_nakes_pcr"; ?>">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="tanggal">Tanggal</label>
            <input type="date" readonly name="tanggal" id="tanggal" class="form-control" value="<?php echo "$tanggal"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="nama_nakes">Nama Lengkap Nakes</label>
            <input type="text" readonly name="nama_nakes" id="nama_nakes" class="form-control" value="<?php echo "$nama_nakes"; ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="kategori_nakes">Kategori Nakes</label>
            <input type="text" readonly name="kategori_nakes" id="kategori_nakes" list="list_kategori_nakes" class="form-control" autocomplete="off" value="<?php echo "$kategori_nakes"; ?>">
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
                <option <?php if($hasil_pcr==""){echo "selected";} ?> value="">Pilih</option>
                <option <?php if($hasil_pcr=="Menunggu"){echo "selected";} ?> value="Menunggu">Menunggu</option>
                <option <?php if($hasil_pcr=="Positif"){echo "selected";} ?> value="Positif">Positif</option>
                <option <?php if($hasil_pcr=="Negatif"){echo "selected";} ?> value="Negatif">Negatif</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3" id="NotifikasiEditHasilPcrNakes">
            Pastikan data hasil PCR Nakes yang anda input sudah benar.
        </div>
    </div>
<?php } ?>