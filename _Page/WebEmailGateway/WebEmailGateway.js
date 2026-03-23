//Proses Tambah Galeri
$('#ProsesUpdateEmailGateway').submit(function(){
    $('#NotifikasiUpdateEmailGateway').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesUpdateEmailGateway')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebEmailGateway/ProsesUpdateEmailGateway.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiUpdateEmailGateway').html(data);
            var NotifikasiUpdateEmailGatewayBerhasil=$('#NotifikasiUpdateEmailGatewayBerhasil').html();
            if(NotifikasiUpdateEmailGatewayBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Proses Kirim Email
$('#ProsesKirimEmail').submit(function(){
    $('#NotifikasiKirimEmail').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesKirimEmail')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebEmailGateway/ProsesKirimEmail.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiKirimEmail').html(data);
            var NotifikasiKirimEmailBerhasil=$('#NotifikasiKirimEmailBerhasil').html();
            if(NotifikasiKirimEmailBerhasil=="Success"){
                location.reload();
            }
        }
    });
});