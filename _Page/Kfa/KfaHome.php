<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'5bbcS3mJoY');
    if($StatusAkses=="Yes"){
?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8 mb-3">
                    <h4><i class="icofont-drug"></i> Kamus Farmasi & Alkes</h4>
                    Kamus Farmasi dan Alat Kesehatan (KFA) Dari Satu Sehat
                </div>
                <div class="col-md-2 mb-2">
                    <button type="button" class="btn btn-sm btn-block btn-secondary" data-toggle="modal" data-target="#ModalFilterKfa">
                        <i class="ti-filter"></i> Filter
                    </button>
                </div>
                <div class="col-md-2 mb-2">
                    <button type="button" class="btn btn-sm btn-block btn-info" id="ReloadKfa">
                        <i class="ti-reload"></i> Reload
                    </button>
                </div>
            </div>
        </div>
        <div id="TabelKfa">
            
        </div>
    </div>
<?php 
    }else{
        include "_Page/UnPage/ErrorPageSubCard.php";
    }
?>