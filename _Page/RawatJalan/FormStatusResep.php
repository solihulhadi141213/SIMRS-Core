<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_resep'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Resep Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        $id_resep=$_POST['id_resep'];
        //Buka Detail Pasien
        $status=getDataDetail($Conn,"resep",'id_resep',$id_resep,'status');
?>
    <input type="hidden" name="id_resep" id="id_resep" class="form-control" value="<?php echo "$id_resep"; ?>">
    <div class="modal-body">
        <div class="row mb-4">
            <div class="col-md-12 mb-2">
                <dt>Status Resep</dt>
            </div>
            <div class="col-md-12">
                <ul>
                    <li>
                        <input <?php if($status=="Pending"){echo "checked";} ?> type="radio" name="StatusResep" id="StatusResepPending" value="Pending"> 
                        <label for="StatusResepPending">Pending</label>
                    </li>
                    <li>
                        <input <?php if($status=="Selesai"){echo "checked";} ?> type="radio" name="StatusResep" id="StatusResepSelesai" value="Selesai"> 
                        <label for="StatusResepSelesai">Selesai</label>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <dt>Keterangan :</dt>
                <code id="KeteranganStatusResep">
                    <?php
                        if($status=="Pending"){
                            echo "Resep masih di proses dan belum diberikan kepada pasien.";
                        }else{
                            echo "Resep sudah selesai dan obat sudah diberikan kepada pasien, dengan status ini petugas tidak bisa melakukan perubahan pada informasi resep";
                        }
                    ?>
                </code>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12" id="NotifikasiStatusResep">
                <span class="text-primary">Pastikan status resep sudah terisi dengan benar.</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary mr-3">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php } ?>
<script>
    // $(document).ready(function () {
    //     $('input[type=radio][name=StatusResep]').change(function() {
    //         iif (this.value == 'Pending') {
    //             $('#KeteranganStatusResep').html('Resep masih di proses dan belum diberikan kepada pasien.');
    //         }
    //         else if (this.value == 'Selesai') {
    //             $('#KeteranganStatusResep').html('Resep sudah selesai dan obat sudah diberikan kepada pasien, dengan status ini petugas tidak bisa melakukan perubahan pada informasi resep');
    //         }
    //     });
    // });
    $('#StatusResepPending').click(function(){
        $('#KeteranganStatusResep').html('Resep masih di proses dan belum diberikan kepada pasien.');
    });
    $('#StatusResepSelesai').click(function(){
        $('#KeteranganStatusResep').html('Resep sudah selesai dan obat sudah diberikan kepada pasien, dengan status ini petugas tidak bisa melakukan perubahan pada informasi resep');
    });
</script>