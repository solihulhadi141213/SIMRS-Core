<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_kunjungan'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Kunjungan Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
    }else{
        if(empty($_POST['kategori'])){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Kategori Tidak Boleh Kosong!';
            echo '      </div>';
            echo '  </div>';
        }else{
            $id_kunjungan=$_POST['id_kunjungan'];
            $kategori=$_POST['kategori'];
?>
    <form action="javascript:void(0);" id="ProsesTandaTanganPemeriksaanFisik">
        <input type="hidden" name="TtdPemeriksaanDasarIdKunjungan" id="TtdPemeriksaanDasarIdKunjungan" value="<?php echo $id_kunjungan; ?>">
        <input type="hidden" name="KategoriPemeriksaanDasarIdKunjungan" id="KategoriPemeriksaanDasarIdKunjungan" value="<?php echo $kategori; ?>">
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <canvas id="signature-pad4" class="signature-pad4" width="100%"></canvas>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2" id="NotifikasiTandaTanganPemeriksaanDasar">
                <span>Silahkan Tanda Tangan Di Sini</span>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <button type="button" class="btn btn-sm btn-primary" id="SimpanTandaTnganPemeriksaanDasar">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-default" id="TutupTandaTanganPemeriksaanDasar">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </form>
<?php }} ?>
<script>
    var canvas = document.getElementById('signature-pad4');
    // Adjust canvas coordinate space taking into account pixel ratio,
    // to make it look crisp on mobile devices.
    // This also causes canvas to be cleared.
    function resizeCanvas() {
        // When zoomed out to less than 100%, for some very strange reason,
        // some browsers report devicePixelRatio as less than 1
        // and only part of the canvas is cleared then.
        var ratio =  Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }
    window.onresize = resizeCanvas;
    resizeCanvas();

    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)'
    });
    $('#TutupTandaTanganPemeriksaanDasar').click(function(){
        $('#FormTandaTanganPemeriksaanDasar').html("");
    });
    $('#SimpanTandaTnganPemeriksaanDasar').click(function(){
        var id_kunjungan = $('#TtdPemeriksaanDasarIdKunjungan').val();
        var kategori = $('#KategoriPemeriksaanDasarIdKunjungan').val();
        var signature = signaturePad.toDataURL();
        $('#NotifikasiTandaTanganPemeriksaanDasar').html('Loading...');
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/ProsesSimpanTandaTanganPemeriksaanDasar.php',
            data        :   {id_kunjungan: id_kunjungan, kategori: kategori, TandaTangan: signature},
            success     :   function(data){
                $('#NotifikasiTandaTanganPemeriksaanDasar').html(data);
                var NotifikasiTandaTanganPemeriksaanDasarBerhasil=$('#NotifikasiTandaTanganPemeriksaanDasarBerhasil').html();
                if(NotifikasiTandaTanganPemeriksaanDasarBerhasil=="Success"){
                    $('#DetailPemeriksaanDasar').html("Loading...");
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
                        text: 'Tanda Tangan Pemeriksaan Dasar Berhasil',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    })
                }
            }
        });
    });
</script>