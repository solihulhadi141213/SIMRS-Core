<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    //Tangkap id_akses_ref
    if(empty($_POST['id_akses_ref'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center mb-3">';
        echo '         ID Referensi Tidak Boleh Kosong!.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer bg-info">';
        echo '  <button type="button" class="btn btn-md btn-light mt-2 ml-2" data-dismiss="modal">';
        echo '      <i class="ti-close"></i> Tutup';
        echo '  </button>';
        echo '</div>';
    }else{
        $id_akses_ref=$_POST['id_akses_ref'];
        $nama_fitur=getDataDetail($Conn,'akses_ref','id_akses_ref',$id_akses_ref,'nama_fitur');
        $kategori=getDataDetail($Conn,'akses_ref','id_akses_ref',$id_akses_ref,'kategori');
        $kode=getDataDetail($Conn,'akses_ref','id_akses_ref',$id_akses_ref,'kode');
        $keterangan=getDataDetail($Conn,'akses_ref','id_akses_ref',$id_akses_ref,'keterangan');
?>
    <div class="modal-body">
        <div class="row mb-4">
            <div class="col-6">
                <dt>Nama Fitur</dt>
            </div>
            <div class="col-6">
                <?php echo "$nama_fitur"; ?>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <dt>Kategori</dt>
            </div>
            <div class="col-6">
                <?php echo "$kategori"; ?>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <dt>Kode</dt>
            </div>
            <div class="col-6">
                <?php echo "$kode"; ?>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <dt>Keterangan</dt>
            </div>
            <div class="col-6">
                <?php echo "$keterangan"; ?>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-info">
        <div class="btn-group dropdown-split-inverse">
            <button type="button" class="btn btn-md btn-primary dropdown-toggle dropdown-toggle-split waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="OptionButton">
                <i class="ti ti-settings"></i> Option
            </button>
            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(107px, -2px, 0px); top: 0px; left: 0px; will-change: transform;">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalEditReferensiFitur" data-id="<?php echo "$id_akses_ref"; ?>">
                    <i class="ti-pencil"></i> Edit
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item waves-effect waves-light" href="javascript:void(0);" data-toggle="modal" data-target="#ModalHapusReferensiAkses" data-id="<?php echo "$id_akses_ref"; ?>">
                    <i class="ti-trash"></i> Hapus
                </a>
            </div>
        </div>
        <button type="button" class="btn btn-md btn-inverse" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>