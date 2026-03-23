//Ketika submit tambah So
$('#ProsesTambahSo').submit(function(){
    $('#NotifikasiTambahSo').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahSo')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSo/ProsesTambahSo.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahSo').html(data);
            var NotifikasiTambahSoBerhasil=$('#NotifikasiTambahSoBerhasil').html();
            if(NotifikasiTambahSoBerhasil=="Success"){
                window.location.reload();
            }
        }
    });
});
//Modal Edit So
$('#ModalEditSo').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_struktur_organisasi = $(e.relatedTarget).data('id');
    $('#FormEditSo').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSo/FormEditSo.php',
        data        : {id_struktur_organisasi: id_struktur_organisasi},
        success     : function(data){
            $('#FormEditSo').html(data);
        }
    });
});
//Ketika submit Edit So
$('#ProsesEditSo').submit(function(){
    $('#NotifikasiEditSo').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesEditSo')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSo/ProsesEditSo.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditSo').html(data);
            var NotifikasiEditSoBerhasil=$('#NotifikasiEditSoBerhasil').html();
            if(NotifikasiEditSoBerhasil=="Success"){
                window.location.reload(); 
            }
        }
    });
});

//Modal Delete Met Tag
$('#ModalHapustSo').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_struktur_organisasi = $(e.relatedTarget).data('id');
    $('#FormHapusSo').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSo/FormHapusSo.php',
        data 	    :  {id_struktur_organisasi: id_struktur_organisasi},
        success     : function(data){
            $('#FormHapusSo').html(data);
            $('#KonfirmasiHapusSo').click(function(){
                $('#NotifikasiHapusSo').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebSo/ProsesHapusSo.php',
                    data 	    :  { id_struktur_organisasi: id_struktur_organisasi },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusSo').html(data);
                        var NotifikasiHapusSoBerhasil=$('#NotifikasiHapusSoBerhasil').html();
                        if(NotifikasiHapusSoBerhasil=="Success"){
                            window.location.reload(); 
                        }
                    }
                });
            });
        }
    });
});
