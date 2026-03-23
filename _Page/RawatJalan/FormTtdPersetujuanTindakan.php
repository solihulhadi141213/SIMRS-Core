<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    if(empty($_POST['id_persetujuan_tindakan'])){
        echo '  <div class="row">';
        echo '      <div class="col-md-12 text-center text-danger">';
        echo '          ID Persetujuan Tindakan Tidak Boleh Kosong!';
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
            $id_persetujuan_tindakan=$_POST['id_persetujuan_tindakan'];
            $kategori=$_POST['kategori'];
            $id_kunjungan=getDataDetail($Conn,"persetujuan_tindakan",'id_persetujuan_tindakan',$id_persetujuan_tindakan,'id_kunjungan');
?>
    <form action="javascript:void(0);" id="ProsesTandaTanganPersetujuanTindakan">
        <input type="hidden" name="id_persetujuan_tindakan" id="id_persetujuan_tindakan" value="<?php echo $id_persetujuan_tindakan; ?>">
        <input type="hidden" name="kategori" id="kategori" value="<?php echo $kategori; ?>">
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <canvas id="signature-pad5" class="signature-pad5" width="100%"></canvas>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2" id="NotifikasiTandaTanganPersetujuanTindakan">
                <span>Silahkan Tanda Tangan Di Sini</span>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-12 mb-2">
                <button type="button" class="btn btn-sm btn-primary" id="SimpanTandaTanganPersetujuanTindakan">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-default" id="TutupTandaTanganPersetujuanTindakan">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </form>
<?php }} ?>
<script>
    var canvas = document.getElementById('signature-pad5');
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
    $('#SimpanTandaTanganPersetujuanTindakan').click(function(){
        var id_persetujuan_tindakan = $('#id_persetujuan_tindakan').val();
        var kategori = $('#kategori').val();
        var signature = signaturePad.toDataURL();
        var id_kunjungan="<?php echo $id_kunjungan;?>";
        $('#NotifikasiTandaTanganPersetujuanTindakan').html('Loading...');
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/ProsesTandaTanganPersetujuanTindakan.php',
            data        :   {id_persetujuan_tindakan: id_persetujuan_tindakan, kategori: kategori, TandaTangan: signature},
            success     :   function(data){
                $('#NotifikasiTandaTanganPersetujuanTindakan').html(data);
                var NotifikasiTandaTanganPersetujuanTindakanBerhasil=$('#NotifikasiTandaTanganPersetujuanTindakanBerhasil').html();
                if(NotifikasiTandaTanganPersetujuanTindakanBerhasil=="Success"){
                    $('#DetailPersetujuanTindakan').html("Loading...");
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/RawatJalan/DetailPersetujuanTindakan.php',
                        data        : {id_kunjungan: id_kunjungan},
                        success     : function(data){
                            $('#DetailPersetujuanTindakan').html(data);
                        }
                    });
                    //Tampilkan Swal
                    Swal.fire({
                        title: 'Good Job!',
                        text: 'Tanda Tangan Persetujuan Tindakan Berhasil',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    })
                }
            }
        });
    });
</script>