//Modal Edit Profile
$('#ModalEditProfile').on('show.bs.modal', function (e) {
    $('#FormEditProfile').load('_Page/Inventory/ModalLoader.php');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ProfileUser/FormEditProfile.php',
        success     : function(data){
            $('#FormEditProfile').html(data);
            //Proses Edit Profile
            $('#ProsesEditProfile').submit(function(){
                var ProsesEditProfile = $('#ProsesEditProfile').serialize();
                $('#NotifikasiEditProfile').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/ProfileUser/ProsesEditProfile.php',
                    data 	    :  ProsesEditProfile,
                    success     : function(data){
                        $('#NotifikasiEditProfile').html(data);
                        var NotifikasiBerhasil=$('#NotifikasiBerhasil').html();
                        if(NotifikasiBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Ganti Password
$('#ModalGantiPassword').on('show.bs.modal', function (e) {
    $('#FormGantiPassword').load('_Page/Inventory/ModalLoader.php');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ProfileUser/FormGantiPassword.php',
        success     : function(data){
            $('#FormGantiPassword').html(data);
            $('#password1').val('');
            $('#password2').val('');
            //Kondisi saat tampilkan password
            $('#TampilkanPasswordProfile').click(function(){
                if($(this).is(':checked')){
                    $('#password1').attr('type','text');
                    $('#password2').attr('type','text');
                }else{
                    $('#password1').attr('type','password');
                    $('#password2').attr('type','password');
                }
            });
            //Proses Edit Profile
            $('#ProsesGantiPassword').submit(function(){
                var ProsesGantiPassword = $('#ProsesGantiPassword').serialize();
                $('#NotifikasGantiPassword').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/ProfileUser/ProsesGantiPassword.php',
                    data 	    :  ProsesGantiPassword,
                    success     : function(data){
                        $('#NotifikasGantiPassword').html(data);
                        var NotifikasiUbahPasswordBerhasil=$('#NotifikasiUbahPasswordBerhasil').html();
                        if(NotifikasiUbahPasswordBerhasil=="Success"){
                            location.reload();
                        }
                    }
                });
            });
        }
    });
});
//Modal Ganti Password
$('#ModalEditFoto').on('show.bs.modal', function (e) {
    $('#FormGantiFoto').load('_Page/Inventory/ModalLoader.php');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ProfileUser/FormGantiFoto.php',
        success     : function(data){
            $('#FormGantiFoto').html(data);
            //Proses Edit Foto
            $('#ProsesGantiFoto').submit(function(){
                e.preventDefault();
                $('#NotifikasiGantiFoto').html('Loading..');
                var form = $('#ProsesGantiFoto')[0];
                var data = new FormData(form);
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/ProfileUser/ProsesGantiFoto.php',
                    data 	    :  data,
                    cache       : false,
                    processData : false,
                    contentType : false,
                    enctype     : 'multipart/form-data',
                    success     : function(data){
                        $('#NotifikasiGantiFoto').html(data);
                        var NotifikasiBerhasil=$('#NotifikasiBerhasil').html();
                        if(NotifikasiBerhasil=="Ganti Foto Berhasil"){
                            window.location.href='index.php?Page=ProfileUser&Sub=MyProfile';
                        }
                    }
                });
            });
        }
    });
});
//Proses Kirim Laporan Pengguna
$('#ProsesKirimLaporanPengguna').submit(function(){
    var ProsesKirimLaporanPengguna = $('#ProsesKirimLaporanPengguna').serialize();
    $('#NotifikasiKirimLaporanPengguna').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ProfileUser/ProsesKirimLaporanPengguna.php',
        data 	    :  ProsesKirimLaporanPengguna,
        success     : function(data){
            $('#NotifikasiKirimLaporanPengguna').html(data);
            var NotifikasiKirimLaporanPenggunaBerhasil=$('#NotifikasiKirimLaporanPenggunaBerhasil').html();
            if(NotifikasiKirimLaporanPenggunaBerhasil=="Success"){
                location.reload();
            }
        }
    });
});
//Modal Detail Laporan Pengguna
$('#ModalDetailLaporanPengguna').on('show.bs.modal', function (e) {
    var id_laporan_pengguna = $(e.relatedTarget).data('id');
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#FormDetailLaporanPengguna').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ProfileUser/FormDetailLaporanPengguna.php',
        data 	    :  {id_laporan_pengguna: id_laporan_pengguna},
        success     : function(data){
            $('#FormDetailLaporanPengguna').html(data);
        }
    });
});
//Tabel Data Table Riwayat Laporan
$('#TableLaporanPengguna').load("_Page/ProfileUser/TableLaporanPengguna.php");
//Semua JS dalam My Log Disini
$('#MenampilkanTabelLog').load("_Page/ProfileUser/TabelLog.php");
//Batas dan Pencarian
$('#BatasPencarian').submit(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
    $('#MenampilkanTabelLog').html(Loading);
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ProfileUser/TabelLog.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelLog').html(data);
        }
    });
});
//Menampilkan Grafik
var NamaData="Log Aktivitas";
var kategori_log =$('#kategori_log').val();
var periode_grafik = $('#periode_grafik').val();
var tahun_grafik = $('#tahun_grafik').val();
var bulan_grafik = $('#bulan_grafik').val();
$('#TampilkanGrafik').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/ProfileUser/MenampilkanGrafikLog.php',
    data 	    :  {kategori_log: kategori_log, periode_grafik: periode_grafik, tahun_grafik: tahun_grafik, bulan_grafik: bulan_grafik},
    success     : function(data){
        // $('#TampilkanGrafik').html(data);
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
                text: 'No Data'
            }
        }
        
        var chart = new ApexCharts(
            document.querySelector("#TampilkanGrafik"),
            options
        );
        // var UrlData = '_Page/Akses/GrafikLogAkses.json';
        var UrlData = '_Page/ProfileUser/MenampilkanGrafikLog.php';
        $.getJSON(UrlData, function(response) {
            chart.updateSeries([{
                name: NamaData,
                data: data
            }])
        });
        chart.render();
    }
});
$('#TampilkanRekapLog').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/ProfileUser/TabelRekapLog.php',
    data 	    :  {kategori_log: kategori_log, periode_grafik: periode_grafik, tahun_grafik: tahun_grafik, bulan_grafik: bulan_grafik},
    success     : function(data){
        $('#TampilkanRekapLog').html(data);
    }
});
// $('#ProsesTampilkanGrafik').submit(function(){
//     var NamaData="Log Aktivitas";
//     var ProsesTampilkanGrafik = $('#ProsesTampilkanGrafik').serialize();
//     $('#TampilkanGrafik').html('Loading...');
//     $.ajax({
//         type 	    : 'POST',
//         url 	    : '_Page/Akses/MenampilkanGrafikLog.php',
//         data 	    :  ProsesTampilkanGrafik,
//         success     : function(data){
//             // $('#MenampilkanGrafikLog').html(data);
//             var options = {
//                 chart: {
//                     height: 400,
//                     type: 'bar',
//                 },
//                 dataLabels: {
//                     enabled: false
//                 },
//                 series: [],
//                 title: {
//                     text: NamaData,
//                 },
//                 noData: {
//                     text: 'No Data'
//                 }
//             }
            
//             var chart = new ApexCharts(
//                 document.querySelector("#TampilkanGrafik"),
//                 options
//             );
//             var UrlData = '_Page/Akses/GrafikLogAkses.json';
//             // var UrlData = '_Page/Akses/MenampilkanGrafikLog.php';
//             $.getJSON(UrlData, function(response) {
//                 chart.updateSeries([{
//                     name: NamaData,
//                     data: response
//                 }])
//             });
//             chart.render();
//         }
//     });
// });
