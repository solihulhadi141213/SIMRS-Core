<div class="row">
    <div class="col-md-6">
        <input type="file" name="file_import" id="file_import" class="form-control" required>
        <small for="file_import">File Import (Excel)</small>
    </div>
    <div class="col-md-3">
        <a href="_Page/Obat/TamplateObat.xlsx" target="_blank" class="btn btn-md btn-block btn-secondary">
            <i class="icofont-download"></i> Tamplate
        </a>
    </div>
    <div class="col-md-3">
        <button type="button" class="btn btn-md btn-block btn-success" id="ClickTampilkan">
            <i class="icofont-table"></i> Tampilkan
        </button>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12 pre-scrollable">
        <div class="table table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="bg-dark">
                    <tr>
                        <th class="text-center text-white">No</th>
                        <th class="text-center text-white">Obat</th>
                        <th class="text-center text-white">Satuan</th>
                        <th class="text-center text-white">Harga</th>
                        <th class="text-center text-white">Status</th>
                    </tr>
                </thead>
                <tbody id="TampilkanDataImport">
                    <tr>
                        <td colspan="6" class="text-center">Belum Ada Data Yang Ditampilkan</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12" id="NotifikasiImportObat">
        <span class="text-info">KETERANGAN : Sistem hanya akan melakukan input pada data dengan status Ready</span>
    </div>
</div>