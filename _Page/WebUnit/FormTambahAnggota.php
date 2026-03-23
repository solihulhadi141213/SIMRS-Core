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
            <label for="nama_karyawan">Nama Anggota</label>
            <input type="text" id="nama_karyawan" name="nama_karyawan" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="posisi_jabatan">Posisi Jabatan</label>
            <input type="text" id="posisi_jabatan" name="posisi_jabatan" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="sk_jabatan">SK Jabatan</label>
            <input type="text" id="sk_jabatan" name="sk_jabatan" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="foto">Foto</label>
            <input type="file" id="foto" name="foto" class="form-control">
            <small>Maksimal file 2 mb (jpg, jpeg, png & gif)</small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3" id="NotifikasiTambahAnggota">
            <small class="text-primary">Pastikan informasi anggota unit yang anda input sudah sesuai</small>
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