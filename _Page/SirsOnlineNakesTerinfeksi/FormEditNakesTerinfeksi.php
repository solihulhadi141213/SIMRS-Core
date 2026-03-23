<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(empty($_POST['id_nakes_terinfeksi'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID Nakes Terinfeksi Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_nakes_terinfeksi=$_POST['id_nakes_terinfeksi'];
        $id_nakes_pcr=getDataDetail($Conn,'nakes_terinfeksi','id_nakes_terinfeksi',$id_nakes_terinfeksi,'id_nakes_pcr');
        $nama=getDataDetail($Conn,'nakes_terinfeksi','id_nakes_terinfeksi',$id_nakes_terinfeksi,'nama');
        $tanggal=getDataDetail($Conn,'nakes_terinfeksi','id_nakes_terinfeksi',$id_nakes_terinfeksi,'tanggal');
        $kategori=getDataDetail($Conn,'nakes_terinfeksi','id_nakes_terinfeksi',$id_nakes_terinfeksi,'kategori');
        $status=getDataDetail($Conn,'nakes_terinfeksi','id_nakes_terinfeksi',$id_nakes_terinfeksi,'status');
        $id_akses=getDataDetail($Conn,'nakes_terinfeksi','id_nakes_terinfeksi',$id_nakes_terinfeksi,'id_akses');
        $NamaPetugas=getDataDetail($Conn,'akses','id_akses',$id_akses,'nama');
        //Buat Format Tanggal
        $strtotime=strtotime($tanggal);
        $TanggalFormat=date('d/m/Y',$strtotime)
?>
    <input type="hidden" name="id_nakes_terinfeksi" id="id_nakes_terinfeksi" class="form-control" value="<?php echo $id_nakes_terinfeksi; ?>">
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="id_nakes_pcr">ID.PCR</label>
        </div>
        <div class="col-md-9">
            <input type="text" readonly name="id_nakes_pcr" id="id_nakes_pcr" class="form-control" value="<?php echo $id_nakes_pcr; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="nama">Nama Nakes</label>
        </div>
        <div class="col-md-9">
            <input type="text" readonly name="nama" id="nama" class="form-control" value="<?php echo $nama; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="kategori">Kategori Nakes</label>
        </div>
        <div class="col-md-9">
            <input type="text" readonly name="kategori" id="kategori" list="list_kategori_nakes" class="form-control" autocomplete="off" value="<?php echo $kategori; ?>">
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
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="tanggal">Tanggal</label>
        </div>
        <div class="col-md-9">
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo $tanggal; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="status">Status</label>
        </div>
        <div class="col-md-9">
            <select name="status" id="status" class="form-control">
                <option <?php if($status==""){echo "selected";} ?> value="">Pilih</option>
                <option <?php if($status=="Sembuh"){echo "selected";} ?> value="Sembuh">Sembuh</option>
                <option <?php if($status=="Isoman"){echo "selected";} ?> value="Isoman">Isoman</option>
                <option <?php if($status=="Dirawat"){echo "selected";} ?> value="Dirawat">Dirawat</option>
                <option <?php if($status=="Meninggal"){echo "selected";} ?> value="Meninggal">Meninggal</option>
            </select>
        </div>
    </div>
<?php } ?>