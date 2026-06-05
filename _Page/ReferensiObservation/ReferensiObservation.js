$(document).ready(function() {
    // ====================================================================
    // FUNCTION BLOCK
    // ====================================================================
    // Tabel Referensi Observasi
    function TabelReferensiObservation() {
        var ProsesFilter = $('#ProsesFilter').serialize();
        let target = $('#tabel_referensi_observation');

        target.addClass('blur-loading');

        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiObservation/TabelReferensiObservation.php',
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

    // Add Form Coded
    function formCoded() {

        return `
            <div class="item-coded mb-2">
                <div class="input-group">

                    <input type="text" 
                        name="label[]" 
                        class="form-control" 
                        placeholder="Label">

                    <input type="text" 
                        name="value[]" 
                        class="form-control" 
                        placeholder="Value">

                    <button type="button" 
                        class="btn btn-outline-danger HapusCoded">
                        <i class="bi bi-trash"></i>
                    </button>

                </div>
            </div>
        `;

    }

    // Add Form Coded Mode Edit
    function formCodedEdit() {

        return `
            <div class="item-coded-edit mb-2">
                <div class="input-group">

                    <input type="text" 
                        name="label[]" 
                        class="form-control" 
                        placeholder="Label">

                    <input type="text" 
                        name="value[]" 
                        class="form-control" 
                        placeholder="Value">

                    <button type="button" 
                        class="btn btn-outline-danger HapusCodedEdit">
                        <i class="bi bi-trash"></i>
                    </button>

                </div>
            </div>
        `;

    }


    // ====================================================================
    // EVENT BLOCK
    // ====================================================================
    
    // Menampilkan Data Pertama Kali
    TabelReferensiObservation();

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelReferensiObservation(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelReferensiObservation(0);
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
            url 	    : '_Page/ReferensiObservation/FormFilter.php',
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
        TabelReferensiObservation();
    });

    //-----------------------------------
    // TAMBAH OBSERVATION
    //-----------------------------------
    $('.form_result_coded').hide();
    $('.form_satuan_unit').hide();

    // Mapping kategori observation
    const kategoriObservation = {
        "Riwayat Sosial": {
            code: "social-history",
            display: "Social History"
        },
        "Tanda Vital": {
            code: "vital-signs",
            display: "Vital Signs"
        },
        "Pencitraan Medis": {
            code: "imaging",
            display: "Imaging"
        },
        "Laboratorium": {
            code: "laboratory",
            display: "Laboratory"
        },
        "Tindakan Medis": {
            code: "procedure",
            display: "Procedure"
        },
        "Asesmen": {
            code: "survey",
            display: "Survey"
        },
        "Pemeriksaan Fisik": {
            code: "exam",
            display: "Exam"
        },
        "Response Terapi": {
            code: "therapy",
            display: "Therapy"
        },
        "Aktivitas": {
            code: "activity",
            display: "Activity"
        },
        "Gejala": {
            code: "symptom",
            display: "Symptom"
        }
    };

    // Saat kategori dipilih
    $('#category_name').on('change', function () {

        let kategori = $(this).val();

        if (kategoriObservation[kategori]) {

            $('#category_code').val(
                kategoriObservation[kategori].code
            );

            $('#category_display').val(
                kategoriObservation[kategori].display
            );

        } else {

            $('#category_code').val('');
            $('#category_display').val('');

        }

    });

    // Saat result_type dipilih
    $('#result_type').on('change', function () {

        let result_type = $(this).val();

        if (result_type=='Numeric'||result_type=='Decimal') {
            $('.form_result_coded').hide();
            $('.form_satuan_unit').show();
        }  
        if (result_type=='Text'||result_type=='Boolean') {
            $('.form_result_coded').hide();
            $('.form_satuan_unit').hide();
        }
        if (result_type=='Coded') {
            $('.form_result_coded').show();
            $('.form_satuan_unit').hide();
        } 

    });

    // Tambah Form Coded
    $('#TambahCoded').click(function () {
        $('#WrapperResultCoded').append(
            formCoded()
        );
    });

    // Hapus Form Coded
    $(document).on('click', '.HapusCoded', function () {
        $(this).closest('.item-coded').remove();
    });

    // SELECT2 UNIT
    $('#unit_name').select2({
        theme         : 'bootstrap-5',
        width         : '100%',
        dropdownParent: $('#ModalTambah'),
        placeholder   : 'Pilih atau ketik satuan',
        allowClear    : true,

        // Bisa input manual
        tags: true,

        // Tidak perlu minimum karakter
        minimumInputLength: 0,

        // AJAX
        ajax: {
            url     : '_Page/ReferensiObservation/SelectUnit.php',
            type    : 'GET',
            dataType: 'json',
            delay   : 250,
            data: function (params) {
                return {
                    search: params.term || '',
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                let results = [];
                // Pastikan results array
                if (
                    data &&
                    Array.isArray(data.results)
                ) {
                    results = data.results;
                }
                return {
                    results: results,
                    pagination: {
                        more:
                            data &&
                            data.pagination &&
                            data.pagination.more
                                ? true
                                : false
                    }
                };
            },
            cache: true
        },

        // MANUAL INPUT
        createTag: function (params) {
            let term = (params.term || '').trim();
            // Jika kosong
            if (term === '') {
                return null;
            }
            // Tetap izinkan manual input
            return {
                id: term,
                text: term,
                newTag: true
            };
        }
    });

    // AUTO ISI DETAIL UNIT
    $('#unit_name').on('select2:select', function (e) {
        let data = e.params.data;
        
        // JIKA INPUT MANUAL
        if (data.newTag) {
            $('#unit_code').val('');
            $('#unit_display').val(data.text);
            $('#unit_system').val(
                'http://unitsofmeasure.org'
            );
        }

        // JIKA PILIH DARI DATABASE
        else {
            $('#unit_code').val(
                data.code || ''
            );
            $('#unit_display').val(
                data.display || ''
            );
            $('#unit_system').val(
                data.system ||
                'http://unitsofmeasure.org'
            );
        }
    });

    // CLEAR SELECT
    $('#unit_name').on('select2:clear', function () {
        $('#unit_code').val('');
        $('#unit_display').val('');
        $('#unit_system').val(
            'http://unitsofmeasure.org'
        );
    });

    // Handdel Proses Tambah
     $('#ProsesTambah').submit(function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonTambah');

        // Reset notifikasi
        $('#NotifikasiTambah').html('');

        // Loading button
        button.prop('disabled', true);

        let buttonText = button.html();

        button.html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menyimpan...
        `);

        // Ambil form data
        let formData = new FormData(this);

        $.ajax({
            url: '_Page/ReferensiObservation/ProsesTambah.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',

            success: function (response) {

                // SUCCESS
                if (response.status == 'success') {

                    // Tutup modal
                    $('#ModalTambah').modal('hide');

                    // Reset form
                    form[0].reset();

                    // Reset select2
                    $('#unit_name').val(null).trigger('change');

                    // Reset coded
                    $('#WrapperResultCoded').html('');

                    // Hide optional form
                    $('.form_satuan_unit').hide();
                    $('.form_result_coded').hide();

                    // Sweetalert Toast
                    Swal.fire({
                        icon             : 'success',
                        title            : 'Berhasil',
                        text             : response.message,
                        timer            : 3000,
                        showConfirmButton: false,
                        toast            : true,
                        position         : 'top-end'
                    });

                    // Tampilkan Ulang Tabel
                    TabelReferensiObservation();

                } 
                
               // ERROR
                else {

                    $('#NotifikasiTambah').html(`
                        <div class="alert alert-danger alert-dismissible fade show">
                            <small>${response.message}</small>

                            <button type="button" 
                                class="btn-close" 
                                data-bs-dismiss="alert">
                            </button>
                        </div>
                    `);

                }

            },

            // AJAX ERROR
            error: function (xhr, status, error) {

                $('#NotifikasiTambah').html(`
                    <div class="alert alert-danger alert-dismissible fade show">
                        <small>
                            Terjadi kesalahan pada server!<br>
                            ${error}
                        </small>

                        <button type="button" 
                            class="btn-close" 
                            data-bs-dismiss="alert">
                        </button>
                    </div>
                `);

            },

            // COMPLETE
            complete: function () {

                // Kembalikan tombol
                button.prop('disabled', false);

                button.html(buttonText);

            }

        });

    });

    //-----------------------------------
    // DETAIL
    //-----------------------------------
    $(document).on('click', '.modal_detail', function () {

        // Tangkap ID
        var id_observation_reference = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetail').modal('show');

        // Loading Form
        $('#FormDetail').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiObservation/FormDetail.php',
            data        : {id_observation_reference: id_observation_reference},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });

    //-----------------------------------
    // EDIT
    //-----------------------------------

    // Menampilkan Modal Edit
    $(document).on('click', '.modal_edit', function () {

        // Tangkap ID
        var id_observation_reference = $(this).data('id');

        // Munculkan Modal
        $('#ModalEdit').modal('show');

        // Loading Form
        $('#FormEdit').html('Loading...');

        // AJAX load form
        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiObservation/FormEdit.php',
            data: { id_observation_reference: id_observation_reference },
            success: function (data) {

                // Masukkan HTML form
                $('#FormEdit').html(data);

                // Ambil nilai setelah DOM ter-render
                let result_type = $('#result_type_edit').val();

                // Routing Tampilan Form
                if (result_type === "Coded") {
                    $('.form_result_coded_edit').show();
                    $('.form_satuan_unit_edit').hide();
                } else if (result_type === "Numeric" || result_type === "Decimal") {
                    $('.form_result_coded_edit').hide();
                    $('.form_satuan_unit_edit').show();
                } else {
                    $('.form_result_coded_edit').hide();
                    $('.form_satuan_unit_edit').hide();
                }

                // Event change kategori (hindari double bind)
                $(document).off('change', '#category_name_edit').on('change', '#category_name_edit', function () {

                    let kategori = $(this).val();

                    if (typeof kategoriObservation !== 'undefined' && kategoriObservation[kategori]) {
                        $('#category_code_edit').val(kategoriObservation[kategori].code);
                        $('#category_display_edit').val(kategoriObservation[kategori].display);
                    } else {
                        $('#category_code_edit').val('');
                        $('#category_display_edit').val('');
                    }
                });

                // Saat result_type_edit dipilih
                $('#result_type_edit').on('change', function () {

                    let result_type = $(this).val();

                    if (result_type=='Numeric'||result_type=='Decimal') {
                        $('.form_result_coded_edit').hide();
                        $('.form_satuan_unit_edit').show();
                    }  
                    if (result_type=='Text'||result_type=='Boolean') {
                        $('.form_result_coded_edit').hide();
                        $('.form_satuan_unit_edit').hide();
                    }
                    if (result_type=='Coded') {
                        $('.form_result_coded_edit').show();
                        $('.form_satuan_unit_edit').hide();
                    } 

                });

                // Tambah Form Coded
                $('#TambahCodedEdit').click(function () {
                    $('#WrapperResultCodedEdit').append(
                        formCodedEdit()
                    );
                });

                // Hapus Form Coded
                $(document).on('click', '.HapusCodedEdit', function () {
                    $(this).closest('.item-coded-edit').remove();
                });

                // SELECT2 UNIT MODE EDIT
                $('#unit_name_edit').select2({
                    theme         : 'bootstrap-5',
                    width         : '100%',
                    dropdownParent: $('#ModalEdit'),
                    placeholder   : 'Pilih atau ketik satuan',
                    allowClear    : true,

                    // Bisa input manual
                    tags: true,

                    // Tidak perlu minimum karakter
                    minimumInputLength: 0,

                    // AJAX
                    ajax: {
                        url     : '_Page/ReferensiObservation/SelectUnit.php',
                        type    : 'GET',
                        dataType: 'json',
                        delay   : 250,
                        data: function (params) {
                            return {
                                search: params.term || '',
                                page: params.page || 1
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            let results = [];
                            // Pastikan results array
                            if (
                                data &&
                                Array.isArray(data.results)
                            ) {
                                results = data.results;
                            }
                            return {
                                results: results,
                                pagination: {
                                    more:
                                        data &&
                                        data.pagination &&
                                        data.pagination.more
                                            ? true
                                            : false
                                }
                            };
                        },
                        cache: true
                    },

                    // MANUAL INPUT
                    createTag: function (params) {
                        let term = (params.term || '').trim();
                        // Jika kosong
                        if (term === '') {
                            return null;
                        }
                        // Tetap izinkan manual input
                        return {
                            id: term,
                            text: term,
                            newTag: true
                        };
                    }
                });

                // AUTO ISI DETAIL UNIT
                $('#unit_name_edit').on('select2:select', function (e) {
                    let data = e.params.data;
                    
                    // JIKA INPUT MANUAL
                    if (data.newTag) {
                        $('#unit_code_edit').val('');
                        $('#unit_display_edit').val(data.text);
                        $('#unit_system_edit').val(
                            'http://unitsofmeasure.org'
                        );
                    }

                    // JIKA PILIH DARI DATABASE
                    else {
                        $('#unit_code_edit').val(
                            data.code || ''
                        );
                        $('#unit_display_edit').val(
                            data.display || ''
                        );
                        $('#unit_system_edit').val(
                            data.system ||
                            'http://unitsofmeasure.org'
                        );
                    }
                });

                // CLEAR SELECT
                $('#unit_name_edit').on('select2:clear', function () {
                    $('#unit_code_edit').val('');
                    $('#unit_display_edit').val('');
                    $('#unit_system_edit').val(
                        'http://unitsofmeasure.org'
                    );
                });

            }
        });
    });

    // Handdel Proses Edit
     $('#ProsesEdit').submit(function (e) {
        e.preventDefault();

        // Variabel Form dan Tombol
        let form = $(this);
        let button = $('#ButtonEdit');

        // Reset notifikasi
        $('#NotifikasiEdit').html('');

        // Loading button
        button.prop('disabled', true);
        let buttonText = button.html();
        button.html(`
            <span class="spinner-border spinner-border-sm"></span>
            Menyimpan...
        `);

        // Ambil form data
        let formData = new FormData(this);
        
        // Kirim Data Dengan AJAX
        $.ajax({
            url: '_Page/ReferensiObservation/ProsesEdit.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',

            success: function (response) {

                // SUCCESS
                if (response.status == 'success') {

                    // Tutup modal
                    $('#ModalEdit').modal('hide');

                    // Reset form
                    form[0].reset();

                    // Reset select2
                    $('#unit_name_edit').val(null).trigger('change');

                    // Reset coded
                    $('#WrapperResultCodedEdit').html('');

                    // Hide optional form
                    $('.form_satuan_unit_edit').hide();
                    $('.form_result_coded_edit').hide();

                    // Sweetalert Toast
                    Swal.fire({
                        icon             : 'success',
                        title            : 'Berhasil',
                        text             : response.message,
                        timer            : 3000,
                        showConfirmButton: false,
                        toast            : true,
                        position         : 'top-end'
                    });

                    // Tampilkan Ulang Tabel
                    TabelReferensiObservation();

                } 
                
               // ERROR
                else {

                    $('#NotifikasiEdit').html(`
                        <div class="alert alert-danger alert-dismissible fade show">
                            <small>${response.message}</small>

                            <button type="button" 
                                class="btn-close" 
                                data-bs-dismiss="alert">
                            </button>
                        </div>
                    `);

                }

            },

            // AJAX ERROR
            error: function (xhr, status, error) {
                $('#NotifikasiEdit').html(`
                    <div class="alert alert-danger alert-dismissible fade show">
                        <small>
                            Terjadi kesalahan pada server!<br>
                            ${error}
                        </small>

                        <button type="button" 
                            class="btn-close" 
                            data-bs-dismiss="alert">
                        </button>
                    </div>
                `);
            },

            // COMPLETE
            complete: function () {

                // Kembalikan tombol
                button.prop('disabled', false);
                button.html(buttonText);

            }
        });
    });

    // HAPUS OBSERVATION
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap ID dan Kategori
        var id_observation_reference = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapus').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapus').html('');

        // Loading Form
        $('#FormHapus').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiObservation/FormHapus.php',
            data        : {id_observation_reference: id_observation_reference},
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
            url        : '_Page/ReferensiObservation/ProsesHapus.php',
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
                        title            : 'Hapus Referensi Observation Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelReferensiObservation();

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