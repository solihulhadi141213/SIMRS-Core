$('#TabelTestimoni').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebTestimoni/TabelTestimoni.php',
    success     : function(data){
        $('#TabelTestimoni').html(data);
    }
});
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelTestimoni').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebTestimoni/TabelTestimoni.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelTestimoni').html(data);
        }
    });
});
//keyword_by
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebTestimoni/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TabelTestimoni').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebTestimoni/TabelTestimoni.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#TabelTestimoni').html(data);
        }
    });
});
//Modal Tambah Testimoni
$('#ModalTambahTestimoni').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormTambahTestimoni').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebTestimoni/FormTambahTestimoni.php',
        success     : function(data){
            $('#FormTambahTestimoni').html(data);
        }
    });
});
//Proses Tambah Testimoni
$('#ProsesTambahTestimoni').submit(function(){
    $('#NotifikasiTambahTestimoni').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahTestimoni')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebTestimoni/ProsesTambahTestimoni.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahTestimoni').html(data);
            var NotifikasiTambahTestimoniBerhasil=$('#NotifikasiTambahTestimoniBerhasil').html();
            if(NotifikasiTambahTestimoniBerhasil=="Success"){
                var BatasPencarian = $('#BatasPencarian').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#TabelTestimoni').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebTestimoni/TabelTestimoni.php',
                    data 	    :  BatasPencarian,
                    success     : function(data){
                        $('#TabelTestimoni').html(data);
                        $('#ModalTambahTestimoni').modal('hide');
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Tambah Testimoni Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Detail Testimoni
$('#ModalDetailTestimoni').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_testimoni = $(e.relatedTarget).data('id');
    $('#FormDetailTestimoni').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebTestimoni/FormDetailTestimoni.php',
        data 	    :  {id_web_testimoni: id_web_testimoni},
        success     : function(data){
            $('#FormDetailTestimoni').html(data);
        }
    });
});
//Modal Hapus Testimoni
$('#ModalHapusTestimoni').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_testimoni = $(e.relatedTarget).data('id');
    $('#FormHapusTestimoni').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebTestimoni/FormHapusTestimoni.php',
        data 	    :  {id_web_testimoni: id_web_testimoni},
        success     : function(data){
            $('#FormHapusTestimoni').html(data);
            $('#KonfirmasiHapusTestimoni').click(function(){
                $('#NotifikasiHapusTestimoni').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebTestimoni/ProsesHapusTestimoni.php',
                    data 	    :  { id_web_testimoni: id_web_testimoni },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusTestimoni').html(data);
                        var NotifikasiHapusTestimoniBerhasil=$('#NotifikasiHapusTestimoniBerhasil').html();
                        if(NotifikasiHapusTestimoniBerhasil=="Success"){
                            var BatasPencarian = $('#BatasPencarian').serialize();
                            var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                            $('#TabelTestimoni').html(Loading);
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebTestimoni/TabelTestimoni.php',
                                data 	    :  BatasPencarian,
                                success     : function(data){
                                    $('#TabelTestimoni').html(data);
                                    $('#ModalHapusTestimoni').modal('hide');
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Hapus Testimoni Berhasil',
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
//Modal Edit Testimoni
$('#ModalEditTestimoni').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_testimoni = $(e.relatedTarget).data('id');
    $('#FormEditTestimoni').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebTestimoni/FormEditTestimoni.php',
        data 	    :  {id_web_testimoni: id_web_testimoni},
        success     : function(data){
            $('#FormEditTestimoni').html(data);
        }
    });
});
//Proses Edit Testimoni
$('#ProsesEditTestimoni').submit(function(){
    $('#NotifikasiEditTestimoni').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesEditTestimoni')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebTestimoni/ProsesEditTestimoni.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditTestimoni').html(data);
            var NotifikasiEditTestimoniBerhasil=$('#NotifikasiEditTestimoniBerhasil').html();
            if(NotifikasiEditTestimoniBerhasil=="Success"){
                var BatasPencarian = $('#BatasPencarian').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#TabelTestimoni').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebTestimoni/TabelTestimoni.php',
                    data 	    :  BatasPencarian,
                    success     : function(data){
                        $('#TabelTestimoni').html(data);
                        $('#ModalEditTestimoni').modal('hide');
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Edit Testimoni Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});