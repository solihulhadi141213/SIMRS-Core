<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'6p4MtNxb88');
    if($StatusAkses=="Yes"){
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-4 col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <small id="NamaNegara">Indonesia</small>
                                    <dt>Propinsi (BPJS)</dt>
                                </div>
                                <div class="card-body" id="GetDataPropinsi">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <small id="NamaPropinsi">Propinsi</small>
                                    <dt>Kabupaten/Kota (BPJS)</dt>
                                </div>
                                <div class="card-body" id="GetDataKabupaten">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <small id="NamaKabupaten">Kabupaten</small>
                                    <dt>Kecamatan (BPJS)</dt>
                                </div>
                                <div class="card-body" id="GetDataKecamatan">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="styleSelector">

            </div>
        </div>
    </div>
<?php 
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>