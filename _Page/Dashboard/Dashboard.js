// Dashboard.js Bersifat Global
function tampilkanToast(pesan, tipe = 'success') {
    const toastEl = document.getElementById('liveToast');

    // ubah isi pesan
    toastEl.querySelector('.toast-body').innerHTML = pesan;

    // ubah warna berdasarkan tipe
    toastEl.className = 'toast align-items-center border-0';

    if (tipe === 'success') {
        toastEl.classList.add('text-bg-success');
    } else if (tipe === 'danger') {
        toastEl.classList.add('text-bg-danger');
    } else if (tipe === 'warning') {
        toastEl.classList.add('text-bg-warning');
    } else {
        toastEl.classList.add('text-bg-primary');
    }

    const toast = new bootstrap.Toast(toastEl, {
        delay: 1000
    });

    toast.show();
}

//Fungsi Menampilkan Data
function ShowGrafik() {

    // Ambil data filter
    let formData = $('#ProsesFilterPeriodeGrafik').serialize();

    // Loading
    $('#GrafikPasien').html('<div class="text-center">Loading...</div>');

    // AJAX ambil data
    $.ajax({
        url     : '_Page/Dashboard/GrafikDashboard.php',
        type    : 'POST',
        data    : formData,
        dataType: 'json',
        success: function (res) {

            // Validasi data
            if (res.status !== 'success') {
                $('#GrafikPasien').html('<div class="text-danger text-center">' + res.message + '</div>');
                return;
            }

            // 🔥 BUAT JUDUL DINAMIS
            let judul = '';

            if (res.periode === 'Tahunan') {
                judul = `Grafik Kunjungan Tahun ${res.tahun}`;
            } else if (res.periode === 'Bulanan') {

                const namaBulan = [
                    "Jan", "Feb", "Mar", "Apr", "Mei", "Jun",
                    "Jul", "Agu", "Sep", "Okt", "Nov", "Des"
                ];

                let bulanIndex = parseInt(res.bulan) - 1;
                let bulanText = namaBulan[bulanIndex];

                judul = `Grafik Kunjungan ${bulanText} ${res.tahun}`;
            }

            // 🔥 TAMPILKAN JUDUL + CHART
            $('#GrafikPasien').html(`
                <div class="mb-3 text-center">
                    <h5 class="fw-bold">${judul}</h5>
                </div>
                <div id="ChartKunjungan"></div>
            `);

            // 🔥 CONFIG CHART
            var options = {
                chart: {
                    type: 'bar',
                    height: 450,
                    background: 'transparent', // 🔥 transparan
                    toolbar: { show: false }
                },
                series: [{
                    name: 'Jumlah Kunjungan',
                    data: res.data
                }],
                xaxis: {
                    categories: res.kategori
                },
                colors: ['#0d6efd'],
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    curve: 'smooth'
                },
                grid: {
                    borderColor: '#e0e0e0',
                    strokeDashArray: 4
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " kunjungan";
                        }
                    }
                },
                noData: {
                    text: 'Tidak ada data'
                }
            };

           // 🔥 RENDER CHART
            var chart = new ApexCharts(document.querySelector("#ChartKunjungan"), options);
            chart.render();
        },
        error: function () {
            $('#GrafikPasien').html('<div class="text-danger text-center">Gagal mengambil data</div>');
        }
    });
}
function formatDashboardNumber(number) {
    number = parseInt(number) || 0;

    // < 1.000
    if (number < 1000) {
        return number.toString();
    }

    // 1.000 s/d 999.999 => K
    if (number < 1000000) {
        let result = number / 1000;

        // Jika bulat, tanpa desimal
        if (result % 1 === 0) {
            return result + ' K';
        }

        // Jika ada pecahan, 1 angka di belakang koma
        return result.toFixed(1).replace('.', ',') + ' K';
    }

    // >= 1.000.000 => M
    let result = number / 1000000;

    if (result % 1 === 0) {
        return result + ' M';
    }

    return result.toFixed(1).replace('.', ',') + ' M';
}

// Menampilkan Angka Dashboard
function ShowDashboard() {
    // Loading
    $('#jumlah_pasien').html('Loading..');
    $('#jumlah_kunjungan').html('Loading..');
    $('#jumlah_poliklinik').html('Loading..');
    $('#jumlah_bed').html('Loading..');

    // Ambil Data Dengan AJAX
    $.ajax({
        url     : '_Page/Dashboard/GetCount.php',
        type    : 'GET',
        dataType: 'json',
        success : function (response) {
           var pasien = response.pasien;
           var kunjungan = response.kunjungan;
           var poliklinik = response.poliklinik;
           var bed_total = response.bed_total;

            // Tempelkan He HTML
            $('#jumlah_pasien').html(formatDashboardNumber(pasien));
            $('#jumlah_kunjungan').html(formatDashboardNumber(kunjungan));
            $('#jumlah_poliklinik').html(formatDashboardNumber(poliklinik));
            $('#jumlah_bed').html(formatDashboardNumber(bed_total));
        }
    });
}

// Menampilkan Tabel Pasien Existing
function ShowPasienExisting() {
    let ProsesFilterPasienExisting = $('#ProsesFilterPasienExisting').serialize();

    // Tampilkan loading overlay
    $('#LoadingPasienExisting').fadeIn(150);

    $.ajax({
        url: '_Page/Dashboard/TabelPasienExisting.php',
        type: 'POST',
        data: ProsesFilterPasienExisting,
        success: function (data) {
            // Fade out isi lama
            $('#TabelPasienExisting').fadeOut(120, function () {
                $(this).html(data).fadeIn(180);
            });
        },
        complete: function () {
            // Hilangkan overlay
            $('#LoadingPasienExisting').fadeOut(150);
        }
    });
}

// Fungsi load tahun dari server
function loadTahun() {
    $.ajax({
        url     : '_Page/Dashboard/ListTahun.php',
        type    : 'GET',
        dataType: 'json',
        success : function (res) {
            let html = '<option value="">Pilih</option>';

            res.forEach(function (item) {
                html += `<option value="${item.tahun}">${item.tahun}</option>`;
            });

            $('#tahun').html(html);
        }
    });
}

// Fungsi load bulan
function loadBulan() {
    let bulan = [
        { val: "01", text: "Januari" },
        { val: "02", text: "Februari" },
        { val: "03", text: "Maret" },
        { val: "04", text: "April" },
        { val: "05", text: "Mei" },
        { val: "06", text: "Juni" },
        { val: "07", text: "Juli" },
        { val: "08", text: "Agustus" },
        { val: "09", text: "September" },
        { val: "10", text: "Oktober" },
        { val: "11", text: "November" },
        { val: "12", text: "Desember" }
    ];

    let html = '<option value="">Pilih</option>';

    bulan.forEach(function (item) {
        html += `<option value="${item.val}">${item.text}</option>`;
    });

    $('#bulan').html(html);
}

$(document).ready(function() {
    //Menampilkan Data Pada Saat Pertama Kali
    ShowGrafik();
    ShowDashboard();
    ShowPasienExisting();

    //Tombol Fiolter Grafik Di Pilih
    $('.ganti_periode_grafik').click(function(){
        $('#ModalFilterPeriodeGrafik').modal('show');
    });


    // Saat periode berubah
    $('#periode').change(function () {
        let periode = $(this).val();

        // Reset
        $('#tahun').html('<option value="">Loading...</option>');
        $('#bulan').html('<option value="">Pilih</option>');

        if (periode === "Tahunan") {

            // Disable bulan
            $('#bulan').prop('disabled', true);

            // Ambil data tahun via AJAX
            loadTahun();

        } else if (periode === "Bulanan") {

            // Enable bulan
            $('#bulan').prop('disabled', false);

            // Load tahun
            loadTahun();

            // Load bulan statis
            loadBulan();
        }
    });

    // Ketika Filter Di Submit
    $('#ProsesFilterPeriodeGrafik').submit(function () {
        $('#ModalFilterPeriodeGrafik').modal('hide');
        ShowGrafik();
    });

    // Menampilkan Filter Pasien Exiting
    $('.filter_pasien_existing').click(function(){
        $('#ModalPasienExisting').modal('show');
    });

    // Proses Filter Pasien Existing
    $('#ProsesFilterPasienExisting').click(function(){
        ShowPasienExisting(0);
        $('#ModalPasienExisting').modal('hide');
    });

    // Pagging pasien Existing
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page').val(next_page);
        ShowPasienExisting(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page').val(next_page);
        ShowPasienExisting(0);
    });
    
    // Cleanup untuk semua modal saat ditutup
    $(document).on('hidden.bs.modal', '.modal', function () {
        setTimeout(function () {
            if (!$('.modal.show').length) {
                $('body').removeClass('modal-open').css({
                    'overflow': 'auto',
                    'padding-right': ''
                });

                $('.modal-backdrop').remove();
            }
        }, 100);
    });

});