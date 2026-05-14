// Tabel Kunjungan
function TabelKunjungan() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_kunjungan');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Kunjungan/TabelKunjungan.php',
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

// Tabel Pasien
function TabelPasien() {
    var ProsesFilterPasien = $('#ProsesFilterPasien').serialize();
    let target = $('#tabel_pasien');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Kunjungan/TabelPasien.php',
        data: ProsesFilterPasien,
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

                $('#page_info_pasien').html(currentPage + ' / ' + pageCount);
                $('#previous_page_pasien').prop('disabled', currentPage <= 1);
                $('#next_page_pasien').prop('disabled', currentPage <= 0 || currentPage >= pageCount);

                setTimeout(function () {
                    target.removeClass('blur-loading');
                }, 200);
            }, 150);
        }
    });
}

// Saat Memilih Kenis Kunjungan
function toggleRanapField() {
    let jenis_kunjungan = $('input[name="jenis_kunjungan"]:checked').val();
    if (jenis_kunjungan === 'Ranap') {
        $('#kelas').prop('disabled', false);
        $('#ruang_rawat').prop('disabled', false);
        $('#tempat_tidur').prop('disabled', false);
    } else {
        $('#kelas').prop('disabled', true).val('');
        $('#ruang_rawat').prop('disabled', true).val('');
        $('#tempat_tidur').prop('disabled', true).val('');
    }
}

// Show Select Option Province
function loadProvince() {
    $.ajax({
        url: '_Page/Pasien/GetProvince.php',
        type: 'GET',
        success: function (res) {
            $('#province').html(res);
        }
    });
}

function ShowDetail() {
    // Tangkap Data Dari Detail Kunjungan
    var ProsesDetailKunjungan = $('#ProsesDetailKunjungan').serialize();
    
    // Tampilkan Detail Kunjungan Dengan Ajax
    $.ajax({
        type 	    : 'POST',
        url 	    : '_Page/Kunjungan/_DetailKunjungan.php',
        data        : ProsesDetailKunjungan,
        success     : function(data){
            $('#detail_view').html(data);
        }
    });
}

// ====================================================================
//MENAMPILKAN DATA PERTAMA KALI
// ====================================================================
$(document).ready(function() {

    // Tampilkan Tabel
    $('#table_view').show();

    // Sembunyikan Detail View
    $('#detail_view').hide();

    // Sembunyikan Form Tambah
    $('#registration_view').hide();

    // Load Tabel
    TabelKunjungan();

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelKunjungan(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelKunjungan(0);
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
            url 	    : '_Page/Kunjungan/FormFilter.php',
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
        TabelKunjungan();
    });

    //Ketika Tombol .back_to_table_view di click
    $(document).on('click', '.back_to_table_view', function () {
        
        // Tempelkan Tabel
        $('#table_view').show();

        // Sembunyikan Detail View
        $('#detail_view').hide();

        // Sembunyikan Form Tambah
        $('#registration_view').hide();

    });

    // ====================================================================
    //TAMBAH KUNJUNGAN
    // ====================================================================
    
    // Auto Focus Keyword (Saat Pencarian Pasien)
    $('#ModalPilihPasien').on('shown.bs.modal', function () {
        $('#keyword_pasien').focus();

        // Menampilkan Tabel Pasien
        TabelPasien();

    });

    // Pencarian pasien
    $('#ProsesFilterPasien').submit(function(){
        $('#page_pasien').val('1');
       TabelPasien();
    });

    // Pagging data pasien
    $(document).on('click', '#next_page_pasien', function() {
        var page_now_pasien = parseInt($('#page_pasien').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_pasien = page_now_pasien + 1;
        $('#page_pasien').val(next_page_pasien);
        TabelPasien(0);
    });
    $(document).on('click', '#previous_page_pasien', function() {
        var page_now_pasien = parseInt($('#page_pasien').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page_pasien = page_now_pasien - 1;
        $('#page_pasien').val(next_page_pasien);
        TabelPasien(0);
    });

    // Ketika Salah Satu pasien Dipilih
    $(document).on('click', '.pilih_pasien', function () {
        let id_pasien = $(this).data('id');
        let nama      = $(this).data('nama');
        let no_bpjs   = $(this).data('no_bpjs');
        let nik       = $(this).data('nik');
        let id_ihs    = $(this).data('id_ihs');

        // Tutup Modal
        $('#ModalPilihPasien').modal('hide');

        // Sembunyikan Tabel
        $('#table_view').hide();

        // Sembunyikan Detail View
        $('#detail_view').hide();

        // Munculkan Form Tambah
        $('#registration_view').show();

        // Tempelkan Nilai Ke Form
        $('#id_pasien').val(id_pasien);
        $('#nama').val(nama);
        $('#nik').val(nik);
        $('#id_ihs').val(id_ihs);
        $('#no_bpjs').val(no_bpjs);
    });
    
    // Saat Raajal Ranap Dipilih Pada Form Tambah Kunjungan
    toggleRanapField();

    // Saat radio berubah
    $('input[name="jenis_kunjungan"]').on('change', function () {
        toggleRanapField();
    });

    // Saat Metode Pembayaran Diubah
    $(document).on('change', 'input[name="pembayaran_metode"]', function () {

        // Ambil metode pembayaran
        let metode = $(this).val();

        // Ambil nomor BPJS
        let no_bpjs = $('#no_bpjs').val().trim();

        // Reset default dulu
        $('#pembayaran_penanggung').val('');

        // Hanya jalan jika ASURANSI
        if (metode !== 'ASURANSI') {
            return;
        }

        // Validasi nomor BPJS
        if (no_bpjs === '') {
            return;
        }

        // Loading sementara
        $('#pembayaran_penanggung')
            .val('Memuat data peserta...');

        $.ajax({
            type: 'POST',
            url: '_Page/Pasien/ProsesCariNoBpjs.php',
            dataType: 'JSON',
            data: {
                no_bpjs: no_bpjs
            },

            success: function (response) {

                // Validasi object response
                if (!response || typeof response !== 'object') {

                    $('#pembayaran_penanggung').val('');

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Response server tidak valid'
                    });

                    return;
                }

                // Jika sukses
                if (response.status === 'Success') {

                    let metadata = response.metadata || {};
                    let jenisPeserta = metadata.jenisPeserta || '';

                    if (jenisPeserta !== '') {
                        $('#pembayaran_penanggung')
                            .val(jenisPeserta);
                    } else {

                        $('#pembayaran_penanggung').val('');

                        Swal.fire({
                            icon: 'warning',
                            title: 'Perhatian',
                            text: 'Jenis peserta BPJS tidak ditemukan'
                        });
                    }

                } else {

                    $('#pembayaran_penanggung').val('');

                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian',
                        text: response.message || 'Data peserta tidak ditemukan'
                    });
                }
            },

            error: function (xhr, status, error) {

                $('#pembayaran_penanggung').val('');

                Swal.fire({
                    icon: 'error',
                    title: 'AJAX Error',
                    text: error
                });

                console.log(xhr.responseText);
            }
        });
    });
    
    // Load Data Dokter Penerima
    $('#id_dokter').select2({
        theme         : 'bootstrap-5',
        dropdownParent: $('#ProsesTambahKunjungan'),
        placeholder   : 'Pilih Dokter',
        allowClear    : true,
        ajax: {
            url: '_Page/Kunjungan/ListDokter.php',
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
        }
    });

    // Ketika dokter dipilih
    $('#id_dokter').on('select2:select', function (e) {

        let data = e.params.data;

        $('#kode_dokter').val(data.kode);
        $('#dokter').val(data.nama);

    });

    // Jika clear
    $('#id_dokter').on('select2:clear', function () {

        $('#kode_dokter').val('');
        $('#dokter').val('');

    });

    // Load Data Dokter DPJP
    $('#dpjp_id').select2({
        theme         : 'bootstrap-5',
        dropdownParent: $('#ProsesTambahKunjungan'),
        placeholder   : 'Pilih Dokter',
        allowClear    : true,
        ajax: {
            url: '_Page/Kunjungan/ListDokter.php',
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
        }
    });

    // Ketika dokter dipilih
    $('#dpjp_id').on('select2:select', function (e) {

        let data = e.params.data;

        $('#dpjp_kode').val(data.kode);
        $('#dpjp_nama').val(data.nama);

    });

    // Jika clear
    $('#dpjp_id').on('select2:clear', function () {

        $('#dpjp_kode').val('');
        $('#dpjp_nama').val('');

    });

    // Load Poliklinik
    $('#id_poliklinik').select2({
        theme         : 'bootstrap-5',
        dropdownParent: $('#ProsesTambahKunjungan'),
        placeholder   : 'Pilih Poliklinik',
        allowClear    : true,
        ajax: {
            url: '_Page/Kunjungan/ListPoliklinik.php',
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
        }
    });

    // Ketika dokter dipilih
    $('#id_poliklinik').on('select2:select', function (e) {

        let data = e.params.data;

        $('#kode_poliklinik').val(data.kode);
        $('#poliklinik').val(data.nama);

    });

    // Jika clear
    $('#id_poliklinik').on('select2:clear', function () {

        $('#kode_poliklinik').val('');
        $('#poliklinik').val('');

    });

    // Pemilihan Kelas, Ruangan Dan Tempat Tidur
    // TAMPILKAN KELAS RAWAT
    $('#ModalKelas').on('shown.bs.modal', function () {

        $.ajax({
            url: '_Page/Kunjungan/TabelKelasRawat.php',
            type: 'POST',
            beforeSend: function () {

                $('#tabel_kelas_rawat').html(`
                    <tr>
                        <td colspan="7" class="text-center">
                            <small>Loading...</small>
                        </td>
                    </tr>
                `);

            },
            success: function (response) {
                $('#tabel_kelas_rawat').html(response);
            }
        });

    });

    // PILIH KELAS RAWAT
    $(document).on('click', '.pilih-kelas', function () {

        let id_kelas_rawat = $(this).data('id');
        let kelas          = $(this).data('kelas');

        $('#id_kelas_rawat').val(id_kelas_rawat);
        $('#kelas').val(kelas);
        $('#kelas').attr('data-id', id_kelas_rawat);

        // Reset bawahnya
        $('#ruang_rawat').val('').attr('data-id', '');
        $('#tempat_tidur').val('').attr('data-id', '');

        $('#ModalKelas').modal('hide');

    });

    // TAMPILKAN RUANGAN
    $('#ModalRuangan').on('shown.bs.modal', function () {

        let id_kelas_rawat = $('#id_kelas_rawat').val();

        if (!id_kelas_rawat) {

            $('#tabel_ruangan').html(`
                <tr>
                    <td colspan="5" class="text-center">
                        <small class="text-danger">
                            Pilih kelas rawat terlebih dahulu
                        </small>
                    </td>
                </tr>
            `);

            return;
        }

        $.ajax({
            url: '_Page/Kunjungan/TabelRuangan.php',
            type: 'POST',
            data: {
                id_kelas_rawat: id_kelas_rawat
            },

            beforeSend: function () {

                $('#tabel_ruangan').html(`
                    <tr>
                        <td colspan="5" class="text-center">
                            <small>Loading...</small>
                        </td>
                    </tr>
                `);

            },

            success: function (response) {
                $('#tabel_ruangan').html(response);
            }
        });

    });

    // PILIH RUANGAN
    $(document).on('click', '.pilih-ruangan', function () {

        let id_ruang_rawat = $(this).data('id');
        let ruang_rawat    = $(this).data('ruang');

        $('#ruang_rawat').val(ruang_rawat);
        $('#id_ruang_rawat').val(id_ruang_rawat);
        $('#ruang_rawat').attr('data-id', id_ruang_rawat);

        // Reset TT
        $('#tempat_tidur').val('').attr('data-id', '');

        $('#ModalRuangan').modal('hide');

    });

    // TAMPILKAN TEMPAT TIDUR
    $('#ModalTempatTidur').on('shown.bs.modal', function () {

        let id_kelas_rawat = $('#id_kelas_rawat').val();
        let id_ruang_rawat = $('#id_ruang_rawat').val();

        if (!id_kelas_rawat || !id_ruang_rawat) {

            $('#tabel_tempat_tidur').html(`
                <tr>
                    <td colspan="5" class="text-center">
                        <small class="text-danger">
                            Pilih ruangan terlebih dahulu
                        </small>
                    </td>
                </tr>
            `);

            return;
        }

        $.ajax({
            url: '_Page/Kunjungan/TabelTempatTidur.php',
            type: 'POST',
            data: {
                id_kelas_rawat: id_kelas_rawat,
                id_ruang_rawat: id_ruang_rawat
            },

            beforeSend: function () {

                $('#tabel_tempat_tidur').html(`
                    <tr>
                        <td colspan="5" class="text-center">
                            <small>Loading...</small>
                        </td>
                    </tr>
                `);

            },

            success: function (response) {
                $('#tabel_tempat_tidur').html(response);
            }
        });

    });

    // PILIH TEMPAT TIDUR
    $(document).on('click', '.pilih-tempat-tidur', function () {

        let id_tempat_tidur = $(this).data('id');
        let tempat_tidur    = $(this).data('tempat_tidur');

        $('#tempat_tidur').val(tempat_tidur);
        $('#tempat_tidur').attr('data-id', id_tempat_tidur);

        $('#ModalTempatTidur').modal('hide');

    });

    // ketika Pernytaan Petugas Di Pilih
    // Check Pernyataan
    $('#pernyataan_petugas').on('change', function () {
        if ($(this).is(':checked')) {
            $('#ButtonTambahKunjungan').prop('disabled', false);
        } else {
            $('#ButtonTambahKunjungan').prop('disabled', true);
        }
    });

    // Submit Tambah Kunjungan
    $(document).ready(function() {

        $('#ProsesTambahKunjungan').on('submit', function(e) {
            e.preventDefault();

            let form        = $(this);
            let button      = $('#ButtonTambahKunjungan');
            let notifikasi  = $('#NotifikasiTambahKunjungan');

            // Reset notifikasi
            notifikasi.html('');

            // Simpan text tombol
            let buttonText = button.html();

            // Loading Button
            button.prop('disabled', true);
            button.html(`
                <span class="spinner-border spinner-border-sm"></span>
                Menyimpan...
            `);

            $.ajax({
                type: 'POST',
                url: '_Page/Kunjungan/ProsesTambahKunjungan.php',
                data: form.serialize(),
                dataType: 'JSON',

                success: function(response) {

                    // Kembalikan tombol
                    button.prop('disabled', false);
                    button.html(buttonText);

                    if (response.status == 'success') {

                        // Toast Success
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        // Reset form
                        form[0].reset();

                        // Reset Select2
                        $('#id_dokter').val(null).trigger('change');
                        $('#dpjp_id').val(null).trigger('change');
                        $('#id_poliklinik').val(null).trigger('change');

                        // Reset hidden field
                        $('#id_kelas_rawat').val('');
                        $('#id_ruang_rawat').val('');
                        $('#id_tempat_tidur').val('');

                        // Reset field rawat inap
                        $('#kelas').val('');
                        $('#ruang_rawat').val('');
                        $('#tempat_tidur').val('');

                        // Tampilkan Tabel
                        $('#table_view').show();

                        // Sembunyikan Detail View
                        $('#detail_view').hide();

                        // Sembunyikan Form Tambah
                        $('#registration_view').hide();

                        // Reset Form Filter
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

                        // Reload Tabel Kunjungan
                        TabelKunjungan();

                    } else {

                        notifikasi.html(`
                            <div class="alert alert-danger alert-dismissible fade show">
                                ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        `);

                    }
                },

                error: function(xhr) {

                    button.prop('disabled', false);
                    button.html(buttonText);

                    notifikasi.html(`
                        <div class="alert alert-danger alert-dismissible fade show">
                            Terjadi kesalahan pada server.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `);

                    console.log(xhr.responseText);
                }
            });

        });
    });

    // ===================================
    // DETAIL KUNJUNGAN
    // ===================================
    
    $(document).on('click', '.modal_detail', function () {
        
        // Tangkap id_kunjungan
        let id_kunjungan = $(this).data('id');

        // Loading Form
        $('#FormDetailKunjungan').html('Loading...');

        // Disable Button
        $('#ButtonDetailKunjunganSelengkapnya').prop('disabled', true);

        // Tampilkan Modal
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

    // Ketika submit Selengkapnya
    $('#ProsesDetailKunjungan').on('submit', function(e) {

        // Tampilkan detail_view
        $('#detail_view').show();

        // Sembunyikan tabel dan form registrasi
        $('#table_view').hide();
        $('#registration_view').hide();

        // Tutup Modal
        $('#ModalDetailKunjungan').modal('hide');

        ShowDetail();
    });

    $(document).on('click', '.modal_reload_detail_kunjungan', function () {
        ShowDetail();
    });

    //===================================================
    // PENDAFTARAN PASIEN BARU
    //===================================================
    $(document).on('click', '#modal_tambah_pasien', function () {
        
        // Tampilkan Modal
        $('#ModalTambahPasien').modal('show');

    });

    // Auto Focus Keyword
    $('#ModalTambahPasien').on('shown.bs.modal', function () {
        $('#nik_pasien').focus();
    });

    //Mode No RM Manual
    $('#id_pasien_manual').on('change', function () {
        if ($(this).is(':checked')) {
            $('#id_pasien_baru').prop('disabled', false).removeClass('bg-secondary-subtle');
        } else {
            $('#id_pasien_baru').prop('disabled', true).addClass('bg-secondary-subtle').val('');
        }
    });

    // Pasien Anak Relasi Ibu
    $('#pasien_anak').on('change', function () {
        if ($(this).is(':checked')) {
            $('#id_pasien_relasi').prop('disabled', false).removeClass('bg-danger-subtle');

            // INIT SELECT2
            $('#id_pasien_relasi').select2({
                theme             : 'bootstrap-5',
                dropdownParent    : $('#ModalTambahPasien'),
                placeholder       : 'Cari No.RM / Nama Pasien',
                minimumInputLength: 0,
                ajax              : {
                    url     : '_Page/Pasien/SearchPasien.php',
                    type    : 'POST',
                    dataType: 'json',
                    delay   : 250,
                    data    : function (params) {
                        return {
                            keyword: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    }
                }
            });

        } else {
            $('#id_pasien_relasi').prop('disabled', true)
                .addClass('bg-danger-subtle')
                .val(null)
                .trigger('change');
        }
    });

    // Ketika RM Ibu Dipilih
    $(document).on('change', '#id_pasien_relasi', function () {

        let id_pasien = $(this).val();

        // Kosongkan jika tidak ada pilihan
        if (!id_pasien) {
            return;
        }

        $.ajax({
            url      : '_Page/Pasien/GetDetailPasien.php',
            type     : 'POST',
            dataType : 'json',
            data     : {
                id_pasien: id_pasien
            },

            success: function (response) {

                if (response.status == 'success') {

                    let data = response.metadata;

                    // =====================================================
                    // AUTO ISI NAMA PASIEN ANAK
                    // =====================================================
                    // Contoh:
                    // UYU YULIANTI -> BAYI NY. UYU YULIANTI

                    $('#nama').val(''+data.nama+' (BY)');

                    // =====================================================
                    // AUTO ISI ALAMAT
                    // =====================================================
                    $('#province').val(data.province).trigger('change');

                    // Tunggu regency load
                    setTimeout(function () {

                        $('#regency').val(data.regency).trigger('change');

                        setTimeout(function () {

                            $('#subdistrict').val(data.subdistrict).trigger('change');

                            setTimeout(function () {

                                $('#village').val(data.village).trigger('change');

                            }, 500);

                        }, 500);

                    }, 500);

                    $('#street').val(data.street);
                    $('#postal_code').val(data.postal_code);
                    $('#kontak').val(data.kontak);

                } else {

                    Swal.fire({
                        icon : 'warning',
                        title: 'Oops!',
                        text : response.message
                    });

                }
            },

            error: function () {

                Swal.fire({
                    icon : 'error',
                    title: 'Server Error',
                    text : 'Terjadi kesalahan pada server.'
                });

            }
        });
    });

    // Load Select Option Provinsi Pertama Kali
    loadProvince();

    // Province -> Regency
    $('#province').on('change', function () {
        let province = $(this).val();

        $('#regency').html('<option>Loading...</option>');

        $.ajax({
            url: '_Page/Pasien/GetRegency.php',
            type: 'POST',
            data: { province: province },
            success: function (res) {
                $('#regency').html(res);
                $('#subdistrict').html('<option value="">Pilih</option>');
                $('#village').html('<option value="">Pilih</option>');
            }
        });
    });

    // Regency -> Subdistrict
    $('#regency').on('change', function () {
        let regency = $(this).val();

        $('#subdistrict').html('<option>Loading...</option>');

        $.ajax({
            url: '_Page/Pasien/GetSubdistrict.php',
            type: 'POST',
            data: { regency: regency },
            success: function (res) {
                $('#subdistrict').html(res);
                $('#village').html('<option value="">Pilih</option>');
            }
        });
    });

    // Subdistrict -> Village
    $('#subdistrict').on('change', function () {
        let subdistrict = $(this).val();

        $('#village').html('<option>Loading...</option>');

        $.ajax({
            url: '_Page/Pasien/GetVillage.php',
            type: 'POST',
            data: { subdistrict: subdistrict },
            success: function (res) {
                $('#village').html(res);
            }
        });
    });

    // Check Pernyataan
    $('#pernyataan_petugas_pasien_baru').on('change', function () {
        if ($(this).is(':checked')) {
            $('#ButtonTambahPasienBaru').prop('disabled', false);
        } else {
            $('#ButtonTambahPasienBaru').prop('disabled', true);
        }
    });

    // Submit Tambah Pasien
    $(document).on('submit', '#ProsesTambahPasien', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonTambahPasienBaru');
        let modal      = $('#ModalTambahPasien');
        let notifikasi = $('#NotifikasiTambah');

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
            url        : '_Page/Pasien/ProsesTambahPasien.php',
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

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Pasien Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Reset Filter
                    let filterForm = $('#ProsesFilter');
                    
                    // Page Pencarian Pasien
                    $('#page_pasien').val('1');
                    $('#keyword_pasien').val('');
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelPasien();

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

    //=========================================================
    // DETAIL PASIEN
    //=========================================================
    $(document).on('click', '.modal_detail_pasien', function () {
        
        // Tangkap id_pasien
        var id_pasien = $(this).data('id');

        // Show Modal
        $('#ModalDetailPasien').modal('show');

        // Loading Form
        $('#FormDetailPasien').html('Loading...');

        $.ajax({
            url: '_Page/Pasien/FormDetail.php',
            type: 'POST',
            data: { id_pasien: id_pasien },
            success: function (res) {
                $('#FormDetailPasien').html(res);
            }
        });
    });

    //=========================================================
    // DETAIL POLIKLINIK
    //=========================================================
    $(document).on('click', '.modal_detail_poliklinik', function () {
        
        // Tangkap id_poliklinik
        var id_poliklinik = $(this).data('id');

        // Show Modal
        $('#ModalDetailPoliklinik').modal('show');

        // Loading Form
        $('#FormDetailPoliklinik').html('Loading...');

        $.ajax({
            url: '_Page/ReferensiPoliklinik/FormDetailPoliklinik.php',
            type: 'POST',
            data: { id_poliklinik: id_poliklinik },
            success: function (res) {
                $('#FormDetailPoliklinik').html(res);
            }
        });
    });

    //=========================================================
    // DETAIL KELAS RAWAT
    //=========================================================
    $(document).on('click', '.modal_detail_kelas', function () {
        
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');

        // Show Modal
        $('#ModalDetailKelas').modal('show');

        // Loading Form
        $('#FormDetailKelas').html('Loading...');

        $.ajax({
            url: '_Page/Kunjungan/FormDetailKelas.php',
            type: 'POST',
            data: { id_kunjungan: id_kunjungan },
            success: function (res) {
                $('#FormDetailKelas').html(res);
            }
        });
    });

    //=========================================================
    // DETAIL DOKTER
    //=========================================================
    $(document).on('click', '.modal_detail_dokter', function () {
        
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');

        // Show Modal
        $('#ModalDetailDokter').modal('show');

        // Loading Form
        $('#FormDetailDokter').html('Loading...');

        $.ajax({
            url: '_Page/Kunjungan/FormDetailDokter.php',
            type: 'POST',
            data: { id_kunjungan: id_kunjungan },
            success: function (res) {
                $('#FormDetailDokter').html(res);
            }
        });
    });

    //=========================================================
    // DETAIL STATUS
    //=========================================================
    $(document).on('click', '.modal_detail_status', function () {
        
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');

        // Show Modal
        $('#ModalDetailStatus').modal('show');

        // Loading Form
        $('#FormDetailStatus').html('Loading...');

        $.ajax({
            url: '_Page/Kunjungan/FormDetailStatus.php',
            type: 'POST',
            data: { id_kunjungan: id_kunjungan },
            success: function (res) {
                $('#FormDetailStatus').html(res);
            }
        });
    });

    //=========================================================
    // EDIT KUNJUNGAN
    //=========================================================
    $(document).on('click', '.modal_edit', function () {
        
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');
        var from         = $(this).data('from');

        // Show Modal
        $('#ModalEdit').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEdit').html('');

        // Loading Form
        $('#FormEdit').html('Loading...');

        $.ajax({
            url: '_Page/Kunjungan/FormEdit.php',
            type: 'POST',
            data: { id_kunjungan: id_kunjungan, from: from },
            success: function (res) {
                $('#FormEdit').html(res);
            }
        });
    });

    // Mengubah Dokter Penerima
    $(document).on('change', '#id_dokter_edit', function () {

        // Ambil option yang dipilih
        let selected = $(this).find(':selected');

        // Ambil attribute
        let kode = selected.attr('kode');
        let nama = selected.attr('nama');

        // Set value ke input
        $('#kode_dokter_edit').val(kode || '');
        $('#dokter_edit').val(nama || '');

    });

    // Mengubah Dokter DPJP
    $(document).on('change', '#dpjp_id', function () {

        // Ambil option yang dipilih
        let selected = $(this).find(':selected');

        // Ambil attribute
        let kode = selected.attr('kode');
        let nama = selected.attr('nama');

        // Set value ke input
        $('#dpjp_kode_edit').val(kode || '');
        $('#dpjp_nama_edit').val(nama || '');

    });

    // Mengubah Poliklinik
    $(document).on('change', '#id_poliklinik_edit', function () {

        // Ambil option yang dipilih
        let selected = $(this).find(':selected');

        // Ambil attribute
        let kode = selected.attr('kode');
        let nama = selected.attr('nama');

        // Set value ke input
        $('#kode_poliklinik_edit').val(kode || '');
        $('#poliklinik_edit').val(nama || '');

    });

    // Mengubah kelas_edit
    $(document).on('change', '#kelas_edit', function () {

        var id_kelas_rawat = $('#kelas_edit').val();

        // Reset Form Tempat Tidur
        $('#tempat_tidur_edit').html('<option value="">Pilih</option>');

        // Tampilkan Form Ruangan Dengan Ajax
        $.ajax({
            url: '_Page/Kunjungan/SelectRuangan.php',
            type: 'POST',
            data: { id_kelas_rawat: id_kelas_rawat },
            success: function (res) {
                $('#ruang_rawat_edit').html(res);
            }
        });
    });

    // Mengubah ruang_rawat_edit
    $(document).on('change', '#ruang_rawat_edit', function () {

        var id_ruang_rawat = $('#ruang_rawat_edit').val();

        // Tampilkan Form Ruangan Dengan Ajax
        $.ajax({
            url: '_Page/Kunjungan/SelectTempatTidur.php',
            type: 'POST',
            data: { id_ruang_rawat: id_ruang_rawat },
            success: function (res) {
                $('#tempat_tidur_edit').html(res);
            }
        });
    });

    // Submit Edit Kunjungan
    $(document).on('submit', '#ProsesEditKunjungan', function (e) {
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
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/Kunjungan/ProsesEditKunjungan.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                var form = response.form;

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
                        title            : 'Edit Kunjungan Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Reload data berdasarkan form
                    if(form=='tabel'){
                        TabelKunjungan();
                    }else{
                        ShowDetail();
                    }
                    

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

    //=========================================================
    // UPDATE STATUS KUNJUNGAN
    //=========================================================
    $(document).on('click', '.modal_update_status', function () {
        
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');
        var from         = $(this).data('from');

        // Show Modal
        $('#ModalUpdateStatusKunjungan').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiUpdateStatusKunjungan').html('');

        // Loading Form
        $('#FormUpdateStatusKunjungan').html('Loading...');

        $.ajax({
            url: '_Page/Kunjungan/FormUpdateStatusKunjungan.php',
            type: 'POST',
            data: { id_kunjungan: id_kunjungan, from: from },
            success: function (res) {
                $('#FormUpdateStatusKunjungan').html(res);
            }
        });
    });

    // Submit Update Status Kunjungan
    $(document).on('submit', '#ProsesUpdateStatusKunjungan', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonUpdateStatusKunjungan');
        let modal      = $('#ModalUpdateStatusKunjungan');
        let notifikasi = $('#NotifikasiUpdateStatusKunjungan');

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
            url        : '_Page/Kunjungan/ProsesUpdateStatusKunjungan.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                var form = response.form;

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
                        title            : 'Update Status Kunjungan Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Reload data berdasarkan form
                    if(form=='tabel'){
                        TabelKunjungan();
                    }else{
                        ShowDetail();
                    }
                    

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

    //=========================================================
    // HAPUS KUNJUNGAN
    //=========================================================
    $(document).on('click', '.modal_hapus', function () {
        
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');
        var from         = $(this).data('from');

        // Show Modal
        $('#ModalHapus').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapus').html('');

        // Loading Form
        $('#FormHapus').html('Loading...');

        $.ajax({
            url: '_Page/Kunjungan/FormHapus.php',
            type: 'POST',
            data: { id_kunjungan: id_kunjungan, from: from },
            success: function (res) {
                $('#FormHapus').html(res);
            }
        });
    });

    // Submit ProsesHapus
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
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/Kunjungan/ProsesHapus.php',
            type       : 'POST',
            data       : formData,
            dataType   : 'json',
            processData: false,
            contentType: false,

            success: function (response) {

                // Kembalikan tombol seperti semula
                button.prop('disabled', false).html(buttonText);

                var form = response.form;

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
                        title            : 'Hapus Kunjungan Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Reload data berdasarkan form
                    if(form=='tabel'){
                        TabelKunjungan();
                    }else{
                        ShowDetail();
                    }
                    

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

    //=========================================================
    // CETAK LABEL
    //=========================================================
    $(document).on('click', '.modal_cetak_label', function () {
        
        // Tangkap id_kunjungan
        var id_kunjungan = $(this).data('id');

        // Show Modal
        $('#ModalCetaklabel').modal('show');


        // Loading Form
        $('#FormCetaklabel').html('Loading...');

        $.ajax({
            url: '_Page/Kunjungan/FormCetaklabel.php',
            type: 'POST',
            data: { id_kunjungan: id_kunjungan },
            success: function (res) {
                $('#FormCetaklabel').html(res);
            }
        });
    });

    //=========================================================
    // MODAL DOWNLOAD
    //=========================================================
    $(document).on('click', '.modal_download', function () {
        
        // Clear Notification 
        $('#NotifikasiDownloadKunjungan').html('');

        // Disabled Button
        $('#ButtonDownloadKunjungan').prop('disabled', true);

        // Show Modal
        $('#ModalDownloadKunjungan').modal('show');
        
        // Periksa Ijin Akses Dengan Ajax
        $.ajax({
            url     : '_Page/Kunjungan/CekIjinDownload.php',
            dataType: 'JSON',
            success: function (response) {
                let status = response.status;
                if(status==true){
                    $('#ButtonDownloadKunjungan').prop('disabled', false);
                    $('#NotifikasiDownloadKunjungan').html('<div class="alert alert-info"><small>Output data yang dihasilkan dalam bentuk Excel. Semakin besar data yang ada pada database akan membutuhkan waktu lebih lama.</small></div>');
                }else{
                    $('#ButtonDownloadKunjungan').prop('disabled', true);
                    $('#NotifikasiDownloadKunjungan').html('<div class="alert alert-danger"><small>Anda Tidak Memiliki Ijin Untuk Melakukan Download Data Kunjungan.</small></div>');
                }
            }
        });
    });

    //=========================================================
    // MODAL IMPORT / UPLOAD
    //=========================================================
    $(document).on('click', '.modal_import', function () {

        $('#file_excel').val('');

        $('#NotifikasiUploadKunjungan').html(`
            <tr>
                <td colspan="11" class="text-center">
                    <small class="text-muted">
                        Belum Ada Data Yang Diimport
                    </small>
                </td>
            </tr>
        `);

        $('#ImportProgressWrapper').hide();

        $('#ButtonUploadKunjungan').prop('disabled', true);

        $('#ModalUploadKunjungan').modal('show');

        // Cek Ijin
        $.ajax({
            url: '_Page/Kunjungan/CekIjinDownload.php',
            dataType: 'JSON',
            success: function (response) {

                if(response.status === true){
                    $('#ButtonUploadKunjungan').prop('disabled', false);
                }else{
                    $('#ButtonUploadKunjungan').prop('disabled', true);
                }

            }
        });

    });


    // Submit Import
    $('#ProsesUploadKunjungan').off('submit').on('submit', function(e){

        e.preventDefault();

        let file = $('#file_excel')[0].files[0];

        if(!file){

            $('#NotifikasiUploadKunjungan').html(`
                <tr>
                    <td colspan="11" class="text-center text-danger">
                        Pilih file excel terlebih dahulu
                    </td>
                </tr>
            `);

            return;
        }

        let formData = new FormData();

        formData.append('file_excel', file);

        $('#ButtonUploadKunjungan').prop('disabled', true);

        $('#ImportProgressWrapper').show();

        $.ajax({

            url: '_Page/Kunjungan/ProsesImportKunjungan.php',
            type: 'POST',
            data: formData,

            processData: false,
            contentType: false,

            xhr: function(){

                let xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function(evt){

                    if(evt.lengthComputable){

                        let percent = Math.round((evt.loaded / evt.total) * 100);

                        $('#ImportProgressBar')
                            .css('width', percent + '%');

                        $('#ImportProgressText')
                            .html(percent + '%');

                    }

                }, false);

                return xhr;

            },

            beforeSend: function(){

                $('#NotifikasiUploadKunjungan').html(`
                    <tr>
                        <td colspan="11" class="text-center">
                            <div class="spinner-border spinner-border-sm text-primary"></div>
                            Memproses import data...
                        </td>
                    </tr>
                `);

            },

            success: function(response){

                $('#NotifikasiUploadKunjungan').html(response);
                // Reset Form Filter
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
                TabelKunjungan();
            },

            error: function(){

                $('#NotifikasiUploadKunjungan').html(`
                    <tr>
                        <td colspan="11" class="text-center text-danger">
                            Terjadi kesalahan saat import data
                        </td>
                    </tr>
                `);

            },

            complete: function(){

                $('#ButtonUploadKunjungan').prop('disabled', false);

                $('#ImportProgressBar')
                    .removeClass('progress-bar-animated');

            }

        });

    });
    
});
