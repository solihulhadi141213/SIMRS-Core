<?php
    if(!empty($_POST['id_akses'])){
        $id_akses=$_POST['id_akses'];
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
            <small class="modal-title my-3" id="NotifikasiHapusAkses">Anda Yakin Ingin Menghapus Data Ini?</small>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12 text-center">
            <button type="button" id="KonfirmasiHapusAkses" class="btn btn-md btn-outline-info" value="<?php echo $id_akses;?>">Ya</button>
            <button type="button" class="btn btn-md btn-outline-danger" data-dismiss="modal">Tidak</button>
        </div>
    </div>
</div>
<?php 
    }else{
        $id_akses="";
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col col-md-12 text-center">';
        echo '          <small class="modal-title my-3">Maaf, Tidak ada data akses yang dipilih.</small>';
        echo '      </div>';
        echo '  </div>';
        echo '  <div class="row">';
        echo '      <div class="col col-md-12 text-center">';
        echo '          <button type="button" class="btn btn-md btn-outline-white" data-dismiss="modal">Tutup</button>';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
    }
?>