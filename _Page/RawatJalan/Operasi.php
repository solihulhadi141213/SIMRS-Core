<?php
    include "_Config/SimrsFunction.php"; 
    //Tangkap ID
    if(empty($_GET['id'])){
        echo '<span class="text-danger">Belum Ada Data Kunjungan Yang Dipilih</span>';
    }else{
        $id_kunjungan=$_GET['id'];
        if(empty($_SESSION['UrlBackOperasi'])){
            $UrlBack='index.php?Page=RawatJalan&Sub=DetailKunjungan&id='.$id_kunjungan.'';
        }else{
            $UrlBack=$_SESSION['UrlBackOperasi'];
        }
        if(empty($_GET['ms_sub'])){
            $ms_sub="";
        }else{
            $ms_sub=$_GET['ms_sub'];
        }
?>
    <input type="hidden" name="GetIdKunjunganOperasi" id="GetIdKunjunganOperasi" value="<?php echo "$id_kunjungan"; ?>">
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
                                            <h4>
                                                <i class="icofont-surgeon"></i> Lembar Tindakan Operasi
                                            </h4>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <a href="<?php echo $UrlBack;?>" class="btn btn-sm btn-block btn-secondary">
                                                <i class="ti ti-angle-left"></i> Kembali
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-12 text-center icon-btn">
                                            <a href="index.php?Page=RawatJalan&Sub=Operasi&ms_sub=PreviewOperasi&id=<?php echo $id_kunjungan; ?>" class="btn btn-sm <?php if(empty($ms_sub)||$ms_sub=="PreviewOperasi"){echo "btn-secondary";}else{echo "btn-outline-secondary";} ?> btn-icon" title="Preview Operasi">
                                                <i class="icofont-info"></i>
                                            </a>
                                            <a href="index.php?Page=RawatJalan&Sub=Operasi&ms_sub=FormOperasi&id=<?php echo $id_kunjungan; ?>" class="btn btn-sm <?php if($ms_sub=="FormOperasi"){echo "btn-secondary";}else{echo "btn-outline-secondary";} ?> btn-icon" title="Form Operasi">
                                                <i class="icofont-pencil-alt-5"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-icon" title="Hapus Operasi" data-toggle="modal" data-target="#ModalHapusOperasi" data-id="<?php echo "$id_kunjungan"; ?>">
                                                <i class="icofont-ui-delete"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary btn-icon" title="Cetak Operasi" data-toggle="modal" data-target="#ModalCetakOperasi" data-id="<?php echo "$id_kunjungan"; ?>">
                                                <i class="icofont-printer"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-12">
                                            <!-- Konten Operasi -->
                                            <?php
                                                if(empty($ms_sub)){
                                                    include "_Page/RawatJalan/PreviewOperasi.php";
                                                }else{
                                                    if($ms_sub=="PreviewOperasi"){
                                                        include "_Page/RawatJalan/PreviewOperasi.php";
                                                    }else{
                                                        if($ms_sub=="FormOperasi"){
                                                            include "_Page/RawatJalan/FormOperasi.php";
                                                        }else{
                                                            
                                                        }
                                                    }
                                                }
                                            ?>
                                        </div>
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