$('#MenampilkanTabelSlider').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebSlider/TabelSlider.php',
    success     : function(data){
        $('#MenampilkanTabelSlider').html(data);
    }
});
//Ketika submit tambah Slider
$('#ProsesTambahSlider').submit(function(){
    $('#NotifikasiTambahSlider').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahSlider')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSlider/ProsesTambahSlider.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahSlider').html(data);
            var NotifikasiTambahSliderBerhasil=$('#NotifikasiTambahSliderBerhasil').html();
            if(NotifikasiTambahSliderBerhasil=="Success"){
                //reset form
                $('#ProsesTambahSlider')[0].reset();
                //Apabila berhasil tutup modal
                $('#ModalTambahSlider').modal('hide');
                //Reset Tabel
                $('#MenampilkanTabelSlider').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebSlider/TabelSlider.php',
                    success     : function(data){
                        $('#MenampilkanTabelSlider').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Tambah Slider Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit Slider
$('#ModalEditSlider').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_hero = $(e.relatedTarget).data('id');
    $('#FormEditSlider').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSlider/FormEditSlider.php',
        data        : {id_web_hero: id_web_hero},
        success     : function(data){
            $('#FormEditSlider').html(data);
        }
    });
});
//Ketika submit Edit Slider
$('#ProsesEditSlider').submit(function(){
    $('#NotifikasiEditSlider').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesEditSlider')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSlider/ProsesEditSlider.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditSlider').html(data);
            var NotifikasiEditSliderBerhasil=$('#NotifikasiEditSliderBerhasil').html();
            if(NotifikasiEditSliderBerhasil=="Success"){
                //Apabila berhasil tutup modal
                $('#ModalEditSlider').modal('hide');
                //Reset Tabel
                $('#MenampilkanTabelSlider').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebSlider/TabelSlider.php',
                    success     : function(data){
                        $('#MenampilkanTabelSlider').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Edit Slider Berhasil',
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
$('#ModalHapustSlider').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_web_hero = $(e.relatedTarget).data('id');
    $('#FormHapusSlider').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebSlider/FormHapusSlider.php',
        data 	    :  {id_web_hero: id_web_hero},
        success     : function(data){
            $('#FormHapusSlider').html(data);
            $('#KonfirmasiHapusSlider').click(function(){
                $('#NotifikasiHapusSlider').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebSlider/ProsesHapusSlider.php',
                    data 	    :  { id_web_hero: id_web_hero },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusSlider').html(data);
                        var NotifikasiHapusSliderBerhasil=$('#NotifikasiHapusSliderBerhasil').html();
                        if(NotifikasiHapusSliderBerhasil=="Success"){
                            //Apabila berhasil tutup modal
                            $('#ModalHapustSlider').modal('hide');
                            //Reset Tabel
                            $('#MenampilkanTabelSlider').html('Loading...');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebSlider/TabelSlider.php',
                                success     : function(data){
                                    $('#MenampilkanTabelSlider').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Hapus Slider Berhasil',
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