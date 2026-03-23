<?php
    if(empty($_POST['bpjs'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12">';
        echo '      <span class="text-danger">No BPJS Tidak Boleh Kosong!</span>';
        echo '  </div>';
        echo '</div>';
    }else{
        $bpjs=$_POST['bpjs'];
?>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="btn-group btn-block w-100">
                <button type="button" class="btn btn-md btn-outline-primary" id="DetailBpjsDariSimrs">
                    SIMRS
                </button>
                <button type="button" class="btn btn-md btn-outline-primary" id="DetailBpjsDariBpjs">
                    BPJS
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3" id="DetailPasienBpjs">
            <div class="alert alert-info" role="alert">  
                Silahkan Pilih Mode Pencarian SIMRS atau webservice BPJS Terlebih Dulu.
            </div>
        </div>
    </div>
<?php } ?>