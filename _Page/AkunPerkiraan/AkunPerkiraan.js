//menampilkan Akun Perkiraan Pertama Kali
var BatasPencarian = $('#BatasPencarian').serialize();
$('#MenampilkanTabelAkunPerkiraan').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center"><span class="text-primary">Loading...</span></div></div></div>');
$.ajax({
    type 	    : 'POST',
    url 	    : '_Page/AkunPerkiraan/TabelAkunPerkiraan.php',
    data 	    :  BatasPencarian,
    success     : function(data){
        $('#MenampilkanTabelAkunPerkiraan').html(data);
    }
});
//Ketika Batas Diubah
$('#batas').change(function(){
    var BatasPencarian = $('#BatasPencarian').serialize();
    $('#MenampilkanTabelAkunPerkiraan').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center"><span class="text-primary">Loading...</span></div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/TabelAkunPerkiraan.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelAkunPerkiraan').html(data);
        }
    });
});
//Ketika Proses Pencarian Dimulai
$('#BatasPencarian').submit(function(){
    //Kosongkan Page
    $('#page').val('');
    var BatasPencarian = $('#BatasPencarian').serialize();
    $('#MenampilkanTabelAkunPerkiraan').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center"><span class="text-primary">Loading...</span></div></div></div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/TabelAkunPerkiraan.php',
        data 	    :  BatasPencarian,
        success     : function(data){
            $('#MenampilkanTabelAkunPerkiraan').html(data);
        }
    });
});
//Ketika Modal Tambah Akun Perkiraan Muncul
$('#ModalTambahAkunPerkiraan').on('show.bs.modal', function (e) {
    var id_perkiraan = $(e.relatedTarget).data('id');
    $('#NotifikasiTambahAkunPerkiraan').html('<span class="text-primary">Pastikan data akun perkiraan yang anda input sudah benar</span>');
    $('#FormTambahAkunPerkiraan').html('<div class="modal-body">Loading...</div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/FormTambahAkunPerkiraan.php',
        data 	    :  {id_perkiraan: id_perkiraan},
        success     : function(data){
            $('#FormTambahAkunPerkiraan').html(data);
        }
    });
});
//Ketika Proses Tambah Akun Perkiraan Dimulai
$('#ProsesTambahAkunPerkiraan').submit(function(){
    var ProsesTambahAkunPerkiraan = $('#ProsesTambahAkunPerkiraan').serialize();
    $('#NotifikasiTambahAkunPerkiraan').html('<small class="text-primary">Loading...</small>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/ProsesTambahTarifTindakan.php',
        data 	    :  ProsesTambahAkunPerkiraan,
        success     : function(data){
            $('#NotifikasiTambahAkunPerkiraan').html(data);
            var NotifikasiTambahAkunPerkiraanBerhasil=$('#NotifikasiTambahAkunPerkiraanBerhasil').html();
            if(NotifikasiTambahAkunPerkiraanBerhasil=="Success"){
                //Reset Form
                $('#ProsesTambahAkunPerkiraan')[0].reset();
                //Tutup Modal
                $('#ModalTambahAkunPerkiraan').modal('hide');
                $('#ModalDetailAkunPerkiraan').modal('hide');
                //Tampilkan Data
                var BatasPencarian = $('#BatasPencarian').serialize();
                $('#MenampilkanTabelAkunPerkiraan').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center"><span class="text-primary">Loading...</span></div></div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/AkunPerkiraan/TabelAkunPerkiraan.php',
                    data 	    :  BatasPencarian,
                    success     : function(data){
                        $('#MenampilkanTabelAkunPerkiraan').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Tambah Akun Perkiraan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Detail Akun Perkiraan
$('#ModalDetailAkunPerkiraan').on('show.bs.modal', function (e) {
    var id_perkiraan = $(e.relatedTarget).data('id');
    $('#FormDetailAkunPerkiraan').html('<div class="modal-body">Loading...</div>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/FormDetailAkunPerkiraan.php',
        data 	    :  {id_perkiraan: id_perkiraan},
        success     : function(data){
            $('#FormDetailAkunPerkiraan').html(data);
        }
    });
});
//Modal Edit Akun Perkiraan
$('#ModalEditAkunPerkiraan').on('show.bs.modal', function (e) {
    var id_perkiraan = $(e.relatedTarget).data('id');
    $('#FormEditAkunPerkiraan').html('<div class="modal-body">Loading...</div>');
    $('#NotifikasiEditAkunPerkiraan').html('<span class="text-primary">Pastikan informasi perubahan pada akun perkiraan yang anda input sudah benar</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/FormEditAkunPerkiraan.php',
        data 	    :  {id_perkiraan: id_perkiraan},
        success     : function(data){
            $('#FormEditAkunPerkiraan').html(data);
        }
    });
});
//Ketika Proses Edit Akun Perkiraan Dimulai
$('#ProsesEditAkunPerkiraan').submit(function(){
    var ProsesEditAkunPerkiraan = $('#ProsesEditAkunPerkiraan').serialize();
    $('#NotifikasiEditAkunPerkiraan').html('<small class="text-primary">Loading...</small>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/ProsesEditAkunPerkiraan.php',
        data 	    :  ProsesEditAkunPerkiraan,
        success     : function(data){
            $('#NotifikasiEditAkunPerkiraan').html(data);
            var NotifikasiEditAkunPerkiraanBerhasil=$('#NotifikasiEditAkunPerkiraanBerhasil').html();
            if(NotifikasiEditAkunPerkiraanBerhasil=="Success"){
                //Reset Form
                $('#ProsesEditAkunPerkiraan')[0].reset();
                //Tutup Modal
                $('#ModalEditAkunPerkiraan').modal('hide');
                $('#ModalDetailAkunPerkiraan').modal('hide');
                //Tampilkan Data
                var BatasPencarian = $('#BatasPencarian').serialize();
                $('#MenampilkanTabelAkunPerkiraan').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center"><span class="text-primary">Loading...</span></div></div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/AkunPerkiraan/TabelAkunPerkiraan.php',
                    data 	    :  BatasPencarian,
                    success     : function(data){
                        $('#MenampilkanTabelAkunPerkiraan').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Edit Akun Perkiraan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});
//Modal Hapus Akun Perkiraan
$('#ModalHapusAkunPerkiraan').on('show.bs.modal', function (e) {
    var id_perkiraan = $(e.relatedTarget).data('id');
    $('#PutIdPerkiraanForHapus').val(id_perkiraan);
    $('#NotifikasiHapusAkunPerkiraan').html('<span class="text-primary">Apakah anda yakin akan menghapus akun perkiraan ini?</span>');
});
//Ketika Proses Hapus Akun Perkiraan Dimulai
$('#ProsesHapusAkunPerkiraan').submit(function(){
    var ProsesHapusAkunPerkiraan = $('#ProsesHapusAkunPerkiraan').serialize();
    $('#NotifikasiHapusAkunPerkiraan').html('<span class="text-primary">Loading...</span>');
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/AkunPerkiraan/ProsesHapusAkunPerkiraan.php',
        data 	    :  ProsesHapusAkunPerkiraan,
        success     : function(data){
            $('#NotifikasiHapusAkunPerkiraan').html(data);
            var NotifikasiHapusAkunPerkiraanBerhasil=$('#NotifikasiHapusAkunPerkiraanBerhasil').html();
            if(NotifikasiHapusAkunPerkiraanBerhasil=="Success"){
                //Reset Form
                $('#ProsesHapusAkunPerkiraan')[0].reset();
                //Tutup Modal
                $('#ModalHapusAkunPerkiraan').modal('hide');
                $('#ModalDetailAkunPerkiraan').modal('hide');
                //Tampilkan Data
                var BatasPencarian = $('#BatasPencarian').serialize();
                $('#MenampilkanTabelAkunPerkiraan').html('<div class="card-body"><div class="row"><div class="col-md-12 text-center"><span class="text-primary">Loading...</span></div></div></div>');
                $.ajax({
                    type 	    : 'POST',
                    url 	    : '_Page/AkunPerkiraan/TabelAkunPerkiraan.php',
                    data 	    :  BatasPencarian,
                    success     : function(data){
                        $('#MenampilkanTabelAkunPerkiraan').html(data);
                    }
                });
                //Tampilkan Swal
                Swal.fire({
                    title: 'Good Job!',
                    text: 'Hapus Akun Perkiraan Berhasil',
                    icon: 'success',
                    confirmButtonText: 'Tutup'
                })
            }
        }
    });
});