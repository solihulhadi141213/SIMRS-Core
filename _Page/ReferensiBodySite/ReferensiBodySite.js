$(document).ready(function () {
    // ====================================================================
    // FUNCTION BLOCK
    // Semua Function Jquery/Javascript Di Tulias Pada Block Ini
    // ====================================================================

    // Tabel Referensi Body Site
    function TabelBodySite() {
        var ProsesFilter = $('#ProsesFilter').serialize();
        let target = $('#tabel_body_site');

        target.addClass('blur-loading');

        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiBodySite/TabelReferensiBodySite.php',
            data: ProsesFilter,
            success: function (data) {
                let wrapper = $('<div>').html(data);
                let rowHtml = wrapper.find('tr');
                let firstRow = rowHtml.first();
                let pageCount = parseInt(firstRow.attr('data-page-count'), 10);
                let currentPage = parseInt(firstRow.attr('data-current-page'), 10);

                if (isNaN(pageCount)) {
                    pageCount = 0;
                }

                if (isNaN(currentPage)) {
                    currentPage = 0;
                }

                target.css('opacity', '0');

                setTimeout(function () {
                    target.html(rowHtml)
                        .addClass('blur-loading')
                        .css('opacity', '1');

                    $('#page_info').html(currentPage + ' / ' + pageCount);
                    $('#previous_page').prop('disabled', currentPage <= 1);
                    $('#next_page').prop('disabled', currentPage <= 0 || currentPage >= pageCount);

                    setTimeout(function () {
                        target.removeClass('blur-loading');
                    }, 200);
                }, 150);
            }
        });
    }

    // ====================================================================
    // EVENT BLOCK
    // Semua Script Javascript / Jquery Event Handler Ditulis Disini
    // ====================================================================

    // Load Tabel Pada Saat Pertama Kali
    TabelBodySite();

    //Pagging
    $(document).on('click', '#next_page', function () {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelBodySite(0);
    });
    $(document).on('click', '#previous_page', function () {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelBodySite(0);
    });

    // Auto Focus Keyword
    $('#ModalFilter').on('shown.bs.modal', function () {
        $('#keyword_form').focus();
    });

    // Keyword By
    $('#keyword_by').change(function () {
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiBodySite/FormFilter.php',
            data: { keyword_by: keyword_by },
            success: function (data) {
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Pencarian Kunjungan
    $('#ProsesFilter').submit(function () {

        // Reset Page
        $('#page_filter').val('1');

        // Hidden Modal
        $('#ModalFilter').modal('hide');

        // Reload Function
        TabelBodySite();
    });

    // ==============================
    // TAMBAH REFERENSI BODY SITE
    // ==============================

    // Ketika Modal Tambah Muncul
    $('#ModalTambah').on('shown.bs.modal', function () {

        // Fokus otomatis 'body_site_category'
        $('#body_site_category').focus();

        // Menampilkan list option 'body_site_category' berdasarkan enum.
        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiBodySite/body_site_category.php',
            success: function (data) {
                $('#body_site_category').html('<option value="">Pilih Kategori</option>' + data);
            }
        });

    });

    // Handdle Submit Referensi Body Site
    $(document).on('submit', '#ProsesTambah', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambah');
        let modal = $('#ModalTambah');
        let notifikasi = $('#NotifikasiTambah');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url: '_Page/ReferensiBodySite/ProsesTambah.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Reset form
                    $('#ProsesTambah')[0].reset();

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Tambah Referensi Body Site Berhasil',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });

                    // Reset Filter Kembali Ke halaman 1 (Belulum)
                    $('#ProsesFilter')[0].reset();
                    $('#page_filter').val(1);

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelBodySite();

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

    // DETAIL
    $(document).on('click', '.modal_detail', function () {

        // Tangkap id_body_site
        var id_body_site = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetail').modal('show');

        // Loading Form
        $('#FormDetail').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiBodySite/FormDetail.php',
            data: { id_body_site: id_body_site },
            success: function (data) {
                $('#FormDetail').html(data);
            }
        });
    });

    // EDIT BODY SITE
    $(document).on('click', '.modal_edit', function () {

        // Tangkap ID
        var id_body_site = $(this).data('id');

        // Munculkan Modal
        $('#ModalEdit').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEdit').html('');

        // Loading Form
        $('#FormEdit').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiBodySite/FormEdit.php',
            data: { id_body_site: id_body_site },
            success: function (data) {
                $('#FormEdit').html(data);
            }
        });
    });

    // Handdle Submit Edit Referensi Tindakan
    $(document).on('submit', '#ProsesEdit', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEdit');
        let modal      = $('#ModalEdit');
        let notifikasi = $('#NotifikasiEdit');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url        : '_Page/ReferensiBodySite/ProsesEdit.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,
            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Referensi Body Site Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelBodySite();

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

    // HAPUS BODY SITE
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap ID dan Kategori
        var id_body_site = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapus').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapus').html('');

        // Loading Form
        $('#FormHapus').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiBodySite/FormHapus.php',
            data: { id_body_site: id_body_site },
            success: function (data) {
                $('#FormHapus').html(data);
            }
        });
    });

    // Handdle Submit Hapus Referensi Tindakan
    $(document).on('submit', '#ProsesHapus', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapus');
        let modal      = $('#ModalHapus');
        let notifikasi = $('#NotifikasiHapus');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url        : '_Page/ReferensiBodySite/ProsesHapus.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Hapus Referensi Body Site Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelBodySite();

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

    // IMPORT REFERENSI BODY SITE
    $(document).on('submit', '#ProsesImport', function (e) {
        e.preventDefault();

        let button     = $('#ButtonImport');
        let modal      = $('#ModalImport');
        let notifikasi = $('#NotifikasiImport');
        let buttonText = button.html();
        let formData   = new FormData(this);

        // Reset notifikasi
        notifikasi.html('');

        // Loading
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiBodySite/ProsesImport.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,
            success: function (response) {

                // Restore button
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Reset form
                    $('#ProsesImport')[0].reset();

                    // Close modal
                    modal.modal('hide');

                    // Toast success
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : response.message,
                        showConfirmButton: false,
                        timer            : 1500,
                        timerProgressBar : true
                    });

                    // Refresh tabel
                    TabelBodySite();

                } else {

                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },

            error: function () {

                button.prop('disabled', false).html(buttonText);

                notifikasi.html(`
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada server.</small>
                    </div>
                `);
            }
        });
    });

});
