<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'qUL6USfUbB');
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
                                            <h4><i class="icofont-chart-flow-1"></i> SNOMED</h4>
                                            Tampilkan referensi SNOMED CT. Referensi data selengkapnya dapat diakses pada halaman web <a href="https://mlds.ihtsdotools.org" class="text-success" target="_blank">berikut ini</a>
                                        </div>
                                    </div>
                                    <form action="javascript:void(0);" id="BatasPencarianSnomed">
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
                                            <div class="col-md-3 mb-3 mb-2">
                                                <select name="keyword_by" id="keyword_by" class="form-control">
                                                    <option value="">Pilih</option>
                                                    <option value="conceptId">ID Snomed</option>
                                                    <option value="term">Description</option>
                                                </select>
                                                <small>Keyword By</small>
                                            </div>
                                            <div class="col-md-4 mb-2" id="FormPencarianLoinc">
                                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                                <small>Keyword</small>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <button type="submit" class="btn btn-sm btn-block btn-secondary"><i class="ti-search"></i> Tampilkan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="TabelSnomed">
                                    
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