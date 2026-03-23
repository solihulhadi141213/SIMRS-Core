//menampilkan data jadwal defaul
var Hari="Senin";
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/JadwalDokter/TabelJadwal.php',
    data 	    :  {Hari: Hari},
    success     : function(data){
        $('#MenampilkanTabelJadwal').html(data);
        $('#ClickSenin').removeClass('btn-info');
        $('#ClickSenin').addClass('btn-primary');
        $('#ClickSelasa').removeClass('btn-primary');
        $('#ClickSelasa').addClass('btn-info');
        $('#ClickRabu').removeClass('btn-primary');
        $('#ClickRabu').addClass('btn-info');
        $('#ClickKamis').removeClass('btn-primary');
        $('#ClickKamis').addClass('btn-info');
        $('#ClickJumat').removeClass('btn-primary');
        $('#ClickJumat').addClass('btn-info');
        $('#ClickSabtu').removeClass('btn-primary');
        $('#ClickSabtu').addClass('btn-info');
        $('#ClickMinggu').removeClass('btn-primary');
        $('#ClickMinggu').addClass('btn-info');
    }
});
//ClickSenin
$('#ClickSenin').click(function(){
    var Hari="Senin";
    $('#MenampilkanTabelJadwal').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalDokter/TabelJadwal.php',
        data 	    :  {Hari: Hari},
        success     : function(data){
            $('#MenampilkanTabelJadwal').html(data);
            $('#ClickSenin').removeClass('btn-info');
            $('#ClickSenin').addClass('btn-primary');
            $('#ClickSelasa').removeClass('btn-primary');
            $('#ClickSelasa').addClass('btn-info');
            $('#ClickRabu').removeClass('btn-primary');
            $('#ClickRabu').addClass('btn-info');
            $('#ClickKamis').removeClass('btn-primary');
            $('#ClickKamis').addClass('btn-info');
            $('#ClickJumat').removeClass('btn-primary');
            $('#ClickJumat').addClass('btn-info');
            $('#ClickSabtu').removeClass('btn-primary');
            $('#ClickSabtu').addClass('btn-info');
            $('#ClickMinggu').removeClass('btn-primary');
            $('#ClickMinggu').addClass('btn-info');
        }
    });
});
//ClickSelasa
$('#ClickSelasa').click(function(){
    var Hari="Selasa";
    $('#MenampilkanTabelJadwal').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalDokter/TabelJadwal.php',
        data 	    :  {Hari: Hari},
        success     : function(data){
            $('#MenampilkanTabelJadwal').html(data);
            $('#ClickSenin').removeClass('btn-primary');
            $('#ClickSenin').addClass('btn-info');
            $('#ClickSelasa').removeClass('btn-info');
            $('#ClickSelasa').addClass('btn-primary');
            $('#ClickRabu').removeClass('btn-primary');
            $('#ClickRabu').addClass('btn-info');
            $('#ClickKamis').removeClass('btn-primary');
            $('#ClickKamis').addClass('btn-info');
            $('#ClickJumat').removeClass('btn-primary');
            $('#ClickJumat').addClass('btn-info');
            $('#ClickSabtu').removeClass('btn-primary');
            $('#ClickSabtu').addClass('btn-info');
            $('#ClickMinggu').removeClass('btn-primary');
            $('#ClickMinggu').addClass('btn-info');
        }
    });
});
//ClickRabu
$('#ClickRabu').click(function(){
    var Hari="Rabu";
    $('#MenampilkanTabelJadwal').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalDokter/TabelJadwal.php',
        data 	    :  {Hari: Hari},
        success     : function(data){
            $('#MenampilkanTabelJadwal').html(data);
            $('#ClickSenin').removeClass('btn-primary');
            $('#ClickSenin').addClass('btn-info');
            $('#ClickSelasa').removeClass('btn-primary');
            $('#ClickSelasa').addClass('btn-info');
            $('#ClickRabu').removeClass('btn-info');
            $('#ClickRabu').addClass('btn-primary');
            $('#ClickKamis').removeClass('btn-primary');
            $('#ClickKamis').addClass('btn-info');
            $('#ClickJumat').removeClass('btn-primary');
            $('#ClickJumat').addClass('btn-info');
            $('#ClickSabtu').removeClass('btn-primary');
            $('#ClickSabtu').addClass('btn-info');
            $('#ClickMinggu').removeClass('btn-primary');
            $('#ClickMinggu').addClass('btn-info');
        }
    });
});
//ClickKamis
$('#ClickKamis').click(function(){
    var Hari="Kamis";
    $('#MenampilkanTabelJadwal').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalDokter/TabelJadwal.php',
        data 	    :  {Hari: Hari},
        success     : function(data){
            $('#MenampilkanTabelJadwal').html(data);
            $('#ClickSenin').removeClass('btn-primary');
            $('#ClickSenin').addClass('btn-info');
            $('#ClickSelasa').removeClass('btn-primary');
            $('#ClickSelasa').addClass('btn-info');
            $('#ClickRabu').removeClass('btn-primary');
            $('#ClickRabu').addClass('btn-info');
            $('#ClickKamis').removeClass('btn-info');
            $('#ClickKamis').addClass('btn-primary');
            $('#ClickJumat').removeClass('btn-primary');
            $('#ClickJumat').addClass('btn-info');
            $('#ClickSabtu').removeClass('btn-primary');
            $('#ClickSabtu').addClass('btn-info');
            $('#ClickMinggu').removeClass('btn-primary');
            $('#ClickMinggu').addClass('btn-info');
        }
    });
});
//ClickJumat
$('#ClickJumat').click(function(){
    var Hari="Jumat";
    $('#MenampilkanTabelJadwal').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalDokter/TabelJadwal.php',
        data 	    :  {Hari: Hari},
        success     : function(data){
            $('#MenampilkanTabelJadwal').html(data);
            $('#ClickSenin').removeClass('btn-primary');
            $('#ClickSenin').addClass('btn-info');
            $('#ClickSelasa').removeClass('btn-primary');
            $('#ClickSelasa').addClass('btn-info');
            $('#ClickRabu').removeClass('btn-primary');
            $('#ClickRabu').addClass('btn-info');
            $('#ClickKamis').removeClass('btn-primary');
            $('#ClickKamis').addClass('btn-info');
            $('#ClickJumat').removeClass('btn-info');
            $('#ClickJumat').addClass('btn-primary');
            $('#ClickSabtu').removeClass('btn-primary');
            $('#ClickSabtu').addClass('btn-info');
            $('#ClickMinggu').removeClass('btn-primary');
            $('#ClickMinggu').addClass('btn-info');
        }
    });
});
//ClickSabtu
$('#ClickSabtu').click(function(){
    var Hari="Sabtu";
    $('#MenampilkanTabelJadwal').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalDokter/TabelJadwal.php',
        data 	    :  {Hari: Hari},
        success     : function(data){
            $('#MenampilkanTabelJadwal').html(data);
            $('#ClickSenin').removeClass('btn-primary');
            $('#ClickSenin').addClass('btn-info');
            $('#ClickSelasa').removeClass('btn-primary');
            $('#ClickSelasa').addClass('btn-info');
            $('#ClickRabu').removeClass('btn-primary');
            $('#ClickRabu').addClass('btn-info');
            $('#ClickKamis').removeClass('btn-primary');
            $('#ClickKamis').addClass('btn-info');
            $('#ClickJumat').removeClass('btn-primary');
            $('#ClickJumat').addClass('btn-info');
            $('#ClickSabtu').removeClass('btn-info');
            $('#ClickSabtu').addClass('btn-primary');
            $('#ClickMinggu').removeClass('btn-primary');
            $('#ClickMinggu').addClass('btn-info');
        }
    });
});
//ClickMinggu
$('#ClickMinggu').click(function(){
    var Hari="Minggu";
    $('#MenampilkanTabelJadwal').html("Loading..");
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalDokter/TabelJadwal.php',
        data 	    :  {Hari: Hari},
        success     : function(data){
            $('#MenampilkanTabelJadwal').html(data);
            $('#ClickSenin').removeClass('btn-primary');
            $('#ClickSenin').addClass('btn-info');
            $('#ClickSelasa').removeClass('btn-primary');
            $('#ClickSelasa').addClass('btn-info');
            $('#ClickRabu').removeClass('btn-primary');
            $('#ClickRabu').addClass('btn-info');
            $('#ClickKamis').removeClass('btn-primary');
            $('#ClickKamis').addClass('btn-info');
            $('#ClickJumat').removeClass('btn-primary');
            $('#ClickJumat').addClass('btn-info');
            $('#ClickSabtu').removeClass('btn-primary');
            $('#ClickSabtu').addClass('btn-info');
            $('#ClickMinggu').removeClass('btn-info');
            $('#ClickMinggu').addClass('btn-primary');
        }
    });
});

//Tambah jadwal dokter
$('#ModalTambahJadwal').on('show.bs.modal', function (e) {
    $('#FormTambahJadwal').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalDokter/FormTambahJadwal.php',
        success     : function(data){
            $('#FormTambahJadwal').html(data);
            //Proses Submit
            $('#ProsesTambahJadwal').submit(function(){
                var Hari=$('#hari').val();
                var jam1=$('#jam1').val();
                var jam2=$('#jam2').val();
                var id_dokter=$('#id_dokter').val();
                var id_poliklinik=$('#id_poliklinik').val();
                var kuota_non_jkn=$('#kuota_non_jkn').val();
                var kuota_jkn=$('#kuota_jkn').val();
                var time_max=$('#time_max').val();
                $('#NotifikasiTambahJadwal').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/JadwalDokter/ProsesTambahjadwal.php',
                    data 	    :  {Hari: Hari, jam1: jam1, jam2: jam2, id_dokter: id_dokter, id_poliklinik: id_poliklinik, kuota_non_jkn: kuota_non_jkn, kuota_jkn: kuota_jkn, time_max: time_max},
                    success     : function(data){
                        $('#NotifikasiTambahJadwal').html(data);
                        var NotifikasiTambahJadwalBerhasil=$('#NotifikasiTambahJadwalBerhasil').html();
                        if(NotifikasiTambahJadwalBerhasil=="Berhasil"){
                            $('#MenampilkanTabelJadwal').html("Loading..");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/JadwalDokter/TabelJadwal.php',
                                data 	    :  {Hari: Hari},
                                success     : function(data){
                                    $('#MenampilkanTabelJadwal').html(data);
                                    if(Hari=="Senin"){
                                        $('#ClickSenin').removeClass('btn-info');
                                        $('#ClickSenin').addClass('btn-primary');
                                        $('#ClickSelasa').removeClass('btn-primary');
                                        $('#ClickSelasa').addClass('btn-info');
                                        $('#ClickRabu').removeClass('btn-primary');
                                        $('#ClickRabu').addClass('btn-info');
                                        $('#ClickKamis').removeClass('btn-primary');
                                        $('#ClickKamis').addClass('btn-info');
                                        $('#ClickJumat').removeClass('btn-primary');
                                        $('#ClickJumat').addClass('btn-info');
                                        $('#ClickSabtu').removeClass('btn-primary');
                                        $('#ClickSabtu').addClass('btn-info');
                                        $('#ClickMinggu').removeClass('btn-primary');
                                        $('#ClickMinggu').addClass('btn-info');
                                    }
                                    if(Hari=="Selasa"){
                                        $('#ClickSenin').removeClass('btn-primary');
                                        $('#ClickSenin').addClass('btn-info');
                                        $('#ClickSelasa').removeClass('btn-info');
                                        $('#ClickSelasa').addClass('btn-primary');
                                        $('#ClickRabu').removeClass('btn-primary');
                                        $('#ClickRabu').addClass('btn-info');
                                        $('#ClickKamis').removeClass('btn-primary');
                                        $('#ClickKamis').addClass('btn-info');
                                        $('#ClickJumat').removeClass('btn-primary');
                                        $('#ClickJumat').addClass('btn-info');
                                        $('#ClickSabtu').removeClass('btn-primary');
                                        $('#ClickSabtu').addClass('btn-info');
                                        $('#ClickMinggu').removeClass('btn-primary');
                                        $('#ClickMinggu').addClass('btn-info');
                                    }
                                    if(Hari=="Rabu"){
                                        $('#ClickSenin').removeClass('btn-primary');
                                        $('#ClickSenin').addClass('btn-info');
                                        $('#ClickSelasa').removeClass('btn-primary');
                                        $('#ClickSelasa').addClass('btn-info');
                                        $('#ClickRabu').removeClass('btn-info');
                                        $('#ClickRabu').addClass('btn-primary');
                                        $('#ClickKamis').removeClass('btn-primary');
                                        $('#ClickKamis').addClass('btn-info');
                                        $('#ClickJumat').removeClass('btn-primary');
                                        $('#ClickJumat').addClass('btn-info');
                                        $('#ClickSabtu').removeClass('btn-primary');
                                        $('#ClickSabtu').addClass('btn-info');
                                        $('#ClickMinggu').removeClass('btn-primary');
                                        $('#ClickMinggu').addClass('btn-info');
                                    }
                                    if(Hari=="Kamis"){
                                        $('#ClickSenin').removeClass('btn-primary');
                                        $('#ClickSenin').addClass('btn-info');
                                        $('#ClickSelasa').removeClass('btn-primary');
                                        $('#ClickSelasa').addClass('btn-info');
                                        $('#ClickRabu').removeClass('btn-primary');
                                        $('#ClickRabu').addClass('btn-info');
                                        $('#ClickKamis').removeClass('btn-info');
                                        $('#ClickKamis').addClass('btn-primary');
                                        $('#ClickJumat').removeClass('btn-primary');
                                        $('#ClickJumat').addClass('btn-info');
                                        $('#ClickSabtu').removeClass('btn-primary');
                                        $('#ClickSabtu').addClass('btn-info');
                                        $('#ClickMinggu').removeClass('btn-primary');
                                        $('#ClickMinggu').addClass('btn-info');
                                    }
                                    if(Hari=="Jumat"){
                                        $('#ClickSenin').removeClass('btn-primary');
                                        $('#ClickSenin').addClass('btn-info');
                                        $('#ClickSelasa').removeClass('btn-primary');
                                        $('#ClickSelasa').addClass('btn-info');
                                        $('#ClickRabu').removeClass('btn-primary');
                                        $('#ClickRabu').addClass('btn-info');
                                        $('#ClickKamis').removeClass('btn-primary');
                                        $('#ClickKamis').addClass('btn-info');
                                        $('#ClickJumat').removeClass('btn-info');
                                        $('#ClickJumat').addClass('btn-primary');
                                        $('#ClickSabtu').removeClass('btn-primary');
                                        $('#ClickSabtu').addClass('btn-info');
                                        $('#ClickMinggu').removeClass('btn-primary');
                                        $('#ClickMinggu').addClass('btn-info');
                                    }
                                    if(Hari=="Sabtu"){
                                        $('#ClickSenin').removeClass('btn-primary');
                                        $('#ClickSenin').addClass('btn-info');
                                        $('#ClickSelasa').removeClass('btn-primary');
                                        $('#ClickSelasa').addClass('btn-info');
                                        $('#ClickRabu').removeClass('btn-primary');
                                        $('#ClickRabu').addClass('btn-info');
                                        $('#ClickKamis').removeClass('btn-primary');
                                        $('#ClickKamis').addClass('btn-info');
                                        $('#ClickJumat').removeClass('btn-primary');
                                        $('#ClickJumat').addClass('btn-info');
                                        $('#ClickSabtu').removeClass('btn-info');
                                        $('#ClickSabtu').addClass('btn-primary');
                                        $('#ClickMinggu').removeClass('btn-primary');
                                        $('#ClickMinggu').addClass('btn-info');
                                    }
                                    if(Hari=="Minggu"){
                                        $('#ClickSenin').removeClass('btn-primary');
                                        $('#ClickSenin').addClass('btn-info');
                                        $('#ClickSelasa').removeClass('btn-primary');
                                        $('#ClickSelasa').addClass('btn-info');
                                        $('#ClickRabu').removeClass('btn-primary');
                                        $('#ClickRabu').addClass('btn-info');
                                        $('#ClickKamis').removeClass('btn-primary');
                                        $('#ClickKamis').addClass('btn-info');
                                        $('#ClickJumat').removeClass('btn-primary');
                                        $('#ClickJumat').addClass('btn-info');
                                        $('#ClickSabtu').removeClass('btn-primary');
                                        $('#ClickSabtu').addClass('btn-info');
                                        $('#ClickMinggu').removeClass('btn-info');
                                        $('#ClickMinggu').addClass('btn-primary');
                                    }
                                    $('#ModalTambahJadwal').modal('hide');
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Simpan Data Jadwal Berhasil',
                                        icon: 'success',
                                        confirmButtonText: 'Tutup'
                                    })
                                }
                            });
                        }
                    }
                });
            });
        }
    });
});
//Modal Detail Dokter
$('#ModalEditJadwalDokter').on('show.bs.modal', function (e) {
    var id_jadwal = $(e.relatedTarget).data('id');
    $('#FormEditJadwal').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/JadwalDokter/FormEditJadwal.php',
        data 	    :  {id_jadwal: id_jadwal},
        success     : function(data){
            $('#FormEditJadwal').html(data);
            //Proses Edit jadwal
            $('#ProsesEditJadwalDokter').submit(function(){
                var ProsesEditJadwalDokter = $('#ProsesEditJadwalDokter').serialize();
                $('#NotifikasiEditJadwal').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/JadwalDokter/ProsesEditjadwal.php',
                    data 	    :  ProsesEditJadwalDokter,
                    success     : function(data){
                        $('#NotifikasiEditJadwal').html(data);
                        var NotifikasiEditJadwalBerhasil=$('#NotifikasiEditJadwalBerhasil').html();
                        var GetDataHari=$('#GetDataHari').html();
                        if(NotifikasiEditJadwalBerhasil=="Berhasil"){
                            $('#MenampilkanTabelJadwal').html("Loading..");
                            $.ajax({
                                type 	    : 'POST',
                                url 	    : '_Page/JadwalDokter/TabelJadwal.php',
                                data 	    :  {Hari: GetDataHari},
                                success     : function(data){
                                    $('#MenampilkanTabelJadwal').html(data);
                                    if(GetDataHari=="Senin"){
                                        $('#ClickSenin').removeClass('btn-info');
                                        $('#ClickSenin').addClass('btn-primary');
                                        $('#ClickSelasa').removeClass('btn-primary');
                                        $('#ClickSelasa').addClass('btn-info');
                                        $('#ClickRabu').removeClass('btn-primary');
                                        $('#ClickRabu').addClass('btn-info');
                                        $('#ClickKamis').removeClass('btn-primary');
                                        $('#ClickKamis').addClass('btn-info');
                                        $('#ClickJumat').removeClass('btn-primary');
                                        $('#ClickJumat').addClass('btn-info');
                                        $('#ClickSabtu').removeClass('btn-primary');
                                        $('#ClickSabtu').addClass('btn-info');
                                        $('#ClickMinggu').removeClass('btn-primary');
                                        $('#ClickMinggu').addClass('btn-info');
                                    }
                                    if(GetDataHari=="Selasa"){
                                        $('#ClickSenin').removeClass('btn-primary');
                                        $('#ClickSenin').addClass('btn-info');
                                        $('#ClickSelasa').removeClass('btn-info');
                                        $('#ClickSelasa').addClass('btn-primary');
                                        $('#ClickRabu').removeClass('btn-primary');
                                        $('#ClickRabu').addClass('btn-info');
                                        $('#ClickKamis').removeClass('btn-primary');
                                        $('#ClickKamis').addClass('btn-info');
                                        $('#ClickJumat').removeClass('btn-primary');
                                        $('#ClickJumat').addClass('btn-info');
                                        $('#ClickSabtu').removeClass('btn-primary');
                                        $('#ClickSabtu').addClass('btn-info');
                                        $('#ClickMinggu').removeClass('btn-primary');
                                        $('#ClickMinggu').addClass('btn-info');
                                    }
                                    if(GetDataHari=="Rabu"){
                                        $('#ClickSenin').removeClass('btn-primary');
                                        $('#ClickSenin').addClass('btn-info');
                                        $('#ClickSelasa').removeClass('btn-primary');
                                        $('#ClickSelasa').addClass('btn-info');
                                        $('#ClickRabu').removeClass('btn-info');
                                        $('#ClickRabu').addClass('btn-primary');
                                        $('#ClickKamis').removeClass('btn-primary');
                                        $('#ClickKamis').addClass('btn-info');
                                        $('#ClickJumat').removeClass('btn-primary');
                                        $('#ClickJumat').addClass('btn-info');
                                        $('#ClickSabtu').removeClass('btn-primary');
                                        $('#ClickSabtu').addClass('btn-info');
                                        $('#ClickMinggu').removeClass('btn-primary');
                                        $('#ClickMinggu').addClass('btn-info');
                                    }
                                    if(GetDataHari=="Kamis"){
                                        $('#ClickSenin').removeClass('btn-primary');
                                        $('#ClickSenin').addClass('btn-info');
                                        $('#ClickSelasa').removeClass('btn-primary');
                                        $('#ClickSelasa').addClass('btn-info');
                                        $('#ClickRabu').removeClass('btn-primary');
                                        $('#ClickRabu').addClass('btn-info');
                                        $('#ClickKamis').removeClass('btn-info');
                                        $('#ClickKamis').addClass('btn-primary');
                                        $('#ClickJumat').removeClass('btn-primary');
                                        $('#ClickJumat').addClass('btn-info');
                                        $('#ClickSabtu').removeClass('btn-primary');
                                        $('#ClickSabtu').addClass('btn-info');
                                        $('#ClickMinggu').removeClass('btn-primary');
                                        $('#ClickMinggu').addClass('btn-info');
                                    }
                                    if(GetDataHari=="Jumat"){
                                        $('#ClickSenin').removeClass('btn-primary');
                                        $('#ClickSenin').addClass('btn-info');
                                        $('#ClickSelasa').removeClass('btn-primary');
                                        $('#ClickSelasa').addClass('btn-info');
                                        $('#ClickRabu').removeClass('btn-primary');
                                        $('#ClickRabu').addClass('btn-info');
                                        $('#ClickKamis').removeClass('btn-primary');
                                        $('#ClickKamis').addClass('btn-info');
                                        $('#ClickJumat').removeClass('btn-info');
                                        $('#ClickJumat').addClass('btn-primary');
                                        $('#ClickSabtu').removeClass('btn-primary');
                                        $('#ClickSabtu').addClass('btn-info');
                                        $('#ClickMinggu').removeClass('btn-primary');
                                        $('#ClickMinggu').addClass('btn-info');
                                    }
                                    if(GetDataHari=="Sabtu"){
                                        $('#ClickSenin').removeClass('btn-primary');
                                        $('#ClickSenin').addClass('btn-info');
                                        $('#ClickSelasa').removeClass('btn-primary');
                                        $('#ClickSelasa').addClass('btn-info');
                                        $('#ClickRabu').removeClass('btn-primary');
                                        $('#ClickRabu').addClass('btn-info');
                                        $('#ClickKamis').removeClass('btn-primary');
                                        $('#ClickKamis').addClass('btn-info');
                                        $('#ClickJumat').removeClass('btn-primary');
                                        $('#ClickJumat').addClass('btn-info');
                                        $('#ClickSabtu').removeClass('btn-info');
                                        $('#ClickSabtu').addClass('btn-primary');
                                        $('#ClickMinggu').removeClass('btn-primary');
                                        $('#ClickMinggu').addClass('btn-info');
                                    }
                                    if(GetDataHari=="Minggu"){
                                        $('#ClickSenin').removeClass('btn-primary');
                                        $('#ClickSenin').addClass('btn-info');
                                        $('#ClickSelasa').removeClass('btn-primary');
                                        $('#ClickSelasa').addClass('btn-info');
                                        $('#ClickRabu').removeClass('btn-primary');
                                        $('#ClickRabu').addClass('btn-info');
                                        $('#ClickKamis').removeClass('btn-primary');
                                        $('#ClickKamis').addClass('btn-info');
                                        $('#ClickJumat').removeClass('btn-primary');
                                        $('#ClickJumat').addClass('btn-info');
                                        $('#ClickSabtu').removeClass('btn-primary');
                                        $('#ClickSabtu').addClass('btn-info');
                                        $('#ClickMinggu').removeClass('btn-info');
                                        $('#ClickMinggu').addClass('btn-primary');
                                    }
                                    $('#ModalEditJadwalDokter').modal('hide');
                                    Swal.fire({
                                        title: 'Good Job!',
                                        text: 'Update Data Jadwal Berhasil',
                                        icon: 'success',
                                        confirmButtonText: 'Tutup'
                                    })
                                }
                            });
                        }
                    }
                });
            });
            //Delete Jadwal
            $('#ModalDeleteJadwalDokter').on('show.bs.modal', function (e) {
                $('#FormDeleteJadwalDokter').html("Loading...");
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/JadwalDokter/FormDeleteJadwal.php',
                    data        :  {id_jadwal: id_jadwal},
                    success     : function(data){
                        $('#FormDeleteJadwalDokter').html(data);
                        //Konfirmasi Hapus Data jadwal
                        $('#KonfirmasiHapusJadwal').click(function(){
                            $('#FormDeleteJadwalDokter').html('Loading...');
                            $.ajax({
                                url     : "_Page/JadwalDokter/ProsesDeleteJadwal.php",
                                method  : "POST",
                                data    :  {id_jadwal: id_jadwal},
                                success : function (data) {
                                    $('#FormDeleteJadwalDokter').html(data);
                                    //Notifikasi Proses Hapus
                                    var NotifikasiHapusJadwalberhasil=$('#NotifikasiHapusJadwalberhasil').html();
                                    if(NotifikasiHapusJadwalberhasil=="Berhasil"){
                                        $('#MenampilkanTabelJadwal').html("Loading..");
                                        $.ajax({
                                            type 	    : 'POST',
                                            url 	    : '_Page/JadwalDokter/TabelJadwal.php',
                                            data 	    :  {Hari: Hari},
                                            success     : function(data){
                                                $('#MenampilkanTabelJadwal').html(data);
                                                if(Hari=="Senin"){
                                                    $('#ClickSenin').removeClass('btn-info');
                                                    $('#ClickSenin').addClass('btn-primary');
                                                    $('#ClickSelasa').removeClass('btn-primary');
                                                    $('#ClickSelasa').addClass('btn-info');
                                                    $('#ClickRabu').removeClass('btn-primary');
                                                    $('#ClickRabu').addClass('btn-info');
                                                    $('#ClickKamis').removeClass('btn-primary');
                                                    $('#ClickKamis').addClass('btn-info');
                                                    $('#ClickJumat').removeClass('btn-primary');
                                                    $('#ClickJumat').addClass('btn-info');
                                                    $('#ClickSabtu').removeClass('btn-primary');
                                                    $('#ClickSabtu').addClass('btn-info');
                                                    $('#ClickMinggu').removeClass('btn-primary');
                                                    $('#ClickMinggu').addClass('btn-info');
                                                }
                                                if(Hari=="Selasa"){
                                                    $('#ClickSenin').removeClass('btn-primary');
                                                    $('#ClickSenin').addClass('btn-info');
                                                    $('#ClickSelasa').removeClass('btn-info');
                                                    $('#ClickSelasa').addClass('btn-primary');
                                                    $('#ClickRabu').removeClass('btn-primary');
                                                    $('#ClickRabu').addClass('btn-info');
                                                    $('#ClickKamis').removeClass('btn-primary');
                                                    $('#ClickKamis').addClass('btn-info');
                                                    $('#ClickJumat').removeClass('btn-primary');
                                                    $('#ClickJumat').addClass('btn-info');
                                                    $('#ClickSabtu').removeClass('btn-primary');
                                                    $('#ClickSabtu').addClass('btn-info');
                                                    $('#ClickMinggu').removeClass('btn-primary');
                                                    $('#ClickMinggu').addClass('btn-info');
                                                }
                                                if(Hari=="Rabu"){
                                                    $('#ClickSenin').removeClass('btn-primary');
                                                    $('#ClickSenin').addClass('btn-info');
                                                    $('#ClickSelasa').removeClass('btn-primary');
                                                    $('#ClickSelasa').addClass('btn-info');
                                                    $('#ClickRabu').removeClass('btn-info');
                                                    $('#ClickRabu').addClass('btn-primary');
                                                    $('#ClickKamis').removeClass('btn-primary');
                                                    $('#ClickKamis').addClass('btn-info');
                                                    $('#ClickJumat').removeClass('btn-primary');
                                                    $('#ClickJumat').addClass('btn-info');
                                                    $('#ClickSabtu').removeClass('btn-primary');
                                                    $('#ClickSabtu').addClass('btn-info');
                                                    $('#ClickMinggu').removeClass('btn-primary');
                                                    $('#ClickMinggu').addClass('btn-info');
                                                }
                                                if(Hari=="Kamis"){
                                                    $('#ClickSenin').removeClass('btn-primary');
                                                    $('#ClickSenin').addClass('btn-info');
                                                    $('#ClickSelasa').removeClass('btn-primary');
                                                    $('#ClickSelasa').addClass('btn-info');
                                                    $('#ClickRabu').removeClass('btn-primary');
                                                    $('#ClickRabu').addClass('btn-info');
                                                    $('#ClickKamis').removeClass('btn-info');
                                                    $('#ClickKamis').addClass('btn-primary');
                                                    $('#ClickJumat').removeClass('btn-primary');
                                                    $('#ClickJumat').addClass('btn-info');
                                                    $('#ClickSabtu').removeClass('btn-primary');
                                                    $('#ClickSabtu').addClass('btn-info');
                                                    $('#ClickMinggu').removeClass('btn-primary');
                                                    $('#ClickMinggu').addClass('btn-info');
                                                }
                                                if(Hari=="Jumat"){
                                                    $('#ClickSenin').removeClass('btn-primary');
                                                    $('#ClickSenin').addClass('btn-info');
                                                    $('#ClickSelasa').removeClass('btn-primary');
                                                    $('#ClickSelasa').addClass('btn-info');
                                                    $('#ClickRabu').removeClass('btn-primary');
                                                    $('#ClickRabu').addClass('btn-info');
                                                    $('#ClickKamis').removeClass('btn-primary');
                                                    $('#ClickKamis').addClass('btn-info');
                                                    $('#ClickJumat').removeClass('btn-info');
                                                    $('#ClickJumat').addClass('btn-primary');
                                                    $('#ClickSabtu').removeClass('btn-primary');
                                                    $('#ClickSabtu').addClass('btn-info');
                                                    $('#ClickMinggu').removeClass('btn-primary');
                                                    $('#ClickMinggu').addClass('btn-info');
                                                }
                                                if(Hari=="Sabtu"){
                                                    $('#ClickSenin').removeClass('btn-primary');
                                                    $('#ClickSenin').addClass('btn-info');
                                                    $('#ClickSelasa').removeClass('btn-primary');
                                                    $('#ClickSelasa').addClass('btn-info');
                                                    $('#ClickRabu').removeClass('btn-primary');
                                                    $('#ClickRabu').addClass('btn-info');
                                                    $('#ClickKamis').removeClass('btn-primary');
                                                    $('#ClickKamis').addClass('btn-info');
                                                    $('#ClickJumat').removeClass('btn-primary');
                                                    $('#ClickJumat').addClass('btn-info');
                                                    $('#ClickSabtu').removeClass('btn-info');
                                                    $('#ClickSabtu').addClass('btn-primary');
                                                    $('#ClickMinggu').removeClass('btn-primary');
                                                    $('#ClickMinggu').addClass('btn-info');
                                                }
                                                if(Hari=="Minggu"){
                                                    $('#ClickSenin').removeClass('btn-primary');
                                                    $('#ClickSenin').addClass('btn-info');
                                                    $('#ClickSelasa').removeClass('btn-primary');
                                                    $('#ClickSelasa').addClass('btn-info');
                                                    $('#ClickRabu').removeClass('btn-primary');
                                                    $('#ClickRabu').addClass('btn-info');
                                                    $('#ClickKamis').removeClass('btn-primary');
                                                    $('#ClickKamis').addClass('btn-info');
                                                    $('#ClickJumat').removeClass('btn-primary');
                                                    $('#ClickJumat').addClass('btn-info');
                                                    $('#ClickSabtu').removeClass('btn-primary');
                                                    $('#ClickSabtu').addClass('btn-info');
                                                    $('#ClickMinggu').removeClass('btn-info');
                                                    $('#ClickMinggu').addClass('btn-primary');
                                                }
                                                $('#ModalDeleteJadwalDokter').modal('hide');
                                                $('#ModalEditJadwalDokter').modal('hide');
                                                Swal.fire({
                                                    title: 'Good Job!',
                                                    text: 'Hapus Data Jadwal Berhasil',
                                                    icon: 'success',
                                                    confirmButtonText: 'Tutup'
                                                })
                                            }
                                        });
                                    }
                                }
                            })
                        });
                    }
                });
            });
        }
    });
});
//Modal Hfis
$('#ModalDataHfis').on('show.bs.modal', function (e) {
    $('#ProsesPencarianJadwalHfis').submit(function(){
        var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
        var tanggal=$('#TanggalPencarianHfis').val();
        var kode_dokter=$('#kode_poli').val();
        $('#FormDataHfis').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/JadwalDokter/TabelJadwalHfis.php',
            data 	    :  {tanggal: tanggal, kode_dokter: kode_dokter},
            success     : function(data){
                $('#FormDataHfis').html(data);
            }
        });
    });
});
//Modal Update Jadwal Hfis
$('#ModalUpdateToHfis').on('show.bs.modal', function (e) {
    $('#ProsesTampilkanDataUntukUpdate').submit(function(){
        var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
        var id_dokter=$('#id_dokter').val();
        var id_poliklinik=$('#id_poliklinik').val();
        $('#TampilkanDataUntukUpdate').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/JadwalDokter/TampilkanDataUntukUpdate.php',
            data 	    :  {id_dokter: id_dokter, id_poliklinik: id_poliklinik},
            success     : function(data){
                $('#TampilkanDataUntukUpdate').html(data);
            }
        });
    });
    $('#ProsesUpdateDataHfis').click(function(){
        var Loading='<div class="modal-body"><div class="row"><div class="col col-md-12">Loading..</div></div></div>';
        var id_dokter=$('#id_dokter').val();
        var id_poliklinik=$('#id_poliklinik').val();
        $('#TampilkanDataUntukUpdate').html(Loading);
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/JadwalDokter/ProsesUpdateDataHfis.php',
            data 	    :  {id_dokter: id_dokter, id_poliklinik: id_poliklinik},
            success     : function(data){
                $('#TampilkanDataUntukUpdate').html(data);
            }
        });
    });
});