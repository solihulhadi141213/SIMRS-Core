<?php
    include "_Config/SimrsFunction.php"; 
    //Tangkap ID
    if(empty($_GET['id'])){
        echo '<span class="text-danger">Belum Ada Data Kunjungan Yang Dipilih</span>';
    }else{
        $id_kunjungan=$_GET['id'];
        if(empty($_SESSION['UrlBackResume'])){
            $UrlBack='index.php?Page=RawatJalan&Sub=DetailKunjungan&id='.$id_kunjungan.'';
        }else{
            $UrlBack=$_SESSION['UrlBackResume'];
        }
?>
    <input type="hidden" name="GetIdKunjunganResume" id="GetIdKunjunganResume" value="<?php echo "$id_kunjungan"; ?>">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-10 mb-2">
                                            <h4><i class="ti ti-info-alt"></i> Resume Pasien</h4>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <a href="<?php echo $UrlBack;?>" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 text-center icon-btn mb-4">
                                            <button type="button" class="btn btn-icon btn-outline-secondary" id="DetailResume" title="Detail Informasi Resume">
                                                <i class="icofont-list"></i>
                                            </button>
                                            <button type="button" class="btn btn-icon btn-outline-secondary" id="FormResume" title="Ubah Resume">
                                                <i class="ti ti-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-icon btn-outline-secondary" title="Hapus Data Resume" data-toggle="modal" data-target="#ModalHapusResume" data-id="<?php echo "$id_kunjungan"; ?>">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                            <button type="button" class="btn btn-icon btn-outline-secondary" title="Cetak Data Resume" data-toggle="modal" data-target="#ModalCetakResume" data-id="<?php echo "$id_kunjungan"; ?>">
                                                <i class="ti ti-printer"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div id="KontenResume">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>