//Menampilkan KFA Pertama Kali
var FilterKfa=$('#FilterKfa').serialize();
$('#TabelKfa').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Kfa/TabelKfa.php',
    data 	    :  FilterKfa,
    enctype     : 'multipart/form-data',
    success     : function(data){
        $('#TabelKfa').html(data);
    }
});
$('#FilterKfa').submit(function(){
    var FilterKfa=$('#FilterKfa').serialize();
    $('#TabelKfa').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Kfa/TabelKfa.php',
        data 	    :  FilterKfa,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#TabelKfa').html(data);
            $('#ModalFilterKfa').modal('hide');
        }
    });
});
$('#ReloadKfa').click(function(){
    var FilterKfa=$('#FilterKfa').serialize();
    $('#TabelKfa').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Kfa/TabelKfa.php',
        data 	    :  FilterKfa,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#TabelKfa').html(data);
            $('#ModalFilterKfa').modal('hide');
        }
    });
});
//Modal Detail Kfa
$('#ModalDetailKfa').on('show.bs.modal', function (e) {
    var kfa_code = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormDetailKfa').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Kfa/FormDetailKfa.php',
        data 	    :  {kfa_code: kfa_code},
        success     : function(data){
            $('#FormDetailKfa').html(data);
        }
    });
});
//Modal Harga Kfa
$('#ModalHargaKfa').on('show.bs.modal', function (e) {
    var kfa_code = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormHargaKfa').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Kfa/FormHargaKfa.php',
        data 	    :  {kfa_code: kfa_code},
        success     : function(data){
            $('#FormHargaKfa').html(data);
        }
    });
});

//WILAYAH
//Menampilkan Wilayah Pertama Kali
$('#TabelWilayah').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Kfa/TabelWilayah.php',
    enctype     : 'multipart/form-data',
    success     : function(data){
        $('#TabelWilayah').html(data);
    }
});
$('#ReloadWilayah').click(function(){
    $('#TabelWilayah').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Kfa/TabelWilayah.php',
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#TabelWilayah').html(data);
        }
    });
});
//Menampilkan MSI Pertama Kali
var FilterMsi=$('#FilterMsi').serialize();
$('#TabelMsi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Kfa/TabelMsi.php',
    data 	    :  FilterMsi,
    enctype     : 'multipart/form-data',
    success     : function(data){
        $('#TabelMsi').html(data);
    }
});
$('#FilterMsi').submit(function(){
    var FilterMsi=$('#FilterMsi').serialize();
    $('#TabelMsi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Kfa/TabelMsi.php',
        data 	    :  FilterMsi,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#TabelMsi').html(data);
            $('#ModalFilterMsi').modal('hide');
        }
    });
});
$('#ReloadMsi').click(function(){
    var FilterMsi=$('#FilterMsi').serialize();
    $('#TabelMsi').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center">Loading...</div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Kfa/TabelMsi.php',
        data 	    :  FilterMsi,
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#TabelMsi').html(data);
        }
    });
});
//Modal Filter MSI muncul
$('#ModalFilterMsi').on('show.bs.modal', function (e) {
    $('#kode_provinsi').html('<option>Loading..</option>>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Kfa/ListProvinsi.php',
        success     : function(data){
            $('#kode_provinsi').html(data);
        }
    });
});
$('#kode_provinsi').change(function(){
    var kode_provinsi=$('#kode_provinsi').val();
    $('#kode_kabkota').html('<option>Loading..</option>>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Kfa/ListKabupaten.php',
        data 	    :  {kode_provinsi: kode_provinsi},
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#kode_kabkota').html(data);
        }
    });
});
$('#kode_kabkota').change(function(){
    var kode_kabkota=$('#kode_kabkota').val();
    $('#kode_kecamatan').html('<option>Loading..</option>>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Kfa/ListKecamatan.php',
        data 	    :  {kode_kabkota: kode_kabkota},
        enctype     : 'multipart/form-data',
        success     : function(data){
            $('#kode_kecamatan').html(data);
        }
    });
});
//Modal Detail MSI
$('#ModalDetailMsi').on('show.bs.modal', function (e) {
    var kode_sarana = $(e.relatedTarget).data('id');
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#FormDetailMsi').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Kfa/FormDetailMsi.php',
        data 	    :  {kode_sarana: kode_sarana},
        success     : function(data){
            $('#FormDetailMsi').html(data);
        }
    });
});