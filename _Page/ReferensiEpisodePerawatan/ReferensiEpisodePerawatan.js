// ====================================================================
// FUNCTION BLOCK
// ====================================================================

// Tabel Utama
function TabelEpisodePerawatan() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_episode_perawatan');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/ReferensiEpisodePerawatan/TabelReferensiEpisodePerawatan.php',
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
// ====================================================================
$(document).ready(function () {

    // Load Tabel Pada Saat Pertama Kali
    TabelEpisodePerawatan();

    //Pagging
    $(document).on('click', '#next_page', function () {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelEpisodePerawatan(0);
    });
    $(document).on('click', '#previous_page', function () {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelEpisodePerawatan(0);
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
            url: '_Page/ReferensiEpisodePerawatan/FormFilter.php',
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
        TabelEpisodePerawatan();
    });

    // ===================================
    // TAMBAH REFERENSI EPISODE PERAWATAN
    // ===================================

    // Fokus otomatis
    $('#ModalTambah').on('shown.bs.modal', function () {
        $('#episode_category').focus();
    });

    $('#episode_category').select2({
        dropdownParent: $('#ModalTambah'), // Agar dropdown berfungsi dengan baik di dalam Bootstrap Modal
        theme: 'bootstrap-5', // Sesuaikan dengan tema Bootstrap yang Anda gunakan (atau hapus jika tidak pakai tema khusus)
        placeholder: 'Pilih / Ketik Kategori',
        allowClear: true,
        tags: true, // FITUR UTAMA: Mengizinkan user mengetik input baru yang belum ada di pilihan
        ajax: {
            url: '_Page/ReferensiEpisodePerawatan/GetCategory.php',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term // Parameter pencarian yang dikirim ke server
                };
            },
            processResults: function (data) {
                return {
                    results: data // Format data dari server harus berupa array objek [{id: '...', text: '...'}, ...]
                };
            },
            cache: true
        }
    });


    // Handdle Submit Referensi Tindakan
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
            url: '_Page/ReferensiEpisodePerawatan/ProsesTambah.php',
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
                        title: 'Tambah Referensi Referensi Episode Perawatan Berhasil',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });

                    // Reset Filter Kembali Ke halaman 1 (Belulum)
                    $('#ProsesFilter')[0].reset();
                    $('#page_filter').val(1);

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

    // ===================================
    // DETAIL REFERENSI EPISODE PERAWATAN
    // ===================================
    $(document).on('click', '.modal_detail', function () {

        // Tangkap ID dan Kategori
        var id_episode_perawatan_kode = $(this).data('id');
        var kategori = $(this).data('kategori');

        // Munculkan Modal
        $('#ModalDetail').modal('show');

        // Loading Form
        $('#FormDetail').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiEpisodePerawatan/FormDetail.php',
            data: { id_episode_perawatan_kode: id_episode_perawatan_kode },
            success: function (data) {
                $('#FormDetail').html(data);
            }
        });
    });

    // ===================================
    // EDIT REFERENSI EPISODE PERAWATAN
    // ===================================

    // Menampilkan Form Modal Edit
    $(document).on('click', '.modal_edit', function () {

        // Tangkap ID
        var id_episode_perawatan_kode = $(this).data('id');

        // Munculkan Modal
        $('#ModalEdit').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiEdit').html('');

        // Loading Form
        $('#FormEdit').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiEpisodePerawatan/FormEdit.php',
            data: { id_episode_perawatan_kode: id_episode_perawatan_kode },
            success: function (data) {
                $('#FormEdit').html(data);

                // INISIALISASI SELECT2 SETELAH FORM DIMUAT
                $('#episode_category_edit').select2({
                    dropdownParent: $('#ModalEdit'),
                    theme: 'bootstrap-5',
                    placeholder: 'Pilih / Ketik Kategori',
                    allowClear: true,
                    tags: true, // Memungkinkan user mengetik kategori baru
                    ajax: {
                        url: '_Page/ReferensiEpisodePerawatan/GetCategory.php',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });
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
            url: '_Page/ReferensiEpisodePerawatan/ProsesEdit.php',
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
                        title: 'Edit Referensi Referensi Episode Perawatan Berhasil',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
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

    // ===================================
    // HAPUS REFERENSI EPISODE PERAWATAN
    // ====================================
    // Menampilkan Form Konfirmasi Hapus
    $(document).on('click', '.modal_hapus', function () {

        // Tangkap ID dan Kategori
        var id_episode_perawatan_kode = $(this).data('id');

        // Munculkan Modal
        $('#ModalHapus').modal('show');

        // Kosongkan Notifikasi
        $('#NotifikasiHapus').html('');

        // Loading Form
        $('#FormHapus').html('Loading...');

        // Tampilkan Dengan AJAX
        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiEpisodePerawatan/FormHapus.php',
            data: { id_episode_perawatan_kode: id_episode_perawatan_kode },
            success: function (data) {
                $('#FormHapus').html(data);
            }
        });
    });

    // Handdle Submit Hapus Referensi Tindakan
    $(document).on('submit', '#ProsesHapus', function (e) {
        e.preventDefault();

        let form = $(this);
        let button = $('#ButtonHapus');
        let modal = $('#ModalHapus');
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
            url: '_Page/ReferensiEpisodePerawatan/ProsesHapus.php',
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
                        title: 'Hapus Referensi Referensi Episode Perawatan Berhasil',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
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

    // ===================================
    // IMPORT REFERENSI EPISODE PERAWATAN
    // ====================================
    $(document).on('submit', '#ProsesUpload', function (e) {
        e.preventDefault(); // Mencegah form melakukan submit standar (page reload)

        // Buat objek FormData untuk menampung data form termasuk file
        var formData = new FormData(this);

        // Nonaktifkan tombol upload dan tampilkan indikator loading
        $('#ButtonImport').prop('disabled', true).html('<i class="spinner-border spinner-border-sm"></i> Sedang Mengunggah...');
        
        // Kosongkan dan tampilkan pesan loading pada area notifikasi
        $('#NotifikasiImport').html('<div class="alert alert-info"><small>Sedang memproses file, mohon tunggu...</small></div>');

        $.ajax({
            type: 'POST',
            url: '_Page/ReferensiEpisodePerawatan/ProsesImport.php',
            data: formData,
            dataType: 'json', // Berharap response dari backend berupa JSON
            contentType: false, // Wajib untuk upload file via AJAX
            processData: false, // Wajib agar jQuery tidak memproses data form menjadi string query
            success: function (response) {
                // Kembalikan tombol ke kondisi semula
                $('#ButtonImport').prop('disabled', false).html('<i class="bi bi-upload"></i> Upload / Import');

                if (response.status === 'success') {
                    // Tampilkan pesan sukses
                    $('#NotifikasiImport').html('<div class="alert alert-success"><small>' + response.message + '</small></div>');
                    
                    // Reset form input file
                    $('#ProsesUpload')[0].reset();

                    // Refresh tabel data setelah beberapa detik (jika fungsi TabelEpisodePerawatan tersedia)
                    if (typeof TabelEpisodePerawatan === 'function') {
                        setTimeout(function() {
                            TabelEpisodePerawatan();
                        }, 1500);
                    }
                } else {
                    // Tampilkan pesan error dari backend
                    $('#NotifikasiImport').html('<div class="alert alert-danger"><small>' + response.message + '</small></div>');
                }
            },
            error: function (xhr, status, error) {
                // Kembalikan tombol ke kondisi semula
                $('#ButtonImport').prop('disabled', false).html('<i class="bi bi-upload"></i> Upload / Import');

                // Tangkap error sistem / server
                $('#NotifikasiImport').html('<div class="alert alert-danger"><small>Terjadi kesalahan pada server: ' + error + '</small></div>');
            }
        });
    });
});
