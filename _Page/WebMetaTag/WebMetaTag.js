$('#MenampilkanTabelMetaTag').load("_Page/WebMetaTag/TabelWebMetaTag.php");
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelMetaTag').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebMetaTag/TabelWebMetaTag.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelMetaTag').html(data);
        }
    });
});
//Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelMetaTag').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebMetaTag/TabelWebMetaTag.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelMetaTag').html(data);
        }
    });
});
//Ketika submit tambah meta tag
$('#ProsesTambahMetaTag').submit(function(){
    $('#NotifikasiTambahMetaTag').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahMetaTag')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebMetaTag/ProsesTambahMetaTag.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahMetaTag').html(data);
            var NotifikasiTambahMetaTagBerhasil=$('#NotifikasiTambahMetaTagBerhasil').html();
            if(NotifikasiTambahMetaTagBerhasil=="Success"){
                //reset form
                $('#ProsesTambahMetaTag')[0].reset();
                //Apabila berhasil tutup modal
                $('#ModalTambahtMetaTag').modal('hide');
                //Reset Tabel
                $('#MenampilkanTabelMetaTag').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebMetaTag/TabelWebMetaTag.php',
                    success     : function(data){
                        $('#MenampilkanTabelMetaTag').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Tambah Meta Tag Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit Meta Tag
$('#ModalEditMetaTag').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_metatag = $(e.relatedTarget).data('id');
    $('#FormEditMetaTag').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebMetaTag/FormEditMetaTag.php',
        data        : {id_web_metatag: id_web_metatag},
        success     : function(data){
            $('#FormEditMetaTag').html(data);
            $('#ProsesEditMetaTag').submit(function(){
                e.preventDefault();
                $('#NotifikasiEditMetaTag').html('Loading..');
                var form = $('#ProsesEditMetaTag')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebMetaTag/ProsesEditMetaTag.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditMetaTag').html(data);
                        var NotifikasiEditMetaTagBerhasil=$('#NotifikasiEditMetaTagBerhasil').html();
                        if(NotifikasiEditMetaTagBerhasil=="Success"){
                            //Apabila berhasil tutup modal
                            $('#ModalEditMetaTag').modal('hide');
                            //Reset Tabel
                            $('#MenampilkanTabelMetaTag').html('Loading...');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebMetaTag/TabelWebMetaTag.php',
                                success     : function(data){
                                    $('#MenampilkanTabelMetaTag').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Edit Meta Tag Berhasil',
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
//Modal Delete Met Tag
$('#ModalHapustMetaTag').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_metatag = $(e.relatedTarget).data('id');
    $('#FormHapusMetaTag').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebMetaTag/FormHapusMetaTag.php',
        data 	    :  {id_web_metatag: id_web_metatag},
        success     : function(data){
            $('#FormHapusMetaTag').html(data);
            $('#KonfirmasiHapusMetaTag').click(function(){
                $('#NotifikasiHapusMetaTag').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebMetaTag/ProsesHapusMetaTag.php',
                    data 	    :  { id_web_metatag: id_web_metatag },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusMetaTag').html(data);
                        var NotifikasiHapusMetaTagBerhasil=$('#NotifikasiHapusMetaTagBerhasil').html();
                        if(NotifikasiHapusMetaTagBerhasil=="Success"){
                            //Apabila berhasil tutup modal
                            $('#ModalHapustMetaTag').modal('hide');
                            //Reset Tabel
                            $('#MenampilkanTabelMetaTag').html('Loading...');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebMetaTag/TabelWebMetaTag.php',
                                success     : function(data){
                                    $('#MenampilkanTabelMetaTag').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Hapus Meta Tag Berhasil',
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