var FilterReferensiAlergi=$('#FilterReferensiAlergi').serialize();
$('#TabelAlergi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Alergi/TabelAlergi.php',
    data 	    :  FilterReferensiAlergi,
    enctype     : 'multipart/form-data',
    success     : function(data){
        $('#TabelAlergi').html(data);
    }
});
//Casar Pencarian Berubah
$('#keyword_by').change(function(){
    var keyword_by=$('#keyword_by').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Alergi/FormKataKunci.php',
        data 	    :  {keyword_by: keyword_by},
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#FormKataKunci').html(data);
        }
    });
});
//Pencarian
$('#FilterReferensiAlergi').submit(function(){
    var FilterReferensiAlergi=$('#FilterReferensiAlergi').serialize();
    $('#TabelAlergi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Alergi/TabelAlergi.php',
        data 	    :  FilterReferensiAlergi,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#TabelAlergi').html(data);
            $('#ModalFilterAlergi').modal('hide');
        }
    });
});
//Detail Data Alergi
$('#ModalDetailAlergi').on('show.bs.modal', function (e) {
    var id_referensi_alergi = $(e.relatedTarget).data('id');
    $('#FormDetailAlergi').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Alergi/FormDetailAlergi.php',
        data 	    :  {id_referensi_alergi: id_referensi_alergi},
        success     : function(data){
            $('#FormDetailAlergi').html(data);
        }
    });
});
//Modal Tambah Alergi
$('#ModalTambahhAlergi').on('show.bs.modal', function (e) {
    $('#NotifikasiTambahAlergi').html('Pastikan data alergi yang anda input sudah benar!');
});
//Proses Tambah Alergi
$('#ProsesTambahAlergi').submit(function(){
    var ProsesTambahAlergi=$('#ProsesTambahAlergi').serialize();
    $('#NotifikasiTambahAlergi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Alergi/ProsesTambahAlergi.php',
        data 	    :  ProsesTambahAlergi,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahAlergi').html(data);
            var NotifikasiTambahAlergiBerhasil=$('#NotifikasiTambahAlergiBerhasil').html();
            if(NotifikasiTambahAlergiBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalTambahhAlergi').modal('hide');
                $('#ProsesTambahAlergi')[0].reset();
                $('#FilterReferensiAlergi')[0].reset();
                //Tampilkan Data Terbaru
                var FilterReferensiAlergi=$('#FilterReferensiAlergi').serialize();
                $('#TabelAlergi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Alergi/TabelAlergi.php',
                    data 	    :  FilterReferensiAlergi,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#TabelAlergi').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Referensi Alergi Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Hapus Alergi
$('#ModalHapusAlergi').on('show.bs.modal', function (e) {
    var id_referensi_alergi = $(e.relatedTarget).data('id');
    $('#FormHapusAlergi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Alergi/FormHapusAlergi.php',
        data 	    :  {id_referensi_alergi: id_referensi_alergi},
        success     : function(data){
            $('#FormHapusAlergi').html(data);
            $('#ModalDetailAlergi').modal('hide');
        }
    });
});
//Proses HHapus Alergi
$('#ProsesHapusAlergi').submit(function(){
    var ProsesHapusAlergi=$('#ProsesHapusAlergi').serialize();
    $('#FormHapusAlergi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Alergi/ProsesHapusAlergi.php',
        data 	    :  ProsesHapusAlergi,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#FormHapusAlergi').html(data);
            var NotifikasiHapusAlergiBerhasil=$('#NotifikasiHapusAlergiBerhasil').html();
            if(NotifikasiHapusAlergiBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalHapusAlergi').modal('hide');
                //Tampilkan Data Terbaru
                var FilterReferensiAlergi=$('#FilterReferensiAlergi').serialize();
                $('#TabelAlergi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Alergi/TabelAlergi.php',
                    data 	    :  FilterReferensiAlergi,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#TabelAlergi').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Hapus Referensi Alergi Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit Alergi
$('#ModalEditAlergi').on('show.bs.modal', function (e) {
    var id_referensi_alergi = $(e.relatedTarget).data('id');
    $('#FormEditAlergi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Alergi/FormEditAlergi.php',
        data 	    :  {id_referensi_alergi: id_referensi_alergi},
        success     : function(data){
            $('#FormEditAlergi').html(data);
            $('#NotifikasiEditAlergi').html('Pastikan data alergi yang anda input sudah benar!');
            $('#ModalDetailAlergi').modal('hide');
        }
    });
});
//Proses Edit Alergi
$('#ProsesEditAlergi').submit(function(){
    var ProsesEditAlergi=$('#ProsesEditAlergi').serialize();
    $('#NotifikasiEditAlergi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Alergi/ProsesEditAlergi.php',
        data 	    :  ProsesEditAlergi,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditAlergi').html(data);
            var NotifikasiEditAlergiBerhasil=$('#NotifikasiEditAlergiBerhasil').html();
            if(NotifikasiEditAlergiBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalEditAlergi').modal('hide');
                //Tampilkan Data Terbaru
                var FilterReferensiAlergi=$('#FilterReferensiAlergi').serialize();
                $('#TabelAlergi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Alergi/TabelAlergi.php',
                    data 	    :  FilterReferensiAlergi,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#TabelAlergi').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Edit Referensi Alergi Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Import Alergi
$('#ModalImportAlergi').on('show.bs.modal', function (e) {
    $('#NotifikasiImportAlergi').html('Tunggu sampai proses selesai ');
});
//Proses Import Database Alergi
$('#ProsesImportAlergi').submit(function(){
    var form = $('#ProsesImportAlergi')[0];
    var data = new FormData(form);
    $('#NotifikasiImportAlergi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Alergi/ProsesImportAlergi.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiImportAlergi').html(data);
            var NotifikasiImportAlergiBerhasil=$('#NotifikasiImportAlergiBerhasil').html();
            if(NotifikasiImportAlergiBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                // $('#ModalImportAlergi').modal('hide');
                //Tampilkan Data Terbaru
                var FilterReferensiAlergi=$('#FilterReferensiAlergi').serialize();
                $('#TabelAlergi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Alergi/TabelAlergi.php',
                    data 	    :  FilterReferensiAlergi,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#TabelAlergi').html(data);
                        $('#ProsesImportAlergi')[0].reset();
                        //Tampilkan Swal
                        // Swal.fire({
                        //     title: 'Good Job!',
                        //     text: 'Import Data Referensi Alergi Berhasil',
                        //     icon: 'success',
                        //     confirmButtonText: 'Tutup'
                        // })
                    }
                });
            }
        }
    });
});