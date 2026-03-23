var NamaData="Web Monitoring";
var FormMonitoring = $('#FormMonitoring').serialize();
var GetPeriode = $('#periode').val();
var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
$('#TampilkanGrafik').html('Loading...');
$('#TampilkanTabel').html(Loading);
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebMonitoring/TampilkanGrafik.php',
    data 	    :  FormMonitoring,
    enctype     : 'multipart/form-data',
    success     : function(data){
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
        
        var chart = new ApexCharts(
            document.querySelector("#TampilkanGrafik"),
            options
        );
        if(GetPeriode=="Bulanan"){
            var UrlData = '_Page/WebMonitoring/WebMonitoringBulanan.json';
        }else{
            var UrlData = '_Page/WebMonitoring/WebMonitoringTahunan.json';
        }
       
        $.getJSON(UrlData, function(response) {
            chart.updateSeries([{
                name: NamaData,
                data: response
            }])
        });
        chart.render();
    }
});
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/WebMonitoring/TampilkanTabel.php',
    data 	    :  FormMonitoring,
    success     : function(data){
        $('#TampilkanTabel').html(data);
    }
});
//Batas dan Pencarian
$('#periode').change(function(){
    var periode = $('#periode').val();
    if(periode=="Bulanan"){
        $('#FormBulan').html('Loading...');
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/WebMonitoring/FormBulan.php',
            data 	    :  {periode: periode},
            success     : function(data){
                $('#FormBulan').html(data);
            }
        });
    }else{
        $('#FormBulan').html('Loading...');
        $('#FormBulan').html('');
    }
});
//Pencarian
$('#TombolTampilkan').click(function(){
    var FormMonitoring = $('#FormMonitoring').serialize();
    var GetPeriode = $('#periode').val();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#TampilkanTabel').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebMonitoring/TampilkanTabel.php',
        data 	    :  FormMonitoring,
        success     : function(data){
            $('#TampilkanTabel').html(data);
        }
    });
    $('#TampilkanGrafik').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/WebMonitoring/TampilkanGrafik.php',
        data 	    :  FormMonitoring,
        enctype     : 'multipart/form-data',
        success     : function(data){
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
            
            var chart = new ApexCharts(
                document.querySelector("#TampilkanGrafik"),
                options
            );
            if(GetPeriode=="Bulanan"){
                var UrlData = '_Page/WebMonitoring/WebMonitoringBulanan.json';
            }else{
                var UrlData = '_Page/WebMonitoring/WebMonitoringTahunan.json';
            }
            $.getJSON(UrlData, function(response) {
                chart.updateSeries([{
                    name: NamaData,
                    data: response
                }])
            });
            chart.render();
        }
    });
});


// var options = {
//     chart: {
//         type: 'line'
//     },
//     title: {
//         text: NamaData2,
//     },
//     series: [{
//         name: 'sales',
//         data: [30,40,35,50,49,60,70,91,125]
//     }],
//         xaxis: {
//         categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
//     }
// }
// var chart = new ApexCharts(document.querySelector("#chart"), options);
// chart.render();