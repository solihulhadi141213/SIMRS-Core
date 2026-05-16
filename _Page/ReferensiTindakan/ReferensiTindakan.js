$(document).ready(function() {
    // ====================================================================
    // FUNCTION BLOCK
    // ====================================================================
    // Tabel Referensi Tindakan
    function TabelReferensiTindakan() {
        var ProsesFilter = $('#ProsesFilter').serialize();
        let target = $('#tabel_referensi_tindakan');

        target.addClass('blur-loading');

        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiTindakan/TabelReferensiTindakan.php',
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

    function trimSelect2Text(value) {
        return String(value ?? '').trim();
    }

    function createManualSelect2Tag(params) {
        let term = trimSelect2Text(params.term);
        if (term === '') {
            return null;
        }

        return {
            id: term,
            text: term,
            newTag: true
        };
    }

    function insertManualSelect2Tag(data, tag) {
        if (!tag) {
            return;
        }

        let tagExists = data.some(function(item) {
            return trimSelect2Text(item.id || item.text || '') === tag.id;
        });

        if (!tagExists) {
            data.unshift(tag);
        }
    }

    function addManualTagToResults(data, params) {
        if(!Array.isArray(data)){
            data = [];
        }

        params = params || {};
        let tag = createManualSelect2Tag({
            term: params.term || ''
        });

        if (tag) {
            insertManualSelect2Tag(data, tag);
        }

        return data;
    }

    function select2SafeTransport(params, success) {
        let completed = false;
        let request = $.ajax($.extend({}, params, {
            timeout: 5000
        }));

        let fallbackTimer = setTimeout(function() {
            if (completed) {
                return;
            }

            completed = true;
            success([]);
        }, 700);

        request.done(function(data) {
            if (completed) {
                return;
            }

            completed = true;
            clearTimeout(fallbackTimer);
            success(data);
        });

        request.fail(function() {
            if (completed) {
                return;
            }

            completed = true;
            clearTimeout(fallbackTimer);
            success([]);
        });

        return request;
    }

    function setManualSelect2Value(select, term) {
        term = trimSelect2Text(term);

        if (term === '') {
            return;
        }

        let existingOption = select.find('option').filter(function() {
            return trimSelect2Text($(this).val()) === term;
        });

        if (existingOption.length === 0) {
            existingOption = $('<option>', {
                value: term,
                text: term
            });
            select.append(existingOption);
        }

        existingOption.prop('selected', true);
        select.trigger('change');
        select.trigger({
            type: 'select2:select',
            params: {
                data: {
                    id: term,
                    text: term,
                    newTag: true
                }
            }
        });
    }

    function bindManualSelect2Input(selector) {
        let select = $(selector);

        select.off('select2:open.manualSelect2').on('select2:open.manualSelect2', function() {
            let searchField = $('.select2-container--open .select2-search__field');

            searchField.off('keydown.manualSelect2').on('keydown.manualSelect2', function(e) {
                if (e.key === 'Enter' && trimSelect2Text($(this).val()) !== '') {
                    setManualSelect2Value(select, $(this).val());
                    select.select2('close');
                    e.preventDefault();
                }
            });

            searchField.off('blur.manualSelect2').on('blur.manualSelect2', function() {
                if (trimSelect2Text($(this).val()) !== '' && !select.val()) {
                    setManualSelect2Value(select, $(this).val());
                }
            });
        });
    }

    function initManualSelect2Field(config) {
        let select = $(config.selector);

        if (!select.length) {
            return;
        }

        if (select.hasClass('select2-hidden-accessible')) {
            select.select2('destroy');
        }

        select.select2({
            theme: 'bootstrap-5',
            dropdownParent: config.dropdownParent,
            placeholder: config.placeholder,
            width: '100%',
            tags: true,
            minimumInputLength: 1,
            createTag: createManualSelect2Tag,
            insertTag: insertManualSelect2Tag,
            ajax: {
                url: config.url,
                type: 'POST',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term || ''
                    };
                },
                transport: select2SafeTransport,
                processResults: function(data, params) {
                    return {
                        results: addManualTagToResults(data, params)
                    };
                },
                cache: false
            },
            templateResult: config.templateResult,
            templateSelection: function(data){
                return data.text || data.id;
            },
            escapeMarkup: function(markup){
                return markup;
            },
            language: {
                searching: function(){
                    return "Mencari...";
                },
                noResults: function(){
                    return "Tidak ditemukan. Ketik untuk tambah baru.";
                }
            }
        });

        bindManualSelect2Input(config.selector);
    }

    function templateSnomedResult(data) {
        if(data.loading){
            return data.text;
        }

        if(data.newTag){
            return $(`
                <div>
                    <b>Tambah Baru</b><br>
                    <small>${data.text}</small>
                </div>
            `);
        }

        return $(`
            <div>
                <b>${data.text ?? ''}</b><br>
                <small>${data.code ?? ''}</small><br>
                <small>${data.display ?? ''}</small>
            </div>
        `);
    }

    function templateIcd9Result(data) {
        if(data.loading){
            return data.text;
        }

        if(data.newTag){
            return $(`
                <div>
                    <b>Tambah Baru</b><br>
                    <small>${data.text}</small>
                </div>
            `);
        }

        return $(`
            <div>
                <b>${data.text ?? ''}</b><br>
                <small>${data.description ?? ''}</small>
            </div>
        `);
    }

    function initEditReferensiTindakanSelect2() {
        initManualSelect2Field({
            selector: '#kategori_tindakan_edit',
            dropdownParent: $('#ModalEdit'),
            placeholder: 'Cari / Tambah Kategori Tindakan',
            url: '_Page/ReferensiTindakan/SearchKategoriTindakan.php',
            templateResult: templateSnomedResult
        });

        initManualSelect2Field({
            selector: '#lokasi_tubuh_edit',
            dropdownParent: $('#ModalEdit'),
            placeholder: 'Cari / Tambah Body Site',
            url: '_Page/ReferensiTindakan/SearchBodySite.php',
            templateResult: templateSnomedResult
        });

        initManualSelect2Field({
            selector: '#icd9_code_edit',
            dropdownParent: $('#ModalEdit'),
            placeholder: 'Cari / Tambah ICD9',
            url: '_Page/ReferensiTindakan/SearchICD9.php',
            templateResult: templateIcd9Result
        });

        $('#kategori_tindakan_edit').off('select2:select.edit').on('select2:select.edit', function(e){
            let data = e.params.data;

            if(data.newTag){
                $('#kategori_tindakan_code_edit').val('');
                $('#kategori_tindakan_display_edit').val('');
                $('#kategori_tindakan_system_edit').val('http://snomed.info/sct');
            }else{
                $('#kategori_tindakan_code_edit').val(data.code ?? '');
                $('#kategori_tindakan_display_edit').val(data.display ?? '');
                $('#kategori_tindakan_system_edit').val(data.system ?? 'http://snomed.info/sct');
            }
        });

        $('#lokasi_tubuh_edit').off('select2:select.edit').on('select2:select.edit', function(e){
            let data = e.params.data;

            if(data.newTag){
                $('#lokasi_tubuh_code_edit').val('');
                $('#lokasi_tubuh_display_edit').val('');
                $('#lokasi_tubuh_system_edit').val('http://snomed.info/sct');
            }else{
                $('#lokasi_tubuh_code_edit').val(data.code ?? '');
                $('#lokasi_tubuh_display_edit').val(data.display ?? '');
                $('#lokasi_tubuh_system_edit').val(data.system ?? 'http://snomed.info/sct');
            }
        });

        $('#icd9_code_edit').off('select2:select.edit').on('select2:select.edit', function(e){
            let data = e.params.data;

            if(data.newTag){
                $('#icd9_description_edit').val('');
            }else{
                $('#icd9_description_edit').val(data.description ?? '');
            }
        });
    }

    function resetReferensiTindakanForm(form) {
        form[0].reset();

        $('#kategori_tindakan, #lokasi_tubuh, #icd9_code').each(function() {
            $(this).val(null).trigger('change');
        });

        $('#kategori_tindakan option, #lokasi_tubuh option, #icd9_code option').remove();

        $('#kategori_tindakan_code').val('');
        $('#kategori_tindakan_display').val('');
        $('#kategori_tindakan_system').val('http://snomed.info/sct');

        $('#nama_tindakan_code').val('');
        $('#nama_tindakan_display').val('');
        $('#nama_tindakan_system').val('http://snomed.info/sct');

        $('#lokasi_tubuh_code').val('');
        $('#lokasi_tubuh_display').val('');
        $('#lokasi_tubuh_system').val('http://snomed.info/sct');

        $('#icd9_description').val('');
        $('#NotifikasiTambah').html('');
    }

    function resetReferensiTindakanFilter() {
        let filterForm = $('#ProsesFilter');

        if (filterForm.length) {
            filterForm[0].reset();
        }

        $('#page_filter').val('1');
        $('#batas').val('10');
        $('#OrderBy').val('');
        $('#ShortBy').val('DESC');
        $('#keyword_by').val('');
        $('#FormFilter').html('<input type="text" name="keyword" id="keyword_form" class="form-control">');
    }

    // ====================================================================
    // EVENT BLOCK
    // ====================================================================
    
    // Load Tabel Pada Saat Pertama Kali
    TabelReferensiTindakan();

     //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelReferensiTindakan(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelReferensiTindakan(0);
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
            url 	    : '_Page/ReferensiTindakan/FormFilter.php',
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
        TabelReferensiTindakan();
    });

    // ==============================
    // TAMBAH REFERENSI TINDAKAN
    // ==============================

    // Auto Focus Saat Form Dibuka
    $('#ModalTambah').on('shown.bs.modal', function () {
        $('#kategori_tindakan').focus();
    });

    // Select 2 Kategori Tindakan
    $('#kategori_tindakan').select2({
        theme: 'bootstrap-5',
        
        // WAJIB modal utama
        dropdownParent: $('#ModalTambah'),
        placeholder: 'Cari / Tambah Kategori Tindakan',
        width: '100%',
        tags: true,
        minimumInputLength: 1,
        ajax: {
            url: '_Page/ReferensiTindakan/SearchKategoriTindakan.php',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params){
                return {
                    search: params.term || ''
                };
            },
            transport: select2SafeTransport,
            processResults: function(data, params){
                return {
                    results: addManualTagToResults(data, params)
                };
            },
            error: function(){
                // cegah select2 stuck loading
                return {
                    results: []
                };
            },
            cache: false
        },

        // MEMBUAT OPSI MANUAL
        createTag: createManualSelect2Tag,
        insertTag: insertManualSelect2Tag,

        // MENAMPILKAN TAG MANUAL
        templateResult: function(data){

            // loading
            if(data.loading){
                return data.text;
            }

            // input manual
            if(data.newTag){
                return $(`
                    <div>
                        <b>Tambah Baru</b><br>
                        <small>${data.text}</small>
                    </div>
                `);
            }

            // data database
            return $(`
                <div>
                    <b>${data.text ?? ''}</b><br>
                    <small>${data.code ?? ''}</small><br>
                    <small>${data.display ?? ''}</small>
                </div>
            `);
        },

        // teks terpilih
        templateSelection: function(data){
            return data.text || data.id;
        },
        escapeMarkup: function(markup){
            return markup;
        },
        language: {
            searching: function(){
                return "Mencari...";
            },
            noResults: function(){
                return "Tidak ditemukan. Ketik untuk tambah baru.";
            }
        }
    });
    bindManualSelect2Input('#kategori_tindakan');

    // Autofill Ketika Kategori Dipilih
    $('#kategori_tindakan').on('select2:select', function(e){
        let data = e.params.data;
        // INPUT MANUAL
        if(data.newTag){
            $('#kategori_tindakan_code').val('');
            $('#kategori_tindakan_display').val('');
            $('#kategori_tindakan_system').val(
                'http://snomed.info/sct'
            );

        }else{
            $('#kategori_tindakan_code').val(
                data.code ?? ''
            );
            $('#kategori_tindakan_display').val(
                data.display ?? ''
            );
            $('#kategori_tindakan_system').val(
                data.system ?? 'http://snomed.info/sct'
            );
        }
    });

    // Select2 Body Site
    $('#lokasi_tubuh').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('.form_lokasi_tubuh'),
        placeholder: 'Cari / Tambah Body Site',
        tags: true,
        minimumInputLength: 1,
        createTag: createManualSelect2Tag,
        insertTag: insertManualSelect2Tag,
        ajax: {
            url: '_Page/ReferensiTindakan/SearchBodySite.php',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term || ''
                };
            },
            transport: select2SafeTransport,
            processResults: function(data, params) {
                return {
                    results: addManualTagToResults(data, params)
                };
            },
            cache: false
        },
        templateResult: function(data){
            if(data.loading){
                return data.text;
            }

            if(data.newTag){
                return $(`
                    <div>
                        <b>Tambah Baru</b><br>
                        <small>${data.text}</small>
                    </div>
                `);
            }

            return $(`
                <div>
                    <b>${data.text ?? ''}</b><br>
                    <small>${data.code ?? ''}</small><br>
                    <small>${data.display ?? ''}</small>
                </div>
            `);
        },
        templateSelection: function(data){
            return data.text || data.id;
        },
        escapeMarkup: function(markup){
            return markup;
        },
        language: {
            searching: function(){
                return "Mencari...";
            },
            noResults: function(){
                return "Tidak ditemukan. Ketik untuk tambah baru.";
            }
        }
    });
    bindManualSelect2Input('#lokasi_tubuh');

    // Autofill Body Site
    $('#lokasi_tubuh').on('select2:select', function(e){
        let data = e.params.data;
        if(data.newTag){
            $('#lokasi_tubuh_code').val('');
            $('#lokasi_tubuh_display').val('');
            $('#lokasi_tubuh_system').val('http://snomed.info/sct');
        }else{
            $('#lokasi_tubuh_code').val(data.code ?? '');
            $('#lokasi_tubuh_display').val(data.display ?? '');
            $('#lokasi_tubuh_system').val(data.system ?? 'http://snomed.info/sct');
        }
    });

    // Select 2 ICD9
    $('#icd9_code').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('.form_icd9'),
        placeholder: 'Cari / Tambah ICD9',
        tags: true,
        minimumInputLength: 1,
        createTag: createManualSelect2Tag,
        insertTag: insertManualSelect2Tag,
        ajax: {
            url: '_Page/ReferensiTindakan/SearchICD9.php',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term || ''
                };
            },
            transport: select2SafeTransport,
            processResults: function(data, params) {
                return {
                    results: addManualTagToResults(data, params)
                };
            },
            cache: false
        },
        templateResult: function(data){
            if(data.loading){
                return data.text;
            }

            if(data.newTag){
                return $(`
                    <div>
                        <b>Tambah Baru</b><br>
                        <small>${data.text}</small>
                    </div>
                `);
            }

            return $(`
                <div>
                    <b>${data.text ?? ''}</b><br>
                    <small>${data.description ?? ''}</small>
                </div>
            `);
        },
        templateSelection: function(data){
            return data.text || data.id;
        },
        escapeMarkup: function(markup){
            return markup;
        },
        language: {
            searching: function(){
                return "Mencari...";
            },
            noResults: function(){
                return "Tidak ditemukan. Ketik untuk tambah baru.";
            }
        }
    });
    bindManualSelect2Input('#icd9_code');

    // Autofill ICD9
    $('#icd9_code').on('select2:select', function(e){
        let data = e.params.data;
        if(data.newTag){
            $('#icd9_description').val('');
        }else{
            $('#icd9_description').val(data.description ?? '');
        }
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
            url        : '_Page/ReferensiTindakan/ProsesTambah.php',
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

                    // Reset form termasuk Select2
                    resetReferensiTindakanForm(form);

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Referensi Tindakan Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Reset filter tabel
                    resetReferensiTindakanFilter();
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelReferensiTindakan();

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

    // DETAIL TINDAKAN
    $(document).on('click', '.modal_detail', function () {

        // Tangkap ID dan Kategori
        var id_tindakan_referensi = $(this).data('id');
        var kategori              = $(this).data('kategori');

        // Munculkan Modal
        $('#ModalDetail').modal('show');

        // Loading Form
        $('#FormDetail').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiTindakan/FormDetail.php',
            data        : {id_tindakan_referensi: id_tindakan_referensi, kategori: kategori},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });

    // EDIT TINDAKAN
    $(document).on('click', '.modal_edit', function () {

        // Tangkap ID dan Kategori
        var id_tindakan_referensi = $(this).data('id');

        // Munculkan Modal
        $('#ModalEdit').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEdit').html('');

        // Loading Form
        $('#FormEdit').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiTindakan/FormEdit.php',
            data        : {id_tindakan_referensi: id_tindakan_referensi},
            success     : function(data){
                $('#FormEdit').html(data);
                initEditReferensiTindakanSelect2();
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
            url        : '_Page/ReferensiTindakan/ProsesEdit.php',
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
                        title            : 'Edit Referensi Tindakan Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelReferensiTindakan();

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

    // HAPUS TINDAKAN
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap ID dan Kategori
        var id_tindakan_referensi = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapus').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapus').html('');

        // Loading Form
        $('#FormHapus').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiTindakan/FormHapus.php',
            data        : {id_tindakan_referensi: id_tindakan_referensi},
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
            url        : '_Page/ReferensiTindakan/ProsesHapus.php',
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
                        title            : 'Hapus Referensi Tindakan Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelReferensiTindakan();

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
    // RECOVERY TINDAKAN
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
            url     : '_Page/ReferensiTindakan/FormRecovery.php',
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

            url         : '_Page/ReferensiTindakan/ProsesRecovery.php',
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
                    TabelReferensiTindakan();

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
});
