<?php
    if(empty($_POST['id_nakes_pcr'])){
        echo '<div class="row">';
        echo '  <div class="col-md-12 text-center text-danger">';
        echo '      ID PCR Nakes Tidak Boleh Kosong!';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_nakes_pcr=$_POST['id_nakes_pcr'];
        echo '<input type="hidden" name="id_nakes_pcr" id="id_nakes_pcr" value="'.$id_nakes_pcr.'">';
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
            <small class="modal-title my-3" id="NotifikasiHapusHasilPcrNakes">Anda Yakin Ingin Menghapus Data Ini?</small>
        </div>
    </div>
    </div>
<?php
    }
?>