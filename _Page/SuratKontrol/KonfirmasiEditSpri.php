<?php
    //Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    //Tangkap noSuratKontrol
    if(empty($_POST['noSuratKontrol'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          Data No.Surat Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $noSuratKontrol=$_POST['noSuratKontrol'];
?>
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center">
                <img src="assets/images/question.gif" alt="" width="70%">
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center text-primary">
                <span id="NotifikasiHapusSuratKontrol">
                    Apakah anda yakin akan melakukan perubahan pada surat kontrol <?php echo "<dt id='GetNoSpri'>$noSuratKontrol</dt>"; ?> ini?
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3 mt-3 text-center">
                <a href="javascript:void(0);" class="btn btn-md btn-inverse btn-round mt-2 ml-2" id="KonfirmasiEditYa" value="<?php echo "$noSuratKontrol"; ?>">
                    <i class="ti-check-box"></i> Ya, Edit
                </a>
                <button type="button" class="btn btn-md btn-outline-dark btn-round mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>