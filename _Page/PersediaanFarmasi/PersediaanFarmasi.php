<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5"><i class="ti ti-list"></i> Persediaan - Farmasi</a>
                    </h5>
                    <p class="m-b-0">Kelola data persediaan barang unit farmasi</p>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="javascript:void(0);" id="ProsesFilter">
    <input type="hidden" name="page" id="page" value="1">
    <input type="hidden" name="tahun" id="tahun" value="2023">
</form>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-9">
                                        <span class="badge badge-inverse" id="periode_data">PERIODE TAHUN</span>
                                    </div>
                                    <div class="col-1 text-end">
                                        <button type="button" class="btn btn-sm btn-block btn-secondary pilih_tahun" data-id="2023">
                                            2023
                                        </button>
                                    </div>
                                    <div class="col-1 text-end">
                                        <button type="button" class="btn btn-sm btn-block btn-secondary pilih_tahun" data-id="2024">
                                            2024
                                        </button>
                                    </div>
                                    <div class="col-1 text-end">
                                        <button type="button" class="btn btn-sm btn-block btn-secondary pilih_tahun" data-id="2025">
                                            2025
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                               <div class="row mb-3">
                                <div class="col-6"><dt>JUMLAH TOTAL</dt></div>
                                <div class="col-6 text-right"><dt id="JumlahTotal">Rp</dt></div>
                               </div>
                               <div class="row">
                                <div class="col-12">
                                    <div class="table table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="bg-dark">
                                                    <td class="text-center"><dt class="text-light">No</dt></td>
                                                    <td class="text-center"><dt class="text-light">Nama Barang</dt></td>
                                                    <td class="text-center"><dt class="text-light">Kategori</dt></td>
                                                    <td class="text-center"><dt class="text-light">Harga + PPN</dt></td>
                                                    <td class="text-center"><dt class="text-light">QTY</dt></td>
                                                    <td class="text-center"><dt class="text-light">Satuan</dt></td>
                                                    <td class="text-center"><dt class="text-light">Jumlah</dt></td>
                                                </tr>
                                            </thead>
                                            <tbody id="TabelPersediaan">
                                                <tr>
                                                    <td colspan="7" class="text-center">Tidak Ada Data Yang Ditampilkan</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                               </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-6">
                                        <dt class="page_info">Page 1 / 1</dt>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="button" class="btn btn-sm btn-primary preview_button">
                                            <i class="ti ti-angle-left"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-primary next_button">
                                            <i class="ti ti-angle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
