$('#MenampilkanTabelArsip').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebArsip/TabelArsip.php',
    success     : function(data){
        $('#MenampilkanTabelArsip').html(data);
    }
});
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelArsip').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArsip/TabelArsip.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelArsip').html(data);
        }
    });
});
//keyword_by
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArsip/FormKeyword.php',
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
    $('#MenampilkanTabelArsip').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArsip/TabelArsip.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelArsip').html(data);
        }
    });
});
//Ketika submit tambah arsip
$('#ProsesTambahArsip').submit(function(){
    $('#NotifikasiTambahArsip').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahArsip')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArsip/ProsesTambahArsip.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahArsip').html(data);
            var NotifikasiTambahArsipBerhasil=$('#NotifikasiTambahArsipBerhasil').html();
            if(NotifikasiTambahArsipBerhasil=="Success"){
                //reset form
                $('#ProsesTambahArsip')[0].reset();
                //Apabila berhasil tutup modal
                $('#ModalTambahArsip').modal('hide');
                //Reset Tabel
                $('#MenampilkanTabelArsip').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebArsip/TabelArsip.php',
                    success     : function(data){
                        $('#MenampilkanTabelArsip').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Tambah Arsip Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Detail Arsip
$('#ModalDetailArsip').on('show.bs.modal', function (e) {
    var Loading='<div class="row"><div class="col col-md-12">Loading..</div></div>';
    var id_arsip = $(e.relatedTarget).data('id');
    $('#FormDetailArsip').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArsip/FormDetailArsip.php',
        data        : {id_arsip: id_arsip},
        success     : function(data){
            $('#FormDetailArsip').html(data);
        }
    });
});
//Modal Edit Arsip
$('#ModalEditArsip').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_arsip = $(e.relatedTarget).data('id');
    $('#FormEditArsip').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArsip/FormEditArsip.php',
        data        : {id_arsip: id_arsip},
        success     : function(data){
            $('#FormEditArsip').html(data);
        }
    });
});
//Ketika submit Edit Arsip
$('#ProsesEditArsip').submit(function(){
    $('#NotifikasiEditArsip').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesEditArsip')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArsip/ProsesEditArsip.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditArsip').html(data);
            var NotifikasiEditArsipBerhasil=$('#NotifikasiEditArsipBerhasil').html();
            if(NotifikasiEditArsipBerhasil=="Success"){
                //reset form
                $('#ProsesEditArsip')[0].reset();
                //Apabila berhasil tutup modal
                $('#ModalEditArsip').modal('hide');
                //Reset Tabel
                $('#MenampilkanTabelArsip').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebArsip/TabelArsip.php',
                    success     : function(data){
                        $('#MenampilkanTabelArsip').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Edit Arsip Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});

//Modal Hapus Arsip
$('#ModalHapusArsip').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_arsip = $(e.relatedTarget).data('id');
    $('#FormHapusArsip').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebArsip/FormHapusArsip.php',
        data 	    :  {id_arsip: id_arsip},
        success     : function(data){
            $('#FormHapusArsip').html(data);
            //Konfirmasi Hapus Arsip
            $('#KonfirmasiHapusArsip').click(function(){
                $('#NotifikasiHapusArsip').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebArsip/ProsesHapusArsip.php',
                    data 	    :  { id_arsip: id_arsip },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusArsip').html(data);
                        var NotifikasiHapusArsipBerhasil=$('#NotifikasiHapusArsipBerhasil').html();
                        if(NotifikasiHapusArsipBerhasil=="Success"){
                            //Apabila berhasil tutup modal
                            $('#ModalHapusArsip').modal('hide');
                            //Reset Tabel
                            $('#MenampilkanTabelArsip').html('Loading...');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebArsip/TabelArsip.php',
                                success     : function(data){
                                    $('#MenampilkanTabelArsip').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Hapus Arsip Berhasil',
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
