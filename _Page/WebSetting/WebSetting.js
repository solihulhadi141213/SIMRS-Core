$('#TabelService').html('Loading...');
var BatasData=$('#BatasData').val();
var kategori_service=$('#kategori_service').val();
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebSetting/TabelService.php',
    data        : {BatasData: BatasData, kategori_service: kategori_service},
    success     : function(data){
        $('#TabelService').html(data);
    }
});
$('#BatasData').change(function(){
    var BatasData=$('#BatasData').val();
    var kategori_service=$('#kategori_service').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSetting/TabelService.php',
        data        : {BatasData: BatasData, kategori_service: kategori_service},
        success     : function(data){
            $('#TabelService').html(data);
        }
    });
});
$('#kategori_service').change(function(){
    var BatasData=$('#BatasData').val();
    var kategori_service=$('#kategori_service').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSetting/TabelService.php',
        data        : {BatasData: BatasData, kategori_service: kategori_service},
        success     : function(data){
            $('#TabelService').html(data);
        }
    });
});
$('#ProsesSettingKoneksiWebsite').submit(function(){
    $('#NotifikasiSettingKoneksiWebsite').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesSettingKoneksiWebsite')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSetting/ProsesSettingKoneksiWebsite.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSettingKoneksiWebsite').html(data);
            var NotifikasiSettingKoneksiWebsiteBerhasil=$('#NotifikasiSettingKoneksiWebsiteBerhasil').html();
            if(NotifikasiSettingKoneksiWebsiteBerhasil=="Success"){
                window.location.reload();
            }
        }
    });
});
//Ketika submit tambah service
$('#ProsesTambahService').submit(function(){
    var GetKategoriService=$('#service_category').val();
    $('#NotifikasiTambahService').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahService')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSetting/ProsesTambahService.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahService').html(data);
            var NotifikasiTambahServiceBerhasil=$('#NotifikasiTambahServiceBerhasil').html();
            if(NotifikasiTambahServiceBerhasil=="Success"){
                //reset form
                $('#ProsesTambahService')[0].reset();
                //Apabila berhasil tutup modal
                $('#ModalTambahServiceWeb').modal('hide');
                //Reset Kategori
                $('#kategori_service').html('<option>Loading...</option>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebSetting/kategori_service.php',
                    data        : {GetKategori: GetKategoriService},
                    success     : function(data){
                        $('#kategori_service').html(data);
                    }
                });
                //Reset Tabel
                $('#TabelService').html('Loading...');
                var BatasData=$('#BatasData').val();
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebSetting/TabelService.php',
                    data        : {BatasData: BatasData, kategori_service: GetKategoriService},
                    success     : function(data){
                        $('#TabelService').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Tambah Service Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit Service
$('#ModalEditService').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_setting_service = $(e.relatedTarget).data('id');
    $('#FormEditService').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSetting/FormEditService.php',
        data        : {id_setting_service: id_setting_service},
        success     : function(data){
            $('#FormEditService').html(data);
            $('#ProsesEditService').submit(function(){
                var GetKategori=$('#service_category_edit').val();
                e.preventDefault();
                $('#NotifikasiEditService').html('Loading..');
                var form = $('#ProsesEditService')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebSetting/ProsesEditService.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditService').html(data);
                        var NotifikasiEditServiceBerhasil=$('#NotifikasiEditServiceBerhasil').html();
                        if(NotifikasiEditServiceBerhasil=="Success"){
                            //Apabila berhasil tutup modal
                            $('#ModalEditService').modal('hide');
                            //Reset Kategori
                            $('#kategori_service').html('<option>Loading...</option>');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebSetting/kategori_service.php',
                                data        : {GetKategori: GetKategori},
                                success     : function(data){
                                    $('#kategori_service').html(data);
                                }
                            });
                            //Reset Tabel
                            $('#TabelService').html('Loading...');
                            var BatasData=$('#BatasData').val();
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebSetting/TabelService.php',
                                data        : {BatasData: BatasData, kategori_service: GetKategori},
                                success     : function(data){
                                    $('#TabelService').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Edit Service Berhasil',
                                        icon: 'success',
                                        confirmButtonText: 'Tutup'
                                    })
                                }
                            });
                        }
                    }
                });
            });
        }
    });
});
//Modal Delete Service
$('#ModalHapusService').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_setting_service = $(e.relatedTarget).data('id');
    $('#FormDeleteService').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSetting/FormDeleteService.php',
        data 	    :  {id_setting_service: id_setting_service},
        success     : function(data){
            $('#FormDeleteService').html(data);
            $('#KonfirmasiHapusService').click(function(){
                $('#NotifikasiHapusService').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebSetting/ProsesHapusService.php',
                    data 	    :  { id_setting_service: id_setting_service },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusService').html(data);
                        var NotifikasiHapusServiceBerhasil=$('#NotifikasiHapusServiceBerhasil').html();
                        if(NotifikasiHapusServiceBerhasil=="Success"){
                            //Apabila berhasil tutup modal
                            $('#ModalHapusService').modal('hide');
                            //Reset Tabel
                            $('#TabelService').html('Loading...');
                            var BatasData=$('#BatasData').val();
                            var kategori_service=$('#kategori_service').val();
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebSetting/TabelService.php',
                                data        : {BatasData: BatasData, kategori_service: kategori_service},
                                success     : function(data){
                                    $('#TabelService').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Hapus Service Berhasil',
                                        icon: 'success',
                                        confirmButtonText: 'Tutup'
                                    })
                                }
                            });
                        }
                    }
                });
            });
        }
    });
});
$('#ModalReplace').submit(function(){
    $('#NotifikasiRepliceService').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesRepliceService')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSetting/ProsesRepliceService.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiRepliceService').html(data);
            var NotifikasiRepliceServiceBerhasil=$('#NotifikasiRepliceServiceBerhasil').html();
            if(NotifikasiRepliceServiceBerhasil=="Success"){
                window.location.reload();
            }
        }
    });
});
$('#ProsesSettingWebsite').submit(function(){
    $('#NotifikasiSettingWebsite').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesSettingWebsite')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSetting/ProsesSettingWebsite.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiSettingWebsite').html(data);
            var NotifikasiSettingWebsiteBerhasil=$('#NotifikasiSettingWebsiteBerhasil').html();
            if(NotifikasiSettingWebsiteBerhasil=="Success"){
                window.location.reload();
            }
        }
    });
});