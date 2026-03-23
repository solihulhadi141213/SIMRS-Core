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
        if(empty($_POST['id_nakes_operasi'])){
            echo '  <div class="row">';
            echo '      <div class="col-md-12 text-center text-danger">';
            echo '          ID Nakes Tidak Boleh Kosong!';
            echo '      </div>';
            echo '  </div>';
        }else{
            $id_kunjungan=$_POST['id_kunjungan'];
            $id_nakes_operasi=$_POST['id_nakes_operasi'];
            $id_operasi=getDataDetail($Conn,"operasi",'id_kunjungan',$id_kunjungan,'id_operasi');
?>
    <form action="javascript:void(0);" id="ProsesTtdNakesOperasi<?php echo $id_nakes_operasi; ?>">
        <input type="hidden" name="id_kunjungan" id="IdKunjunganOperasi<?php echo $id_kunjungan; ?>" value="<?php echo $id_kunjungan; ?>">
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <canvas class="signature-operasi" id="signature-nakesoperasi<?php echo $id_nakes_operasi; ?>" width="100%"></canvas>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2" id="NotifikasiTtdNakesOperasi<?php echo $id_nakes_operasi; ?>">
                <span>Silahkan Tanda Tangan Di Sini</span>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-default" id="HideFormTtdNakesOperasi<?php echo $id_nakes_operasi; ?>">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </form>
<?php }} ?>
<script>
    var id_nakes_operasi="<?php echo "$id_nakes_operasi"; ?>";
    var canvas = document.getElementById('signature-nakesoperasi'+id_nakes_operasi+'');
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
    //Sembunyikan Form
    $('#HideFormTtdNakesOperasi'+id_nakes_operasi+'').click(function(){
        $('#FormTtdNakesOperasi'+id_nakes_operasi+'').html('Loading...');
        $('#FormTtdNakesOperasi'+id_nakes_operasi+'').html('');
    });
    //Simpan Tanda Tangan
    $('#ProsesTtdNakesOperasi'+id_nakes_operasi+'').submit(function(){
        var id_kunjungan ="<?php echo "$id_kunjungan"; ?>";
        var signature = signaturePad.toDataURL();
        $('#NotifikasiTtdNakesOperasi'+id_nakes_operasi+'').html('Loading...');
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/ProsesTtdNakesOperasi.php',
            data        :   {id_kunjungan: id_kunjungan, id_nakes_operasi: id_nakes_operasi, signature: signature},
            success     :   function(data){
                $('#NotifikasiTtdNakesOperasi'+id_nakes_operasi+'').html(data);
                var NotifikasiTtdNakesOperasiBerhasil=$('#NotifikasiTtdNakesOperasiBerhasil'+id_nakes_operasi+'').html();
                var UrlBackTtdNakesOperasi=$('#UrlBackTtdNakesOperasi'+id_nakes_operasi+'').html();
                if(NotifikasiTtdNakesOperasiBerhasil=="Success"){
                    var UrlBackTtdNakesOperasi=UrlBackTtdNakesOperasi.replace(/&amp;/g, '&');
                    window.location.replace(UrlBackTtdNakesOperasi);
                }
            }
        });
    });
</script>