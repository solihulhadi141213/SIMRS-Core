//Menampilkan nakes terinfeksi Untuk Pertama Kali
var ProsesFilterNakesTerinfeksi = $('#ProsesFilterNakesTerinfeksi').serialize();
$('#MenampilkanTabelNakesTerinfeksi').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/SirsOnlineNakesTerinfeksi/TabelNakesTerinfeksi.php',
    data 	    :  ProsesFilterNakesTerinfeksi,
    success     : function(data){
        $('#MenampilkanTabelNakesTerinfeksi').html(data);
    }
});
//Ketika Kategori Pencarian Di Ubah
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormFilter').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/FormFilter.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormFilter').html(data);
        }
    });
});
//Ketika Dilakukan Pencarian Nakes Terinfeksi
$('#ProsesFilterNakesTerinfeksi').submit(function(){
    var ProsesFilterNakesTerinfeksi = $('#ProsesFilterNakesTerinfeksi').serialize();
    $('#MenampilkanTabelNakesTerinfeksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/TabelNakesTerinfeksi.php',
        data 	    :  ProsesFilterNakesTerinfeksi,
        success     : function(data){
            $('#MenampilkanTabelNakesTerinfeksi').html(data);
            $('#ModalFilterNakesTerinfeksi').modal('hide');
        }
    });
});
//Kondisi Saat Pilih PCR Nakes Muncul
$('#ModalPilihPcrNakes').on('show.bs.modal', function (e) {
    var ProsesFilterPcrNakes = $('#ProsesFilterPcrNakes').serialize();
    $('#MenampilkanTabelPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/TabelPcrNakes.php',
        data 	    :  ProsesFilterPcrNakes,
        success     : function(data){
            $('#MenampilkanTabelPcrNakes').html(data);
            $('#ModalTambahNakesTerinfeksi').modal('hide');
        }
    });
});
//Ketika Dilakukan Pencarian PCR Nakes
$('#ProsesFilterPcrNakes').submit(function(){
    var ProsesFilterPcrNakes = $('#ProsesFilterPcrNakes').serialize();
    $('#MenampilkanTabelPcrNakes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/TabelPcrNakes.php',
        data 	    :  ProsesFilterPcrNakes,
        success     : function(data){
            $('#MenampilkanTabelPcrNakes').html(data);
            $('#ModalTambahNakesTerinfeksi').modal('hide');
        }
    });
});
//Kondisi Saat Tambah Nakes Terinfeksi Muncul
$('#ModalTambahNakesTerinfeksi').on('show.bs.modal', function (e) {
    var id_nakes_pcr = $(e.relatedTarget).data('id');
    $('#FormTambahNakesTerinfeksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/FormTambahNakesTerinfeksi.php',
        data 	    :  {id_nakes_pcr: id_nakes_pcr},
        success     : function(data){
            $('#FormTambahNakesTerinfeksi').html(data);
            $('#NotifikasiTambahNakesTerinfeksi').html('Pastikan Data Nakes Terinfeksi Yang Anda Masukan Sudah Sesuai');
            $('#ModalPilihPcrNakes').modal('hide');
        }
    });
});
//Proses Tambah Nakes Terinfeksi
$('#ProsesTambahNakesTerinfeksi').submit(function(){
    var ProsesTambahNakesTerinfeksi = $('#ProsesTambahNakesTerinfeksi').serialize();
    $('#NotifikasiTambahNakesTerinfeksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/ProsesTambahNakesTerinfeksi.php',
        data 	    :  ProsesTambahNakesTerinfeksi,
        success     : function(data){
            $('#NotifikasiTambahNakesTerinfeksi').html(data);
            var NotifikasiTambahNakesTerinfeksiBerhasil=$('#NotifikasiTambahNakesTerinfeksiBerhasil').html();
            if(NotifikasiTambahNakesTerinfeksiBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalTambahNakesTerinfeksi').modal('hide');
                //Tampilkan Data Terbaru
                $('#MenampilkanTabelNakesTerinfeksi').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineNakesTerinfeksi/TabelNakesTerinfeksi.php',
                    success     : function(data){
                        $('#MenampilkanTabelNakesTerinfeksi').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Nakes Terinfeksi Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Kondisi Detail Nakes Terinfeksi
$('#ModalDetailNakesTerinfeksi').on('show.bs.modal', function (e) {
    var id_nakes_terinfeksi = $(e.relatedTarget).data('id');
    $('#FormDetailNakesTerinfeksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/FormDetailNakesTerinfeksi.php',
        data 	    :  {id_nakes_terinfeksi: id_nakes_terinfeksi},
        success     : function(data){
            $('#FormDetailNakesTerinfeksi').html(data);
        }
    });
});
//Modal Edit Nakes Terinfeksi
$('#ModalEditNakesTerinfeksi').on('show.bs.modal', function (e) {
    var id_nakes_terinfeksi = $(e.relatedTarget).data('id');
    $('#FormEditNakesTerinfeksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/FormEditNakesTerinfeksi.php',
        data 	    :  {id_nakes_terinfeksi: id_nakes_terinfeksi},
        success     : function(data){
            $('#FormEditNakesTerinfeksi').html(data);
            $('#NotifikasiEditNakesTerinfeksi').html('Pastikan Data Nakes Terinfeksi Yang Anda Masukan Sudah Sesuai');
        }
    });
});
//Proses Edit Nakes Terinfeksi
$('#ProsesEditNakesTerinfeksi').submit(function(){
    var ProsesEditNakesTerinfeksi = $('#ProsesEditNakesTerinfeksi').serialize();
    $('#NotifikasiEditNakesTerinfeksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/ProsesEditNakesTerinfeksi.php',
        data 	    :  ProsesEditNakesTerinfeksi,
        success     : function(data){
            $('#NotifikasiEditNakesTerinfeksi').html(data);
            var NotifikasiEditNakesTerinfeksiBerhasil=$('#NotifikasiEditNakesTerinfeksiBerhasil').html();
            if(NotifikasiEditNakesTerinfeksiBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalEditNakesTerinfeksi').modal('hide');
                //Tampilkan Data Terbaru
                $('#MenampilkanTabelNakesTerinfeksi').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineNakesTerinfeksi/TabelNakesTerinfeksi.php',
                    success     : function(data){
                        $('#MenampilkanTabelNakesTerinfeksi').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Edit Nakes Terinfeksi Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Hapus Nakes Terinfeksi
$('#ModalHapusNakesTerinfeksi').on('show.bs.modal', function (e) {
    var id_nakes_terinfeksi = $(e.relatedTarget).data('id');
    $('#FormHapusNakesTerinfeksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/FormHapusNakesTerinfeksi.php',
        data 	    :  {id_nakes_terinfeksi: id_nakes_terinfeksi},
        success     : function(data){
            $('#FormHapusNakesTerinfeksi').html(data);
        }
    });
});
//Proses Hapus Nakes Terinfeksi
$('#ProsesHapusNakesTerinfeksi').submit(function(){
    var ProsesHapusNakesTerinfeksi = $('#ProsesHapusNakesTerinfeksi').serialize();
    $('#FormHapusNakesTerinfeksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/ProsesHapusNakesTerinfeksi.php',
        data 	    :  ProsesHapusNakesTerinfeksi,
        success     : function(data){
            $('#FormHapusNakesTerinfeksi').html(data);
            var NotifikasiHapusNakesTerinfeksiBerhasil=$('#NotifikasiHapusNakesTerinfeksiBerhasil').html();
            if(NotifikasiHapusNakesTerinfeksiBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalHapusNakesTerinfeksi').modal('hide');
                //Tampilkan Data Terbaru
                $('#MenampilkanTabelNakesTerinfeksi').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineNakesTerinfeksi/TabelNakesTerinfeksi.php',
                    success     : function(data){
                        $('#MenampilkanTabelNakesTerinfeksi').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Hapus Nakes Terinfeksi Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Menampilkan rekap nakes terinfeksi
$('#ProsesFilterRekap').submit(function(){
    var ProsesFilterRekap = $('#ProsesFilterRekap').serialize();
    $('#MenampilkanRekapitulasiNakesTerinfeksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/MenampilkanRekapitulasiNakesTerinfeksi.php',
        data 	    :  ProsesFilterRekap,
        success     : function(data){
            $('#MenampilkanRekapitulasiNakesTerinfeksi').html(data);
        }
    });
});
//Menampilkan rekap nakes terinfeksi
$('#ProsesRekapNakesTerinfeksi').submit(function(){
    var ProsesRekapNakesTerinfeksi = $('#ProsesRekapNakesTerinfeksi').serialize();
    $('#NotifikasiRekapNakesTerinfeksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/ProsesRekapNakesTerinfeksi.php',
        data 	    :  ProsesRekapNakesTerinfeksi,
        success     : function(data){
            $('#NotifikasiRekapNakesTerinfeksi').html(data);
            var NotifikasiRekapNakesTerinfeksiBerhasil=$('#NotifikasiRekapNakesTerinfeksiBerhasil').html();
            if(NotifikasiRekapNakesTerinfeksiBerhasil=="Success"){
                //Tampilkan Data Terbaru
                var ProsesFilterRekap = $('#ProsesFilterRekap').serialize();
                $('#MenampilkanRekapitulasiNakesTerinfeksi').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineNakesTerinfeksi/MenampilkanRekapitulasiNakesTerinfeksi.php',
                    data 	    :  ProsesFilterRekap,
                    success     : function(data){
                        $('#MenampilkanRekapitulasiNakesTerinfeksi').html(data);
                        $('#NotifikasiRekapNakesTerinfeksi').html('Proses Berhasil, Silahkan Buka Data SIRS Online Dengan Tanggal Periode Laporan');
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Simpan Data Rekap Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Menampilkan Nakes Terinfeksi Dari SIRS Online
$('#ProsesTampilkanNakesTerinfeksiSirsOnline').submit(function(){
    var ProsesTampilkanNakesTerinfeksiSirsOnline = $('#ProsesTampilkanNakesTerinfeksiSirsOnline').serialize();
    $('#MenampilkanNakesTerinfeksiSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/ProsesTampilkanNakesTerinfeksiSirsOnline.php',
        data 	    :  ProsesTampilkanNakesTerinfeksiSirsOnline,
        success     : function(data){
            $('#MenampilkanNakesTerinfeksiSirsOnline').html(data);
        }
    });
});
//Menampilkan Log nakes terinfeksi Untuk Pertama Kali
var ProsesTampilkanLogNakesTerinfeksiSirsOnline = $('#ProsesTampilkanLogNakesTerinfeksiSirsOnline').serialize();
$('#MenampilkanTabelLogNakesTerinfeksi').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/SirsOnlineNakesTerinfeksi/TabelLogNakesTerinfeksi.php',
    data 	    :  ProsesTampilkanLogNakesTerinfeksiSirsOnline,
    success     : function(data){
        $('#MenampilkanTabelLogNakesTerinfeksi').html(data);
    }
});
//Menampilkan Log nakes terinfeksi berdasarkan filter
$('#ProsesTampilkanLogNakesTerinfeksiSirsOnline').submit(function(){
    var ProsesTampilkanLogNakesTerinfeksiSirsOnline = $('#ProsesTampilkanLogNakesTerinfeksiSirsOnline').serialize();
    $('#MenampilkanTabelLogNakesTerinfeksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/TabelLogNakesTerinfeksi.php',
        data 	    :  ProsesTampilkanLogNakesTerinfeksiSirsOnline,
        success     : function(data){
            $('#MenampilkanTabelLogNakesTerinfeksi').html(data);
        }
    });
});
//Modal Detail Log Nakes Terinfeksi
$('#ModalDetailLaporanNakesTerinfeksi').on('show.bs.modal', function (e) {
    var id_sirs_online_task = $(e.relatedTarget).data('id');
    $('#FormDetailLogNakesTerinfeksi').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineNakesTerinfeksi/FormDetailLogNakesTerinfeksi.php',
        data 	    :  {id_sirs_online_task: id_sirs_online_task},
        success     : function(data){
            $('#FormDetailLogNakesTerinfeksi').html(data);
        }
    });
});