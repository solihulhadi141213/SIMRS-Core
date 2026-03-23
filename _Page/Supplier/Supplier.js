//Menampilkan Supplier Pertama Kali
var CariFilterSupplier = $('#CariFilterSupplier').serialize();
$('#TabelSupplier').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Supplier/TabelSupplier.php',
    data 	    :  CariFilterSupplier,
    success     : function(data){
        $('#TabelSupplier').html(data);
    }
});
//Ketika Batas Data Diubah
$('#batas').change(function(){
    var CariFilterSupplier = $('#CariFilterSupplier').serialize();
    $('#TabelSupplier').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/TabelSupplier.php',
        data 	    :  CariFilterSupplier,
        success     : function(data){
            $('#TabelSupplier').html(data);
        }
    });
});
//Ketika OrderBy Data Diubah
$('#OrderBy').change(function(){
    var CariFilterSupplier = $('#CariFilterSupplier').serialize();
    $('#TabelSupplier').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/TabelSupplier.php',
        data 	    :  CariFilterSupplier,
        success     : function(data){
            $('#TabelSupplier').html(data);
        }
    });
});
//Ketika ShortBy Data Diubah
$('#ShortBy').change(function(){
    var CariFilterSupplier = $('#CariFilterSupplier').serialize();
    $('#TabelSupplier').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/TabelSupplier.php',
        data 	    :  CariFilterSupplier,
        success     : function(data){
            $('#TabelSupplier').html(data);
        }
    });
});
//Ketika Proses Pencarian Dimulai
$('#CariFilterSupplier').submit(function(){
    $('#page').val('1');
    var CariFilterSupplier = $('#CariFilterSupplier').serialize();
    $('#TabelSupplier').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/TabelSupplier.php',
        data 	    :  CariFilterSupplier,
        success     : function(data){
            $('#TabelSupplier').html(data);
        }
    });
});
//Ketika Modal Tambah Supplier Muncul
$('#ModalTambahSupplier').on('show.bs.modal', function (e) {
    $('#NotifikasiTambahSupplier').html('<span class="text-primary">Pastikan informasi Supplier yang anda input sudah sesuai</span>');
});
//Proses Tambah Supplier
$('#PorosesTambahSupplier').submit(function(){
    $('#NotifikasiTambahSupplier').html('Loading..');
    var form = $('#PorosesTambahSupplier')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/PorosesTambahSupplier.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiTambahSupplier').html(data);
            var NotifikasiTambahSupplierBerhasil=$('#NotifikasiTambahSupplierBerhasil').html();
            if(NotifikasiTambahSupplierBerhasil=="Berhasil"){
                //Mengembalikan halaman ke 1
                $('#page').val("1");
                //Menampilkan data supplier berdasarkan filter
                var CariFilterSupplier = $('#CariFilterSupplier').serialize();
                $('#TabelSupplier').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Supplier/TabelSupplier.php',
                    data 	    :  CariFilterSupplier,
                    success     : function(data){
                        $('#TabelSupplier').html(data);
                    }
                });
                //Reset Form
                $("#PorosesTambahSupplier")[0].reset();
                //Menutup Modal
                $('#ModalTambahSupplier').modal("hide");
                //Menampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Supplier Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Detail Supplier
$('#ModalDetailSupplier').on('show.bs.modal', function (e) {
    var id_supplier = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col-md-12 text-center">Loading..</div></div>';
    $('#FormDetailSupplier').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/FormDetailSupplier.php',
        data 	    :  {id_supplier: id_supplier},
        success     : function(data){
            $('#FormDetailSupplier').html(data);
        }
    });
});
//Modal Edit Supplier
$('#ModalEditSupplier').on('show.bs.modal', function (e) {
    var id_supplier = $(e.relatedTarget).data('id');
    $('#NotifikasiEditSupplier').html('<span class="text-primary">Pastikan informasi Supplier yang anda ubah sudah sesuai</span>');
    var Loading='<div class="row"><div class="col-md-12 text-center">Loading..</div></div>';
    $('#FormEditSupplier').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/FormEditSupplier.php',
        data 	    :  {id_supplier: id_supplier},
        success     : function(data){
            $('#FormEditSupplier').html(data);
        }
    });
});
//Proses Edit Supplier
$('#ProsesEditSupplier').submit(function(){
    $('#NotifikasiEditSupplier').html('Loading..');
    var form = $('#ProsesEditSupplier')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/ProsesEditSupplier.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiEditSupplier').html(data);
            var NotifikasiEditSupplierBerhasil=$('#NotifikasiEditSupplierBerhasil').html();
            if(NotifikasiEditSupplierBerhasil=="Berhasil"){
                //Menampilkan data supplier berdasarkan filter
                var CariFilterSupplier = $('#CariFilterSupplier').serialize();
                $('#TabelSupplier').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Supplier/TabelSupplier.php',
                    data 	    :  CariFilterSupplier,
                    success     : function(data){
                        $('#TabelSupplier').html(data);
                    }
                });
                //Menutup Modal
                $('#ModalEditSupplier').modal("hide");
                //Menampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Supplier Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Supplier
$('#ModalHapusSupplier').on('show.bs.modal', function (e) {
    var id_supplier = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col-md-12 text-center">Loading..</div></div>';
    $('#FormHapusSupplier').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/FormHapusSupplier.php',
        data 	    :  {id_supplier: id_supplier},
        success     : function(data){
            $('#FormHapusSupplier').html(data);
            var GetIdSupplierForDelete =$('#GetIdSupplierForDelete').val();
            if(GetIdSupplierForDelete!=="0"){
                $('#TombolHapusSupplier').prop('disabled', false);
                $('#NotifikasiHapusSupplier').html('<span class="text-primary">Apakah anda yakin akan menghapus supplier tersebut?</span>');
            }else{
                $('#TombolHapusSupplier').prop('disabled', true);
                $('#NotifikasiHapusSupplier').html('');
            }
        }
    });
});
//Proses Hapus Supplier
$('#ProsesHapusSupplier').submit(function(){
    $('#NotifikasiHapusSupplier').html('Loading..');
    var form = $('#ProsesHapusSupplier')[0];
    var data = new FormData(form);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/ProsesHapusSupplier.php',
        data 	    :  data,
        cache       : false,
        processData : false,
        contentType : false,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#NotifikasiHapusSupplier').html(data);
            var NotifikasiHapusSupplierBerhasil=$('#NotifikasiHapusSupplierBerhasil').html();
            if(NotifikasiHapusSupplierBerhasil=="Success"){
                //Menampilkan data supplier berdasarkan filter
                var CariFilterSupplier = $('#CariFilterSupplier').serialize();
                $('#TabelSupplier').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Supplier/TabelSupplier.php',
                    data 	    :  CariFilterSupplier,
                    success     : function(data){
                        $('#TabelSupplier').html(data);
                    }
                });
                //Menutup Modal
                $('#ModalHapusSupplier').modal("hide");
                //Menampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Supplier Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Transaksi Supplier
$('#ModalTransaksiSupplier').on('show.bs.modal', function (e) {
    var id_supplier = $(e.relatedTarget).data('id');
    $('#PutIdSupplierForTransaksi').val(id_supplier);
    var FilterTransaksiSupplier = $('#FilterTransaksiSupplier').serialize();
    $('#TabelTransaksiSupplier').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/TabelTransaksiSupplier.php',
        data 	    :  FilterTransaksiSupplier,
        success     : function(data){
            $('#TabelTransaksiSupplier').html(data);
        }
    });
});
//Proses Pencarian Transaksi Supplier
$('#FilterTransaksiSupplier').submit(function(){
    var FilterTransaksiSupplier = $('#FilterTransaksiSupplier').serialize();
    $('#TabelTransaksiSupplier').html('<div class="row mb-3"><div class="col-md-12 text-center">Loading...</div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Supplier/TabelTransaksiSupplier.php',
        data 	    :  FilterTransaksiSupplier,
        success     : function(data){
            $('#TabelTransaksiSupplier').html(data);
        }
    });
});