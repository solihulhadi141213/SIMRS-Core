<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            A.1 Monitoring Data SEP (Kunjungan)
        </h4>
    </div>
    <div class="card-block accordion-block">
        <form action="javascript:void(0);" id="ProsesPencarianMonitoringKunjungan">
            <div class="row mb-3">
                <div class="col-md-4 mb-3">
                    <input type="date" class="form-control" name="KunjunganPeriodeAwal" id="KunjunganPeriodeAwal" value="<?php echo "$firstDayOfMonth";?>">
                    <label for="KunjunganPeriodeAwal">Periode Awal</label>
                </div>
                <div class="col-md-4 mb-3">
                    <input type="date" class="form-control" name="KunjunganPeriodeAkhir" id="KunjunganPeriodeAkhir" value="<?php echo date('Y-m-d') ?>">
                    <label for="KunjunganPeriodeAkhir">Periode Akhir</label>
                </div>
                <div class="col-md-4 mb-3">
                    <select name="JenisPelayanan" id="JenisPelayanan" class="form-control">
                        <option value="1">Rawat Inap</option>
                        <option value="2">Rawat Jalan</option>
                    </select>
                    <label for="JenisPelayanan">Jenis Pelayanan</label>
                </div>
                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-sm btn-primary btn-block btn-round">
                        <i class="ti ti-search"></i> Tampilkan Monitoring Kunjungan
                    </button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12" id="ListMonitoringKunjungan">
                
            </div>
        </div>
    </div>
</div>