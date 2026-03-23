<?php
    //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

?>>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="tanggal">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?php echo date('Y-m-d');?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="jam">Jam</label>
            <input type="time" id="jam" name="jam" class="form-control" value="<?php echo date('H:i');?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nama_testimoni">Nama Pengirim</label>
            <input type="text" id="nama_testimoni" name="nama_testimoni" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label for="email">Email Pengirim</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="isi_testimoni">Isi Testimoni</label>
            <textarea name="isi_testimoni" id="isi_testimoni" class="form-control" cols="30" rows="3"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="status_testimoni">Status</label>
            <select name="status_testimoni" id="status_testimoni" class="form-control">
                <option value="">Pilih</option>
                <option value="Pending">Pending</option>
                <option value="Draft">Draft</option>
                <option value="Publish">Publish</option>
            </select>
        </div>
        <div class="col-md-6 mb-3">
            <label for="image_testimoni">File Foto</label>
            <input type="file" id="image_testimoni" name="image_testimoni" class="form-control">
            <small>Maksimal file 2 mb (jpg, jpeg, png & gif)</small>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3" id="NotifikasiTambahTestimoni">
            <small class="text-primary">Pastikan informasi testimoni yang anda input sudah sesuai</small>
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