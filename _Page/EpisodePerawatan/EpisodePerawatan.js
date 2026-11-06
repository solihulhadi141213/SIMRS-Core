// ==========================================
// BLOCK FUNCTION
// Semua function ditulis pada block ini
// ==========================================
    
// Menampilkan Data episode perawatan
function TabelEpisodePerawatan() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_episode_perawatan');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/EpisodePerawatan/TabelEpisodePerawatan.php',
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

// Inisialisasi Select2 "ID/Nama Pasien" (data dimuat via AJAX)
// Inisialisasi Select2 "ID/Nama Pasien" (data dimuat via AJAX)
function InisialisasiSelectPasien() {
    let $pasien = $('#id_pasien');

    // Cegah inisialisasi ganda jika modal dibuka berulang kali
    if ($pasien.hasClass('select2-hidden-accessible')) {
        return;
    }

    $pasien.select2({
        theme               : 'bootstrap-5',
        dropdownParent      : $('#FormIdPasien'),
        width               : '100%',
        placeholder         : 'Pilih',
        allowClear          : false,
        tags                : false,
        minimumInputLength  : 0,
        ajax: {
            method  : 'POST',
            url     : '_Page/EpisodePerawatan/GetPasien.php',
            dataType: 'json',
            delay   : 250,
            cache   : true,
            data: function (params) {
                return {
                    keyword: params.term || '',
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results || [],
                    pagination: {
                        more: !!(data.pagination && data.pagination.more)
                    }
                };
            }
        },
        // Kustomisasi Tampilan Item dalam Dropdown
        templateResult: function (pasien) {
            if (pasien.loading) {
                return pasien.text;
            }
            if (!pasien.id) {
                return pasien.text;
            }

            // Susun HTML sesuai permintaan: Nama tebal, di bawahnya RM/ID & info tambahan kecil
            let $container = $(`
                <div>
                    <strong>${pasien.nama}</strong><br>
                    <small class="text-muted">No. RM: ${pasien.id_pasien} | NIK: ${pasien.nik} | BPJS: ${pasien.no_bpjs}</small>
                </div>
            `);
            return $container;
        },
        // Kustomisasi Tampilan saat Pasien sudah Dipilih di Kotak Input
        templateSelection: function (pasien) {
            if (!pasien.id) {
                return pasien.text;
            }
            // Tampilan ringkas saat terpilih
            return `${pasien.nama} (No. RM: ${pasien.id_pasien})`;
        },
        escapeMarkup: function (markup) {
            return markup; // Izinkan rendering HTML di template
        },
        language: {
            searching: function () { return 'Mencari...'; },
            noResults: function () { return 'Pasien tidak ditemukan'; },
            loadingMore: function () { return 'Memuat data berikutnya...'; },
            errorLoading: function () { return 'Data gagal dimuat'; }
        }
    });
}

// Inisialisasi Select2 "Nama Episode Perawatan" (data dimuat via AJAX)
function InisialisasiSelectEpisodeKode() {
    let $episodeKode = $('#id_episode_perawatan_kode');

    // Cegah inisialisasi ganda jika modal dibuka berulang kali
    if ($episodeKode.hasClass('select2-hidden-accessible')) {
        return;
    }

    $episodeKode.select2({
        theme               : 'bootstrap-5',       // Tema Bootstrap 5
        dropdownParent      : $('#FormKodeEpisodePerawatan'), // Parent container
        width               : '100%',
        placeholder         : 'Pilih',
        allowClear          : false,               // Wajib diisi
        tags                : false,               // Dilarang input manual
        minimumInputLength  : 0,
        ajax: {
            method  : 'POST',
            url     : '_Page/EpisodePerawatan/GetEpisodeKode.php',
            dataType: 'json',
            delay   : 250,
            cache   : true,
            data: function (params) {
                return {
                    keyword: params.term || '',
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results || [],
                    pagination: {
                        more: !!(data.pagination && data.pagination.more)
                    }
                };
            }
        },
        // Custom Style: Nama tebal di atas, kecil di bawah
        templateResult: function (item) {
            if (item.loading) {
                return item.text;
            }
            if (!item.id) {
                return item.text;
            }

            let $container = $(`
                <div>
                    <strong>${item.episode_name}</strong><br>
                    <small class="text-muted">Display: ${item.episode_display} | Kode: ${item.episode_code} | Kategori: ${item.episode_category}</small>
                </div>
            `);
            return $container;
        },
        templateSelection: function (item) {
            if (!item.id) {
                return item.text;
            }
            return `${item.episode_name} (${item.episode_code})`;
        },
        escapeMarkup: function (markup) {
            return markup; // Membenarkan rendering tag HTML di dalam pilihan
        },
        language: {
            searching: function () { return 'Mencari...'; },
            noResults: function () { return 'Episode perawatan tidak ditemukan'; },
            loadingMore: function () { return 'Memuat data berikutnya...'; },
            errorLoading: function () { return 'Data gagal dimuat'; }
        }
    });
}

// Inisialisasi Select2 "Diagnosis Pasien"
function InisialisasiSelectDiagnosis() {
    let $diagnosis = $('#id_diagnosis');

    if ($diagnosis.hasClass('select2-hidden-accessible')) {
        return;
    }

    $diagnosis.select2({
        theme               : 'bootstrap-5',
        dropdownParent      : $('#FormDiagnosis'),
        width               : '100%',
        placeholder         : 'Pilih Pasien Terlebih Dahulu',
        allowClear          : false,
        tags                : false,
        minimumInputLength  : 0,
        ajax: {
            method  : 'POST',
            url     : '_Page/EpisodePerawatan/GetDiagnosis.php',
            dataType: 'json',
            delay   : 250,
            cache   : false, // Set false agar mengambil data baru sesuai pasien yang dipilih
            data: function (params) {
                return {
                    keyword   : params.term || '',
                    page      : params.page || 1,
                    id_pasien : $('#id_pasien').val() // Kirim ID Pasien yang sedang dipilih
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results || [],
                    pagination: {
                        more: !!(data.pagination && data.pagination.more)
                    }
                };
            }
        },
        templateResult: function (item) {
            if (item.loading) return item.text;
            if (!item.id) return item.text;

            let $container = $(`
                <div>
                    <strong>[${item.icd_kode}] ${item.icd_deskripsi}</strong><br>
                    <small class="text-muted">Jenis: ${item.jenis_diagnosis} | Kasus: ${item.status_kasus} | Dokter: ${item.dokter_nama}</small>
                </div>
            `);
            return $container;
        },
        templateSelection: function (item) {
            if (!item.id) return item.text;
            return `[${item.icd_kode}] ${item.icd_deskripsi}`;
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        language: {
            searching   : function () { return 'Mencari...'; },
            noResults   : function () { 
                let pasienVal = $('#id_pasien').val();
                if (!pasienVal) {
                    return 'Silakan pilih pasien terlebih dahulu';
                }
                return 'Diagnosis tidak ditemukan untuk pasien ini'; 
            },
            loadingMore : function () { return 'Memuat data berikutnya...'; },
            errorLoading: function () { return 'Data gagal dimuat'; }
        }
    });
}

// Inisialisasi Select2 "Dokter DPJP" (data dimuat via AJAX)
function InisialisasiSelectDokter() {
    let $dokter = $('#id_dokter');

    // Cegah inisialisasi ganda jika modal dibuka berulang kali
    if ($dokter.hasClass('select2-hidden-accessible')) {
        return;
    }

    $dokter.select2({
        theme               : 'bootstrap-5',       // Tema Bootstrap 5
        dropdownParent      : $('#FormDokterDPJP'),// Parent container modal
        width               : '100%',
        placeholder         : 'Pilih Dokter DPJP',
        allowClear          : false,               // Wajib diisi
        tags                : false,               // Dilarang input manual
        minimumInputLength  : 0,
        ajax: {
            method  : 'POST',
            url     : '_Page/EpisodePerawatan/GetDokter.php',
            dataType: 'json',
            delay   : 250,
            cache   : true,
            data: function (params) {
                return {
                    keyword: params.term || '',
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results || [],
                    pagination: {
                        more: !!(data.pagination && data.pagination.more)
                    }
                };
            }
        },
        // Custom Style: Nama Dokter tebal di atas, Kategori/Spesialisasi & Kode kecil di bawah
        templateResult: function (item) {
            if (item.loading) {
                return item.text;
            }
            if (!item.id) {
                return item.text;
            }

            let $container = $(`
                <div>
                    <strong>${item.nama}</strong><br>
                    <small class="text-muted">Spesialisasi: ${item.kategori} | Kode: ${item.kode}</small>
                </div>
            `);
            return $container;
        },
        templateSelection: function (item) {
            if (!item.id) {
                return item.text;
            }
            return `${item.nama} (${item.kategori})`;
        },
        escapeMarkup: function (markup) {
            return markup; // Mengizinkan rendering tag HTML di dalam pilihan
        },
        language: {
            searching   : function () { return 'Mencari...'; },
            noResults   : function () { return 'Dokter tidak ditemukan'; },
            loadingMore : function () { return 'Memuat data berikutnya...'; },
            errorLoading: function () { return 'Data gagal dimuat'; }
        }
    });
}


// ==========================================
// BLOCK EVENT HANDLER
// Semua event handler ditulis pada block ini
// ==========================================
$(document).ready(function() {
    // ------------------------------
    // Menampilkan Data Pertama Kali
    // ------------------------------
    TabelEpisodePerawatan();

    // ------------------------------
    // Pagging
    // ------------------------------
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelEpisodePerawatan(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelEpisodePerawatan(0);
    });

    // ------------------------------
    // Filter
    // ------------------------------
    // Auto Focus Keyword
    $('#ModalFilter').on('shown.bs.modal', function () {
        $('#keyword_form').focus();
    });

    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/EpisodePerawatan/FormFilter.php',
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
        TabelEpisodePerawatan();
    });

    // ------------------------------
    // TAMBAH
    // ------------------------------
    
    // Saat modal Tambah tampil: aktifkan Select2 lalu buka dropdown (autofocus)
    $('#ModalTambah').on('shown.bs.modal', function () {
        InisialisasiSelectPasien();
        InisialisasiSelectEpisodeKode();
        InisialisasiSelectDiagnosis();
        InisialisasiSelectDokter();
        $('#id_pasien').select2('open');
    });

    // Penanganan Select2 'id_pasien'
    // Select2 v4.1: fokus manual ke kolom pencarian saat dropdown terbuka
    $(document).on('select2:open', '#id_pasien', function () {
        let search = document.querySelector('.select2-container--open .select2-search__field');
        if (search) {
            search.focus();
        }
    });

    // Saat modal ditutup: kosongkan pilihan pasien
    $('#ModalTambah').on('hidden.bs.modal', function () {
        $('#id_pasien').val(null).trigger('change');
        $('#id_episode_perawatan_kode').val(null).trigger('change');
        $('#id_diagnosis').val(null).trigger('change');
        $('#id_dokter').val(null).trigger('change');
    });

    // Event handler ketika pilihan pasien berubah, reset diagnosis
    $(document).on('change', '#id_pasien', function() {
        $('#id_diagnosis').val(null).trigger('change');
    });
    
    // Handdle Submit Tambah
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
            url        : '_Page/EpisodePerawatan/ProsesTambah.php',
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
                    $('#ProsesTambah')[0].reset();

                    // Reset Filter Kembali Ke halaman 1 (Belulum)
                    $('#ProsesFilter')[0].reset();
                    $('#page_filter').val(1);

                    // Kosongkan notifikasi
                    notifikasi.html('');

                    // Tutup modal
                    modal.modal('hide');

                    // Toast sukses
                    Swal.fire({
                        toast            : true,
                        position         : 'top-end',
                        icon             : 'success',
                        title            : 'Tambah Data Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelEpisodePerawatan();

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

    // ------------------------------
    // DETAIL
    // ------------------------------
     $(document).on('click', '.modal_detail', function () {

        // Tangkap ID
        var id_episode_perawatan = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetail').modal('show');

        // Loading Form
        $('#FormDetail').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/EpisodePerawatan/FormDetail.php',
            data: { id_episode_perawatan: id_episode_perawatan },
            success: function (data) {
                $('#FormDetail').html(data);
            }
        });
    });

    // ------------------------------
    // DETAIL PASIEN
    // ------------------------------
     $(document).on('click', '.modal_detail_pasien', function () {

        // Tangkap ID
        var id_pasien = $(this).data('id');

        // Munculkan Modal
        $('#ModalDetailPasien').modal('show');

        // Loading Form
        $('#FormDetailPasien').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/Pasien/FormDetail.php',
            data: { id_pasien: id_pasien },
            success: function (data) {
                $('#FormDetailPasien').html(data);
            }
        });
    });

    // ------------------------------
    // EDIT 
    // ------------------------------
    $(document).on('click', '.modal_edit', function () {
        var id_episode_perawatan = $(this).data('id');

        // Tampilkan Modal Edit
        $('#ModalEdit').modal('show');

        // Kosongkan / set loading pada container form edit
        $('#FormEdit').html(`
            <div class="text-center text-muted py-4">
                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                Memuat form edit...
            </div>
        `);

        // Bersihkan notifikasi sebelumnya jika ada
        $('#NotifikasiEdit').html('');

        // Ambil data form via AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/EpisodePerawatan/FormEdit.php',
            data: { id_episode_perawatan: id_episode_perawatan },
            success: function (response) {
                $('#FormEdit').html(response);

                // Aktifkan kembali fungsi Select2 yang ada di dalam form edit
                if (typeof InisialisasiSelectPasienEdit === 'function') {
                    InisialisasiSelectPasienEdit();
                }
                if (typeof InisialisasiSelectEpisodeKodeEdit === 'function') {
                    InisialisasiSelectEpisodeKodeEdit();
                }
                if (typeof InisialisasiSelectDiagnosisEdit === 'function') {
                    InisialisasiSelectDiagnosisEdit();
                }
                if (typeof InisialisasiSelectDokterEdit === 'function') {
                    InisialisasiSelectDokterEdit();
                }
            },
            error: function () {
                $('#FormEdit').html(`
                    <div class="alert alert-danger text-center">
                        <small>Gagal memuat form edit ke server.</small>
                    </div>
                `);
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
            url        : '_Page/EpisodePerawatan/ProsesEdit.php',
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
                        title            : 'Edit Data Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelEpisodePerawatan();

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

    // ------------------------------
    // HAPUS 
    // ------------------------------
    // Menampilkan Modal Hapus
    $(document).on('click', '.modal_hapus', function () {
        
        // Tangkap id_episode_perawatan
        var id_episode_perawatan = $(this).data('id');

        // Show Modal
        $('#ModalHapus').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapus').html('');

        // Loading Form
        $('#FormHapus').html('Loading...');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/EpisodePerawatan/FormHapus.php',
            data        : {id_episode_perawatan : id_episode_perawatan},
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
            url        : '_Page/EpisodePerawatan/ProsesHapus.php',
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
                        title            : 'Hapus Data Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelEpisodePerawatan();

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

    // ------------------------------
    // KIRIM 
    // ------------------------------
    // Menampilkan Modal Kirim
    $(document).on('click', '.modal_kirim', function () {

        // Tangkap 'id_episode_perawatan' dari tombol
        var id_episode_perawatan = $(this).data('id');

        $('#ModalKirim').modal('show');
        $('#NotifikasiKirim').html('');
        $('#ButtonKirim').prop('disabled', true);
        $('#FormKirim').html('Loading...');

        $.ajax({
            type    : 'POST',
            url     : '_Page/EpisodePerawatan/FormKirim.php',
            data    : {id_episode_perawatan: id_episode_perawatan},
            dataType: 'JSON',

            success: function (response) {

                $('#FormKirim').html(response.html);

                if (response.status === 'ready') {
                    $('#ButtonKirim').prop('disabled', false);
                } else {
                    $('#ButtonKirim').prop('disabled', true);
                }

                if (response.status === 'error') {
                    $('#NotifikasiKirim').html(`
                        <div class="alert alert-danger">
                            <small>${response.message}</small>
                        </div>
                    `);
                }
            },

            error: function () {

                $('#FormKirim').html('');

                $('#NotifikasiKirim').html(`
                    <div class="alert alert-danger">
                        <small>Gagal mengambil detail Episode Of Care dari server.</small>
                    </div>
                `);

                $('#ButtonKirim').prop('disabled', true);
            }
        });
    });


    // Handdle Submit Kirim
    $(document).on('submit', '#ProsesKirim', function (e) {
        e.preventDefault();

        let form       = $(this);
        let button     = $('#ButtonKirim');
        let modal      = $('#ModalKirim');
        let notifikasi = $('#NotifikasiKirim');

        // Simpan isi tombol awal
        let buttonText = button.html();

        // Ambil data form
        let formData = new FormData(this);

        // Kosongkan notifikasi
        notifikasi.html('');

        // Loading tombol
        button.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-1"></span> Loading...`);

        $.ajax({
            url        : '_Page/EpisodePerawatan/ProsesKirim.php',
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
                        title            : 'Kirim Data Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });
                    
                    // Tampilkan Ulang (Refresh Tabel)
                    TabelEpisodePerawatan();

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

    // ------------------------------
    // DETAIL  SATUSEHAT 
    // ------------------------------
    // Menampilkan Modal Detail satusehat
    $(document).on('click', '.modal_detail_episode_of_care', function () {
        
        // Tangkap IdEpisodeOfCare
        var IdEpisodeOfCare = $(this).data('id');

        // Show Modal
        $('#ModalDetailEpisodeOfCare').modal('show');

        // Loading Form
        $('#FormDetailEpisodeOfCare').html('Loading...');

        // Tampilkan Detail Kunjungan Dengan Ajax
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/EpisodePerawatan/FormDetailEpisodeOfCare.php',
            data        : {IdEpisodeOfCare : IdEpisodeOfCare},
            success     : function(data){
                $('#FormDetailEpisodeOfCare').html(data);
            }
        });
    });

    // --------------------------------------------------
    // EXPORT
    // --------------------------------------------------
    $(document).on('input change', '#periode_awal, #periode_akhir', function () {
        let periodeAwal  = $('#periode_awal').val().trim();
        let periodeAkhir = $('#periode_akhir').val().trim();

        // Cek apakah kedua input tanggal sudah terisi
        if (periodeAwal !== '' && periodeAkhir !== '') {
            $('#ButtonExport').prop('disabled', false);
        } else {
            $('#ButtonExport').prop('disabled', true);
        }
    });

});