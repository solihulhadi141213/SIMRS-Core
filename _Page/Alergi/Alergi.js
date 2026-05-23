

$(document).ready(function() {

    //-----------------------------------------
    // BLOCK FUNCTION
    //-----------------------------------------

    // Tabel Alergi
    function TabelAlergi() {
        var ProsesFilter = $('#ProsesFilter').serialize();
        let target = $('#tabel_alergi');

        target.addClass('blur-loading');

        $.ajax({
            type: 'POST',
            url: '_Page/Alergi/TabelAlergi.php',
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

    // MENAMPILKAN DATA VIEW
    function ShowDataView(id_kunjungan){

        let detailView = $('#DetailView');

        // Tambahkan efek blur + transparan
        detailView.css({
            'transition' : 'all 0.3s ease',
            'filter'     : 'blur(3px)',
            'opacity'    : '0.5'
        });

        // Loading
        detailView.html(`
            <div class="text-center p-4">
                <div class="spinner-border text-primary mb-2"></div>
                <div>
                    <small class="text-muted">Loading Data...</small>
                </div>
            </div>
        `);

        // AJAX
        $.ajax({
            type    : 'POST',
            url     : '_Page/Alergi/DetailView.php',
            data    : {
                id_kunjungan: id_kunjungan
            },

            success: function(data){

                // Fade out dulu
                detailView.fadeOut(150, function(){

                    // Ganti isi
                    detailView.html(data);

                    // Hilangkan blur
                    detailView.css({
                        'filter'  : 'blur(0px)',
                        'opacity' : '1'
                    });

                    // Fade in
                    detailView.fadeIn(200);
                });
            },

            error: function(){

                detailView.html(`
                    <div class="alert alert-danger m-3">
                        <small>
                            Terjadi kesalahan saat memuat data.
                        </small>
                    </div>
                `);

                detailView.css({
                    'filter'  : 'blur(0px)',
                    'opacity' : '1'
                });
            }
        });
    }

    //-----------------------------------------
    // BLOCK EVENT
    //-----------------------------------------

    // MENAMPILKAN DATA PERTAMA KALI

    // Menampilkan table_view
    $('#table_view').show();

    // Sembunyikan Data View
    $('#detail_view').hide();

    TabelAlergi();

     //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelAlergi(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelAlergi(0);
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
            url 	    : '_Page/Alergi/FormFilter.php',
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
        TabelAlergi();
    });

    // DETAIL KUNJUNGAN
    $(document).on('click', '.modal_detail_kunjungan', function () {
        
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');

        // Loading Form
        $('#FormDetailKunjungan').html('Loading...');

        // Show Modal
        $('#ModalDetailKunjungan').modal('show');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Kunjungan/FormDetailKunjungan.php',
            data        : {id_kunjungan : id_kunjungan},
            success     : function(data){
                $('#FormDetailKunjungan').html(data);
            }
        });

    });

    // DETAIL PASIEN
    $(document).on('click', '.modal_detail_pasien', function () {
        
        // Tangkap id_pasien
        var id_pasien = $(this).data('id');

        // Loading Form
        $('#FormDetailPasien').html('Loading...');

        // Show Modal
        $('#ModalDetailPasien').modal('show');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Pasien/FormDetail.php',
            data        : {id_pasien : id_pasien},
            success     : function(data){
                $('#FormDetailPasien').html(data);
            }
        });
    });

    // DETAIL ALERGI
    $(document).on('click', '.show_data_view', function () {
        
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');

        // Sembunyikan table_view
        $('#table_view').hide();

        // Sembunyikan Data View
        $('#detail_view').show();

        ShowDataView(id_kunjungan);

    });

    // RELOAD DATA VIEW
    $(document).on('click', '.reload_data', function () {
        var id_kunjungan = $('#put_id_kunjungan').val();
        ShowDataView(id_kunjungan);

    });

    // TAMBAH ALERGI
    $(document).on('click', '.modal_tambah_alergi', function () {
    
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');

        // Kosongkan Notifikasi
        $('#NotifikasiTambahAlergi').html('');

        // Show Modal
        $('#ModalTambahAlergi').modal('show');
        
        // Loading Form
        $('#FormTambahAlergi').html('Loading...');

        // Ajax Form
        $.ajax({
            type  : 'POST',
            url   : '_Page/Alergi/FormTambahAlergi.php',
            data  : {id_kunjungan : id_kunjungan},
            success : function(data){

                $('#FormTambahAlergi').html(data);

                // SELECT2 ALERGEN
                $('#id_alergi_alergen').select2({
                    theme             : 'bootstrap-5',
                    dropdownParent    : $('#ModalTambahAlergi'),
                    placeholder       : 'Pilih atau ketik alergen',
                    tags              : true,
                    minimumInputLength: 0,

                    ajax: {
                        url     : '_Page/Alergi/SelectAlergen.php',
                        type    : 'POST',
                        dataType: 'json',
                        delay   : 250,

                        data: function (params) {
                            return {
                                search          : params.term,
                                kategori_alergen: $('#kategori_alergen').val(),
                                page            : params.page || 1
                            };
                        },

                        processResults: function (data, params) {

                            params.page = params.page || 1;

                            return {
                                results   : data.results,
                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        },

                        cache: true
                    }
                });

                // DETEKSI INPUT MANUAL
                $('#id_alergi_alergen').on('select2:select', function (e) {

                    let data = e.params.data;

                    if (data.newTag) {
                        $('#manual_alergen').val(data.text);
                    } else {
                        $('#manual_alergen').val('');
                    }
                });

                // RELOAD SAAT KATEGORI BERUBAH
                $('#kategori_alergen').on('change', function () {
                    $('#id_alergi_alergen').val(null).trigger('change');
                });

                // SELECT2 DOKTER/PRAKTISI
                $('#id_praktisi').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $('#ModalTambahAlergi'),
                    placeholder: 'Pilih Praktisi',
                    allowClear: true,

                    ajax: {
                        url: '_Page/Alergi/SelectPraktisi.php',
                        type: 'POST',
                        dataType: 'json',
                        delay: 250,

                        data: function (params) {
                            return {
                                search: params.term,
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
                        }
                    }
                });
            }
        });
    });

    // Handdle Submit Alergi
    $(document).on('submit', '#ProsesTambahAlergi', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahAlergi');
        let modal      = $('#ModalTambahAlergi');
        let notifikasi = $('#NotifikasiTambahAlergi');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url        : '_Page/Alergi/ProsesTambahAlergi.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // id_kunjungan
                let id_kunjungan = response.id_kunjungan;

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    let id_kunjungan = response.id_kunjungan;

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Riwayat Alergi Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    ShowDataView(id_kunjungan);

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

    // MODAL DETAIL
    $(document).on('click', '.modal_detail', function () {
        
        // Tangkap id_alergi
        var id_alergi = $(this).data('id');

        // Show Modal
        $('#ModalDetail').modal('show');

        // Loading Form
        $('#FormDetail').html('Loading...');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Alergi/FormDetail.php',
            data        : {id_alergi : id_alergi},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });

    // MODAL EDIT
    $(document).on('click', '.modal_edit', function () {
        
        // Tangkap id_alergi
        var id_alergi = $(this).data('id');

        // Show Modal
        $('#ModalEdit').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEdit').html('');

        // Loading Form
        $('#FormEdit').html('Loading...');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Alergi/FormEdit.php',
            data        : {id_alergi : id_alergi},
            success     : function(data){
                $('#FormEdit').html(data);
            }
        });
    });

    // Handdle Submit Edit
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
            url        : '_Page/Alergi/ProsesEdit.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // id_kunjungan
                let id_kunjungan = response.id_kunjungan;

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    let id_kunjungan = response.id_kunjungan;

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Edit Alergi Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    ShowDataView(id_kunjungan);

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

    // MODAL HAPUS
    $(document).on('click', '.modal_hapus', function () {
        
        // Tangkap id_alergi
        var id_alergi = $(this).data('id');

        // Show Modal
        $('#ModalHapus').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapus').html('');

        // Loading Form
        $('#FormHapus').html('Loading...');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Alergi/FormHapus.php',
            data        : {id_alergi : id_alergi},
            success     : function(data){
                $('#FormHapus').html(data);
            }
        });
    });

    // Handdle Submit Hapus
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
            url        : '_Page/Alergi/ProsesHapus.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // id_kunjungan
                let id_kunjungan = response.id_kunjungan;

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    let id_kunjungan = response.id_kunjungan;

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Hapus Alergi Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    ShowDataView(id_kunjungan);

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

    // MODAL DETAIL ALERGEN
    $(document).on('click', '.modal_detail_alergen', function () {
        
        // Tangkap id_alergi_alergen
        var id_alergi_alergen = $(this).data('id');

        // Show Modal
        $('#ModalDetailAlergen').modal('show');

        // Loading Form
        $('#FormDetailAlergen').html('Loading...');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiAlergen/FormDetail.php',
            data        : {id_alergi_alergen : id_alergi_alergen},
            success     : function(data){
                $('#FormDetailAlergen').html(data);
            }
        });
    });

    // MODAL DETAIL PRAKTISI
    $(document).on('click', '.modal_detail_praktisi', function () {
        
        // Tangkap id_praktisi
        var id_praktisi = $(this).data('id');

        // Show Modal
        $('#ModalDetailPraktisi').modal('show');

        // Loading Form
        $('#FormDetailPraktisi').html('Loading...');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiPraktisi/FormDetail.php',
            data        : {id_praktisi : id_praktisi},
            success     : function(data){
                $('#FormDetailPraktisi').html(data);
            }
        });
    });

    // MODAL KIRIM ALERGI
    $(document).on('click', '.modal_kirim_alergi', function () {
        
        // Tangkap id_alergi
        var id_alergi = $(this).data('id');

        // Show Modal
        $('#ModalKirimAlergi').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiKirimAlergi').html('');

        // Loading Form
        $('#FormKirimAlergi').html('Loading...');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Alergi/FormKirimAlergi.php',
            data        : {id_alergi : id_alergi},
            success     : function(data){
                $('#FormKirimAlergi').html(data);
            }
        });
    });

    // Handdle Submit Kirim Alergi
    $(document).on('submit', '#ProsesKirimAlergi', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonKirimAlergi');
        let modal      = $('#ModalKirimAlergi');
        let notifikasi = $('#NotifikasiKirimAlergi');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url        : '_Page/Alergi/ProsesKirimAlergi.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // id_kunjungan
                let id_kunjungan = response.id_kunjungan;

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    let id_kunjungan = response.id_kunjungan;

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Kirim Alergi Ke SATUSEHAT Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    ShowDataView(id_kunjungan);

                } else {

                    // Tampilkan error
                    notifikasi.html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small><br>
                            <textarea class="form-control">${response.payload}</textarea><br>
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

    // Moddal Detail Allergy Intolerance
    $(document).on('click', '.modal_detail_allergy_intolerance', function () {
        
        // Tangkap AllergyIntolerance
        var AllergyIntolerance = $(this).data('id');

        // Show Modal
        $('#ModdalDetailAllergyIntolerance').modal('show');

        // Loading Form
        $('#FormAllergyIntolerance').html('Loading...');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Alergi/FormAllergyIntolerance.php',
            data        : {AllergyIntolerance : AllergyIntolerance},
            success     : function(data){
                $('#FormAllergyIntolerance').html(data);
            }
        });
    });

    // KEMBALI
    $(document).on('click', '.back_to_data', function () {

        // Menampilkan table_view
        $('#table_view').show();

        // Sembunyikan Data View
        $('#detail_view').hide();
        
        // Scroll ke atas halaman
        $('html, body').animate({
            scrollTop: 0
        }, 300);

    });


});
