<?php
    if(empty($_POST['nik'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">NIK Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $nik=$_POST['nik'];
?>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="btn-group btn-block w-100">
                <button type="button" class="btn btn-md btn-outline-primary" id="DetailDariSimrs">
                    SIMRS
                </button>
                <button type="button" class="btn btn-md btn-outline-primary" id="DetailDariBpjs">
                    BPJS
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3" id="DetailPasienNik">
            <div class="alert alert-info" role="alert">  
                Silahkan Pilih Mode Pencarian SIMRS atau webservice BPJS Terlebih Dulu.
            </div>
        </div>
    </div>
<?php } ?>