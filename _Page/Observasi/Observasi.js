// FUNCTION
// Berikut ini adalah kumpulan function yang akan digunakan pada event hanldle di bawah ini.

// Function Menampilkan Data
function TabelObservasi() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    let target = $('#tabel_observasi');

    target.addClass('blur-loading');

    $.ajax({
        type: 'POST',
        url: '_Page/Observasi/TabelObservasi.php',
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

// SELECT2 UNTUK MODAL TAMBAH OBSERVASI
$(document).ready(function() {
    const modalTambah = $('#ModalTambah');
    if (!modalTambah.length || typeof $.fn.select2 !== 'function') {
        return;
    }

    function twoLineSelectTemplate(title, details) {
        return function(item) {
            if (item.loading || !item.id) return item.text || '';
            const primary = title(item);
            const secondary = details(item);
            const row = $('<div>', {class: 'observasi-select2-option'});
            $('<div>', {class: 'fw-semibold fs-6'}).text(primary || item.text || '').appendTo(row);
            if (secondary) {
                $('<small>', {class: 'text-muted d-block'}).text(secondary).appendTo(row);
            }
            return row;
        };
    }

    const templatePasien = twoLineSelectTemplate(
        function(item) { return item.nama || item.text; },
        function(item) { return item.id_pasien ? 'No. RM: ' + item.id_pasien : ''; }
    );
    const templateKunjungan = twoLineSelectTemplate(
        function(item) { return item.tanggal_kunjungan || item.text; },
        function(item) {
            const details = [];
            if (item.jenis_kunjungan) details.push('Jenis: ' + item.jenis_kunjungan);
            if (item.id) details.push('ID Kunjungan: ' + item.id);
            return details.join(' · ');
        }
    );
    const templatePraktisi = twoLineSelectTemplate(
        function(item) { return item.nama_praktisi || item.text; },
        function(item) { return item.profesi_praktisi ? 'Profesi: ' + item.profesi_praktisi : ''; }
    );

    function initRemoteSelect(selector, action, placeholder, parentSelector, extraData, displayTemplate) {
        const select = $(selector);
        if (!select.length) return;
        if (select.hasClass('select2-hidden-accessible')) {
            select.select2('destroy');
        }

        select.select2({
            theme: 'bootstrap-5',
            dropdownParent: $(parentSelector).length ? $(parentSelector) : modalTambah,
            placeholder: placeholder,
            allowClear: true,
            width: '100%',
            templateResult: displayTemplate,
            templateSelection: displayTemplate,
            ajax: {
                url: '_Page/Observasi/ListDataTambah.php',
                type: 'POST',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    const requestData = {
                        action: action,
                        search: params.term || '',
                        page: params.page || 1
                    };
                    const dependentData = typeof extraData === 'function' ? extraData() : extraData;
                    if (dependentData) Object.assign(requestData, dependentData);
                    return requestData;
                },
                processResults: function(data) {
                    return {
                        results: Array.isArray(data.results) ? data.results : [],
                        pagination: {more: !!(data.pagination && data.pagination.more)}
                    };
                },
                cache: true
            }
        });
    }

    initRemoteSelect('#id_pasien', 'pasien', 'Cari No.RM / nama pasien', '#FormIdPasien', null, templatePasien);
    initRemoteSelect('#id_kunjungan', 'kunjungan', 'Pilih tanggal dan jenis kunjungan', '#FormIdKunjungan', function() {
        return {id_pasien: $('#id_pasien').val() || ''};
    }, templateKunjungan);
    initRemoteSelect('#id_praktisi', 'praktisi', 'Cari nama petugas', '#FormIdPraktisi', null, templatePraktisi);
    initRemoteSelect('#category_name', 'kategori', 'Cari kategori observasi', '#FormCategpryName');
    initRemoteSelect('#id_observation_reference', 'referensi', 'Cari jenis observasi', '#FormObservationReference', function() {
        return {category_name: $('#category_name').val() || ''};
    });

    let observationValueRequest = null;
    let observationValueRequestId = 0;

    function loadObservationValue() {
        const referenceId = $('#id_observation_reference').val();
        const requestId = ++observationValueRequestId;
        const wrapper = $('#FormObservationValue');

        if (observationValueRequest) {
            observationValueRequest.abort();
            observationValueRequest = null;
        }

        if (!referenceId) {
            wrapper.html('<small class="text-muted">Pilih jenis observasi untuk mengisi hasil.</small>');
            validateTambah();
            return;
        }

        wrapper.html('<small class="text-muted">Memuat form hasil...</small>');
        validateTambah();
        observationValueRequest = $.ajax({
            type: 'POST',
            url: '_Page/Observasi/FormObservationValue.php',
            data: {id_observation_reference: referenceId},
            dataType: 'html'
        }).done(function(html) {
            if (requestId === observationValueRequestId && referenceId === $('#id_observation_reference').val()) {
                wrapper.html(html);
            }
        }).fail(function(xhr, status) {
            if (status !== 'abort' && requestId === observationValueRequestId) {
                wrapper.html('<small class="text-danger">Gagal memuat form hasil observasi.</small>');
            }
        }).always(function() {
            if (requestId === observationValueRequestId) {
                observationValueRequest = null;
                validateTambah();
            }
        });
    }

    function observationValueIsValid() {
        const wrapper = $('#FormObservationValue');
        const checkedRadio = wrapper.find('input[name="observation_value"]:checked');
        const control = wrapper.find('[name="observation_value"]').first();
        if (checkedRadio.length) return true;
        if (!control.length || control.is(':radio')) return false;
        return String(control.val() || '').trim() !== '' && control[0].checkValidity();
    }

    function validateTambah() {
        const requiredSelects = [
            '#id_pasien', '#id_kunjungan', '#id_praktisi', '#category_name',
            '#id_observation_reference'
        ];
        const selectionsAreValid = requiredSelects.every(function(selector) {
            return Boolean($(selector).val());
        });
        const observationTimeIsValid = ['#tanggal_observasi', '#jam_observasi'].every(function(selector) {
            const field = $(selector);
            return field.length && String(field.val() || '').trim() !== '' && field[0].checkValidity();
        });
        const resultIsValid = observationValueIsValid();
        $('#ButtonTambah').prop('disabled', !(selectionsAreValid && observationTimeIsValid && resultIsValid));
    }

    function setCurrentObservationTime() {
        const now = new Date();
        const pad = function(value) { return String(value).padStart(2, '0'); };
        const date = now.getFullYear() + '-' + pad(now.getMonth() + 1) + '-' + pad(now.getDate());
        const time = pad(now.getHours()) + ':' + pad(now.getMinutes());
        let timezone = '';
        if (window.Intl && Intl.DateTimeFormat) {
            timezone = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
        }
        if (!timezone) {
            const offsetMinutes = -now.getTimezoneOffset();
            const sign = offsetMinutes >= 0 ? '+' : '-';
            const absoluteOffset = Math.abs(offsetMinutes);
            timezone = 'UTC' + sign + pad(Math.floor(absoluteOffset / 60)) + ':' + pad(absoluteOffset % 60);
        }
        $('#tanggal_observasi').val(date);
        $('#jam_observasi').val(time);
        $('#timezone_user').val(timezone);
        validateTambah();
    }

    $('#ButtonTambah').prop('disabled', true);
    $('#id_kunjungan').prop('disabled', true);

    $('#id_pasien').on('change', function() {
        const patientSelected = Boolean($(this).val());
        $('#id_kunjungan').val(null).trigger('change').prop('disabled', !patientSelected);
        validateTambah();
    });

    $('#category_name').on('change', function() {
        $('#id_observation_reference').val(null).trigger('change');
        validateTambah();
    });

    $('#id_observation_reference').on('change', loadObservationValue);

    $('#id_kunjungan, #id_praktisi, #id_observation_reference').on('change', validateTambah);
    $('#FormObservationValue').on('input change', '[name="observation_value"]', validateTambah);
    modalTambah.on(
        'change select2:select select2:clear input',
        '#id_pasien, #id_kunjungan, #id_praktisi, #category_name, #id_observation_reference, #tanggal_observasi, #jam_observasi, #FormObservationValue [name="observation_value"]',
        validateTambah
    );

    modalTambah.on('show.bs.modal', setCurrentObservationTime);

    modalTambah.on('hidden.bs.modal', function() {
        const formTambah = $('#ProsesTambah')[0];
        if (formTambah) formTambah.reset();
        $('#ProsesTambah select').val(null).trigger('change');
        $('#id_kunjungan').prop('disabled', true);
        $('#ButtonTambah').prop('disabled', true);
    });

    loadObservationValue();
    setCurrentObservationTime();
    validateTambah();
});

//--------------------------------------------------------------------------------------------------
// EVENT HANDLE
//--------------------------------------------------------------------------------------------------
$(document).ready(function() {
    
    // menampilkan Data Petama Kali
    TabelObservasi();

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter').val(next_page);
        TabelObservasi(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter').val(next_page);
        TabelObservasi(0);
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
            url 	    : '_Page/Observasi/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            }
        });
    });

    // Submit Pencarian/Filter
    $('#ProsesFilter').submit(function(){
        $('#page_filter').val("1");
        TabelObservasi();
        $('#ModalFilter').modal('hide');
    });

    // TAMBAH OBSERVASI
    // ---------------------------------------
    // Submit Tambah Observasi
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
            url        : '_Page/Observasi/ProsesTambahObservasi.php',
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
                        title            : 'Tambah Observasi Berhasil',
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
                    TabelObservasi();

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
