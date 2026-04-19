// Tabel Bridging PBJS
function TabelSettingBpjs() {
    
    let target = $('#tabel_setting_bpjs');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/SettingBpjs/TabelSettingBpjs.php',
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
    TabelSettingBpjs();

    //==================================================================
    // TAMBAH BRIDGING BPJS
    //==================================================================
    // Ketika Modal Tambah Pengaturan Muncul - Fokus Ke form setting_name
    $('#ModalTambahSettingBpjs').on('shown.bs.modal', function () {
        $('#nama_setting_bpjs').focus();
    });

    // HANDLE SUBMIT TAMBAH BRIDGING BPJS
    $(document).on('submit', '#ProsesTambahSettingBpjs', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambahSettingBpjs');
        let modal = $('#ModalTambahSettingBpjs');
        let notifikasi = $('#NotifikasiTambahSettingBpjs');

        let buttonText = button.html();

        // reset notifikasi
        notifikasi.html('');

        // loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/SettingBpjs/ProsesTambahSettingBpjs.php',
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
                        title            : 'Tambah Bridging PBJS Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });


                    // refresh tabel
                    TabelSettingBpjs();

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
    // DETAIL BRIDGING BPJS
    //==================================================================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap ID Bridging PBJS
        var id_setting_bpjs = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailBpjs').modal('show');

        // Loading Form
        $('#FormDetailBpjs').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingBpjs/FormDetailBpjs.php',
            data        : {id_setting_bpjs: id_setting_bpjs},
            success     : function(data){
                $('#FormDetailBpjs').html(data);
            }
        });
    });

    //==================================================================
    // UJI COBA KONEKSI BRIDGING BPJS
    //==================================================================
    $(document).on('click', '.modal_coba_koneksi', function () {

        // Tangkap ID Bridging PBJS
        var id_setting_bpjs = $(this).data('id');

        // Munculkan Modal
        $('#ModalKoneksiBpjs').modal('show');

        // Loading Form
        $('#FormKoneksiBpjs').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingBpjs/FormKoneksiBpjs.php',
            data        : {id_setting_bpjs: id_setting_bpjs},
            success     : function(data){
                $('#FormKoneksiBpjs').html(data);
            }
        });
    });

    //==================================================================
    // EDIT BRIDGING BPJS
    //==================================================================
    $(document).on('click', '.modal_edit', function () {

        // Tangkap ID Bridging PBJS
        var id_setting_bpjs = $(this).data('id');

        // Munculkan Modal
        $('#ModalEditSettingBpjs').modal('show');

        // Loading Form
        $('#FormEditSettingBpjs').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditSettingBpjs').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingBpjs/FormEditSettingBpjs.php',
            data        : {id_setting_bpjs: id_setting_bpjs},
            success     : function(data){
                $('#FormEditSettingBpjs').html(data);
            }
        });
    });

    // SUBMIT EDIT BRIDGING BPJS
    $(document).on('submit', '#ProsesEditSettingBpjs', function (e) {
        e.preventDefault();

        let formData = $(this).serialize();

        // Simpan tombol awal
        let btn = $('#ButtonEditBpjs');
        let btnHtml = btn.html();

        // Loading button
        btn.prop('disabled', true);
        btn.html('<span class="spinner-border spinner-border-sm me-1"></span> Loading...');

        // Kosongkan notifikasi
        $('#NotifikasiEditSettingBpjs').html('');

        $.ajax({
            type: 'POST',
            url: '_Page/SettingBpjs/ProsesEditSettingBpjs.php',
            data: formData,
            dataType: 'JSON',
            success: function (response) {

                if (response.status === 'success') {

                    // Tutup modal
                    $('#ModalEditSettingBpjs').modal('hide');

                    // Refresh Tabel
                    TabelSettingBpjs();

                    // Toast sukses
                    tampilkanToast('Bridging PBJS berhasil diperbarui', 'success');

                } else {
                    $('#NotifikasiEditSettingBpjs').html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },
            error: function () {
                $('#NotifikasiEditSettingBpjs').html(`
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
    // HAPUS BRIDGING BPJS
    //==================================================================
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap ID Bridging PBJS
        var id_setting_bpjs = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusSettingBpjs').modal('show');

        // Loading Form
        $('#FormHapusSettingBpjs').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusSettingBpjs').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/SettingBpjs/FormHapusSettingBpjs.php',
            data        : {id_setting_bpjs: id_setting_bpjs},
            success     : function(data){
                $('#FormHapusSettingBpjs').html(data);
            }
        });
    });

    // Submit Hapus Bridging PBJS
    $(document).on('submit', '#ProsesHapusSettingBpjs', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusSettingBpjs');
        let modal      = $('#ModalHapusSettingBpjs');
        let notifikasi = $('#NotifikasiHapusSettingBpjs');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/SettingBpjs/ProsesHapusSettingBpjs.php',
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
                        title            : 'Hapus Bridging PBJS Berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelSettingBpjs();

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