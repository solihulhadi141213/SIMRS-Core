$(document).ready(function() {
    // ====================================================================
    // FUNCTION BLOCK
    // ====================================================================
    
    // Tabel Referensi Alergen
    function TabelAlergen() {
        var ProsesFilter = $('#ProsesFilter').serialize();
        let target = $('#tabel_alergen');

        target.addClass('blur-loading');

        $.ajax({
            type   : 'POST',
            url    : '_Page/ReferensiAlergen/TabelReferensiAlergen.php',
            data   : ProsesFilter,
            success: function(data) {
                let wrapper     = $('<div>').html(data);
                let rowHtml     = wrapper.find('tr');
                let firstRow    = rowHtml.first();
                let pageCount   = parseInt(firstRow.attr('data-page-count'), 10);
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
    // ====================================================================
    
    // Load Tabel Pada Saat Pertama Kali
    TabelAlergen();

     //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelAlergen(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelAlergen(0);
    });

    // Auto Focus Keyword
    $('#ModalFilter').on('shown.bs.modal', function () {
        $('#keyword_form').focus();
    });

    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiAlergen/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Pencarian Kunjungan
    $('#ProsesFilter').submit(function(){

        // Reset Page
        $('#page_filter').val('1');

        // Hidden Modal
        $('#ModalFilter').modal('hide');

        // Reload Function
        TabelAlergen();
    });

    // ==============================
    // TAMBAH REFERENSI ALERGEN
    // ==============================

    // Fokus otomatis
    $('#ModalTambah').on('shown.bs.modal', function () {
        $('#kategori_alergen').focus();
    });
    

    // Handdle Submit Referensi Tindakan
    $(document).on('submit', '#ProsesTambah', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambah');
        let modal      = $('#ModalTambah');
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
            url        : '_Page/ReferensiAlergen/ProsesTambah.php',
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

                    // Reset form
                    $('#ProsesTambah')[0].reset();

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Referensi Alergen Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Reset Filter Kembali Ke halaman 1 (Belulum)
                    $('#ProsesFilter')[0].reset();
                    $('#page_filter').val(1);

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelAlergen();

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

        // Tangkap ID dan Kategori
        var id_alergi_alergen = $(this).data('id');
        var kategori              = $(this).data('kategori');

        // Munculkan Modal
        $('#ModalDetail').modal('show');

        // Loading Form
        $('#FormDetail').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiAlergen/FormDetail.php',
            data        : {id_alergi_alergen: id_alergi_alergen},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });

    // EDIT ALERGEN
    $(document).on('click', '.modal_edit', function () {

        // Tangkap ID dan Kategori
        var id_alergi_alergen = $(this).data('id');

        // Munculkan Modal
        $('#ModalEdit').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEdit').html('');

        // Loading Form
        $('#FormEdit').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiAlergen/FormEdit.php',
            data        : {id_alergi_alergen: id_alergi_alergen},
            success     : function(data){
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
            url        : '_Page/ReferensiAlergen/ProsesEdit.php',
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
                        title            : 'Edit Referensi Alergen Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelAlergen();

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

    // HAPUS ALERGEN
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap ID dan Kategori
        var id_alergi_alergen = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapus').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapus').html('');

        // Loading Form
        $('#FormHapus').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiAlergen/FormHapus.php',
            data        : {id_alergi_alergen: id_alergi_alergen},
            success     : function(data){
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
            url        : '_Page/ReferensiAlergen/ProsesHapus.php',
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
                        title            : 'Hapus Referensi Alergen Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelAlergen();

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


    // ==============================
    // RECOVERY ALERGEN
    // ==============================
    $(document).on('click', '.modal_recovery', function () {

        // Tangkap ID
        var id_tindakan_referensi = $(this).data('id');

        // Tampilkan Modal
        $('#ModalRecovery').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiRecovery').html('');

        // Loading
        $('#FormRecovery').html(`
            <div class="text-center text-muted">
                <span class="spinner-border spinner-border-sm me-1"></span>
                Loading...
            </div>
        `);
        $.ajax({
            type    : 'POST',
            url     : '_Page/ReferensiAlergen/FormRecovery.php',
            data    : {
                id_tindakan_referensi: id_tindakan_referensi
            },
            success : function(data){

                $('#FormRecovery').html(data);

            },
            error : function(){

                $('#FormRecovery').html(`
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan saat memuat form recovery.</small>
                    </div>
                `);
            }
        });
    });

    // HANDLE SUBMIT RECOVERY
    $(document).on('submit', '#ProsesRecovery', function (e) {

        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonRecovery');
        let modal      = $('#ModalRecovery');
        let notifikasi = $('#NotifikasiRecovery');

        // Simpan Text Awal
        let buttonText = button.html();

        // Form Data
        let formData = new FormData(this);

        // Kosongkan Notifikasi
        notifikasi.html('');

        // Loading Button
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span>
            Loading...
        `);

        // ==================================================
        // AJAX RECOVERY
        // ==================================================
        $.ajax({

            url         : '_Page/ReferensiAlergen/ProsesRecovery.php',
            type        : 'POST',
            data        : formData,
            dataType    : 'json',
            processData : false,
            contentType : false,

            success: function (response) {

                // Kembalikan Tombol
                button.prop('disabled', false).html(buttonText);

                // SUCCESS
                if (response.status === 'success') {

                    // Kosongkan Notifikasi
                    notifikasi.html('');

                    // Tutup Modal
                    modal.modal('hide');

                    // Toast Success
                    Swal.fire({
                        toast             : true,
                        position          : 'top-end',
                        icon              : 'success',
                        title             : 'Recovery Referensi Tindakan Berhasil',
                        showConfirmButton : false,
                        timer             : 1500,
                        timerProgressBar  : true
                    });

                    // Refresh Tabel
                    TabelAlergen();

                } else {

                    // Notifikasi Error
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },

            error: function () {

                // Kembalikan Tombol
                button.prop('disabled', false).html(buttonText);

                // Error Server
                notifikasi.html(`
                    <div class="alert alert-danger">
                        <small>Terjadi kesalahan pada server.</small>
                    </div>
                `);
            }
        });
    });

    // UPLOAD / IMPORT REFERENSI ALERGEN
    $(document).on('submit', '#ProsesUpload', function (e) {
        e.preventDefault();

        let button     = $('#ButtonUpload');
        let modal      = $('#ModalUpload');
        let notifikasi = $('#NotifikasiUpload');
        let buttonText = button.html();
        let formData   = new FormData(this);

        // Reset notifikasi
        notifikasi.html('');

        // Loading
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url         : '_Page/ReferensiAlergen/ProsesUpload.php',
            type        : 'POST',
            data        : formData,
            dataType    : 'json',
            processData : false,
            contentType : false,

            success: function (response) {

                // Restore button
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Reset form
                    $('#ProsesUpload')[0].reset();

                    // Close modal
                    modal.modal('hide');

                    // Toast success
                    Swal.fire({
                        toast             : true,
                        position          : 'top-end',
                        icon              : 'success',
                        title             : response.message,
                        showConfirmButton : false,
                        timer             : 1500,
                        timerProgressBar  : true
                    });

                    // Refresh tabel
                    TabelAlergen();

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
