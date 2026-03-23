<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Menangkap Nomor Antrian
    if(empty($_POST['id_antrian'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Antrian Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_antrian=$_POST['id_antrian'];
        //Buka data Antrian
        $QryAntrian = mysqli_query($Conn,"SELECT * FROM antrian WHERE id_antrian='$id_antrian'")or die(mysqli_error($Conn));
        $DataAntrian = mysqli_fetch_array($QryAntrian);
        $id_kunjungan= $DataAntrian['id_kunjungan'];
        $NoAntrian= $DataAntrian['no_antrian'];
?>
    <div class="modal-body">   
        <div class="row">
            <div class="col col-md-12 text-center">
                <div class="alert alert-danger" role="alert">
                    <h3><i class="ti ti-trash"></i></h3>
                    Anda yakin akan menghapus antrian ini?
                    <p id="NotifikasiHapusAntrian"></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col col-md col-12 text-center">
                <button type="button" class="btn btn-md btn-primary mt-2 mr-2" id="KonfirmasiHapus">
                    <i class="ti ti-check"></i> Ya, Hapus
                </button>
                <button type="button" class="btn btn-md btn-danger mt-2 mr-2" data-dismiss="modal">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>