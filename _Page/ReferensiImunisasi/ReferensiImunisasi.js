// =========================================================================================
/** BLOCK FUNCTION */
// Agar Rapih maka semua function disimpan pada block ini
// =========================================================================================

/** Menampilkan Data Berdasarkan Filter */
function TabelReferensiImunisasi() {

    // Menangkap Data Dari Form Filter
    var ProsesFilter = $('#ProsesFilter').serialize();

    // Tujuan Ajax
    let target = $('#tabel_referensi_imunisasi');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/ReferensiImunisasi/TabelReferensiImunisasi.php',
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



// =========================================================================================
// BLOCK EVENT HANDLER
// Semua event dan handler disimpan pada block ini
// =========================================================================================
$(document).ready(function () {
    // Tampilkan data antrean pertama kali.
    TabelReferensiImunisasi();

    //Pagging
    $(document).on('click', '#next_page', function () {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelReferensiImunisasi(0);
    });
    $(document).on('click', '#previous_page', function () {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelReferensiImunisasi(0);
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
            url: '_Page/ReferensiImunisasi/FormFilter.php',
            data: { keyword_by: keyword_by },
            success: function (data) {
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Pencarian/Filter
    $('#ProsesFilter').submit(function () {
        $('#page_filter').val("1");
        TabelReferensiImunisasi();
        $('#ModalFilter').modal('hide');
    });

    //------------------------------------
    //  Tambah Referensi Imunisasi
    //------------------------------------

    

    // Submit 'ProsesTambah'
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
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiImunisasi/ProsesTambah.php',
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
                        title            : 'Tambah Referensi Imunisasi Berhasil',
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
                    TabelReferensiImunisasi();

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

    //------------------------------------
    //  DETAIL
    //------------------------------------
    $(document).on('click', '.modal_detail', function () {

        // Ambil ID id_imunisasi_referensi
        let id_imunisasi_referensi = $(this).data('id');

        // Validasi
        if (!id_imunisasi_referensi) {
            console.error('ID Referensi tidak ditemukan');
            return;
        }

        // Loading View
        $('#FormDetail')
            .html(`
                <div class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary mb-2"></div>
                    <div>
                        <small class="text-muted">Memuat detail pasien...</small>
                    </div>
                </div>
            `)
            .css({
                opacity: 0,
                filter: 'blur(6px)'
            });

        // Tampilkan Modal
        $('#ModalDetail').modal('show');

        // Smooth Loading Animation
        $('#FormDetail').animate({
            opacity: 1
        }, 200);

        // AJAX
        $.ajax({
            url    : '_Page/ReferensiImunisasi/FormDetail.php',
            type   : 'POST',
            data   : {id_imunisasi_referensi: id_imunisasi_referensi},
            timeout: 10000,
            success: function (response) {

                // Fade Out Sebelum Replace
                $('#FormDetail').animate({
                    opacity: 0
                }, 120, function () {

                    // Replace Content
                    $(this)
                        .html(response)
                        .css({
                            filter: 'blur(6px)',
                            opacity: 0
                        });

                    // Fade In + Blur Clear
                    $({
                        blur: 6
                    }).animate({
                        blur: 0
                    }, {
                        duration: 250,

                        step: function () {
                            $('#FormDetail').css('filter', `blur(${this.blur}px)`);
                        }
                    });

                    $('#FormDetail').animate({
                        opacity: 1
                    }, 250);
                });
            },

            error: function (xhr, status, error) {

                console.error(error);

                $('#FormDetail').html(`
                    <div class="alert alert-danger mb-0">
                        <small>
                            Gagal memuat detail!<br>
                            Status : ${status}
                        </small>
                    </div>
                `).css({
                    opacity: 1,
                    filter: 'blur(0)'
                });
            }
        });
    });

    //------------------------------------
    //  EDIT
    //------------------------------------
    $(document).on('click', '.modal_edit', function () {

        // Ambil ID id_imunisasi_referensi
        let id_imunisasi_referensi = $(this).data('id');

        // Validasi
        if (!id_imunisasi_referensi) {
            console.error('ID Referensi tidak ditemukan');
            return;
        }

        // Loading View
        $('#FormEdit')
            .html(`
                <div class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary mb-2"></div>
                    <div>
                        <small class="text-muted">Memuat detail pasien...</small>
                    </div>
                </div>
            `)
            .css({
                opacity: 0,
                filter: 'blur(6px)'
            });

        // Tampilkan Modal
        $('#ModalEdit').modal('show');

        // Smooth Loading Animation
        $('#FormEdit').animate({
            opacity: 1
        }, 200);

        // AJAX
        $.ajax({
            url    : '_Page/ReferensiImunisasi/FormEdit.php',
            type   : 'POST',
            data   : {id_imunisasi_referensi: id_imunisasi_referensi},
            timeout: 10000,
            success: function (response) {

                // Fade Out Sebelum Replace
                $('#FormEdit').animate({
                    opacity: 0
                }, 120, function () {

                    // Replace Content
                    $(this)
                        .html(response)
                        .css({
                            filter: 'blur(6px)',
                            opacity: 0
                        });

                    // Fade In + Blur Clear
                    $({
                        blur: 6
                    }).animate({
                        blur: 0
                    }, {
                        duration: 250,

                        step: function () {
                            $('#FormEdit').css('filter', `blur(${this.blur}px)`);
                        }
                    });

                    $('#FormEdit').animate({
                        opacity: 1
                    }, 250);
                });
            },

            error: function (xhr, status, error) {

                console.error(error);

                $('#FormEdit').html(`
                    <div class="alert alert-danger mb-0">
                        <small>
                            Gagal memuat data!<br>
                            Status : ${status}
                        </small>
                    </div>
                `).css({
                    opacity: 1,
                    filter: 'blur(0)'
                });
            }
        });
    });

    // Submit Proses Edit
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
        button.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span> Loading...
        `);

        $.ajax({
            url        : '_Page/ReferensiImunisasi/ProsesEdit.php',
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
                        title            : 'Ubah Referensi Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelReferensiImunisasi();

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
    
    //------------------------------------
    //  HAPUS
    //------------------------------------
    $(document).on('click', '.modal_hapus', function () {

        // Ambil ID id_imunisasi_referensi
        let id_imunisasi_referensi = $(this).data('id');

        // Validasi
        if (!id_imunisasi_referensi) {
            console.error('ID Referensi tidak ditemukan');
            return;
        }

        // Loading View
        $('#FormHapus')
            .html(`
                <div class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary mb-2"></div>
                    <div>
                        <small class="text-muted">Memuat detail pasien...</small>
                    </div>
                </div>
            `)
            .css({
                opacity: 0,
                filter: 'blur(6px)'
            });

        // Tampilkan Modal
        $('#ModalHapus').modal('show');

        // Smooth Loading Animation
        $('#FormHapus').animate({
            opacity: 1
        }, 200);

        // AJAX
        $.ajax({
            url    : '_Page/ReferensiImunisasi/FormHapus.php',
            type   : 'POST',
            data   : {id_imunisasi_referensi: id_imunisasi_referensi},
            timeout: 10000,
            success: function (response) {

                // Fade Out Sebelum Replace
                $('#FormHapus').animate({
                    opacity: 0
                }, 120, function () {

                    // Replace Content
                    $(this)
                        .html(response)
                        .css({
                            filter: 'blur(6px)',
                            opacity: 0
                        });

                    // Fade In + Blur Clear
                    $({
                        blur: 6
                    }).animate({
                        blur: 0
                    }, {
                        duration: 250,

                        step: function () {
                            $('#FormHapus').css('filter', `blur(${this.blur}px)`);
                        }
                    });

                    $('#FormHapus').animate({
                        opacity: 1
                    }, 250);
                });
            },

            error: function (xhr, status, error) {

                console.error(error);

                $('#FormHapus').html(`
                    <div class="alert alert-danger mb-0">
                        <small>
                            Gagal memuat data!<br>
                            Status : ${status}
                        </small>
                    </div>
                `).css({
                    opacity: 1,
                    filter: 'blur(0)'
                });
            }
        });
    });

    // Submit Proses Hapus
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
            url        : '_Page/ReferensiImunisasi/ProsesHapus.php',
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
                        title            : 'Hapus Referensi Berhasil',
                        showConfirmButton: false,
                        timer            : 1000,
                        timerProgressBar : true
                    });

                    // Tampilkan Ulang (Refresh Tabel)
                    TabelReferensiImunisasi();

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

    //------------------------------------
    //  EXPORT
    //------------------------------------
    $(document).on('click', '.modal_export', function () {
        $('#ModalExport').modal('show');
    });

    const modalExportReferensi = $('#modalExportReferensi');

    function currentYearReferensi() {
        return new Date().getFullYear();
    }

    function buildExportLanjutan(periode) {
        const year = currentYearReferensi();
        if (periode === 'Semua') {
            $('#FormLanjutanExport').empty();
            return;
        }
        if (periode === 'Tahun') {
            $('#FormLanjutanExport').html(
                '<div class="row mb-3">' +
                    '<div class="col-12">' +
                        '<label><small>Tahun</small></label>' +
                        '<input type="number" name="tahun" id="tahun_export" class="form-control" value="' + year + '" min="2000" max="2100">' +
                    '</div>' +
                '</div>'
            );
            return;
        }
        if (periode === 'Bulan') {
            let options = '';
            for (let m = 1; m <= 12; m++) {
                const val = String(m).padStart(2, '0');
                const names = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                options += '<option value="' + val + '">' + names[m - 1] + '</option>';
            }
            $('#FormLanjutanExport').html(
                '<div class="row mb-3">' +
                    '<div class="col-12">' +
                        '<label><small>Tahun</small></label>' +
                        '<input type="number" name="tahun" id="tahun_export" class="form-control" value="' + year + '" min="2000" max="2100">' +
                    '</div>' +
                '</div>' +
                '<div class="row mb-3">' +
                    '<div class="col-12">' +
                        '<label><small>Bulan</small></label>' +
                        '<select name="bulan" id="bulan_export" class="form-control">' + options + '</select>' +
                    '</div>' +
                '</div>'
            );
            return;
        }
        if (periode === 'Periodik') {
            $('#FormLanjutanExport').html(
                '<div class="row mb-3">' +
                    '<div class="col-6">' +
                        '<label><small>Periode Awal</small></label>' +
                        '<input type="date" name="periode_awal" id="periode_awal_export" class="form-control">' +
                    '</div>' +
                    '<div class="col-6">' +
                        '<label><small>Periode Akhir</small></label>' +
                        '<input type="date" name="periode_akhir" id="periode_akhir_export" class="form-control">' +
                    '</div>' +
                '</div>'
            );
            return;
        }
        $('#FormLanjutanExport').empty();
    }

    // Menghitung Jumlah Data Berdasarkan Filter Periode
    function countExportReferensi() {
        const periode = $('#periode_data').val() || 'Semua';
        const data = { mode: 'count', periode_data: periode };
        $('#FormLanjutanExport').find('input, select').each(function () {
            if (this.name) {
                data[this.name] = $(this).val();
            }
        });
        $.ajax({
            type    : 'POST',
            url     : '_Page/ReferensiImunisasi/FormExport.php',
            data    : data,
            dataType: 'JSON'
        }).done(function (response) {
            const jumlah = response && typeof response.jumlah !== 'undefined' ? parseInt(response.jumlah, 10) : 0;
            if (jumlah > 0) {
                $('#NotifikasiJumlahDataExport').html('<div class="alert alert-info mb-0"><small>Jumlah data referensi yang akan diexport: <b>' + jumlah + '</b></small></div>');
                $('#ButtonExport').prop('disabled', false);
            } else {
                $('#NotifikasiJumlahDataExport').html('<div class="alert alert-warning mb-0"><small>Tidak ada data referensi pada periode tersebut.</small></div>');
                $('#ButtonExport').prop('disabled', true);
            }
        }).fail(function () {
            $('#NotifikasiJumlahDataExport').html('<div class="alert alert-danger mb-0"><small>Gagal menghitung jumlah data referensi.</small></div>');
            $('#ButtonExport').prop('disabled', true);
        });
    }

    // Saat modal export muncul pertama kali
    modalExportReferensi.on('shown.bs.modal', function () {
        $('#periode_data').val('Semua');
        buildExportLanjutan('Semua');
        countExportReferensi();
    });

    // Saat periode_data diubah
    $(document).on('change', '#periode_data', function () {
        const periode = $(this).val();
        buildExportLanjutan(periode);
        countExportReferensi();
    });

    // Hitung ulang saat input lanjutan berubah
    $(document).on('change', '#FormLanjutanExport input, #FormLanjutanExport select', function () {
        countExportReferensi();
    });

    //------------------------------------
    //  IMPORT
    //------------------------------------
    $(document).on('click', '.modal_import', function () {
        $('#ModalImport').modal('show');
    });

    // Submit Import Referensi Imunisasi
    $(document).on('submit', '#ProsesImport', function (e) {
        e.preventDefault();

        let button      = $('#ButtonImport');
        let notifikasi  = $('#NotifikasiImport');
        let fileInput   = $('#import_file');

        if (!fileInput.val()) {
            notifikasi.html('<div class="alert alert-warning mb-0"><small>Pilih file Excel terlebih dahulu.</small></div>');
            return;
        }

        let formData   = new FormData(this);
        let buttonHtml = button.html();

        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Processing...');

        notifikasi.html(
            '<div class="progress mb-2" style="height:20px;">' +
                '<div class="progress-bar progress-bar-striped progress-bar-animated" id="ProgressImportReferensi" role="progressbar" style="width:0%;">0%</div>' +
            '</div>' +
            '<div class="text-muted small">Mengupload file...</div>'
        );

        $.ajax({
            url: '_Page/ReferensiImunisasi/ProsesImport.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function (e) {
                    if (e.lengthComputable) {
                        let percent = Math.round((e.loaded / e.total) * 100);
                        $('#ProgressImportReferensi')
                            .css('width', percent + '%')
                            .html(percent + '%');
                    }
                }, false);
                return xhr;
            },
            beforeSend: function () {
                $('#ProgressImportReferensi')
                    .removeClass('bg-danger')
                    .addClass('progress-bar-animated');
            },
            success: function (response) {
                button.prop('disabled', false).html(buttonHtml);

                let data = response;
                if (typeof response === 'string') {
                    try {
                        data = JSON.parse(response);
                    } catch (err) {
                        data = null;
                    }
                }

                if (data && typeof data === 'object' && data.status === 'success') {
                    let html = '<div class="alert alert-success mb-0"><small>' + (data.message || 'Import berhasil.') + '</small></div>';
                    if (Array.isArray(data.detail)) {
                        html += '<div class="table-responsive mt-2"><table class="table table-bordered table-sm"><thead class="table-dark"><tr><th>No</th><th>Nama Vaksin</th><th>Status</th><th>Keterangan</th></tr></thead><tbody>';
                        $.each(data.detail, function (i, item) {
                            let badge = '';
                            if (item.status === 'INSERT') {
                                badge = '<span class="badge bg-success">INSERT</span>';
                            } else if (item.status === 'UPDATE') {
                                badge = '<span class="badge bg-primary">UPDATE</span>';
                            } else {
                                badge = '<span class="badge bg-danger">GAGAL</span>';
                            }
                            html += '<tr>' +
                                '<td>' + (item.no || (i + 1)) + '</td>' +
                                '<td>' + (item.nama_vaksin || item.nama || '-') + '</td>' +
                                '<td>' + badge + '</td>' +
                                '<td>' + (item.keterangan || '-') + '</td>' +
                            '</tr>';
                        });
                        html += '</tbody></table></div>';
                    }
                    notifikasi.html(html);
                    if (typeof TabelReferensiImunisasi === 'function') {
                        TabelReferensiImunisasi();
                    }
                } else if (typeof response === 'string' && response.trim() !== '') {
                    notifikasi.html(response);
                    if (typeof TabelReferensiImunisasi === 'function') {
                        TabelReferensiImunisasi();
                    }
                } else {
                    let msg = (data && data.message) ? data.message : 'Import gagal.';
                    notifikasi.html('<div class="alert alert-danger mb-0"><small>' + msg + '</small></div>');
                }
            },
            error: function (xhr) {
                button.prop('disabled', false).html(buttonHtml);
                let msg = 'Terjadi kesalahan saat import data.';
                if (xhr && xhr.responseText) {
                    try {
                        let res = JSON.parse(xhr.responseText);
                        if (res && res.message) {
                            msg = res.message;
                        }
                    } catch (err) {
                        if (xhr.responseText.trim() !== '') {
                            msg = xhr.responseText;
                        }
                    }
                }
                notifikasi.html('<div class="alert alert-danger mb-0"><small>' + msg + '</small></div>');
            }
        });
    });

});
