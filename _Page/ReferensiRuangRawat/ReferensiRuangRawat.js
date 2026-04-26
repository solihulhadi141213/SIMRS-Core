// Tabel KelasRawat
function TabelKelasRawat() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_kelas_rawat');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/ReferensiRuangRawat/TabelKelasRawat.php',
        data: ProsesFilter,
        success: function(data) {
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

// Menampilkan Data Ruang Rawat Berdasarkan Kelas (Smooth + Blur)
function TabelRuangRawat(id_kelas_rawat){

    let container = $('#FormRuangRawat');

    // Tambahkan efek blur ke konten lama
    container.addClass('blur-loading');

    $.ajax({
        type : 'POST',
        url  : '_Page/ReferensiRuangRawat/FormRuangRawat.php',
        data : {id_kelas_rawat: id_kelas_rawat},

        success: function(data){

            // Sedikit delay biar efek terasa smooth (opsional tapi bagus)
            setTimeout(function(){

                // Ganti konten
                container.html(data);

                // Hilangkan blur + kasih animasi masuk
                container.removeClass('blur-loading').addClass('fade-in');

                // Hapus class animasi setelah selesai (biar bisa dipakai lagi)
                setTimeout(function(){
                    container.removeClass('fade-in');
                }, 400);

            }, 200);
        }
    });
}

// Menampilkan Data Ruang Rawat Berdasarkan Kelas (Smooth + Blur)
function TabelTempatTidur(id_ruang_rawat){

    let container = $('#FormTempatTidur');

    // Tambahkan efek blur ke konten lama
    container.addClass('blur-loading');

    $.ajax({
        type : 'POST',
        url  : '_Page/ReferensiRuangRawat/FormTempatTidur.php',
        data : {id_ruang_rawat: id_ruang_rawat},

        success: function(data){

            // Sedikit delay biar efek terasa smooth (opsional tapi bagus)
            setTimeout(function(){

                // Ganti konten
                container.html(data);

                // Hilangkan blur + kasih animasi masuk
                container.removeClass('blur-loading').addClass('fade-in');

                // Hapus class animasi setelah selesai (biar bisa dipakai lagi)
                setTimeout(function(){
                    container.removeClass('fade-in');
                }, 400);

            }, 200);
        }
    });
}


// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {
    TabelKelasRawat();

    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiRuangRawat/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelKelasRawat();
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelKelasRawat(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelKelasRawat(0);
    });

    // ==============================================================
    // TAMBAH KELAS
    // ==============================================================
    $('#ModalTambahKelas').on('shown.bs.modal', function () {
        // Auto Fokus Ke kode_kelas
        $('#kode_kelas').focus();

        // Select2 Kode kelas
        $('#kode_kelas').select2({
            dropdownParent    : $('#ModalTambahKelas'),          // ✅ sesuai modal
            theme             : 'bootstrap-5',
            placeholder       : 'Pilih atau ketik kode kelas',
            allowClear        : true,
            tags              : true,
            minimumInputLength: 0,

            ajax: {
                url: '_Page/ReferensiRuangRawat/GetKelasBpjs.php',
                type: 'POST',
                dataType: 'json',
                delay: 250,

                data: function (params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1
                    };
                },

                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },

                cache: true
            },

            createTag: function (params) {
                let term = $.trim(params.term);

                if (term === '') return null;

                return {
                    id: term,
                    text: term + ' (Manual)',
                    newTag: true
                };
            }
        });
    });

    // Submit Tambah Kelas
    $(document).on('submit', '#ProsesTambahKelas', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahKelas');
        let modal      = $('#ModalTambahKelas');
        let notifikasi = $('#NotifikasiTambahKelas');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiRuangRawat/ProsesTambahKelas.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Reset form
                    form[0].reset();
                    $('#kode_kelas').val(null).trigger('change');

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Kelas Berhasil',
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
                    TabelKelasRawat();

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

    // EDIT KELAS
    $(document).on('click', '.modal_edit_kelas', function() {

        // Tangkap ID Kelas
        var id_kelas_rawat = $(this).data('id');

        // Show Modal
        $('#ModalEditKelas').modal('show');
        
        // Loading Form
        $('#FormEditKelas').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditKelas').html('');

        // Tampilkan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiRuangRawat/FormEditKelas.php',
            data        : {id_kelas_rawat: id_kelas_rawat},
            success     : function(data){
                $('#FormEditKelas').html(data);
            }
        });
        
    });

    // Saat modal edit tampil
    $('#ModalEditKelas').on('shown.bs.modal', function () {

        let currentKode = $('#kode_kelas_edit').data('value') || '';
        let currentText = $('#kode_kelas_edit').data('text') || '';

        $('#kode_kelas_edit').select2({
            dropdownParent    : $('#ModalEditKelas'),
            theme             : 'bootstrap-5',
            placeholder       : 'Pilih atau ketik kode kelas',
            allowClear        : true,
            tags              : true,
            minimumInputLength: 0,

            ajax: {
                url: '_Page/ReferensiRuangRawat/GetKelasBpjs.php',
                type: 'POST',
                dataType: 'json',
                delay: 250,

                data: function (params) {
                    return {
                        search: params.term || '',
                        page: params.page || 1
                    };
                },

                processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.results,
                        pagination: {
                            more: data.pagination.more
                        }
                    };
                },

                cache: true
            },

            createTag: function (params) {
                let term = $.trim(params.term);
                if (term === '') return null;

                return {
                    id: term,
                    text: term + ' (Manual)',
                    newTag: true
                };
            }
        });

        // SET VALUE AWAL (INI PENTING!)
        if (currentKode !== '') {
            let option = new Option(currentText, currentKode, true, true);
            $('#kode_kelas_edit').append(option).trigger('change');
        }
    });

    // Submit Edit Kelas
    $(document).on('submit', '#ProsesEditKelas', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEditKelas');
        let modal      = $('#ModalEditKelas');
        let notifikasi = $('#NotifikasiEditKelas');

        let buttonText = button.html();
        let formData   = new FormData(this);

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiRuangRawat/ProsesEditKelas.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    form[0].reset();
                    $('#kode_kelas_edit').val(null).trigger('change');

                    notifikasi.html('');
                    modal.modal('hide');

                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Kelas Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Refresh tabel
                    TabelKelasRawat();

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

    // HAPUS KELAS
    $(document).on('click', '.modal_hapus_kelas', function() {

        // Tangkap ID Kelas
        var id_kelas_rawat = $(this).data('id');

        // Show Modal
        $('#ModalHapusKelas').modal('show');
        
        // Loading Form
        $('#FormHapusKelas').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusKelas').html('');

        // Tampilkan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiRuangRawat/FormHapusKelas.php',
            data        : {id_kelas_rawat: id_kelas_rawat},
            success     : function(data){
                $('#FormHapusKelas').html(data);
            }
        });
        
    });

    // Submit Hapus Kelas
    $(document).on('submit', '#ProsesHapusKelas', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapusKelas');
        let modal      = $('#ModalHapusKelas');
        let notifikasi = $('#NotifikasiHapusKelas');

        let buttonText = button.html();
        let formData   = new FormData(this);

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiRuangRawat/ProsesHapusKelas.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    notifikasi.html('');
                    modal.modal('hide');

                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Hapus Kelas Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Refresh tabel
                    TabelKelasRawat();

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

    // RUANG RAWAT
    $(document).on('click', '.modal_ruang_rawat', function() {

        // Tangkap ID Kelas
        var id_kelas_rawat = $(this).data('id');

        // Show Modal
        $('#ModalRuangRawat').modal('show');

        TabelRuangRawat(id_kelas_rawat);
    });

    // TAMBAH RUANG RAWAT
    $(document).on('click', '.modal_tambah_ruangan', function() {

        // Tangkap ID Kelas
        var id_kelas_rawat = $(this).data('id');

        // Show Modal
        $('#ModalTambahRuangan').modal('show');
        
        // Loading Form
        $('#FormTambahRuangan').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiTambahRuangan').html('');

        // Tampilkan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiRuangRawat/FormTambahRuangan.php',
            data        : {id_kelas_rawat: id_kelas_rawat},
            success     : function(data){
                $('#FormTambahRuangan').html(data);

                // Auto Fokus Ke Nama Ruangan
                $('#nama_ruangan').focus();
            }
        });
        
    });

    // Submit Tambah Ruangan
    $(document).on('submit', '#ProsesTambahRuangan', function (e) {
        e.preventDefault();

        // Tangkap Semua Data dari Form
        let form       = $(this);
        let button     = $('#ButtonTambahRuangan');
        let modal      = $('#ModalTambahRuangan');
        let notifikasi = $('#NotifikasiTambahRuangan');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiRuangRawat/ProsesTambahRuangan.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Variabel id_kelas_rawat
                let id_kelas_rawat = response.id_kelas_rawat;
                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Reset form
                    form[0].reset();

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Ruangan Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelKelasRawat();
                    TabelRuangRawat(id_kelas_rawat);

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

    // EDIT RUANG RAWAT
    $(document).on('click', '.modal_edit_ruangan', function() {

        // Tangkap ID Kelas
        var id_ruang_rawat = $(this).data('id');

        // Show Modal
        $('#ModalEditRuangan').modal('show');
        
        // Loading Form
        $('#FormEditRuangan').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditRuangan').html('');

        // Tampilkan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiRuangRawat/FormEditRuangan.php',
            data        : {id_ruang_rawat: id_ruang_rawat},
            success     : function(data){
                $('#FormEditRuangan').html(data);

                // Auto Fokus Ke Nama Ruangan
                $('#nama_ruangan_edit').focus();
            }
        });
        
    });

    // Submit Edit Ruangan
    $(document).on('submit', '#ProsesEditRuangan', function (e) {
        e.preventDefault();

        // Tangkap Semua Data dari Form
        let form       = $(this);
        let button     = $('#ButtonEditRuangan');
        let modal      = $('#ModalEditRuangan');
        let notifikasi = $('#NotifikasiEditRuangan');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiRuangRawat/ProsesEditRuangan.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Tangkap id_kelas_rawat
                    let id_kelas_rawat = response.id_kelas_rawat;
                    // Reset form
                    form[0].reset();

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Ruangan Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelKelasRawat();
                    TabelRuangRawat(id_kelas_rawat);

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

    // HAPUS RUANG RAWAT
    $(document).on('click', '.modal_hapus_ruangan', function() {

        // Tangkap ID Kelas
        var id_ruang_rawat = $(this).data('id');

        // Show Modal
        $('#ModalHapusRuangan').modal('show');
        
        // Loading Form
        $('#FormHapusRuangan').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusRuangan').html('');

        // Tampilkan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiRuangRawat/FormHapusRuangan.php',
            data        : {id_ruang_rawat: id_ruang_rawat},
            success     : function(data){
                $('#FormHapusRuangan').html(data);
            }
        });
        
    });

    // Submit Hapus Ruangan
    $(document).on('submit', '#ProsesHapusRuangan', function (e) {
        e.preventDefault();

        // Tangkap Semua Data dari Form
        let form       = $(this);
        let button     = $('#ButtonHapusRuangan');
        let modal      = $('#ModalHapusRuangan');
        let notifikasi = $('#NotifikasiHapusRuangan');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiRuangRawat/ProsesHapusRuangan.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Tangkap id_kelas_rawat
                    let id_kelas_rawat = response.id_kelas_rawat;
                    // Reset form
                    form[0].reset();

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Hapus Ruangan Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelKelasRawat();
                    TabelRuangRawat(id_kelas_rawat);

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

    // TEMPAT TIDUR
    $(document).on('click', '.modal_tempat_tidur', function() {

        // Tangkap ID Kelas
        var id_ruang_rawat = $(this).data('id');

        // Show Modal
        $('#ModalTempatTidur').modal('show');

        TabelTempatTidur(id_ruang_rawat);
    });

    // TAMBAH TEMPAT TIDUR
    $(document).on('click', '.modal_tambah_tempat_tidur', function() {

        // Tangkap ID Kelas
        var id_ruang_rawat = $(this).data('id');

        // Show Modal
        $('#ModalTambahTempatTidur').modal('show');
        
        // Loading Form
        $('#FormTambahTempatTidur').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiTambahTempatTidur').html('');

        // Tampilkan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiRuangRawat/FormTambahTempatTidur.php',
            data        : {id_ruang_rawat: id_ruang_rawat},
            success     : function(data){
                $('#FormTambahTempatTidur').html(data);
            }
        });
        
    });

    // Submit Tempat Tidur
    $(document).on('submit', '#ProsesTambahTempatTidur', function (e) {
        e.preventDefault();

        // Tangkap Semua Data dari Form
        let form       = $(this);
        let button     = $('#ButtonTambahTempatTidur');
        let modal      = $('#ModalTambahTempatTidur');
        let notifikasi = $('#NotifikasiTambahTempatTidur');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiRuangRawat/ProsesTambahTempatTidur.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Tangkap id_ruang_rawat
                    let id_ruang_rawat = response.id_ruang_rawat;
                    let id_kelas_rawat = response.id_kelas_rawat;

                    // Reset form
                    form[0].reset();

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelKelasRawat();
                    TabelRuangRawat(id_kelas_rawat);
                    TabelTempatTidur(id_ruang_rawat);

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

    // EDIT TEMPAT TIDUR
    $(document).on('click', '.modal_edit_tempat_tidur', function() {

        // Tangkap ID Kelas
        var id_tempat_tidur = $(this).data('id');

        // Show Modal
        $('#ModalEditTempatTidur').modal('show');
        
        // Loading Form
        $('#FormEditTempatTidur').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiEditTempatTidur').html('');

        // Tampilkan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiRuangRawat/FormEditTempatTidur.php',
            data        : {id_tempat_tidur: id_tempat_tidur},
            success     : function(data){
                $('#FormEditTempatTidur').html(data);
            }
        });
        
    });

    // Submit Edit Tempat Tidur
    $(document).on('submit', '#ProsesEditTempatTidur', function (e) {
        e.preventDefault();

        // Tangkap Semua Data dari Form
        let form       = $(this);
        let button     = $('#ButtonEditTempatTidur');
        let modal      = $('#ModalEditTempatTidur');
        let notifikasi = $('#NotifikasiEditTempatTidur');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiRuangRawat/ProsesEditTempatTidur.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Tangkap id_ruang_rawat
                    let id_ruang_rawat = response.id_ruang_rawat;
                    let id_kelas_rawat = response.id_kelas_rawat;

                    // Reset form
                    form[0].reset();

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelKelasRawat();
                    TabelRuangRawat(id_kelas_rawat);
                    TabelTempatTidur(id_ruang_rawat);

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

    // HAPUS TEMPAT TIDUR
    $(document).on('click', '.modal_hapus_tempat_tidur', function() {

        // Tangkap ID Kelas
        var id_tempat_tidur = $(this).data('id');

        // Show Modal
        $('#ModalHapusTempatTidur').modal('show');
        
        // Loading Form
        $('#FormHapusTempatTidur').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapusTempatTidur').html('');

        // Tampilkan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiRuangRawat/FormHapusTempatTidur.php',
            data        : {id_tempat_tidur: id_tempat_tidur},
            success     : function(data){
                $('#FormHapusTempatTidur').html(data);
            }
        });
        
    });

    // Submit Hapus Tempat Tidur
    $(document).on('submit', '#ProsesHapusTempatTidur', function (e) {
        e.preventDefault();

        // Tangkap Semua Data dari Form
        let form       = $(this);
        let button     = $('#ButtonHapusTempatTidur');
        let modal      = $('#ModalHapusTempatTidur');
        let notifikasi = $('#NotifikasiHapusTempatTidur');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiRuangRawat/ProsesHapusTempatTidur.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    // Tangkap id_ruang_rawat
                    let id_ruang_rawat = response.id_ruang_rawat;
                    let id_kelas_rawat = response.id_kelas_rawat;

                    // Reset form
                    form[0].reset();

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelKelasRawat();
                    TabelRuangRawat(id_kelas_rawat);
                    TabelTempatTidur(id_ruang_rawat);

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

    // APLICARE
    $(document).on('click', '.modal_aplicare', function() {

        // Show Modal
        $('#ModalAplicare').modal('show');
        
        // Loading Form
        $('#FormAplicare').html('<tr><td colspan="10" class="text-center"><small>Loading...</small></td></tr>');

        // Tampilkan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiRuangRawat/FormAplicare.php',
            success     : function(data){
                $('#FormAplicare').html(data);
            }
        });
        
    });

    $(document).on('click', '#ReloadAplicare', function() {

        // Loading Form
        $('#FormAplicare').html('<tr><td colspan="10" class="text-center"><small>Loading...</small></td></tr>');

        // Tampilkan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiRuangRawat/FormAplicare.php',
            success     : function(data){
                $('#FormAplicare').html(data);
            }
        });
        
    });

    // Modal Update Aplicare
    $(document).on('click', '.modal_update_aplicare', function() {

        // Show Modal
        $('#ModalUpdateAplicare').modal('show');
        
        // Loading Form
        $('#FormUpdateAplicare').html('<tr><td colspan="10" class="text-center"><small>Loading...</small></td></tr>');

        // Tampilkan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiRuangRawat/FormUpdateAplicare.php',
            success     : function(data){
                $('#FormUpdateAplicare').html(data);
            }
        });
        
    });

    // Ketika Click Submit Update Aplicare
    $(document).on('click', '#UpdateAplicare', function() {

        let offset = 0;
        let limit  = 5; // jumlah per batch (AMAN)
        let total  = 0;

        $('#FormUpdateAplicare').html('');
        updateProgress(0);

        function processBatch() {

            $.ajax({
                type: 'POST',
                url: '_Page/ReferensiRuangRawat/ProsesUpdateAplicare.php',
                data: {
                    offset: offset,
                    limit: limit
                },
                dataType: 'json',
                success: function(res){

                    if(res.status === 'error'){
                        $('#FormUpdateAplicare').html(
                            '<tr><td colspan="10" class="text-center text-danger">'+res.message+'</td></tr>'
                        );
                        return;
                    }

                    // Append row
                    $('#FormUpdateAplicare').append(res.html);

                    total = res.total;

                    offset += limit;

                    // Update progress
                    let percent = Math.min((offset / total) * 100, 100);
                    updateProgress(percent);

                    // lanjut batch berikutnya
                    if(offset < total){
                        setTimeout(processBatch, 500); // DELAY
                    }else{
                        updateProgress(100);
                    }
                }
            });
        }

        function updateProgress(percent){
            $('#ProgressAplicare')
                .css('width', percent+'%')
                .text(Math.round(percent)+'%');
        }

        // START
        processBatch();
    });

});