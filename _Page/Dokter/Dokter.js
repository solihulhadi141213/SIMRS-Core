//Menampilkan Data Dokter Untuk Pertama Kali
var BatasPencarian = $('#BatasPencarian').serialize();
var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
$('#MenampilkanTabelDokter').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Dokter/TabelDokter.php',
    data 	    :  BatasPencarian,
    success     : function(data){
        $('#MenampilkanTabelDokter').html(data);
    }
});
//Ketika Batas Data Diubah
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/TabelDokter.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelDokter').html(data);
        }
    });
});
//Ketika ShortBy Diubah
$('#ShortBy').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/TabelDokter.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelDokter').html(data);
        }
    });
});
//Ketika OrderBy Diubah
$('#OrderBy').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/TabelDokter.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelDokter').html(data);
        }
    });
});
//Ketika keyword_by Diubah
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//Ketika Proses Pencarian Dimulai
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/TabelDokter.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelDokter').html(data);
        }
    });
});
//Modal Tambah Dokter
$('#ModalTambahDokter').on('show.bs.modal', function (e) {
    $('#NotifikasiTambahDokter').html('<span class="text-primary">Pastikan informasi Dokter & tenaga profesional kesehatan yang anda input sudah sesuai</span>');
});
//Proses Tambah Dokter
$('#ProsesTambahDokter').submit(function(){
    $('#NotifikasiTambahDokter').html('Loading..');
    var form = $('#ProsesTambahDokter')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/ProsesTambahDokter.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahDokter').html(data);
            var NotifikasiTambahDokterBerhasil=$('#NotifikasiTambahDokterBerhasil').html();
            if(NotifikasiTambahDokterBerhasil=="Berhasil"){
                //Mengembalikan halaman ke 1
                $('#page').val("1");
                //Menampilkan data dokter berdasarkan filter
                var BatasPencarian = $('#BatasPencarian').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#MenampilkanTabelDokter').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Dokter/TabelDokter.php',
                    data 	    :  BatasPencarian,
                    success     : function(data){
                        $('#MenampilkanTabelDokter').html(data);
                    }
                });
                //Reset Form
                $("#ProsesTambahDokter")[0].reset();
                //Menutup Modal
                $('#ModalTambahDokter').modal("hide");
                //Menampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Dokter Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Detail Dokter
$('#ModalDetailDokter').on('show.bs.modal', function (e) {
    var id_dokter = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDetailDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/FormDetailDokter.php',
        data 	    :  {id_dokter: id_dokter},
        success     : function(data){
            $('#FormDetailDokter').html(data);
        }
    });
});
//Modal Edit Dokter
$('#ModalEditDokter').on('show.bs.modal', function (e) {
    var id_dokter = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#NotifikasiEditDokter').html('<span class="text-primary">Pastikan informasi Dokter & tenaga profesional kesehatan yang anda input sudah sesuai</span>');
    $('#FormEditDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/FormEditDokter.php',
        data 	    :  {id_dokter: id_dokter},
        success     : function(data){
            $('#FormEditDokter').html(data);
        }
    });
});
$('#ProsesEditDokter').submit(function(){
    $('#NotifikasiEditDokter').html('Loading..');
    var form = $('#ProsesEditDokter')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/ProsesEditDokter.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditDokter').html(data);
            var NotifikasiEditDokterBerhasil=$('#NotifikasiEditDokterBerhasil').html();
            if(NotifikasiEditDokterBerhasil=="Success"){
                //Menampilkan data dokter berdasarkan filter
                var BatasPencarian = $('#BatasPencarian').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#MenampilkanTabelDokter').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Dokter/TabelDokter.php',
                    data 	    :  BatasPencarian,
                    success     : function(data){
                        $('#MenampilkanTabelDokter').html(data);
                    }
                });
                //Menutup Modal
                $('#ModalEditDokter').modal("hide");
                //Menampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Dokter Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Hapus Dokter
$('#ModalHapusDokter').on('show.bs.modal', function (e) {
    var id_dokter = $(e.relatedTarget).data('id');
    $('#NotifikasiHapusDokter').html('<span class="text-danger">Apakah anda yakin akan menghapus data Dokter ini?</span>');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormHapusDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/FormHapusDokter.php',
        data        :  {id_dokter: id_dokter},
        success     : function(data){
            $('#FormHapusDokter').html(data);
        }
    });
});
//Konfirmasi Hapus Data Dokter
$('#ProsesHapusDokter').click(function(){
    var ProsesHapusDokter = $('#ProsesHapusDokter').serialize();
    $('#NotifikasiHapusDokter').html('Loading...');
    $.ajax({
        url     : "_Page/Dokter/ProsesHapusDokter.php",
        method  : "POST",
        data    :  ProsesHapusDokter,
        success : function (data) {
            $('#NotifikasiHapusDokter').html(data);
            //Notifikasi Proses Hapus
            var NotifikasiHapusDokterBerhasil=$('#NotifikasiHapusDokterBerhasil').html();
            if(NotifikasiHapusDokterBerhasil=="Success"){
                //Menampilkan data dokter berdasarkan filter
                var BatasPencarian = $('#BatasPencarian').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#MenampilkanTabelDokter').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Dokter/TabelDokter.php',
                    data 	    :  BatasPencarian,
                    success     : function(data){
                        $('#MenampilkanTabelDokter').html(data);
                    }
                });
                //Menutup Modal
                $('#ModalHapusDokter').modal("hide");
                //Menampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Dokter Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    })
});
//Modal Jadwal Praktek
$('#ModalJadwalDokter').on('show.bs.modal', function (e) {
    var id_dokter = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormJadwalPraktek').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/FormJadwalPraktek.php',
        data        : {id_dokter: id_dokter},
        success     : function(data){
            $('#FormJadwalPraktek').html(data);
        }
    });
});
//Modal History Dokter
$('#ModalHistoryDokter').on('show.bs.modal', function (e) {
    var id_dokter = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#PutIdDokterKunjungan').val(id_dokter);
    $('#keyword_kunjungan').val("");
    var BatasKunjungan = $('#BatasKunjungan').serialize();
    $('#FormHistoryDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/FormHistoryDokter.php',
        data        : BatasKunjungan,
        success     : function(data){
            $('#FormHistoryDokter').html(data);
        }
    });
});
//Ketika Dilakukan Pencarian
$('#BatasKunjungan').submit(function(){
    var BatasKunjungan = $('#BatasKunjungan').serialize();
    $('#FormHistoryDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/FormHistoryDokter.php',
        data        : BatasKunjungan,
        success     : function(data){
            $('#FormHistoryDokter').html(data);
        }
    });
});
//Modal IHS Dokter
$('#ModalIhsDokter').on('show.bs.modal', function (e) {
    var id_ihs_practitioner = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormIhsDokter').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Referensi/FormDetailPractitionerSatuSehat.php',
        data        : {id: id_ihs_practitioner},
        success     : function(data){
            $('#FormIhsDokter').html(data);
        }
    });
});
//Modal Data Hfis
$('#ModalDataHfis').on('show.bs.modal', function (e) {
    var kode = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDataHfis').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dokter/TabelDokterHfis.php',
        data        : {kode: kode},
        success     : function(data){
            $('#FormDataHfis').html(data);
        }
    });
});