$('#MenampilkanDataMonitoring').load("_Page/Monitoring/DataKunjungan.php");
$('#TabKunjungan').click(function(){
    $('#TitleCard').html("Monitoring Kunjungan");
    $('#MenampilkanDataMonitoring').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Monitoring/DataKunjungan.php',
        success     : function(data){
            $('#MenampilkanDataMonitoring').html(data);
            //Inisiasi Tombol
            $('#TabKunjungan').removeClass('btn-primary');
            $('#TabKunjungan').addClass('btn-inverse');
            $('#TabKlaim').removeClass('btn-inverse');
            $('#TabKlaim').addClass('btn-primary');
            $('#TabPelayananPeserta').removeClass('btn-inverse');
            $('#TabPelayananPeserta').addClass('btn-primary');
            $('#TabJasaRaharja').removeClass('btn-inverse');
            $('#TabJasaRaharja').addClass('btn-primary');
            
        }
    });
});
$('#TabKlaim').click(function(){
    $('#TitleCard').html("Data Klaim");
    $('#MenampilkanDataMonitoring').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Monitoring/DataKlaim.php',
        success     : function(data){
            $('#MenampilkanDataMonitoring').html(data);
            //Inisiasi Tombol
            $('#TabKunjungan').removeClass('btn-inverse');
            $('#TabKunjungan').addClass('btn-primary');
            $('#TabKlaim').removeClass('btn-primary');
            $('#TabKlaim').addClass('btn-inverse');
            $('#TabPelayananPeserta').removeClass('btn-inverse');
            $('#TabPelayananPeserta').addClass('btn-primary');
            $('#TabJasaRaharja').removeClass('btn-inverse');
            $('#TabJasaRaharja').addClass('btn-primary');
            
        }
    });
});
$('#TabPelayananPeserta').click(function(){
    $('#TitleCard').html("Pelayanan Peserta");
    $('#MenampilkanDataMonitoring').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Monitoring/DataPelayananPeserta.php',
        success     : function(data){
            $('#MenampilkanDataMonitoring').html(data);
            //Inisiasi Tombol
            $('#TabKunjungan').removeClass('btn-inverse');
            $('#TabKunjungan').addClass('btn-primary');
            $('#TabKlaim').removeClass('btn-inverse');
            $('#TabKlaim').addClass('btn-primary');
            $('#TabPelayananPeserta').removeClass('btn-primary');
            $('#TabPelayananPeserta').addClass('btn-inverse');
            $('#TabJasaRaharja').removeClass('btn-inverse');
            $('#TabJasaRaharja').addClass('btn-primary');
            
        }
    });
});
$('#TabJasaRaharja').click(function(){
    $('#TitleCard').html("Jasa Raharja");
    $('#MenampilkanDataMonitoring').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Monitoring/DataJasaRaharja.php',
        success     : function(data){
            $('#MenampilkanDataMonitoring').html(data);
            //Inisiasi Tombol
            $('#TabKunjungan').removeClass('btn-inverse');
            $('#TabKunjungan').addClass('btn-primary');
            $('#TabKlaim').removeClass('btn-inverse');
            $('#TabKlaim').addClass('btn-primary');
            $('#TabPelayananPeserta').removeClass('btn-inverse');
            $('#TabPelayananPeserta').addClass('btn-primary');
            $('#TabJasaRaharja').removeClass('btn-primary');
            $('#TabJasaRaharja').addClass('btn-inverse');
            
        }
    });
});
