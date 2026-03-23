<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_resep'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Resep Tidak Boleh Kosong!';
        echo '      </div>';
        echo '  </div>';
    }else{
        $id_resep=$_POST['id_resep'];
        $id_kunjungan=getDataDetail($Conn,"resep",'id_resep',$id_resep,'id_kunjungan');
?>
    <form action="javascript:void(0);" id="ProsesTtdDokterResep">
        <input type="hidden" name="id_resep" id="id_resep" value="<?php echo $id_resep; ?>">
        <input type="hidden" name="id_kunjungan" id="id_kunjungan" value="<?php echo $id_kunjungan; ?>">
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <canvas id="signature-pad4" class="signature-pad4" width="100%"></canvas>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2" id="NotifikasiTtdDokterResep">
                <span>Silahkan Tanda Tangan Di Sini</span>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <button type="button" class="btn btn-sm btn-primary" id="SimpanTandaTanganResep">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-default" id="HideFormTtdDokterResep">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </form>
<?php } ?>
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
    //Simpan Tanda Tangan
    $('#SimpanTandaTanganResep').click(function(){
        var id_resep = $('#id_resep').val();
        var id_kunjungan = $('#id_kunjungan').val();
        var signature = signaturePad.toDataURL();
        $('#NotifikasiTtdDokterResep').html('Loading...');
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/ProsesSimpanTandaTanganResep.php',
            data        :   {id_resep: id_resep, signature: signature},
            success     :   function(data){
                $('#NotifikasiTtdDokterResep').html(data);
                var NotifikasiTtdDokterResepBerhasil=$('#NotifikasiTtdDokterResepBerhasil').html();
                if(NotifikasiTtdDokterResepBerhasil=="Success"){
                    $('#DetailResep').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/DetailResep.php',
                        data        : {id_kunjungan: id_kunjungan},
                        success     : function(data){
                            $('#DetailResep').html(data);
                        }
                    });
                    //Tampilkan Swal
                    Swal.fire({
                        title: 'Good Job!',
                        text: 'Tanda Tangan Resep Berhasil',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    })
                }
            }
        });
    });
</script>