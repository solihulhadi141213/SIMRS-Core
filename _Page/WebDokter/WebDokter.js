$('#MenampilkanTabelDokter').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebDokter/TabelDokter.php',
    success     : function(data){
        $('#MenampilkanTabelDokter').html(data);
    }
});
//Batas dan Pencarian
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebDokter/TabelDokter.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelDokter').html(data);
        }
    });
});
//keyword_by
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebDokter/FormKeyword.php',
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
    $('#MenampilkanTabelDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebDokter/TabelDokter.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelDokter').html(data);
        }
    });
});
//Modal Detail Dokter
$('#ModalDetailDokter').on('show.bs.modal', function (e) {
    var Loading='<div class="row"><div class="col col-md-12">Loading..</div></div>';
    var id_dokter = $(e.relatedTarget).data('id');
    $('#FormDetailDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebDokter/FormDetailDokter.php',
        data        : {id_dokter: id_dokter},
        success     : function(data){
            $('#FormDetailDokter').html(data);
        }
    });
});

//Modal Hapus Dokter
$('#ModalHapusDokter').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_dokter = $(e.relatedTarget).data('id');
    $('#FormHapusDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebDokter/FormHapusDokter.php',
        data 	    :  {id_dokter: id_dokter},
        success     : function(data){
            $('#FormHapusDokter').html(data);
            //Konfirmasi Hapus Dokter
            $('#KonfirmasiHapusDokter').click(function(){
                $('#NotifikasiHapusDokter').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebDokter/ProsesHapusDokter.php',
                    data 	    :  { id_dokter: id_dokter },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusDokter').html(data);
                        var NotifikasiHapusDokterBerhasil=$('#NotifikasiHapusDokterBerhasil').html();
                        if(NotifikasiHapusDokterBerhasil=="Success"){
                            //Apabila berhasil tutup modal
                            $('#ModalHapusDokter').modal('hide');
                            //Reset Tabel
                            $('#MenampilkanTabelDokter').html('Loading...');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebDokter/TabelDokter.php',
                                success     : function(data){
                                    $('#MenampilkanTabelDokter').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Hapus Dokter Berhasil',
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
//Modal Tambah Dokter
$('#ModalTambahDokterDeh').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_dokter = $(e.relatedTarget).data('id');
    $('#FormTambahDokterDeh').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebDokter/FormTambahDokter.php',
        data 	    :  {id_dokter: id_dokter},
        success     : function(data){
            $('#FormTambahDokterDeh').html(data);
            //Proses Tambah Galeri
            $('#ProsesTambahDokterDeh').submit(function(){
                $('#NotifikasiTambahDokterDeh').html('<span class="text-primary">Loading...</span>');
                var form = $('#ProsesTambahDokterDeh')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebDokter/ProsesTambahDokter.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahDokterDeh').html(data);
                        var NotifikasiTambahDokterBerhasil=$('#NotifikasiTambahDokterBerhasil').html();
                        if(NotifikasiTambahDokterBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Edit Dokter
$('#ModalEditDokter').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_dokter = $(e.relatedTarget).data('id');
    $('#FormEditDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebDokter/FormEditDokter.php',
        data 	    :  {id_dokter: id_dokter},
        success     : function(data){
            $('#FormEditDokter').html(data);
            //Proses Tambah Galeri
            $('#ProsesEditDokter').submit(function(){
                $('#NotifikasiEditDokter').html('<span class="text-primary">Loading...</span>');
                var form = $('#ProsesEditDokter')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebDokter/ProsesEditDokter.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditDokter').html(data);
                        var NotifikasiEditDokterBerhasil=$('#NotifikasiEditDokterBerhasil').html();
                        if(NotifikasiEditDokterBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
var GetIdDokter=$('#GetIdDokter').val();
$('#TabelJadwalDokterWeb').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebDokter/TabelJadwalDokterWeb.php',
    data        : {GetIdDokter: GetIdDokter},
    success     : function(data){
        $('#TabelJadwalDokterWeb').html(data);
    }
});
$('#nama_hari').change(function(){
    var nama_hari=$('#nama_hari').val();
    $('#TabelJadwalDokterWeb').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebDokter/TabelJadwalDokterWeb.php',
        data        : {GetIdDokter: GetIdDokter, nama_hari: nama_hari},
        success     : function(data){
            $('#TabelJadwalDokterWeb').html(data);
        }
    });
});
//Modal List Jadwal Dokter SIMRS
$('#ModalListJadwalSimrs').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_dokter = $(e.relatedTarget).data('id');
    $('#ListJadwalDokterSimrs').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebDokter/ListJadwalDokterSimrs.php',
        data 	    :  {id_dokter: id_dokter},
        success     : function(data){
            $('#ListJadwalDokterSimrs').html(data);
            $(function(){
                $("#CheckAll").click(function(){
                    if ( (this).checked == true ){
                        $('.checkbox').prop('checked', true);
                    } else {
                        $('.checkbox').prop('checked', false);
                    }
             
                });
            });
            //Proses Set Jadwal SIMRS
            $('#ProsesSetJadwalSimrs').submit(function(){
                $('#NotifikasiSinkronisasiJadwal').html('<span class="text-primary">Loading...</span>');
                var form = $('#ProsesSetJadwalSimrs')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebDokter/ProsesSetJadwalSimrs.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiSinkronisasiJadwal').html(data);
                        var NotifikasiSinkronisasiJadwalBerhasil=$('#NotifikasiSinkronisasiJadwalBerhasil').html();
                        if(NotifikasiSinkronisasiJadwalBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Tambah Jadwal Manual
$('#ModalTambahJadwalManual').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_dokter = $(e.relatedTarget).data('id');
    $('#FormTambahJadwalManual').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebDokter/FormTambahJadwalManual.php',
        data 	    :  {id_dokter: id_dokter},
        success     : function(data){
            $('#FormTambahJadwalManual').html(data);
            //Proses Tambah Jadwal Manual
            $('#ProsesTmabahJadwalmanual').submit(function(){
                $('#NotifikasiTambahJadwalManual').html('<span class="text-primary">Loading...</span>');
                var form = $('#ProsesTmabahJadwalmanual')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebDokter/ProsesTmabahJadwalmanual.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahJadwalManual').html(data);
                        var NotifikasiTambahJadwalManualBerhasil=$('#NotifikasiTambahJadwalManualBerhasil').html();
                        if(NotifikasiTambahJadwalManualBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Hapus Jadwal
$('#ModalHapusJadwal').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_jadwal = $(e.relatedTarget).data('id');
    $('#FormHapusJadwal').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebDokter/FormHapusJadwal.php',
        data 	    :  {id_jadwal: id_jadwal},
        success     : function(data){
            $('#FormHapusJadwal').html(data);
            //Konfirmasi Hapus Jadwal
            $('#KonfirmasiHapusJadwal').click(function(){
                $('#NotifikasiHapusJadwal').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebDokter/ProsesHapusJadwal.php',
                    data 	    :  { id_jadwal: id_jadwal },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusJadwal').html(data);
                        var NotifikasiHapusJadwalBerhasil=$('#NotifikasiHapusJadwalBerhasil').html();
                        if(NotifikasiHapusJadwalBerhasil=="Success"){
                            //Apabila berhasil tutup modal
                            $('#ModalHapusJadwal').modal('hide');
                            //Reset Tabel
                            $('#TabelJadwalDokterWeb').html('Loading...');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/WebDokter/TabelJadwalDokterWeb.php',
                                data        : {GetIdDokter: GetIdDokter},
                                success     : function(data){
                                    $('#TabelJadwalDokterWeb').html(data);
                                    //Tampilkan Swal
                                    Swal.fire({
                                        title: 'Mantap!',
                                        text: 'Hapus Jadwal Berhasil',
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
//Modal Edit Jadwal
$('#ModalEditJadwal').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    var id_jadwal = $(e.relatedTarget).data('id');
    $('#FormEditJadwalDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebDokter/FormEditJadwalDokter.php',
        data 	    :  {id_jadwal: id_jadwal},
        success     : function(data){
            $('#FormEditJadwalDokter').html(data);
            //Proses Edit Jadwal Dokter
            $('#ProsesEditJadwalDokter').submit(function(){
                $('#NotifikasiEditJadwalDokter').html('<span class="text-primary">Loading...</span>');
                var form = $('#ProsesEditJadwalDokter')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/WebDokter/ProsesEditJadwalDokter.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditJadwalDokter').html(data);
                        var NotifikasiEditJadwalDokterBerhasil=$('#NotifikasiEditJadwalDokterBerhasil').html();
                        if(NotifikasiEditJadwalDokterBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
