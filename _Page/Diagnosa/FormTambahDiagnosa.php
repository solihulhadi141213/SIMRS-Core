<form action="javascript:void(0);" id="ProsesTambahDiagnosa" autocomplete="off">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mt-3">
                <label for="versi"><dt>Versi</dt></label>
                <select name="versi" id="versi" class="form-control" required>
                    <option value="ICD9">ICD9</option>
                    <option value="ICD10">ICD10</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <label for="kode"><dt>Kode Diagnosa</dt></label>
                <input type="text" name="kode" id="kode" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <label for="long_des"><dt>Long Description</dt></label>
                <input type="text" name="long_des" id="long_des" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3">
                <label for="short_des"><dt>Short Description</dt></label>
                <input type="text" name="short_des" id="short_des" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-3" id="NotifikasiTambahDiagnosa">
                <dt>Keterangan :</dt>
                Pastikan data yang anda input sudah benar.
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-sm btn-inverse mt-2">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-light mt-2 ml-3" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</form>