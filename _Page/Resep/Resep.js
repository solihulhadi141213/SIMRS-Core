//Menampilkan Data Resep Pertama Kali
var PencarianResep = $('#PencarianResep').serialize();
var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
$('#TabelResep').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Resep/TabelResep.php',
    data 	    :  PencarianResep,
    success     : function(data){
        $('#TabelResep').html(data);
    }
});
//Ketika Batas Data Diubah
$('#batas').change(function(){
    var PencarianResep = $('#PencarianResep').serialize();
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#TabelResep').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Resep/TabelResep.php',
        data 	    :  PencarianResep,
        success     : function(data){
            $('#TabelResep').html(data);
        }
    });
});
//Ketika Mode Pencarian Diubah
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $("#FormKeyword").html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Resep/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//Ketika Pencarian Di Submit
$('#PencarianResep').submit(function(){
    var PencarianResep = $('#PencarianResep').serialize();
    var Loading='<div class="row"><div class="col col-md-12 text-center">Loading..</div></div>';
    $('#TabelResep').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Resep/TabelResep.php',
        data 	    :  PencarianResep,
        success     : function(data){
            $('#TabelResep').html(data);
        }
    });
});
//Ketika Modal Detail Resep Muncul
$('#ModalDetailResep').on('show.bs.modal', function (e) {
    var id_resep = $(e.relatedTarget).data('id');
    $('#FormDetailResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Resep/FormDetailResep.php',
        data        : {id_resep: id_resep},
        success     : function(data){
            $('#FormDetailResep').html(data);
        }
    });
});
//Ketika Modal Detail Pasien Muncul
$('#ModalDetailPasien').on('show.bs.modal', function (e) {
    var id_pasien = $(e.relatedTarget).data('id');
    $('#FormDetailPasien').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailPasien.php',
        data        : {id_pasien: id_pasien},
        success     : function(data){
            $('#FormDetailPasien').html(data);
        }
    });
    $('#TombolDetailPasien').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Resep/TombolDetailPasien.php',
        data        : {id_pasien: id_pasien},
        success     : function(data){
            $('#TombolDetailPasien').html(data);
        }
    });
});
//Ketika Modal Detail Kunjungan Muncul
$('#ModalDetailKunjungan').on('show.bs.modal', function (e) {
    var id_kunjungan = $(e.relatedTarget).data('id');
    $('#FormDetailKunjungan').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/RawatJalan/FormDetailInfoKunjungan.php',
        data        : {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#FormDetailKunjungan').html(data);
        }
    });
    $('#TombolDetailKunjungan').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Resep/TombolDetailKunjungan.php',
        data        : {id_kunjungan: id_kunjungan},
        success     : function(data){
            $('#TombolDetailKunjungan').html(data);
        }
    });
});
//Ketika Modal Cetak Resep Muncul
$('#ModalCetakResep').on('show.bs.modal', function (e) {
    var id_resep = $(e.relatedTarget).data('id');
    $('#FormCetakResep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Resep/FormCetakResep.php',
        data        : {id_resep: id_resep},
        success     : function(data){
            $('#FormCetakResep').html(data);
        }
    });
});
//Ketika Modal Cetak etiket Muncul
$('#ModalCetakEtiket').on('show.bs.modal', function (e) {
    var GetData = $(e.relatedTarget).data('id');
    var pecah = GetData.split(",");
    var id_resep = pecah[0];
    var id = pecah[1];
    $('#FormCetakEtiket').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Resep/FormCetakEtiket.php',
        data        : {id_resep: id_resep, id: id},
        success     : function(data){
            $('#FormCetakEtiket').html(data);
        }
    });
});