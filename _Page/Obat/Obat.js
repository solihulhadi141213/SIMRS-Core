//Menampilkan List Kategori Pertama kali
$('#ListKategori').load("_Page/Obat/ListKategori.php");
//Proses Tambah Kategori Harga
$('#ProsesTambahKategoriHarga').submit(function(){
    var ProsesTambahKategoriHarga = $('#ProsesTambahKategoriHarga').serialize();
    $('#NotifikasiTambahKategoriHarga').html('<span class="text-primary">Loading...</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesTambahKategoriHarga.php',
        data 	    :  ProsesTambahKategoriHarga,
        success     : function(data){
            $('#NotifikasiTambahKategoriHarga').html(data);
            var NotifikasiTambahKategoriHargaBerhasil=$('#NotifikasiTambahKategoriHargaBerhasil').html();
            if(NotifikasiTambahKategoriHargaBerhasil=="Success"){
                $('#ModalTambahKategoriHarga').modal('hide');
                $('#ProsesTambahKategoriHarga')[0].reset();
                $('#ListKategori').load("_Page/Obat/ListKategori.php");
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Kategori Harga Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Ketika Modal Kategori Harga Muncul
$('#ModalKategoriHarga').on('show.bs.modal', function (e) {
    $('#ModalTambahKategoriHarga').modal('hide');
    $('#ModalEditKategoriHarga').modal('hide');
    $('#ModalHapusKategoriHarga').modal('hide');
});
//Ketika Modal Tambah Kategori Harga Muncul
$('#ModalTambahKategoriHarga').on('show.bs.modal', function (e) {
    $('#ModalKategoriHarga').modal('hide');
});
//Modal Edit Kategori Obat
$('#ModalEditKategoriHarga').on('show.bs.modal', function (e) {
    var id_kategori_harga = $(e.relatedTarget).data('id');
    $('#FormEditKategoriHarga').html('<div class="modal-body">Loading...</div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormEditKategoriHarga.php',
        data 	    :  {id_kategori_harga: id_kategori_harga},
        success     : function(data){
            $('#FormEditKategoriHarga').html(data);
            $('#ModalKategoriHarga').modal('hide');
        }
    });
});
//Proses Edit Kategori Harga
$('#ProsesEditKategoriHarga').submit(function() { 
    var ProsesEditKategoriHarga = $('#ProsesEditKategoriHarga').serialize();
    $('#NotifikasiEditKategoriHarga').html('<span class="text-primary">Loading...</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesEditKategoriHarga.php',
        data 	    :  ProsesEditKategoriHarga,
        success     : function(data){
            $('#NotifikasiEditKategoriHarga').html(data);
            var NotifikasiEditKategoriHargaBerhasil=$('#NotifikasiEditKategoriHargaBerhasil').html();
            if(NotifikasiEditKategoriHargaBerhasil=="Success"){
                $('#ModalEditKategoriHarga').modal('hide');
                $('#NotifikasiEditKategoriHarga').html('<span class="text-primary">Pastikan informasi kategori obat yang anda input sudah benar!</span>');
                $('#ProsesEditKategoriHarga')[0].reset();
                $('#ListKategori').load("_Page/Obat/ListKategori.php");
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Kategori Harga Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Kategori Obat
$('#ModalHapusKategoriHarga').on('show.bs.modal', function (e) {
    var id_kategori_harga = $(e.relatedTarget).data('id');
    $('#FormHapusKategoriHarga').html('<div class="modal-body">Loading...</div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormHapusKategoriHarga.php',
        data 	    :  {id_kategori_harga: id_kategori_harga},
        success     : function(data){
            $('#FormHapusKategoriHarga').html(data);
            $('#ModalKategoriHarga').modal('hide');
            //Proses Hapus
            $('#ProsesHapusKategoriHarga').submit(function() { 
                var ProsesHapusKategoriHarga = $('#ProsesHapusKategoriHarga').serialize();
                $('#NotifikasiHapusKategoriHarga').html('<small class="modal-title my-3">Loading...</small>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Obat/ProsesHapusKategoriHarga.php',
                    data 	    :  ProsesHapusKategoriHarga,
                    success     : function(data){
                        $('#NotifikasiHapusKategoriHarga').html(data);
                        var NotifikasiHapusKategoriHargaBerhasil=$('#NotifikasiHapusKategoriHargaBerhasil').html();
                        if(NotifikasiHapusKategoriHargaBerhasil=="Success"){
                            $('#ModalHapusKategoriHarga').modal('hide');
                            $('#ProsesHapusKategoriHarga')[0].reset();
                            $('#ListKategori').load("_Page/Obat/ListKategori.php");
                            Swal.fire({
                                title: 'Good Job!',
                                text: 'Hapus Kategori Harga Berhasil',
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
//Menampilkan Data Obat Pertama Kali
var BatasPencarian = $('#BatasPencarian').serialize();
var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
$('#MenampilkanTabelObat').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Obat/TabelObat.php',
    data 	    :  BatasPencarian,
    success     : function(data){
        $('#MenampilkanTabelObat').html(data);
    }
});
//Batas dan Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
    $('#MenampilkanTabelObat').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/TabelObat.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelObat').html(data);
            $('#ModalFilterObat').modal('hide');
        }
    });
});
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
    $('#MenampilkanTabelObat').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/TabelObat.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelObat').html(data);
        }
    });
});
//Kondisi Ketika keyword_by Diubah
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    var Loading='Loading...';
    $('#FormKeyword').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//Fiter Tabel
$('#ModalFilterObat').on('show.bs.modal', function (e) {
    var ColomName = $(e.relatedTarget).data('id');
    var batas =$('#batas').val();
    $('#FormFilterObat').load("_Partial/PreLoader.php");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormFilterObat.php',
        data 	    :  {ColomName: ColomName, batas: batas},
        success     : function(data){
            $('#FormFilterObat').html(data);
            $('#ProsesFilterObat').submit(function(){
                var ProsesFilterObat = $('#ProsesFilterObat').serialize();
                var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
                $('#MenampilkanTabelObat').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Obat/TabelObat.php',
                    data 	    :  ProsesFilterObat,
                    success     : function(data){
                        $('#MenampilkanTabelObat').html(data);
                    }
                });
            });
        }
    });
});
//Ketika modal tambah obat muncul
$('#ModalTambahObat').on('show.bs.modal', function (e) {
    $('#MutliHarga').html('<span class="text-success">Loading..</span>');
    $('#MutliHarga').load('_Page/Obat/FormMutliHarga.php');
});
//Ketika Click Tombol Generate Kode Obat
$('#GenerateKodeObatBaru').click(function(){
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesGenerateKodeObat.php',
        success     : function(data){
            var textWithoutSpaces = data.replace(/\s+/g, '');
            $('#kode').val(textWithoutSpaces);
        }
    });
});
//Proses Tambah Obat
$('#ProsesTambahObat').submit(function(){
    $('#NotifikasiTambahObat').html('Loading..');
    var form = $('#ProsesTambahObat')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesTambahObat.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahObat').html(data);
            var NotifikasiTambahObatBerhasil=$('#NotifikasiTambahObatBerhasil').html();
            if(NotifikasiTambahObatBerhasil=="Success"){
                //hidden modal
                $('#ProsesTambahObat')[0].reset();
                $('#ModalTambahObat').modal('hide');
                var BatasPencarian = $('#BatasPencarian').serialize();
                var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
                $('#MenampilkanTabelObat').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Obat/TabelObat.php',
                    data 	    :  BatasPencarian,
                    success     : function(data){
                        $('#MenampilkanTabelObat').html(data);
                    }
                });
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Obat Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Detail Obat
$('#ModalDetailObat').on('show.bs.modal', function (e) {
    var id_obat = $(e.relatedTarget).data('id');
    $('#FormDetailObat').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormDetailObat.php',
        data 	    :  {id_obat: id_obat},
        success     : function(data){
            $('#FormDetailObat').html(data);
        }
    });
});
//Modal Edit Obat
$('#ModalEditObat').on('show.bs.modal', function (e) {
    var id_obat = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormEditObat').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormEditObat.php',
        data 	    :  {id_obat: id_obat},
        success     : function(data){
            $('#FormEditObat').html(data);
            $('#GenerateKodeObatBaru2').click(function(){
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Obat/ProsesGenerateKodeObat.php',
                    success     : function(data){
                        var textWithoutSpaces = data.replace(/\s+/g, '');
                        $('#kode2').val(textWithoutSpaces);
                    }
                });
            });
        }
    });
});
//Proses Edit Obat
$('#ProsesEditObat').submit(function(){
    $('#NotifikasiEditObat').html('Loading..');
    var form = $('#ProsesEditObat')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesEditObat.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditObat').html(data);
            var NotifikasiEditObatBerhasil=$('#NotifikasiEditObatBerhasil').html();
            if(NotifikasiEditObatBerhasil=="Berhasil"){
                location.reload();
            }
        }
    });
});
//Modal Hapus Obat
$('#ModalHapusObat').on('show.bs.modal', function (e) {
    var id_obat = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormHapusObat').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormHapusObat.php',
        data 	    :  {id_obat: id_obat},
        success     : function(data){
            $('#FormHapusObat').html(data);
            $('#KonfirmasiHapusObat').click(function(){
                $('#NotifikasiHapusObat').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Obat/ProsesDeleteObat.php',
                    data 	    :  { id_obat: id_obat },
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiHapusObat').html(data);
                        var NotifikasiHapusObatBerhasil=$('#NotifikasiHapusObatBerhasil').html();
                        if(NotifikasiHapusObatBerhasil=="Berhasil"){
                            window.location.href='index.php?Page=Obat';
                        }
                    }
                });
            });
        }
    });
});
//Modal Pilih Racikan
$('#ModalPilihRacikan').on('show.bs.modal', function (e) {
    var id_obat = $(e.relatedTarget).data('id');
    $('#FormPilihRacikan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormPilihRacikan.php',
        data 	    :  {id_obat: id_obat},
        success     : function(data){
            $('#FormPilihRacikan').html(data);
        }
    });
});

//Modal Tambah Medication
$('#ModalTambahMedication').on('show.bs.modal', function (e) {
    var GetIdObat = $(e.relatedTarget).data('id');
    $('#FormTambahMedication').html("Loading...");
    $('#NotifikasiTambahMedication').html("Loading...");
    // $('#ModalPencarianKfa').modal('hide');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormTambahMedication.php',
        data        :   {GetIdObat: GetIdObat},
        success     : function(data){
            $('#FormTambahMedication').html(data);
            $('#NotifikasiTambahMedication').html('Pastikan data yang anda input sudah benar');
        }
    });
});
//Modal Tambah Satuan Multi
$('#ModalTambahSatuanMulti').on('show.bs.modal', function (e) {
    var id_obat = $(e.relatedTarget).data('id');
    $('#FormTambahSatuanMulti').load("_Partial/PreLoader.php");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormTambahSatuanMulti.php',
        data 	    :  {id_obat: id_obat},
        success     : function(data){
            $('#FormTambahSatuanMulti').html(data);
        }
    });
});
//proses Simpan Data Satuan Multi
$('#ProsesTambahSatuanMulti').submit(function(){
    $('#NotifikasiTambahSatuanMulti').html('Loading..');
    var form = $('#ProsesTambahSatuanMulti')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesTambahSatuanMulti.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahSatuanMulti').html(data);
            var NotifikasiTambahSatuanMultiBerhasil=$('#NotifikasiTambahSatuanMultiBerhasil').html();
            if(NotifikasiTambahSatuanMultiBerhasil=="Success"){
                //hidden modal
                $('#ProsesTambahSatuanMulti')[0].reset();
                $('#ModalTambahSatuanMulti').modal('hide');
                location.reload();
            }
        }
    });
});
//Modal Edit Satuan Multi
$('#ModalEditSatuanMulti').on('show.bs.modal', function (e) {
    var id_obat_multi = $(e.relatedTarget).data('id');
    $('#FormEditSatuanMulti').load("_Partial/PreLoader.php");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormEditSatuanMulti.php',
        data 	    :  {id_obat_multi: id_obat_multi},
        success     : function(data){
            $('#FormEditSatuanMulti').html(data);
        }
    });
});
//proses Update Data Satuan Multi
$('#ProsesEditSatuanMulti').submit(function(){
    $('#NotifikasiEditSatuanMulti').html('Loading..');
    var form = $('#ProsesEditSatuanMulti')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesEditSatuanMulti.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditSatuanMulti').html(data);
            var NotifikasiEditSatuanMultiBerhasil=$('#NotifikasiEditSatuanMultiBerhasil').html();
            if(NotifikasiEditSatuanMultiBerhasil=="Success"){
                //hidden modal
                $('#ProsesEditSatuanMulti')[0].reset();
                $('#ModalEditSatuanMulti').modal('hide');
                location.reload();
            }
        }
    });
});
//proses Hapus Data Satuan Multi
$('#KonfirmasiHapusSatuanMulti').click(function(){
    $('#NotifikasiEditSatuanMulti').html('Loading..');
    var form = $('#ProsesEditSatuanMulti')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesHapusSatuanMulti.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditSatuanMulti').html(data);
            var NotifikasiHapusSatuanMultiBerhasil=$('#NotifikasiHapusSatuanMultiBerhasil').html();
            if(NotifikasiHapusSatuanMultiBerhasil=="Success"){
                //hidden modal
                $('#ProsesEditSatuanMulti')[0].reset();
                $('#ModalEditSatuanMulti').modal('hide');
                location.reload();
            }
        }
    });
});
//Modal Posisi Obat
$('#ModalPosisiObat').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_obat = pecah[0];
    var id_obat_storage = pecah[1];
    $('#FormPosisiObat').load("_Partial/PreLoader.php");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormPosisiObat.php',
        data 	    :  {id_obat: id_obat, id_obat_storage: id_obat_storage},
        success     : function(data){
            $('#FormPosisiObat').html(data);
        }
    });
});
//proses Posisi Obat
$('#ProsesPosisiObat').submit(function(){
    $('#NotifikasiPosisiObat').html('Loading..');
    var form = $('#ProsesPosisiObat')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesPosisiObat.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiPosisiObat').html(data);
            var NotifikasiPosisiObatBerhasil=$('#NotifikasiPosisiObatBerhasil').html();
            if(NotifikasiPosisiObatBerhasil=="Success"){
                //hidden modal
                $('#ProsesPosisiObat')[0].reset();
                $('#ModalPosisiObat').modal('hide');
                location.reload();
            }
        }
    });
});
//Menampilkan Riwayat Transaksi Obat Pertama Kali
var FilterRiwayatTransaksi = $('#FilterRiwayatTransaksi').serialize();
var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
$('#TabelRiwayatTransaksi').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Obat/TabelRiwayatTransaksi.php',
    data 	    :  FilterRiwayatTransaksi,
    success     : function(data){
        $('#TabelRiwayatTransaksi').html(data);
    }
});
//Ketika Dilakukan Pencarian Riwayat Transaksi
$('#FilterRiwayatTransaksi').submit(function(){
    var FilterRiwayatTransaksi = $('#FilterRiwayatTransaksi').serialize();
    var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
    $('#TabelRiwayatTransaksi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/TabelRiwayatTransaksi.php',
        data 	    :  FilterRiwayatTransaksi,
        success     : function(data){
            $('#TabelRiwayatTransaksi').html(data);
        }
    });
});
//Menampilkan Expired Date Pertama Kali
var FilterExpiredDate = $('#FilterExpiredDate').serialize();
var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
$('#TabelExpiredDate').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Obat/TabelExpiredDate.php',
    data 	    :  FilterExpiredDate,
    success     : function(data){
        $('#TabelExpiredDate').html(data);
    }
});
//Ketika Proses Pencarian Data Expired
$('#FilterExpiredDate').submit(function(){
    var FilterExpiredDate = $('#FilterExpiredDate').serialize();
    var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
    $('#TabelExpiredDate').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/TabelExpiredDate.php',
        data 	    :  FilterExpiredDate,
        success     : function(data){
            $('#TabelExpiredDate').html(data);
        }
    });
});
//Ketika Keyword By Expired Date Diubah
$('#KeywordByExpiredDate').change(function(){
    var KeywordByExpiredDate = $('#KeywordByExpiredDate').val();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormKeywordExpiredDate.php',
        data 	    :  {KeywordByExpiredDate: KeywordByExpiredDate},
        success     : function(data){
            $('#FormKeywordExpiredDate').html(data);
        }
    });
});
//Modal Tambah Expired
$('#ModalTambahExpiredDate').on('show.bs.modal', function (e) {
    var id_obat = $(e.relatedTarget).data('id');
    $('#FormTambahExpiredDate').load("_Partial/PreLoader.php");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormTambahExpiredDate.php',
        data 	    :  {id_obat: id_obat},
        success     : function(data){
            $('#FormTambahExpiredDate').html(data);
        }
    });
});
//Proses Tambah Expired
$('#ProsesTambahExpiredDate').submit(function(){
    $('#NotifikasiExpiredDate').html('Loading..');
    var form = $('#ProsesTambahExpiredDate')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesTambahExpiredDate.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiExpiredDate').html(data);
            var NotifikasiExpiredDateBerhasil=$('#NotifikasiExpiredDateBerhasil').html();
            if(NotifikasiExpiredDateBerhasil=="Success"){
                //hidden modal
                $('#ProsesTambahExpiredDate')[0].reset();
                $('#ModalTambahExpiredDate').modal('hide');
                var FilterExpiredDate = $('#FilterExpiredDate').serialize();
                var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
                $('#TabelExpiredDate').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Obat/TabelExpiredDate.php',
                    data 	    :  FilterExpiredDate,
                    success     : function(data){
                        $('#TabelExpiredDate').html(data);
                    }
                });
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Expired Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Edit Expired
$('#ModalEditExpiredDate').on('show.bs.modal', function (e) {
    var id_obat_expired = $(e.relatedTarget).data('id');
    $('#FormEditExpiredDate').load("_Partial/PreLoader.php");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormEditExpiredDate.php',
        data 	    :  {id_obat_expired: id_obat_expired},
        success     : function(data){
            $('#FormEditExpiredDate').html(data);
        }
    });
});
//Proses Edit Expired Date
$('#ProsesEditExpiredDate').submit(function(){
    $('#NotifikasiEditExpiredDate').html('Loading..');
    var form = $('#ProsesEditExpiredDate')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesEditExpiredDate.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditExpiredDate').html(data);
            var NotifikasiEditExpiredDateBerhasil=$('#NotifikasiEditExpiredDateBerhasil').html();
            if(NotifikasiEditExpiredDateBerhasil=="Success"){
                //hidden modal
                $('#ProsesEditExpiredDate')[0].reset();
                $('#ModalEditExpiredDate').modal('hide');
                var FilterExpiredDate = $('#FilterExpiredDate').serialize();
                var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
                $('#TabelExpiredDate').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Obat/TabelExpiredDate.php',
                    data 	    :  FilterExpiredDate,
                    success     : function(data){
                        $('#TabelExpiredDate').html(data);
                    }
                });
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Expired Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Proses Hapus Expired Date
$('#ClickHapusExpiredDate').click(function(){
    $('#NotifikasiEditExpiredDate').html('Loading..');
    var form = $('#ProsesEditExpiredDate')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesHapusExpiredDate.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditExpiredDate').html(data);
            var NotifikasiHapusExpiredBerhasil=$('#NotifikasiHapusExpiredBerhasil').html();
            if(NotifikasiHapusExpiredBerhasil=="Success"){
                //hidden modal
                $('#ProsesEditExpiredDate')[0].reset();
                $('#ModalEditExpiredDate').modal('hide');
                var FilterExpiredDate = $('#FilterExpiredDate').serialize();
                var Loading='<div class="card-body"><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></div>';
                $('#TabelExpiredDate').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Obat/TabelExpiredDate.php',
                    data 	    :  FilterExpiredDate,
                    success     : function(data){
                        $('#TabelExpiredDate').html(data);
                    }
                });
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Expired Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Update Obat Parsial
$('#ModalUpdateObatParsial').on('show.bs.modal', function (e) {
    var ProsesGetTabelObat = $('#ProsesGetTabelObat').serialize();
    $('#TabelUpdateObatParsial').html('<tr><td class="text-center" colspan="5"><span class="text-info">Loading...</span></td></tr>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/TabelUpdateObatParsial.php',
        data 	    :  ProsesGetTabelObat,
        success     : function(data){
            $('#TabelUpdateObatParsial').html(data);
        }
    });
});
//ketika aktifkan kategori di click
$('#aktifkan_kategori').click(function() { 
    var aktifkan_kategori=$('#aktifkan_kategori').val();
    if(aktifkan_kategori=="Ya"){
        $('#aktifkan_kategori').val("Tidak");
        $("#KategoriParsial").prop("disabled", false);
    }
    if(aktifkan_kategori!=="Ya"){
        $('#aktifkan_kategori').val("Ya");
        $("#KategoriParsial").prop("disabled", true);
    }
});
//ketika aktifkan kelompok di click
$('#aktifkan_kelompok').click(function() { 
    var aktifkan_kelompok=$('#aktifkan_kelompok').val();
    if(aktifkan_kelompok=="Ya"){
        $('#aktifkan_kelompok').val("Tidak");
        $("#KelompokParsial").prop("disabled", false);
    }
    if(aktifkan_kelompok!=="Ya"){
        $('#aktifkan_kelompok').val("Ya");
        $("#KelompokParsial").prop("disabled", true);
    }
});
//ketika satuan kategori di click
$('#aktifkan_satuan').click(function() { 
    var aktifkan_satuan=$('#aktifkan_satuan').val();
    if(aktifkan_satuan=="Ya"){
        $('#aktifkan_satuan').val("Tidak");
        $("#SatuanParsial").prop("disabled", false);
    }
    if(aktifkan_satuan!=="Ya"){
        $('#aktifkan_satuan').val("Ya");
        $("#SatuanParsial").prop("disabled", true);
    }
});
//ketika stok_minimum di click
$('#aktifkan_stok_minimum').click(function() { 
    var aktifkan_stok_minimum=$('#aktifkan_stok_minimum').val();
    if(aktifkan_stok_minimum=="Ya"){
        $('#aktifkan_stok_minimum').val("Tidak");
        $("#stok_minimum").prop("disabled", false);
    }
    if(aktifkan_stok_minimum!=="Ya"){
        $('#aktifkan_stok_minimum').val("Ya");
        $("#stok_minimum").prop("disabled", true);
    }
});
//ketika ProsesUpdateObatParsial Submit
$('#ProsesUpdateObatParsial').submit(function() { 
    var ProsesUpdateObatParsial = $('#ProsesUpdateObatParsial').serialize();
    $('#TabelUpdateObatParsial').html('<tr><td class="text-center" colspan="5"><span class="text-info">Loading...</span></td></tr>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/ProsesUpdateObatParsial.php',
        data 	    :  ProsesUpdateObatParsial,
        success     : function(data){
            $('#TabelUpdateObatParsial').html(data);
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Obat/TabelObat.php',
                success     : function(data){
                    $('#MenampilkanTabelObat').html(data);
                    $("#ProsesUpdateObatParsial")[0].reset();
                    $("#KategoriParsial").prop("disabled", true);
                    $("#KelompokParsial").prop("disabled", true);
                    $("#SatuanParsial").prop("disabled", true);
                    $("#stok_minimum").prop("disabled", true);
                }
            });
        }
    });
});
//Modal Hapus Obat Parsial
$('#ModalHapusObatParsial').on('show.bs.modal', function (e) {
    var ProsesGetTabelObat = $('#ProsesGetTabelObat').serialize();
    $('#TabelHapusObatParsial').html('<tr><td class="text-center" colspan="6"><span class="text-info">Loading...</span></td></tr>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/TabelHapusObatParsial.php',
        data 	    :  ProsesGetTabelObat,
        success     : function(data){
            $('#TabelHapusObatParsial').html(data);
        }
    });
    //ketika Proses Hapus Submit
    $('#ProsesHapusParsial').submit(function() { 
        var ProsesHapusParsial = $('#ProsesHapusParsial').serialize();
        $('#TabelHapusObatParsial').html('<tr><td class="text-center" colspan="6"><span class="text-info">Loading...</span></td></tr>');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Obat/ProsesHapusParsial.php',
            data 	    :  ProsesHapusParsial,
            success     : function(data){
                $('#TabelHapusObatParsial').html(data);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Obat/TabelObat.php',
                    success     : function(data){
                        $('#MenampilkanTabelObat').html(data);
                        $('#ModalHapusObatParsial').modal('hide');
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Hapus Obat Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        });
    });
});
//Modal Cetak Barcode Obat Parsial
$('#ModalCetakParsial').on('show.bs.modal', function (e) {
    var ProsesGetTabelObat = $('#ProsesGetTabelObat').serialize();
    $('#TabelCetakBarcodeParsial').html('<tr><td class="text-center" colspan="6"><span class="text-info">Loading...</span></td></tr>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/TabelCetakBarcodeParsial.php',
        data 	    :  ProsesGetTabelObat,
        success     : function(data){
            $('#TabelCetakBarcodeParsial').html(data);
        }
    });
});

//Setting Obat
$('#ModalSettingObat').on('show.bs.modal', function (e) {
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormSettingObat').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormSettingObat.php',
        success     : function(data){
            $('#FormSettingObat').html(data);
            $('#FormSettingObat2').load('_Page/Obat/FormSettingObat2.php');
            //select Obat
            $('#SelecObatGroup').change(function(){
                var ObatGroup=$('#SelecObatGroup').val();
                $('#FormSettingObat2').html('Loading...');
                $.ajax({
                    url     : "_Page/Obat/FormSettingObat2.php",
                    method  : "POST",
                    data    :  {ObatGroup: ObatGroup},
                    success : function (data) {
                        $('#FormSettingObat2').html(data);
                        //Proses setting Obat
                        $('#ProsesSettingObat').submit(function(){
                            $('#NotifikasiSettingObat').html(Loading);
                            var ProsesSettingObat = $('#ProsesSettingObat').serialize();
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/Obat/ProsesSettingObat.php',
                                data 	    :  ProsesSettingObat,
                                success     : function(data){
                                    $('#NotifikasiSettingObat').html(data);
                                    var Notifikasi=$('#Notifikasi').html();
                                    if(Notifikasi=="Setting Obat Berhasil"){
                                        $('#TampilkanTabelObat').load("_Page/Obat/TabelObat.php");
                                        $('#FormSettingObat').load('_Page/Obat/NotifikasiSettingObatBerhasil.php');
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
//Export Obat
$('#ModalExportObat').on('show.bs.modal', function (e) {
    $('#FormExportObat').load("_Partial/PreLoader.php");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormExportObat.php',
        success     : function(data){
            $('#FormExportObat').html(data);
            $('#ProsesFilterObat').submit(function(){
                var ProsesFilterObat = $('#ProsesFilterObat').serialize();
                var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
                $('#MenampilkanTabelObat').html(Loading);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Obat/TabelObat.php',
                    data 	    :  ProsesFilterObat,
                    success     : function(data){
                        $('#MenampilkanTabelObat').html(data);
                    }
                });
            });
        }
    });
});
//Export Obat
$('#ModalImportObat').on('show.bs.modal', function (e) {
    $('#FormImportObat').load("_Partial/PreLoader.php");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Obat/FormImportObat.php',
        success     : function(data){
            $('#FormImportObat').html(data);
            $('#ClickTampilkan').click(function(){
                var form = $('#ProsesImportObat')[0];
                var data = new FormData(form);
                $('#TampilkanDataImport').html("<tr><td colspan='6' class='text-center'>Loading...</td></tr>");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Obat/ProsesTampilkanImportt.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#TampilkanDataImport').html(data);
                    }
                });
            });
            $('#ProsesImportObat').submit(function(){
                var form = $('#ProsesImportObat')[0];
                var data = new FormData(form);
                $('#TampilkanDataImport').html("<tr><td colspan='6' class='text-center'>Loading...</td></tr>");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Obat/ProsesImportObat.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#TampilkanDataImport').html(data);
                        $('#ProsesImportObat')[0].reset();
                        $('#NotifikasiImportObat').html('<span class="text-success">KETERANGAN : Import Berhasil!</span>');
                        $('#MenampilkanTabelObat').load("_Page/Obat/TabelObat.php");
                    }
                });
            });
        }
    });
});
