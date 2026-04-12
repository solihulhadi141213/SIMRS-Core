// Tabel Email Gateway
function TabelEmailGateway() {
    
    let target = $('#tabel_email_gateway');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/EmailGateway/TabelEmailGateway.php',
        success: function(data) {
            target.css('opacity', '0');

            setTimeout(function () {
                target.html(data)
                      .addClass('blur-loading')
                      .css('opacity', '1');

                setTimeout(function () {
                    target.removeClass('blur-loading');
                }, 200);
            }, 150);
        }
    });
}

// FUNCTION GENERATE RANDOM STRING
function generateRandomString(length = 32) {
    let chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';

    for (let i = 0; i < length; i++) {
        result += chars.charAt(Math.floor(Math.random() * chars.length));
    }

    return result;
}

// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {
    TabelEmailGateway();

    //==================================================================
    // TAMBAH EMAIL GATEWAY
    //==================================================================
    // Ketika Modal Tambah Pengaturan Muncul - Fokus Ke form setting_name
    $('#ModalTambahEmailGateway').on('shown.bs.modal', function () {
        $('#email_gateway').focus();
    });

    // HANDLE SUBMIT TAMBAH EMAIL GATEWAY
    $(document).on('submit', '#ProsesTambahEmailGateway', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambahEmailGateway');
        let modal = $('#ModalTambahEmailGateway');
        let notifikasi = $('#NotifikasiTambahEmailGateway');

        let buttonText = button.html();

        // reset notifikasi
        notifikasi.html('');

        // loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/EmailGateway/ProsesTambahEmailGateway.php',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',

            success: function (response) {

                // tombol kembali normal
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // reset form
                    form[0].reset();

                    // tutup modal
                    modal.modal('hide');

                    // toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Email Gateway Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });


                    // refresh tabel
                    TabelEmailGateway();

                } else {
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            ${response.message}
                        </div>
                    `);
                }
            },

            error: function () {
                button.prop('disabled', false).html(buttonText);

                notifikasi.html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan pada server.
                    </div>
                `);
            }
        });
    });

    //==================================================================
    // DETAIL EMAIL GATEWAY
    //==================================================================
    $(document).on('click', '.modal_detail_email_gateway', function () {

        // Tangkap ID Email Gateway
        var id_setting_email_gateway = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailEmailGateway').modal('show');

        // Loading Form
        $('#FormDetailEmailGateway').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/EmailGateway/FormDetailEmailGateway.php',
            data        : {id_setting_email_gateway: id_setting_email_gateway},
            success     : function(data){
                $('#FormDetailEmailGateway').html(data);
            }
        });
    });

    //==================================================================
    // EDIT EMAIL GATEWAY
    //==================================================================
    $(document).on('click', '.modal_edit_email_gateway', function () {

        // Tangkap ID Email Gateway
        var id_setting_email_gateway = $(this).data('id');

        // Munculkan Modal
        $('#ModalEditEmailGateway').modal('show');

        // Loading Form
        $('#FormEditEmailGateway').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditEmailGateway').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/EmailGateway/FormEditEmailGateway.php',
            data        : {id_setting_email_gateway: id_setting_email_gateway},
            success     : function(data){
                $('#FormEditEmailGateway').html(data);
            }
        });
    });

    // SUBMIT EDIT EMAIL GATEWAY
    $(document).on('submit', '#ProsesEditEmailGateway', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        // Simpan tombol awal
        let btn = $('#ButtonEditEmailGateway');
        let btnHtml = btn.html();

        // Loading button
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Loading...');

        // Kosongkan notifikasi
        $('#NotifikasiEditEmailGateway').html('');

        $.ajax({
            type: 'POST',
            url: '_Page/EmailGateway/ProsesEditEmailGateway.php',
            data: formData,
            dataType: 'JSON',
            success: function (response) {

                if (response.status === 'success') {

                    // Tutup modal
                    $('#ModalEditEmailGateway').modal('hide');

                    // Refresh Tabel
                    TabelEmailGateway();

                    // Toast sukses
                    tampilkanToast('Email Gateway berhasil diperbarui', 'success');

                } else {
                    $('#NotifikasiEditEmailGateway').html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },
            error: function () {
                $('#NotifikasiEditEmailGateway').html(`
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada server.</small>
                    </div>
                `);
            },
            complete: function () {
                btn.prop('disabled', false);
                btn.html(btnHtml);
            }
        });
    });

    //==================================================================
    // KIRIM EMAIL
    //==================================================================
    $(document).on('click', '.modal_kirim_email', function () {

        // Tangkap ID Email Gateway
        var id_setting_email_gateway = $(this).data('id');

        // Munculkan Modal
        $('#ModalKirimEmail').modal('show');

        // Loading Form
        $('#FormKirimEmail').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiKirimEmail').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/EmailGateway/FormKirimEmail.php',
            data        : {id_setting_email_gateway: id_setting_email_gateway},
            success     : function(data){
                $('#FormKirimEmail').html(data);
            }
        });
    });

    //==================================================================
    // HAPUS Email Gateway
    //==================================================================
    $(document).on('click', '.modal_hapus_email_gateway', function () {

        // Tangkap ID Email Gateway
        var id_setting_email_gateway = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusEmailGateway').modal('show');

        // Loading Form
        $('#FormHapusEmailGateway').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusEmailGateway').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/EmailGateway/FormHapusEmailGateway.php',
            data        : {id_setting_email_gateway: id_setting_email_gateway},
            success     : function(data){
                $('#FormHapusEmailGateway').html(data);
            }
        });
    });

    // Submit Kirim Email
    $(document).on('submit', '#ProsesKirimEmail', function (e) {
        e.preventDefault();

        // Data Dari Form
        let ProsesKirimEmail = $(this).serialize();

        // Loading Notifikasi
        $('#NotifikasiKirimEmail').html('Loading...');

        // Kirim Dengan AJAX
        $.ajax({
            url : '_Page/EmailGateway/ProsesKirimEmail.php',
            type: 'POST',
            data: ProsesKirimEmail,
            success: function (response) {
                $('#NotifikasiKirimEmail').html(response);
            }
        });
        
    });

    // Submit Hapus Email Gateway
    $(document).on('submit', '#ProsesHapusEmailGateway', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusEmailGateway');
        let modal      = $('#ModalHapusEmailGateway');
        let notifikasi = $('#NotifikasiHapusEmailGateway');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/EmailGateway/ProsesHapusEmailGateway.php',
            type: 'POST',
            data: formData,
            dataType: 'json',

            success: function (response) {
                // tombol kembali normal
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // tutup modal
                    modal.modal('hide');

                    // toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Hapus Email Gateway Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelEmailGateway();

                } else {
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            ${response.message}
                        </div>
                    `);
                }
            },

            error: function () {
                button.prop('disabled', false).html(buttonText);

                notifikasi.html(`
                    <div class="alert alert-danger">
                        Terjadi kesalahan pada server.
                    </div>
                `);
            }
        });
    });


});