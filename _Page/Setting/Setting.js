// Tabel Setting
function TabelSetting() {
    
    let target = $('#tabel_setting');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Setting/TabelSetting.php',
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

    // Pertama Kali Halaman Load, Tampilkan Tabel Setting
    TabelSetting();

    //==================================================================
    // TAMBAH SETTING
    //==================================================================
    // Ketika Modal Tambah Pengaturan Muncul - Fokus Ke form setting_name
    $('#ModalTambahSetting').on('shown.bs.modal', function () {
        $('#setting_name').focus();
    });

    // Proses Tambah Setting
    $(document).on('submit', '#ProsesTambahSetting', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambahSetting');
        let modal = $('#ModalTambahSetting');
        let notifikasi = $('#NotifikasiTambahSetting');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil semua data form termasuk file
        let formData = new FormData(this);

        // Reset notifikasi
        notifikasi.html('');

        // Ubah tombol jadi loading
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/Setting/ProsesTambahSetting.php',
            type: 'POST',
            data: formData,
            processData: false, // wajib untuk FormData
            contentType: false, // wajib untuk FormData
            dataType: 'json',

            success: function (response) {
                // Kembalikan tombol
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Tutup modal
                    modal.modal('hide');

                    // Reset form
                    form[0].reset();

                    // Refresh tabel
                    TabelSetting();

                    // Toast notifikasi sukses
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Tambah pengaturan berhasil',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

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
    // DETAIL SETTING
    //==================================================================
    $(document).on('click', '.modal_detail_setting', function () {

        // Tangkap ID Setting
        var id_setting = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailSetting').modal('show');

        // Loading Form
        $('#FormDetailSetting').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Setting/FormDetailSetting.php',
            data        : {id_setting: id_setting},
            success     : function(data){
                $('#FormDetailSetting').html(data);
            }
        });
    });

    //==================================================================
    // EDIT SETTING
    //==================================================================
    $(document).on('click', '.edit_setting', function () {

        // Tangkap ID Setting
        var id_setting = $(this).data('id');

        // Munculkan ModalEditSetting
        $('#ModalEditSetting').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEditSetting').html('');

        // Loading Form
        $('#FormEditSetting').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Setting/FormEditSetting.php',
            data        : {id_setting: id_setting},
            success     : function(data){
                $('#FormEditSetting').html(data);
            }
        });
    });

    // SUBMIT EDIT SETTING
    $(document).on('submit', '#ProsesEditSetting', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonEditSetting');
        let modal = $('#ModalEditSetting');
        let notifikasi = $('#NotifikasiEditSetting');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data termasuk file
        let formData = new FormData(this);

        // Reset notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/Setting/ProsesEditSetting.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {

                // Kembalikan tombol
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit pengaturan berhasil',
                        showConfirmButton: false,
                        timer            : 3000,
                        timerProgressBar : true
                    });

                    // Refresh tabel
                    TabelSetting();

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
                        Terjadi kesalahan saat mengirim data.
                    </div>
                `);
            }
        });
    });

    //==================================================================
    // HAPUS SETTING
    //==================================================================
    $(document).on('click', '.modal_hapus_setting', function () {

        // Tangkap ID Setting
        var id_setting = $(this).data('id');

        // Munculkan ModalEditSetting
        $('#ModalHapusSetting').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusSetting').html('');

        // Loading Form
        $('#FormHapusSetting').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Setting/FormHapusSetting.php',
            data        : {id_setting: id_setting},
            success     : function(data){
                $('#FormHapusSetting').html(data);
            }
        });
    });

    // SUBMIT HAPUS SETTING
    $(document).on('submit', '#ProsesHapusSetting', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonHapusSetting');
        let modal = $('#ModalHapusSetting');
        let notifikasi = $('#NotifikasiHapusSetting');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/Setting/ProsesHapusSetting.php',
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
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Hapus pengaturan berhasil',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    // refresh tabel
                    TabelSetting();

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