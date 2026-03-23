<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <form action="javascript:void(0);" id="PencarianPermintaanLab">
                                    <div class="row">
                                        <div class="col-md-1 mb-3">
                                            <select name="batas_permintaan" id="batas_permintaan" class="form-control">
                                                <option value="5">5</option>
                                                <option selected value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            <small>Batas</small>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select name="keyword_by_permintaan" id="keyword_by_permintaan" class="form-control">
                                                <option value="">Semua</option>
                                                <?php
                                                    $NamaTabel="laboratorium_permintaan";
                                                    $ListKolom=getColomList($Conn,$NamaTabel);
                                                    foreach ($ListKolom as $value){
                                                        $nama_kolom=$value['nama_kolom'];
                                                        if($nama_kolom=="nama_pasien"){
                                                            echo '<option value="'.$nama_kolom.'">Nama Pasien</option>';
                                                        }else{
                                                            if($nama_kolom=="id_pasien"){
                                                                echo '<option value="'.$nama_kolom.'">No.RM</option>';
                                                            }else{
                                                                if($nama_kolom=="tanggal"){
                                                                    echo '<option value="'.$nama_kolom.'">Tanggal Permintaan</option>';
                                                                }else{
                                                                    if($nama_kolom=="faskes"){
                                                                        echo '<option value="'.$nama_kolom.'">Nama Faskes</option>';
                                                                    }else{
                                                                        if($nama_kolom=="unit"){
                                                                            echo '<option value="'.$nama_kolom.'">Unit Yang Meminta</option>';
                                                                        }else{
                                                                            if($nama_kolom=="prioritas"){
                                                                                echo '<option value="'.$nama_kolom.'">Prioritas</option>';
                                                                            }else{
                                                                                if($nama_kolom=="status"){
                                                                                    echo '<option value="'.$nama_kolom.'">Status Permintaan</option>';
                                                                                }else{
                                                                                    // if($nama_kolom=="keterangan_permintaan"){
                                                                                    //     echo '<option value="'.$nama_kolom.'">Keterangan Permintaan</option>';
                                                                                    // }else{
                                                                                    //     if($nama_kolom=="nama_signature"){
                                                                                    //         echo '<option value="'.$nama_kolom.'">Nama Pemohon</option>';
                                                                                    //     }else{
                                                                                    //         if($nama_kolom=="id_pasien"){
                                                                                    //             echo '<option value="'.$nama_kolom.'">No.RM</option>';
                                                                                    //         }else{
                                                                                    //             echo '<option value="'.$nama_kolom.'">'.$nama_kolom.'</option>';
                                                                                    //         }
                                                                                    //     }
                                                                                    // }
                                                                                }
                                                                            }
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
                                        <div class="col-md-3 mb-3" id="FormKeywordPermintaan">
                                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Kata Kunci">
                                            <small>Kata Kunci</small>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="submit" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti-search"></i> Cari
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <button type="button" class="btn btn-sm btn-block btn-inverse" data-toggle="modal" data-target="#ModalExportPermintaanLab" title="Export Data Permintaan Lab">
                                                <i class="ti ti-export"></i> Export
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <a href="index.php?Page=Laboratorium&Sub=TambahPermintaanLab" class="btn btn-sm btn-block btn-primary" title="Tambah Permintaan Lab">
                                                <i class="ti-plus text-white"></i> Pendaftaran
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="TabelPermintaanLaboratorium">
                                <!--  Menampilkan Tabel Permintaan Laboratorium-->
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