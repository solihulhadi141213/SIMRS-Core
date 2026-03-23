<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap id_pasien
    if(empty($_POST['id_pasien'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data ID Akses Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_pasien=$_POST['id_pasien'];
        //Membuat Sesion URL Back
        $_SESSION['UrlBackPasien']='index.php?Page=Pasien&Sub=DetailPasien&id='.$id_pasien.'';
?>
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row">
            <div class="col-md-12">
                <h4>Keterangan</h4>
                Untuk melakukan perubahan data pasien, anda akan diarahkan ke halaman form edit data pasien. 
                Silahkan pilih tombol lanjutkan untuk masuk ke halaman edit data pasien.
            </div>
        </div>
    </div>
    <div class="modal-footer bg-primary">
        <div class="row">
            <div class="col-md-12">
                <a href="index.php?Page=Pasien&Sub=EditPasien&id=<?php echo "$id_pasien"; ?>" class="btn btn-sm btn-inverse">
                    <i class="ti-check-box"></i> Lanjutkan
                </a>
                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>