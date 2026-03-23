<?php
    if(!empty($_POST['id_unit_instalasi'])){
        $id_unit_instalasi=$_POST['id_unit_instalasi'];
    }else{
        $id_unit_instalasi="";
    }
?>
<input type="hidden" id="id_unit_instalasi" name="id_unit_instalasi" value="<?php echo "$id_unit_instalasi";?>">
<div class="modal-body">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="judul_galeri">Judul Galeri</label>
            <input type="text" id="judul_galeri" name="judul_galeri" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="deskripsi_galeri">Deskripsi Galeri</label>
            <textarea name="deskripsi_galeri" id="deskripsi_galeri" class="form-control" cols="30" rows="3"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="file_galeri">File Galeri</label>
            <input type="file" id="file_galeri" name="file_galeri" class="form-control">
            <small>Maksimal file 2 mb (jpg, jpeg, png & gif)</small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3" id="NotifikasiTambahGaleri">
            <small class="text-primary">Pastikan informasi galeri yang anda input sudah sesuai</small>
        </div>
    </div>
</div>
<div class="modal-footer bg-primary">
    <button type="submit" class="btn btn-md btn btn-success">
        <i class="ti ti-save"></i> Simpan
    </button>
    <button type="button" class="btn btn-md btn btn-secondary" data-dismiss="modal">
        <i class="ti ti-close"></i> Tutup
    </button>
</div>