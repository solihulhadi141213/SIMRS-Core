// MONITORING KUNJUNGAN
//Proses Pencarian Monitoring Kunjungan
$('#ProsesPencarianMonitoringKunjungan').submit(function(){
    var ProsesPencarianMonitoringKunjungan = $('#ProsesPencarianMonitoringKunjungan').serialize();
    var Loading='<p><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></p>';
    $('#ListMonitoringKunjungan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MonitoringBaru/ListMonitoringKunjungan.php',
        data 	    :  ProsesPencarianMonitoringKunjungan,
        success     : function(data){
            $('#ListMonitoringKunjungan').html(data);
        }
    });
});
//Menampilkan Detail SEP
$('#ModalDetailSep').on('show.bs.modal', function (e) {
    var sep = $(e.relatedTarget).data('id');
    $('#FormDetailSep').html("Loading...");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/sep/FormDetailSep.php',
        data        : {sep: sep},
        success     : function(data){
            $('#FormDetailSep').html(data);
        }
    });
});

//KLAIM
//Proses Pencarian Klaim
$('#ProsesPencarianMonitoringKlaim').submit(function(){
    var ProsesPencarianMonitoringKlaim = $('#ProsesPencarianMonitoringKlaim').serialize();
    var Loading='<p><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></p>';
    $('#ListMonitoringKlaim').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MonitoringBaru/ListMonitoringKlaim.php',
        data 	    :  ProsesPencarianMonitoringKlaim,
        success     : function(data){
            $('#ListMonitoringKlaim').html(data);
        }
    });
});
//RUJUKAN KELUAR
//Proses Pencarian Rujukan Keluar
$('#ProsesPencarianMonitoringRujukanKeluar').submit(function(){
    var ProsesPencarianMonitoringRujukanKeluar = $('#ProsesPencarianMonitoringRujukanKeluar').serialize();
    var Loading='<p><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></p>';
    $('#ListMonitoringRujukan').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MonitoringBaru/ListMonitoringRujukan.php',
        data 	    :  ProsesPencarianMonitoringRujukanKeluar,
        success     : function(data){
            $('#ListMonitoringRujukan').html(data);
        }
    });
});

// LPK
//Proses Pencarian LPK
$('#ProsesPencarianMonitoringLpk').submit(function(){
    var ProsesPencarianMonitoringLpk = $('#ProsesPencarianMonitoringLpk').serialize();
    var Loading='<p><div class="row"><div class="col col-md-12 text-center">Loading..</div></div></p>';
    $('#ListMonitoringLpk').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/MonitoringBaru/ListMonitoringLpk.php',
        data 	    :  ProsesPencarianMonitoringLpk,
        success     : function(data){
            $('#ListMonitoringLpk').html(data);
        }
    });
});