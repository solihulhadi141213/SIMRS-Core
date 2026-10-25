const dashboardMonths = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
let dashboardVisitChart = null;
let patientVisitOffset = 0;
let patientVisitLoading = false;
let patientVisitHasMore = true;

function formatDashboardNumber(value) {
    return new Intl.NumberFormat('id-ID').format(Number(value) || 0);
}

function showDashboardError(target, message) {
    $(target).text(message).addClass('is-error').removeClass('is-hidden');
}

function clearDashboardError(target) {
    $(target).empty().removeClass('is-error').addClass('is-hidden');
}

function renderDashboardDonut(target, labels, series, colors) {
    const element = document.querySelector(target);
    if (!element || typeof ApexCharts === 'undefined') {
        showDashboardError(target, 'Komponen grafik tidak tersedia.');
        return null;
    }

    return new ApexCharts(element, {
        chart: { type: 'donut', height: 190, fontFamily: 'Open Sans, sans-serif' },
        labels,
        series,
        colors,
        legend: { position: 'bottom', fontSize: '11px' },
        dataLabels: { enabled: true, formatter: (value) => `${value.toFixed(1)}%` },
        stroke: { width: 2, colors: ['#fff'] },
        plotOptions: {
            pie: {
                donut: {
                    size: '66%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total',
                            formatter: (chart) => formatDashboardNumber(chart.globals.seriesTotals.reduce((total, value) => total + value, 0))
                        }
                    }
                }
            }
        },
        tooltip: { y: { formatter: (value) => `${formatDashboardNumber(value)} kunjungan` } },
        noData: { text: 'Data tidak tersedia' }
    });
}

function loadDashboardDonut(url, target, colors) {
    $.ajax({
        url,
        type: 'GET',
        dataType: 'json'
    }).done(function (response) {
        if (response.status !== 'success' || !Array.isArray(response.series)) {
            showDashboardError(target, response.message || 'Data grafik tidak valid.');
            return;
        }

        const chart = renderDashboardDonut(target, response.labels, response.series, colors);
        if (chart) {
            chart.render();
        }
    }).fail(function (xhr) {
        const message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal memuat data grafik.';
        showDashboardError(target, message);
    });
}

function renderDashboardVisitChart(categories, values) {
    if (typeof ApexCharts === 'undefined') {
        showDashboardError('#GrafikPasien', 'Komponen grafik tidak tersedia.');
        return;
    }

    if (dashboardVisitChart) {
        dashboardVisitChart.destroy();
    }

    dashboardVisitChart = new ApexCharts(document.querySelector('#ChartKunjungan'), {
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: false },
            fontFamily: 'Open Sans, sans-serif'
        },
        series: [{ name: 'Kunjungan', data: values }],
        colors: ['#1a5a6a'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        fill: {
            type: 'gradient',
            gradient: { opacityFrom: 0.25, opacityTo: 0.02, shadeIntensity: 0.3 }
        },
        grid: { borderColor: '#e8eef0', strokeDashArray: 4 },
        xaxis: { categories, axisBorder: { show: false }, axisTicks: { show: false } },
        yaxis: {
            min: 0,
            forceNiceScale: true,
            labels: { formatter: (value) => formatDashboardNumber(Math.round(value)) }
        },
        tooltip: { y: { formatter: (value) => `${formatDashboardNumber(value)} kunjungan` } },
        noData: { text: 'Data tidak tersedia' }
    });
    dashboardVisitChart.render();
}

function loadVisitChart(formData) {
    clearDashboardError('#GrafikPasien');
    $('#ChartKunjungan').addClass('is-hidden');

    $.ajax({
        url: '_Page/Dashboard/GrafikDashboard.php',
        type: 'POST',
        data: formData,
        dataType: 'json'
    }).done(function (response) {
        if (response.status !== 'success' || !Array.isArray(response.kategori) || !Array.isArray(response.data)) {
            showDashboardError('#GrafikPasien', response.message || 'Data grafik tidak valid.');
            return;
        }

        const periodText = response.periode === 'Tahunan'
            ? `Tahun ${response.tahun}`
            : `${dashboardMonths[Number(response.bulan) - 1]} ${response.tahun}`;
        $('#dashboardVisitsPeriod').text(periodText);
        $('#ChartKunjungan').removeClass('is-hidden');
        renderDashboardVisitChart(response.kategori, response.data);
    }).fail(function (xhr) {
        const message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal memuat grafik kunjungan.';
        showDashboardError('#GrafikPasien', message);
    });
}

function loadDashboardCounts() {
    $.ajax({
        url: '_Page/Dashboard/GetCount.php',
        type: 'GET',
        dataType: 'json'
    }).done(function (response) {
        if (response.status !== 'success') {
            const message = response.message || 'Data gagal dimuat.';
            ['#jumlah_dokter', '#jumlah_poliklinik', '#jumlah_bed', '#jumlah_pasien'].forEach((selector) => {
                $(selector).text(message);
            });
            return;
        }

        $('#jumlah_dokter').text(formatDashboardNumber(response.dokter));
        $('#jumlah_poliklinik').text(formatDashboardNumber(response.poliklinik));
        $('#jumlah_bed').text(formatDashboardNumber(response.bed_total));
        $('#jumlah_pasien').text(formatDashboardNumber(response.pasien));
    }).fail(function (xhr) {
        const message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal memuat jumlah data.';
        ['#jumlah_dokter', '#jumlah_poliklinik', '#jumlah_bed', '#jumlah_pasien'].forEach((selector) => {
            $(selector).text('-').attr('title', message);
        });
    });
}

function formatPatientVisitDate(value) {
    if (!value) return '-';
    const utcDate = new Date(`${value.replace(' ', 'T')}Z`);
    if (Number.isNaN(utcDate.getTime())) return value;
    return new Intl.DateTimeFormat('id-ID', {
        dateStyle: 'medium',
        timeStyle: 'short'
    }).format(utcDate);
}

function appendPatientVisits(visits) {
    const list = $('#PasienExistingList');
    visits.forEach((visit) => {
        const item = $('<article>').addClass('dashboard-existing-item');
        const details = $('<div>').addClass('dashboard-existing-details');
        const patientName = $('<h6>').text(visit.nama || 'Nama tidak tersedia');
        const medicalRecord = $('<span>').text(`RM.${String(visit.id_pasien).padStart(5, '0')}`);
        const visitInfo = $('<p>').text(`${visit.jenis_kunjungan || '-'} - ${formatPatientVisitDate(visit.datetime_daftar)}`);
        details.append(patientName, medicalRecord, visitInfo);
        item.append(details, $('<i>').addClass('bi bi-chevron-right').attr('aria-hidden', 'true'));
        list.append(item);
    });
}

function loadNextPatientVisits() {
    if (patientVisitLoading || !patientVisitHasMore) return;

    patientVisitLoading = true;
    let pageLoaded = false;
    $('#PasienExistingList').attr('aria-busy', 'true');
    $('#LoadingPasienExisting').text('Memuat kunjungan...');

    $.ajax({
        url: '_Page/Dashboard/TabelPasienExisting.php',
        type: 'GET',
        data: { offset: patientVisitOffset },
        dataType: 'json'
    }).done(function (response) {
        if (response.status !== 'success' || !Array.isArray(response.data)) {
            $('#LoadingPasienExisting').text(response.message || 'Data kunjungan tidak valid.');
            patientVisitHasMore = false;
            return;
        }

        if (patientVisitOffset === 0) {
            $('#PasienExistingList').empty();
            if (response.data.length === 0) {
                $('#PasienExistingList').html($('<p>').addClass('dashboard-existing-message').text('Belum ada kunjungan terdaftar.'));
            }
        }

        appendPatientVisits(response.data);
        patientVisitOffset = Number(response.nextOffset) || patientVisitOffset + response.data.length;
        patientVisitHasMore = Boolean(response.hasMore);
        pageLoaded = true;
        $('#LoadingPasienExisting').text(patientVisitHasMore ? '' : (patientVisitOffset > 0 ? 'Semua kunjungan telah dimuat.' : ''));

        if (response.data.length === 0) patientVisitHasMore = false;
    }).fail(function (xhr) {
        const message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Gagal memuat daftar kunjungan.';
        $('#LoadingPasienExisting').text(message);
    }).always(function () {
        patientVisitLoading = false;
        $('#PasienExistingList').attr('aria-busy', 'false');
        const list = $('#PasienExistingList')[0];
        if (pageLoaded && patientVisitHasMore && list.scrollHeight <= list.clientHeight + 40) {
            loadNextPatientVisits();
        }
    });
}

$(function () {
    if (!$('#ChartKunjungan').length) return;

    loadDashboardCounts();
    loadDashboardDonut('_Page/Dashboard/GrafikKategoriPelayanan.php', '#ChartKategoriPelayanan', ['#1a5a6a', '#96aaaf']);
    loadDashboardDonut('_Page/Dashboard/GrafikPembiayaan.php', '#ChartPembiayaan', ['#1a5a6a', '#d8a84e']);
    loadVisitChart($('#ProsesFilterPeriodeGrafik').serialize());
    loadNextPatientVisits();

    $('#PasienExistingList').on('scroll', function () {
        if (this.scrollTop + this.clientHeight >= this.scrollHeight - 80) {
            loadNextPatientVisits();
        }
    });

    $('#periode').on('change', function () {
        const isMonthly = $(this).val() === 'Bulanan';
        $('#bulanPeriodeGroup').toggleClass('d-none', !isMonthly);
        $('#bulan').prop('disabled', !isMonthly).prop('required', isMonthly);
    });

    $('#ProsesFilterPeriodeGrafik').on('submit', function (event) {
        event.preventDefault();
        if (!this.reportValidity()) return;

        loadVisitChart($(this).serialize());
        bootstrap.Modal.getOrCreateInstance(document.getElementById('ModalFilterPeriodeGrafik')).hide();
    });
});
