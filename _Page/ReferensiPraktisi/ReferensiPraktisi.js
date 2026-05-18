$(document).ready(function() {
    // ==============
    // Block Function
    // ==============

    // Tabel Praktisi
    function TabelPraktisi() {
        var ProsesFilter = $('#ProsesFilter').serialize();
        let target = $('#tabel_praktisi');

        target.addClass('blur-loading');

        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiPraktisi/TabelPraktisi.php',
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

    // Tabel Akses
    function TabelAkses() {
        var ProsesFilter = $('#ProsesFilterAkses').serialize();
        let target = $('#tabel_akses');

        target.addClass('blur-loading');

        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiPraktisi/TabelAkses.php',
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

                    $('#page_info_akses').html(currentPage + ' / ' + pageCount);
                    $('#previous_page_akses').prop('disabled', currentPage <= 1);
                    $('#next_page_akses').prop('disabled', currentPage <= 0 || currentPage >= pageCount);

                    setTimeout(function () {
                        target.removeClass('blur-loading');
                    }, 200);
                }, 150);
            }
        });
    }

    // Tabel Dokter
    function TabelDokter() {
        var ProsesFilter = $('#ProsesFilterDokter').serialize();
        let target = $('#tabel_dokter');

        target.addClass('blur-loading');

        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiPraktisi/TableDokter.php',
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

                    $('#page_info_akses').html(currentPage + ' / ' + pageCount);
                    $('#previous_page_akses').prop('disabled', currentPage <= 1);
                    $('#next_page_akses').prop('disabled', currentPage <= 0 || currentPage >= pageCount);

                    setTimeout(function () {
                        target.removeClass('blur-loading');
                    }, 200);
                }, 150);
            }
        });
    }

    // ==============
    // Block Event
    // ==============

    // Menampilkan Data Pertama Kali
    TabelPraktisi();

    // Keyword By Diubah
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiPraktisi/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelPraktisi();
        $('#ModalFilter').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelPraktisi(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelPraktisi(0);
    });

    // ====================================================================
    // TAMBAH PRAKTISI
    // ====================================================================

    // Saat Tombol 'modal_tambah_praktisi' Di Click
    $(document).on('click', '.modal_tambah_praktisi', function() {

        // Tangkap Sumber
        let sumber = $(this).data('sumber');
        
        // Data Praktisi Untuk Sumber Akses Pengguna
        if(sumber == 'Akses'){
            // Tampilkan Modal Akses
            $('#ModalAkses').modal('show');

            // Load Tabel Akses
            TabelAkses();
        }

        // Data Praktisi Untuk Sumber Dokter
        if(sumber == 'Dokter'){
             // Tampilkan Modal Dokter
            $('#ModalDokter').modal('show');

            // Load Tabel Akses
            TabelDokter();
        }

        if(sumber == 'Manual'){
            
            // Kosongkan Notifikasi
            $('#NotifikasiTambah').html('');

            // Tampilkan Modal Kosong
            $('#ModalTambah').modal('show');

        }
    });

    // HANDLE DATA AKSES

    // Filter Tabel Akses
    $('#ProsesFilterAkses').submit(function(){
        $('#page_akses').val("1");
        TabelAkses();
    });

    //Pagging Tabel Akses
    $(document).on('click', '#next_page_akses', function() {
        var page_now_akses= parseInt($('#page_akses').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_akses = page_now_akses + 1;
        $('#page_akses').val(next_page_akses);
        TabelAkses(0);
    });
    $(document).on('click', '#previous_page_akses', function() {
        var page_now_akses = parseInt($('#page_akses').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_akses = page_now_akses - 1;
        $('#page_akses').val(next_page_akses);
        TabelAkses(0);
    });

    // Saat Click 'modal_tambah_by_akses'
    $(document).on('click', '.modal_tambah_by_akses', function() {
        let id_akses = $(this).data('id_akses');
        let ihs      = $(this).data('ihs');
        let nama     = $(this).data('nama');
        let nik      = $(this).data('nik');
        let email    = $(this).data('email');
        let kontak   = $(this).data('kontak');
        let akses    = $(this).data('akses');

        // Tutup Modal 'ModalAkses'
        $('#ModalAkses').modal('hide');

        // Tampilkan Modal
        $('#ModalTambah').modal('show');

        // Tempelkan Ke Form
        $('#nama_praktisi').val(nama);
        $('#nik_praktisi').val(nik);
        $('#kontak_praktisi').val(kontak);
        $('#email_praktisi').val(email);
        $('#id_practitioner').val(ihs);

        // Tempelkan Akses
        $('#id_akses').html('<option selected value="'+id_akses+'">'+nama+'</option>');
    });

    // HANDLE DATA DOKTER

    // Filter Tabel Dokter
    $('#ProsesFilterDokter').submit(function(){
        $('#page_dokter').val("1");
        TabelDokter();
    });

    //Pagging Tabel Dokter
    $(document).on('click', '#next_page_dokter', function() {
        var page_now_dokter= parseInt($('#page_dokter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_dokter = page_now_dokter + 1;
        $('#page_dokter').val(next_page_dokter);
        TabelDokter(0);
    });
    $(document).on('click', '#previous_page_dokter', function() {
        var page_now_dokter = parseInt($('#page_dokter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_dokter = page_now_dokter - 1;
        $('#page_dokter').val(next_page_dokter);
        TabelDokter(0);
    });

    // Saat Click 'modal_tambah_by_dokter'
    $(document).on('click', '.modal_tambah_by_dokter', function() {
        let id_dokter = $(this).data('id_dokter');
        let ihs      = $(this).data('ihs');
        let nama     = $(this).data('nama');
        let nik      = $(this).data('nik');
        let email    = $(this).data('email');
        let kontak   = $(this).data('kontak');

        // Tutup Modal 'ModalDokter'
        $('#ModalDokter').modal('hide');

        // Tampilkan Modal
        $('#ModalTambah').modal('show');

        // Tempelkan Ke Form
        $('#nama_praktisi').val(nama);
        $('#nik_praktisi').val(nik);
        $('#kontak_praktisi').val(kontak);
        $('#email_praktisi').val(email);
        $('#id_practitioner').val(ihs);

        // Tempelkan Dokter
        $('#id_dokter').html('<option selected value="'+id_dokter+'">'+nama+'</option>');
    });

    // HANDLE MODAL MUNCUL

    // Saat 'ModalAkses' Muncul
    $('#ModalAkses').on('shown.bs.modal', function () {
        $('#keyword_akses').focus();
    });

    // Saat 'ModalDokter' Muncul
    $('#ModalDokter').on('shown.bs.modal', function () {
        $('#keyword_dokter').focus();
    });

    // Saat 'ModalTambah' Muncul
    $('#ModalTambah').on('shown.bs.modal', function () {
        $('#nama_praktisi').focus();
    });

    // HANDLE CEK NIK
    $(document).on('click', '.modal_cek_nik', function() {

        // Tangkap NIK
        let nik = $('#nik_praktisi').val();

        // Tampilkan Modal
        $('#ModalCeknik').modal('show');

        // Loading Form
        $('#FormCekNik').html('Loading...');

        // Kirim Dengan AJAX
        $.ajax({
            type    : 'POST',
            url     : '_Page/ReferensiPraktisi/FormCekNik.php',
            data    : {nik: nik},
            dataType: 'JSON',
            success : function(response){

                let status  = response.status;
                let message = response.message;
                
                // Jika Ditemukan
                if(status=='success'){
                    let ihs = response.ihs;
                    $('#FormCekNik').html('<div class="alert alert-success text-center"><h1><i class="bi bi-check-circle"></i></h1><small><b>IHS Praktisi Ditemukan</b> <br> <i>ID PRACTITIONER : '+ihs+' </i></small></div>');
                    $('#id_practitioner').val(ihs);

                }else{
                    $('#FormCekNik').html('<div class="alert alert-danger text-center"><small><b>Opss!</b> <br> '+message+'</small></div>');
                }
            }
        });

    });

    // HANDLE SELECT2

    // Select2 Profesi
    $('#profesi_praktisi').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#FormProfesi'),
        placeholder: 'Pilih / Ketik Profesi',
        allowClear: true,
        tags: true,
        ajax: {
            url: '_Page/ReferensiPraktisi/ListProfesi.php',
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
        }
    });

    // Select2 Akses
    $('#id_akses').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#FormAkses'),
        placeholder: 'Pilih Akses',
        allowClear: true,
        ajax: {
            url: '_Page/ReferensiPraktisi/ListAkses.php',
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
        }
    });

    // Select2 Dokter
    $('#id_dokter').select2({
        theme: 'bootstrap-5',
        dropdownParent: $('#FormDokter'),
        placeholder: 'Pilih Dokter',
        allowClear: true,
        ajax: {
            url: '_Page/ReferensiPraktisi/ListDokter.php',
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
        }
    });

    // HANDDLE SUBMIT PRAKTISI
    $(document).on('submit', '#ProsesTambah', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambah');
        let modal      = $('#ModalTambah');
        let notifikasi = $('#NotifikasiTambah');

        let buttonText = button.html();

        let formData = new FormData(this); // ✅ WAJIB

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url: '_Page/ReferensiPraktisi/ProsesTambah.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,   // ✅ WAJIB
            contentType: false,   // ✅ WAJIB

            success: function (response) {

                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {
                    
                    // Reset Form
                    $('#ProsesTambah')[0].reset();

                    // Reset Select2
                    $('#profesi_praktisi').val(null).trigger('change');
                    $('#id_akses').val(null).trigger('change');
                    $('#id_dokter').val(null).trigger('change');

                     // Kosongkan Notifikasi
                    $('#NotifikasiTambah').html('');

                    // Tutup Modal
                    modal.modal('hide');

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Edit Praktisi berhasil',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    // Reset Filter
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

                    // Reload Tabel
                    TabelPraktisi();

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

    

    //==================================================================
    // DETAIL
    //==================================================================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap ID Google Credential
        var id_praktisi = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetail').modal('show');

        // Loading Form
        $('#FormDetail').html(`
            <div class="text-center p-3">
                <div class="spinner-border"></div>
            </div>
        `);

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiPraktisi/FormDetail.php',
            data        : {id_praktisi: id_praktisi},
            success     : function(data){
                $('#FormDetail').html(data);
            }
        });
    });

    // Modal Detail Akses
    $(document).on('click', '.modal_detail_akses', function () {

        // Tangkap Iid_akses
        var id_akses = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailAkses').modal('show');

        // Loading Form
        $('#FormDetailAkses').html(`
            <div class="text-center p-3">
                <div class="spinner-border"></div>
            </div>
        `);

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Akses/FormDetailAkses.php',
            data        : {id_akses: id_akses},
            success     : function(data){
                $('#FormDetailAkses').html(data);
            }
        });
    });

    // Modal Detail Dokter
    $(document).on('click', '.modal_detail_dokter', function () {
        // Tangkap id_dokter
        var id_dokter = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailDokter').modal('show');

        // Loading Form
        $('#FormDetailDokter').html(`
            <div class="text-center p-3">
                <div class="spinner-border"></div>
            </div>
        `);

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiDokter/FormDetailDokter.php',
            data        : {id_dokter: id_dokter},
            success     : function(data){
                $('#FormDetailDokter').html(data);
            }
        });
    });

    //==================================================================
    // EDIT PRAKITISI
    //==================================================================
    $(document).on('click', '.modal_edit', function () {

        // Tangkap id
        var id_praktisi = $(this).data('id');

        // Munculkan Modal
        $('#ModalEdit').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEdit').html('');

        // Loading Form
        $('#FormEdit').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiPraktisi/FormEdit.php',
            data        : {id_praktisi: id_praktisi},
            success     : function(data){
                $('#FormEdit').html(data);

                // Select2 Profesi
                $('#profesi_praktisi_edit').select2({
                    theme         : 'bootstrap-5',
                    dropdownParent: $('#FormProfesiEdit'),
                    placeholder   : 'Pilih / Ketik Profesi',
                    allowClear    : true,
                    tags          : true,
                    ajax          : {
                        url     : '_Page/ReferensiPraktisi/ListProfesi.php',
                        dataType: 'json',
                        delay   : 250,
                        data    : function (params) {
                            return {
                                search: params.term || '',
                                page  : params.page || 1
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

                // Select2 Akses
                $('#id_akses_edit').select2({
                    theme         : 'bootstrap-5',
                    dropdownParent: $('#FormAksesEdit'),
                    placeholder   : 'Pilih Akses',
                    allowClear    : true,
                    ajax          : {
                        url     : '_Page/ReferensiPraktisi/ListAkses.php',
                        dataType: 'json',
                        delay   : 250,
                        data    : function (params) {
                            return {
                                search: params.term || '',
                                page  : params.page || 1
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

                // Select2 Dokter
                $('#id_dokter_edit').select2({
                    theme         : 'bootstrap-5',
                    dropdownParent: $('#FormDokterEdit'),
                    placeholder   : 'Pilih Dokter',
                    allowClear    : true,
                    ajax          : {
                        url     : '_Page/ReferensiPraktisi/ListDokter.php',
                        dataType: 'json',
                        delay   : 250,
                        data    : function (params) {
                            return {
                                search: params.term || '',
                                page  : params.page || 1
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
            }
        });
    });

    // HANDLE CEK NIK
    $(document).on('click', '.modal_cek_nik_edit', function() {

        // Tangkap NIK
        let nik = $('#nik_praktisi_edit').val();

        // Tampilkan Modal
        $('#ModalCeknik').modal('show');

        // Loading Form
        $('#FormCekNik').html('Loading...');

        // Kirim Dengan AJAX
        $.ajax({
            type    : 'POST',
            url     : '_Page/ReferensiPraktisi/FormCekNik.php',
            data    : {nik: nik},
            dataType: 'JSON',
            success : function(response){

                let status  = response.status;
                let message = response.message;
                
                // Jika Ditemukan
                if(status=='success'){
                    let ihs = response.ihs;
                    $('#FormCekNik').html('<div class="alert alert-success text-center"><h1><i class="bi bi-check-circle"></i></h1><small><b>IHS Praktisi Ditemukan</b> <br> <i>ID PRACTITIONER : '+ihs+' </i></small></div>');
                    $('#id_practitioner_edit').val(ihs);

                }else{
                    $('#FormCekNik').html('<div class="alert alert-danger text-center"><small><b>Opss!</b> <br> '+message+'</small></div>');
                }
            }
        });

    });

    // HANDLE SUBMIT EDIT
    $(document).on('submit', '#ProsesEdit', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonEdit');
        let modal      = $('#ModalEdit');
        let notifikasi = $('#NotifikasiEdit');

        let buttonText = button.html();

        let formData = new FormData(this); // ✅ WAJIB

        notifikasi.html('');

        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url: '_Page/ReferensiPraktisi/ProsesEdit.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,   // ✅ WAJIB
            contentType: false,   // ✅ WAJIB

            success: function (response) {

                button.prop('disabled', false).html(buttonText);

                if (response.status === 'success') {

                    modal.modal('hide');
                    TabelPraktisi();

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Edit Praktisi berhasil',
                        showConfirmButton: false,
                        timer: 1500
                    });

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

    //==================================================================
    // HAPUS PRAKTISI
    //==================================================================
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap id
        var id_praktisi = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapus').modal('show');

        // Loading Form
        $('#FormHapus').html('Loading...');

        // Kosongkan Notifikasi
        $('#NotifikasiHapus').html('');

        // Tampilkan Dengan AJAX
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/ReferensiPraktisi/FormHapus.php',
            data        : {id_praktisi: id_praktisi},
            success     : function(data){
                $('#FormHapus').html(data);
            }
        });
    });

    // Submit Hapus  Praktisi
    $(document).on('submit', '#ProsesHapus', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonHapus');
        let modal      = $('#ModalHapus');
        let notifikasi = $('#NotifikasiHapus');

        // Simpan text tombol asli
        let buttonText = button.html();

        // Ambil data form
        let formData = form.serialize();

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html('...');

        $.ajax({
            url: '_Page/ReferensiPraktisi/ProsesHapus.php',
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
                        title            : 'Hapus Praktisi Berhasil',
                        showConfirmButton: false,
                        timer            : 2000,
                        timerProgressBar : true
                    });

                    // refresh tabel
                    TabelPraktisi();

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
