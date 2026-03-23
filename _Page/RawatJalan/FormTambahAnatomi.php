<?php
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SettingFaskes.php";
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
    <form action="javascript:void(0);" id="ProsesTambahAnatomi">
        <input type="hidden" name="IdKunjunganAnatomiForm" id="IdKunjunganAnatomiForm" value="<?php echo $id_kunjungan; ?>">
        <div class="card">
            <div class="card-header">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-dark" id="Img1">
                        Img 1
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dark" id="Img2">
                        Img 2
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dark" id="Img3">
                        Img 3
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dark" id="Img4">
                        Img 4
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dark" id="Img5">
                        Img 5
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dark" id="Img6">
                        Img 6
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dark" id="Img7">
                        Img 3
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-dark" id="Img8">
                        Img 8
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-12 mb-2">
                        <label for="signature-pad3">Gambar Di Sini</label>
                        <canvas id="signature-pad3" class="signature-pad3" width="100%"></canvas><br>
                        <a href="javascript:void(0);" id="GantiWarna" class="text-primary">
                            <small><i class="ti ti-marker-alt"></i> Ganti Warna Pencil</small>
                        </a>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <label for="PenejelasanAnatomi">Penjelasan Gambar</label>
                        <textarea name="PenejelasanAnatomi" id="PenejelasanAnatomi" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 mb-2" id="NotifikasiTambahAnatomi">
                        <span>Pastikan gambar sudah sesuai, silahkan simpan gambar beserta penjelasannya.</span>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white">
                <button type="button" class="btn btn-sm btn-primary" id="SimpanFormAnatomi">
                    <i class="ti ti-save"></i> Simpan
                </button>
                <button type="button" class="btn btn-sm btn-default" id="TutupFormAnatomi">
                    <i class="ti ti-close"></i> Tutup
                </button>
            </div>
        </div>
    </form>
<?php } ?>
<script>
    $('#PenejelasanAnatomi').summernote({
        height: 300,
    });
    var canvas = document.getElementById('signature-pad3');
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
    context = canvas.getContext('2d');
    window.onresize = resizeCanvas;
    resizeCanvas();

    var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)'
    });
    var higthImg=canvas.height;
    var widthImg=canvas.width;
    function BadanDepan(){
        base_image = new Image();
        base_image.src = '<?php echo "$BaseUrl/assets/images/Anatomi/BadanDepan.jpg"; ?>';
        base_image.onload = function(){
            context.drawImage(base_image, 0, 0, higthImg, widthImg);
        }
    }
    function BadanBelakang(){
        base_image = new Image();
        base_image.src = '<?php echo "$BaseUrl/assets/images/Anatomi/BadanBelakang.jpg"; ?>';
        base_image.onload = function(){
            context.drawImage(base_image, 0, 0, higthImg, widthImg);
        }
    }
    function BadanKiri(){
        base_image = new Image();
        base_image.src = '<?php echo "$BaseUrl/assets/images/Anatomi/BadanKiri.jpg"; ?>';
        base_image.onload = function(){
            context.drawImage(base_image, 0, 0, higthImg, widthImg);
        }
    }
    function BadanKanan(){
        base_image = new Image();
        base_image.src = '<?php echo "$BaseUrl/assets/images/Anatomi/BadanKanan.jpg"; ?>';
        base_image.onload = function(){
            context.drawImage(base_image, 0, 0, higthImg, widthImg);
        }
    }
    function KepalaDepan(){
        base_image = new Image();
        base_image.src = '<?php echo "$BaseUrl/assets/images/Anatomi/KepalaDepan.jpg"; ?>';
        base_image.onload = function(){
            context.drawImage(base_image, 0, 0, higthImg, widthImg);
        }
    }
    function KepalaBelakang(){
        base_image = new Image();
        base_image.src = '<?php echo "$BaseUrl/assets/images/Anatomi/KepalaBelakang.jpg"; ?>';
        base_image.onload = function(){
            context.drawImage(base_image, 0, 0, higthImg, widthImg);
        }
    }
    function KepalaKiri(){
        base_image = new Image();
        base_image.src = '<?php echo "$BaseUrl/assets/images/Anatomi/KepalaKiri.jpg"; ?>';
        base_image.onload = function(){
            context.drawImage(base_image, 0, 0, higthImg, widthImg);
        }
    }
    function KepalaKanan(){
        base_image = new Image();
        base_image.src = '<?php echo "$BaseUrl/assets/images/Anatomi/KepalaKanan.jpg"; ?>';
        base_image.onload = function(){
            context.drawImage(base_image, 0, 0, higthImg, widthImg);
        }
    }
    // saat Img1
    document.getElementById('Img1').addEventListener('click', function () {
        BadanDepan();
    });
    document.getElementById('Img2').addEventListener('click', function () {
        BadanBelakang();
    });
    document.getElementById('Img3').addEventListener('click', function () {
        BadanKiri();
    });
    document.getElementById('Img4').addEventListener('click', function () {
        BadanKanan();
    });
    document.getElementById('Img5').addEventListener('click', function () {
        KepalaDepan();
    });
    document.getElementById('Img6').addEventListener('click', function () {
        KepalaBelakang();
    });
    document.getElementById('Img7').addEventListener('click', function () {
        KepalaKiri();
    });
    document.getElementById('Img8').addEventListener('click', function () {
        KepalaKanan();
    });
    //saat tombol change color diklik maka akan merubah warna pena
    document.getElementById('GantiWarna').addEventListener('click', function () {
        //jika warna pena biru maka buat menjadi hitam dan sebaliknya
        if(signaturePad.penColor == "rgba(0, 0, 255, 1)"){
            signaturePad.penColor = "rgba(0, 0, 0, 1)";
        }else{
            signaturePad.penColor = "rgba(0, 0, 255, 1)";
        }
    })
    $('#SimpanFormAnatomi').click(function(){
        var id_kunjungan = $('#IdKunjunganAnatomiForm').val();
        var PenejelasanAnatomi =  $('#PenejelasanAnatomi').summernote('code');
        var anatomi = signaturePad.toDataURL();
        $('#NotifikasiTambahAnatomi').html('Loading...');
        $.ajax({
            type 	    :   'POST',
            url 	    :   '_Page/RawatJalan/ProsesTambahAnatomi.php',
            data        :   {id_kunjungan: id_kunjungan, PenejelasanAnatomi: PenejelasanAnatomi, anatomi: anatomi},
            success     :   function(data){
                $('#NotifikasiTambahAnatomi').html(data);
                var NotifikasiTambahAnatomiBerhasil=$('#NotifikasiTambahAnatomiBerhasil').html();
                if(NotifikasiTambahAnatomiBerhasil=="Success"){
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
                        text: 'Tanda Tangan Anamnesa Berhasil',
                        icon: 'success',
                        confirmButtonText: 'Tutup'
                    })
                }
            }
        });
    });
</script>