// Tabel Akses
function TabelAkses() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_akses');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Akses/TabelAkses.php',
        data: ProsesFilter,
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
    TabelAkses();

    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Akses/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelAkses();
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelAkses(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelAkses(0);
    });

    // ========================
    // MODAL TAMBAH AKSES
    // ========================
    $('#ModalTambahAkses').on('shown.bs.modal', function () {
        $('#nama').focus();

        // Menampilkan list Entitas Akses
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Akses/OptionEntitasAkses.php',
            success     : function(data){
                $('#id_akses_entitas').html(data);
            }
        });
    });

    $('#GeneratePassword').click(function () {
        let length = 10;
        let chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        let password = "";

        for (let i = 0; i < length; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }

        $('#password').val(password);
    });

    $('#SearchByNik').click(function () {
    let nik = $('#nik').val().trim();

    // Reset validasi
    $('#nik').removeClass('is-invalid');
    $('#nik').next('.invalid-feedback').remove();

    // Validasi kosong
    if (nik === '') {
        $('#nik').addClass('is-invalid');
        $('#nik').after('<div class="invalid-feedback">NIK wajib diisi terlebih dahulu</div>');
        return;
    }

    // Disable button sementara
    $('#SearchByNik').prop('disabled', true).html('<i class="bi bi-hourglass"></i> Proses...');

        $.ajax({
            type: 'POST',
            url: '_Page/Akses/IhsByNik.php',
            data: { nik: nik },
            dataType: 'json',
            success: function (response) {

                // Reset dulu
                $('#nik').removeClass('is-invalid');
                $('#nik').next('.invalid-feedback').remove();

                if (response.status === 'success') {
                    $('#ihs').val(response.ihs);
                } else {
                    $('#nik').addClass('is-invalid');
                    $('#nik').after('<div class="invalid-feedback">' + response.message + '</div>');
                }
            },
            error: function () {
                $('#nik').addClass('is-invalid');
                $('#nik').after('<div class="invalid-feedback">Terjadi kesalahan server</div>');
            },
            complete: function () {
                $('#SearchByNik').prop('disabled', false).html('<i class="bi bi-search"></i> Cari');
            }
        });
    });

    $('#gambar').change(function () {
        let file = this.files[0];

        // Reset validasi
        $('#gambar').removeClass('is-invalid');
        $('#gambar').next('.invalid-feedback').remove();

        if (!file) return;

        let maxSize = 2 * 1024 * 1024; // 2MB
        let allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        let allowedMime = ['image/jpeg', 'image/png', 'image/gif'];

        let fileName = file.name.toLowerCase();
        let fileExt = fileName.split('.').pop();
        let fileType = file.type;

        // Validasi ukuran
        if (file.size > maxSize) {
            $('#gambar').addClass('is-invalid');
            $('#gambar').after('<div class="invalid-feedback">Ukuran file maksimal 2 MB</div>');
            $(this).val('');
            return;
        }

        // Validasi extension
        if (!allowedExt.includes(fileExt)) {
            $('#gambar').addClass('is-invalid');
            $('#gambar').after('<div class="invalid-feedback">Format file harus JPG, JPEG, PNG, atau GIF</div>');
            $(this).val('');
            return;
        }

        // Validasi MIME type
        if (!allowedMime.includes(fileType)) {
            $('#gambar').addClass('is-invalid');
            $('#gambar').after('<div class="invalid-feedback">Tipe file tidak valid</div>');
            $(this).val('');
            return;
        }
    });


    // Submit Tambah Akses
    $(document).on('submit', '#ProsesTambahAkses', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahAkses');
        let modal      = $('#ModalTambahAkses');
        let notifikasi = $('#NotifikasiTambahAkses');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url      : '_Page/Akses/ProsesTambahAkses.php',
            type     : 'POST',
            data     : formData,
            dataType : 'json',

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Reset form
                    form[0].reset();

                    // Reset select2 kategori
                    $('#kategori').val(null).trigger('change');

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah akses akses berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Reset Filter
                    let filterForm = $('#ProsesFilter');

                    if (filterForm.length) {
                        filterForm[0].reset();

                        // reset page ke halaman pertama
                        $('#page').val('1');

                        // reset field keyword dinamis
                        $('#FormFilter').html(`
                            <input type="text" name="keyword" id="keyword" class="form-control">
                        `);

                        // reset select field
                        $('#keyword_by').val('');
                        $('#OrderBy').val('');
                        $('#ShortBy').val('DESC');
                        $('#batas').val('10');
                    }
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelAkses();

                } else {

                    // Tampilkan error
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },

            error: function () {

                // Kembalikan tombol
                button.prop('disabled', false).html(buttonText);

                // Error server
                notifikasi.html(`
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada server.</small>
                    </div>
                `);
            }
        });
    });

    // ========================
    // MODAL DAFTAR FITUR
    // ========================
    $(document).on('click', '.modal_daftar_fitur', function () {

        // Tangkap ID Google Credential
        var id_akses = $(this).data('id');

        // Munculkan Modal
        $('#ModalDaftarFitur').modal('show');

        // Loading Form
        $('#FormDaftarFitur').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Akses/FormDaftarFitur.php',
            data        : {id_akses: id_akses},
            success     : function(data){
                $('#FormDaftarFitur').html(data);
            }
        });
    });

    // ========================
    // MODAL DAFTAR PENGGUNA
    // ========================
    $(document).on('click', '.modal_daftar_pengguna', function () {

        // Tangkap ID Google Credential
        var id_akses = $(this).data('id');

        // Munculkan Modal
        $('#ModalDaftarPengguna').modal('show');

        // Loading Form
        $('#FormDaftarPengguna').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Akses/FormDaftarPengguna.php',
            data        : {id_akses: id_akses},
            success     : function(data){
                $('#FormDaftarPengguna').html(data);
            }
        });
    });

    // ========================
    // MODAL EDIT AKSES
    // ========================
    $(document).on('click', '.modal_edit_akses', function () {

        // Tangkap ID Google Credential
        var id_akses = $(this).data('id');

        // Munculkan Modal
        $('#ModalEditAkses').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEditAkses').html('');

        // Loading Form
        $('#FormEditAkses').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Akses/FormEditAkses.php',
            data        : {id_akses: id_akses},
            success     : function(data){
                $('#FormEditAkses').html(data);
            }
        });
    });

    // Submit Edit Akses
    $(document).on('submit', '#ProsesEditAkses', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditAkses');
        let modal      = $('#ModalEditAkses');
        let notifikasi = $('#NotifikasiEditAkses');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url      : '_Page/Akses/ProsesEditAkses.php',
            type     : 'POST',
            data     : formData,
            dataType : 'json',

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Reset form
                    form[0].reset();

                    // Reset select2 kategori
                    $('#kategori').val(null).trigger('change');

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit akses akses berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang Tabel Tanpa Reset Filter
                    TabelAkses();

                } else {

                    // Tampilkan error
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },

            error: function () {

                // Kembalikan tombol
                button.prop('disabled', false).html(buttonText);

                // Error server
                notifikasi.html(`
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada server.</small>
                    </div>
                `);
            }
        });
    });

    // ========================
    // MODAL HAPUS AKSES
    // ========================
    $(document).on('click', '.modal_hapus_akses', function () {

        // Tangkap ID Google Credential
        var id_akses = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusEntitiasAkses').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusEntitiasAkses').html('');

        // Loading Form
        $('#FormHapusEntitiasAkses').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Akses/FormHapusEntitiasAkses.php',
            data        : {id_akses: id_akses},
            success     : function(data){
                $('#FormHapusEntitiasAkses').html(data);
            }
        });
    });

    // Submit Hapus Akses
    $(document).on('submit', '#ProsesHapusEntitiasAkses', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusEntitiasAkses');
        let modal      = $('#ModalHapusEntitiasAkses');
        let notifikasi = $('#NotifikasiHapusEntitiasAkses');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url      : '_Page/Akses/ProsesHapusEntitiasAkses.php',
            type     : 'POST',
            data     : formData,
            dataType : 'json',

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Reset form
                    form[0].reset();

                    // Reset select2 kategori
                    $('#kategori').val(null).trigger('change');

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Hapus akses akses berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang Tabel Tanpa Reset Filter
                    TabelAkses();

                } else {

                    // Tampilkan error
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },

            error: function () {

                // Kembalikan tombol
                button.prop('disabled', false).html(buttonText);

                // Error server
                notifikasi.html(`
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada server.</small>
                    </div>
                `);
            }
        });
    });
});