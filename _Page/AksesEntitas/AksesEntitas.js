// Tabel Entitas
function TabelEntitas() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_entitas');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/AksesEntitas/TabelEntitas.php',
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
    TabelEntitas();

    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesEntitas/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelEntitas();
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelEntitas(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelEntitas(0);
    });

    // ========================
    // MODAL TAMBAH ENTITAS
    // ========================
    $('#ModalTambahEntitas').on('shown.bs.modal', function () {
        $('#NotifikasiTambahEntitas').html('');
        $('#FormTambahEntitas').html('Loading...');

        $.ajax({
            type: 'POST',
            url: '_Page/AksesEntitas/FormTambahEntitas.php',
            success: function(data) {
                $('#FormTambahEntitas').html(data);

                $('#entitas_akses').focus();
            }
        });
    });

    // Parent -> Child
    $(document).on('change', '.kategori-checkbox', function () {
        let isChecked = $(this).prop('checked');

        $(this)
            .closest('.kategori-group')
            .find('.child-checkbox')
            .prop('checked', isChecked);
    });

    // Optional: jika semua child dicentang maka parent ikut aktif
    $(document).on('change', '.child-checkbox', function () {
        let group = $(this).closest('.kategori-group');
        let totalChild = group.find('.child-checkbox').length;
        let checkedChild = group.find('.child-checkbox:checked').length;

        group.find('.kategori-checkbox').prop('checked', totalChild === checkedChild);
    });

    // Submit Tambah Entitas
    $(document).on('submit', '#ProsesTambahEntitas', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahEntitas');
        let modal      = $('#ModalTambahEntitas');
        let notifikasi = $('#NotifikasiTambahEntitas');

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
            url      : '_Page/AksesEntitas/ProsesTambahEntitas.php',
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
                        title            : 'Tambah entitas akses berhasil',
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
                    TabelEntitas();

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
        var id_akses_entitas = $(this).data('id');

        // Munculkan Modal
        $('#ModalDaftarFitur').modal('show');

        // Loading Form
        $('#FormDaftarFitur').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesEntitas/FormDaftarFitur.php',
            data        : {id_akses_entitas: id_akses_entitas},
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
        var id_akses_entitas = $(this).data('id');

        // Munculkan Modal
        $('#ModalDaftarPengguna').modal('show');

        // Loading Form
        $('#FormDaftarPengguna').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesEntitas/FormDaftarPengguna.php',
            data        : {id_akses_entitas: id_akses_entitas},
            success     : function(data){
                $('#FormDaftarPengguna').html(data);
            }
        });
    });

    // ========================
    // MODAL EDIT ENTITAS
    // ========================
    $(document).on('click', '.modal_edit_entitas', function () {

        // Tangkap ID Google Credential
        var id_akses_entitas = $(this).data('id');

        // Munculkan Modal
        $('#ModalEditEntitas').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEditEntitas').html('');

        // Loading Form
        $('#FormEditEntitas').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesEntitas/FormEditEntitas.php',
            data        : {id_akses_entitas: id_akses_entitas},
            success     : function(data){
                $('#FormEditEntitas').html(data);
            }
        });
    });

    // Submit Edit Entitas
    $(document).on('submit', '#ProsesEditEntitas', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditEntitas');
        let modal      = $('#ModalEditEntitas');
        let notifikasi = $('#NotifikasiEditEntitas');

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
            url      : '_Page/AksesEntitas/ProsesEditEntitas.php',
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
                        title            : 'Edit entitas akses berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang Tabel Tanpa Reset Filter
                    TabelEntitas();

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
    // MODAL HAPUS ENTITAS
    // ========================
    $(document).on('click', '.modal_hapus_entitas', function () {

        // Tangkap ID Google Credential
        var id_akses_entitas = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapusEntitiasAkses').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusEntitiasAkses').html('');

        // Loading Form
        $('#FormHapusEntitiasAkses').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/AksesEntitas/FormHapusEntitiasAkses.php',
            data        : {id_akses_entitas: id_akses_entitas},
            success     : function(data){
                $('#FormHapusEntitiasAkses').html(data);
            }
        });
    });

    // Submit Hapus Entitas
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
            url      : '_Page/AksesEntitas/ProsesHapusEntitiasAkses.php',
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
                        title            : 'Hapus entitas akses berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang Tabel Tanpa Reset Filter
                    TabelEntitas();

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