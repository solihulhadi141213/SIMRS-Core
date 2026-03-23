$('#TampilkanListProfileSettingBridging').load("_Page/SettingBridging/ListSettingBridging.php");
//Tambah Bridging
$('#ModalTambahBridging').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormTambahBridging').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SettingBridging/FormTambahBridging.php',
        success     : function(data){
            $('#FormTambahBridging').html(data);
            $('#ProsesTambahSettingBridging').submit(function(){
                e.preventDefault();
                $('#NotifikasiTambahSettingBridging').html('Loading..');
                var form = $('#ProsesTambahSettingBridging')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SettingBridging/ProsesTambahSettingBridging.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahSettingBridging').html(data);
                        var Notifikasi=$('#Notifikasi').html();
                        if(Notifikasi=="Berhasil"){
                            $('#TampilkanListProfileSettingBridging').load("_Page/SettingBridging/ListSettingBridging.php");
                            $('#ModalTambahBridging').modal('toggle');
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Setting Berhasil Disimpan',
                                icon: 'success',
                                confirmButtonText: 'Tutup'
                            })
                        }
                    }
                });
            });
        }
    });
});
//Modal Consol
$('#ModalConsol').on('show.bs.modal', function (e) {
    var id_bridging = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormConsol').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SettingBridging/FormConsol.php',
        data        :  {id_bridging: id_bridging},
        success     : function(data){
            $('#FormConsol').html(data);
            $('#ProsesConsol').submit(function(){
                e.preventDefault();
                $('#GetResponse').html('Loading..');
                var form = $('#ProsesConsol')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SettingBridging/ProsesConsol.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#GetResponse').html(data);
                    }
                });
            });
        }
    });
});
//Modal Edit Bridging
$('#ModalEditBridging').on('show.bs.modal', function (e) {
    var id_bridging = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormEditBridging').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SettingBridging/FormEditBridging.php',
        data        :  {id_bridging: id_bridging},
        success     : function(data){
            $('#FormEditBridging').html(data);
            $('#ProsesEditBridging').submit(function(){
                e.preventDefault();
                $('#NotifikasiEditBridging').html('Loading..');
                var form = $('#ProsesEditBridging')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SettingBridging/ProsesEditBridging.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditBridging').html(data);
                        var NotifikasiEdit=$('#NotifikasiEdit').html();
                        if(NotifikasiEdit=="Berhasil"){
                            $('#TampilkanListProfileSettingBridging').load("_Page/SettingBridging/ListSettingBridging.php");
                            $('#ModalEditBridging').modal('toggle');
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Setting Berhasil Disimpan',
                                icon: 'success',
                                confirmButtonText: 'Tutup'
                            })
                        }
                    }
                });
            });
        }
    });
});
//Modal Hapus Bridging
$('#ModalHapusBridging').on('show.bs.modal', function (e) {
    var id_bridging = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormHapusBridging').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SettingBridging/FormHapusBridging.php',
        data        :  {id_bridging: id_bridging},
        success     : function(data){
            $('#FormHapusBridging').html(data);
            $('#KonfirmasiHapusBridging').click(function(){
                $('#NotifikasiHapusBridging').html('Loading...');
                $.ajax({
                    url     : "_Page/SettingBridging/ProsesHapusBridging.php",
                    method  : "POST",
                    data    :  {id_bridging: id_bridging},
                    success : function (data) {
                        $('#NotifikasiHapusBridging').html(data);
                        //Notifikasi Proses Hapus
                        var NotifikasiHapus=$('#NotifikasiHapus').html();
                        if(NotifikasiHapus=="Hapus Bridging Berhasil"){
                            $('#TampilkanListProfileSettingBridging').load("_Page/SettingBridging/ListSettingBridging.php");
                            $('#ModalHapusBridging').modal('toggle');
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Profile Bridging Berhasil',
                                icon: 'success',
                                confirmButtonText: 'Tutup'
                            })
                        }
                    }
                })
            });
        }
    });
});