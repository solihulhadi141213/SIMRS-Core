<form action="javascript:void(0);" method="POST" id="ProsesPencarian">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mt-4">
                <label for="nik"><dt>Pencarian</dt></label>
                <select name="search_by" id="search_by" class="form-control">
                    <option value="nik">NIK</option>
                    <option value="nomorkartu">No.BPJS</option>
                    <option value="kodebooking">Kode Booking</option>
                </select>
            </div>
            <div class="col-md-6 mt-4">
                <label for="nomorkartu"><dt>Keyword</dt></label>
                <input type="text" name="keyword" id="keyword" class="form-control">
            </div>
        </div>
        <div class="row m-t-25 text-left">
            <div class="col-12" id="HasilPencarianData">
                <span class="text-info">Silahkan masukan data anda untuk memulai pencarian data.</span>
            </div>
        </div>
        <div class="row m-t-30">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">
                    Cari Data
                </button>
            </div>
        </div>
    </div>
</form>