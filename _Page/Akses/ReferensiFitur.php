<?php
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'Ni4cfmtrUT');
    if($StatusAkses=="Yes"){
?>
    <div class="row">
        <div class="col-md-12 mb-3">
            <h5># Referensi Fitur</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card table-card">
                <div class="card-header">
                    <form action="javascript:void(0);" id="BatasPencarianReferensi">
                        <input type="hidden" name="page" id="PutPageReferensi">
                        <div class="row">
                            <div class="col-md-1 mb-3">
                                <select name="batas_referensi" id="batas_referensi" class="form-control">
                                    <option value="5">5</option>
                                    <option selected value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <small>Batas</small>
                            </div>
                            <div class="col-md-2 mb-3">
                                <select name="keyword_by_referensi" id="keyword_by_referensi" class="form-control">
                                    <option value="">Pilih</option>
                                    <?php
                                        //Menampilkan list keyword_by
                                        $NamaTabel="akses_ref";
                                        $ListKolom=getColomList($Conn,$NamaTabel);
                                        foreach ($ListKolom as $value){
                                            $nama_kolom=$value['nama_kolom'];
                                            if($nama_kolom=="nama_fitur"){
                                                echo '<option value="'.$nama_kolom.'">Nama Fitur</option>';
                                            }else{
                                                if($nama_kolom=="kategori"){
                                                    echo '<option value="'.$nama_kolom.'">Kategori Fitur</option>';
                                                }else{
                                                    if($nama_kolom=="kode"){
                                                        echo '<option value="'.$nama_kolom.'">Kode Fitur</option>';
                                                    }else{
                                                        if($nama_kolom=="keterangan "){
                                                            echo '<option value="'.$nama_kolom.'">Keterangan</option>';
                                                        }else{
                                                            
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                                <small>Keyword By</small>
                            </div>
                            <div class="col-md-3 mb-3" id="FormKeywordReferensi">
                                <input type="text" class="form-control" name="keyword_referensi" id="keyword_referensi" placeholder="Kata Kunci">
                                <small>Pencarian</small>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="submit" class="btn btn-sm btn-secondary btn-block"><i class="ti-search"></i> Cari</button>
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="button" class="btn btn-sm btn-block btn-inverse" data-toggle="modal" data-target="#ModalExportReferensi" title="Export Data Referensi Akses">
                                    <i class="ti ti-export"></i> Eksport
                                </button>
                            </div>
                            <div class="col-md-2 mb-3">
                                <a href="javascript:void(0);" class="btn btn-sm btn-block btn-primary" data-toggle="modal" data-target="#ModalTambahReferensi" title="Tambah Referensi Akses">
                                    <i class="ti-plus text-white"></i> Tambah
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="MenampilkanTabelReferensiAkses">
                    <!--  Menampilkan data Referensi akses disini -->
                </div>
            </div>
        </div>
    </div>
<?php 
    }else{
        include "_Page/UnPage/ErrorPageSub.php";
    }
?>