$(document).ready(function () {
    // ====================================================================
    // FUNCTION BLOCK
    // Semua Function Jquery/Javascript Di Tulias Pada Block Ini
    // ====================================================================

    // Tabel Referensi Imunisasi
    function TabelImunisasi() {
        var ProsesFilter = $('#ProsesFilter').serialize();
        let target = $('#tabel_imunisasi');

        target.addClass('blur-loading');

        $.ajax({
            type: 'POST',
            url: '_Page/Imunisasi/TabelImunisasi.php',
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

    /** Select2 Pasien */
    const modalTambahImunisasi = $('#ModalTambah');
    const selectPasienImunisasi = $('#id_pasien');
    const parentSelectPasienImunisasi = $('#select_id_pasien');

    function Select2Pasien() {
        if (!selectPasienImunisasi.length || typeof $.fn.select2 !== 'function') {
            return;
        }
        if (selectPasienImunisasi.hasClass('select2-hidden-accessible')) {
            return;
        }

        function templatePasien(item) {
            if (item.loading || !item.id) {
                return item.text || '';
            }

            const row = $('<div>');
            $('<div>').css('font-weight', 'bold').text(item.id_pasien || item.id).appendTo(row);
            $('<div>').text(item.nama || '').appendTo(row);
            return row;
        }

        selectPasienImunisasi.select2({
            theme: 'bootstrap-5',
            dropdownParent: parentSelectPasienImunisasi.length ? parentSelectPasienImunisasi : modalTambahImunisasi,
            placeholder: 'Cari Pasien',
            allowClear: true,
            width: '100%',
            templateResult: templatePasien,
            templateSelection: templatePasien,
            ajax: {
                url: '_Page/Imunisasi/get_pasien.php',
                type: 'GET',
                dataType: 'JSON',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function (response) {
                    return {
                        results: Array.isArray(response.results) ? response.results : [],
                        pagination: {
                            more: !!(response.pagination && response.pagination.more)
                        }
                    };
                }
            }
        });
    }

    /** Select2 Kunjungan */
    const selectKunjunganImunisasi = $('#id_kunjungan');
    const parentSelectKunjunganImunisasi = $('#select_id_kunjungan');

    function Select2Kunjungan() {
        if (!selectKunjunganImunisasi.length || typeof $.fn.select2 !== 'function') {
            return;
        }
        if (selectKunjunganImunisasi.hasClass('select2-hidden-accessible')) {
            return;
        }

        function templateKunjungan(item) {
            if (item.loading || !item.id) {
                return item.text || '';
            }

            const row = $('<div>', { class: 'imunisasi-select2-kunjungan' });
            $('<div>', { class: 'imunisasi-select2-kunjungan-id' }).text(item.id_kunjungan || item.id).appendTo(row);
            $('<div>', { class: 'imunisasi-select2-kunjungan-info' }).text((item.tanggal_kunjungan || '') + ' - ' + (item.jenis_kunjungan || '')).appendTo(row);
            return row;
        }

        selectKunjunganImunisasi.select2({
            theme: 'bootstrap-5',
            dropdownParent: parentSelectKunjunganImunisasi.length ? parentSelectKunjunganImunisasi : modalTambahImunisasi,
            placeholder: 'Pilih Kunjungan',
            allowClear: true,
            width: '100%',
            templateResult: templateKunjungan,
            templateSelection: function (item) {
                if (item.loading || !item.id) {
                    return item.text || '';
                }
                return $('<div>', { class: 'imunisasi-select2-kunjungan-id' }).text(item.id_kunjungan || item.id);
            },
            ajax: {
                url: '_Page/Imunisasi/get_kunjungan.php',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        id_pasien: $('#id_pasien').val() || '',
                        term: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function (response) {
                    return {
                        results: Array.isArray(response.results) ? response.results : []
                    };
                }
            }
        });
    }

    /** Select2 Imunisasi Referensi */
    const selectImunisasiReferensi = $('#id_imunisasi_referensi');
    const parentSelectImunisasiReferensi = $('#select_imunisasi_referensi');

    function Select2ImunisasiReferensi() {
        if (!selectImunisasiReferensi.length || typeof $.fn.select2 !== 'function') {
            return;
        }
        if (selectImunisasiReferensi.hasClass('select2-hidden-accessible')) {
            return;
        }

        selectImunisasiReferensi.select2({
            theme: 'bootstrap-5',
            dropdownParent: parentSelectImunisasiReferensi.length ? parentSelectImunisasiReferensi : modalTambahImunisasi,
            placeholder: 'Pilih Vaksin',
            allowClear: true,
            width: '100%',
            ajax: {
                url: '_Page/Imunisasi/get_imunisasi_referensi.php',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function (response) {
                    return {
                        results: Array.isArray(response.results) ? response.results : []
                    };
                }
            }
        });
    }

    /** Select2 Body Site */
    const selectBodySiteImunisasi = $('#id_body_site');
    const parentSelectBodySite = $('#select_body_site');

    function Select2BodySite() {
        if (!selectBodySiteImunisasi.length || typeof $.fn.select2 !== 'function') {
            return;
        }
        if (selectBodySiteImunisasi.hasClass('select2-hidden-accessible')) {
            return;
        }

        selectBodySiteImunisasi.select2({
            theme: 'bootstrap-5',
            dropdownParent: parentSelectBodySite.length ? parentSelectBodySite : modalTambahImunisasi,
            placeholder: 'Pilih Body Site',
            allowClear: true,
            width: '100%',
            ajax: {
                url: '_Page/Imunisasi/get_body_site.php',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function (response) {
                    return {
                        results: Array.isArray(response.results) ? response.results : []
                    };
                }
            }
        });
    }

    // Tampilkan detail body site terpilih pada preview
    $('#id_body_site').on('select2:select', function (e) {
        const data = e.params.data || {};
        const preview = $('#body_site_preview');
        if (!preview.length) return;

        const category = data.body_site_category || '-';
        const nama = data.body_site_nama || data.text || '-';
        const display = data.body_site_display || '-';
        const code = data.body_site_code || '-';
        const system = data.body_site_system || '-';

        preview.html(
            '<div class="row mb-1">' +
            '  <div class="col-4"><small class="text-muted">Kategori</small></div>' +
            '  <div class="col-1"><small class="text-muted">:</small></div>' +
            '  <div class="col-7"><small class="text-muted">' + $('<div>').text(category).html() + '</small></div>' +
            '</div>' +
            '<div class="row mb-1">' +
            '  <div class="col-4"><small class="text-muted">Nama</small></div>' +
            '  <div class="col-1"><small class="text-muted">:</small></div>' +
            '  <div class="col-7"><small class="text-muted">' + $('<div>').text(nama).html() + '</small></div>' +
            '</div>' +
            '<div class="row mb-1">' +
            '  <div class="col-4"><small class="text-muted">Display</small></div>' +
            '  <div class="col-1"><small class="text-muted">:</small></div>' +
            '  <div class="col-7"><small class="text-muted">' + $('<div>').text(display).html() + '</small></div>' +
            '</div>' +
            '<div class="row mb-1">' +
            '  <div class="col-4"><small class="text-muted">Code</small></div>' +
            '  <div class="col-1"><small class="text-muted">:</small></div>' +
            '  <div class="col-7"><small class="text-muted">' + $('<div>').text(code).html() + '</small></div>' +
            '</div>' +
            '<div class="row mb-1">' +
            '  <div class="col-4"><small class="text-muted">System</small></div>' +
            '  <div class="col-1"><small class="text-muted">:</small></div>' +
            '  <div class="col-7"><small class="text-muted">' + $('<div>').text(system).html() + '</small></div>' +
            '</div>'
        );
    });

    $('#id_body_site').on('select2:clear', function () {
        $('#body_site_preview').html('');
    });

    /** Select2 Praktisi */
    const selectPraktisiImunisasi = $('#id_praktisi');
    const parentPraktisiImunisasi = $('#select_praktisi');

    function Select2Praktisi() {
        if (!selectPraktisiImunisasi.length || typeof $.fn.select2 !== 'function') {
            return;
        }
        if (selectPraktisiImunisasi.hasClass('select2-hidden-accessible')) {
            return;
        }

        selectPraktisiImunisasi.select2({
            theme: 'bootstrap-5',
            dropdownParent: parentPraktisiImunisasi.length ? parentPraktisiImunisasi : modalTambahImunisasi,
            placeholder: 'Pilih Petugas Medis',
            allowClear: true,
            width: '100%',
            ajax: {
                url: '_Page/Imunisasi/get_praktisi.php',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function (response) {
                    return {
                        results: Array.isArray(response.results) ? response.results : []
                    };
                }
            }
        });
    }

    // Memulai Inisiasi Select2 Untuk Mode Edit
    function InitSelect2FormEdit() {
        const modalEdit = $('#ModalEdit');
        const form = $('#FormEdit');

        function initSelect(selector, config) {
            const el = form.find(selector);
            if (!el.length || typeof $.fn.select2 !== 'function') return;
            if (el.hasClass('select2-hidden-accessible')) return;
            el.select2(config);
        }

        // id_pasien
        initSelect('#id_pasien', {
            theme: 'bootstrap-5',
            dropdownParent: modalEdit.length ? modalEdit : form,
            placeholder: 'Cari Pasien',
            allowClear: true,
            width: '100%',
            ajax: {
                url: '_Page/Imunisasi/get_pasien.php',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { term: params.term || '', page: params.page || 1 };
                },
                processResults: function (response) {
                    return { results: Array.isArray(response.results) ? response.results : [] };
                }
            }
        });

        // id_kunjungan
        initSelect('#id_kunjungan', {
            theme: 'bootstrap-5',
            dropdownParent: modalEdit.length ? modalEdit : form,
            placeholder: 'Pilih Kunjungan',
            allowClear: true,
            width: '100%',
            ajax: {
                url: '_Page/Imunisasi/get_kunjungan.php',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        id_pasien: form.find('#id_pasien').val() || '',
                        term: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function (response) {
                    return { results: Array.isArray(response.results) ? response.results : [] };
                }
            }
        });

        // id_imunisasi_referensi
        initSelect('#id_imunisasi_referensi_edit', {
            theme: 'bootstrap-5',
            dropdownParent: modalEdit.length ? modalEdit : form,
            placeholder: 'Pilih Vaksin',
            allowClear: true,
            width: '100%',
            ajax: {
                url: '_Page/Imunisasi/get_imunisasi_referensi.php',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { term: params.term || '', page: params.page || 1 };
                },
                processResults: function (response) {
                    return { results: Array.isArray(response.results) ? response.results : [] };
                }
            }
        });

        // id_body_site
        initSelect('#id_body_site', {
            theme: 'bootstrap-5',
            dropdownParent: modalEdit.length ? modalEdit : form,
            placeholder: 'Pilih Body Site',
            allowClear: true,
            width: '100%',
            ajax: {
                url: '_Page/Imunisasi/get_body_site.php',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { term: params.term || '', page: params.page || 1 };
                },
                processResults: function (response) {
                    return { results: Array.isArray(response.results) ? response.results : [] };
                }
            }
        });

        // id_praktisi
        initSelect('#id_praktisi_edit', {
            theme: 'bootstrap-5',
            dropdownParent: modalEdit.length ? modalEdit : form,
            placeholder: 'Pilih Petugas Medis',
            allowClear: true,
            width: '100%',
            ajax: {
                url: '_Page/Imunisasi/get_praktisi.php',
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { term: params.term || '', page: params.page || 1 };
                },
                processResults: function (response) {
                    return { results: Array.isArray(response.results) ? response.results : [] };
                }
            }
        });

        // preview body site on select
        form.find('#id_body_site').on('select2:select', function (e) {
            const data = e.params.data || {};
            const preview = $('#body_site_preview'); // not in edit? maybe none
            // no preview in edit form; skip
        });
    }

    // Bersihkan pilihan kunjungan ketika pasien berubah
    $('#id_pasien').on('change', function () {
        if (selectKunjunganImunisasi.hasClass('select2-hidden-accessible')) {
            selectKunjunganImunisasi.val(null).trigger('change');
        }
    });

    // ====================================================================
    // EVENT BLOCK
    // Semua Script Javascript / Jquery Event Handler Ditulis Disini
    // ====================================================================

    // Load Tabel Pada Saat Pertama Kali
    TabelImunisasi();

    //Pagging
    $(document).on('click', '#next_page', function () {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelImunisasi(0);
    });
    $(document).on('click', '#previous_page', function () {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelImunisasi(0);
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
            url: '_Page/Imunisasi/FormFilter.php',
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
        TabelImunisasi();
    });

    // ==============================
    // TAMBAH IMUNISASI
    // ==============================

    // Ketika Modal Tambah Muncul
    $('#ModalTambah').on('shown.bs.modal', function () {

        // Fokus otomatis 'id_pasien'
        $('#id_pasien').focus();

        // Isi tanggal dan jam pemberian dengan waktu sekarang (sesuai timezone user)
        $.ajax({
            type: 'GET',
            url: '_Page/Imunisasi/datetime_now.php',
            dataType: 'json',
            success: function (response) {
                if (response && response.status === 'success') {
                    if (response.tanggal) {
                        $('#tanggal_pemberian').val(response.tanggal);
                    }
                    if (response.jam) {
                        $('#jam_pemberian').val(response.jam);
                    }
                }
            }
        });

        // Menampilkan Select2 'id_pasien'
        Select2Pasien();

        // Menampilkan Select2 'id_kunjungan'
        Select2Kunjungan();

        // Menampilkan Select2 'id_imunisasi_referensi'
        Select2ImunisasiReferensi();

        // Menampilkan Select2 'id_body_site'
        Select2BodySite();

        // Menampilkan Select2 'id_praktisi'
        Select2Praktisi();

    });

    // Handdle Submit Referensi Imunisasi
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
            url: '_Page/Imunisasi/ProsesTambah.php',
            type: 'POST',
            data: formData,
            dataType: 'JSON',
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

                    // Reset Select2
                    $('#id_pasien').val(null).trigger('change');
                    $('#id_kunjungan').val(null).trigger('change');
                    $('#id_imunisasi_referensi').val(null).trigger('change');
                    $('#id_body_site').val(null).trigger('change');
                    $('#id_praktisi').val(null).trigger('change');

                    // Reset preview body site
                    $('#body_site_preview').html('');


                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Tambah Referensi Imunisasi Berhasil',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });

                    // Reset Filter Kembali Ke halaman 1 (Belulum)
                    $('#ProsesFilter')[0].reset();
                    $('#page_filter').val(1);

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelImunisasi();

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
    // DETAIL
    // ==============================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap id_imunisasi
        var id_imunisasi = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetail').modal('show');

        // Loading Form
        $('#FormDetail').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Imunisasi/FormDetail.php',
            data: { id_imunisasi: id_imunisasi },
            success: function (data) {
                $('#FormDetail').html(data);
            }
        });
    });

    // ==============================
    // EDIT
    // ==============================
    $(document).on('click', '.modal_edit', function () {

        // Tangkap ID
        var id_imunisasi = $(this).data('id');

        // Munculkan Modal
        $('#ModalEdit').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEdit').html('');

        // Loading Form
        $('#FormEdit').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Imunisasi/FormEdit.php',
            data: { id_imunisasi: id_imunisasi },
            success: function (data) {
                $('#FormEdit').html(data);
                InitSelect2FormEdit();
            }
        });
    });

    // Handdle Submit Edit Referensi Tindakan
    $(document).on('submit', '#ProsesEdit', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonEdit');
        let modal = $('#ModalEdit');
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
            url: '_Page/Imunisasi/ProsesEdit.php',
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

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Edit Imunisasi Berhasil',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelImunisasi();

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
    // HAPUS
    // ==============================
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap ID dan Kategori
        var id_imunisasi = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapus').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapus').html('');

        // Loading Form
        $('#FormHapus').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Imunisasi/FormHapus.php',
            data: { id_imunisasi: id_imunisasi },
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
            url        : '_Page/Imunisasi/ProsesHapus.php',
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
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Hapus Imunisasi Berhasil',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelImunisasi();

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

