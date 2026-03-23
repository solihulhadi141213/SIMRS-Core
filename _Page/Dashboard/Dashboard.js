//Default Grafik
var NamaData="Grafik Kunjungan Pasien";
var KategoriGrafik = $('#KategoriGrafik').val();
var GetTahun = $('#tahun').val();
var GetBulan = $('#bulan').val();
$('#GrafikPasien').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Dashboard/GrafikDashboard.php',
    data 	    :  {KategoriGrafik: KategoriGrafik, GetTahun: GetTahun, GetBulan: GetBulan},
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
            document.querySelector("#GrafikPasien"),
            options
        );
        var UrlData = '_Page/Dashboard/GrafikDashboard.json';
        $.getJSON(UrlData, function(response) {
            chart.updateSeries([{
                name: NamaData,
                data: response
            }])
        });
        chart.render();
    }
});
//Keterangan Koneksi Satu Sehat
$('#KoneksiSatuSehat').html('Loading..');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Dashboard/StatusKoneksi.php',
    data 	    :  {KategoriKoneksi: 'Satu Sehat'},
    success     : function(data){
        $('#KoneksiSatuSehat').html(data);
    }
});
//Keterangan Koneksi BPJS
$('#KoneksiBridging').html('Loading..');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Dashboard/StatusKoneksi.php',
    data 	    :  {KategoriKoneksi: 'Bridging BPJS'},
    success     : function(data){
        $('#KoneksiBridging').html(data);
    }
});
//Keterangan Koneksi Website
$('#KoneksiWebsite').html('Loading..');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/Dashboard/StatusKoneksi.php',
    data 	    :  {KategoriKoneksi: 'Website'},
    success     : function(data){
        $('#KoneksiWebsite').html(data);
    }
});
//Kondisi Ketika Reload Koneksi
$("#ReloadConnection").click(function(){
    $('#KoneksiWebsite').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dashboard/StatusKoneksi.php',
        data 	    :  {KategoriKoneksi: 'Website'},
        success     : function(data){
            $('#KoneksiWebsite').html(data);
        }
    });
    $('#KoneksiBridging').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dashboard/StatusKoneksi.php',
        data 	    :  {KategoriKoneksi: 'Bridging BPJS'},
        success     : function(data){
            $('#KoneksiBridging').html(data);
        }
    });
    $('#KoneksiSatuSehat').html('Loading..');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Dashboard/StatusKoneksi.php',
        data 	    :  {KategoriKoneksi: 'Satu Sehat'},
        success     : function(data){
            $('#KoneksiSatuSehat').html(data);
        }
    });
});
//Kondisi Ketika Search Muncul Di Atas
$("#PencarianBantuanAtas").click(function(){
    $('#KeywordBantuan').focus();
});

// Konfigurasi Driver.js
const driver = window.driver.js.driver;
const driverObj = driver();
$("#PetunjukGrafik").click(function(){
    driverObj.highlight(
        { 
            element: '#FormFilterGrafik', 
            popover: { 
                title: 'Menampilkan Grafik Kunjungan', 
                description: 'Silahkan tentukan periode data yang ingin anda tampilkan terlebih dulu. (By SIRS El-Syifa)', 
                side: "left", 
                align: 'start' 
            }
        }
    );
});
