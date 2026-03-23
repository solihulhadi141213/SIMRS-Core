<div class="row">
    <div class="col-xl-12 col-md-12">
        <div class="card table-card">
            <div class="card-header">
                <form action="javascript:void(0);" id="BatasPencarian">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <small>Batas Data</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kodebooking">Kode Booking</option>
                                <option value="id_pasien">No.RM</option>
                                <option value="nama">Nama Pasien</option>
                                <option value="nopeserta">Nomor BPJS</option>
                                <option value="tanggal_daftar">Tanggal Daftar</option>
                                <option value="tanggaloperasi">Tanggal Operasi</option>
                                <option value="jenistindakan">Jenis Tindakan</option>
                                <option value="kodepoli">Kode Poliklinik</option>
                                <option value="namapoli">Nama Poliklinik</option>
                                <option value="terlaksana">Status</option>
                                <option value="lastupdate">Update Terakhir</option>
                            </select>
                            <small>Dasar Pencarian</small>
                        </div>
                        <div class="col-md-4 mb-3" id="FormKeyword">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                            <small>Pencarian</small>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button type="submit" class="btn btn-sm btn-outline-secondary btn-block"><i class="ti-search"></i> Cari</button>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#ModalCaripasien">
                                <i class="ti ti-plus text-white"></i> Buat Jadwal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="MenampilkanJadwalOperasi">
                <!--  menampilkan data operasi disini -->
            </div>
        </div>
    </div>
</div>