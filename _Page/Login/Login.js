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
    var ProsesLogin = $('#ProsesLogin').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiLogin').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Login/Login.php',
        data 	    :  ProsesLogin,
        success     : function(data){
            $('#NotifikasiLogin').html(data);
            var NotifikasiLoginBerhasil = $('#NotifikasiLoginBerhasil').html();
            if(NotifikasiLoginBerhasil=="Success"){
                window.location.href='index.php';
            }
        }
    });
});
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Login/CaptchaUrl.php',
    success     : function(data){
        $("#GetUrlCaptcha").attr("src",data);
    }
});
//Reload captcha
$('#ReloadCaptcha').click(function(){
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Login/CaptchaUrl.php',
        success     : function(data){
            $("#GetUrlCaptcha").attr("src",data);
        }
    });
});