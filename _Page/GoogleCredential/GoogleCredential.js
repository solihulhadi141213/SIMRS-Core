// Tabel Google Credential
function TabelGoogleCredential() {
    
    let target = $('#tabel_google_credential');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/GoogleCredential/TabelGoogleCredential.php',
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


// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {
    TabelGoogleCredential();

    //==================================================================
    // TAMBAH GOOGLE CREDENTIAL
    //==================================================================
    // Ketika Modal Tambah Pengaturan Muncul - Fokus Ke form setting_name
    $('#ModalTambahGoogleCredential').on('shown.bs.modal', function () {
        $('#credential_env').focus();
    });

    // HANDLE SUBMIT TAMBAH GOOGLE CREDENTIAL
    $(document).on('submit', '#ProsesTambahGoogleCredential', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambahGoogleCredential');
        let modal = $('#ModalTambahGoogleCredential');
        let notifikasi = $('#NotifikasiTambahGoogleCredential');

        let buttonText = button.html();

        // reset notifikasi
        notifikasi.html('');

        // loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/GoogleCredential/ProsesTambahGoogleCredential.php',
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
                        title            : 'Tambah Google Credential Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });


                    // refresh tabel
                    TabelGoogleCredential();

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
    // DETAIL GOOGLE CREDENTIAL
    //==================================================================
    $(document).on('click', '.modal_detail_google_credential', function () {

        // Tangkap ID Google Credential
        var id_setting_google = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailGoogleCredential').modal('show');

        // Loading Form
        $('#FormDetailGoogleCredential').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/GoogleCredential/FormDetailGoogleCredential.php',
            data        : {id_setting_google: id_setting_google},
            success     : function(data){
                $('#FormDetailGoogleCredential').html(data);
            }
        });
    });

    //==================================================================
    // EDIT GOOGLE CREDENTIAL
    //==================================================================
    $(document).on('click', '.modal_edit_google_credential', function () {

        // Tangkap ID Google Credential
        var id_setting_google = $(this).data('id');

        // Munculkan Modal
        $('#ModalEditGoogleCredential').modal('show');

        // Loading Form
        $('#FormEditGoogleCredential').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditGoogleCredential').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/GoogleCredential/FormEditGoogleCredential.php',
            data        : {id_setting_google: id_setting_google},
            success     : function(data){
                $('#FormEditGoogleCredential').html(data);
            }
        });
    });

    // SUBMIT EDIT GOOGLE CREDENTIAL
    $(document).on('submit', '#ProsesEditGoogleCredential', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        // Simpan tombol awal
        let btn = $('#ButtonEditGoogleCredential');
        let btnHtml = btn.html();

        // Loading button
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Loading...');

        // Kosongkan notifikasi
        $('#NotifikasiEditGoogleCredential').html('');

        $.ajax({
            type: 'POST',
            url: '_Page/GoogleCredential/ProsesEditGoogleCredential.php',
            data: formData,
            dataType: 'JSON',
            success: function (response) {

                if (response.status === 'success') {

                    // Tutup modal
                    $('#ModalEditGoogleCredential').modal('hide');

                    // Refresh Tabel
                    TabelGoogleCredential();

                    // Toast sukses
                    tampilkanToast('Google Credential berhasil diperbarui', 'success');

                } else {
                    $('#NotifikasiEditGoogleCredential').html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },
            error: function () {
                $('#NotifikasiEditGoogleCredential').html(`
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
    // HAPUS Google Credential
    //==================================================================
    $(document).on('click', '.modal_hapus_google_credential', function () {

        // Tangkap ID Google Credential
        var id_setting_google = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusGoogleCredential').modal('show');

        // Loading Form
        $('#FormHapusGoogleCredential').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusGoogleCredential').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/GoogleCredential/FormHapusGoogleCredential.php',
            data        : {id_setting_google: id_setting_google},
            success     : function(data){
                $('#FormHapusGoogleCredential').html(data);
            }
        });
    });

    // Submit Hapus Google Credential
    $(document).on('submit', '#ProsesHapusGoogleCredential', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusGoogleCredential');
        let modal      = $('#ModalHapusGoogleCredential');
        let notifikasi = $('#NotifikasiHapusGoogleCredential');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/GoogleCredential/ProsesHapusGoogleCredential.php',
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
                        title            : 'Hapus Google Credential Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelGoogleCredential();

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