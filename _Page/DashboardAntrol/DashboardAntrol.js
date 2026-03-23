//Menampilkan data dasboard pertama kali
var ProsesDashboardAntrianOnline = $('#ProsesDashboardAntrianOnline').serialize();
$('#HasilDashboardAntrian').html('Loading..');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/DashboardAntrol/DashboardAntrianOnline.php',
    data 	    :  ProsesDashboardAntrianOnline,
    success     : function(data){
        $('#HasilDashboardAntrian').html(data);
    }
});
//Ketika Mode Diubah
$('#mode').change(function(){
    var mode=$('#mode').val();
    $('#FormLanjutan').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/DashboardAntrol/FormLanjutan.php',
        data 	    :  {mode: mode},
        success     : function(data){
            $('#FormLanjutan').html(data);
        }
    });
});
$('#ProsesDashboardAntrianOnline').submit(function(){
    var ProsesDashboardAntrianOnline = $('#ProsesDashboardAntrianOnline').serialize();
    $('#HasilDashboardAntrian').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/DashboardAntrol/DashboardAntrianOnline.php',
        data 	    :  ProsesDashboardAntrianOnline,
        success     : function(data){
            $('#HasilDashboardAntrian').html(data);
        }
    });
});