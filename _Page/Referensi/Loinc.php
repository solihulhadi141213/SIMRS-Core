<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'HsAy0ZAzzt');
    if($StatusAkses=="Yes"){
        $JumlahLocation=mysqli_num_rows(mysqli_query($Conn, "SELECT*FROM referensi_location"));
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <h4><i class="icofont-chart-flow-1"></i> Loinc</h4>
                                            Tampilkan referensi LOINC. Referensi data <a href="https://loinc.org/" target="_blank" class="text-info">Selengkapnya</a>
                                        </div>
                                    </div>
                                    <form action="javascript:void(0);" id="BatasPencarianLoinc">
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <select name="batas" id="batas" class="form-control">
                                                    <option value="5">5</option>
                                                    <option selected value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <small>Batas</small>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <select name="keyword_by" id="keyword_by" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option value="loinc_num">NUM</option>
                                                    <option value="component">COMPONENT</option>
                                                    <option value="property">PROPERTY</option>
                                                    <option value="system">SYSTEM</option>
                                                    <option value="scale_typ">SCALE</option>
                                                </select>
                                                <small>Keyword By</small>
                                            </div>
                                            <div class="col-md-4 mb-2" id="FormPencarianLoinc">
                                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                                <small>Keyword</small>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <button type="submit" class="btn btn-sm btn-block btn-secondary"><i class="ti-search"></i> Cari</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="TabelLoinc">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>