//Menampilkan Data Storage Pertama kali
$('#TableObatStorage').load("_Page/ObatStorage/TableObatStorage.php");
//Modal Tambah Storage
$('#ModalTambahStorage').on('show.bs.modal', function (e) {
    $('#FormTambahStorage').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/FormTambahStorage.php',
        success     : function(data){
            $('#FormTambahStorage').html(data);
        }
    });
});
//Proses Tambah Storage
$('#ProsesTambahStorage').submit(function(){
    var ProsesTambahStorage = $('#ProsesTambahStorage').serialize();
    $('#NotifikasiTambahStorage').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ProsesTambahStorage.php',
        data 	    :  ProsesTambahStorage,
        success     : function(data){
            $('#NotifikasiTambahStorage').html(data);
            var NotifikasiTambahStorageBerhasil=$('#NotifikasiTambahStorageBerhasil').html();
            if(NotifikasiTambahStorageBerhasil=="Berhasil"){
                $('#TableObatStorage').load("_Page/ObatStorage/TableObatStorage.php");
                $('#ModalTambahStorage').modal('hide');
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Penyimpanan Obat Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Detail Storage
$('#ModalDetailObatStorage').on('show.bs.modal', function (e) {
    var id_obat_storage = $(e.relatedTarget).data('id');
    $('#FormDetailStorage').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/FormDetailStorage.php',
        data        : {id_obat_storage: id_obat_storage},
        success     : function(data){
            $('#FormDetailStorage').html(data);
        }
    });
});
//Modal Edit Storage
$('#ModalEditObatStorage').on('show.bs.modal', function (e) {
    var id_obat_storage = $(e.relatedTarget).data('id');
    $('#FormEditStorage').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/FormEditStorage.php',
        data        : {id_obat_storage: id_obat_storage},
        success     : function(data){
            $('#FormEditStorage').html(data);
        }
    });
});
//Proses Edit Storage
$('#ProsesEditStorage').submit(function(){
    var ProsesEditStorage = $('#ProsesEditStorage').serialize();
    $('#NotifikasiEditStorage').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ProsesEditStorage.php',
        data 	    :  ProsesEditStorage,
        success     : function(data){
            $('#NotifikasiEditStorage').html(data);
            var NotifikasiEditStorageBerhasil=$('#NotifikasiEditStorageBerhasil').html();
            if(NotifikasiEditStorageBerhasil=="Berhasil"){
                $('#TableObatStorage').load("_Page/ObatStorage/TableObatStorage.php");
                $('#ModalEditObatStorage').modal('hide');
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Penyimpanan Obat Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Storage
$('#ModalHapusObatStorage').on('show.bs.modal', function (e) {
    var id_obat_storage = $(e.relatedTarget).data('id');
    $('#FormHapusStorage').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/FormHapusStorage.php',
        data        : {id_obat_storage: id_obat_storage},
        success     : function(data){
            $('#FormHapusStorage').html(data);
        }
    });
});
//Proses Hapus Storage
$('#ProsesHapusStorageObat').submit(function(){
    var ProsesHapusStorageObat = $('#ProsesHapusStorageObat').serialize();
    $('#NotifikasiHapusStorage').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ProsesHapusStorage.php',
        data        : ProsesHapusStorageObat,
        success     : function(data){
            $('#NotifikasiHapusStorage').html(data);
            var NotifikasiHapusStorageBerhasil=$('#NotifikasiHapusStorageBerhasil').html();
            if(NotifikasiHapusStorageBerhasil=="Berhasil"){
                $('#TableObatStorage').load("_Page/ObatStorage/TableObatStorage.php");
                $('#ModalHapusObatStorage').modal('hide');
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Penyimpanan Obat Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Menampilkan List Data Obat Yang Ada Dalam Storage
var ProsesBatasObatOnPosisi = $('#ProsesBatasObatOnPosisi').serialize();
$('#TabelListObatOnPosisi').html('<div class="card-body text-center text-danger">Loading</div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/ObatStorage/TabelListObatOnPosisi.php',
    data        : ProsesBatasObatOnPosisi,
    success     : function(data){
        $('#TabelListObatOnPosisi').html(data);
    }
});
//Ketika proses Pencarian Obat Pada Storage Dilakukan
$('#ProsesBatasObatOnPosisi').submit(function(){
    var ProsesBatasObatOnPosisi = $('#ProsesBatasObatOnPosisi').serialize();
    $('#TabelListObatOnPosisi').html('<div class="card-body text-center text-danger">Loading</div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/TabelListObatOnPosisi.php',
        data        : ProsesBatasObatOnPosisi,
        success     : function(data){
            $('#TabelListObatOnPosisi').html(data);
        }
    });
});
//Modal Cari Obat For Alokasi
$('#ModalAlokasiItem').on('show.bs.modal', function (e) {
    var id_obat_storage = $(e.relatedTarget).data('id');
    $('#IdObatStorage').val(id_obat_storage);
    var ProsesCariObatUntukAlokasi = $('#ProsesCariObatUntukAlokasi').serialize();
    $('#ListObatUntukAlokasi').html('<div class="row"><div class="col-md-12 text-center text-danger">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ListObatUntukAlokasi.php',
        data        : ProsesCariObatUntukAlokasi,
        success     : function(data){
            $('#ListObatUntukAlokasi').html(data);
        }
    });
});
//Proses Cari Obat For Alokasi
$('#ProsesCariObatUntukAlokasi').submit(function(){
    var ProsesCariObatUntukAlokasi = $('#ProsesCariObatUntukAlokasi').serialize();
    $('#ListObatUntukAlokasi').html('<div class="row"><div class="col-md-12 text-center text-danger">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ListObatUntukAlokasi.php',
        data        : ProsesCariObatUntukAlokasi,
        success     : function(data){
            $('#ListObatUntukAlokasi').html(data);
        }
    });
});
//Proses Tambah Alokasi
$('#ProsesAlokasiObat').submit(function(){
    var ProsesAlokasiObat = $('#ProsesAlokasiObat').serialize();
    $('#NotifikasiAlokasi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ProsesAlokasiObat.php',
        data        : ProsesAlokasiObat,
        success     : function(data){
            $('#NotifikasiAlokasi').html(data);
            var NotifikasiAlokasiBerhasil = $('#NotifikasiAlokasiBerhasil').html();
            var UrlBack = $('#UrlBackAlokasi').val();
            if(NotifikasiAlokasiBerhasil=="Success"){
                window.location.href=UrlBack;
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
        url 	    : '_Page/ObatStorage/FormPosisiObat.php',
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
        url 	    : '_Page/ObatStorage/ProsesPosisiObat.php',
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
                var ProsesBatasObatOnPosisi = $('#ProsesBatasObatOnPosisi').serialize();
                $('#TabelListObatOnPosisi').html('<div class="card-body text-center text-danger">Loading</div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/ObatStorage/TabelListObatOnPosisi.php',
                    data        : ProsesBatasObatOnPosisi,
                    success     : function(data){
                        $('#TabelListObatOnPosisi').html(data);
                    }
                });
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Update Posisi Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Hapus Posisi Obat
$('#ClickHapusPosisiObat').click(function(){
    $('#NotifikasiPosisiObat').html('Loading..');
    var form = $('#ProsesPosisiObat')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ProsesHapusPosisiObat.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiPosisiObat').html(data);
            var NotifikasiHapusPosisiObatBerhasil=$('#NotifikasiHapusPosisiObatBerhasil').html();
            if(NotifikasiHapusPosisiObatBerhasil=="Success"){
                //hidden modal
                $('#ProsesPosisiObat')[0].reset();
                $('#ModalPosisiObat').modal('hide');
                var ProsesBatasObatOnPosisi = $('#ProsesBatasObatOnPosisi').serialize();
                $('#TabelListObatOnPosisi').html('<div class="card-body text-center text-danger">Loading</div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/ObatStorage/TabelListObatOnPosisi.php',
                    data        : ProsesBatasObatOnPosisi,
                    success     : function(data){
                        $('#TabelListObatOnPosisi').html(data);
                    }
                });
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Posisi Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});

//TRANSFER
//Menampilkan Tabel Transfer Pertama Kali
var ProsesPencarianRiwayatTransfer=$('#ProsesPencarianRiwayatTransfer').serialize();
$('#TabelTransfer').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/ObatStorage/TabelTransfer.php',
    data        : ProsesPencarianRiwayatTransfer,
    success     : function(data){
        $('#TabelTransfer').html(data);
    }
});
//ketika Dilakukan proses Pencarian Transfer
$('#ProsesPencarianRiwayatTransfer').submit(function(){
    var ProsesPencarianRiwayatTransfer=$('#ProsesPencarianRiwayatTransfer').serialize();
    $('#TabelTransfer').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/TabelTransfer.php',
        data        : ProsesPencarianRiwayatTransfer,
        success     : function(data){
            $('#TabelTransfer').html(data);
        }
    });
});
//Ketika Nilai Batas Data Diubah
$('#BatasTransfer').change(function(){
    var ProsesPencarianRiwayatTransfer=$('#ProsesPencarianRiwayatTransfer').serialize();
    $('#TabelTransfer').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/TabelTransfer.php',
        data        : ProsesPencarianRiwayatTransfer,
        success     : function(data){
            $('#TabelTransfer').html(data);
        }
    });
});
//Ketika Keyword By Transfer Diubah
$('#KeywordByTransfer').change(function(){
    var KeywordByTransfer=$('#KeywordByTransfer').val();
    if(KeywordByTransfer=="tanggal"){
        $("#KeywordTransfer").prop("type", "date");
    }else{
        $("#KeywordTransfer").prop("type", "text");
    }
});
//Modal Detail Transfer
$('#ModalDetailTransfer').on('show.bs.modal', function (e) {
    var id_obat_transfer_alokasi=$(e.relatedTarget).data('id');
    $('#FormDetailTransfer').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/FormDetailTransfer.php',
        data 	    :  {id_obat_transfer_alokasi: id_obat_transfer_alokasi},
        success     : function(data){
            $('#FormDetailTransfer').html(data);
        }
    });
});
//Modal Hapus Transfer
$('#ModalHapusTransfer').on('show.bs.modal', function (e) {
    var id_obat_transfer_alokasi=$(e.relatedTarget).data('id');
    $('#FormHapusTransfer').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/FormHapusTransfer.php',
        data 	    :  {id_obat_transfer_alokasi: id_obat_transfer_alokasi},
        success     : function(data){
            $('#FormHapusTransfer').html(data);
            $('#NotifikasiHapusTransfer').html('<span class="text-dark">Apakah Anda Yakin Ingin Menghapus Data Ini?</span>');
        }
    });
});
//Proses Hapus Data Transfer
$('#ProsesHapusTransfer').submit(function(){
    var ProsesHapusTransfer=$('#ProsesHapusTransfer').serialize();
    $('#NotifikasiHapusTransfer').html('<span class="text-dark">Loading...</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ProsesHapusTransfer.php',
        data        : ProsesHapusTransfer,
        success     : function(data){
            $('#NotifikasiHapusTransfer').html(data);
            var NotifikasiHapusTransferBerhasil=$('#NotifikasiHapusTransferBerhasil').html();
            if(NotifikasiHapusTransferBerhasil=="Success"){
                //Apabila Berhasil, Tampilkan Data Berdasarkan Pencarian
                var ProsesPencarianRiwayatTransfer=$('#ProsesPencarianRiwayatTransfer').serialize();
                $('#TabelTransfer').html('<div class="row"><div class="col-md-12 text-center">Loading...</div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/ObatStorage/TabelTransfer.php',
                    data        : ProsesPencarianRiwayatTransfer,
                    success     : function(data){
                        $('#TabelTransfer').html(data);
                    }
                });
                //Tutup Modal
                $('#ModalHapusTransfer').modal('hide');
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Data Transfer Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Konfirmasi Edit Transfer
$('#ModalKonfirmasiEditTransfer').on('show.bs.modal', function (e) {
    var id_obat_transfer_alokasi=$(e.relatedTarget).data('id');
    $('#FormKonfirmasiEditTransfer').html('<div class="modal-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/FormKonfirmasiEditTransfer.php',
        data 	    :  {id_obat_transfer_alokasi: id_obat_transfer_alokasi},
        success     : function(data){
            $('#FormKonfirmasiEditTransfer').html(data);
        }
    });
});
//ketika tempat penyimpanan asal diubah
$('#id_obat_storage1').change(function(){
    var id_obat_storage1=$('#id_obat_storage1').val();
    $('#id_obat_storage2').html('<option value="">Pilih</option>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ListStorage.php',
        data        : {id_obat_storage1: id_obat_storage1},
        success     : function(data){
            $('#id_obat_storage2').html(data);
        }
    });
    $('#id_obat').html('<option value="">Pilih</option>');
});
//Ketika memilih item obat
$('#ModalPilihObatUntukTransfer').on('show.bs.modal', function (e) {
    var id_obat_storage1=$('#id_obat_storage1').val();
    //terapkan kedalam form
    $('#PutIdObatStorage').val(id_obat_storage1);
    var ProsesCariObatUntukTransfer = $('#ProsesCariObatUntukTransfer').serialize();
    $('#ListObatUntukTransfer').load("_Partial/PreLoader.php");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ListObatUntukTransfer.php',
        data 	    :  ProsesCariObatUntukTransfer,
        success     : function(data){
            $('#ListObatUntukTransfer').html(data);
        }
    });
});
//Pencarian Obat Untuk Transfer
$('#ProsesCariObatUntukTransfer').submit(function(){
    var ProsesCariObatUntukTransfer = $('#ProsesCariObatUntukTransfer').serialize();
    $('#ListObatUntukTransfer').load("_Partial/PreLoader.php");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ListObatUntukTransfer.php',
        data 	    :  ProsesCariObatUntukTransfer,
        success     : function(data){
            $('#ListObatUntukTransfer').html(data);
        }
    });
});
//Proses Transfer
$('#ProsesTransfer').submit(function(){
    var ProsesTransfer = $('#ProsesTransfer').serialize();
    $('#NotifikasiTransfer').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ProsesTransfer.php',
        data        : ProsesTransfer,
        success     : function(data){
            $('#NotifikasiTransfer').html(data);
            var NotifikasiTransferBerhasil = $('#NotifikasiTransferBerhasil').html();
            if(NotifikasiTransferBerhasil=="Success"){
                window.location.href='index.php?Page=ObatStorage';
            }
        }
    });
});
//Proses Edit Transfer
$('#ProsesEditTransfer').submit(function(){
    var ProsesEditTransfer = $('#ProsesEditTransfer').serialize();
    $('#NotifikasiEditTransfer').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ObatStorage/ProsesEditTransfer.php',
        data        : ProsesEditTransfer,
        success     : function(data){
            $('#NotifikasiEditTransfer').html(data);
            var NotifikasiEditTransferBerhasil = $('#NotifikasiEditTransferBerhasil').html();
            if(NotifikasiEditTransferBerhasil=="Success"){
                window.location.href='index.php?Page=ObatStorage';
            }
        }
    });
});
//DETAIL STORAGE
//Menampilkan Histori Transfer Pertama Kali
var ProsesBatasTransfer = $('#ProsesBatasTransfer').serialize();
$('#ListHistoriTransfer').html('<div class="card-body text-center text-danger">Loading</div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/ObatStorage/ListHistoriTransfer.php',
    data        : ProsesBatasTransfer,
    success     : function(data){
        $('#ListHistoriTransfer').html(data);
    }
});