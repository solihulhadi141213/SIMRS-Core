<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '<div class="modal-body">';
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
        echo '</div>';
        echo '<div class="modal-footer">';
        echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
        echo '      <i class="ti ti-close"></i> Tutup';
        echo '  </div>';
        echo '</div>';
    }else{
        if(empty($_POST['KodeAnatomi'])){
            echo '<div class="modal-body">';
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Kode Anatomi Tidak Boleh Kosong!';
            echo '      </div>';
            echo '  </div>';
            echo '</div>';
            echo '<div class="modal-footer">';
            echo '  <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">';
            echo '      <i class="ti ti-close"></i> Tutup';
            echo '  </div>';
            echo '</div>';
        }else{
            $id_kunjungan=$_POST['id_kunjungan'];
            $KodeAnatomi=$_POST['KodeAnatomi'];
            //Buka Detail Anamnesis
            $gambar_anatomi=getDataDetail($Conn,"pemeriksaan_fisik",'id_kunjungan',$id_kunjungan,'gambar_anatomi');
            $id_akses=getDataDetail($Conn,"anamnesis",'id_kunjungan',$id_kunjungan,'id_akses');
            //Decode Json
            $JsonGambarAnatomi =json_decode($gambar_anatomi, true);
            $JumlahDataLama=count($JsonGambarAnatomi);
            for($i=0; $i<$JumlahDataLama; $i++){
                if($JsonGambarAnatomi[$i]["KodeAnatomi"]==$KodeAnatomi){
                    $ImageAnatomi=$JsonGambarAnatomi[$i]["ImageAnatomi"];
                    $PenejelasanAnatomi=$JsonGambarAnatomi[$i]["PenejelasanAnatomi"];
                }
            }
?>
    <input type="hidden" name="IdKunjunganEditAnatomiForm" id="IdKunjunganEditAnatomiForm" value="<?php echo $id_kunjungan; ?>">
    <input type="hidden" name="KodeAnatomiEditAnatomiForm" id="KodeAnatomiEditAnatomiForm" value="<?php echo $KodeAnatomi; ?>">
    <div class="modal-body">
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                Untuk menjaga validitas data maka gambar tidak bisa diubah.<br>
                <img src="assets/images/Anatomi/Hasil/<?php echo "$ImageAnatomi"; ?>" width="100%">
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12">
                <label for="PenejelasanAnatomi">Penjelasan Gambar</label>
                <textarea name="EditPenejelasanAnatomi" id="EditPenejelasanAnatomi" class="form-control"><?php echo "$PenejelasanAnatomi"; ?></textarea>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2" id="NotifikasiEditAnatomi">
                <span>Pastikan gambar sudah sesuai, silahkan simpan gambar beserta penjelasannya.</span>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-sm btn-primary mr-3" id="SimpanEditAnatomi">
            <i class="ti ti-save"></i> Simpan
        </button>
        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">
            <i class="ti ti-close"></i> Tutup
        </button>
    </div>
<?php }} ?>
<script>
    //Proses Edit Anatomi
    $('#SimpanEditAnatomi').click(function(){
        var id_kunjungan = $('#IdKunjunganEditAnatomiForm').val();
        var KodeAnatomi = $('#KodeAnatomiEditAnatomiForm').val();
        var EditPenejelasanAnatomi =  $('#EditPenejelasanAnatomi').summernote('code');
        $('#NotifikasiEditAnatomi').html('Loading...');
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/ProsesEditAnatomi.php',
            data        :   {id_kunjungan: id_kunjungan, KodeAnatomi: KodeAnatomi, EditPenejelasanAnatomi: EditPenejelasanAnatomi},
            success     :   function(data){
                $('#NotifikasiEditAnatomi').html(data);
                var NotifikasiEditAnatomiBerhasil=$('#NotifikasiEditAnatomiBerhasil').html();
                if(NotifikasiEditAnatomiBerhasil=="Success"){
                    $('#DetailPemeriksaanDasar').html("Loading...");
                    $('#ModalEditAnatomi').modal('hide');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/DetailPemeriksaanDasar.php',
                        data        : {id_kunjungan: id_kunjungan},
                        success     : function(data){
                            $('#DetailPemeriksaanDasar').html(data);
                        }
                    });
                    //Tampilkan Swal
                    Swal.fire({
                        title: 'Good Job!',
                        text: 'Edit Anatomi Berhasil',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    })
                }
            }
        });
    });
</script>