//Menampilkan Data Laporan Pengguna Pertama kali
var ProsesPencarianLaporanPengguna = $('#ProsesPencarianLaporanPengguna').serialize();
$('#TabelLaporanPengguna').html('<div class="card-body text-center text-danger">Loading</div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/LaporanPengguna/TabelLaporanPengguna.php',
    data        : ProsesPencarianLaporanPengguna,
    success     : function(data){
        $('#TabelLaporanPengguna').html(data);
    }
});
//Kondisi Ketika Batas Diubah
$('#BatasData').change(function(){
    var ProsesPencarianLaporanPengguna = $('#ProsesPencarianLaporanPengguna').serialize();
    $('#TabelLaporanPengguna').html('<div class="card-body text-center text-danger">Loading</div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/LaporanPengguna/TabelLaporanPengguna.php',
        data        : ProsesPencarianLaporanPengguna,
        success     : function(data){
            $('#TabelLaporanPengguna').html(data);
        }
    });
});
//Kondisi Ketika Dilakukan Proses Pencarian
$('#ProsesPencarianLaporanPengguna').submit(function(){
    var ProsesPencarianLaporanPengguna = $('#ProsesPencarianLaporanPengguna').serialize();
    $('#TabelLaporanPengguna').html('<div class="card-body text-center text-danger">Loading</div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/LaporanPengguna/TabelLaporanPengguna.php',
        data        : ProsesPencarianLaporanPengguna,
        success     : function(data){
            $('#TabelLaporanPengguna').html(data);
        }
    });
});
//Kondisi Ketika Keyword By Diubah
$('#KeywordBy').change(function(){
    var KeywordBy = $('#KeywordBy').val();
    if(KeywordBy=="tanggal"){
        $("#Keyword").attr("type", "date");
    }else{
        $("#Keyword").attr("type", "text");
    }
});
//Kondisi Ketika Modal Detail Laporan Pengguna Muncul
$('#ModalDetailLaporanPengguna').on('show.bs.modal', function (e) {
    var id_laporan_pengguna = $(e.relatedTarget).data('id');
    $('#FormDetailLaporanPengguna').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/LaporanPengguna/FormDetailLaporanPengguna.php',
        data        : {id_laporan_pengguna: id_laporan_pengguna},
        success     : function(data){
            $('#FormDetailLaporanPengguna').html(data);
        }
    });
});
//Kondisi Ketika Modal Kirim Response Muncul
$('#ModalKirimResponse').on('show.bs.modal', function (e) {
    var id_laporan_pengguna = $(e.relatedTarget).data('id');
    $('#FormKirimResponse').html('Loading...');
    $('#NotifikasiKirimResponse').html('Loading...');
    $('#NotifikasiKirimResponse').html('<span class="text-primary">Pastikan pesan response yang ingin anda kirim sudah sesuai.</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/LaporanPengguna/FormKirimResponse.php',
        data        : {id_laporan_pengguna: id_laporan_pengguna},
        success     : function(data){
            $('#FormKirimResponse').html(data);
        }
    });
});
//Kondisi Ketika Proses Kirim Response
$('#ProsesKirimResponse').submit(function(){
    var ProsesKirimResponse = $('#ProsesKirimResponse').serialize();
    $('#NotifikasiKirimResponse').html('<span class="text-primary">Loading...</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/LaporanPengguna/ProsesKirimResponse.php',
        data        : ProsesKirimResponse,
        success     : function(data){
            $('#NotifikasiKirimResponse').html(data);
            var NotifikasiKirimResponseBerhasil = $('#NotifikasiKirimResponseBerhasil').html();
            if(NotifikasiKirimResponseBerhasil=="Success"){
                //Tutup Modal
                $('#ModalKirimResponse').modal('hide');
                //Reload Data
                var ProsesPencarianLaporanPengguna = $('#ProsesPencarianLaporanPengguna').serialize();
                $('#TabelLaporanPengguna').html('<div class="card-body text-center text-danger">Loading</div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/LaporanPengguna/TabelLaporanPengguna.php',
                    data        : ProsesPencarianLaporanPengguna,
                    success     : function(data){
                        $('#TabelLaporanPengguna').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Kirim Response Laporan Pengguna Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});