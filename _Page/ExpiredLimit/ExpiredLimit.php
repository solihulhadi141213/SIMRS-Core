<?php
    //Desiossion Akses
    $StatusAkses=GetStatusAccess($Conn,$SessionIdAkses,'ovp6E0xIFN');
    if($StatusAkses=="Yes"){
        //Routing Subpage
        if(empty($_GET['sub'])){
            $Sub="";
        }else{
            $Sub=$_GET['sub'];
        }
?>
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">
                            <a href="" class="h5">
                                <i class="icofont-ui-calendar"></i> Expired & Limit
                            </a>
                        </h5>
                        <p class="m-b-0">Kelola data expired dan stok hampir habis pada obat & alkes.</p>
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
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <dt class="card-title">
                                        <i class="ti ti-menu"></i> Menu Fitur
                                    </dt>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <a href="index.php?Page=ExpiredLimit&sub=ExpiredItem" class="btn btn-round btn-block btn-sm <?php if($Sub=="ExpiredItem"||$Sub==""){echo "btn-primary";}else{echo "btn-outline-primary";} ?> mr-3">
                                                <i class="ti ti-calendar"></i> Expired Item
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a href="index.php?Page=ExpiredLimit&sub=LimitItem" class="btn btn-round btn-block btn-sm <?php if($Sub=="LimitItem"){echo "btn-primary";}else{echo "btn-outline-primary";} ?>">
                                                <i class="icofont-warning"></i> Limit Item
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mt-4 mb-4">
                                        <div class="col-md-12 text-center">
                                            <dt>Keterangan</dt>
                                            <?php
                                                if($Sub=="ExpiredItem"||$Sub==""){
                                                    echo 'Expired item menampilkan data item obat & alkes yang akan melalui masa expired.';
                                                    echo 'Pada halaman ini petugas farmasi dapat melakukan konfirmasi apakah item tersebut terkonfirmasi atau tidak.';
                                                }else{
                                                    echo 'Limit item menampilkan data item obat & alkes yang akan hampir habis.';
                                                    echo 'Fitur ini membantu petugas untuk menentukan daftar belanja obat selanjutnya';
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <form action="javascript:void(0);" id="BatasExpiredLimit">
                                    <input type="hidden" name="page" class="form-control" id="GetPutPage" value="1">
                                    <div class="card-header">
                                        <dt class="card-title">
                                            <i class="ti ti-search"></i> Pencarian Data
                                        </dt>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php
                                                    if($Sub=="ExpiredItem"||$Sub==""){
                                                        echo '<input type="text" readonly id="CategoryData" class="form-control" value="ExpiredItem">';
                                                        echo '<small>Kategori Data</small>';
                                                    }else{
                                                        echo '<input type="text" readonly id="CategoryData" class="form-control" value="LimitItem">';
                                                        echo '<small>Kategori Data</small>';
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <select name="batas" id="batas" class="form-control">
                                                    <option value="5">5</option>
                                                    <option selected value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <small>
                                                    <label for="batas">Batas Data</label>
                                                </small>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <select name="keyword_by" id="keyword_by" class="form-control">
                                                    <?php
                                                        if($Sub=="ExpiredItem"||$Sub==""){
                                                            echo '<option value="">Pilih</option>';
                                                            echo '<option value="batch">Kode Batch</option>';
                                                            echo '<option value="nama">Nama Item</option>';
                                                            echo '<option value="satuan">Satuan</option>';
                                                            echo '<option value="expired">Expired</option>';
                                                            echo '<option value="ingatkan">Ingatkan</option>';
                                                            echo '<option value="status">Status Ketersediaan</option>';
                                                            echo '<option value="status_expired">Status Expired</option>';
                                                        }else{
                                                            echo '<option value="">Pilih</option>';
                                                            echo '<option value="kode">Kode</option>';
                                                            echo '<option value="nama">Nama</option>';
                                                            echo '<option value="kelompok">Kelompok</option>';
                                                            echo '<option value="kategori">Kategori</option>';
                                                            echo '<option value="satuan">Satuan</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <small>
                                                    <label for="keyword_by">Mode Pencarian</label>
                                                </small>
                                            </div>
                                            <div class="col-md-12 mb-2" id="FormKeyword">
                                                <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Kata kunci pencarian">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <button type="submit" class="btn btn-sm btn-dark btn-block btn-round">
                                                    <i class="ti ti-search"></i> Cari
                                                </button>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <button type="button" class="btn btn-sm btn-outline-secondary btn-block btn-round" data-toggle="modal" data-target="#ModalCetakExpiredItem">
                                                    <i class="ti ti-printer"></i> Cetak/Export
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <?php
                                        if($Sub=="ExpiredItem"||$Sub==""){
                                            echo '<h3 class="card-title"><i class="ti-calendar"></i> Expired Item</h3>';
                                        }else{
                                            echo '<h3 class="card-title"><i class="ti-truck"></i> Limit Item</h3>';
                                        }
                                    ?>
                                </div>
                                <div id="TabelExpiredLimit">

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
        include "_Page/UnPage/ErrorPage.php";
    }
?>