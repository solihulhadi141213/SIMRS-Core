// Fungsi Untuk Memuat Gambar Captcha Pada #GetUrlCaptcha
function GenerateCaptchaLogin(FeatureName, id_captcha) {
    let url = '_Page/Login/GenerateCaptcha.php?id_captcha='+ encodeURIComponent(id_captcha) 
              +'&feature_name=' 
              + encodeURIComponent(FeatureName) 
              + '&t=' + new Date().getTime();

    $("#GetUrlCaptcha").attr("src", url);
}

function GenerateCaptchaId(length = 32){
    let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';

    for(let i = 0; i < length; i++){
        result += chars.charAt(Math.floor(Math.random() * chars.length));
    }

    return result;
}

$(document).ready(function() {

    // Inisialisasi FeatureName dan id_captcha
    let FeatureName = "Login";
    let id_captcha  = GenerateCaptchaId(length = 32);

    // Menempelkan id_captcha pada form id_captcha untuk pertama kali
    $('#id_captcha').val(id_captcha);

    // Tampilkan pertama kali
    GenerateCaptchaLogin(FeatureName, id_captcha);

    // Reload manual
    $('#ReloadCaptcha').click(function(){
        // Buat id_captcha
        var id_captcha  = GenerateCaptchaId(length = 32);

        // Tempelkan Ulang ke form
        $('#id_captcha').val(id_captcha);

        // Generate Captcha
        GenerateCaptchaLogin(FeatureName, id_captcha);
    });

    // Reload otomatis setiap 10 menit
    setInterval(function(){
        // Buat id_captcha
        var id_captcha  = GenerateCaptchaId(length = 32);

        // Tempelkan Ulang ke form
        $('#id_captcha').val(id_captcha);

        // Generate Ulang Captcha
        GenerateCaptchaLogin(FeatureName, id_captcha);
    }, 600000);

    //Kondisi saat tampilkan password
    $('#TampilkanPassword').click(function(){
        if($(this).is(':checked')){
            $('#password').attr('type','text');
        }else{
            $('#password').attr('type','password');
        }
    });

    

    //Proses Login
    $('#ProsesLogin').submit(function(){
        // Tangkap Data Login Dari Form
        var ProsesLogin = $(this).serialize();

        // Loading Notifikasi
        $('#NotifikasiLogin').html('<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>');

        // Disable Button 
        $("#button_login").prop("disabled", true);

        // Kirim Data Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Login/ProsesLogin.php',
            dataType    : 'json',
            data 	    :  ProsesLogin,
            success     : function(response){
                var status  = response.status;
                var message = response.message;

                // Jika Berhasil
                if(status=="success"){
                    
                    // Kosongkan Notifikasi
                    $('#NotifikasiLogin').html('');

                    // Reload Halaman Ke 'index.php'
                    window.location.href='index.php';
                }else{

                    // Jika Gagal, Tampilkan Notifikasi
                    $('#NotifikasiLogin').html('<div class="alert alert-danger text-center">'+message+'</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#NotifikasiLogin').html('<div class="alert alert-danger"><small>Terjadi Kesalahan! Silahkan Hubungi Admin Untuk Memeprbaiki Kesalahan Ini.</small></div>');
            }
        });

        // Enable Button 
        $("#button_login").prop("disabled", false);
    });
    
    

    //Click 'modal_pengajuan_akses'
    $(document).on('click', '#modal_pengajuan_akses', function(){
        // Tampilkan Modal
        $("#ModalPengajuanAkses").modal('show');
    });
    $('#ModalPengajuanAkses').on('shown.bs.modal', function () {
        $('#nama').trigger('focus');
    });

    //Reload captcha Pengajuan Akses
    $('#ReloadGambarCaptcha').click(function(){
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Login/CaptchaUrl.php',
            success     : function(data){
                $("#ViewCaptcha").attr("src",data);
            }
        });
    });

    let isSubmitting = false;

    // Submit
    $('#ProsesPengajuanAkses').submit(function(e){
        e.preventDefault();

        if(isSubmitting) return false;
        isSubmitting = true;

        var form = $(this)[0];
        var data = new FormData(form); // ✅ WAJIB untuk file
        var btn  = $("#button_kirim_pengajuan");

        $('#NotifikasiPengajuanAkses').html('Loading...');

        btn.prop("disabled", true).html('<i class="spinner-border spinner-border-sm"></i> Processing...');

        $.ajax({
            type: 'POST',
            url: '_Page/Login/ProsesPengajuanAkses.php',
            data: data,
            dataType: 'json',

            processData: false, // ❗ penting
            contentType: false, // ❗ penting

            success: function(response){
                if(response.status == "success"){
                    
                    $('#NotifikasiPengajuanAkses').html('');

                    $('#ModalPengajuanAkses').modal('hide');

                    Swal.fire({
                        title: "Mantap!!",
                        text: "Pengajuan Akses Berhasil",
                        icon: "success"
                    });

                    // reset form + captcha
                    $('#ProsesPengajuanAkses')[0].reset();
                    $('#ReloadGambarCaptcha').click();

                }else{
                    $('#NotifikasiPengajuanAkses').html(
                        '<div class="alert alert-danger"><b>Error!</b><br>'+response.message+'</div>'
                    );
                }
            },

            error: function(){
                $('#NotifikasiPengajuanAkses').html(
                    '<div class="alert alert-danger">Terjadi kesalahan server!</div>'
                );
            },

            complete: function(){
                isSubmitting = false;
                btn.prop("disabled", false).html('<i class="icofont icofont-paper-plane"></i> Kirim Pengajuan');
            }
        });
    });
});