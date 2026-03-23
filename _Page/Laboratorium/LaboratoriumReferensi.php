<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <form action="javascript:void(0);" id="PencarianParameter">
                                    <input type="hidden" name="page" id="page" value="1">
                                    <div class="row">
                                        <div class="col-md-1 mb-3">
                                            <select name="batas" id="batas_parameter" class="form-control">
                                                <option value="5">5</option>
                                                <option selected value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            <small>Batas</small>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select name="keyword_by" id="keyword_by_parameter" class="form-control">
                                                <option value="">Semua</option>
                                                <?php
                                                    $NamaTabel="laboratorium_parameter";
                                                    $ListKolom=getColomList($Conn,$NamaTabel);
                                                    foreach ($ListKolom as $value){
                                                        $nama_kolom=$value['nama_kolom'];
                                                        if($nama_kolom=="parameter"){
                                                            echo '<option value="'.$nama_kolom.'">Parameter</option>';
                                                        }else{
                                                            if($nama_kolom=="kategori_parameter"){
                                                                echo '<option value="'.$nama_kolom.'">Kategori Parameter</option>';
                                                            }else{
                                                                if($nama_kolom=="tipe_data"){
                                                                    echo '<option value="'.$nama_kolom.'">Tipe Data</option>';
                                                                }else{
                                                                    if($nama_kolom=="nilai_rujukan"){
                                                                        echo '<option value="'.$nama_kolom.'">Nilai Rujukan</option>';
                                                                    }else{
                                                                        if($nama_kolom=="nilai_kritis"){
                                                                            echo '<option value="'.$nama_kolom.'">Nilai Kritis</option>';
                                                                        }else{
                                                                            
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </select>
                                            <small>Pencarian</small>
                                        </div>
                                        <div class="col-md-3 mb-3" id="FormKeyword">
                                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                            <small>Kata Kunci</small>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="submit" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti-search"></i> Cari
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-sm btn-block btn-secondary" data-toggle="modal" data-target="#ModalExportParameterLaboratorium" title="Export Parameter Pemeriksaan">
                                                <i class="ti ti-export"></i> Export
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-sm btn-block btn-primary" data-toggle="modal" data-target="#ModalTambahParameter" title="Tambah Parameter Pemeriksaan">
                                                <i class="ti-plus text-white"></i> Tambah Parameter
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="TabelParameterLaboratorium">
                                <!--  Menampilkan Tabel Parameter Laboratorium-->
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