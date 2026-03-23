<?php
    if(empty($_GET['id'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-danger">';
        echo '          Mohon maaf, ID Rujukan Tidak Bisa Ditangkap Oleh sistem!!';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_rujukan=$_GET['id'];
        //membuka data pada database
        $Qry = mysqli_query($Conn,"SELECT * FROM rujukan WHERE id_rujukan='$id_rujukan'")or die(mysqli_error($Conn));
        $Data = mysqli_fetch_array($Qry);
        $IdRujukan= $Data['id_rujukan'];
        $id_pasien= $Data['id_pasien'];
        $id_kunjungan= $Data['id_kunjungan'];
        $nama= $Data['nama'];
        $nik= $Data['nik'];
        $no_bpjs= $Data['no_bpjs'];
        $noSep= $Data['noSep'];
        $noRujukan= $Data['noRujukan'];
        $tglRujukan= $Data['tglRujukan'];
        $tglRencanaKunjungan= $Data['tglRencanaKunjungan'];
        $ppkDirujuk= $Data['ppkDirujuk'];
        $jnsPelayanan= $Data['jnsPelayanan'];
        $catatan= $Data['catatan'];
        $diagRujukan= $Data['diagRujukan'];
        $tipeRujukan= $Data['tipeRujukan'];
        $poliRujukan= $Data['poliRujukan'];
        $user= $Data['user'];
?>
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="page-header-title">
                    <h5 class="m-b-10">
                        <a href="index.php?Page=Rujukan" class="h5">
                            <i class="icofont-letter"></i> Rujukan Pasien
                        </a>
                    </h5>
                    <p class="m-b-0">Kelola Data Rujukan Pasien</p>
                </div>
            </div>
            <div class="col-md-8 text-right">
                <a href="index.php?Page=Rujukan" class="btn btn-md btn-primary btn-round mr-2 mt-2">
                    <i class="ti ti-info text-white"></i> Info
                </a>
                <a href="index.php?Page=Rujukan&Sub=RujukanInternal" class="btn btn-md btn-primary btn-round mr-2 mt-2">
                    <i class="icofont-database"></i> Internal
                </a>
                <a href="index.php?Page=Rujukan&Sub=RujukanBpjs" class="btn btn-md btn-primary btn-round mr-2 mt-2">
                    <i class="icofont-share"></i> BPJS
                </a>
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
                            <form action="javascript:void(0);" id="ProsesEditRujukan" autocomplete="off">
                                <div class="card-header border-info">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>
                                                <i class="icofont-file-document"></i> Form Edit Rujukan
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label for="noSep"><dt>No.Rujukan</dt></label>
                                            <input type="text" class="form-control" name="noRujukan" id="noRujukan" value="<?php echo "$noRujukan";?>">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="tglRujukan"><dt>Tgl.Rujukan</dt></label>
                                            <input type="date" class="form-control" name="tglRujukan" id="tglRujukan" value="<?php echo "$tglRujukan"; ?>">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="tglRencanaKunjungan"><dt>Tgl.Rencana Kunjungan</dt></label>
                                            <input type="date" class="form-control" name="tglRencanaKunjungan" id="tglRencanaKunjungan" value="<?php echo "$tglRencanaKunjungan"; ?>">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="ppkDirujuk"><dt>Kode PPK</dt></label>
                                            <input type="text" class="form-control" name="ppkDirujuk" id="ppkDirujuk" value="<?php echo "$ppkDirujuk"; ?>" data-toggle="modal" data-target="#ModalCariPpk">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label for="jnsPelayanan"><dt>Jenis Pelayanan</dt></label>
                                            <select name="jnsPelayanan" id="jnsPelayanan" class="form-control" required>
                                                <option <?php if($jnsPelayanan==""){echo "selected";} ?> value="">Pilih</option>
                                                <option <?php if($jnsPelayanan=="Ranap"){echo "selected";} ?>  value="1">Rawat Inap</option>
                                                <option <?php if($jnsPelayanan=="Rajal"){echo "selected";} ?> value="2">Rawat Jalan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="catatan"><dt>Catatan</dt></label>
                                            <input type="text" class="form-control" name="catatan" id="catatan" value="<?php echo "$catatan"; ?>" >
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="diagRujukan"><dt>Diagnosa Rujukan</dt></label>
                                            <input type="text" class="form-control" name="diagRujukan" id="diagRujukan" value="<?php echo "$diagRujukan"; ?>" data-toggle="modal" data-target="#ModalCariDiagnosa">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="tipeRujukan"><dt>Tipe Rujukan</dt></label>
                                            <select name="tipeRujukan" id="tipeRujukan" class="form-control" required>
                                                <option  <?php if($tipeRujukan==""){echo "selected";} ?> value="">Pilih</option>
                                                <option <?php if($tipeRujukan=="0"){echo "selected";} ?> value="0">Penuh</option>
                                                <option <?php if($tipeRujukan=="1"){echo "selected";} ?> value="1">Partial</option>
                                                <option <?php if($tipeRujukan=="2"){echo "selected";} ?> value="2">PRB</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <label for="poliRujukan"><dt>Poli Rujukan</dt></label>
                                            <input type="text" class="form-control" name="poliRujukan" id="poliRujukan" value="<?php echo "$poliRujukan"; ?>" data-toggle="modal" data-target="#ModalCariPoli">
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label for="user"><dt>user/Petugas</dt></label>
                                            <input type="text" readonly class="form-control" name="user" id="user" value="<?php echo "$SessionNama"; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-3" id="NotifikasiEditRujukan">
                                            <span class="text-primary">
                                                <dt>Keterangan</dt>
                                                Pastikan data rujukan yang anda buat sudah sesuai!
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-grd-primary btn-round mt-2 mr-2">
                                                <i class="icofont-send-mail"></i> Buat Rujukan
                                            </button>
                                            <button type="submit" class="btn btn-grd-warning btn-round mt-2 mr-2">
                                                <i class="ti ti-reload"></i> Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="styleSelector">

        </div>
    </div>
</div>
<?php } ?>