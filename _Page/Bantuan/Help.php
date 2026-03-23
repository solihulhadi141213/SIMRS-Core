<?php
    //Menangkap keyword GET
    if(empty($_GET['keyword'])){
        $keyword_get="";
    }else{
        $keyword_get=$_GET['keyword'];
    }
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="" class="h5">
                            <i class="ti ti-help-alt"></i> Bantuan
                        </a>
                    </h5>
                    <p class="m-b-0">Berikut ini adalah semua informasi untuk membantu pengguna memahami cara menggunakan aplikasi</p>
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
                    <div class="col-md-3 mb-3">
                        <form action="javascript:void(0);" id="ProsesPencarianHelp">
                            <input type="hidden" name="page" id="page" class="form-control">
                            <div class="card">
                                <div class="card-header">
                                    <dt class="card-title">
                                        <i class="ti ti-search"></i> Pencarian Bantuan
                                    </dt>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="batas">Batas Data</label>
                                            <select name="batas" id="batas" class="form-control">
                                                <option value="5">5</option>
                                                <option selected value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="keyword_by">Dasar Pencarian</label>
                                            <select name="keyword_by" id="keyword_by" class="form-control">
                                                <option value="">Pilih</option>
                                                <option value="tanggal">Tanggal Post</option>
                                                <option value="judul">Judul</option>
                                                <option value="kategori">Kategori Bantuan</option>
                                                <option value="isi">Isi Bantuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" id="FormKeyword">
                                            <label for="keyword">Kata Kunci</label>
                                            <input type="text" name="keyword" id="keyword" class="form-control" value="<?php echo $keyword_get;?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-sm btn-block btn-dark btn-round">
                                                <i class="ti ti-search"></i> Mulai Pencarian
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-9" id="TabelHelp">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
