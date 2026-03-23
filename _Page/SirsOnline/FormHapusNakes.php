<?php
    if(empty($_POST['id_nakes'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID PCR Nakes Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_nakes=$_POST['id_nakes'];
        echo '<input type="hidden" name="id_nakes" id="id_nakes" value="'.$id_nakes.'">';
?>
    <div class="row">
        <div class="col col-md-12 text-center">
            <span class="modal-icon display-2-lg">
                <img src="assets/images/question.gif" width="70%">
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12 text-center mb-3">
            <small class="modal-title my-3" id="NotifikasiHapusNakes">Anda Yakin Ingin Menghapus Data Ini?</small>
        </div>
    </div>
    </div>
<?php
    }
?>