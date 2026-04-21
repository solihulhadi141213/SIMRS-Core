// Tabel Sifarma
function TabelSettingSifarma() {
    
    let target = $('#tabel_setting_sifarma');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/SettingSifarma/TabelSettingSifarma.php',
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
    TabelSettingSifarma();

    //==================================================================
    // TAMBAH SIFARMA
    //==================================================================
    // Ketika Modal Tambah Pengaturan Muncul - Fokus Ke form setting_name
    $('#ModalTambahSettingSifarma').on('shown.bs.modal', function () {
        $('#nama_setting_sifarma').focus();
    });

    // HANDLE SUBMIT TAMBAH SIFARMA
    $(document).on('submit', '#ProsesTambahSettingSifarma', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambahSettingSifarma');
        let modal = $('#ModalTambahSettingSifarma');
        let notifikasi = $('#NotifikasiTambahSettingSifarma');

        let buttonText = button.html();

        // reset notifikasi
        notifikasi.html('');

        // loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/SettingSifarma/ProsesTambahSettingSifarma.php',
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
                        title            : 'Tambah Sifarma Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });


                    // refresh tabel
                    TabelSettingSifarma();

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
    // DETAIL SIFARMA
    //==================================================================
    $(document).on('click', '.modal_detail_setting_sifarma', function () {

        // Tangkap ID Sifarma
        var id_setting_sifarma = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailSifarma').modal('show');

        // Loading Form
        $('#FormDetailSifarma').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingSifarma/FormDetailSifarma.php',
            data        : {id_setting_sifarma: id_setting_sifarma},
            success     : function(data){
                $('#FormDetailSifarma').html(data);
            }
        });
    });

    //==================================================================
    // UJI COBA KONEKSI SIFARMA
    //==================================================================
    $(document).on('click', '.modal_koneksi_setting_sifarma', function () {

        // Tangkap ID Sifarma
        var id_setting_sifarma = $(this).data('id');

        // Munculkan Modal
        $('#ModalKoneksiSifarma').modal('show');

        // Loading Form
        $('#FormKoneksiSifarma').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingSifarma/FormKoneksiSifarma.php',
            data        : {id_setting_sifarma: id_setting_sifarma},
            success     : function(data){
                $('#FormKoneksiSifarma').html(data);
            }
        });
    });

    //==================================================================
    // EDIT SIFARMA
    //==================================================================
    $(document).on('click', '.modal_edit_setting_sifarma', function () {

        // Tangkap ID Sifarma
        var id_setting_sifarma = $(this).data('id');

        // Munculkan Modal
        $('#ModalEditSettingSifarma').modal('show');

        // Loading Form
        $('#FormEditSettingSifarma').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditSettingSifarma').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingSifarma/FormEditSettingSifarma.php',
            data        : {id_setting_sifarma: id_setting_sifarma},
            success     : function(data){
                $('#FormEditSettingSifarma').html(data);
            }
        });
    });

    // SUBMIT EDIT SIFARMA
    $(document).on('submit', '#ProsesEditSettingSifarma', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        // Simpan tombol awal
        let btn = $('#ButtonEditSifarma');
        let btnHtml = btn.html();

        // Loading button
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Loading...');

        // Kosongkan notifikasi
        $('#NotifikasiEditSettingSifarma').html('');

        $.ajax({
            type: 'POST',
            url: '_Page/SettingSifarma/ProsesEditSettingSifarma.php',
            data: formData,
            dataType: 'JSON',
            success: function (response) {

                if (response.status === 'success') {

                    // Tutup modal
                    $('#ModalEditSettingSifarma').modal('hide');

                    // Refresh Tabel
                    TabelSettingSifarma();

                    // Toast sukses
                    tampilkanToast('Sifarma berhasil diperbarui', 'success');

                } else {
                    $('#NotifikasiEditSettingSifarma').html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },
            error: function () {
                $('#NotifikasiEditSettingSifarma').html(`
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
    // HAPUS SIFARMA
    //==================================================================
    $(document).on('click', '.modal_hapus_setting_sifarma', function () {

        // Tangkap ID Sifarma
        var id_setting_sifarma = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusSettingSifarma').modal('show');

        // Loading Form
        $('#FormHapusSettingSifarma').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusSettingSifarma').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingSifarma/FormHapusSettingSifarma.php',
            data        : {id_setting_sifarma: id_setting_sifarma},
            success     : function(data){
                $('#FormHapusSettingSifarma').html(data);
            }
        });
    });

    // Submit Hapus Sifarma
    $(document).on('submit', '#ProsesHapusSettingSifarma', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusSettingSifarma');
        let modal      = $('#ModalHapusSettingSifarma');
        let notifikasi = $('#NotifikasiHapusSettingSifarma');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/SettingSifarma/ProsesHapusSettingSifarma.php',
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
                        title            : 'Hapus Sifarma Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelSettingSifarma();

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
