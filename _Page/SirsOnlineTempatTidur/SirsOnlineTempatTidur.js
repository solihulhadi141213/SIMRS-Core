//Menampilkan data pertama kali
$('#MenampilkanTabelTempatTidurSirsOnline').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/SirsOnlineTempatTidur/TabelTempatTidur.php',
    success     : function(data){
        $('#MenampilkanTabelTempatTidurSirsOnline').html(data);
    }
});
//Kondisi ketika di click tempat tidur
$('#MasterTempatTidur').click(function(){
    var ProsesFilter = $('#ProsesFilter').serialize();
    $('#MenampilkanTabelTempatTidurSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineTempatTidur/TabelTempatTidur.php',
        data 	    :  ProsesFilter,
        success     : function(data){
            $('#MenampilkanTabelTempatTidurSirsOnline').html(data);
        }
    });
    //Evaluasi Tombol
    $('#MasterTempatTidur').removeClass('btn-outline-primary');
    $('#MasterTempatTidur').addClass('btn-primary');
    $('#SettingTempatTidur').removeClass('btn-primary');
    $('#SettingTempatTidur').addClass('btn-outline-primary');
});
$('#SettingTempatTidur').click(function(){
    $('#MenampilkanTabelTempatTidurSirsOnline').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineTempatTidur/SettingTempatTidur.php',
        success     : function(data){
            $('#MenampilkanTabelTempatTidurSirsOnline').html(data);
        }
    });
    //Evaluasi Tombol
    $('#MasterTempatTidur').removeClass('btn-primary');
    $('#MasterTempatTidur').addClass('btn-outline-primary');
    $('#SettingTempatTidur').removeClass('btn-outline-primary');
    $('#SettingTempatTidur').addClass('btn-primary');
});
//Modal Setting Tempat Tidur
$('#ModalSettingTempatTidur').on('show.bs.modal', function (e) {
    var id_ruang_rawat = $(e.relatedTarget).data('id');
    $('#FormSettingTempatTidur').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineTempatTidur/FormSettingTempatTidur.php',
        data 	    :  {id_ruang_rawat: id_ruang_rawat},
        success     : function(data){
            $('#FormSettingTempatTidur').html(data);
            $('#NotifikasiSettingTempatTidur').html('Pastikan setting tempat tidur untuk SIRS Online sudah benar.');
        }
    });
});
//Proses Setting Tempat Tidur
$('#ProsesSettingTempatTidur').submit(function(){
    var ProsesSettingTempatTidur = $('#ProsesSettingTempatTidur').serialize();
    $('#NotifikasiSettingTempatTidur').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineTempatTidur/ProsesSettingTempatTidur.php',
        data 	    :  ProsesSettingTempatTidur,
        success     : function(data){
            $('#NotifikasiSettingTempatTidur').html(data);
            var NotifikasiSettingTempatTidurBerhasil=$('#NotifikasiSettingTempatTidurBerhasil').html();
            if(NotifikasiSettingTempatTidurBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalSettingTempatTidur').modal('hide');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineTempatTidur/SettingTempatTidur.php',
                    success     : function(data){
                        $('#MenampilkanTabelTempatTidurSirsOnline').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Setting Tempat Tidur Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Detail Tempat Tidur
$('#ModalDetailTempatTidur').on('show.bs.modal', function (e) {
    var id_tt = $(e.relatedTarget).data('id');
    $('#FormDetailTempatTidur').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineTempatTidur/FormDetailTempatTidur.php',
        data 	    :  {id_tt: id_tt},
        success     : function(data){
            $('#FormDetailTempatTidur').html(data);
        }
    });
});
//Modal Tambah Tempat Tidur
$('#ModalTambahTempatTidur').on('show.bs.modal', function (e) {
    var id_tt = $(e.relatedTarget).data('id');
    $('#FormTambahTempatTidur').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineTempatTidur/FormTambahTempatTidur.php',
        data 	    :  {id_tt: id_tt},
        success     : function(data){
            $('#FormTambahTempatTidur').html(data);
            $('#NotifikasiTambahTempatTidur').html('Pastikan setting tempat tidur untuk SIRS Online sudah benar.');
        }
    });
});
//Proses Tambah Tempat Tidur
$('#ProsesTambahTempatTidur').submit(function(){
    var ProsesTambahTempatTidur = $('#ProsesTambahTempatTidur').serialize();
    $('#NotifikasiTambahTempatTidur').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineTempatTidur/ProsesTambahTempatTidur.php',
        data 	    :  ProsesTambahTempatTidur,
        success     : function(data){
            $('#NotifikasiTambahTempatTidur').html(data);
            var NotifikasiTambahTempatTidurBerhasil=$('#NotifikasiTambahTempatTidurBerhasil').html();
            if(NotifikasiTambahTempatTidurBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalTambahTempatTidur').modal('hide');
                $('#MenampilkanTabelTempatTidurSirsOnline').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineTempatTidur/TabelTempatTidur.php',
                    success     : function(data){
                        $('#MenampilkanTabelTempatTidurSirsOnline').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Tempat Tidur Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Update Tempat Tidur
$('#ModalUpdateTempatTidur').on('show.bs.modal', function (e) {
    var id_tt = $(e.relatedTarget).data('id');
    $('#FormUpdateTempatTidur').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineTempatTidur/FormUpdateTempatTidur.php',
        data 	    :  {id_tt: id_tt},
        success     : function(data){
            $('#FormUpdateTempatTidur').html(data);
            $('#NotifikasiUpdateTempatTidur').html('Pastikan setting tempat tidur untuk SIRS Online sudah benar.');
        }
    });
});
//Proses Update Tempat Tidur
$('#ProsesUpdateTempatTidur').submit(function(){
    var ProsesUpdateTempatTidur = $('#ProsesUpdateTempatTidur').serialize();
    $('#NotifikasiUpdateTempatTidur').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineTempatTidur/ProsesUpdateTempatTidur.php',
        data 	    :  ProsesUpdateTempatTidur,
        success     : function(data){
            $('#NotifikasiUpdateTempatTidur').html(data);
            var NotifikasiUpdateTempatTidurBerhasil=$('#NotifikasiUpdateTempatTidurBerhasil').html();
            if(NotifikasiUpdateTempatTidurBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalUpdateTempatTidur').modal('hide');
                $('#MenampilkanTabelTempatTidurSirsOnline').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineTempatTidur/TabelTempatTidur.php',
                    success     : function(data){
                        $('#MenampilkanTabelTempatTidurSirsOnline').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Update Tempat Tidur Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Hapus Tempat Tidur
$('#ModalHapusTempatTidur').on('show.bs.modal', function (e) {
    var id_tt = $(e.relatedTarget).data('id');
    $('#FormHapusTempatTidur').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineTempatTidur/FormHapusTempatTidur.php',
        data 	    :  {id_tt: id_tt},
        success     : function(data){
            $('#FormHapusTempatTidur').html(data);
            $('#NotifikasiHapusTempatTidur').html('Apakah anda yakin akan menghapus data tersebut?');
            $('#ModalDetailTempatTidur').modal('hide');
        }
    });
});
//Proses Hapus Tempat Tidur
$('#ProsesHapusTempatTidur').submit(function(){
    var ProsesHapusTempatTidur = $('#ProsesHapusTempatTidur').serialize();
    $('#NotifikasiHapusTempatTidur').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineTempatTidur/ProsesHapusTempatTidur.php',
        data 	    :  ProsesHapusTempatTidur,
        success     : function(data){
            $('#NotifikasiHapusTempatTidur').html(data);
            var NotifikasiHapusTempatTidurBerhasil=$('#NotifikasiHapusTempatTidurBerhasil').html();
            if(NotifikasiHapusTempatTidurBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalHapusTempatTidur').modal('hide');
                $('#MenampilkanTabelTempatTidurSirsOnline').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineTempatTidur/TabelTempatTidur.php',
                    success     : function(data){
                        $('#MenampilkanTabelTempatTidurSirsOnline').html(data);
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Hapus Tempat Tidur Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});