<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_konsultasi'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Resep Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_konsultasi=$_POST['id_konsultasi'];
?>
    <form action="javascript:void(0);" id="ProsesTtdAsalKonsultasi<?php echo $id_konsultasi;?>" autocomplete="off">
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <canvas id="signature-pad99<?php echo $id_konsultasi;?>" class="signature-pad99<?php echo $id_konsultasi;?>" width="100%"></canvas>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2" id="NotifikasiTtdAsalKonsultasi<?php echo $id_konsultasi;?>">
                <span>Silahkan Tanda Tangan Di Sini</span>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-default" id="TutupFormTtdAsalKonsultasi<?php echo $id_konsultasi;?>">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </form>
<?php } ?>
<script>
    //Form Signature Pad
    var canvas = document.getElementById('signature-pad99<?php echo $id_konsultasi;?>');
    function resizeCanvas() {
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
    //Sembunyikan Form
    $('#TutupFormTtdAsalKonsultasi<?php echo $id_konsultasi;?>').click(function(){
        $('#FormTtdAsal<?php echo $id_konsultasi;?>').html('');
    });
</script>