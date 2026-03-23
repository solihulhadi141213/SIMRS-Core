<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            A.3 Monitoring Rujukan Keluar
        </h4>
    </div>
    <div class="card-block accordion-block">
        <form action="javascript:void(0);" id="ProsesPencarianMonitoringRujukanKeluar">
            <div class="row mb-3">
                <div class="col-md-6 mb-3">
                    <input type="date" class="form-control" name="PeriodeAwal" id="PeriodeAwal" value="<?php echo "$firstDayOfMonth";?>">
                    <label for="PeriodeAwal">Periode Awal</label>
                </div>
                <div class="col-md-6 mb-3">
                    <input type="date" class="form-control" name="PeriodeAkhir" id="PeriodeAkhir" value="<?php echo date('Y-m-d') ?>">
                    <label for="PeriodeAkhir">Periode Akhir</label>
                </div>
                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-sm btn-primary btn-block btn-round">
                        <i class="ti ti-search"></i> Tampilkan Rujukan
                    </button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12" id="ListMonitoringRujukan">
                
            </div>
        </div>
    </div>
</div>