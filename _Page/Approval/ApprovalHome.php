<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <form action="javascript:void(0);" id="PencarianApproval">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4><i class="ti ti-search"></i> Pencarian Approval</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-3 mb-3">
                                            <select class="form-control" name="bulan" id="bulan">
                                                <option value="">Pilih</option>
                                                <?php
                                                    $bulan = array(
                                                        '01' => "Januari",
                                                        '02' => "Februari",
                                                        '03' => "Maret",
                                                        '04' => "April",
                                                        '05' => "Mei",
                                                        '06' => "Juni",
                                                        '07' => "Juli",
                                                        '08' => "Agustus",
                                                        '09' => "September",
                                                        '10' => "Oktober",
                                                        '11' => "November",
                                                        '12' => "Desember"
                                                    );
                                                    foreach ($bulan as $angka => $NamaBulan) {
                                                        if(date('m')==$angka){
                                                            echo '<option selected value="'.$angka.'">'.$NamaBulan.'</option>';
                                                        }else{
                                                            echo '<option value="'.$angka.'">'.$NamaBulan.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <small>Bulan</small>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <select class="form-control" name="tahun" id="tahun">
                                                <?php
                                                    $tahun_saat_ini = date('Y');
                                                    for ($tahun = $tahun_saat_ini; $tahun >= ($tahun_saat_ini - 10); $tahun--) {
                                                        echo '<option value="'.$tahun.'">'.$tahun.'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <small>Tahun</small>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select class="form-control" name="sumber" id="sumber">
                                                <option value="RS">Database RS</option>
                                                <option value="BPJS">WS BPJS</option>
                                            </select>
                                            <small>Sumber</small>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary btn-block">
                                                <i class="ti-search"></i> Mulai Pencarian
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#ModalTambahApproval">
                                                <i class="ti-plus"></i> Buat Approval
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div  class="table table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center"><dt>No</dt></th>
                                                            <th class="text-center"><dt>Tanggal</dt></th>
                                                            <th class="text-center"><dt>Pasien</dt></th>
                                                            <th class="text-center"><dt>Pelayanan</dt></th>
                                                            <th class="text-center"><dt>Status</dt></th>
                                                            <th class="text-center"><dt>Option</dt></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="TabelApproval">
                                                        <tr>
                                                            <td colspan="6" class="text-center text-danger">
                                                                Tidak Ada Data Approval Yang Ditemukan
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>