// Tabel Analyza
function TabelSettingAnalyza() {
    
    let target = $('#tabel_setting_analyza');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/SettingAnalyza/TabelSettingAnalyza.php',
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
    TabelSettingAnalyza();

    //==================================================================
    // TAMBAH ANALYZA
    //==================================================================
    // Ketika Modal Tambah Pengaturan Muncul - Fokus Ke form setting_name
    $('#ModalTambahSettingAnalyza').on('shown.bs.modal', function () {
        $('#nama_setting_analyza').focus();
    });

    // HANDLE SUBMIT TAMBAH ANALYZA
    $(document).on('submit', '#ProsesTambahSettingAnalyza', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambahSettingAnalyza');
        let modal = $('#ModalTambahSettingAnalyza');
        let notifikasi = $('#NotifikasiTambahSettingAnalyza');

        let buttonText = button.html();

        // reset notifikasi
        notifikasi.html('');

        // loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/SettingAnalyza/ProsesTambahSettingAnalyza.php',
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
                        title            : 'Tambah Analyza Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });


                    // refresh tabel
                    TabelSettingAnalyza();

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
    // DETAIL ANALYZA
    //==================================================================
    $(document).on('click', '.modal_detail_setting_analyza', function () {

        // Tangkap ID Analyza
        var id_setting_analyza = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailAnalyza').modal('show');

        // Loading Form
        $('#FormDetailAnalyza').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingAnalyza/FormDetailAnalyza.php',
            data        : {id_setting_analyza: id_setting_analyza},
            success     : function(data){
                $('#FormDetailAnalyza').html(data);
            }
        });
    });

    //==================================================================
    // UJI COBA KONEKSI ANALYZA
    //==================================================================
    $(document).on('click', '.modal_koneksi_setting_analyza', function () {

        // Tangkap ID Analyza
        var id_setting_analyza = $(this).data('id');

        // Munculkan Modal
        $('#ModalKoneksiAnalyza').modal('show');

        // Loading Form
        $('#FormKoneksiAnalyza').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingAnalyza/FormKoneksiAnalyza.php',
            data        : {id_setting_analyza: id_setting_analyza},
            success     : function(data){
                $('#FormKoneksiAnalyza').html(data);
            }
        });
    });

    //==================================================================
    // EDIT ANALYZA
    //==================================================================
    $(document).on('click', '.modal_edit_setting_analyza', function () {

        // Tangkap ID Analyza
        var id_setting_analyza = $(this).data('id');

        // Munculkan Modal
        $('#ModalEditSettingAnalyza').modal('show');

        // Loading Form
        $('#FormEditSettingAnalyza').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditSettingAnalyza').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingAnalyza/FormEditSettingAnalyza.php',
            data        : {id_setting_analyza: id_setting_analyza},
            success     : function(data){
                $('#FormEditSettingAnalyza').html(data);
            }
        });
    });

    // SUBMIT EDIT ANALYZA
    $(document).on('submit', '#ProsesEditSettingAnalyza', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        // Simpan tombol awal
        let btn = $('#ButtonEditAnalyza');
        let btnHtml = btn.html();

        // Loading button
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Loading...');

        // Kosongkan notifikasi
        $('#NotifikasiEditSettingAnalyza').html('');

        $.ajax({
            type: 'POST',
            url: '_Page/SettingAnalyza/ProsesEditSettingAnalyza.php',
            data: formData,
            dataType: 'JSON',
            success: function (response) {

                if (response.status === 'success') {

                    // Tutup modal
                    $('#ModalEditSettingAnalyza').modal('hide');

                    // Refresh Tabel
                    TabelSettingAnalyza();

                    // Toast sukses
                    tampilkanToast('Analyza berhasil diperbarui', 'success');

                } else {
                    $('#NotifikasiEditSettingAnalyza').html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },
            error: function () {
                $('#NotifikasiEditSettingAnalyza').html(`
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
    // HAPUS ANALYZA
    //==================================================================
    $(document).on('click', '.modal_hapus_setting_analyza', function () {

        // Tangkap ID Analyza
        var id_setting_analyza = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusSettingAnalyza').modal('show');

        // Loading Form
        $('#FormHapusSettingAnalyza').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusSettingAnalyza').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingAnalyza/FormHapusSettingAnalyza.php',
            data        : {id_setting_analyza: id_setting_analyza},
            success     : function(data){
                $('#FormHapusSettingAnalyza').html(data);
            }
        });
    });

    // Submit Hapus Analyza
    $(document).on('submit', '#ProsesHapusSettingAnalyza', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusSettingAnalyza');
        let modal      = $('#ModalHapusSettingAnalyza');
        let notifikasi = $('#NotifikasiHapusSettingAnalyza');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/SettingAnalyza/ProsesHapusSettingAnalyza.php',
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
                        title            : 'Hapus Analyza Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelSettingAnalyza();

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
