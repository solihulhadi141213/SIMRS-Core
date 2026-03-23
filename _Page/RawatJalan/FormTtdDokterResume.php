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
        $id_kunjungan=$_POST['id_kunjungan'];
?>
    <form action="javascript:void(0);" id="ProsesTtdDokterResume">
        <input type="hidden" name="IdKunjunganTtdDokterResume" id="IdKunjunganTtdDokterResume" value="<?php echo $id_kunjungan; ?>">
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <canvas id="SignaturePadDokterResume" class="SignaturePadDokterResume" width="100%"></canvas>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2" id="NotifikasiTtdDokterResume">
                <span>Silahkan Tanda Tangan Di Sini</span>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-default" id="TutupFormTtdDokterResume">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </form>
<?php } ?>
<script>
    //Menutup Form
    $('#TutupFormTtdDokterResume').click(function(){
        $('#FormTtdDokterResume').html("Loading...");
        $('#FormTtdDokterResume').html('');
    });
    var canvas = document.getElementById('SignaturePadDokterResume');
    // Adjust canvas coordinate space taking into account pixel ratio,
    // to make it look crisp on mobile devices.
    // This also causes canvas to be cleared.
    function resizeCanvas() {
        // When zoomed out to less than 100%, for some very strange reason,
        // some browsers report devicePixelRatio as less than 1
        // and only part of the canvas is cleared then.
        var ratio =  Math.max(window.devicePixelRatio || 1, 0.5);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }
    window.onresize = resizeCanvas;
    resizeCanvas();

    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)'
    });
    $('#ProsesTtdDokterResume').submit(function(){
        var id_kunjungan = $('#IdKunjunganTtdDokterResume').val();
        var signature = signaturePad.toDataURL();
        $('#NotifikasiTtdDokterResume').html('Loading...');
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/ProsesTtdDokterResume.php',
            data        :   {id_kunjungan: id_kunjungan, signature: signature},
            success     :   function(data){
                $('#NotifikasiTtdDokterResume').html(data);
                var NotifikasiTtdDokterResumeBerhasil=$('#NotifikasiTtdDokterResumeBerhasil').html();
                if(NotifikasiTtdDokterResumeBerhasil=="Success"){
                    $('#KontenResume').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/PreviewResume.php',
                        data        : {id_kunjungan: id_kunjungan},
                        success     : function(data){
                            $('#KontenResume').html(data);
                        }
                    });
                    //Tampilkan Swal
                    Swal.fire({
                        title: 'Good Job!',
                        text: 'Tanda Tangan Dokter Resume Berhasil',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    })
                }
            }
        });
    });
</script>