<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/FungsiSirsOnline.php";
    if(!empty($_POST['id_nakes_pcr'])){
        $id_nakes_pcr=$_POST['id_nakes_pcr'];
        $nama_nakes=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'nama_nakes');
        $kategori_nakes=getDataDetail($Conn,'nakes_pcr','id_nakes_pcr',$id_nakes_pcr,'kategori_nakes');
    }else{
        $id_nakes_pcr="";
        $nama_nakes="";
        $kategori_nakes="";
    }
?>

<div class="row mb-3">
    <div class="col-md-3">
        <label for="id_nakes_pcr">ID.PCR</label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <input type="text" readonly name="id_nakes_pcr" id="id_nakes_pcr" class="form-control" value="<?php echo $id_nakes_pcr; ?>">
            <button type="button" title="Pilih ID PCR Nakes" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#ModalPilihPcrNakes">
                <i class="ti ti-plus"></i>
            </button>
        </div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-3">
        <label for="nama">Nama Nakes</label>
    </div>
    <div class="col-md-9">
        <input type="text" readonly name="nama" id="nama" class="form-control" value="<?php echo $nama_nakes; ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-3">
        <label for="kategori">Kategori Nakes</label>
    </div>
    <div class="col-md-9">
        <input type="text" readonly name="kategori" id="kategori" list="list_kategori_nakes" class="form-control" autocomplete="off" value="<?php echo $kategori_nakes; ?>">
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
        <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-3">
        <label for="status">Status</label>
    </div>
    <div class="col-md-9">
        <select name="status" id="status" class="form-control">
            <option value="">Pilih</option>
            <option value="Sembuh">Sembuh</option>
            <option value="Isoman">Isoman</option>
            <option value="Dirawat">Dirawat</option>
            <option value="Meninggal">Meninggal</option>
        </select>
    </div>
</div>