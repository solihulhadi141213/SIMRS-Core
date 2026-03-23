//Menampilkan Data Antrian SIMRS pertama kali
var ProsesFilterAntrian = $('#ProsesFilterAntrian').serialize();
$('#MenampilkanKontenAntrian').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/SirsOnlineAntrian/TabelAntrian.php',
    data 	    :  ProsesFilterAntrian,
    success     : function(data){
        $('#MenampilkanKontenAntrian').html(data);
        $('#TitleHalaman').html('<i class="ti ti-server"></i> Antrian SIMRS (Local)');
    }
});
//keyword_by Filter Nakes berubah
$('#keyword_by').change(function(){
    var keyword_by = $('#keyword_by').val();
    $('#FormKeyword').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAntrian/FormKeyword.php',
        data 	    :  {keyword_by: keyword_by},
        success     : function(data){
            $('#FormKeyword').html(data);
        }
    });
});
//Proses Filter Nakes
$('#ProsesFilterAntrian').submit(function(){
    var ProsesFilterAntrian = $('#ProsesFilterAntrian').serialize();
    $('#MenampilkanKontenAntrian').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAntrian/TabelAntrian.php',
        data 	    :  ProsesFilterAntrian,
        success     : function(data){
            $('#MenampilkanKontenAntrian').html(data);
            $('#TitleHalaman').html('<i class="ti ti-server"></i> Antrian SIMRS (Local)');
            $('#ModalFilterAntrian').modal('hide');
            //Evaluasi Tombol
            $('#TampilkanAntrianSimrs').removeClass('btn-outline-info');
            $('#TampilkanAntrianSimrs').addClass('btn-info');
            $('#TampilkanAntrianSirsOnline').addClass('btn-outline-info');
            $('#TampilkanAntrianSirsOnline').removeClass('btn-info');
        }
    });
});
//Tampilkan Antrian Simrs
$('#TampilkanAntrianSimrs').click(function(){
    var ProsesFilterAntrian = $('#ProsesFilterAntrian').serialize();
    $('#MenampilkanKontenAntrian').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAntrian/TabelAntrian.php',
        data 	    :  ProsesFilterAntrian,
        success     : function(data){
            $('#MenampilkanKontenAntrian').html(data);
            $('#TitleHalaman').html('<i class="ti ti-server"></i> Antrian SIMRS (Local)');
            //Evaluasi Tombol
            $('#TampilkanAntrianSimrs').removeClass('btn-outline-info');
            $('#TampilkanAntrianSimrs').addClass('btn-info');
            $('#TampilkanAntrianSirsOnline').addClass('btn-outline-info');
            $('#TampilkanAntrianSirsOnline').removeClass('btn-info');
        }
    });
});
//Tampilkan Antrian Sirs Online
$('#TampilkanAntrianSirsOnline').click(function(){
    var ProsesFilterAntrian = $('#ProsesFilterAntrian').serialize();
    $('#MenampilkanKontenAntrian').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAntrian/TabelAntrianSirsOnline.php',
        data 	    :  ProsesFilterAntrian,
        success     : function(data){
            $('#MenampilkanKontenAntrian').html(data);
            $('#TitleHalaman').html('<i class="ti ti-world"></i> Antrian SIRS Online');
            //Evaluasi Tombol
            $('#TampilkanAntrianSirsOnline').removeClass('btn-outline-info');
            $('#TampilkanAntrianSirsOnline').addClass('btn-info');
            $('#TampilkanAntrianSimrs').addClass('btn-outline-info');
            $('#TampilkanAntrianSimrs').removeClass('btn-info');
        }
    });
});
//Modal Add Antrian
$('#ModalAddAntrian').on('show.bs.modal', function (e) {
    var id_antrian = $(e.relatedTarget).data('id');
    $('#FormAddAntrianSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAntrian/FormAddAntrianSirsOnline.php',
        data 	    :  {id_antrian: id_antrian},
        success     : function(data){
            $('#FormAddAntrianSirsOnline').html(data);
            $('#NotifikasiProsesAddAntrian').html('Pastikan data antrian yang anda input sudah benar!');
        }
    });
});
//Proses Creat Antrian
$('#ProsesAddAntrian').submit(function(){
    var ProsesAddAntrian = $('#ProsesAddAntrian').serialize();
    $('#NotifikasiProsesAddAntrian').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAntrian/ProsesAddAntrian.php',
        data 	    :  ProsesAddAntrian,
        success     : function(data){
            $('#NotifikasiProsesAddAntrian').html(data);
            var NotifikasiProsesAddAntrianBerhasil=$('#NotifikasiProsesAddAntrianBerhasil').html();
            if(NotifikasiProsesAddAntrianBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalAddAntrian').modal('hide');
                var ProsesFilterAntrian = $('#ProsesFilterAntrian').serialize();
                $('#MenampilkanKontenAntrian').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineAntrian/TabelAntrian.php',
                    data 	    :  ProsesFilterAntrian,
                    success     : function(data){
                        $('#MenampilkanKontenAntrian').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Antrian Ke SIRS Online Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Detail Antrian
$('#ModalDetailAntrian').on('show.bs.modal', function (e) {
    var id_antrian = $(e.relatedTarget).data('id');
    $('#FormDetailAntrian').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAntrian/FormDetailAntrian.php',
        data 	    :  {id_antrian: id_antrian},
        success     : function(data){
            $('#FormDetailAntrian').html(data);
        }
    });
});
//Modal Update Antrian SIRS Online
$('#ModalUpdateAntrianSirsOnline').on('show.bs.modal', function (e) {
    var GetContent = $(e.relatedTarget).data('id');
    $('#FormUpdateAntrianSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAntrian/FormUpdateAntrianSirsOnline.php',
        data 	    :  {GetContent: GetContent},
        success     : function(data){
            $('#FormUpdateAntrianSirsOnline').html(data);
            $('#NotifikasiUpdateAntrianSirsOnline').html('Pastikan data antrian yang anda input sudah benar!');
        }
    });
});
//Proses Update Antrian
$('#ProsesUpdateAntrianSirsOnline').submit(function(){
    var ProsesUpdateAntrianSirsOnline = $('#ProsesUpdateAntrianSirsOnline').serialize();
    $('#NotifikasiUpdateAntrianSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAntrian/ProsesUpdateAntrianSirsOnline.php',
        data 	    :  ProsesUpdateAntrianSirsOnline,
        success     : function(data){
            $('#NotifikasiUpdateAntrianSirsOnline').html(data);
            var NotifikasiUpdateAntrianSirsOnlineBerhasil=$('#NotifikasiUpdateAntrianSirsOnlineBerhasil').html();
            if(NotifikasiUpdateAntrianSirsOnlineBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalUpdateAntrianSirsOnline').modal('hide');
                var ProsesFilterAntrian = $('#ProsesFilterAntrian').serialize();
                $('#MenampilkanKontenAntrian').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineAntrian/TabelAntrian.php',
                    data 	    :  ProsesFilterAntrian,
                    success     : function(data){
                        $('#MenampilkanKontenAntrian').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Update Antrian Ke SIRS Online Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Detail Antrian SIRS Online
$('#ModalDetailAntrianSirsOnline').on('show.bs.modal', function (e) {
    var GetContent = $(e.relatedTarget).data('id');
    $('#FormDetailAntrianSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAntrian/FormDetailAntrianSirsOnline.php',
        data 	    :  {GetContent: GetContent},
        success     : function(data){
            $('#FormDetailAntrianSirsOnline').html(data);
        }
    });
    $('#FormUpdateTaskIdAntian').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAntrian/FormUpdateTaskIdAntian.php',
        data 	    :  {GetContent: GetContent},
        success     : function(data){
            $('#FormUpdateTaskIdAntian').html(data);
        }
    });
});
//Proses Update Task ID
 $('#ProsesUpdateTaskIdAntianSubmit').submit(function(){
    var ProsesUpdateTaskIdAntianSubmit = $('#ProsesUpdateTaskIdAntianSubmit').serialize();
    $('#FormUpdateTaskIdAntian').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAntrian/ProsesUpdateTaskIdAntrian.php',
        data 	    :  ProsesUpdateTaskIdAntianSubmit,
        success     : function(data){
            $('#FormUpdateTaskIdAntian').html(data);
        }
    });
});