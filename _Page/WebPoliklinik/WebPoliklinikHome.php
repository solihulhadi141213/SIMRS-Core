<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=WebPoliklinik" class="h5"><i class="ti ti-view-grid"></i> Poliklinik</a>
                    </h5>
                    <p class="m-b-0">Kelola data Poliklinik halaman website</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <div class="page-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="card table-card">
                            <div class="card-header border-info">
                                <form action="javascript:void(0);" id="BatasPencarian">
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <select name="batas" id="batas" class="form-control">
                                                <option value="5">5</option>
                                                <option selected value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            <small>Batas</small>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <select name="keyword_by" id="keyword_by" class="form-control">
                                                <option value="">Semua</option>
                                                <?php
                                                    include "_Config/SettingKoneksiWeb.php";
                                                    include "_Config/WebFunction.php";
                                                    $url=urlServiceInline('Info Poliklinik');
                                                    $JdonDataInfo=GetInfoPoliklinik($api_key,$url);
                                                    $massage=$JdonDataInfo['metadata']['massage'];
                                                    if($massage=="Berhasil"){
                                                        $list_kolom=$JdonDataInfo['response']['list_kolom'];
                                                        foreach ($list_kolom as $value){
                                                            $Kolom=$value['nama_kolom'];
                                                            if($Kolom=="id_poliklinik"){
                                                                $LabelKolom="ID";
                                                            }else{
                                                                if($Kolom=="nama"){
                                                                    $LabelKolom="Nama Poli";
                                                                }else{
                                                                    if($Kolom=="deskripsi"){
                                                                        $LabelKolom="Deskripsi Poli";
                                                                    }else{
                                                                        if($Kolom=="kode"){
                                                                            $LabelKolom="Kode Poli";
                                                                        }else{
                                                                            if($Kolom=="last_update"){
                                                                                $LabelKolom="Update Time";
                                                                            }else{
                                                                                if($Kolom=="status"){
                                                                                    $LabelKolom="Status";
                                                                                }else{
                                                                                    $LabelKolom="$Kolom";
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            echo '<option value="'.$value['nama_kolom'].'">'.$LabelKolom.'</option>';
                                                        }
                                                    }else{
                                                        echo '<option>'.$massage.'</option>';
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
                                                <i class="ti-search"></i> Mulai Pencarian
                                            </button>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-block btn-primary" data-toggle="modal" data-target="#ModalTambahPoliklinik">
                                                <i class="ti-plus text-white"></i> Tambah Poliklinik
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div id="MenampilkanTabelPoliklinik">
                                <!--  menampilkan data Poliklinik disini -->
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