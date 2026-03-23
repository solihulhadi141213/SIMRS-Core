<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'NaRe5gboHP');
    if($StatusAkses=="Yes"){
?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-10 mb-3">
                    <h4><i class="icofont-drug"></i> Master Wilayah</h4>
                    Kamus Farmasi dan Alat Kesehatan (KFA) Dari Satu Sehat
                </div>
                <div class="col-md-2 mb-2">
                    <button type="button" class="btn btn-sm btn-block btn-info" id="ReloadWilayah">
                        <i class="ti-reload"></i> Reload
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col col-md-12" id="TabelWilayah">

                </div>
            </div>
        </div>
    </div>
<?php 
    }else{
        include "_Page/UnPage/ErrorPageSubCard.php";
    }
?>