<div class="row">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h4><i class="ti ti-search"></i> Pencarian Antrian SIMRS</h4>
            </div>
            <div class="card-body">
                <form action="javascript:void(0);" id="BatasPencarian">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <select name="batas" id="batas" class="form-control">
                                <option value="5">5</option>
                                <option selected value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <small>Batas</small>
                        </div>
                        <div class="col-md-8 mb-3">
                            <select name="keyword_by" id="keyword_by" class="form-control">
                                <option value="">Pilih</option>
                                <option value="kodebooking">Kode Booking</option>
                                <option value="id_kunjungan">No.REG/ID Kunjungan</option>
                                <option value="id_pasien">No.RM</option>
                                <option value="nama_pasien">Nama Pasien</option>
                                <option value="nomorkartu">Nomor Kartu</option>
                                <option value="nik">NIK</option>
                                <option value="tanggal_daftar">Tanggal Daftar</option>
                                <option value="tanggal_kunjungan">Tanggal Kunjungan</option>
                                <option value="nama_dokter">Dokter</option>
                                <option value="namapoli">Poliklinik</option>
                                <option value="keluhan">Keluhan</option>
                                <option value="pembayaran">Pembayaran</option>
                                <option value="nomorreferensi">No.Referensi</option>
                                <option value="status">Status</option>
                                <option value="sumber_antrian">Sumber Data</option>
                            </select>
                            <small>Keyword By</small>
                        </div>
                        <div class="col-md-12 mb-3" id="FormKeyword">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                            <small>Keyword</small>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-sm btn-outline-secondary btn-block"><i class="ti-search"></i> Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4><i class="ti ti-search"></i> Pencarian Antrian BPJS</h4>
            </div>
            <div class="card-body">
                <form action="javascript:void(0);" id="PencarianAntrianBpjs">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <select name="ModePencarianAntrian" id="ModePencarianAntrian" class="form-control">
                                <option selected value="">Pilih</option>
                                <option value="Antrian Per Tanggal">Antrian Per Tanggal</option>
                                <option value="Antrian Per Kode Boking">Antrian Per Kode Boking</option>
                                <option value="Antrian Belum Dilayani">Antrian Belum Dilayani</option>
                                <option value="Antrian Belum Dilayani Per Poli">Antrian Belum Dilayani Per Poli</option>
                            </select>
                            <small>Mode Pencarian</small>
                        </div>
                    </div>
                    <div class="row" id="FormLanjutanPencarianAntrianBpjs"></div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-sm btn-outline-secondary btn-block"><i class="ti-search"></i> Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-primary btn-block mb-4" data-toggle="modal" data-target="#ModalAddAntrianManual">
            <i class="ti ti-plus text-white"></i> Buat Antrian
        </button>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div id="MenampilkanDataAntrian">
                <!--  menampilkan data Pasien disini -->
            </div>
        </div>
    </div>
</div>
