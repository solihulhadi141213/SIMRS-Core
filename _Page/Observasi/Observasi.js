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

    // EXPORT DATA OBSERVASI
    // ---------------------------------------
    let exportObservasiRequest = null;
    let exportObservasiRequestId = 0;
    $('#ModalExport').on('shown.bs.modal', function() {
        const requestId = ++exportObservasiRequestId;
        const formExport = $('#FormExport');

        if (exportObservasiRequest) {
            exportObservasiRequest.abort();
            exportObservasiRequest = null;
        }
        $('#ButtonExport').prop('disabled', true);
        formExport.html('<div class="text-center text-muted py-3"><span class="spinner-border spinner-border-sm me-2"></span>Menghitung data observasi...</div>');

        exportObservasiRequest = $.ajax({
            type: 'GET',
            url: '_Page/Observasi/FormExport.php',
            dataType: 'html'
        }).done(function(response) {
            if (requestId === exportObservasiRequestId) {
                formExport.html(response);
                const total = Number(formExport.find('[data-export-count]').attr('data-export-count') || 0);
                const confirmed = formExport.find('#ConfirmExportObservation').is(':checked');
                $('#ButtonExport').prop('disabled', total < 1 || !confirmed);
            }
        }).fail(function(xhr, status) {
            if (status !== 'abort' && requestId === exportObservasiRequestId) {
                formExport.html('<div class="alert alert-danger mb-0">Gagal menghitung data observasi untuk export.</div>');
            }
        }).always(function() {
            if (requestId === exportObservasiRequestId) {
                exportObservasiRequest = null;
            }
        });
    });

    $(document).on('change', '#ConfirmExportObservation', function() {
        const total = Number($('#FormExport [data-export-count]').attr('data-export-count') || 0);
        $('#ButtonExport').prop('disabled', total < 1 || !this.checked);
    });

    $(document).on('submit', '#ProsesExportObservasi', function() {
        const button = $('#ButtonExport');
        const buttonHtml = button.html();
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Mengekspor...');
        window.setTimeout(function() {
            button.html(buttonHtml);
            const confirmed = $('#ConfirmExportObservation').is(':checked');
            const total = Number($('#FormExport [data-export-count]').attr('data-export-count') || 0);
            button.prop('disabled', total < 1 || !confirmed);
        }, 1800);
    });

    $('#ModalExport').on('hidden.bs.modal', function() {
        exportObservasiRequestId++;
        if (exportObservasiRequest) exportObservasiRequest.abort();
        exportObservasiRequest = null;
        $('#FormExport').empty();
        $('#ButtonExport').prop('disabled', true).html('<i class="bi bi-download"></i> Export');
    });

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

    // EDIT OBSERVASI
    // ---------------------------------------
    let editFormRequest = null;
    let editFormRequestId = 0;
    let editValueRequest = null;
    let editValueRequestId = 0;

    function destroyEditSelects() {
        $('#FormEdit select.select2-hidden-accessible').each(function() {
            $(this).select2('destroy');
        });
    }

    function validateEditObservation() {
        const selectors = [
            '#edit_id_pasien', '#edit_id_kunjungan', '#edit_id_praktisi',
            '#edit_category_name', '#edit_id_observation_reference'
        ];
        const selectsAreValid = selectors.every(function(selector) {
            return Boolean($('#FormEdit ' + selector).val());
        });
        const timeAreValid = ['#edit_tanggal_observasi', '#edit_jam_observasi'].every(function(selector) {
            const field = $('#FormEdit ' + selector);
            return field.length && String(field.val() || '').trim() !== '' && field[0].checkValidity();
        });
        const wrapper = $('#FormEditObservationValue');
        const checkedRadio = wrapper.find('input[name="observation_value"]:checked');
        const valueControl = wrapper.find('[name="observation_value"]').first();
        let valueIsValid = checkedRadio.length > 0;
        if (!valueIsValid && valueControl.length && !valueControl.is(':radio')) {
            valueIsValid = String(valueControl.val() || '').trim() !== '' && valueControl[0].checkValidity();
        }
        $('#ButtonEdit').prop('disabled', !(selectsAreValid && timeAreValid && valueIsValid));
    }

    function initEditRemoteSelect(selector, action, placeholder, extraData, templateResult, templateSelection) {
        const select = $(selector);
        if (!select.length || typeof $.fn.select2 !== 'function') return;
        if (select.hasClass('select2-hidden-accessible')) {
            select.select2('destroy');
        }

        select.select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#ModalEdit'),
            placeholder: placeholder,
            allowClear: true,
            width: '100%',
            templateResult: templateResult || function(item) { return item.text || ''; },
            templateSelection: templateSelection || function(item) { return item.text || ''; },
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
                    if (typeof extraData === 'function') {
                        Object.assign(requestData, extraData());
                    }
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

    function editSelectTemplate(titleCallback, detailCallback) {
        return function(item) {
            if (item.loading || !item.id) return item.text || '';
            const row = $('<div>', {class: 'observasi-select2-option'});
            $('<div>', {class: 'fw-normal'}).text(titleCallback(item) || item.text || '').appendTo(row);
            const detail = detailCallback ? detailCallback(item) : '';
            if (detail) $('<small>', {class: 'text-muted d-block'}).text(detail).appendTo(row);
            return row;
        };
    }

    function loadEditObservationValue() {
        const referenceId = $('#edit_id_observation_reference').val();
        const requestId = ++editValueRequestId;
        const wrapper = $('#FormEditObservationValue');
        if (editValueRequest) {
            editValueRequest.abort();
            editValueRequest = null;
        }
        if (!referenceId) {
            wrapper.html('<small class="text-muted">Pilih jenis observasi untuk mengisi hasil.</small>');
            validateEditObservation();
            return;
        }

        wrapper.html('<small class="text-muted">Memuat form hasil...</small>');
        validateEditObservation();
        const requestData = {
            id_observation_reference: referenceId,
            form_prefix: 'edit'
        };
        if (String(referenceId) === String($('#edit_initial_reference_id').val() || '')) {
            requestData.observation_value = $('#edit_initial_observation_value').val() || '';
        }

        editValueRequest = $.ajax({
            type: 'POST',
            url: '_Page/Observasi/FormObservationValue.php',
            data: requestData,
            dataType: 'html'
        }).done(function(html) {
            if (requestId === editValueRequestId && referenceId === $('#edit_id_observation_reference').val()) {
                wrapper.html(html);
            }
        }).fail(function(xhr, status) {
            if (status !== 'abort' && requestId === editValueRequestId) {
                wrapper.html('<small class="text-danger">Gagal memuat form hasil observasi.</small>');
            }
        }).always(function() {
            if (requestId === editValueRequestId) {
                editValueRequest = null;
                validateEditObservation();
            }
        });
    }

    function initializeEditForm() {
        const templatePatient = editSelectTemplate(
            function(item) { return item.nama || item.text; },
            function(item) { return item.id_pasien ? 'No. RM: ' + item.id_pasien : ''; }
        );
        const templateVisit = editSelectTemplate(
            function(item) { return item.tanggal_kunjungan || item.text; },
            function(item) { return item.jenis_kunjungan ? 'Jenis: ' + item.jenis_kunjungan : ''; }
        );
        const templatePractitioner = editSelectTemplate(
            function(item) { return item.nama_praktisi || item.text; },
            function(item) { return item.profesi_praktisi ? 'Profesi: ' + item.profesi_praktisi : ''; }
        );
        const templateReference = editSelectTemplate(
            function(item) { return item.observation_name || item.text; },
            function(item) {
                const detail = [];
                if (item.unit_name) detail.push('Satuan: ' + item.unit_name);
                if (item.result_type) detail.push('Tipe: ' + item.result_type);
                return detail.join(' · ');
            }
        );

        initEditRemoteSelect('#edit_id_pasien', 'pasien', 'Cari No. RM / nama pasien', null, templatePatient, templatePatient);
        initEditRemoteSelect('#edit_id_kunjungan', 'kunjungan', 'Pilih kunjungan', function() {
            return {id_pasien: $('#edit_id_pasien').val() || ''};
        }, templateVisit, templateVisit);
        initEditRemoteSelect('#edit_id_praktisi', 'praktisi', 'Cari nama petugas', null, templatePractitioner, templatePractitioner);
        const templateCategory = editSelectTemplate(function(item) { return item.text; }, null);
        initEditRemoteSelect('#edit_category_name', 'kategori', 'Cari kategori observasi', null, templateCategory, templateCategory);
        initEditRemoteSelect('#edit_id_observation_reference', 'referensi', 'Cari jenis observasi', function() {
            return {category_name: $('#edit_category_name').val() || ''};
        }, templateReference, templateReference);

        loadEditObservationValue();
        validateEditObservation();
    }

    $(document).on('click', '.modal_edit', function(e) {
        e.preventDefault();
        const idObservation = Number($(this).attr('data-id'));
        const requestId = ++editFormRequestId;
        const modal = $('#ModalEdit');
        const formEdit = $('#FormEdit');

        if (editFormRequest) editFormRequest.abort();
        if (editValueRequest) editValueRequest.abort();
        destroyEditSelects();
        $('#NotifikasiEdit').empty();
        $('#ButtonEdit').prop('disabled', true);
        $('#ProsesEdit [name="id_observation"]').val(idObservation || '');
        modal.modal('show');

        if (!Number.isInteger(idObservation) || idObservation < 1) {
            formEdit.html('<div class="alert alert-danger mb-0">ID observasi tidak valid.</div>');
            return;
        }
        formEdit.html('<div class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-2"></span>Memuat form edit...</div>');

        editFormRequest = $.ajax({
            type: 'POST',
            url: '_Page/Observasi/FormEditObservasi.php',
            data: {id_observation: idObservation},
            dataType: 'html'
        }).done(function(html) {
            if (requestId !== editFormRequestId) return;
            formEdit.html(html);
            if (formEdit.find('#edit_id_pasien').length) {
                try {
                    initializeEditForm();
                } catch (error) {
                    console.error('Observasi edit: gagal menginisialisasi form.', error);
                    $('#FormEditObservationValue').html('<small class="text-danger">Form edit gagal diinisialisasi. Tutup lalu buka kembali.</small>');
                    $('#ButtonEdit').prop('disabled', true);
                }
            }
        }).fail(function(xhr, status) {
            if (status !== 'abort' && requestId === editFormRequestId) {
                formEdit.html('<div class="alert alert-danger mb-0">Gagal memuat form edit observasi.</div>');
            }
        }).always(function() {
            if (requestId === editFormRequestId) editFormRequest = null;
        });
    });

    $(document).on('change', '#edit_id_pasien', function() {
        $('#edit_id_kunjungan').val(null).trigger('change');
        validateEditObservation();
    });
    $(document).on('change', '#edit_category_name', function() {
        $('#edit_id_observation_reference').val(null).trigger('change');
        validateEditObservation();
    });
    $(document).on('change', '#edit_id_observation_reference', loadEditObservationValue);
    $(document).on(
        'change input',
        '#FormEdit select, #FormEdit input, #FormEditObservationValue [name="observation_value"]',
        validateEditObservation
    );

    $(document).on('submit', '#ProsesEdit', function(e) {
        e.preventDefault();
        if ($('#ButtonEdit').prop('disabled')) return;

        const form = $(this);
        const button = $('#ButtonEdit');
        const notification = $('#NotifikasiEdit');
        const buttonText = button.html();
        notification.empty();
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Memproses...');

        $.ajax({
            url: '_Page/Observasi/ProsesEditObservasi.php',
            type: 'POST',
            data: new FormData(this),
            dataType: 'json',
            processData: false,
            contentType: false
        }).done(function(response) {
            if (response.status === 'success') {
                $('#ModalEdit').modal('hide');
                Swal.fire({toast: true, position: 'top-end', icon: 'success', title: 'Edit Observasi Berhasil', showConfirmButton: false, timer: 1200, timerProgressBar: true});
                TabelObservasi();
            } else {
                notification.html('<div class="alert alert-danger mb-0"><small>' + $('<div>').text(response.message || 'Data observasi gagal diperbarui.').html() + '</small></div>');
            }
        }).fail(function() {
            notification.html('<div class="alert alert-danger mb-0"><small>Terjadi kesalahan saat memperbarui observasi.</small></div>');
        }).always(function() {
            button.html(buttonText);
            validateEditObservation();
        });
    });

    $('#ModalEdit').on('hidden.bs.modal', function() {
        editFormRequestId++;
        editValueRequestId++;
        if (editFormRequest) editFormRequest.abort();
        if (editValueRequest) editValueRequest.abort();
        destroyEditSelects();
        $('#FormEdit').empty();
        $('#NotifikasiEdit').empty();
        $('#ProsesEdit [name="id_observation"]').val('');
        $('#ButtonEdit').prop('disabled', true);
    });

    // HAPUS OBSERVASI
    // ---------------------------------------
    let deletePreviewRequest = null;
    let deletePreviewRequestId = 0;
    $(document).on('click', '.modal_hapus', function(e) {
        e.preventDefault();
        const idObservation = Number($(this).attr('data-id'));
        const requestId = ++deletePreviewRequestId;
        const formPreview = $('#FormHapus');

        if (deletePreviewRequest) deletePreviewRequest.abort();
        $('#NotifikasiHapus').empty();
        $('#ButtonHapus').prop('disabled', true);
        $('#ProsesHapus [name="id_observation"]').val(idObservation || '');
        $('#ModalHapus').modal('show');

        if (!Number.isInteger(idObservation) || idObservation < 1) {
            formPreview.html('<div class="alert alert-danger mb-0">ID observasi tidak valid.</div>');
            return;
        }
        formPreview.html('<div class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-2"></span>Memuat preview observasi...</div>');

        deletePreviewRequest = $.ajax({
            type: 'POST',
            url: '_Page/Observasi/FormHapusObservasi.php',
            data: {id_observation: idObservation},
            dataType: 'html'
        }).done(function(html) {
            if (requestId === deletePreviewRequestId) formPreview.html(html);
        }).fail(function(xhr, status) {
            if (status !== 'abort' && requestId === deletePreviewRequestId) {
                formPreview.html('<div class="alert alert-danger mb-0">Gagal memuat preview observasi.</div>');
            }
        }).always(function() {
            if (requestId === deletePreviewRequestId) deletePreviewRequest = null;
        });
    });

    $(document).on('change', '#pernyataan_petugas_penghapus', function() {
        $('#ButtonHapus').prop('disabled', !$(this).is(':checked'));
    });

    $(document).on('submit', '#ProsesHapus', function(e) {
        e.preventDefault();
        if ($('#ButtonHapus').prop('disabled')) return;

        const button = $('#ButtonHapus');
        const notification = $('#NotifikasiHapus');
        const buttonText = button.html();
        notification.empty();
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menghapus...');

        $.ajax({
            url: '_Page/Observasi/ProsesHapusObservasi.php',
            type: 'POST',
            data: new FormData(this),
            dataType: 'json',
            processData: false,
            contentType: false
        }).done(function(response) {
            if (response.status === 'success') {
                $('#ModalHapus').modal('hide');
                Swal.fire({toast: true, position: 'top-end', icon: 'success', title: 'Hapus Observasi Berhasil', showConfirmButton: false, timer: 1200, timerProgressBar: true});
                TabelObservasi();
            } else {
                notification.html('<div class="alert alert-danger mb-0"><small>' + $('<div>').text(response.message || 'Data observasi gagal dihapus.').html() + '</small></div>');
            }
        }).fail(function() {
            notification.html('<div class="alert alert-danger mb-0"><small>Terjadi kesalahan saat menghapus observasi.</small></div>');
        }).always(function() {
            button.html(buttonText);
            button.prop('disabled', !$('#pernyataan_petugas_penghapus').is(':checked'));
        });
    });

    $('#ModalHapus').on('hidden.bs.modal', function() {
        deletePreviewRequestId++;
        if (deletePreviewRequest) deletePreviewRequest.abort();
        deletePreviewRequest = null;
        $('#FormHapus').empty();
        $('#NotifikasiHapus').empty();
        $('#ProsesHapus [name="id_observation"]').val('');
        $('#ButtonHapus').prop('disabled', true);
    });

    // DETAIL OBSERVASI
    // ---------------------------------------
    let detailObservasiRequest = null;
    let detailObservasiRequestId = 0;
    $(document).on('click', '.modal_detail', function(e) {
        e.preventDefault();

        const idObservation = Number($(this).attr('data-id'));
        const modalDetail   = $('#ModalDetail');
        const formDetail    = $('#FormDetail');
        const requestId     = ++detailObservasiRequestId;

        if (detailObservasiRequest) {
            detailObservasiRequest.abort();
            detailObservasiRequest = null;
        }

        modalDetail.modal('show');

        if (!Number.isInteger(idObservation) || idObservation < 1) {
            formDetail.html('<div class="alert alert-danger mb-0">ID observasi tidak valid.</div>');
            return;
        }

        formDetail.html('<div class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-2"></span>Memuat detail observasi...</div>');

        detailObservasiRequest = $.ajax({
            type    : 'POST',
            url     : '_Page/Observasi/FormDetailObservasi.php',
            data    : {id_observation: idObservation},
            dataType: 'html'
        }).done(function(response) {
            if (requestId === detailObservasiRequestId) {
                formDetail.html(response);
            }
        }).fail(function(xhr, status) {
            if (status !== 'abort' && requestId === detailObservasiRequestId) {
                formDetail.html('<div class="alert alert-danger mb-0">Gagal memuat detail observasi.</div>');
            }
        }).always(function() {
            if (requestId === detailObservasiRequestId) {
                detailObservasiRequest = null;
            }
        });
    });

    // DETAIL OBSERVATION SATUSEHAT
    // ---------------------------------------
    let detailObservationSatusehatRequest = null;
    let detailObservationSatusehatRequestId = 0;
    $(document).on('click', '.modal_detail_observation', function(e) {
        e.preventDefault();

        const observationId = String($(this).attr('data-id') || '').trim();
        const requestId = ++detailObservationSatusehatRequestId;
        const modal = $('#ModalDetailObservation');
        const form = $('#FormDetailObservation');

        if (detailObservationSatusehatRequest) {
            detailObservationSatusehatRequest.abort();
            detailObservationSatusehatRequest = null;
        }

        modal.modal('show');
        if (!/^[A-Za-z0-9.-]{1,64}$/.test(observationId)) {
            form.html('<div class="alert alert-danger mb-0">ID Observation SATUSEHAT tidak valid.</div>');
            return;
        }

        form.html('<div class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-2"></span>Memuat detail Observation dari SATUSEHAT...</div>');
        detailObservationSatusehatRequest = $.ajax({
            type: 'POST',
            url: '_Page/Observasi/FormDetailObservation.php',
            data: {observation_id: observationId},
            dataType: 'html'
        }).done(function(response) {
            if (requestId === detailObservationSatusehatRequestId) {
                form.html(response);
            }
        }).fail(function(xhr, status) {
            if (status !== 'abort' && requestId === detailObservationSatusehatRequestId) {
                form.html('<div class="alert alert-danger mb-0">Gagal mengambil detail Observation dari SATUSEHAT.</div>');
            }
        }).always(function() {
            if (requestId === detailObservationSatusehatRequestId) {
                detailObservationSatusehatRequest = null;
            }
        });
    });

    $('#ModalDetailObservation').on('hidden.bs.modal', function() {
        detailObservationSatusehatRequestId++;
        if (detailObservationSatusehatRequest) detailObservationSatusehatRequest.abort();
        detailObservationSatusehatRequest = null;
        $('#FormDetailObservation').empty();
    });

    // KIRIM OBSERVATION
    // ---------------------------------------
    let observationPayloadRequest = null;
    let observationPayloadRequestId = 0;
    $(document).on('click', '.kirim_observation', function(e) {
        e.preventDefault();

        const idObservation = Number($(this).attr('data-id'));
        const requestId = ++observationPayloadRequestId;
        const modal = $('#ModalKirimObservation');
        const payloadForm = $('#FormKirimObservation');

        if (observationPayloadRequest) {
            observationPayloadRequest.abort();
            observationPayloadRequest = null;
        }
        $('#NotifikasiKirimObservation').empty();
        $('#ButtonKirimObservation').prop('disabled', true);
        $('#ProsesKirimObservation [name="id_observation"]').val(idObservation || '');
        modal.modal('show');

        if (!Number.isInteger(idObservation) || idObservation < 1) {
            payloadForm.html('<div class="alert alert-danger mb-0">ID observasi tidak valid.</div>');
            return;
        }

        payloadForm.html('<div class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-2"></span>Menyusun payload Observation...</div>');
        observationPayloadRequest = $.ajax({
            type: 'POST',
            url: '_Page/Observasi/FormKirimObservation.php',
            data: {id_observation: idObservation},
            dataType: 'html'
        }).done(function(html) {
            if (requestId === observationPayloadRequestId) {
                payloadForm.html(html);
                const payloadReady = payloadForm.find('[data-observation-ready="1"]').length > 0;
                $('#ButtonKirimObservation').prop('disabled', !payloadReady);
            }
        }).fail(function(xhr, status) {
            if (status !== 'abort' && requestId === observationPayloadRequestId) {
                payloadForm.html('<div class="alert alert-danger mb-0">Gagal memuat payload Observation.</div>');
            }
        }).always(function() {
            if (requestId === observationPayloadRequestId) {
                observationPayloadRequest = null;
            }
        });
    });

    let observationSubmitRequest = null;
    $(document).on('submit', '#ProsesKirimObservation', function(e) {
        e.preventDefault();

        const form = $(this);
        const button = $('#ButtonKirimObservation');
        const notification = $('#NotifikasiKirimObservation');
        const payloadReady = $('#FormKirimObservation').find('[data-observation-ready="1"]').length > 0;
        if (!payloadReady || button.prop('disabled') || observationSubmitRequest) {
            return;
        }

        const originalButtonHtml = button.html();
        notification.empty();
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Mengirim...');

        observationSubmitRequest = $.ajax({
            type: 'POST',
            url: '_Page/Observasi/ProsesKirimObservation.php',
            data: new FormData(this),
            processData: false,
            contentType: false,
            dataType: 'json'
        }).done(function(response) {
            if (response && response.status === 'success') {
                $('#ModalKirimObservation').modal('hide');
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: response.message || 'Observation berhasil dikirim ke SATUSEHAT',
                    showConfirmButton: false,
                    timer: 1800,
                    timerProgressBar: true
                });
                TabelObservasi();
                return;
            }

            const message = response && response.message ? response.message : 'Pengiriman Observation gagal.';
            notification.html('<div class="alert alert-danger mb-0"><small>' + $('<div>').text(message).html() + '</small></div>');
        }).fail(function(xhr) {
            const response = xhr.responseJSON || {};
            const message = response.message || 'Terjadi kesalahan saat mengirim Observation ke SATUSEHAT.';
            let missingHtml = '';
            if (Array.isArray(response.missing) && response.missing.length) {
                missingHtml = '<ul class="mb-0 mt-2">' + response.missing.map(function(item) {
                    return '<li>' + $('<div>').text(item).html() + '</li>';
                }).join('') + '</ul>';
            }
            notification.html('<div class="alert alert-danger mb-0"><small>' + $('<div>').text(message).html() + '</small>' + missingHtml + '</div>');
            if (xhr.status === 422 || response.observation_id) {
                $('#FormKirimObservation [data-observation-ready]').attr('data-observation-ready', '0');
                button.prop('disabled', true);
            }
        }).always(function() {
            observationSubmitRequest = null;
            button.html(originalButtonHtml);
            const stillReady = $('#FormKirimObservation').find('[data-observation-ready="1"]').length > 0;
            button.prop('disabled', !stillReady);
        });
    });

    $('#ModalKirimObservation').on('hidden.bs.modal', function() {
        observationPayloadRequestId++;
        if (observationPayloadRequest) observationPayloadRequest.abort();
        observationPayloadRequest = null;
        $('#FormKirimObservation').empty();
        $('#NotifikasiKirimObservation').empty();
        $('#ProsesKirimObservation [name="id_observation"]').val('');
        $('#ButtonKirimObservation').prop('disabled', true);
    });

});
