/**
 * Memuat baris tabel antrean berdasarkan filter aktif dan menyelaraskan kontrol paginasi.
 */
function loadTabelAntrian() {
    const target = $('#tabel_antrian');
    target.addClass('blur-loading');
    // Minta tabel sesuai filter aktif; metadata halaman ikut dikirim pada baris pertama.
    $.ajax({
        type: 'POST',
        url: '_Page/Antrian/TabelAntrian.php',
        data: $('#ProsesFilter').serialize(),
        dataType: 'html'
    }).done(function (html) {
        const rows = $('<table>').html(html).find('tr');
        const firstRow = rows.first();
        const pageCount = parseInt(firstRow.attr('data-page-count'), 10) || 0;
        const currentPage = parseInt(firstRow.attr('data-current-page'), 10) || 0;
        target.html(rows);
        $('#page_info').text(currentPage + ' / ' + pageCount);
        $('#page_filter').val(currentPage || 1);
        $('#previous_page').prop('disabled', currentPage <= 1);
        $('#next_page').prop('disabled', currentPage === 0 || currentPage >= pageCount);
        formatAntrianDates(target);
    // Tampilkan kondisi gagal dan nonaktifkan paginasi jika server tidak merespons.
    }).fail(function () {
        target.html('<tr><td colspan="13" class="text-center text-danger">Gagal memuat data antrian. Silakan coba kembali.</td></tr>');
        $('#page_info').text('0 / 0');
        $('#previous_page, #next_page').prop('disabled', true);
    // Hentikan indikator pemuatan baik request berhasil maupun gagal.
    }).always(function () {
        target.removeClass('blur-loading');
    });
}

/**
 * Mengubah elemen tanggal di dalam kontainer ke format waktu lokal browser.
 * @param {jQuery} container Elemen yang berisi timestamp UTC atau tanggal lokal.
 */
function formatAntrianDates(container) {
    container.find('.js-date-time[data-utc]').each(function () {
        const value = $(this).attr('data-utc');
        const date = new Date(value);
        const formattedDate = Number.isNaN(date.getTime())
            ? '-'
            : $(this).hasClass('js-date-only')
                ? new Intl.DateTimeFormat('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' }).format(date)
                : date.toLocaleString();
        $(this).text(formattedDate);
    });
    container.find('.js-local-date[data-date]').each(function () {
        const parts = ($(this).attr('data-date') || '').split('-').map(Number);
        const date = parts.length === 3 ? new Date(parts[0], parts[1] - 1, parts[2]) : new Date(NaN);
        $(this).text(Number.isNaN(date.getTime()) ? '-' : date.toLocaleDateString());
    });
}

/** Menampilkan toast singkat dengan pola Bootstrap yang digunakan fitur referensi. */
function showAntrianToast(message, icon = 'success') {
    const isWarning = icon === 'warning';
    const colorClass = icon === 'success' ? 'bg-success' : isWarning ? 'bg-warning' : 'bg-danger';
    const textClass = isWarning ? 'text-dark' : 'text-white';
    const closeClass = isWarning ? '' : 'btn-close-white';
    const toast = $('<div>', {
        class: 'toast align-items-center ' + textClass + ' ' + colorClass + ' border-0 position-fixed top-0 end-0 m-3',
        role: 'alert',
        'aria-live': 'assertive',
        'aria-atomic': 'true'
    }).css('z-index', 9999);
    const content = $('<div>', { class: 'd-flex' });

    $('<div>', { class: 'toast-body' })
        .text(message || 'Proses antrean selesai.')
        .appendTo(content);
    $('<button>', {
        type: 'button',
        class: 'btn-close ' + closeClass + ' me-2 m-auto',
        'data-bs-dismiss': 'toast',
        'aria-label': 'Tutup'
    }).appendTo(content);
    toast.append(content).appendTo('body');

    toast.on('hidden.bs.toast', function () {
        $(this).remove();
    });
    bootstrap.Toast.getOrCreateInstance(toast[0], { delay: 2000 }).show();
}

/** Menampilkan pesan server secara aman di area notifikasi modal. */
function showAntrianNotification(target, message, variant = 'danger') {
    const alert = $('<div>', { class: 'alert alert-' + variant + ' mb-0' });
    $('<small>').text(message || 'Terjadi kesalahan saat memproses data antrean.').appendTo(alert);
    $(target).empty().append(alert);
}

/**
 * Memuat jadwal aktif sesuai poliklinik dan tanggal pada form yang dipilih.
 * @param {jQuery|string} form Form antrean yang memuat pilihan poliklinik, tanggal, dan jadwal.
 * @param {string|number} [selectedId] ID jadwal yang perlu tetap terpilih.
 */
function loadJadwalAntrian(form, selectedId) {
    const formElement = $(form || '#FormAntrian');
    const schedule = formElement.find('[name="id_jadwal"]');
    const idPoli = formElement.find('[name="id_poliklinik"]').val();
    const tanggal = formElement.find('[name="tanggal_kunjungan"]').val();
    const notification = formElement.find('.js-antrian-notification');
    // Hapus pesan sebelumnya saat petugas memperbarui pilihan jadwal.
    notification.empty();
    schedule.prop('disabled', true).html('<option value="">Memuat jadwal...</option>');
    // Jadwal baru dapat dicari setelah poliklinik dan tanggal tersedia.
    if (!idPoli || !tanggal) {
        schedule.html('<option value="">Pilih tanggal dan poliklinik terlebih dahulu</option>');
        return;
    }
    // Ambil jadwal aktif dari server untuk pilihan poliklinik dan tanggal tersebut.
    $.ajax({
        url: '_Page/Antrian/ListJadwal.php',
        type: 'GET',
        data: { id_poliklinik: idPoli, tanggal_kunjungan: tanggal, selected_id: selectedId || '' },
        dataType: 'json'
    }).done(function (response) {
        // Isi pilihan jadwal aktif dan pertahankan pilihan saat form edit dibuka.
        schedule.empty().append($('<option>', { value: '', text: 'Pilih jadwal dokter' }));
        (response.results || []).forEach(function (item) {
            const option = new Option(item.text, item.id, false, String(item.id) === String(selectedId || ''));
            schedule.append(option);
        });
        schedule.prop('disabled', false);
        if (!response.results || response.results.length === 0) {
            schedule.html('<option value="">Tidak ada jadwal aktif pada tanggal ini</option>');
            schedule.prop('disabled', true);
        }
    }).fail(function () {
        schedule.html('<option value="">Gagal memuat jadwal dokter</option>').prop('disabled', true);
        showAntrianNotification(notification, 'Jadwal dokter tidak dapat dimuat.');
    });
}

/**
 * Menginisialisasi Select2 pada form untuk mencari pasien atau memasukkan pasien baru.
 * @param {string|jQuery} [selectElement] Elemen pilih pasien yang akan dipasangi Select2.
 * @param {string|jQuery} [modalElement] Modal induk dropdown Select2.
 * @param {string|jQuery} [notificationElement] Area untuk menampilkan pesan pencarian.
 */
function initializeSelect2Antrian(selectElement, modalElement, notificationElement) {
    const select = $(selectElement || '#pilih_pasien_antrian');
    const modal = $(modalElement || '#ModalTambah');
    const notification = notificationElement || '#NotifikasiAntrian';
    // Hancurkan instance lama agar handler dan dropdown tidak terpasang ganda.
    if (select.hasClass('select2-hidden-accessible')) {
        select.select2('destroy');
    }
    select.select2({
        theme: 'bootstrap-5',
        dropdownParent: modal,
        placeholder: 'Cari nama, RM, NIK, atau pasien baru',
        allowClear: true,
        tags: true,
        width: '100%',
        createTag: function (params) {
            // Izinkan teks pencarian yang bukan pasien terdaftar menjadi pilihan pasien baru.
            const term = $.trim(params.term || '');
            if (!term) {
                return null;
            }
            return { id: 'new:' + term, text: term, isNew: true };
        },
        insertTag: function (results, tag) {
            // Cegah opsi pasien baru menduplikasi nama yang sudah ditemukan dari server.
            const tagText = tag.text.toLocaleLowerCase();
            const exists = results.some(function (item) {
                return item.text.toLocaleLowerCase() === tagText;
            });
            if (!exists) {
                results.push(tag);
            }
        },
        ajax: {
            url: '_Page/Antrian/ListPasien.php',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { term: params.term || '' };
            },
            processResults: function (response) {
                return response;
            },
            error: function () {
                showAntrianNotification(notification, 'Pencarian pasien tidak dapat dimuat.');
            }
        }
    });
}

/**
 * Menyesuaikan visibilitas, nilai, dan status input berdasarkan jenis pasien.
 * @param {string} mode Gunakan `lama` untuk pasien terdaftar atau `baru` untuk pasien baru.
 * @param {string|jQuery} [form] Form antrean yang kontrolnya akan disesuaikan.
 */
function setModePasienAntrian(mode, form) {
    const formElement = $(form || '#FormAntrian');
    const isRegistered = mode === 'lama';
    const patientSelect = formElement.find('.js-pilih-pasien-antrian');
    const patientInputs = formElement.find('[name="nama_pasien"], [name="gender"], [name="nik"], [name="no_bpjs"], [name="kontak"]');
    formElement.find('.js-pilih-pasien-field').toggle(isRegistered);
    formElement.find('.js-data-pasien-field').toggleClass('d-none', isRegistered);
    formElement.find('.js-data-pasien-field :input').prop('disabled', isRegistered);
    formElement.find('[name="id_pasien"]').val(isRegistered ? patientSelect.val() || '' : '');
    patientInputs.prop('readonly', isRegistered);
    if (!isRegistered) {
        patientSelect.val(null).trigger('change');
        formElement.find('[name="id_pasien"]').val('');
        patientInputs.val('');
    }
}

/**
 * Memuat konten detail antrean atau data terkait ke dalam modal detail bersama.
 * @param {string} title Judul modal yang sesuai dengan jenis detail.
 * @param {string} url Endpoint yang mengembalikan markup detail.
 * @param {Object} data Parameter POST untuk endpoint detail.
 */
function showAntrianDetail(title, url, data) {
    // Tampilkan indikator muat dan tombol tutup sebelum meminta markup detail ke server.
    $('#judul_detail_antrian').html(title);
    $('#isi_detail_antrian').html('<div class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Memuat data...</div>');
    $('#aksi_detail_antrian').html('<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>');
    bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalDetailAntrian')).show();
    $.ajax({ type: 'POST', url: url, data: data, dataType: 'html' })
        .done(function (html) {
            $('#isi_detail_antrian').html(html);
            formatAntrianDates($('#isi_detail_antrian'));
        })
        .fail(function (xhr) {
            showAntrianNotification('#isi_detail_antrian', 'Gagal memuat detail. Silakan coba kembali.');
            if (xhr.status === 401) {
                showAntrianToast('Sesi berakhir. Silakan login kembali.', 'warning');
            }
        });
}

let editFormRequest = null;
let editFormRequestId = 0;

/**
 * Meminta markup form edit yang sudah diisi oleh PHP berdasarkan ID antrean.
 * @param {string|number} id ID antrean yang akan diedit.
 */
function openEditAntrian(id) {
    // Abaikan respons lama bila petugas memilih antrean lain sebelum form selesai dimuat.
    editFormRequestId += 1;
    const requestId = editFormRequestId;
    if (editFormRequest) {
        editFormRequest.abort();
    }

    const container = $('#KontenFormEditAntrian');
    container.html('<div class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span>Memuat form edit antrian...</div>');
    $('#NotifikasiEditAntrian').empty();
    $('#SimpanEditAntrian').prop('disabled', true);
    bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalEditAntrian')).show();

    // Kirim ID ke PHP agar endpoint membaca data dan merender seluruh field edit.
    editFormRequest = $.ajax({
        type: 'POST',
        url: '_Page/Antrian/FormEditAntrian.php',
        data: { id_antrian: id },
        dataType: 'html'
    }).done(function (html) {
        if (requestId !== editFormRequestId) {
            return;
        }
        container.html(html);
        initializeSelect2Antrian('#pilih_pasien_edit', '#ModalEditAntrian', '#NotifikasiEditAntrian');
        $('#SimpanEditAntrian').prop('disabled', false);
        if ($('#mode_pasien_edit_lama').is(':checked')) {
            $('#pilih_pasien_edit').next('.select2').find('.select2-selection').trigger('focus');
        } else {
            $('#nama_pasien_edit').trigger('focus');
        }
    }).fail(function (xhr, status) {
        if (requestId !== editFormRequestId || status === 'abort') {
            return;
        }
        container.empty();
        showAntrianNotification(
            '#NotifikasiEditAntrian',
            xhr.status === 401
                ? 'Sesi berakhir. Silakan login kembali.'
                : xhr.status === 404
                    ? 'Data antrian tidak ditemukan.'
                    : 'Form edit antrian gagal dimuat.'
        );
    }).always(function () {
        if (requestId === editFormRequestId) {
            editFormRequest = null;
        }
    });
}

/** Pasang handler halaman setelah elemen tabel, form, dan modal tersedia di DOM. */
$(document).ready(function () {
    // Siapkan komponen pencarian pasien dan tampilkan data antrean pertama kali.
    initializeSelect2Antrian();
    loadTabelAntrian();

    // Bersihkan form dan isi nilai awal setiap modal tambah dibuka dari tombol tambah.
    $('#ModalTambah').on('show.bs.modal', function (event) {
        if ($(event.relatedTarget).is('[data-bs-target="#ModalTambah"]')) {
            $('#FormAntrian')[0].reset();
            $('#NotifikasiAntrian').empty();
            $('#antrian_id, #antrian_id_pasien').val('');
            $('#judul_form_antrian').html('<i class="bi bi-plus-circle"></i> Tambah Antrian Manual');
            $('#data_pasien_field').addClass('d-none').find(':input').prop('disabled', true);
            $('#mode_pasien_lama').prop('checked', true);
            $('#pilih_pasien_antrian').val(null).trigger('change');
            setModePasienAntrian('lama', '#FormAntrian');
            $('#id_jadwal').html('<option value="">Pilih tanggal dan poliklinik terlebih dahulu</option>').prop('disabled', true);
            const today = new Date();
            const localToday = [
                today.getFullYear(),
                String(today.getMonth() + 1).padStart(2, '0'),
                String(today.getDate()).padStart(2, '0')
            ].join('-');
            $('#tanggal_kunjungan').val(localToday);
        }
    });

    // Pindahkan fokus ke kontrol utama setelah tiap modal tampil.
    $('#ModalFilter').on('shown.bs.modal', function () {
        $('#NotifikasiFilter').empty();
        $('#keyword_form').trigger('focus');
    });
    $('#ModalTambah').on('shown.bs.modal', function () {
        if ($('#mode_pasien_lama').is(':checked')) {
            $('#pilih_pasien_antrian').next('.select2').find('.select2-selection').trigger('focus');
        } else {
            $('#nama_pasien').trigger('focus');
        }
    });
    $('#ModalEditAntrian').on('hidden.bs.modal', function () {
        // Hentikan pemuatan yang masih berjalan dan kosongkan field edit saat modal ditutup.
        editFormRequestId += 1;
        if (editFormRequest) {
            editFormRequest.abort();
            editFormRequest = null;
        }
        const patientSelect = $('#pilih_pasien_edit');
        if (patientSelect.hasClass('select2-hidden-accessible')) {
            patientSelect.select2('destroy');
        }
        $('#KontenFormEditAntrian').empty();
        $('#NotifikasiEditAntrian').empty();
        $('#SimpanEditAntrian').prop('disabled', false);
    });
    $('#ModalDaftarPasienAntrian').on('shown.bs.modal', function () {
        $('#daftar_nama_pasien').trigger('focus');
    });

    // Sinkronkan form dengan pilihan pasien terdaftar atau pasien baru.
    $(document).on('change', '.js-mode-pasien', function () {
        const form = $(this).closest('form');
        form.find('.js-antrian-notification').empty();
        setModePasienAntrian($(this).val(), form);
    });

    // Isi identitas pasien dari hasil pencarian, atau pindah ke mode pasien baru.
    $(document).on('select2:select', '.js-pilih-pasien-antrian', function (event) {
        const form = $(this).closest('form');
        form.find('.js-antrian-notification').empty();
        const patient = event.params.data;
        if (patient.isNew) {
            form.find('.js-mode-pasien[value="baru"]').prop('checked', true);
            setModePasienAntrian('baru', form);
            $(this).append(new Option(patient.text, patient.id, true, true)).trigger('change');
            form.find('[name="nama_pasien"]').val(patient.text);
            return;
        }
        form.find('[name="id_pasien"]').val(patient.id);
        form.find('[name="nama_pasien"]').val(patient.nama).prop('readonly', true);
        form.find('[name="gender"]').val(patient.gender || '').prop('readonly', Boolean(patient.gender));
        form.find('[name="nik"]').val(patient.nik || '').prop('readonly', Boolean(patient.nik));
        form.find('[name="no_bpjs"]').val(patient.no_bpjs || '').prop('readonly', Boolean(patient.no_bpjs));
        form.find('[name="kontak"]').val(patient.kontak || '').prop('readonly', Boolean(patient.kontak));
    });
    $(document).on('select2:clear', '.js-pilih-pasien-antrian', function () {
        const form = $(this).closest('form');
        form.find('.js-antrian-notification').empty();
        form.find('[name="id_pasien"]').val('');
        if (form.find('.js-mode-pasien[value="lama"]').is(':checked')) {
            form.find('[name="nama_pasien"], [name="gender"], [name="nik"], [name="no_bpjs"], [name="kontak"]').val('');
            form.find('[name="nama_pasien"], [name="gender"], [name="nik"], [name="no_bpjs"], [name="kontak"]').prop('readonly', true);
        }
    });

    // Perbarui pilihan jadwal saat poliklinik atau tanggal kunjungan berubah.
    $(document).on('change', '.js-antrian-schedule-filter', function () {
        loadJadwalAntrian($(this).closest('form'));
    });

    // Terapkan filter, ubah tanggal pencarian menjadi batas UTC, lalu muat tabel ulang.
    $('#ProsesFilter').on('submit', function (event) {
        event.preventDefault();
        $('#NotifikasiFilter').empty();
        if ($('#keyword_by').val() === 'datetime_creat') {
            const parts = ($('#keyword_form').val() || '').split('-').map(Number);
            if (parts.length === 3 && parts.every(Number.isFinite)) {
                const start = new Date(parts[0], parts[1] - 1, parts[2]);
                const end = new Date(parts[0], parts[1] - 1, parts[2] + 1);
                $('#filter_utc_start').val(start.toISOString().slice(0, 19).replace('T', ' '));
                $('#filter_utc_end').val(end.toISOString().slice(0, 19).replace('T', ' '));
            }
        } else {
            $('#filter_utc_start, #filter_utc_end').val('');
        }
        $('#page_filter').val('1');
        bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalFilter')).hide();
        loadTabelAntrian();
    });

    // Muat jenis kontrol pencarian yang sesuai dengan kolom filter terpilih.
    $('#keyword_by').on('change', function () {
        $('#FormFilter').html('<div class="text-center py-2"><span class="spinner-border spinner-border-sm" role="status" aria-label="Memuat"></span></div>');
        $.ajax({
            type: 'POST',
            url: '_Page/Antrian/FormFilter.php',
            data: { keyword_by: $(this).val() },
            dataType: 'html'
        }).done(function (html) {
            $('#FormFilter').html(html);
        }).fail(function () {
            $('#FormFilter').html('<input type="search" name="keyword" id="keyword_form" class="form-control" placeholder="Gagal memuat filter">');
            showAntrianNotification('#NotifikasiFilter', 'Form pencarian tidak dapat dimuat.');
        });
    });

    // Ganti halaman tabel dan ambil kembali data dari server.
    $('#next_page').on('click', function () {
        $('#page_filter').val(parseInt($('#page_filter').val(), 10) + 1);
        loadTabelAntrian();
    });
    $('#previous_page').on('click', function () {
        $('#page_filter').val(Math.max(1, parseInt($('#page_filter').val(), 10) - 1));
        loadTabelAntrian();
    });

    // Validasi data pasien dan simpan form tambah/edit melalui endpoint yang sama.
    $(document).on('submit', '.js-form-simpan-antrian', function (event) {
        event.preventDefault();
        const form = $(this);
        const notification = form.find('.js-antrian-notification');
        const button = form.find('.js-simpan-antrian');
        notification.empty();
        if (form.find('.js-mode-pasien[value="lama"]').is(':checked') && !form.find('[name="id_pasien"]').val()) {
            showAntrianNotification(notification, 'Pilih pasien terdaftar atau pilih opsi pasien baru.', 'warning');
            return;
        }
        button.prop('disabled', true);
        // Kirim semua nilai form; respons sukses menutup modal dan menyegarkan tabel.
        $.ajax({
            type: 'POST',
            url: '_Page/Antrian/ProsesSimpanAntrian.php',
            data: form.serialize(),
            dataType: 'json'
        }).done(function (response) {
            // Beri umpan balik sesuai hasil server dan muat ulang daftar bila berhasil.
            if (response.status !== 'success') {
                showAntrianNotification(notification, response.message || 'Data antrian gagal disimpan.');
                return;
            }
            bootstrap.Modal.getOrCreateInstance(form.closest('.modal')[0]).hide();
            showAntrianToast(response.message + ' Nomor antrian: ' + response.no_antrian + ' (' + response.kode_booking + ').');
            loadTabelAntrian();
        }).fail(function (xhr) {
            const response = xhr.responseJSON;
            showAntrianNotification(notification, response && response.message ? response.message : 'Data antrian gagal disimpan.');
        }).always(function () {
            button.prop('disabled', false);
        });
    });

    // Arahkan setiap tombol detail ke konten dan endpoint sesuai jenis datanya.
    $(document).on('click', '.js-detail-antrian', function () {
        showAntrianDetail('<i class="bi bi-ticket-detailed"></i> Detail Antrian', '_Page/Antrian/FormDetailAntrian.php', { id_antrian: $(this).data('id') });
    });
    $(document).on('click', '.js-edit-antrian', function () {
        openEditAntrian($(this).data('id'));
    });
    $(document).on('click', '.js-detail-pasien', function () {
        showAntrianDetail('<i class="bi bi-person-vcard"></i> Detail Rekam Medis', '_Page/Antrian/FormDetailPasien.php', { id_pasien: $(this).data('id') });
    });
    $(document).on('click', '.js-detail-poliklinik, .js-detail-dokter', function () {
        const isPoli = $(this).hasClass('js-detail-poliklinik');
        showAntrianDetail(
            isPoli ? '<i class="bi bi-hospital"></i> Detail Poliklinik' : '<i class="bi bi-person-badge"></i> Detail Dokter',
            '_Page/Antrian/FormDetailReferensi.php',
            { jenis: isPoli ? 'poliklinik' : 'dokter', id: $(this).data('id') }
        );
    });

    // Simpan request dan nomor urut untuk mengabaikan respons detail yang sudah kedaluwarsa.
    let hapusDetailRequest = null;
    let hapusDetailRequestId = 0;

    // Minta form hapus yang sudah dirender server dengan mengirim ID antrean terpilih.
    $(document).on('click', '.js-hapus-antrian', function () {
        const id = $(this).data('id');
        hapusDetailRequestId += 1;
        const requestId = hapusDetailRequestId;
        if (hapusDetailRequest) {
            hapusDetailRequest.abort();
        }

        $('#FormHapusAntrian').html('<div class="text-center text-muted py-3"><span class="spinner-border spinner-border-sm me-2" role="status" aria-label="Memuat"></span>Memuat detail antrian...</div>');
        $('#NotifikasiHapusAntrian').empty();
        $('#ButtonHapusAntrian').prop('disabled', true);
        bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalHapusAntrian')).show();

        // Endpoint mengambil antrean berdasarkan ID dan mengembalikan HTML form konfirmasi.
        hapusDetailRequest = $.ajax({
            type: 'POST',
            url: '_Page/Antrian/FormhapusAntrian.php',
            data: { id_antrian: id },
            dataType: 'html'
        }).done(function (html) {
            if (requestId !== hapusDetailRequestId) {
                return;
            }
            $('#FormHapusAntrian').html(html);
            formatAntrianDates($('#FormHapusAntrian'));
            $('#ButtonHapusAntrian').prop('disabled', true);
        }).fail(function (xhr, status) {
            if (requestId !== hapusDetailRequestId || status === 'abort') {
                return;
            }
            $('#FormHapusAntrian').empty();
            showAntrianNotification(
                '#NotifikasiHapusAntrian',
                xhr.status === 401 ? 'Sesi berakhir. Silakan login kembali.' : 'Form penghapusan antrean gagal dimuat.'
            );
        });
    });

    // Aktifkan tombol hapus hanya setelah checklist pernyataan petugas dicentang.
    $(document).on('change', '#pernyataan_petugas_penghapus_antrian', function () {
        const idAntrian = $('#hapus_antrian_id').val();
        $('#ButtonHapusAntrian').prop('disabled', !idAntrian || !$(this).is(':checked'));
    });

    // Batalkan request dan reset modal jika ditutup sebelum atau sesudah konfirmasi.
    $('#ModalHapusAntrian').on('hidden.bs.modal', function () {
        hapusDetailRequestId += 1;
        if (hapusDetailRequest) {
            hapusDetailRequest.abort();
            hapusDetailRequest = null;
        }
        $('#FormHapusAntrian').empty();
        $('#NotifikasiHapusAntrian').empty();
        $('#ButtonHapusAntrian').prop('disabled', true).html('<i class="bi bi-check"></i> Hapus');
    });

    // Kirim penghapusan setelah detail dimuat dan checklist persetujuan telah dicentang.
    $('#ProsesHapusAntrian').on('submit', function (event) {
        event.preventDefault();
        const form = $(this);
        const button = $('#ButtonHapusAntrian');
        const buttonText = button.html();
        const id = $('#hapus_antrian_id').val();
        if (!id || !$('#pernyataan_petugas_penghapus_antrian').is(':checked')) {
            return;
        }

        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Menghapus...');
        $.ajax({
            type: 'POST',
            url: '_Page/Antrian/ProsesHapusAntrian.php',
            data: form.serialize(),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 'success') {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalHapusAntrian')).hide();
                showAntrianToast(response.message);
                loadTabelAntrian();
                return;
            }
            showAntrianNotification('#NotifikasiHapusAntrian', response.message || 'Data antrian gagal dihapus.');
        }).fail(function (xhr) {
            showAntrianNotification('#NotifikasiHapusAntrian', xhr.responseJSON?.message || 'Data antrian gagal dihapus.');
        }).always(function () {
            button.html(buttonText).prop('disabled', !$('#pernyataan_petugas_penghapus_antrian').is(':checked'));
        });
    });

    // Pindahkan data antrean ke form pendaftaran pasien, lalu tampilkan modalnya.
    $(document).on('click', '.js-daftarkan-pasien', function () {
        const button = $(this);
        const patientData = {
            id: button.data('id'),
            nama: button.data('nama'),
            gender: button.data('gender'),
            nik: button.data('nik'),
            noBpjs: button.data('no-bpjs'),
            kontak: button.data('kontak')
        };
        $('#FormDaftarPasienAntrian')[0].reset();
        $('#NotifikasiDaftarPasienAntrian').empty();
        $('#daftar_pasien_id_antrian').val(patientData.id);
        $('#daftar_nama_pasien').val(patientData.nama);
        $('#daftar_gender_pasien').val(patientData.gender);
        $('#daftar_nik_pasien').val(patientData.nik);
        $('#daftar_bpjs_pasien').val(patientData.noBpjs);
        $('#daftar_kontak_pasien').val(patientData.kontak);
        $('#ModalDetailAntrian').one('hidden.bs.modal', function () {
            bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalDaftarPasienAntrian')).show();
        });
        bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalDetailAntrian')).hide();
    });

    // Buat rekam medis dari form pendaftaran dan muat ulang daftar antrean setelah sukses.
    $('#FormDaftarPasienAntrian').on('submit', function (event) {
        event.preventDefault();
        const button = $(this).find('[type="submit"]').prop('disabled', true);
        // Kirim data pasien yang sudah dipindahkan dari antrean untuk membuat rekam medis.
        $.ajax({
            type: 'POST',
            url: '_Page/Antrian/ProsesDaftarPasien.php',
            data: $(this).serialize(),
            dataType: 'json'
        }).done(function (response) {
            if (response.status !== 'success') {
                showAntrianNotification('#NotifikasiDaftarPasienAntrian', response.message || 'Rekam medis gagal dibuat.');
                return;
            }
            bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalDaftarPasienAntrian')).hide();
            bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalDetailAntrian')).hide();
            showAntrianToast(response.message + ' Nomor RM: ' + response.id_pasien);
            loadTabelAntrian();
        }).fail(function (xhr) {
            showAntrianNotification('#NotifikasiDaftarPasienAntrian', xhr.responseJSON?.message || 'Rekam medis gagal dibuat.');
        }).always(function () {
            button.prop('disabled', false);
        });
    });
});
