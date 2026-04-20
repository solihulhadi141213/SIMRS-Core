// Fungsi untuk menampilkan Tabel SIRS Online
function TabelSettingSirsOnline() {
    
    let target = $('#tabel_setting_sirs_online');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/SettingSirsOnline/TabelSettingSirsOnline.php',
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


$(document).ready(function() {
    // MENAMPILKAN DATA PERTAMA KALI
    TabelSettingSirsOnline();

    //==================================================================
    // TAMBAH SISRS ONLINE
    //==================================================================
    // Ketika Modal Tambah Pengaturan Muncul - Fokus Ke form setting_name
    $('#ModalTambahSettingSirsOnline').on('shown.bs.modal', function () {
        $('#nama_setting_sirs_online').focus();
    });

    // HANDLE SUBMIT TAMBAH SISRS ONLINE
    $(document).on('submit', '#ProsesTambahSettingSirsOnline', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambahSettingSirsOnline');
        let modal = $('#ModalTambahSettingSirsOnline');
        let notifikasi = $('#NotifikasiTambahSettingSirsOnline');

        let buttonText = button.html();

        // reset notifikasi
        notifikasi.html('');

        // loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/SettingSirsOnline/ProsesTambahSettingSirsOnline.php',
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
                        title            : 'Tambah SIRS Online Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });


                    // refresh tabel
                    TabelSettingSirsOnline();

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
    // DETAIL SISRS ONLINE
    //==================================================================
    $(document).on('click', '.modal_detail_setting_sirs_online', function () {

        // Tangkap ID SIRS Online
        var id_setting_sirs_online = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailSirsOnline').modal('show');

        // Loading Form
        $('#FormDetailSirsOnline').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingSirsOnline/FormDetailSirsOnline.php',
            data        : {id_setting_sirs_online: id_setting_sirs_online},
            success     : function(data){
                $('#FormDetailSirsOnline').html(data);
            }
        });
    });

    //==================================================================
    // UJI COBA KONEKSI SISRS ONLINE
    //==================================================================
    $(document).on('click', '.modal_koneksi_setting_sirs_online', function () {

        // Tangkap ID SIRS Online
        var id_setting_sirs_online = $(this).data('id');

        // Munculkan Modal
        $('#ModalKoneksiSirsOnline').modal('show');

        // Loading Form
        $('#FormKoneksiSirsOnline').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingSirsOnline/FormKoneksiSirsOnline.php',
            data        : {id_setting_sirs_online: id_setting_sirs_online},
            success     : function(data){
                $('#FormKoneksiSirsOnline').html(data);
            }
        });
    });

    //==================================================================
    // EDIT SISRS ONLINE
    //==================================================================
    $(document).on('click', '.modal_edit_setting_sirs_online', function () {

        // Tangkap ID SIRS Online
        var id_setting_sirs_online = $(this).data('id');

        // Munculkan Modal
        $('#ModalEditSettingSirsOnline').modal('show');

        // Loading Form
        $('#FormEditSettingSirsOnline').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditSettingSirsOnline').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingSirsOnline/FormEditSettingSirsOnline.php',
            data        : {id_setting_sirs_online: id_setting_sirs_online},
            success     : function(data){
                $('#FormEditSettingSirsOnline').html(data);
            }
        });
    });

    // SUBMIT EDIT SISRS ONLINE
    $(document).on('submit', '#ProsesEditSettingSirsOnline', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        // Simpan tombol awal
        let btn = $('#ButtonEditSettingSirsOnline');
        let btnHtml = btn.html();

        // Loading button
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Loading...');

        // Kosongkan notifikasi
        $('#NotifikasiEditSettingSirsOnline').html('');

        $.ajax({
            type: 'POST',
            url: '_Page/SettingSirsOnline/ProsesEditSettingSirsOnline.php',
            data: formData,
            dataType: 'JSON',
            success: function (response) {

                if (response.status === 'success') {

                    // Tutup modal
                    $('#ModalEditSettingSirsOnline').modal('hide');

                    // Refresh Tabel
                    TabelSettingSirsOnline();

                    // Toast sukses
                    tampilkanToast('SIRS Online berhasil diperbarui', 'success');

                } else {
                    $('#NotifikasiEditSettingSirsOnline').html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },
            error: function () {
                $('#NotifikasiEditSettingSirsOnline').html(`
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
    // HAPUS SISRS ONLINE
    //==================================================================
    $(document).on('click', '.modal_hapus_setting_sirs_online', function () {

        // Tangkap ID SIRS Online
        var id_setting_sirs_online = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusSettingSirsOnline').modal('show');

        // Loading Form
        $('#FormHapusSettingSirsOnline').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusSettingSirsOnline').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingSirsOnline/FormHapusSettingSirsOnline.php',
            data        : {id_setting_sirs_online: id_setting_sirs_online},
            success     : function(data){
                $('#FormHapusSettingSirsOnline').html(data);
            }
        });
    });

    // Submit Hapus SIRS Online
    $(document).on('submit', '#ProsesHapusSettingSirsOnline', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusSettingSirsOnline');
        let modal      = $('#ModalHapusSettingSirsOnline');
        let notifikasi = $('#NotifikasiHapusSettingSirsOnline');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/SettingSirsOnline/ProsesHapusSettingSirsOnline.php',
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
                        title            : 'Hapus SIRS Online Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelSettingSirsOnline();

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