$('#MenampilkanTabelMedsos').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebMedsos/TabelMedsos.php',
    success     : function(data){
        $('#MenampilkanTabelMedsos').html(data);
    }
});
//Ketika submit tambah Medsos
$('#ProsesTambahMedsos').submit(function(){
    $('#NotifikasiTambahMedsos').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahMedsos')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebMedsos/ProsesTambahMedsos.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahMedsos').html(data);
            var NotifikasiTambahMedsosBerhasil=$('#NotifikasiTambahMedsosBerhasil').html();
            if(NotifikasiTambahMedsosBerhasil=="Success"){
                //reset form
                $('#ProsesTambahMedsos')[0].reset();
                //Apabila berhasil tutup modal
                $('#ModalTambahMedsos').modal('hide');
                //Reset Tabel
                $('#MenampilkanTabelMedsos').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebMedsos/TabelMedsos.php',
                    success     : function(data){
                        $('#MenampilkanTabelMedsos').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Tambah Medsos Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit Medsos
$('#ModalEditMedsos').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_medsos = $(e.relatedTarget).data('id');
    $('#FormEditMedsos').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebMedsos/FormEditMedsos.php',
        data        : {id_web_medsos: id_web_medsos},
        success     : function(data){
            $('#FormEditMedsos').html(data);
        }
    });
});
//Ketika submit Edit Medsos
$('#ProsesEditMedsos').submit(function(){
    $('#NotifikasiEditMedsos').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesEditMedsos')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebMedsos/ProsesEditMedsos.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditMedsos').html(data);
            var NotifikasiEditMedsosBerhasil=$('#NotifikasiEditMedsosBerhasil').html();
            if(NotifikasiEditMedsosBerhasil=="Success"){
                //Apabila berhasil tutup modal
                $('#ModalEditMedsos').modal('hide');
                //Reset Tabel
                $('#MenampilkanTabelMedsos').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebMedsos/TabelMedsos.php',
                    success     : function(data){
                        $('#MenampilkanTabelMedsos').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Edit Medsos Berhasil',
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
$('#ModalHapustMedsos').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_medsos = $(e.relatedTarget).data('id');
    $('#FormHapusMedsos').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebMedsos/FormHapusMedsos.php',
        data 	    :  {id_web_medsos: id_web_medsos},
        success     : function(data){
            $('#FormHapusMedsos').html(data);
            $('#KonfirmasiHapusMedsos').click(function(){
                $('#NotifikasiHapusMedsos').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebMedsos/ProsesHapusMedsos.php',
                    data 	    :  { id_web_medsos: id_web_medsos },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusMedsos').html(data);
                        var NotifikasiHapusMedsosBerhasil=$('#NotifikasiHapusMedsosBerhasil').html();
                        if(NotifikasiHapusMedsosBerhasil=="Success"){
                            //Apabila berhasil tutup modal
                            $('#ModalHapustMedsos').modal('hide');
                            //Reset Tabel
                            $('#MenampilkanTabelMedsos').html('Loading...');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebMedsos/TabelMedsos.php',
                                success     : function(data){
                                    $('#MenampilkanTabelMedsos').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Hapus Medsos Berhasil',
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
