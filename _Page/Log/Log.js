$('#MenampilkanTabelLog').load("_Page/Log/TabelLog.php");
//Batas dan Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Log/TabelLog.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelLog').html(data);
        }
    });
});
//Ketika batas data diubah
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Log/TabelLog.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelLog').html(data);
        }
    });
});
//Ketika dasar pencarian diubah
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    if(keyword_by=="waktu"){
        $('#keyword').attr('type', 'date');
        $('#ListKeyword').html();
    }else{
        $('#keyword').attr('type', 'text');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Log/ListKeyword.php',
            data 	    :  {keyword_by: keyword_by},
            success     : function(data){
                $('#ListKeyword').html(data);
            }
        });
    }
});
$('#ProsesFilterUser').submit(function(){
    var ProsesFilterUser = $('#ProsesFilterUser').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelLog').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Log/CariUser.php',
        data 	    :  ProsesFilterUser,
        success     : function(data){
            $('#HasilCariUser').html(data);
            var HasilCariUser=$('#HasilCariUser2').html();
            $.ajax({
                type 	    : 'POST',
                url 	    : '_Page/Log/TabelLog.php',
                data 	    :  {id_akses: HasilCariUser},
                success     : function(data){
                    $('#MenampilkanTabelLog').html(data);
                    $('#ModalUser').modal('hide');
                }
            });
        }
    });
});
$('#ProsesFilterTanggal').submit(function(){
    var ProsesFilterTanggal = $('#ProsesFilterTanggal').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelLog').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Log/TabelLog.php',
        data 	    :  ProsesFilterTanggal,
        success     : function(data){
            $('#MenampilkanTabelLog').html(data);
        }
    });
});
$('#ProsesFilterKategori').submit(function(){
    var ProsesFilterKategori = $('#ProsesFilterKategori').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelLog').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Log/TabelLog.php',
        data 	    :  ProsesFilterKategori,
        success     : function(data){
            $('#MenampilkanTabelLog').html(data);
        }
    });
});
$('#ProsesFilterNamaLog').submit(function(){
    var ProsesFilterNamaLog = $('#ProsesFilterNamaLog').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelLog').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Log/TabelLog.php',
        data 	    :  ProsesFilterNamaLog,
        success     : function(data){
            $('#MenampilkanTabelLog').html(data);
        }
    });
});
//Fiter Tabel
$('#ModalFilterTabel').on('show.bs.modal', function (e) {
    var ColomName = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormFilterTabel').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Log/FormFilterTabel.php',
        data 	    :  {ColomName: ColomName},
        success     : function(data){
            $('#FormFilterTabel').html(data);
            $('#ProsesFilterTabel').submit(function(){
                var batas = $('#batas').val();
                var keyword_by = $('#keyword_by').val();
                var keyword = $('#keyword_short').val();
                var ShortBy = $('#ShortBy').val();
                $('#MenampilkanTabelLog').html('Loading..');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/Log/TabelLog.php',
                    data 	    :  {batas: batas, keyword_by: keyword_by, keyword: keyword, ShortBy: ShortBy},
                    success     : function(data){
                        $('#MenampilkanTabelLog').html(data);
                    }
                });
            });
        }
    });
});

var NamaData="Grafik Log Aktivitas";
var options = {
    chart: {
        height: 400,
        type: 'bar',
    },
    dataLabels: {
        enabled: false
    },
    series: [],
    title: {
        text: NamaData,
    },
    noData: {
        text: 'Loading...'
    }
}
var chart = new ApexCharts(document.querySelector("#GrafikAktivitas"), options);
chart.render();
window.setInterval(function () {
    var UrlData = '_Page/Log/Log.json';
    $.getJSON(UrlData, function(response) {
        chart.updateSeries([{
            name: NamaData,
            data: response
        }])
    });
}, 5000)