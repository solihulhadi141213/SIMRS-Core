// =========================================================================================
/** BLOCK FUNCTION */
// =========================================================================================

/** Menampilkan Data Berdasarkan Filter */
function TabelAntrian() {

    // Menangkap Data Dari Form Filter
    var ProsesFilter = $('#ProsesFilter').serialize();

    // Tujuan Ajax
    let target = $('#tabel_antrian');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Antrian/TabelAntrian.php',
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
const modalTambahAntrian = $('#ModalTambah');
const selectPasien = $('#id_pasien');
const parentSelectPasien = $('#select_id_pasien');

function Select2Pasien() {
    if (!selectPasien.length || typeof $.fn.select2 !== 'function') {
        return;
    }
    if (selectPasien.hasClass('select2-hidden-accessible')) {
        return;
    }

    function templatePasien(item) {
        if (item.loading || !item.id) {
            return item.text || '';
        }

        const row = $('<div>', { class: 'antrian-select2-pasien' });
        $('<div>', { class: 'antrian-select2-pasien-id' }).text(item.id_pasien || item.id).appendTo(row);
        $('<div>', { class: 'antrian-select2-pasien-nama' }).text(item.nama || '').appendTo(row);
        return row;
    }

    selectPasien.select2({
        theme: 'bootstrap-5',
        dropdownParent: parentSelectPasien.length ? parentSelectPasien : modalTambahAntrian,
        placeholder: 'Cari Pasien',
        allowClear: true,
        width: '100%',
        templateResult: templatePasien,
        templateSelection: templatePasien,
        ajax: {
            url: '_Page/Antrian/ListPasien.php',
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
                    results: Array.isArray(response.results) ? response.results : [],
                    pagination: {
                        more: Boolean(response.pagination && response.pagination.more)
                    }
                };
            },
            cache: true
        }
    });
}

// ID request mencegah respons lama mengisi pilihan setelah parent berubah cepat.
const antrianSelectRequestId = { poliklinik: 0, dokter: 0, jadwal: 0 };
const antrianSelectRequest = { poliklinik: null, dokter: null, jadwal: null };

function ResetSelectAntrian(select, placeholder, disabled = true) {
    select.empty().append(new Option(placeholder, '')).val('').prop('disabled', disabled);
}

function BatalkanRequestSelectAntrian(jenis) {
    antrianSelectRequestId[jenis] += 1;
    if (antrianSelectRequest[jenis]) {
        antrianSelectRequest[jenis].abort();
        antrianSelectRequest[jenis] = null;
    }
}

/** Mengisi semua halaman endpoint ke native select agar tidak ada opsi yang terpotong. */
function MuatSemuaOptionAntrian(jenis, select, url, data, placeholder, emptyText) {
    BatalkanRequestSelectAntrian(jenis);
    const requestId = antrianSelectRequestId[jenis];
    ResetSelectAntrian(select, 'Memuat...', true);

    function muatHalaman(page) {
        antrianSelectRequest[jenis] = $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: Object.assign({}, data, { page: page })
        }).done(function (response) {
            if (requestId !== antrianSelectRequestId[jenis]) {
                return;
            }

            const results = Array.isArray(response.results) ? response.results : [];
            results.forEach(function (item) {
                select.append(new Option(item.text || '', item.id || ''));
            });

            if (response.pagination && response.pagination.more) {
                muatHalaman(page + 1);
                return;
            }

            if (select.find('option').length > 1) {
                select.find('option').first().text(placeholder);
                select.prop('disabled', false);
            } else {
                ResetSelectAntrian(select, emptyText, true);
            }
            antrianSelectRequest[jenis] = null;
        }).fail(function (xhr, status) {
            if (status === 'abort' || requestId !== antrianSelectRequestId[jenis]) {
                return;
            }
            ResetSelectAntrian(select, 'Gagal memuat pilihan', true);
            antrianSelectRequest[jenis] = null;
        });
    }

    muatHalaman(1);
}

/** Select Option Poliklinik */
function SelectOptionPoliklinik() {
    const selectPoliklinik = $('#id_poliklinik');
    if (!selectPoliklinik.length) {
        return;
    }

    MuatSemuaOptionAntrian(
        'poliklinik',
        selectPoliklinik,
        '_Page/Antrian/ListPoliklinik.php',
        { term: '' },
        'Pilih poliklinik',
        'Poliklinik tidak tersedia'
    );
}

/** Memuat dokter yang memiliki jadwal pada poliklinik terpilih. */
function SelectOptionDokter(poliklinikId) {
    const selectDokter = $('#id_dokter');
    if (!selectDokter.length) {
        return;
    }

    const idPoliklinik = poliklinikId === undefined ? $('#id_poliklinik').val() : poliklinikId;
    if (!idPoliklinik) {
        BatalkanRequestSelectAntrian('dokter');
        ResetSelectAntrian(selectDokter, 'Pilih poliklinik terlebih dahulu', true);
        return;
    }

    MuatSemuaOptionAntrian(
        'dokter',
        selectDokter,
        '_Page/Antrian/ListDokter.php',
        { id_poliklinik: idPoliklinik, term: '' },
        'Pilih dokter',
        'Dokter tidak tersedia pada poliklinik ini'
    );
}

/** Memuat jadwal setelah dokter dan tanggal kunjungan tersedia. */
function SelectOptionJadwal(dokterId, tanggalKunjungan) {
    const selectJadwal = $('#id_jadwal');
    if (!selectJadwal.length) {
        return;
    }

    const idDokter = dokterId === undefined ? $('#id_dokter').val() : dokterId;
    const tanggal = tanggalKunjungan === undefined ? $('#tanggal_kunjungan').val() : tanggalKunjungan;
    const idPoliklinik = $('#id_poliklinik').val();

    BatalkanRequestSelectAntrian('jadwal');
    if (!idPoliklinik) {
        ResetSelectAntrian(selectJadwal, 'Pilih poliklinik terlebih dahulu', true);
        return;
    }
    if (!idDokter) {
        ResetSelectAntrian(selectJadwal, 'Pilih dokter terlebih dahulu', true);
        return;
    }
    if (!tanggal) {
        ResetSelectAntrian(selectJadwal, 'Pilih tanggal kunjungan terlebih dahulu', true);
        return;
    }

    const requestId = antrianSelectRequestId.jadwal;
    ResetSelectAntrian(selectJadwal, 'Memuat jadwal...', true);
    antrianSelectRequest.jadwal = $.ajax({
        url: '_Page/Antrian/ListJadwal.php',
        type: 'GET',
        dataType: 'json',
        data: {
            id_poliklinik: idPoliklinik,
            id_dokter: idDokter,
            tanggal_kunjungan: tanggal
        }
    }).done(function (response) {
        if (requestId !== antrianSelectRequestId.jadwal) {
            return;
        }

        const jadwal = Array.isArray(response.results) ? response.results : [];
        if (jadwal.length === 0) {
            ResetSelectAntrian(selectJadwal, 'Jadwal tidak tersedia pada tanggal ini', true);
            antrianSelectRequest.jadwal = null;
            return;
        }

        ResetSelectAntrian(selectJadwal, 'Pilih jadwal praktik', false);
        jadwal.forEach(function (item) {
            selectJadwal.append(new Option(item.text || '', item.id || ''));
        });
        antrianSelectRequest.jadwal = null;
    }).fail(function (xhr, status) {
        if (status === 'abort' || requestId !== antrianSelectRequestId.jadwal) {
            return;
        }
        ResetSelectAntrian(selectJadwal, 'Gagal memuat jadwal', true);
        antrianSelectRequest.jadwal = null;
    });
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


// =========================================================================================
// BLOCK EVENT HANDLER
// =========================================================================================
$(document).ready(function () {
    // Tampilkan data antrean pertama kali.
    TabelAntrian();

    //Pagging
    $(document).on('click', '#next_page', function () {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelAntrian(0);
    });
    $(document).on('click', '#previous_page', function () {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelAntrian(0);
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
            url: '_Page/Antrian/FormFilter.php',
            data: { keyword_by: keyword_by },
            success: function (data) {
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Pencarian/Filter
    $('#ProsesFilter').submit(function () {
        $('#page_filter').val("1");
        TabelAntrian();
        $('#ModalFilter').modal('hide');
    });

    //------------------------------------
    //  Tambah Antrian
    //------------------------------------

    // inisiasi Select2 untuk pencarian pasien lama
    Select2Pasien();
    SelectOptionPoliklinik();
    SelectOptionDokter();
    SelectOptionJadwal();

    // Poli menentukan daftar dokter; perubahan atau pengosongan poli mereset dokter dan jadwal.
    $('#id_poliklinik').on('change', function () {
        const idPoliklinik = $(this).val();

        $('#id_dokter').val(null).trigger('change');
        $('#id_jadwal').val(null).trigger('change');
        SelectOptionDokter(idPoliklinik);
        SelectOptionJadwal('', '');
    });

    // Dokter menentukan daftar jadwal yang tersedia pada tanggal kunjungan.
    $('#id_dokter').on('change', function () {
        const idDokter = $(this).val();

        $('#id_jadwal').val(null).trigger('change');
        SelectOptionJadwal(idDokter, $('#tanggal_kunjungan').val());
    });

    // Jadwal harus dimuat ulang ketika tanggal kunjungan berubah.
    $('#tanggal_kunjungan').on('change', function () {
        $('#id_jadwal').val(null).trigger('change');
        SelectOptionJadwal($('#id_dokter').val(), $(this).val());
    });

    // Nomor referensi hanya dapat diisi setelah jenis referensi dipilih.
    const jenisReferensi = $('#FormAntrian').find('#jenis_referensi');
    const nomorReferensi = $('#FormAntrian').find('#nomor_referensi');
    function AturInputNomorReferensi() {
        const jenisDipilih = Boolean(jenisReferensi.val());
        nomorReferensi.prop('readonly', !jenisDipilih);

        if (!jenisDipilih) {
            nomorReferensi.val('');
        }
    }
    jenisReferensi.on('change', AturInputNomorReferensi);
    AturInputNomorReferensi();

    // Reset pasien lama sebelum select dinonaktifkan untuk mode pasien baru.
    $('#ModalTambah').on('change', 'input[name="jenis_request"]', function () {
        const pasienBaru = $(this).val() === '1';

        if (pasienBaru) {
            selectPasien.val(null).trigger('change');
            $('#antrian_id_pasien').val('');
            $('#nama_pasien').val('');
            $('#gender_antrian').val('').trigger('change');
            $('#nik_antrian').val('');
            $('#no_bpjs_antrian').val('');
            $('#kontak_antrian').val('');
        }

        selectPasien.prop('disabled', pasienBaru);
    });

    // Ketika pasien dipilih dari Select2, ambil data pasien dan isi form
    selectPasien.on('select2:select', function (e) {
        const selectedData = e.params.data;
        const idPasien = selectedData.id;

        if (!idPasien) {
            return;
        }

        // Simpan ID pasien dan isi identitas dari data hasil pencarian.
        $('#antrian_id_pasien').val(idPasien);
        $('#nama_pasien').val(selectedData.nama || '');
        $('#gender_antrian').val(selectedData.gender || '').trigger('change');
        $('#nik_antrian').val(selectedData.nik || '');
        $('#no_bpjs_antrian').val(selectedData.no_bpjs || '');
        $('#kontak_antrian').val(selectedData.kontak || '');
    });

    // Kirim data form tambah antrian ke backend.
    $('#FormAntrian').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const button = $('#ButtonTambahAntrian');
        const notification = $('#NotifikasiAntrian');
        const buttonHtml = button.html();
        const jenisRequest = $('input[name="jenis_request"]:checked').val();
        const modePasien = jenisRequest === '1' ? 'baru' : 'lama';

        // Kirim satu nilai id_pasien yang sesuai dengan mode pasien dan kontrak endpoint.
        const data = form.serializeArray().filter(function (field) {
            return field.name !== 'id_pasien' && field.name !== 'mode_pasien';
        });
        data.push({
            name: 'id_pasien',
            value: modePasien === 'lama'
                ? ($('#id_pasien').val() || '')
                : ''
        });
        data.push({ name: 'mode_pasien', value: modePasien });

        notification.empty();
        button.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...'
        );

        $.ajax({
            type: 'POST',
            url: '_Page/Antrian/ProsesTambahAntrian.php',
            data: data,
            dataType: 'json'
        }).done(function (response) {
            if (!response || response.status !== 'success') {
                const alert = $('<div>', { class: 'alert alert-danger mb-0' });
                $('<small>').text(response && response.message ? response.message : 'Data antrian gagal disimpan.').appendTo(alert);
                notification.empty().append(alert);
                return;
            }

            form[0].reset();
            selectPasien.val(null).trigger('change').prop('disabled', false);
            $('#antrian_id_pasien').val('');
            $('#id_poliklinik').val('').trigger('change');
            SelectOptionDokter('');
            SelectOptionJadwal('', '');
            notification.empty();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalTambah')).hide();
            TabelAntrian();

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message || 'Data antrian berhasil disimpan.'
                });
            } else {
                window.alert(response.message || 'Data antrian berhasil disimpan.');
            }
        }).fail(function (xhr) {
            const response = xhr.responseJSON;
            const message = response && response.message
                ? response.message
                : 'Data antrian gagal disimpan. Silakan coba kembali.';
            const alert = $('<div>', { class: 'alert alert-danger mb-0' });
            $('<small>').text(message).appendTo(alert);
            notification.empty().append(alert);
        }).always(function () {
            button.prop('disabled', false).html(buttonHtml);
        });
    });

    //------------------------------------
    //  DETAIL ANTRIAN
    //------------------------------------
    let detailAntrianRequest = null;
    let detailAntrianRequestId = 0;

    // Ambil ID dari tombol pemicu modal dan muat detail antrian ke FormDetail.
    $('#ModalDetail').on('show.bs.modal', function (event) {
        const trigger = $(event.relatedTarget);
        const idAntrian = trigger.data('id');
        const target = $('#FormDetail');

        detailAntrianRequestId += 1;
        const requestId = detailAntrianRequestId;
        if (detailAntrianRequest) {
            detailAntrianRequest.abort();
            detailAntrianRequest = null;
        }

        if (!idAntrian) {
            target.html('<div class="alert alert-warning mb-0">ID antrian tidak valid.</div>');
            return;
        }

        target.html(
            '<div class="text-center text-muted py-4">' +
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' +
            'Memuat detail antrian...</div>'
        );

        detailAntrianRequest = $.ajax({
            type: 'POST',
            url: '_Page/Antrian/FormDetailAntrian.php',
            data: { id_antrian: idAntrian },
            dataType: 'html'
        }).done(function (html) {
            if (requestId === detailAntrianRequestId) {
                target.html(html);
            }
        }).fail(function (xhr, status) {
            if (status === 'abort' || requestId !== detailAntrianRequestId) {
                return;
            }

            const message = xhr.status === 401
                ? 'Sesi berakhir. Silakan login kembali.'
                : 'Gagal memuat detail antrian. Silakan coba kembali.';
            target.empty().append($('<div>', { class: 'alert alert-danger mb-0' }).text(message));
        }).always(function () {
            if (requestId === detailAntrianRequestId) {
                detailAntrianRequest = null;
            }
        });
    });

    // Batalkan request bila modal ditutup sebelum respons diterima.
    $('#ModalDetail').on('hidden.bs.modal', function () {
        detailAntrianRequestId += 1;
        if (detailAntrianRequest) {
            detailAntrianRequest.abort();
            detailAntrianRequest = null;
        }
    });

    //------------------------------------
    //  EDIT ANTRIAN
    //------------------------------------
    let editAntrianRequest = null;
    let editAntrianRequestId = 0;

    // Ambil data-id dari tombol edit dan muat form ke dalam modal.
    $('#ModalEdit').on('show.bs.modal', function (event) {
        const trigger = $(event.relatedTarget);
        const idAntrian = trigger.data('id');
        const target = $('#FormEdit');

        $('#NotifikasiEdit').empty();

        editAntrianRequestId += 1;
        const requestId = editAntrianRequestId;
        if (editAntrianRequest) {
            editAntrianRequest.abort();
            editAntrianRequest = null;
        }

        if (!idAntrian) {
            target.html('<div class="alert alert-warning mb-0">ID antrian tidak valid.</div>');
            return;
        }

        target.html(
            '<div class="text-center text-muted py-4">' +
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' +
            'Memuat form edit antrian...</div>'
        );

        editAntrianRequest = $.ajax({
            type: 'POST',
            url: '_Page/Antrian/FormEdit.php',
            data: { id_antrian: idAntrian },
            dataType: 'html'
        }).done(function (html) {
            if (requestId === editAntrianRequestId) {
                target.html(html);
            }
        }).fail(function (xhr, status) {
            if (status === 'abort' || requestId !== editAntrianRequestId) {
                return;
            }

            const message = xhr.status === 401
                ? 'Sesi berakhir. Silakan login kembali.'
                : 'Gagal memuat form edit antrian. Silakan coba kembali.';
            target.empty().append($('<div>', { class: 'alert alert-danger mb-0' }).text(message));
        }).always(function () {
            if (requestId === editAntrianRequestId) {
                editAntrianRequest = null;
            }
        });
    });

    // Batalkan request jika modal ditutup sebelum form selesai dimuat.
    $('#ModalEdit').on('hidden.bs.modal', function () {
        editAntrianRequestId += 1;
        if (editAntrianRequest) {
            editAntrianRequest.abort();
            editAntrianRequest = null;
        }
        $('#NotifikasiEdit').empty();
    });

    // Submit Proses Edit Antrian
    $('#ProsesEdit').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const button = $('#SimpanEditAntrian');
        const notification = $('#NotifikasiEdit');
        const buttonHtml = button.html();
        const jenisRequest = $('#ModalEdit input[name="jenis_request"]:checked').val();
        const modePasien = jenisRequest === '1' ? 'baru' : 'lama';
        const idPasien = modePasien === 'lama'
            ? ($('#id_pasien_edit').val() || $('#antrian_id_pasien_edit').val() || '')
            : '';

        // Pastikan id_pasien dan mode_pasien terkirim secara konsisten
        const data = form.serializeArray().filter(function (field) {
            return field.name !== 'id_pasien' && field.name !== 'mode_pasien';
        });
        data.push({ name: 'id_pasien', value: idPasien });
        data.push({ name: 'mode_pasien', value: modePasien });

        notification.empty();
        button.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...'
        );

        $.ajax({
            type: 'POST',
            url: '_Page/Antrian/ProsesEdit.php',
            data: data,
            dataType: 'json'
        }).done(function (response) {
            if (!response || response.status !== 'success') {
                const alert = $('<div>', { class: 'alert alert-danger mb-0' });
                $('<small>').text(response && response.message ? response.message : 'Perubahan data antrian gagal disimpan.').appendTo(alert);
                notification.empty().append(alert);
                return;
            }

            notification.empty();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalEdit')).hide();
            TabelAntrian();

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message || 'Perubahan data antrian berhasil disimpan.'
                });
            } else {
                window.alert(response.message || 'Perubahan data antrian berhasil disimpan.');
            }
        }).fail(function (xhr) {
            const response = xhr.responseJSON;
            const message = response && response.message
                ? response.message
                : 'Perubahan data antrian gagal disimpan. Silakan coba kembali.';
            const alert = $('<div>', { class: 'alert alert-danger mb-0' });
            $('<small>').text(message).appendTo(alert);
            notification.empty().append(alert);
        }).always(function () {
            button.prop('disabled', false).html(buttonHtml);
        });
    });


    //------------------------------------
    //  HAPUS ANTRIAN
    //------------------------------------
    let hapusAntrianRequest = null;
    let hapusAntrianRequestId = 0;

    // Ambil data-id dari tombol pemicu modal dan muat form konfirmasi hapus
    $('#ModalHapus').on('show.bs.modal', function (event) {
        const trigger = $(event.relatedTarget);
        const idAntrian = trigger.data('id');
        const target = $('#FormHapus');
        const button = $('#ButtonHapusAntrian');

        $('#NotifikasiHapusAntrian').empty();
        button.prop('disabled', true);

        hapusAntrianRequestId += 1;
        const requestId = hapusAntrianRequestId;
        if (hapusAntrianRequest) {
            hapusAntrianRequest.abort();
            hapusAntrianRequest = null;
        }

        if (!idAntrian) {
            target.html('<div class="alert alert-warning mb-0">ID antrian tidak valid.</div>');
            return;
        }

        target.html(
            '<div class="text-center text-muted py-3">' +
            '<span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span>' +
            'Memuat detail antrian...</div>'
        );

        hapusAntrianRequest = $.ajax({
            type: 'POST',
            url: '_Page/Antrian/FormHapus.php',
            data: { id_antrian: idAntrian },
            dataType: 'html'
        }).done(function (html) {
            if (requestId === hapusAntrianRequestId) {
                target.html(html);
                button.prop('disabled', !$('#pernyataan_petugas_penghapus_antrian').is(':checked'));
            }
        }).fail(function (xhr, status) {
            if (status === 'abort' || requestId !== hapusAntrianRequestId) {
                return;
            }

            const message = xhr.status === 401
                ? 'Sesi berakhir. Silakan login kembali.'
                : 'Gagal memuat detail antrian. Silakan coba kembali.';
            target.empty().append($('<div>', { class: 'alert alert-danger mb-0' }).text(message));
        }).always(function () {
            if (requestId === hapusAntrianRequestId) {
                hapusAntrianRequest = null;
            }
        });
    });

    // Batalkan request jika modal ditutup sebelum data selesai dimuat
    $('#ModalHapus').on('hidden.bs.modal', function () {
        hapusAntrianRequestId += 1;
        if (hapusAntrianRequest) {
            hapusAntrianRequest.abort();
            hapusAntrianRequest = null;
        }
        $('#NotifikasiHapusAntrian').empty();
        $('#ButtonHapusAntrian').prop('disabled', true);
    });

    // Aktifkan atau nonaktifkan tombol hapus sesuai centang pernyataan petugas
    $(document).on('change', '#pernyataan_petugas_penghapus_antrian', function () {
        $('#ButtonHapusAntrian').prop('disabled', !$(this).is(':checked'));
    });
    // Submit Proses Hapus Antrian
    $('#ProsesHapus').on('submit', function (e) {
        e.preventDefault();
        const form = $(this);
        const button = $('#ButtonHapusAntrian');
        const notification = $('#NotifikasiHapusAntrian');
        const buttonHtml = button.html();

        notification.empty();
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menghapus...');

        $.ajax({
            type: 'POST',
            url: '_Page/Antrian/ProsesHapus.php',
            data: form.serialize(),
            dataType: 'json'
        }).done(function (response) {
            if (!response || response.status !== 'success') {
                const alert = $('<div>', { class: 'alert alert-danger mb-0' });
                $('<small>').text(response && response.message ? response.message : 'Gagal menghapus antrian.').appendTo(alert);
                notification.empty().append(alert);
                return;
            }
            notification.empty();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalHapus')).hide();
            TabelAntrian();
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message || 'Antrian berhasil dihapus.'
                });
            } else {
                window.alert(response.message || 'Antrian berhasil dihapus.');
            }
        }).fail(function (xhr) {
            const response = xhr.responseJSON;
            const message = response && response.message ? response.message : 'Gagal menghapus antrian. Silakan coba kembali.';
            const alert = $('<div>', { class: 'alert alert-danger mb-0' });
            $('<small>').text(message).appendTo(alert);
            notification.empty().append(alert);
        }).always(function () {
            button.prop('disabled', false).html(buttonHtml);
        });
    });

    //------------------------------------
    //  PENDAFTARAN PASIEN
    // Handle opening of patient registration modal and load form via AJAX
    let pendaftaranRequest = null;
    let pendaftaranRequestId = 0;
    $('#ModalPendaftaranPasien').on('show.bs.modal', function (event) {
        const trigger   = $(event.relatedTarget);
        const idAntrian = trigger.data('id') || 0;
        const target    = $('#FormPendaftaranPasien');
        
        // Reset any previous content
        target.empty();
        
        // Show loading indicator
        target.html('<div class="text-center text-muted py-3"><span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span> Memuat form pendaftaran...</div>');
       
        // Abort previous request if any
        pendaftaranRequestId++;
        const requestId = pendaftaranRequestId;
        if (pendaftaranRequest) {
            pendaftaranRequest.abort();
            pendaftaranRequest = null;
        }
        pendaftaranRequest = $.ajax({
            type: 'POST',
            url: '_Page/Antrian/FormPendaftaranPasien.php',
            data: { id_antrian: idAntrian },
            dataType: 'html'
        }).done(function (html) {
            if (requestId === pendaftaranRequestId) {
                target.html(html);
                // PANGGIL loadProvince DI SINI setelah form berhasil dimuat ke DOM!
                loadProvince();
            }
        }).fail(function (xhr, status) {
            if (status === 'abort' || requestId !== pendaftaranRequestId) {
                return;
            }
            const message = xhr.status === 401 ? 'Sesi berakhir. Silakan login kembali.' : 'Gagal memuat form pendaftaran. Silakan coba kembali.';
            target.empty().append($('<div>', { class: 'alert alert-danger mb-0' }).text(message));
        }).always(function () {
            if (requestId === pendaftaranRequestId) {
                pendaftaranRequest = null;
            }
        });
    });
    
    // Cancel request if modal closed before load completes
    $('#ModalPendaftaranPasien').on('hidden.bs.modal', function () {
        pendaftaranRequestId++;
        if (pendaftaranRequest) {
            pendaftaranRequest.abort();
            pendaftaranRequest = null;
        }
        $('#FormPendaftaranPasien').empty();
    });

    // 3. Gunakan Event Delegation untuk elemen-elemen dinamis (Province, Regency, Subdistrict, dll)
    // Ini aman digunakan meskipun elemennya baru dimuat melalui AJAX
    $(document).on('change', '#province', function () {
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

    $(document).on('change', '#regency', function () {
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

    $(document).on('change', '#subdistrict', function () {
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

    // Check Pernyataan (Sesuaikan ID tombol jika menggunakan #ButtonPendaftaranPasien sesuai HTML modal di atas)
    $(document).on('change', '#pernyataan_petugas', function () {
        if ($(this).is(':checked')) {
            $('#ButtonPendaftaranPasien').prop('disabled', false); // Di HTML modal pakai id ButtonPendaftaranPasien
        } else {
            $('#ButtonPendaftaranPasien').prop('disabled', true);
        }
    });

    // Submit Pendaftaran pasien
    $('#ProsesPendaftaranPasien').on('submit', function (e) {
        e.preventDefault();
        const form         = $(this);
        const button       = $('#ButtonPendaftaranPasien');
        const notification = $('#NotifikasiPendaftaranPasien');
        const buttonHtml   = button.html();

        notification.empty();
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menambahkan...');

        $.ajax({
            type    : 'POST',
            url     : '_Page/Antrian/ProsesPendaftaranPasien.php',
            data    : form.serialize(),
            dataType: 'json'
        }).done(function (response) {
            if (!response || response.status !== 'success') {
                const alert = $('<div>', { class: 'alert alert-danger mb-0' });
                $('<small>').text(response && response.message ? response.message : 'Gagal menambahkan pasien.').appendTo(alert);
                notification.empty().append(alert);
                return;
            }
            notification.empty();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalPendaftaranPasien')).hide();
            TabelAntrian();
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message || 'Pasien berhasil ditambahkan.'
                });
            } else {
                window.alert(response.message || 'Pasien berhasil ditambahkan.');
            }
        }).fail(function (xhr) {
            const response = xhr.responseJSON;
            const message = response && response.message ? response.message : 'Gagal menambahkan pasien. Silakan coba kembali.';
            const alert = $('<div>', { class: 'alert alert-danger mb-0' });
            $('<small>').text(message).appendTo(alert);
            notification.empty().append(alert);
        }).always(function () {
            button.prop('disabled', false).html(buttonHtml);
        });
    });
    
    // ----------------------------------
    // DETAIL PASIEN
    // ----------------------------------
    $(document).on('click', '.modal_detail_pasien', function () {

        // Ambil ID Pasien
        let id_pasien = $(this).data('id');

        // Validasi
        if (!id_pasien) {
            console.error('ID Pasien tidak ditemukan');
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
            url    : '_Page/Pasien/FormDetail.php',
            type   : 'POST',
            data   : {id_pasien: id_pasien},
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
                            Gagal memuat detail pasien!<br>
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
    //  PENDAFTARAN KUNJUNGAN
    //------------------------------------
    // Menampilkan Pendaftaran Kunjungan
    $(document).on('click', '.modal_pendaftaran_kunjungan', function () {

        // Ambil ID Antrian
        let id_antrian = $(this).data('id');

        // Validasi
        if (!id_antrian) {
            console.error('ID Antrian tidak ditemukan');
            return;
        }

        // Loading View
        $('#FormPendaftaranKunjungan')
            .html(`
                <div class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary mb-2"></div>
                    <div>
                        <small class="text-muted">Memuat Form Pendaftaran Kunjungan...</small>
                    </div>
                </div>
            `)
            .css({
                opacity: 0,
                filter: 'blur(6px)'
            });

        // Tampilkan Modal
        $('#ModalPendaftaranKunjungan').modal('show');

        // Smooth Loading Animation
        $('#FormPendaftaranKunjungan').animate({
            opacity: 1
        }, 200);

        // AJAX
        $.ajax({
            url    : '_Page/Antrian/FormPendaftaranKunjungan.php',
            type   : 'POST',
            data   : {id_antrian: id_antrian},
            timeout: 10000,
            success: function (response) {

                // Fade Out Sebelum Replace
                $('#FormPendaftaranKunjungan').animate({
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
                    $({blur: 6}).animate({blur: 0}, {
                        duration: 250,
                        step: function () {
                            $('#FormPendaftaranKunjungan').css('filter', `blur(${this.blur}px)`);
                        }
                    });

                    $('#FormPendaftaranKunjungan').animate({
                        opacity: 1
                    }, 250);
                });
            },

            // Apabila Terjadi Kesalahan
            error: function (xhr, status, error) {
                console.error(error);
                $('#FormPendaftaranKunjungan').html(`
                    <div class="alert alert-danger mb-0">
                        <small>
                            Gagal memuat form pendaftaran kunungan!<br>
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
    // EXPORT DATA ANTRIAN
    //------------------------------------
    const modalExportAntrian = $('#ModalExportAntrian');

    function currentYearAntrian() {
        return new Date().getFullYear();
    }

    function buildExportLanjutan(periode) {
        const year = currentYearAntrian();
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

    function countExportAntrian() {
        const periode = $('#periode_data').val() || 'Semua';
        const data = { mode: 'count', periode_data: periode };
        $('#FormLanjutanExport').find('input, select').each(function () {
            if (this.name) {
                data[this.name] = $(this).val();
            }
        });
        $.ajax({
            type: 'POST',
            url: '_Page/Antrian/ProsesExportAntrian.php',
            data: data,
            dataType: 'json'
        }).done(function (response) {
            const jumlah = response && typeof response.jumlah !== 'undefined' ? parseInt(response.jumlah, 10) : 0;
            if (jumlah > 0) {
                $('#NotifikasiJumlahDataAntrian').html('<div class="alert alert-info mb-0"><small>Jumlah data antrian yang akan diexport: <b>' + jumlah + '</b></small></div>');
                $('#ButtonExport').prop('disabled', false);
            } else {
                $('#NotifikasiJumlahDataAntrian').html('<div class="alert alert-warning mb-0"><small>Tidak ada data antrian pada periode tersebut.</small></div>');
                $('#ButtonExport').prop('disabled', true);
            }
        }).fail(function () {
            $('#NotifikasiJumlahDataAntrian').html('<div class="alert alert-danger mb-0"><small>Gagal menghitung jumlah data antrian.</small></div>');
            $('#ButtonExport').prop('disabled', true);
        });
    }

    // Saat modal export muncul pertama kali
    modalExportAntrian.on('shown.bs.modal', function () {
        $('#periode_data').val('Semua');
        buildExportLanjutan('Semua');
        countExportAntrian();
    });

    // Saat periode_data diubah
    $(document).on('change', '#periode_data', function () {
        const periode = $(this).val();
        buildExportLanjutan(periode);
        countExportAntrian();
    });

    // Hitung ulang saat input lanjutan berubah
    $(document).on('change', '#FormLanjutanExport input, #FormLanjutanExport select', function () {
        countExportAntrian();
    });

    // Submit Pendaftaran Kunjungan
    $('#ProsesPendaftaranKunjungan').on('submit', function (e) {
        e.preventDefault();

        const form         = $(this);
        const button       = $('#ButtonPendaftaranKunjungan');
        const notification = $('#NotifikasiPendaftaranKunjungan');
        const buttonHtml   = button.html();

        notification.empty();
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menyimpan...');

        $.ajax({
            type    : 'POST',
            url     : '_Page/Antrian/ProsesPendaftaranKunjungan.php',
            data    : form.serialize(),
            dataType: 'json'
        }).done(function (response) {
            if (!response || response.status !== 'success') {
                const alert = $('<div>', { class: 'alert alert-danger mb-0' });
                $('<small>').text(response && response.message ? response.message : 'Gagal menyimpan pendaftaran kunjungan.').appendTo(alert);
                if (response && response.debug) {
                    $('<pre>', { class: 'small text-danger mt-2 mb-0' }).text(response.debug).appendTo(alert);
                }
                notification.empty().append(alert);
                return;
            }

            notification.empty();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalPendaftaranKunjungan')).hide();
            TabelAntrian();

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon : 'success',
                    title: 'Berhasil',
                    text : response.message || 'Pendaftaran kunjungan berhasil disimpan.'
                });
            } else {
                window.alert(response.message || 'Pendaftaran kunjungan berhasil disimpan.');
            }
        }).fail(function (xhr) {
            const response = xhr.responseJSON;
            const message  = response && response.message ? response.message : 'Gagal menyimpan pendaftaran kunjungan. Silakan coba kembali.';
            const alert    = $('<div>', { class: 'alert alert-danger mb-0' });
            $('<small>').text(message).appendTo(alert);
            if (response && response.debug) {
                $('<pre>', { class: 'small text-danger mt-2 mb-0' }).text(response.debug).appendTo(alert);
            } else if (xhr.responseText) {
                $('<pre>', { class: 'small text-danger mt-2 mb-0' }).text(xhr.responseText).appendTo(alert);
            }
            notification.empty().append(alert);
        }).always(function () {
            button.prop('disabled', false).html(buttonHtml);
        });
    });

    // ----------------------------------
    // DETAIL KUNJUNGAN
    // ----------------------------------
    $(document).on('click', '.modal_detail_kunjungan', function () {

        // Ambil ID id_kunjungan
        let id_kunjungan = $(this).data('id');

        // Validasi
        if (!id_kunjungan) {
            console.error('ID Kunjungan tidak ditemukan');
            return;
        }

        // Loading View
        $('#FormDetailKunjungan')
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
        $('#ModalDetailKunjungan').modal('show');

        // Smooth Loading Animation
        $('#FormDetailKunjungan').animate({
            opacity: 1
        }, 200);

        // AJAX
        $.ajax({
            url    : '_Page/Kunjungan/FormDetailKunjungan.php',
            type   : 'POST',
            data   : {id_kunjungan: id_kunjungan},
            timeout: 10000,
            success: function (response) {

                // Fade Out Sebelum Replace
                $('#FormDetailKunjungan').animate({
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
                            $('#FormDetailKunjungan').css('filter', `blur(${this.blur}px)`);
                        }
                    });

                    $('#FormDetailKunjungan').animate({
                        opacity: 1
                    }, 250);
                });
            },

            error: function (xhr, status, error) {

                console.error(error);

                $('#FormDetailKunjungan').html(`
                    <div class="alert alert-danger mb-0">
                        <small>
                            Gagal memuat detail kunjungan!<br>
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

    // ----------------------------------
    // EXPORT DATA ANTRIAN
    // ----------------------------------
});
