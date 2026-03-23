//REFERENSI FITUR AKSES
//Menampilkan Tabel Referensi Pertama Kali
var BatasPencarianReferensi = $('#BatasPencarianReferensi').serialize();
var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
$('#MenampilkanTabelReferensiAkses').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Akses/TabelReferensiAkses.php',
    data 	    :  BatasPencarianReferensi,
    success     : function(data){
        $('#MenampilkanTabelReferensiAkses').html(data);
    }
});
//Batas dan Pencarian
$('#batas_referensi').change(function(){
    var BatasPencarianReferensi = $('#BatasPencarianReferensi').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelReferensiAkses').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/TabelReferensiAkses.php',
        data 	    :  BatasPencarianReferensi,
        success     : function(data){
            $('#MenampilkanTabelReferensiAkses').html(data);
        }
    });
});
//Mulai Pencarian Referensi
$('#BatasPencarianReferensi').submit(function(){
    var BatasPencarianReferensi = $('#BatasPencarianReferensi').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelReferensiAkses').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/TabelReferensiAkses.php',
        data 	    :  BatasPencarianReferensi,
        success     : function(data){
            $('#MenampilkanTabelReferensiAkses').html(data);
        }
    });
});
//Ketika keyword by diubah
$('#keyword_by_referensi').change(function(){
    var keyword_by_referensi = $('#keyword_by_referensi').val();
    $('#FormKeywordReferensi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormKeywordReferensi.php',
        data 	    :  {keyword_by_referensi: keyword_by_referensi},
        success     : function(data){
            $('#FormKeywordReferensi').html(data);
        }
    });
});
$('#GenerateKodeFitur').click(function(){
    $('#kode').val('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/ProsesGenerateKodeFitur.php',
        success     : function(data){
            $('#kode').val(data);
        }
    });
});
//Modal Tambah Referensi Muncul
$('#ModalTambahReferensi').on('show.bs.modal', function (e) {
    $('#NotifikasiTambahReferensi').html('Loading...');
    $('#NotifikasiTambahReferensi').html('<span class="text-primary">Pastikan Referensi Fitur Yang Anda Input Sudah Sesuai</span>');
});
//Tambah Referensi Fitur
$('#ProsesTambahReferensi').submit(function(){
    var ProsesTambahReferensi = $('#ProsesTambahReferensi').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiTambahReferensi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/ProsesTambahReferensi.php',
        data 	    :  ProsesTambahReferensi,
        success     : function(data){
            $('#NotifikasiTambahReferensi').html(data);
            var NotifikasiTambahReferensiBerhasil = $('#NotifikasiTambahReferensiBerhasil').html();
            if(NotifikasiTambahReferensiBerhasil=="Success"){
                //Kembalikan ke halaman 1
                $('#PutPageReferensi').val('1');
                var BatasPencarianReferensi = $('#BatasPencarianReferensi').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#MenampilkanTabelReferensiAkses').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/TabelReferensiAkses.php',
                    data 	    :  BatasPencarianReferensi,
                    success     : function(data){
                        $('#MenampilkanTabelReferensiAkses').html(data);
                        //Reset Form
                        $("#ProsesTambahReferensi")[0].reset();
                        //Menutup Modal
                        $('#ModalTambahReferensi').modal('hide');
                        //Menampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Referensi Akses Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Detail Referensi Fitur Akses
$('#ModalDetailReferensiFitur').on('show.bs.modal', function (e) {
    var id_akses_ref = $(e.relatedTarget).data('id');
    $('#FormDetailReferensiFitur').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormDetailReferensiFitur.php',
        data 	    :  {id_akses_ref: id_akses_ref},
        success     : function(data){
            $('#FormDetailReferensiFitur').html(data);
        }
    });
});
//Modal Edit Referensi Akses
$('#ModalEditReferensiFitur').on('show.bs.modal', function (e) {
    var id_akses_ref = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12">Loading..</div></div>';
    $('#FormEditReferensiAkses').html(Loading);
    $('#NotifikasiEditReferensiAkses').html('<span class="text-primary">Pastikan Referensi Fitur Yang Anda Input Sudah Sesuai</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormEditReferensiAkses.php',
        data 	    :  {id_akses_ref: id_akses_ref},
        success     : function(data){
            $('#FormEditReferensiAkses').html(data);
            //Generate Kode Fitur
            $('#GenerateKodeFitur2').click(function(){
                $('#kode2').val('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/ProsesGenerateKodeFitur.php',
                    success     : function(data){
                        $('#kode2').val(data);
                    }
                });
            });
        }
    });
});
//Proses Simpan Edit Referensi
$('#ProsesEditReferensiAkses').submit(function(){
    var ProsesEditReferensiAkses = $('#ProsesEditReferensiAkses').serialize();
    $('#NotifikasiEditReferensiAkses').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/ProsesEditReferensiAkses.php',
        data 	    :  ProsesEditReferensiAkses,
        success     : function(data){
            $('#NotifikasiEditReferensiAkses').html(data);
            var NotifikasiEditReferensiAksesBerhasil=$('#NotifikasiEditReferensiAksesBerhasil').html();
            if(NotifikasiEditReferensiAksesBerhasil=="Success"){
                var BatasPencarianReferensi = $('#BatasPencarianReferensi').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#MenampilkanTabelReferensiAkses').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/TabelReferensiAkses.php',
                    data 	    :  BatasPencarianReferensi,
                    success     : function(data){
                        $('#MenampilkanTabelReferensiAkses').html(data);
                        //Sembunyikan Modal Edit
                        $('#ModalEditReferensiFitur').modal('hide');
                        //Sembunyikan Modal Detail
                        $('#ModalDetailReferensiFitur').modal('hide');
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Edit Referensi Akses Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Hapus Referensi
$('#ModalHapusReferensiAkses').on('show.bs.modal', function (e) {
    var id_akses_ref = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormHapusReferensi').html(Loading);
    $('#NotifikasiHapusReferensi').html('<small class="text-danger">Anda Yakin Ingin Menghapus Data Ini?</small>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormHapusReferensi.php',
        data 	    :  {id_akses_ref: id_akses_ref},
        success     : function(data){
            $('#FormHapusReferensi').html(data);
        }
    });
});
$('#ProsesHapusReferensiAkses').submit(function(){
    var ProsesHapusReferensiAkses = $('#ProsesHapusReferensiAkses').serialize();
    $('#NotifikasiHapusReferensi').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/ProsesHapusReferensiAkses.php',
        data 	    :  ProsesHapusReferensiAkses,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiHapusReferensi').html(data);
            var NotifikasiHapusReferensiBerhasil=$('#NotifikasiHapusReferensiBerhasil').html();
            if(NotifikasiHapusReferensiBerhasil=="Success"){
                var BatasPencarianReferensi = $('#BatasPencarianReferensi').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#MenampilkanTabelReferensiAkses').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/TabelReferensiAkses.php',
                    data 	    :  BatasPencarianReferensi,
                    success     : function(data){
                        $('#MenampilkanTabelReferensiAkses').html(data);
                        //Sembunyikan Modal Hapus Referensi Akses
                        $('#ModalHapusReferensiAkses').modal('hide');
                        //Sembunyikan Modal Detail
                        $('#ModalDetailReferensiFitur').modal('hide');
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Hapus Referensi Akses Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//ENTITAS AKSES
$('#MenampilkanTabelEntitas').load("_Page/Akses/TabelEntitas.php");
//Batas dan Pencarian
$('#batas_entitas').change(function(){
    var BatasPencarianEntitas = $('#BatasPencarianEntitas').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelEntitas').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/TabelEntitas.php',
        data 	    :  BatasPencarianEntitas,
        success     : function(data){
            $('#MenampilkanTabelEntitas').html(data);
        }
    });
});
//Mulai Pencarian Referensi
$('#BatasPencarianEntitas').submit(function(){
    var BatasPencarianEntitas = $('#BatasPencarianEntitas').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelEntitas').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/TabelEntitas.php',
        data 	    :  BatasPencarianEntitas,
        success     : function(data){
            $('#MenampilkanTabelEntitas').html(data);
        }
    });
});
//Tambah Tambah Entitas
$('#ProsesTambahEntitas').submit(function(){
    var ProsesTambahEntitas = $('#ProsesTambahEntitas').serialize();
    $('#NotifikasiTambahEntitas').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/ProsesTambahEntitas.php',
        data 	    :  ProsesTambahEntitas,
        success     : function(data){
            $('#NotifikasiTambahEntitas').html(data);
            var NotifikasiTambahEntitasBerhasil = $('#NotifikasiTambahEntitasBerhasil').html();
            if(NotifikasiTambahEntitasBerhasil=="Success"){
                window.location.href='index.php?Page=Akses&Sub=EntitasAkses';
            }
        }
    });
});
//Modal Detail Entitas
$('#ModalDetailEntitas').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_akses_entitas = pecah[0];
    var keyword_by = pecah[1];
    var keyword = pecah[2];
    var batas = pecah[3];
    var ShortBy = pecah[4];
    var OrderBy = pecah[5];
    var page = pecah[6];
    var posisi = pecah[7];
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDetailEntitas').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormDetailEntitas.php',
        data 	    :  {id_akses_entitas: id_akses_entitas},
        success     : function(data){
            $('#FormDetailEntitas').html(data);
            //Modal Hapus Entitas
            $('#ModalHapusEntitas').on('show.bs.modal', function (e) {
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormHapusEntitas').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/FormHapusEntitas.php',
                    data 	    :  {id_akses_entitas: id_akses_entitas},
                    success     : function(data){
                        $('#FormHapusEntitas').html(data);
                        $('#KonfirmasiHapusEntitas').click(function(){
                            $('#NotifikasiHapusEntitas').html('Loading..');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Akses/ProsesHapusEntitas.php',
                                data 	    :  { id_akses_entitas: id_akses_entitas },
                                enctype     : 'multipart/form-data',
                                success     : function(data){
                                    $('#NotifikasiHapusEntitas').html(data);
                                    var NotifikasiHapusEntitasBerhasil=$('#NotifikasiHapusEntitasBerhasil').html();
                                    if(NotifikasiHapusEntitasBerhasil=="Success"){
                                        $.ajax({
                                            type 	    : 'POST',
                                            url 	    : '_Page/Akses/TabelEntitas.php',
                                            data 	    :  {keyword_entitas: keyword, batas_entitas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by_entitas: keyword_by},
                                            success     : function(data){
                                                $('#MenampilkanTabelEntitas').html(data);
                                                $('#ModalHapusEntitas').modal('hide');
                                                $('#ModalDetailEntitas').modal('hide');
                                                Swal.fire({
                                                    title: 'Good Job!',
                                                    text: 'Hapus Entitas Akses Berhasil',
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
        }
    });
});
//Tambah Edit Entitas
$('#ProsesEditEntitas').submit(function(){
    var ProsesEditEntitas = $('#ProsesEditEntitas').serialize();
    $('#NotifikasiEditEntitas').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/ProsesEditEntitas.php',
        data 	    :  ProsesEditEntitas,
        success     : function(data){
            $('#NotifikasiEditEntitas').html(data);
            var NotifikasiEditEntitasBerhasil = $('#NotifikasiEditEntitasBerhasil').html();
            if(NotifikasiEditEntitasBerhasil=="Success"){
                window.location.href='index.php?Page=Akses&Sub=EntitasAkses';
            }
        }
    });
});

//AKSES USER
$('#MenampilkanTabelAkses').load("_Page/Akses/TabelAkses.php");
//Ketika Pencarian di proses
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelAkses').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/TabelAkses.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelAkses').html(data);
        }
    });
});
//Ketika batas di ubah
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelAkses').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/TabelAkses.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelAkses').html(data);
        }
    });
});
//Ketika keyword_by di ubah
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormPencarianAkses').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormPencarianAkses.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormPencarianAkses').html(data);
        }
    });
});
//Tambah Akses
$('#ModalTambahtAkses').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormTambahAkses').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormTambahAkses.php',
        success     : function(data){
            $('#FormTambahAkses').html(data);
            $('#ProsesTambahAkses').submit(function(){
                e.preventDefault();
                $('#NotifikasiTambahAkses').html('Loading..');
                var form = $('#ProsesTambahAkses')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/ProsesTambahAkses.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiTambahAkses').html(data);
                        var Notifikasi=$('#Notifikasi').html();
                        if(Notifikasi=="Tambah Akses Berhasil"){
                            $('#MenampilkanTabelAkses').load("_Page/Akses/TabelAkses.php");
                            $('#FormTambahAkses').load('_Page/Akses/NotifikasiTambahAksesBerhasil.php');
                        }
                    }
                });
            });
        }
    });
});

//Modal Detail Akses
$('#ModalDetailAkses').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_akses = pecah[0];
    var keyword = pecah[1];
    var batas = pecah[2];
    var ShortBy = pecah[3];
    var OrderBy = pecah[4];
    var page = pecah[5];
    var posisi = pecah[6];
    var keyword_by = pecah[7];
    $('#FormDetailAkses').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormDetailAkses.php',
        data 	    :  {id_akses: id_akses},
        success     : function(data){
            $('#FormDetailAkses').html(data);
            
            //Modal Edit Password
            $('#ModalEditPassword').on('show.bs.modal', function (e) {
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormEditPassword').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/FormEditPassword.php',
                    data 	    :  {id_akses: id_akses},
                    success     : function(data){
                        $('#FormEditPassword').html(data);
                        $('#ProsesEditPassword').submit(function(){
                            e.preventDefault();
                            $('#NotifikasiEditPassword').html('Loading..');
                            var form = $('#ProsesEditPassword')[0];
                            var data = new FormData(form);
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Akses/ProsesEditPassword.php',
                                data 	    :  data,
                                cache       : false,
                                processData : false,
                                contentType : false,
                                enctype     : 'multipart/form-data',
                                success     : function(data){
                                    $('#NotifikasiEditPassword').html(data);
                                    var Notifikasi=$('#Notifikasi').html();
                                    if(Notifikasi=="Edit Password Berhasil"){
                                        $.ajax({
                                            type 	    : 'POST',
                                            url 	    : '_Page/Akses/TabelAkses.php',
                                            data 	    :  {keyword: keyword, batas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by: keyword_by},
                                            success     : function(data){
                                                $('#MenampilkanTabelAkses').html(data);
                                                $('#ModalEditPassword').modal('hide');
                                                $('#ModalDetailAkses').modal('hide');
                                                Swal.fire({
                                                    title: 'Good Job!',
                                                    text: 'Edit Password Berhasil',
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
            //Modal Delete Akses
            $('#ModalDeleteAkses').on('show.bs.modal', function (e) {
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormDeleteAkses').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/FormDeleteAkses.php',
                    data 	    :  {id_akses: id_akses},
                    success     : function(data){
                        $('#FormDeleteAkses').html(data);
                        $('#KonfirmasiHapusAkses').click(function(){
                            $('#NotifikasiHapusAkses').html('Loading..');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Akses/ProsesHapusAkses.php',
                                data 	    :  { id_akses: id_akses },
                                enctype     : 'multipart/form-data',
                                success     : function(data){
                                    $('#NotifikasiHapusAkses').html(data);
                                    var Notifikasi=$('#Notifikasi').html();
                                    if(Notifikasi=="Hapus Akses Berhasil"){
                                        $.ajax({
                                            type 	    : 'POST',
                                            url 	    : '_Page/Akses/TabelAkses.php',
                                            data 	    :  {keyword: keyword, batas: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by: keyword_by},
                                            success     : function(data){
                                                $('#MenampilkanTabelAkses').html(data);
                                                $('#ModalDeleteAkses').modal('hide');
                                                $('#ModalDetailAkses').modal('hide');
                                                Swal.fire({
                                                    title: 'Good Job!',
                                                    text: 'Hapus Akses Berhasil',
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
            $('#DeleteAkses').click(function(){
                $('#FormEditAkses').html('Loading...');
                $.ajax({
                    url     : "_Page/Akses/DeleteAkses.php",
                    method  : "POST",
                    data    :  {id_akses: id_akses},
                    success : function (data) {
                        $('#FormEditAkses').html(data);
                        $('#KonfirmasiHapusAkses').click(function(){
                            $('#NotifikasiHapusAkses').html('Loading...');
                            $.ajax({
                                url     : "_Page/Akses/ProsesHapusAkses.php",
                                method  : "POST",
                                data    :  {id_akses: id_akses},
                                success : function (data) {
                                    $('#NotifikasiHapusAkses').html(data);
                                    var Notifikasi=$('#Notifikasi').html();
                                    if(Notifikasi=="Hapus Akses Berhasil"){
                                        $('#MenampilkanTabelAkses').load("_Page/Akses/TabelAkses.php");
                                        $('#FormEditAkses').load('_Page/Akses/NotifikasiHapusAksesBerhasil.php');
                                    }
                                }
                            })
                        });
                    }
                })
            });
        }
    });
});
//Edit Akses
$('#ModalEditAkses').on('show.bs.modal', function (e) {
    var id_akses = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormEditAkses').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormEditAkses.php',
        data 	    :  {id_akses: id_akses},
        success     : function(data){
            $('#FormEditAkses').html(data);
            $('#ProsesEditAkses').submit(function(){
                e.preventDefault();
                $('#NotifikasiEditAkses').html('Loading..');
                var form = $('#ProsesEditAkses')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/ProsesEditAkses.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiEditAkses').html(data);
                        var NotifikasiEditAksesBerhasil=$('#NotifikasiEditAksesBerhasil').html();
                        if(NotifikasiEditAksesBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
$('#ProsesSimpanIjinAkses').submit(function(){
    $('#NotifikasiSimpanIjinAkses').html('Loading...');
    var ProsesSimpanIjinAkses = $('#ProsesSimpanIjinAkses').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/ProsesSimpanIjinAkses.php',
        data 	    :  ProsesSimpanIjinAkses,
        success     : function(data){
            $('#NotifikasiSimpanIjinAkses').html(data);
            var NotifikasiSimpanIjinAksesBerhasil=$('#NotifikasiSimpanIjinAksesBerhasil').html();
            if(NotifikasiSimpanIjinAksesBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Setting Akses
$('#ModalSettingAkses').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormSettingAkses').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormSettingAkses.php',
        success     : function(data){
            $('#FormSettingAkses').html(data);
            $('#FormSettingAkses2').load('_Page/Akses/FormSettingAkses2.php');
            //select akses
            $('#SelecAksesGroup').change(function(){
                var AksesGroup=$('#SelecAksesGroup').val();
                $('#FormSettingAkses2').html('Loading...');
                $.ajax({
                    url     : "_Page/Akses/FormSettingAkses2.php",
                    method  : "POST",
                    data    :  {AksesGroup: AksesGroup},
                    success : function (data) {
                        $('#FormSettingAkses2').html(data);
                        //Proses setting akses
                        $('#ProsesSettingAkses').submit(function(){
                            $('#NotifikasiSettingAkses').html(Loading);
                            var ProsesSettingAkses = $('#ProsesSettingAkses').serialize();
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Akses/ProsesSettingAkses.php',
                                data 	    :  ProsesSettingAkses,
                                success     : function(data){
                                    $('#NotifikasiSettingAkses').html(data);
                                    var Notifikasi=$('#Notifikasi').html();
                                    if(Notifikasi=="Setting Akses Berhasil"){
                                        $('#TampilkanTabelAkses').load("_Page/Akses/TabelAkses.php");
                                        $('#FormSettingAkses').load('_Page/Akses/NotifikasiSettingAksesBerhasil.php');
                                    }
                                }
                            });
                        });
                    }
                });
            });
        }
    });
});
//PENGAJUAN AKSES
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Akses/CaptchaUrl.php',
    success     : function(data){
        $("#ViewCaptcha").attr("src",data);
    }
});
//Reload captcha
$('#ReloadGambarCaptcha').click(function(){
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/CaptchaUrl.php',
        success     : function(data){
            $("#ViewCaptcha").attr("src",data);
        }
    });
});
//Kirim Pengajuan akses
$('#ProsesPengajuanAkses').submit(function(){
    $('#NotifikasiPengajuanAkses').html('Loading..');
    var form = $('#ProsesPengajuanAkses')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/ProsesPengajuanAkses.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiPengajuanAkses').html(data);
            var NotifikasiPengajuanAksesBerhasil=$('#NotifikasiPengajuanAksesBerhasil').html();
            if(NotifikasiPengajuanAksesBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
$('#MenampilkanTabelPengajuan').load("_Page/Akses/TabelPengajuanAkses.php");
//Batas dan Pencarian
$('#BatasPencarianPengajuan').submit(function(){
    var BatasPencarianPengajuan = $('#BatasPencarianPengajuan').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelPengajuan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/TabelPengajuanAkses.php',
        data 	    :  BatasPencarianPengajuan,
        success     : function(data){
            $('#MenampilkanTabelPengajuan').html(data);
        }
    });
});
//Ketika keyword by diubah
$('#keyword_by_pengajuan').change(function(){
    var keyword_by_pengajuan = $('#keyword_by_pengajuan').val();
    $('#FormKeywordPengajuan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormKeywordPengajuan.php',
        data 	    :  {keyword_by_pengajuan: keyword_by_pengajuan},
        success     : function(data){
            $('#FormKeywordPengajuan').html(data);
        }
    });
});
//Modal Detail Pengajuan Akses
$('#ModalDetailPengajuanAkses').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_akses_pengajuan = pecah[0];
    var keyword_by = pecah[1];
    var keyword = pecah[2];
    var batas = pecah[3];
    var ShortBy = pecah[4];
    var OrderBy = pecah[5];
    var page = pecah[6];
    var posisi = pecah[7];
    $('#FormDetailPengajuanAkses').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormDetailPengajuanAkses.php',
        data 	    :  {id_akses_pengajuan: id_akses_pengajuan},
        success     : function(data){
            $('#FormDetailPengajuanAkses').html(data);
            //Menampilkan foto
            $('#TampilkanFotoPengajuan').click(function(){
                var TampilkanFotoPengajuan = $('#TampilkanFotoPengajuan').html();
                if(TampilkanFotoPengajuan=="(Tampilkan)"){
                    $('#TempatMenampilkanFoto').html('Loading...');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/Akses/TempatMenampilkanFoto.php',
                        data 	    :  {id_akses_pengajuan: id_akses_pengajuan},
                        success     : function(data){
                            $('#TempatMenampilkanFoto').html(data);
                        }
                    });
                    $('#TampilkanFotoPengajuan').html("(Sembunyikan)");
                }else{
                    $('#TempatMenampilkanFoto').html('');
                    $('#TampilkanFotoPengajuan').html("(Tampilkan)");
                }
            });
            //Modal Hapus Pengajuan Akses
            $('#ModalHapusPengajuanAkses').on('show.bs.modal', function (e) {
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#FormHapusPengajuanAkses').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/FormHapusPengajuanAkses.php',
                    data 	    :  {id_akses_pengajuan: id_akses_pengajuan},
                    success     : function(data){
                        $('#FormHapusPengajuanAkses').html(data);
                        $('#KonfirmasiHapusPengajuanAkses').click(function(){
                            $('#NotifikasiHapusPengajuanAkses').html('Loading..');
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Akses/ProsesHapusPengajuanAkses.php',
                                data 	    :  { id_akses_pengajuan: id_akses_pengajuan },
                                enctype     : 'multipart/form-data',
                                success     : function(data){
                                    $('#NotifikasiHapusPengajuanAkses').html(data);
                                    var NotifikasiHapusPengajuanAksesBerhasil=$('#NotifikasiHapusPengajuanAksesBerhasil').html();
                                    if(NotifikasiHapusPengajuanAksesBerhasil=="Success"){
                                        $('#MenampilkanTabelPengajuan').html('Loading...');
                                        $.ajax({
                                            type 	    : 'POST',
                                            url 	    : '_Page/Akses/TabelPengajuanAkses.php',
                                            data 	    :  {keyword_pengajuan: keyword, batas_pengajuan: batas, ShortBy: ShortBy, OrderBy: OrderBy, page: page, posisi: posisi, keyword_by_pengajuan: keyword_by},
                                            success     : function(data){
                                                $('#MenampilkanTabelPengajuan').html(data);
                                                $('#ModalHapusPengajuanAkses').modal('hide');
                                                $('#ModalDetailPengajuanAkses').modal('hide');
                                                Swal.fire({
                                                    title: 'Good Job!',
                                                    text: 'Hapus Pengajuan Akses Berhasil',
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
        }
    });
});
//Modal Tampilkan Foto Pengajuan
$('#ModalTampilkanFotoPengajuan').on('show.bs.modal', function (e) {
    var foto = $(e.relatedTarget).data('id');
    $('#FormTampilkanFotoPengajuan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormTampilkanFotoPengajuan.php',
        data 	    :  {foto: foto},
        success     : function(data){
            $('#FormTampilkanFotoPengajuan').html(data);
        }
    });
});
//Modal Tampilkan Foto User
$('#ModalTampilkanFotoUser').on('show.bs.modal', function (e) {
    var FotoProfile = $(e.relatedTarget).data('id');
    $('#FormTampilkanFotoUser').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormTampilkanFotoUser.php',
        data 	    :  {FotoProfile: FotoProfile},
        success     : function(data){
            $('#FormTampilkanFotoUser').html(data);
        }
    });
});
//Modal Terima Pengajuan
$('#ModalTerimaPengajuan').on('show.bs.modal', function (e) {
    var id_akses_pengajuan = $(e.relatedTarget).data('id');
    $('#FormTerimaPengajuanAkses').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormTerimaPengajuanAkses.php',
        data 	    :  {id_akses_pengajuan: id_akses_pengajuan},
        success     : function(data){
            $('#FormTerimaPengajuanAkses').html(data);
            //Generate Password
            $('#GeneratePassword').click(function(){
                $('#password').val('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/GeneratePassword.php',
                    success     : function(data){
                        $('#password').val(data);
                    }
                });
            });
            //Proses Terima Pengajuan
            $('#ProsesTerimaPengajuan').submit(function(){
                $('#NotifikasiTerimaPengajuan').html('Loading...');
                var ProsesTerimaPengajuan = $('#ProsesTerimaPengajuan').serialize();
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/ProsesTerimaPengajuan.php',
                    data 	    :  ProsesTerimaPengajuan,
                    success     : function(data){
                        $('#NotifikasiTerimaPengajuan').html(data);
                        var NotifikasiTerimaPengajuanBerhasil=$('#NotifikasiTerimaPengajuanBerhasil').html();
                        if(NotifikasiTerimaPengajuanBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Tolak Pengajuan
$('#ModalTolakPengajuan').on('show.bs.modal', function (e) {
    var id_akses_pengajuan = $(e.relatedTarget).data('id');
    $('#FormTolakPengajuan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormTolakPengajuan.php',
        data 	    :  {id_akses_pengajuan: id_akses_pengajuan},
        success     : function(data){
            $('#FormTolakPengajuan').html(data);
            //Proses Tolak Pengajuan
            $('#ProsesTolakPengajuan').submit(function(){
                $('#NotifikasiTolakPengajuan').html('Loading...');
                var ProsesTolakPengajuan = $('#ProsesTolakPengajuan').serialize();
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/ProsesTolakPengajuan.php',
                    data 	    :  ProsesTolakPengajuan,
                    success     : function(data){
                        $('#NotifikasiTolakPengajuan').html(data);
                        var NotifikasiTolakPengajuanBerhasil=$('#NotifikasiTolakPengajuanBerhasil').html();
                        if(NotifikasiTolakPengajuanBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Hapus Pengajuan Akses2
$('#ModalHapusPengajuanAkses2').on('show.bs.modal', function (e) {
    var id_akses_pengajuan = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormHapusPengajuanAkses2').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormHapusPengajuanAkses.php',
        data 	    :  {id_akses_pengajuan: id_akses_pengajuan},
        success     : function(data){
            $('#FormHapusPengajuanAkses2').html(data);
            $('#KonfirmasiHapusPengajuanAkses').click(function(){
                $('#NotifikasiHapusPengajuanAkses').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/ProsesHapusPengajuanAkses.php',
                    data 	    :  { id_akses_pengajuan: id_akses_pengajuan },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusPengajuanAkses').html(data);
                        var NotifikasiHapusPengajuanAksesBerhasil=$('#NotifikasiHapusPengajuanAksesBerhasil').html();
                        if(NotifikasiHapusPengajuanAksesBerhasil=="Success"){
                            window.location.href='index.php?Page=Akses&Sub=PengajuanAkses';
                        }
                    }
                });
            });
        }
    });
});
//Modal Hapus Akses
$('#ModalHapusAkses').on('show.bs.modal', function (e) {
    var id_akses = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormHapusAkses').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormHapusAkses.php',
        data 	    :  {id_akses: id_akses},
        success     : function(data){
            $('#FormHapusAkses').html(data);
            $('#KonfirmasiHapusAkses').click(function(){
                $('#NotifikasiHapusAkses').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/ProsesHapusAkses.php',
                    data 	    :  { id_akses: id_akses },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusAkses').html(data);
                        var NotifikasiHapusAksesBerhasil=$('#NotifikasiHapusAksesBerhasil').html();
                        if(NotifikasiHapusAksesBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Ubah Password
$('#ModalUbahPassword').on('show.bs.modal', function (e) {
    var id_akses = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormUbahPassword').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormUbahPassword.php',
        data 	    :  {id_akses: id_akses},
        success     : function(data){
            $('#FormUbahPassword').html(data);
            //Tampilkan Password?
            $('#TampilkanPassword').click(function(){
                if($(this).is(':checked')){
                    $('#password1').attr('type','text');
                    $('#password2').attr('type','text');
                }else{
                    $('#password1').attr('type','password');
                    $('#password2').attr('type','password');
                }
            });
            $('#ProsesUbahPassword').submit(function(){
                e.preventDefault();
                $('#NotifikasiUbahPassword').html('Loading..');
                var form = $('#ProsesUbahPassword')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/ProsesUbahPassword.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiUbahPassword').html(data);
                        var NotifikasiUbahPasswordBerhasil=$('#NotifikasiUbahPasswordBerhasil').html();
                        if(NotifikasiUbahPasswordBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
$('#ModalDetailPengajuanAkses2').on('show.bs.modal', function (e) {
    var id_akses_pengajuan = $(e.relatedTarget).data('id');
    $('#FormDetailPengajuanAkses2').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormDetailPengajuanAkses2.php',
        data 	    :  {id_akses_pengajuan: id_akses_pengajuan},
        success     : function(data){
            $('#FormDetailPengajuanAkses2').html(data);
            //Menampilkan foto
            $('#TampilkanFotoPengajuan2').click(function(){
                var TampilkanFotoPengajuan = $('#TampilkanFotoPengajuan2').html();
                if(TampilkanFotoPengajuan=="(Tampilkan)"){
                    $('#TempatMenampilkanFoto2').html('Loading...');
                    $.ajax({
                        type 	    : 'POST',
                        url 	    : '_Page/Akses/TempatMenampilkanFoto.php',
                        data 	    :  {id_akses_pengajuan: id_akses_pengajuan},
                        success     : function(data){
                            $('#TempatMenampilkanFoto2').html(data);
                        }
                    });
                    $('#TampilkanFotoPengajuan2').html("(Sembunyikan)");
                }else{
                    $('#TempatMenampilkanFoto2').html('');
                    $('#TampilkanFotoPengajuan2').html("(Tampilkan)");
                }
            });
        }
    });
});

//LOG AKSES
var ProsesBatasLogAkses = $('#ProsesBatasLogAkses').serialize();
$('#MenampilkanLogAkses').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Akses/TabelAksesLog.php',
    data 	    :  ProsesBatasLogAkses,
    success     : function(data){
        $('#MenampilkanLogAkses').html(data);
    }
});
//Batas dan Pencarian
$('#BatasLog').change(function(){
    var ProsesBatasLogAkses = $('#ProsesBatasLogAkses').serialize();
    $('#MenampilkanLogAkses').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/TabelAksesLog.php',
        data 	    :  ProsesBatasLogAkses,
        success     : function(data){
            $('#MenampilkanLogAkses').html(data);
        }
    });
});
//Mulai Pencarian Referensi
$('#ProsesBatasLogAkses').submit(function(){
    var ProsesBatasLogAkses = $('#ProsesBatasLogAkses').serialize();
    $('#MenampilkanLogAkses').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/TabelAksesLog.php',
        data 	    :  ProsesBatasLogAkses,
        success     : function(data){
            $('#MenampilkanLogAkses').html(data);
        }
    });
});
// Ketika keyword by diubah
$('#KeywordByLog').change(function(){
    var KeywordByLog = $('#KeywordByLog').val();
    $('#FormKeywordLog').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormKeywordLog.php',
        data 	    :  {KeywordByLog: KeywordByLog},
        success     : function(data){
            $('#FormKeywordLog').html(data);
        }
    });
});
$('#ModalEksportLogAkses').on('show.bs.modal', function (e) {
    var id_akses = $(e.relatedTarget).data('id');
    $('#FormEksportLogAkses').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormEksportLogAkses.php',
        data 	    :  {id_akses: id_akses},
        success     : function(data){
            $('#FormEksportLogAkses').html(data);
        }
    });
});
$('#ModalRekapLogAkses').on('show.bs.modal', function (e) {
    var id_akses = $(e.relatedTarget).data('id');
    var NamaData="Grafik Log Akses";
    $('#FormShortGrafik').html('Loading...');
    $('#MenampilkanGrafikLog').html('');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Akses/FormShortGrafik.php',
        data 	    :  {id_akses: id_akses},
        success     : function(data){
            $('#FormShortGrafik').html(data);
            $('#ProsesTampilkanGrafik').submit(function(){
                var ProsesTampilkanGrafik = $('#ProsesTampilkanGrafik').serialize();
                $('#MenampilkanGrafikLog').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Akses/MenampilkanGrafikLog.php',
                    data 	    :  ProsesTampilkanGrafik,
                    success     : function(data){
                        // $('#MenampilkanGrafikLog').html(data);
                        var options = {
                            chart: {
                                height: 400,
                                type: 'bar',
                            },
                            dataLabels: {
                                enabled: false
                            },
                            series: [],
                            title: {
                                text: NamaData,
                            },
                            noData: {
                                text: 'No Data'
                            }
                        }
                        
                        var chart = new ApexCharts(
                            document.querySelector("#MenampilkanGrafikLog"),
                            options
                        );
                        var UrlData = '_Page/Akses/GrafikLogAkses.json';
                        // var UrlData = '_Page/Akses/MenampilkanGrafikLog.php';
                        $.getJSON(UrlData, function(response) {
                            chart.updateSeries([{
                                name: NamaData,
                                data: response
                            }])
                        });
                        chart.render();
                    }
                });
            });
        }
    });
});