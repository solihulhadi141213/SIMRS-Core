//Menampilkan Data Kelas Dan Ruangan Pertama Kali
$('#MenampilkanTabelKelasRuangan').html('<div class="row"><div class="col col-md-12 text-center text-danger">Loading..</div></div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/KelasRuangan/TabelKelas.php',
    success     : function(data){
        $('#MenampilkanTabelKelasRuangan').html(data);
    }
});
var ShowDataAplicare=$('#ShowDataAplicare').val();
if(ShowDataAplicare=="true"){
    $('#MenampilkanDataAplicare').html("Loading...");
    $('#MenampilkanDataAplicare').load("_Page/KelasRuangan/TabelAplicare.php");
}

//Click Tombol Kelas
$('#ClickKelas').click(function(){
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelKelasRuangan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/TabelKelas.php',
        success     : function(data){
            $('#MenampilkanTabelKelasRuangan').html(data);
            //Pengaturan Tombol
            $('#ClickKelas').addClass('btn-primary');
            $('#ClickKelas').removeClass('btn-info');
            $('#ClickRuangan').addClass('btn-info');
            $('#ClickRuangan').removeClass('btn-primary');
            $('#ClickTidur').addClass('btn-info');
            $('#ClickTidur').removeClass('btn-primary');
            $('#ClickAllTableRuangan').addClass('btn-info');
            $('#ClickAllTableRuangan').removeClass('btn-primary');
            //Ketika melakukan pencarian
            
        }
    });
});
//Click Tombol Ruangan
$('#ClickRuangan').click(function(){
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelKelasRuangan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/TabelRuangan.php',
        success     : function(data){
            $('#MenampilkanTabelKelasRuangan').html(data);
            //Pengaturan Tombol
            $('#ClickKelas').addClass('btn-info');
            $('#ClickKelas').removeClass('btn-primary');
            $('#ClickRuangan').addClass('btn-primary');
            $('#ClickRuangan').removeClass('btn-info');
            $('#ClickTidur').addClass('btn-info');
            $('#ClickTidur').removeClass('btn-primary');
            $('#ClickAllTableRuangan').addClass('btn-info');
            $('#ClickAllTableRuangan').removeClass('btn-primary');
        }
    });
});
//Click Tombol Tidur
$('#ClickTidur').click(function(){
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelKelasRuangan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/TabelTidur.php',
        success     : function(data){
            $('#MenampilkanTabelKelasRuangan').html(data);
            $('#ClickKelas').addClass('btn-info');
            $('#ClickKelas').removeClass('btn-primary');
            $('#ClickRuangan').addClass('btn-info');
            $('#ClickRuangan').removeClass('btn-primary');
            $('#ClickTidur').addClass('btn-primary');
            $('#ClickTidur').removeClass('btn-info');
            $('#ClickAllTableRuangan').addClass('btn-info');
            $('#ClickAllTableRuangan').removeClass('btn-primary');
        }
    });
});

//Click Tombol ClickAllTableRuangan
$('#ClickAllTableRuangan').click(function(){
    $('#MenampilkanTabelKelasRuangan').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/TabelAll.php',
        success     : function(data){
            $('#MenampilkanTabelKelasRuangan').html(data);
            $('#ClickKelas').addClass('btn-info');
            $('#ClickKelas').removeClass('btn-primary');
            $('#ClickRuangan').addClass('btn-info');
            $('#ClickRuangan').removeClass('btn-primary');
            $('#ClickTidur').addClass('btn-info');
            $('#ClickTidur').removeClass('btn-primary');
            $('#ClickAllTableRuangan').addClass('btn-primary');
            $('#ClickAllTableRuangan').removeClass('btn-info');
        }
    });
});

//Modal Tambah Kelas
$('#ModalTambahKelas').on('show.bs.modal', function (e) {
    $('#FormTambahKelas').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormTambahKelas.php',
        success     : function(data){
            $('#FormTambahKelas').html(data);
            $('#ProsesTambahKelas').submit(function(){
                e.preventDefault();
                $('#NotifikasiTambahKelas').html('Loading..');
                var form = $('#ProsesTambahKelas')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/ProsesTambahKelas.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahKelas').html(data);
                        var NotifikasiTambahKelasBerhasil=$('#NotifikasiTambahKelasBerhasil').html();
                        if(NotifikasiTambahKelasBerhasil=="Berhasil"){
                            $('#MenampilkanTabelKelasRuangan').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/KelasRuangan/TabelKelas.php',
                                success     : function(data){
                                    $('#MenampilkanTabelKelasRuangan').html(data);
                                    //Pengaturan Tombol
                                    $('#ClickKelas').addClass('btn-primary');
                                    $('#ClickKelas').removeClass('btn-info');
                                    $('#ClickRuangan').addClass('btn-info');
                                    $('#ClickRuangan').removeClass('btn-primary');
                                    $('#ClickTidur').addClass('btn-info');
                                    $('#ClickTidur').removeClass('btn-primary');
                                    //Ketika melakukan pencarian
                                    $('#ModalTambahKelas').modal("hide");
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Tambah Kelas Baru Berhasil',
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
$('#ModalTambahRuangan').on('show.bs.modal', function (e) {
    var PilihKelas =$('#PilihKelas').val();
    $('#FormTambahRuangan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormTambahRuangan.php',
        data 	    :  {PilihKelas: PilihKelas},
        success     : function(data){
            $('#FormTambahRuangan').html(data);
            $('#ProsesTambahRuangan').submit(function(){
                e.preventDefault();
                $('#NotifikasiTambahRuangan').html('Loading..');
                var form = $('#ProsesTambahRuangan')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/ProsesTambahRuangan.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahRuangan').html(data);
                        var NotifikasiTambahRuanganBerhasil=$('#NotifikasiTambahRuanganBerhasil').html();
                        if(NotifikasiTambahRuanganBerhasil=="Berhasil"){
                            $('#MenampilkanDataRuangan').html("Loading..");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/KelasRuangan/DataRuangan.php',
                                data 	    :  {PilihKelas: PilihKelas},
                                success     : function(data){
                                    $('#MenampilkanDataRuangan').html(data);
                                    $('#ModalTambahRuangan').modal("hide");
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Tambah Ruangan Baru Berhasil',
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
$('#ModalTambahBed').on('show.bs.modal', function (e) {
    var PilihKelas =$('#PilihKelas').val();
    var PilihRuangan =$('#PilihRuangan').val();
    $('#FormTambahBed').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormTambahBed.php',
        data 	    :  {PilihKelas: PilihKelas, PilihRuangan: PilihRuangan},
        success     : function(data){
            $('#FormTambahBed').html(data);
            $('#ProsesTambahBed').submit(function(){
                e.preventDefault();
                $('#NotifikasiTambahBed').html('Loading..');
                var form = $('#ProsesTambahBed')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/ProsesTambahBed.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahBed').html(data);
                        var NotifikasiTambahBedBerhasil=$('#NotifikasiTambahBedBerhasil').html();
                        if(NotifikasiTambahBedBerhasil=="Berhasil"){
                            $('#MenampilkanDataBed').html("Loading..");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/KelasRuangan/DataBed.php',
                                data 	    :  {PilihKelas: PilihKelas, PilihRuangan: PilihRuangan},
                                success     : function(data){
                                    $('#MenampilkanDataBed').html(data);
                                    $('#ModalTambahBed').modal("hide");
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Tambah Tempat Tidur Baru Berhasil',
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
//Modal Edit Kelas, ruangan dan bed
$('#ModalEditKelas').on('show.bs.modal', function (e) {
    var id_ruang_rawat = $(e.relatedTarget).data('id');
    $('#FormEditKelas').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormEditKelas.php',
        data        : {id_ruang_rawat: id_ruang_rawat},
        success     : function(data){
            $('#FormEditKelas').html(data);
            $('#ProsesEditKelas').submit(function(){
                e.preventDefault();
                $('#NotifikasiEditKelas').html('Loading..');
                var form = $('#ProsesEditKelas')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/ProsesEditKelas.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditKelas').html(data);
                        var NotifikasiEditKelasBerhasil=$('#NotifikasiEditKelasBerhasil').html();
                        if(NotifikasiEditKelasBerhasil=="Berhasil"){
                            $('#MenampilkanTabelKelasRuangan').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/KelasRuangan/TabelKelas.php',
                                success     : function(data){
                                    $('#MenampilkanTabelKelasRuangan').html(data);
                                    //Pengaturan Tombol
                                    $('#ClickKelas').addClass('btn-primary');
                                    $('#ClickKelas').removeClass('btn-info');
                                    $('#ClickRuangan').addClass('btn-info');
                                    $('#ClickRuangan').removeClass('btn-primary');
                                    $('#ClickTidur').addClass('btn-info');
                                    $('#ClickTidur').removeClass('btn-primary');
                                    //Ketika melakukan pencarian
                                    $('#ModalEditKelas').modal("hide");
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Edit Kelas Berhasil',
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
$('#ModalEditRuangan').on('show.bs.modal', function (e) {
    var id_ruang_rawat = $(e.relatedTarget).data('id');
    var PilihKelas =$('#PilihKelas').val();
    $('#FormEditRuangan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormEditRuangan.php',
        data        : {id_ruang_rawat: id_ruang_rawat, PilihKelas: PilihKelas},
        success     : function(data){
            $('#FormEditRuangan').html(data);
            $('#ProsesEditRuangan').submit(function(){
                e.preventDefault();
                $('#NotifikasiEditRuangan').html('Loading..');
                var form = $('#ProsesEditRuangan')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/ProsesEditRuangan.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditRuangan').html(data);
                        var NotifikasiEditRuanganBerhasil=$('#NotifikasiEditRuanganBerhasil').html();
                        if(NotifikasiEditRuanganBerhasil=="Berhasil"){
                            $('#MenampilkanDataRuangan').html("Loading..");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/KelasRuangan/DataRuangan.php',
                                data 	    :  {PilihKelas: PilihKelas},
                                success     : function(data){
                                    $('#MenampilkanDataRuangan').html(data);
                                    $('#ModalEditRuangan').modal("hide");
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Edit Ruangan Berhasil',
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
$('#ModalEditBed').on('show.bs.modal', function (e) {
    var id_ruang_rawat = $(e.relatedTarget).data('id');
    var PilihKelas =$('#PilihKelas').val();
    var PilihRuangan =$('#PilihRuangan').val();
    $('#FormEditBed').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormEditBed.php',
        data        : {id_ruang_rawat: id_ruang_rawat, PilihKelas: PilihKelas, PilihRuangan: PilihRuangan},
        success     : function(data){
            $('#FormEditBed').html(data);
            $('#ProsesEditBed').submit(function(){
                e.preventDefault();
                $('#NotifikasiEditBed').html('Loading..');
                var form = $('#ProsesEditBed')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/ProsesEditBed.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditBed').html(data);
                        var NotifikasiEditBedBerhasil=$('#NotifikasiEditBedBerhasil').html();
                        if(NotifikasiEditBedBerhasil=="Berhasil"){
                            $('#MenampilkanDataBed').html("Loading..");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/KelasRuangan/DataBed.php',
                                data 	    :  {PilihKelas: PilihKelas, PilihRuangan: PilihRuangan},
                                success     : function(data){
                                    $('#MenampilkanDataBed').html(data);
                                    $('#ModalEditBed').modal("hide");
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Edit Tempat Tidur Baru Berhasil',
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
//Modal Hapus Kelas
$('#ModalHapusKelas').on('show.bs.modal', function (e) {
    var id_ruang_rawat = $(e.relatedTarget).data('id');
    $('#FormHapusKelas').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormHapusKelas.php',
        data        : {id_ruang_rawat: id_ruang_rawat},
        success     : function(data){
            $('#FormHapusKelas').html(data);
            $('#ProsesHapusKelas').submit(function(){
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/ProsesHapusKelas.php',
                    data        : {id_ruang_rawat: id_ruang_rawat},
                    success     : function(data){
                        $('#NotifikasiHapusKelas').html(data);
                        var NotifikasiHapusKelasBerhasil=$('#NotifikasiHapusKelasBerhasil').html();
                        if(NotifikasiHapusKelasBerhasil=="Berhasil"){
                            $('#MenampilkanTabelKelasRuangan').html("Loading...");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/KelasRuangan/TabelKelas.php',
                                success     : function(data){
                                    $('#MenampilkanTabelKelasRuangan').html(data);
                                    //Pengaturan Tombol
                                    $('#ClickKelas').addClass('btn-primary');
                                    $('#ClickKelas').removeClass('btn-info');
                                    $('#ClickRuangan').addClass('btn-info');
                                    $('#ClickRuangan').removeClass('btn-primary');
                                    $('#ClickTidur').addClass('btn-info');
                                    $('#ClickTidur').removeClass('btn-primary');
                                    //Ketika melakukan pencarian
                                    $('#ModalHapusKelas').modal("hide");
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Hapus Kelas Berhasil',
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
$('#ModalHapusRuangan').on('show.bs.modal', function (e) {
    var id_ruang_rawat = $(e.relatedTarget).data('id');
    var PilihKelas =$('#PilihKelas').val();
    $('#FormHapusRuangan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormHapusRuangan.php',
        data        : {id_ruang_rawat: id_ruang_rawat},
        success     : function(data){
            $('#FormHapusRuangan').html(data);
            $('#ProsesHapusRuangan').submit(function(){
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/ProsesHapusRuangan.php',
                    data        : {id_ruang_rawat: id_ruang_rawat},
                    success     : function(data){
                        $('#NotifikasiHapusRuangan').html(data);
                        var NotifikasiHapusRuanganBerhasil=$('#NotifikasiHapusRuanganBerhasil').html();
                        if(NotifikasiHapusRuanganBerhasil=="Berhasil"){
                            $('#MenampilkanDataRuangan').html("Loading..");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/KelasRuangan/DataRuangan.php',
                                data 	    :  {PilihKelas: PilihKelas},
                                success     : function(data){
                                    $('#MenampilkanDataRuangan').html(data);
                                    $('#ModalHapusRuangan').modal("hide");
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Hapus Ruangan Berhasil',
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
$('#ModalHapusBed').on('show.bs.modal', function (e) {
    var id_ruang_rawat = $(e.relatedTarget).data('id');
    var PilihKelas =$('#PilihKelas').val();
    var PilihRuangan =$('#PilihRuangan').val();
    $('#FormHapusBed').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormHapusBed.php',
        data        : {id_ruang_rawat: id_ruang_rawat},
        success     : function(data){
            $('#FormHapusBed').html(data);
            $('#ProsesHapusBed').submit(function(){
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/ProsesHapusBed.php',
                    data        : {id_ruang_rawat: id_ruang_rawat},
                    success     : function(data){
                        $('#NotifikasiHapusBed').html(data);
                        var NotifikasiHapusBedBerhasil=$('#NotifikasiHapusBedBerhasil').html();
                        if(NotifikasiHapusBedBerhasil=="Berhasil"){
                            $('#MenampilkanDataBed').html("Loading..");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/KelasRuangan/DataBed.php',
                                data 	    :  {PilihKelas: PilihKelas, PilihRuangan: PilihRuangan},
                                success     : function(data){
                                    $('#MenampilkanDataBed').html(data);
                                    $('#ModalHapusBed').modal("hide");
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Edit Tempat Tidur Baru Berhasil',
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

//Tampilkan Ruangan?
$('#ModalTampilkanRuangan').on('show.bs.modal', function (e) {
    var kelas = $(e.relatedTarget).data('id');
    $('#FormTampilkanRuangan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormTampilkanRuangan.php',
        data        : {kelas: kelas},
        success     : function(data){
            $('#FormTampilkanRuangan').html(data);
            $('#ProsesTampilkanRuangan').submit(function(){
                $('#MenampilkanTabelKelasRuangan').html("Loading..");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/TabelRuangan.php',
                    data 	    :  {PilihKelas: kelas},
                    success     : function(data){
                        $('#MenampilkanTabelKelasRuangan').html(data);
                        //Pengaturan Tombol
                        $('#ClickKelas').addClass('btn-info');
                        $('#ClickKelas').removeClass('btn-primary');
                        $('#ClickRuangan').addClass('btn-primary');
                        $('#ClickRuangan').removeClass('btn-info');
                        $('#ClickTidur').addClass('btn-info');
                        $('#ClickTidur').removeClass('btn-primary');
                        $('#MenampilkanDataRuangan').html("Loading..");
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/KelasRuangan/DataRuangan.php',
                            data 	    :  {PilihKelas: kelas},
                            success     : function(data){
                                $('#MenampilkanDataRuangan').html(data);
                                $('#ModalTampilkanRuangan').modal("hide");
                            }
                        });
                    }
                });
            });
        }
    });
});
//Tampilkan Bed?
$('#ModalTampilkanBed').on('show.bs.modal', function (e) {
    var ruangan = $(e.relatedTarget).data('id');
    var kelas = $('#PilihKelas').val();
    $('#FormTampilkanBed').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormTampilkanBed.php',
        data        : {kelas: kelas},
        success     : function(data){
            $('#FormTampilkanBed').html(data);
            $('#ProsesTampilkanBed').submit(function(){
                $('#MenampilkanTabelKelasRuangan').html("Loading..");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/TabelTidur.php',
                    data 	    :  {ruangan: ruangan, kelas: kelas},
                    success     : function(data){
                        $('#MenampilkanTabelKelasRuangan').html(data);
                        //Pengaturan Tombol
                        $('#MenampilkanTabelKelasRuangan').html(data);
                        $('#ClickKelas').addClass('btn-info');
                        $('#ClickKelas').removeClass('btn-primary');
                        $('#ClickRuangan').addClass('btn-info');
                        $('#ClickRuangan').removeClass('btn-primary');
                        $('#ClickTidur').addClass('btn-primary');
                        $('#ClickTidur').removeClass('btn-info');
                        
                        $('#MenampilkanDataBed').html("Loading..");
                        $.ajax({
                            type 	    : 'POST',
                            url 	    : '_Page/KelasRuangan/DataBed.php',
                            data 	    :  {PilihRuangan: ruangan, PilihKelas: kelas},
                            success     : function(data){
                                $('#MenampilkanDataBed').html(data);
                                $('#ModalTampilkanBed').modal("hide");
                            }
                        });
                    }
                });
            });
        }
    });
});
//Tampilkan Bed?
$('#KonfirmasiHapusSemuaAplicare').click(function(){
    $('#FormHapusAplicare').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/ProsesHapusSemuaAplicare.php',
        success     : function(data){
            $('#FormHapusAplicare').html(data);
        }
    });
});
//Tampilkan Bed?
$('#ModalTambahAaplicare').on('show.bs.modal', function (e) {
    $('#FormTambahRuanganAplicare').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormTambahRuanganAplicare.php',
        success     : function(data){
            $('#FormTambahRuanganAplicare').html(data);
            //Proses SImpan
            $('#ProsesSimpanAplicare').submit(function(){
                var ProsesSimpanAplicare = $('#ProsesSimpanAplicare').serialize();
                $('#NotifikasiSimpanDataApliccare').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/ProsesSimpanAplicare.php',
                    data 	    :  ProsesSimpanAplicare,
                    success     : function(data){
                        $('#NotifikasiSimpanDataApliccare').html(data);
                    }
                });
            });
        }
    });
});
//Tampilkan Bed?
$('#ModalDeleteRuanganBpjs').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var kodekelas = pecah[0];
    var koderuang = pecah[1];
    $('#FormDeleteRuanganAplicare').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormDeleteRuanganAplicare.php',
        success     : function(data){
            $('#FormDeleteRuanganAplicare').html(data);
            //Proses SImpan
            $('#ProsesHapusRuanganAplicare').submit(function(){
                var ProsesHapusRuanganAplicare = $('#ProsesHapusRuanganAplicare').serialize();
                $('#NotifikasiHapusRuanganAplicare').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/ProsesHapusRuanganAplicare.php',
                    data 	    :  {kodekelas: kodekelas, koderuang: koderuang},
                    success     : function(data){
                        $('#NotifikasiHapusRuanganAplicare').html(data);
                        var NotifikasiHapusRuanganAplicareBerhasil=$('#NotifikasiHapusRuanganAplicareBerhasil').val();
                        if(NotifikasiHapusRuanganAplicareBerhasil=="Berhasil"){
                            $('#MenampilkanDataAplicare').html("Loading..");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/KelasRuangan/TabelAplicare.php',
                                success     : function(data){
                                    $('#MenampilkanDataAplicare').html(data);
                                    $('#ModalDeleteRuanganBpjs').modal("hide");
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Hapus Ruangan Aplicare Berhasil',
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
//Auto update page
// $('#AutoUpdateDataRuanganRS').html('Loading..');
// $.ajax({
//     type 	    : 'POST',
//     url 	    : '_Page/KelasRuangan/AutoUpdateDataRuanganRS.php',
//     success     : function(data){
//         $('#AutoUpdateDataRuanganRS').html(data);
//     }
// });
// $('#AutoUpdateDataRuanganBpjs').html('Loading..');
// $.ajax({
//     type 	    : 'POST',
//     url 	    : '_Page/KelasRuangan/AutoUpdateDataRuanganBpjs.php',
//     success     : function(data){
//         $('#AutoUpdateDataRuanganBpjs').html(data);
//     }
// });
//Menjalankan auto update
$('#TombolPlay').click(function(){
    var play_stop = $('#play_stop').val();
    if(play_stop=="play"){
        var timeupdate = $('#timeupdate').val();
        if(timeupdate==""){
            $('#KeteranganAutoUpdate').html('Time tidak boleh kosong');
        }
        if(timeupdate!==""){
            $('#play_stop').val('stop');
            $('#timeupdate').val(timeupdate);
            $('#ButtonClassUpdate').html('<a href="" class="btn btn-sm btn-outline-danger" id="TombolPlay"><i class="ti-control-stop"></i> Stop</a>');
            $('#KeteranganAutoUpdate').html('Running..');
            setInterval(function() { 
                $('#AutoUpdateDataRuanganRS').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/AutoUpdateDataRuanganRS.php',
                    data 	    :  {play_stop: play_stop},
                    success     : function(data){
                        $('#AutoUpdateDataRuanganRS').html(data);
                    }
                });
            }, timeupdate);
        }
    }
});
//Modal Edit Kelas, ruangan dan bed
$('#ModalDetailRuanganBpjs').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var namaruang = pecah[0];
    var namakelas = pecah[1];
    var kapasitas = pecah[2];
    var tersediapria = pecah[3];
    var tersediawanita = pecah[4];
    var tersediapriawanita = pecah[5];
    var lastupdate = pecah[6];
    var kodekelas = pecah[7];
    $('#FormDetailRuanganBpjs').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/FormDetailRuanganBpjs.php',
        data        : {namaruang: namaruang, namakelas: namakelas, kapasitas: kapasitas, tersediapria: tersediapria, tersediawanita: tersediawanita, tersediapriawanita: tersediapriawanita, lastupdate: lastupdate, kodekelas: kodekelas},
        success     : function(data){
            $('#FormDetailRuanganBpjs').html(data);
        }
    });
});
//Proses SImpan
$('#ProsesUpdateRuanganBpjs').submit(function(){
    var ProsesUpdateRuanganBpjs = $('#ProsesUpdateRuanganBpjs').serialize();
    $('#NotifikasiUpdateRuanganBpjs').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/ProsesUpdateRuanganBpjs.php',
        data 	    :  ProsesUpdateRuanganBpjs,
        success     : function(data){
            $('#NotifikasiUpdateRuanganBpjs').html(data);
            var NotifikasiUpdateRuanganBpjsBerhasil=$('#NotifikasiUpdateRuanganBpjsBerhasil').val();
            if(NotifikasiUpdateRuanganBpjsBerhasil=="Berhasil"){
                $('#MenampilkanDataAplicare').html("Loading..");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/KelasRuangan/TabelAplicare.php',
                    success     : function(data){
                        $('#MenampilkanDataAplicare').html(data);
                        $('#ModalDetailRuanganBpjs').modal("hide");
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Update Ruangan Aplicare Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modall Pasien By Kelas
$('#ModalPasienByKelas').on('show.bs.modal', function (e) {
    var kelas = $(e.relatedTarget).data('id');
    $('#FormPasienByKelas').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/TabelPasienByKelas.php',
        data        : {kelas: kelas},
        success     : function(data){
            $('#FormPasienByKelas').html(data);
        }
    });
});
//Modall Pasien By Ruangan
$('#ModalPasienByRuangan').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var kelas = pecah[0];
    var ruangan = pecah[1];
    $('#FormPasienByRuangan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/TabelPasienByRuangan.php',
        data        : {ruangan: ruangan, kelas: kelas},
        success     : function(data){
            $('#FormPasienByRuangan').html(data);
        }
    });
});
//Modall Pasien By Bed
$('#ModalPasienByBed').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var kelas = pecah[0];
    var ruangan = pecah[1];
    var id_ruang_rawat = pecah[2];
    $('#FormPasienByBed').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/KelasRuangan/TabelPasienByBed.php',
        data        : {ruangan: ruangan, kelas: kelas, id_ruang_rawat: id_ruang_rawat},
        success     : function(data){
            $('#FormPasienByBed').html(data);
        }
    });
});