<?php
    //Tangkap kode
    if(empty($_POST['IdRujukan'])){
        echo '<div class="card-body border-0 pb-0">';
        echo '  <div class="row">';
        echo '      <div class="col-md-6 mb-3">';
        echo '          ID Rujukan Tidak Dapat didefinisikan.';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }else{
        $IdRujukan=$_POST['IdRujukan'];
?>
    <div class="modal-body border-0 pb-0 mb-4">
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center">
                <img src="assets/images/question.gif" alt="" width="70%">
            </div>
        </div>
        <div class="row mt-2 mb-2"> 
            <div class="col-md-12 text-center text-primary">
                <span id="">
                    Apakah anda yakin akan melakukan perubahan pada rujukan <?php echo "$IdRujukan"; ?> ini?
                </span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-12 mb-3">
                <a href="index.php?Page=Rujukan&Sub=EditRukan&id=<?php echo "$IdRujukan"; ?>" class="btn btn-md btn-inverse mt-2 ml-2">
                    <i class="ti-check-box"></i> Ya, Edit
                </a>
                <button type="button" class="btn btn-md btn-danger mt-2 ml-2" data-dismiss="modal">
                    <i class="ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </div>
<?php } ?>