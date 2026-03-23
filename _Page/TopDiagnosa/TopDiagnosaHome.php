<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=TopDiagnosa" class="h5">
                            <i class="ti ti-files"></i> Top Diagnosa
                        </a>
                    </h5>
                    <p class="m-b-0">Laporan Top Diagnosa</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="card">
                    <div class="card-header">
                        <form action="javascript:void(0);" id="FilterLaporanTopDiagnosa">
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <input type="date" class="form-control" name="periode_1" id="periode_1">
                                    <label for="periode_1">
                                        <small>Periode Awal</small>
                                    </label>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <input type="date" class="form-control" name="periode_2" id="periode_2">
                                    <label for="periode_2">
                                        <small>Periode Akhir</small>
                                    </label>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <select class="form-control" name="tujuan" id="tujuan">
                                        <option value="">Pilih</option>
                                        <option value="Rajal">Rajal</option>
                                        <option value="Ranap">Ranap</option>
                                    </select>
                                    <label for="periode_2">
                                        <small>Tujuan Kunjungan</small>
                                    </label>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <select class="form-control" name="kategori" id="kategori">
                                        <option value="">Pilih</option>
                                        <?php
                                            $query = "SELECT DISTINCT kategori FROM diagnosis_pasien WHERE kategori IS NOT NULL AND kategori != '' ORDER BY kategori ASC";
                                            $result = mysqli_query($Conn, $query);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . htmlspecialchars($row['kategori']) . '">' . htmlspecialchars($row['kategori']) . '</option>';
                                            }
                                        ?>
                                    </select>
                                    <label for="periode_2">
                                        <small>Kategori</small>
                                    </label>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <button type="button" class="btn btn-md btn-block btn-primary" id="TampilkanDataTopDiagnosa">
                                        Tampilkan
                                    </button>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <button type="button" class="btn btn-md btn-block btn-dark" id="ExportDataTopDiagnosa">
                                        Export
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="table table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><dt>No</dt></th>
                                                <th class="text-center"><dt>Kode</dt></th>
                                                <th class="text-center"><dt>Deskripsi</dt></th>
                                                <th class="text-center"><dt>Laki-Laki</dt></th>
                                                <th class="text-center"><dt>Perempuan</dt></th>
                                                <th class="text-center"><dt>Jumlah</dt></th>
                                                <th class="text-center"><dt>Persentase</dt></th>
                                            </tr>
                                        </thead>
                                        <tbody id="TabelTopDiagnosa">
                                            <tr>
                                                <td colspan="7" align="center">
                                                    <i>Tidak Ada Data Yang Ditampilkan</i>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>