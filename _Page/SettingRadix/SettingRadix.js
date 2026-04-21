// Tabel Radix
function TabelSettingRadix() {
    
    let target = $('#tabel_setting_radix');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/SettingRadix/TabelSettingRadix.php',
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
    TabelSettingRadix();

    //==================================================================
    // TAMBAH RADIX
    //==================================================================
    // Ketika Modal Tambah Pengaturan Muncul - Fokus Ke form setting_name
    $('#ModalTambahSettingRadix').on('shown.bs.modal', function () {
        $('#nama_setting_radix').focus();
    });

    // HANDLE SUBMIT TAMBAH RADIX
    $(document).on('submit', '#ProsesTambahSettingRadix', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambahSettingRadix');
        let modal = $('#ModalTambahSettingRadix');
        let notifikasi = $('#NotifikasiTambahSettingRadix');

        let buttonText = button.html();

        // reset notifikasi
        notifikasi.html('');

        // loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/SettingRadix/ProsesTambahSettingRadix.php',
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
                        title            : 'Tambah Radix Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });


                    // refresh tabel
                    TabelSettingRadix();

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
    // DETAIL RADIX
    //==================================================================
    $(document).on('click', '.modal_detail_setting_radix', function () {

        // Tangkap ID Radix
        var id_setting_radix = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailRadix').modal('show');

        // Loading Form
        $('#FormDetailRadix').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingRadix/FormDetailRadix.php',
            data        : {id_setting_radix: id_setting_radix},
            success     : function(data){
                $('#FormDetailRadix').html(data);
            }
        });
    });

    //==================================================================
    // UJI COBA KONEKSI RADIX
    //==================================================================
    $(document).on('click', '.modal_koneksi_setting_radix', function () {

        // Tangkap ID Radix
        var id_setting_radix = $(this).data('id');

        // Munculkan Modal
        $('#ModalKoneksiRadix').modal('show');

        // Loading Form
        $('#FormKoneksiRadix').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingRadix/FormKoneksiRadix.php',
            data        : {id_setting_radix: id_setting_radix},
            success     : function(data){
                $('#FormKoneksiRadix').html(data);
            }
        });
    });

    //==================================================================
    // EDIT RADIX
    //==================================================================
    $(document).on('click', '.modal_edit_setting_radix', function () {

        // Tangkap ID Radix
        var id_setting_radix = $(this).data('id');

        // Munculkan Modal
        $('#ModalEditSettingRadix').modal('show');

        // Loading Form
        $('#FormEditSettingRadix').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditSettingRadix').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingRadix/FormEditSettingRadix.php',
            data        : {id_setting_radix: id_setting_radix},
            success     : function(data){
                $('#FormEditSettingRadix').html(data);
            }
        });
    });

    // SUBMIT EDIT RADIX
    $(document).on('submit', '#ProsesEditSettingRadix', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        // Simpan tombol awal
        let btn = $('#ButtonEditRadix');
        let btnHtml = btn.html();

        // Loading button
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Loading...');

        // Kosongkan notifikasi
        $('#NotifikasiEditSettingRadix').html('');

        $.ajax({
            type: 'POST',
            url: '_Page/SettingRadix/ProsesEditSettingRadix.php',
            data: formData,
            dataType: 'JSON',
            success: function (response) {

                if (response.status === 'success') {

                    // Tutup modal
                    $('#ModalEditSettingRadix').modal('hide');

                    // Refresh Tabel
                    TabelSettingRadix();

                    // Toast sukses
                    tampilkanToast('Radix berhasil diperbarui', 'success');

                } else {
                    $('#NotifikasiEditSettingRadix').html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },
            error: function () {
                $('#NotifikasiEditSettingRadix').html(`
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
    // HAPUS RADIX
    //==================================================================
    $(document).on('click', '.modal_hapus_setting_radix', function () {

        // Tangkap ID Radix
        var id_setting_radix = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusSettingRadix').modal('show');

        // Loading Form
        $('#FormHapusSettingRadix').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusSettingRadix').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingRadix/FormHapusSettingRadix.php',
            data        : {id_setting_radix: id_setting_radix},
            success     : function(data){
                $('#FormHapusSettingRadix').html(data);
            }
        });
    });

    // Submit Hapus Radix
    $(document).on('submit', '#ProsesHapusSettingRadix', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusSettingRadix');
        let modal      = $('#ModalHapusSettingRadix');
        let notifikasi = $('#NotifikasiHapusSettingRadix');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/SettingRadix/ProsesHapusSettingRadix.php',
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
                        title            : 'Hapus Radix Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelSettingRadix();

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