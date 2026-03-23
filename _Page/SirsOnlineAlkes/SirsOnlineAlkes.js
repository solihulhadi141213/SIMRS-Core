//Menampilkan Data Alkes Pertama Kali
$('#MenampilkanTabelAlkes').html('Loading...');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/SirsOnlineAlkes/TabelAlkes.php',
    success     : function(data){
        $('#MenampilkanTabelAlkes').html(data);
    }
});
//Modal Referensi Alkes
$('#ModalReferensiAlkes').on('show.bs.modal', function (e) {
    $('#FormReferensiAlkes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAlkes/FormReferensiAlkes.php',
        success     : function(data){
            $('#FormReferensiAlkes').html(data);
        }
    });
});
//Modal Detail Alkes
$('#ModalDetailAlkes').on('show.bs.modal', function (e) {
    var id_kebutuhan = $(e.relatedTarget).data('id');
    $('#FormDetailAlkes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAlkes/FormDetailAlkes.php',
        data 	    :  {id_kebutuhan: id_kebutuhan},
        success     : function(data){
            $('#FormDetailAlkes').html(data);
        }
    });
});
//Modal Tambah Alkes
$('#ModalTambahAlkes').on('show.bs.modal', function (e) {
    var id_kebutuhan = $(e.relatedTarget).data('id');
    $('#FormTambahAlkes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAlkes/FormTambahAlkes.php',
        data 	    :  {id_kebutuhan: id_kebutuhan},
        success     : function(data){
            $('#FormTambahAlkes').html(data);
            $('#NotifikasiTambahAlkes').html('Pastikan data alkes yang anda input sudah benar');
        }
    });
});
//Proses Tambah
$('#ProsesTambahAlkes').submit(function(){
    var ProsesTambahAlkes = $('#ProsesTambahAlkes').serialize();
    $('#NotifikasiTambahAlkes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAlkes/ProsesTambahAlkes.php',
        data 	    :  ProsesTambahAlkes,
        success     : function(data){
            $('#NotifikasiTambahAlkes').html(data);
            var NotifikasiTambahAlkesBerhasil=$('#NotifikasiTambahAlkesBerhasil').html();
            if(NotifikasiTambahAlkesBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalTambahAlkes').modal('hide');
                $('#MenampilkanTabelAlkes').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineAlkes/TabelAlkes.php',
                    success     : function(data){
                        $('#MenampilkanTabelAlkes').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Tambah Data Alkes Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Edit Alkes
$('#ModalEditAlkes').on('show.bs.modal', function (e) {
    var id_kebutuhan = $(e.relatedTarget).data('id');
    $('#FormEditAlkes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAlkes/FormEditAlkes.php',
        data 	    :  {id_kebutuhan: id_kebutuhan},
        success     : function(data){
            $('#FormEditAlkes').html(data);
            $('#NotifikasiEditAlkes').html('Pastikan data alkes yang anda input sudah benar');
        }
    });
});
//Proses Edit
$('#ProsesEditAlkes').submit(function(){
    var ProsesEditAlkes = $('#ProsesEditAlkes').serialize();
    $('#NotifikasiEditAlkes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAlkes/ProsesEditAlkes.php',
        data 	    :  ProsesEditAlkes,
        success     : function(data){
            $('#NotifikasiEditAlkes').html(data);
            var NotifikasiEditAlkesBerhasil=$('#NotifikasiEditAlkesBerhasil').html();
            if(NotifikasiEditAlkesBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalEditAlkes').modal('hide');
                $('#MenampilkanTabelAlkes').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineAlkes/TabelAlkes.php',
                    success     : function(data){
                        $('#MenampilkanTabelAlkes').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Edit Data Alkes Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});
//Modal Hapus Alkes
$('#ModalHapusAlkes').on('show.bs.modal', function (e) {
    var id_kebutuhan = $(e.relatedTarget).data('id');
    $('#FormHapusAlkes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAlkes/FormHapusAlkes.php',
        data 	    :  {id_kebutuhan: id_kebutuhan},
        success     : function(data){
            $('#FormHapusAlkes').html(data);
            $('#ModalDetailAlkes').modal('hide');
        }
    });
});
//Proses Hapus
$('#ProsesHapusAlkes').submit(function(){
    var ProsesHapusAlkes = $('#ProsesHapusAlkes').serialize();
    $('#FormHapusAlkes').html('Loading...');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/SirsOnlineAlkes/ProsesHapusAlkes.php',
        data 	    :  ProsesHapusAlkes,
        success     : function(data){
            $('#FormHapusAlkes').html(data);
            var NotifikasiHapusAlkesBerhasil=$('#NotifikasiHapusAlkesBerhasil').html();
            if(NotifikasiHapusAlkesBerhasil=="Success"){
                //Apabila berhasil Tutup Modal
                $('#ModalHapusAlkes').modal('hide');
                $('#MenampilkanTabelAlkes').html('Loading...');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/SirsOnlineAlkes/TabelAlkes.php',
                    success     : function(data){
                        $('#MenampilkanTabelAlkes').html(data);
                        //Tampilkan Swal
                        Swal.fire({
                            title: 'Good Job!',
                            text: 'Hapus Data Alkes Berhasil',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        })
                    }
                });
            }
        }
    });
});