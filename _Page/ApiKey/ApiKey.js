// Tabel API Key
function TabelApiKey() {
    
    let target = $('#tabel_api_key');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/ApiKey/TabelApiKey.php',
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
    TabelApiKey();

    //==================================================================
    // TAMBAH API KEY
    //==================================================================
    // Ketika Modal Tambah Pengaturan Muncul - Fokus Ke form setting_name
    $('#ModalTambahApiKey').on('shown.bs.modal', function () {
        $('#api_name').focus();
    });

    // GENERATE CLIENT ID
    $(document).on('click', '.generate_client_id', function () {
        $('#client_id').val(generateRandomString(32));
    });

    // GENERATE CLIENT KEY
    $(document).on('click', '.generate_client_key', function () {
        $('#client_key').val(generateRandomString(64));
    });

    // HANDLE SUBMIT TAMBAH API KEY
    $(document).on('submit', '#ProsesTambahApiKey', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambahApiKey');
        let modal = $('#ModalTambahApiKey');
        let notifikasi = $('#NotifikasiTambahApiKey');

        let buttonText = button.html();

        // reset notifikasi
        notifikasi.html('');

        // loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/ApiKey/ProsesTambahApiKey.php',
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

                    // tampilkan toast
                    $('#toast_message').html(response.message || 'Tambah API Key berhasil');
                    let toastElement = document.getElementById('liveToast');
                    let toastBootstrap = new bootstrap.Toast(toastElement, {
                        delay: 2000,
                        autohide: true
                    });
                    toastBootstrap.show();

                    // refresh tabel
                    TabelApiKey();

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
    // DETAIL API KEY
    //==================================================================
    $(document).on('click', '.modal_detail_api_key', function () {

        // Tangkap ID API Key
        var id_api_key = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailApiKey').modal('show');

        // Loading Form
        $('#FormDetailApiKey').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ApiKey/FormDetailApiKey.php',
            data        : {id_api_key: id_api_key},
            success     : function(data){
                $('#FormDetailApiKey').html(data);
            }
        });
    });

    //==================================================================
    // EDIT API KEY
    //==================================================================
    $(document).on('click', '.modal_edit_api_key', function () {

        // Tangkap ID API Key
        var id_api_key = $(this).data('id');

        // Munculkan Modal
        $('#ModalEditApiKey').modal('show');

        // Loading Form
        $('#FormEditApiKey').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditApiKey').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ApiKey/FormEditApiKey.php',
            data        : {id_api_key: id_api_key},
            success     : function(data){
                $('#FormEditApiKey').html(data);
            }
        });
    });

    // SUBMIT EDIT API KEY
    $(document).on('submit', '#ProsesEditApiKey', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        // Simpan tombol awal
        let btn = $('#ButtonEditApiKey');
        let btnHtml = btn.html();

        // Loading button
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Loading...');

        // Kosongkan notifikasi
        $('#NotifikasiEditApiKey').html('');

        $.ajax({
            type: 'POST',
            url: '_Page/ApiKey/ProsesEditApiKey.php',
            data: formData,
            dataType: 'JSON',
            success: function (response) {

                if (response.status === 'success') {

                    // Tutup modal
                    $('#ModalEditApiKey').modal('hide');

                    // Refresh Tabel
                    TabelApiKey();

                    // Toast sukses
                    tampilkanToast('API Key berhasil diperbarui', 'success');

                } else {
                    $('#NotifikasiEditApiKey').html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },
            error: function () {
                $('#NotifikasiEditApiKey').html(`
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
    // REGENERATE CLIENT KEY
    //==================================================================
    $(document).on('click', '.modal_regenerate_client_key', function () {

        // Tangkap ID API Key
        var id_api_key = $(this).data('id');

        // Munculkan Modal
        $('#ModalRegenerateClientKey').modal('show');

        // Loading Form
        $('#FormRegenerateClientKey').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiRegenerateClientKey').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ApiKey/FormRegenerateClientKey.php',
            data        : {id_api_key: id_api_key},
            success     : function(data){
                $('#FormRegenerateClientKey').html(data);
            }
        });
    });

    // GENERATE CLIENT ID (EDIT)
    $(document).on('click', '.generate_client_id_edit', function () {
        $('#client_id_edit').val(generateRandomString(32));
    });

    // GENERATE CLIENT KEY (EDIT)
    $(document).on('click', '.generate_client_key_edit', function () {
        $('#client_key_edit').val(generateRandomString(64));
    });

    // SUBMIT REGENERATE CLIENT KEY
    $(document).on('submit', '#ProsesRegenerateClientKey', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        // Simpan tombol awal
        let btn = $('#ButtonRegenerateClientKey');
        let btnHtml = btn.html();

        // Loading button
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Loading...');

        // Kosongkan notifikasi
        $('#NotifikasiEditApiKey').html('');

        $.ajax({
            type: 'POST',
            url: '_Page/ApiKey/ProsesRegenerateClientKey.php',
            data: formData,
            dataType: 'JSON',
            success: function (response) {

                if (response.status === 'success') {

                    // Tutup modal
                    $('#ModalRegenerateClientKey').modal('hide');

                    // Refresh Tabel
                    TabelApiKey();

                    // Toast sukses
                    tampilkanToast('Client Key berhasil diperbarui', 'success');

                } else {
                    $('#NotifikasiRegenerateClientKey').html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },
            error: function () {
                $('#NotifikasiRegenerateClientKey').html(`
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
    // HAPUS LOG TOKEN
    //==================================================================
    $(document).on('click', '.modal_hapus_log_token', function () {

        // Tangkap ID API Key
        var id_api_key = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusLogToken').modal('show');

        // Loading Form
        $('#FormHapusLogToken').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusLogToken').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ApiKey/FormHapusLogToken.php',
            data        : {id_api_key: id_api_key},
            success     : function(data){
                $('#FormHapusLogToken').html(data);
            }
        });
    });

    // Submit Hapus Log
    $(document).on('submit', '#ProsesHapusLogToken', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusLogToken');
        let modal      = $('#ModalHapusLogToken');
        let notifikasi = $('#NotifikasiHapusLogToken');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/ApiKey/ProsesHapusLogToken.php',
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
                        title            : 'Hapus Log Token Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelApiKey();

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
    // HAPUS API Key
    //==================================================================
    $(document).on('click', '.modal_hapus_api_key', function () {

        // Tangkap ID API Key
        var id_api_key = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusApiKey').modal('show');

        // Loading Form
        $('#FormHapusApiKey').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusApiKey').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ApiKey/FormHapusApiKey.php',
            data        : {id_api_key: id_api_key},
            success     : function(data){
                $('#FormHapusApiKey').html(data);
            }
        });
    });

    // Submit Hapus Api Key
    $(document).on('submit', '#ProsesHapusApiKey', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusApiKey');
        let modal      = $('#ModalHapusApiKey');
        let notifikasi = $('#NotifikasiHapusApiKey');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/ApiKey/ProsesHapusApiKey.php',
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
                        title            : 'Hapus API Key Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelApiKey();

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