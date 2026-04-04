// Menampilkan Profile Saya
function ProfilSaya() {
    
    // Loading
    $('#content_my_profile').html('<div class="col-12 text-center">Loading...</div>');

    $.ajax({
        type: 'POST',
        url: '_Page/ProfileUser/FormProfile.php',
        success: function(data) {
            $('#content_my_profile').html(data);
        }
    });
}

// Ijin Akses
function TabelIjinAkses() {
    var ProsesFilterIjinAkses = $('#ProsesFilterIjinAkses').serialize();
    $.ajax({
        type   : 'POST',
        url    : '_Page/ProfileUser/TabelIjinAkses.php',
        data   : ProsesFilterIjinAkses,
        success: function(data) {
            $('#tabel_ijin_akses').html(data);
        }
    });
}

// Tabel Laporan Kesalahan
function TabelLaporanKesalahan() {
    var page = $('#page_laporan_kesalahan').val();
    $.ajax({
        type   : 'POST',
        url    : '_Page/ProfileUser/TabelLaporanKesalahan.php',
        data   : {page: page},
        success: function(data) {
            $('#TabelLaporanKesalahan').html(data);
        }
    });
}

//Menampilkan Data Pertama Kali
$(document).ready(function() {

    // Tampilkan Data Pertama Kali
    ProfilSaya();
    TabelIjinAkses();
    TabelLaporanKesalahan();

    // ============================================================
    // GANTI FOTO PROFILE - START
    // ============================================================
    //Modal Ganti Foto
    $('#ModalEditFoto').on('show.bs.modal', function (e) {

        // Loading Form 'FormGantiFoto'
        $('#FormGantiFoto').html('Loading...');

        // Remove Notification Form 'NotifikasiGantiFoto'
        $('#NotifikasiGantiFoto').html('');

        // Show Form With Ajax 'FormGantiFoto'
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ProfileUser/FormGantiFoto.php',
            success     : function(data){
                $('#FormGantiFoto').html(data);
            }
        });
    });

    // Drag And Drop File
    // Cegah browser membuka file saat drag/drop
    $(document).on('dragenter dragover drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
    });

    // Saat file diarahkan ke area
    $(document).on('dragenter dragover', '.upload-area', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragover');
    });

    // Saat file keluar dari area
    $(document).on('dragleave', '.upload-area', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
    });

    // Saat file dijatuhkan
    $(document).on('drop', '.upload-area', function(e) {
        e.preventDefault();
        e.stopPropagation();

        $(this).removeClass('dragover');

        let files = e.originalEvent.dataTransfer.files;

        if (files.length > 0) {
            let input = document.getElementById('file_foto');

            let dt = new DataTransfer();
            dt.items.add(files[0]);

            input.files = dt.files;

            // trigger preview
            $(input).trigger('change');
        }
    });

    $(document).on('change', '#file_foto', function () {
        let file = this.files[0];

        if (file) {
            let reader = new FileReader();

            reader.onload = function (e) {
                $('#preview_foto').html(`
                    <img src="${e.target.result}" 
                        class="img-thumbnail"
                        style="max-height:200px; border-radius:12px;">
                `);
            };

            reader.readAsDataURL(file);
        }
    });

    //Proses Edit Foto
    $('#ProsesGantiFoto').submit(function(e){
        e.preventDefault();

        // Loading Notifikasi
        $('#NotifikasiGantiFoto').html('Loading..');

        // Tangkap Data
        var form = $('#ProsesGantiFoto')[0];
        var data = new FormData(form);

        // Kirim Data Dengan AJAX
        $.ajax({
            type       : 'POST',
            url        : '_Page/ProfileUser/ProsesGantiFoto.php',
            data       : data,
            cache      : false,
            processData: false,
            contentType: false,
            enctype    : 'multipart/form-data',
            dataType   : 'json',
            success     : function(response){
                var status  = response.status || 'error';
                var message = response.message || 'Terjadi kesalahan';
                
                // Jika Berhasil
                if (status === 'success') {
                    // Kosongkan Notifikasi
                    $('#NotifikasiGantiFoto').html('');

                    // Tutup Modal
                    $('#ModalEditFoto').modal('hide');
                    $('.modal-backdrop').remove();

                    // Tampilkan Toast
                    tampilkanToast('Foto Profile berhasil diperbarui', 'success');

                    // Reload Profile Saya
                    ProfilSaya();
                    
                } else {
                    $('#NotifikasiGantiFoto').html('<div class="alert alert-danger">' + message + '</div>');
                }
            }
        });
    });

    // ============================================================
    // GANTI FOTO PROFILE - END
    // ============================================================

    // Ketika Click Filter Ijin Akses
    $('.modal_filter_ijin_akses').click(function(){
        // Tampilkan Modal
        $('#ModalFilterIjinAkses').modal('show');
    });

    // Ketyika Submit ProsesFilterIjinAkses
    $(document).on('submit', '#ProsesFilterIjinAkses', function (e) {
        e.preventDefault();
        // Kembalikan ke halaman 1
        $('#page_ijin_akses').val(1);

        // Tutup Modal
        $('#ModalFilterIjinAkses').modal('hide');

        // Muat Ulang TabelIjinAkses
        TabelIjinAkses();
    });

    // pagging TabelIjinAkses
     $(document).on('click', '#next_btn_ijin_akses', function() {
        var page_now = parseInt($('#page_ijin_akses').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_ijin_akses').val(next_page);
        TabelIjinAkses(0);
    });
    $(document).on('click', '#prev_btn_ijin_akses', function() {
        var page_now = parseInt($('#page_ijin_akses').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_ijin_akses').val(next_page);
        TabelIjinAkses(0);
    });

    // Menampilkan Modal List Ijin Akses
    $(document).on('click', '.show_own_fiture', function () {
        // Tangkap kategori
        var kategori = $(this).data('kategori');

        // Tampilkan modal
        $('#ModalListIjinAkses').modal('show');

        // Loading form
        $('#FormListIjinAkses').html('Loading...');

        $.ajax({
            type: 'POST',
            url: '_Page/ProfileUser/FormListIjinAkses.php',
            data: {
                kategori: kategori
            },
            success: function (data) {
                $('#FormListIjinAkses').html(data);
            }
        });
    });

    //Modal Edit Profile
    $('#ModalEditProfile').on('show.bs.modal', function (e) {
        // Loading
        $('#FormEditProfile').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditProfile').html('');

        // Tampilkan Form
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ProfileUser/FormEditProfile.php',
            success     : function(data){
                $('#FormEditProfile').html(data);
            }
        });
    });

    //Proses Edit Profile (delegated, form dimuat via AJAX)
    $(document).on('submit', '#ProsesEditProfile', function (e) {
        e.preventDefault();

        var $form    = $(this);
        var formData = $form.serialize();
        var $notif   = $('#NotifikasiEditProfile');
        var $btn     = $form.find('button[type="submit"]');

        $notif.html('Loading...');
        $btn.prop('disabled', true);

        $.ajax({
            type    : 'POST',
            url     : '_Page/ProfileUser/ProsesEditProfile.php',
            data    : formData,
            dataType: 'json',

            beforeSend: function () {
                $notif.html('<small>Loading...</small>');
            },

            success: function (response) {
                if (!response || typeof response !== 'object') {
                    $notif.html('<div class="alert alert-danger">Response tidak valid</div>');
                    return;
                }

                var status  = response.status || 'error';
                var message = response.message || 'Terjadi kesalahan';

                if (status === 'success') {
                    // Tutup Modal
                    $('#ModalEditProfile').modal('hide');
                    $('.modal-backdrop').remove();

                    // Tampilkan Toast
                    tampilkanToast('Profile berhasil diperbarui', 'success');

                    // Reload Profile Saya
                    ProfilSaya();
                    
                } else {
                    $notif.html('<div class="alert alert-danger">' + message + '</div>');
                }
            },

            error: function (xhr) {
                console.error('AJAX Error:', xhr.responseText);
                $notif.html('<div class="alert alert-danger">Server error / response tidak valid</div>');
            },

            complete: function () {
                $btn.prop('disabled', false);
            }
        });
    });

});





//Modal Ganti Password
$('#ModalGantiPassword').on('show.bs.modal', function (e) {
    
    // Loading
    $('#FormGantiPassword').html('Loading...');

    // Kosongkan Notifikasi
    $('#NotifikasiGantiPassword').html('Loading...');

    // Tampilkan Form Dengan Ajax
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/ProfileUser/FormGantiPassword.php',
        success     : function(data){
            $('#FormGantiPassword').html(data);
            
            //Event saat tampilkan password
            $('#TampilkanPasswordProfile').click(function(){
                if($(this).is(':checked')){
                    $('#password1').attr('type','text');
                    $('#password2').attr('type','text');
                }else{
                    $('#password1').attr('type','password');
                    $('#password2').attr('type','password');
                }
            });
        }
    });
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


