<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'5bbcS3mJoY');
    if($StatusAkses=="Yes"){
?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <h4><i class="icofont-box"></i> Master Sarana Index</h4>
                    Master Sarana Index (MSI) Dari Satu Sehat
                </div>
                <div class="col-md-2 mb-2">
                    <button type="button" class="btn btn-sm btn-block btn-secondary" data-toggle="modal" data-target="#ModalFilterMsi">
                        <i class="ti-filter"></i> Filter
                    </button>
                </div>
                <div class="col-md-2 mb-2">
                    <button type="button" class="btn btn-sm btn-block btn-info" id="ReloadMsi">
                        <i class="ti-reload"></i> Reload
                    </button>
                </div>
            </div>
        </div>
        <div id="TabelMsi">
            
        </div>
    </div>
<?php 
    }else{
        include "_Page/UnPage/ErrorPageSubCard.php";
    }
?>