<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'x0mQfbm1FD');
    if($StatusAkses=="Yes"){
?>
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4><i class="ti-search"></i> Pencarian Wilayah (SIMRS)</h4>
                                </div>
                                <div class="card-body">
                                    <form action="javascript:void(0);" id="BatasPencarianInternal">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <select name="batas" id="batas" class="form-control">
                                                    <option value="5">5</option>
                                                    <option selected value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <small>Batas</small>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <select name="kategori" id="kategori" class="form-control">
                                                    <option value="">Semua</option>
                                                    <?php
                                                        $QryKategori = mysqli_query($Conn, "SELECT DISTINCT kategori FROM wilayah ORDER BY kategori ASC");
                                                        while ($DataKategori = mysqli_fetch_array($QryKategori)) {
                                                            $kategori= $DataKategori['kategori'];
                                                            if(!empty($kategori)){
                                                                if($kategori=="desa"){
                                                                    echo '<option value="'.$kategori.'">Desa</option>';
                                                                }else{
                                                                    echo '<option value="'.$kategori.'">'.$kategori.'</option>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <small>Kategori</small>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <select name="keyword_by" id="keyword_by" class="form-control">
                                                    <option value="">Semua</option>
                                                    <option value="propinsi">Propinsi</option>
                                                    <option value="kabupaten">Kabupaten</option>
                                                    <option value="kecamatan">Kecamatan</option>
                                                    <option value="desa">Desa</option>
                                                </select>
                                                <small>Keyword By</small>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <button type="submit" class="btn btn-sm btn-secondary btn-block"><i class="ti-search"></i> Mulai Pencarian</button>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <a href="javascript:void(0);" class="btn btn-sm btn-primary btn-block" data-toggle="modal" data-target="#ModalTambahWilayah">
                                                    <i class="ti-plus text-white"></i> Tambah Wilayah
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4><i class="ti ti-align-left"></i> List Wilayah (SIMRS)</h4>
                                </div>
                                <div id="MenampilkanTabelWilayahInternal">
                                    <!--  Menampilkan Tabel Wilayah Internal -->
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