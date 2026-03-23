<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_cppt'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID CPPT Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
    }else{
        if(empty($_POST['kategori'])){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          Kategori TTD CPPT Tidak Boleh Kosong!';
            echo '      </div>';
            echo '  </div>';
        }else{
            $id_cppt=$_POST['id_cppt'];
            $kategori=$_POST['kategori'];
?>
    <form action="javascript:void(0);" id="ProsesTtdCppt<?php echo "$kategori$id_cppt"; ?>">
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <canvas id="signature-pad-cppt-<?php echo "$kategori$id_cppt"; ?>" class="signature-pad-cppt-<?php echo "$kategori$id_cppt"; ?>" width="100%"></canvas>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2" id="NotifikasiTtdCppt<?php echo "$kategori$id_cppt"; ?>">
                <span>Silahkan Tanda Tangan Di Sini</span>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-default" id="HideFormTtdCppt<?php echo "$kategori$id_cppt"; ?>">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </form>
<?php }} ?>
<script>
    var canvas = document.getElementById('signature-pad-cppt-<?php echo "$kategori$id_cppt"; ?>');
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
</script>