
<div class="page-wrapper">
    <div class="page-body">
        <div class="card">
            <div class="card-header border-info">
                <form action="javascript:void(0);" id="JalankanProsesAutoUpdate" method="POST">
                    <div class="row">
                        <div class="col-8 mt-2">
                            <h4>Autoupdate Aplicare</h4>
                            <small>Aktivkan halaman ini untuk melakukan autoupdate</small>
                        </div>
                        <div class="col-2">
                            <input type="number" min="1" class="form-control" name="timeupdate" id="timeupdate" value="500">
                            <input type="hidden" name="play_stop" id="play_stop" value="play">
                            <small id="KeteranganAutoUpdate">Time Update (dalam ms)</small>
                        </div>
                        <div class="col-md-2" id="ButtonClassUpdate">
                            <button type="submit" class="btn btn-sm btn-outline-secondary" id="TombolPlay"><i class="ti-control-play"></i> Play</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h5><dt>Data Ruangan RS</dt></h5>
                    </div>
                    <div class="card-body" id="AutoUpdateDataRuanganRS">

                    </div>
                </div>
            </div>
            <div class="col-6 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h5><dt>Data Ruangan Aplicare</dt></h5>
                    </div>
                    <div class="card-body" id="AutoUpdateDataRuanganBpjs">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
