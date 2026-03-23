$('#MenampilkanTabelFAQ').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebFAQ/TabelFAQ.php',
    success     : function(data){
        $('#MenampilkanTabelFAQ').html(data);
    }
});
//Ketika submit tambah FAQ
$('#ProsesTambahFAQ').submit(function(){
    $('#NotifikasiTambahFAQ').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahFAQ')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebFAQ/ProsesTambahFAQ.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahFAQ').html(data);
            var NotifikasiTambahFAQBerhasil=$('#NotifikasiTambahFAQBerhasil').html();
            if(NotifikasiTambahFAQBerhasil=="Success"){
                //reset form
                $('#ProsesTambahFAQ')[0].reset();
                //Apabila berhasil tutup modal
                $('#ModalTambahFAQ').modal('hide');
                //Reset Tabel
                $('#MenampilkanTabelFAQ').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebFAQ/TabelFAQ.php',
                    success     : function(data){
                        $('#MenampilkanTabelFAQ').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Tambah FAQ Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit FAQ
$('#ModalEditFAQ').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_faq = $(e.relatedTarget).data('id');
    $('#FormEditFAQ').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebFAQ/FormEditFAQ.php',
        data        : {id_web_faq: id_web_faq},
        success     : function(data){
            $('#FormEditFAQ').html(data);
        }
    });
});
//Ketika submit Edit FAQ
$('#ProsesEditFAQ').submit(function(){
    $('#NotifikasiEditFAQ').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesEditFAQ')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebFAQ/ProsesEditFAQ.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditFAQ').html(data);
            var NotifikasiEditFAQBerhasil=$('#NotifikasiEditFAQBerhasil').html();
            if(NotifikasiEditFAQBerhasil=="Success"){
                //Apabila berhasil tutup modal
                $('#ModalEditFAQ').modal('hide');
                //Reset Tabel
                $('#MenampilkanTabelFAQ').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebFAQ/TabelFAQ.php',
                    success     : function(data){
                        $('#MenampilkanTabelFAQ').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Edit FAQ Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});

//Modal Delete Met Tag
$('#ModalHapustFAQ').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_faq = $(e.relatedTarget).data('id');
    $('#FormHapusFAQ').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebFAQ/FormHapusFAQ.php',
        data 	    :  {id_web_faq: id_web_faq},
        success     : function(data){
            $('#FormHapusFAQ').html(data);
            $('#KonfirmasiHapusFAQ').click(function(){
                $('#NotifikasiHapusFAQ').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebFAQ/ProsesHapusFAQ.php',
                    data 	    :  { id_web_faq: id_web_faq },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusFAQ').html(data);
                        var NotifikasiHapusFAQBerhasil=$('#NotifikasiHapusFAQBerhasil').html();
                        if(NotifikasiHapusFAQBerhasil=="Success"){
                            //Apabila berhasil tutup modal
                            $('#ModalHapustFAQ').modal('hide');
                            //Reset Tabel
                            $('#MenampilkanTabelFAQ').html('Loading...');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebFAQ/TabelFAQ.php',
                                success     : function(data){
                                    $('#MenampilkanTabelFAQ').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Hapus FAQ Berhasil',
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
//Midal Posisi Naik
$('#ModalPosisiNaik').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_faq = $(e.relatedTarget).data('id');
    var posisi="Naik";
    $('#FormPosisiFAQNaik').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebFAQ/ProsesPosisiFAQ.php',
        data 	    :  {id_web_faq: id_web_faq, posisi: posisi},
        success     : function(data){
            $('#FormPosisiFAQNaik').html(data);
            var NotifikasiPosisiFAQBerhasil=$('#NotifikasiPosisiFAQBerhasil').html();
            if(NotifikasiPosisiFAQBerhasil=="Success"){
                //Reset Tabel
                $('#MenampilkanTabelFAQ').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebFAQ/TabelFAQ.php',
                    success     : function(data){
                        $('#MenampilkanTabelFAQ').html(data);
                    }
                });
            }
        }
    });
});
$('#ModalPosisiTurun').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_faq = $(e.relatedTarget).data('id');
    var posisi="Turun";
    $('#FormPosisiFAQTurun').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebFAQ/ProsesPosisiFAQ.php',
        data 	    :  {id_web_faq: id_web_faq, posisi: posisi},
        success     : function(data){
            $('#FormPosisiFAQTurun').html(data);
            var NotifikasiPosisiFAQBerhasil=$('#NotifikasiPosisiFAQBerhasil').html();
            if(NotifikasiPosisiFAQBerhasil=="Success"){
                //Reset Tabel
                $('#MenampilkanTabelFAQ').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebFAQ/TabelFAQ.php',
                    success     : function(data){
                        $('#MenampilkanTabelFAQ').html(data);
                    }
                });
            }
        }
    });
});