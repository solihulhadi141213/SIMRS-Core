// Tabel Satu Sehat
function TabelSettingSatuSehat() {
    
    let target = $('#tabel_setting_satusehat');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/SettingSatuSehat/TabelSettingSatuSehat.php',
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
    TabelSettingSatuSehat();

    //==================================================================
    // TAMBAH SATUSEHAT
    //==================================================================
    // Ketika Modal Tambah Pengaturan Muncul - Fokus Ke form setting_name
    $('#ModalTambahSettingSatuSehat').on('shown.bs.modal', function () {
        $('#nama_setting_satusehat').focus();
    });

    // HANDLE SUBMIT TAMBAH SATUSEHAT
    $(document).on('submit', '#ProsesTambahSettingSatuSehat', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambahSettingSatuSehat');
        let modal = $('#ModalTambahSettingSatuSehat');
        let notifikasi = $('#NotifikasiTambahSettingSatuSehat');

        let buttonText = button.html();

        // reset notifikasi
        notifikasi.html('');

        // loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/SettingSatuSehat/ProsesTambahSettingSatuSehat.php',
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
                        title            : 'Tambah Satu Sehat Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });


                    // refresh tabel
                    TabelSettingSatuSehat();

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
    // DETAIL SATUSEHAT
    //==================================================================
    $(document).on('click', '.modal_detail_setting_satusehat', function () {

        // Tangkap ID Satu Sehat
        var id_setting_satusehat = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailSatuSehat').modal('show');

        // Loading Form
        $('#FormDetailSatuSehat').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingSatuSehat/FormDetailSatuSehat.php',
            data        : {id_setting_satusehat: id_setting_satusehat},
            success     : function(data){
                $('#FormDetailSatuSehat').html(data);
            }
        });
    });

    //==================================================================
    // UJI COBA KONEKSI SATUSEHAT
    //==================================================================
    $(document).on('click', '.modal_koneksi_setting_satusehat', function () {

        // Tangkap ID Satu Sehat
        var id_setting_satusehat = $(this).data('id');

        // Munculkan Modal
        $('#ModalKoneksiSatuSehat').modal('show');

        // Loading Form
        $('#FormKoneksiSatuSehat').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingSatuSehat/FormKoneksiSatuSehat.php',
            data        : {id_setting_satusehat: id_setting_satusehat},
            success     : function(data){
                $('#FormKoneksiSatuSehat').html(data);
            }
        });
    });

    //==================================================================
    // EDIT SATUSEHAT
    //==================================================================
    $(document).on('click', '.modal_edit_setting_satusehat', function () {

        // Tangkap ID Satu Sehat
        var id_setting_satusehat = $(this).data('id');

        // Munculkan Modal
        $('#ModalEditSettingSatuSehat').modal('show');

        // Loading Form
        $('#FormEditSettingSatuSehat').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditSettingSatuSehat').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingSatuSehat/FormEditSettingSatuSehat.php',
            data        : {id_setting_satusehat: id_setting_satusehat},
            success     : function(data){
                $('#FormEditSettingSatuSehat').html(data);
            }
        });
    });

    // SUBMIT EDIT SATUSEHAT
    $(document).on('submit', '#ProsesEditSettingSatuSehat', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        // Simpan tombol awal
        let btn = $('#ButtonEditSettingSatuSehat');
        let btnHtml = btn.html();

        // Loading button
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Loading...');

        // Kosongkan notifikasi
        $('#NotifikasiEditSettingSatuSehat').html('');

        $.ajax({
            type: 'POST',
            url: '_Page/SettingSatuSehat/ProsesEditSettingSatuSehat.php',
            data: formData,
            dataType: 'JSON',
            success: function (response) {

                if (response.status === 'success') {

                    // Tutup modal
                    $('#ModalEditSettingSatuSehat').modal('hide');

                    // Refresh Tabel
                    TabelSettingSatuSehat();

                    // Toast sukses
                    tampilkanToast('Satu Sehat berhasil diperbarui', 'success');

                } else {
                    $('#NotifikasiEditSettingSatuSehat').html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },
            error: function () {
                $('#NotifikasiEditSettingSatuSehat').html(`
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
    // HAPUS SATUSEHAT
    //==================================================================
    $(document).on('click', '.modal_hapus_setting_satusehat', function () {

        // Tangkap ID Satu Sehat
        var id_setting_satusehat = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusSettingSatuSehat').modal('show');

        // Loading Form
        $('#FormHapusSettingSatuSehat').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusSettingSatuSehat').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingSatuSehat/FormHapusSettingSatuSehat.php',
            data        : {id_setting_satusehat: id_setting_satusehat},
            success     : function(data){
                $('#FormHapusSettingSatuSehat').html(data);
            }
        });
    });

    // Submit Hapus Satu Sehat
    $(document).on('submit', '#ProsesHapusSettingSatuSehat', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusSettingSatuSehat');
        let modal      = $('#ModalHapusSettingSatuSehat');
        let notifikasi = $('#NotifikasiHapusSettingSatuSehat');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/SettingSatuSehat/ProsesHapusSettingSatuSehat.php',
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
                        title            : 'Hapus Satu Sehat Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelSettingSatuSehat();

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