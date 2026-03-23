<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap IdDiagnosa
    if(empty($_POST['IdDiagnosa'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Diagnosa Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="card-footer">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 mb-2 mb-2">';
        echo '          <button class="btn btn-md btn-secondary" data-dismiss="modal"><i class="ti ti-close"></i> Tutup</button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $IdDiagnosa=$_POST['IdDiagnosa'];
        //Buka data diagnosa
        $QryDiagnosa = mysqli_query($Conn,"SELECT * FROM diagnosa WHERE id_diagnosa='$IdDiagnosa'")or die(mysqli_error($Conn));
        $DataDiagnosa = mysqli_fetch_array($QryDiagnosa);
        $id_diagnosa= $DataDiagnosa['id_diagnosa'];
        $kode= $DataDiagnosa['kode'];
        $long_des= $DataDiagnosa['long_des'];
        $short_des= $DataDiagnosa['short_des'];
        $versi= $DataDiagnosa['versi'];
?>
    <div class="modal-body">
        <div class="row mb-2">
            <div class="col-md-4">
                <dt>ID Diagnosa</dt>
            </div>
            <div class="col-md-8">
                <?php echo "$id_diagnosa"; ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <dt>Versi</dt>
            </div>
            <div class="col-md-8">
                <?php echo "$versi"; ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <dt>Kode</dt>
            </div>
            <div class="col-md-8">
                <?php echo "$kode"; ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <dt>Long Description</dt>
            </div>
            <div class="col-md-8">
                <?php echo "$long_des"; ?>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-4">
                <dt>Short Description</dt>
            </div>
            <div class="col-md-8">
                <?php echo "$short_des"; ?>
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <div class="row">
            <div class="col-md-12 mb-2 mb-2">
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#ModalEditDiagnosa" data-id="<?php echo "$IdDiagnosa"; ?>">
                    <i class="ti ti-pencil"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#ModalHapusDiagnosa" data-id="<?php echo "$IdDiagnosa"; ?>">
                    <i class="ti ti-trash"></i> Hapus
                </button>
                <button class="btn btn-sm btn-light" data-dismiss="modal">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>