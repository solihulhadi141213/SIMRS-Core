$('#TabelRuangRawat').load("_Page/WebRuangRawat/TabelRuangRawat.php");
//Proses Tambah Ruang Rawat
$('#ProsesTambahRuangRawat').submit(function(){
    $('#NotifikasiTambahRuangan').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesTambahRuangRawat')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebRuangRawat/ProsesTambahRuangRawat.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahRuangan').html(data);
            var NotifikasiTambahRuanganBerhasil=$('#NotifikasiTambahRuanganBerhasil').html();
            if(NotifikasiTambahRuanganBerhasil=="Success"){
                //reset form
                $('#ProsesTambahRuangRawat')[0].reset();
                //Apabila berhasil tutup modal
                $('#ModalTambahRuangRawat').modal('hide');
                //Reset Tabel
                $('#TabelRuangRawat').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebRuangRawat/TabelRuangRawat.php',
                    success     : function(data){
                        $('#TabelRuangRawat').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Tambah Ruang Rawat Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit Ruang Rawat
$('#ModalEditRuangRawat').on('show.bs.modal', function (e) {
    var Loading='Loading...';
    var ruang_rawat = $(e.relatedTarget).data('id');
    $('#FormEditRuangRawat').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebRuangRawat/FormEditRuangRawat.php',
        data 	    :  {ruang_rawat: ruang_rawat},
        success     : function(data){
            $('#FormEditRuangRawat').html(data);
        }
    });
});
//Proses Edit Ruang Rawat
$('#ProsesEditRuangRawat').submit(function(){
    $('#NotifikasiEditRuangan').html('<span class="text-primary">Loading...</span>');
    var form = $('#ProsesEditRuangRawat')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebRuangRawat/ProsesEditRuangRawat.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditRuangan').html(data);
            var NotifikasiEditRuanganBerhasil=$('#NotifikasiEditRuanganBerhasil').html();
            if(NotifikasiEditRuanganBerhasil=="Success"){
                //Apabila berhasil tutup modal
                $('#ModalEditRuangRawat').modal('hide');
                //Reset Tabel
                $('#TabelRuangRawat').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebRuangRawat/TabelRuangRawat.php',
                    success     : function(data){
                        $('#TabelRuangRawat').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Mantap!',
                            text: 'Edit Ruang Rawat Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Sinkronkan Dari Simrs
$('#ModalSinkronkanDariSimrs').on('show.bs.modal', function (e) {
    var Loading='Loading...';
    $('#FormSinkronisasiRuangRawat').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebRuangRawat/FormSinkronisasiRuangRawat.php',
        success     : function(data){
            $('#FormSinkronisasiRuangRawat').html(data);
        }
    });
});
$('#MulaiProsesSinkronisasiRuangan').click(function(){
    $('#FormSinkronisasiRuangRawat').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebRuangRawat/ProsesSinkronisasiRuangan.php',
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#FormSinkronisasiRuangRawat').html(data);
        }
    });
});
//Modal Hapus Ruang Rawat
$('#ModalHapusRuangRawat').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var ruang_rawat = $(e.relatedTarget).data('id');
    $('#FormHapusRuang').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebRuangRawat/FormHapusRuang.php',
        data 	    :  {ruang_rawat: ruang_rawat},
        success     : function(data){
            $('#FormHapusRuang').html(data);
            $('#KonfirmasiHapusRuang').click(function(){
                $('#NotifikasiHapusRuang').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebRuangRawat/ProsesHapusRuang.php',
                    data 	    :  { ruang_rawat: ruang_rawat },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusRuang').html(data);
                        var NotifikasiHapusRuangBerhasil=$('#NotifikasiHapusRuangBerhasil').html();
                        if(NotifikasiHapusRuangBerhasil=="Success"){
                            $('#TabelRuangRawat').load("_Page/WebRuangRawat/TabelRuangRawat.php");
                            $('#ModalHapusRuangRawat').modal('hide');
                            Swal.fire({
                                title: 'Mantap!',
                                text: 'Hapus Ruang Rawat Berhasil',
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