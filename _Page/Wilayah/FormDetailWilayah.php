<?php 
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    //menangkap id wilayah
    if(empty($_POST['id_wilayah'])){
        echo '<span>Tidak ada ID Wilayah Yang Ditangkap</span>';
    }else{
        $id_wilayah=$_POST['id_wilayah'];
        //Buka data wilayah
        $QryWilayah = mysqli_query($Conn,"SELECT * FROM wilayah WHERE id_wilayah='$id_wilayah'")or die(mysqli_error($Conn));
        $DataWilayah = mysqli_fetch_array($QryWilayah);
        $id_wilayah= $DataWilayah['id_wilayah'];
        $kategori= $DataWilayah['kategori'];
        $propinsi= $DataWilayah['propinsi'];
        $kabupaten= $DataWilayah['kabupaten'];
        $kecamatan= $DataWilayah['kecamatan'];
        $desa= $DataWilayah['desa'];
?>
    <div class="modal-body">
        <div class="row mt-3">
            <div class="col-md-6"><dt>ID</dt></div>
            <div class="col-md-6"><?php echo "$id_wilayah"; ?></div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6"><dt>Kategori</dt></div>
            <div class="col-md-6"><?php echo "$kategori"; ?></div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6"><dt>Propinsi</dt></div>
            <div class="col-md-6"><?php echo "$propinsi"; ?></div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6"><dt>Kabupaten/Kota</dt></div>
            <div class="col-md-6"><?php echo "$kabupaten"; ?></div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6"><dt>Kecamatan</dt></div>
            <div class="col-md-6"><?php echo "$kecamatan"; ?></div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6"><dt>Desa/Kelurahan</dt></div>
            <div class="col-md-6"><?php echo "$desa"; ?></div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-sm btn-inverse mr-2" data-toggle="modal" data-target="#ModalEditWilayah">
                    <i class="ti ti-pencil-alt"></i> Edit
                </button>
                <button type="submit" class="btn btn-sm btn-danger mr-2" data-toggle="modal" data-target="#ModalDeleteWilayah">
                    <i class="ti ti-trash"></i> Hapus
                </button>
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>