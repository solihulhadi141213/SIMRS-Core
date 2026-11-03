// =========================================================================================
/** BLOCK FUNCTION */
// Semua Function Disimpan pada Block Ini
// =========================================================================================

// Menampilkan Grafik Log (ditingkatkan dengan AJAX ke GrafikLog.php)
// Menampilkan Grafik Log (ditingkatkan dengan AJAX ke GrafikLog.php)
function showLogGraph() {
    
    // Pastikan form #ProsesPeriodeGrafik ada di DOM sebelum diserialize
    var $form = $('#ProsesPeriodeGrafik');
    var ProsesPeriodeGrafik = $form.length > 0 ? $form.serialize() : '';

    // Mengirimkan Data Dari Form Dengan AJAX ke Backend PHP 'GrafikLog.php'
    $.ajax({
        url     : '_Page/Log/GrafikLog.php',
        method  : 'POST',
        data    : ProsesPeriodeGrafik,
        dataType: 'json',
        success : function(response) {
            
            // Inisialisasi ApexChart
            var chartOptions = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    width: 1,
                    colors: ['#fff']
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: true
                },
                colors: ['#2b5b84'],
                
                // Mendefinisikan data series untuk nilai Y pada grafik batang
                series: [{
                    name: 'Jumlah Log',
                    data: response.length > 0 ? response.map(function(item) { return item.y; }) : [0]
                }],

                xaxis: {
                    categories: response.length > 0 ? response.map(function(item) { return item.x; }) : ['Tidak ada data']
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Data'
                    }
                },
                tooltip: {
                    enabled: true,
                    theme: 'light',
                    followMouse: true,
                    x: {
                        show: true
                    },
                    y: {
                        title: {
                            text: 'Jumlah'
                        }
                    }
                }
            };

            // Destroy chart if already exists
            if (typeof myChart !== 'undefined' && myChart !== null) {
                myChart.destroy();
            }

            // Render chart
            var chartContainer = $('#grafik_aktivitas')[0];
            if (chartContainer) {
                myChart = new ApexCharts(chartContainer, chartOptions);
                myChart.render();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching graph data:', error);
            console.error('Raw Response:', xhr.responseText);
            
            var chartContainer = $('#grafik_aktivitas')[0];
            if (chartContainer) {
                chartContainer.innerHTML = '<div class="alert alert-danger">Gagal memuat data grafik. Cek console untuk detail.</div>';
            }
        }
    });
}

// Menampilkan Tabel Log
function showLogTable() {
    var ProsesFilterLog = $('#ProsesFilterLog').serialize();
    let target = $('#tabel_log');

    target.addClass('blur-loading');

    $.ajax({
        type   : 'POST',
        url    : '_Page/Log/TabelLog.php',
        data   : ProsesFilterLog,
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

// Menampilkan List Log Pengguna
function showLogPengguna() {
    var ProsesFilterPengguna = $('#ProsesFilterPengguna').serialize();
    let target = $('#list_pengguna');

    target.addClass('blur-loading');

    $.ajax({
        type   : 'POST',
        url    : '_Page/Log/ListLogPengguna.php',
        data   : ProsesFilterPengguna,
        success: function(data) {
            let wrapper     = $('<div>').html(data);
            let rowHtml     = wrapper.find('tr');
            let firstRow    = rowHtml.first();
            let pageCount   = parseInt(firstRow.attr('data-page-count'), 10);
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

                $('#page_info_pengguna').html(currentPage + ' / ' + pageCount);
                $('#previous_page_pengguna').prop('disabled', currentPage <= 1);
                $('#next_page_pengguna').prop('disabled', currentPage <= 0 || currentPage >= pageCount);

                setTimeout(function () {
                    target.removeClass('blur-loading');
                }, 200);
            }, 150);
        }
    });
}

// Menampilkan List Log Kategori
function showLogKategori() {
    var ProsesFilterKategori = $('#ProsesFilterKategori').serialize();
    let target               = $('#list_kategori');

    target.addClass('blur-loading');

    $.ajax({
        type   : 'POST',
        url    : '_Page/Log/ListLogKategori.php',
        data   : ProsesFilterKategori,
        success: function(data) {
            let wrapper     = $('<div>').html(data);
            let rowHtml     = wrapper.find('tr');
            let firstRow    = rowHtml.first();
            let pageCount   = parseInt(firstRow.attr('data-page-count'), 10);
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

                $('#page_info_kategori').html(currentPage + ' / ' + pageCount);
                $('#previous_page_kategori').prop('disabled', currentPage <= 1);
                $('#next_page_kategori').prop('disabled', currentPage <= 0 || currentPage >= pageCount);

                setTimeout(function () {
                    target.removeClass('blur-loading');
                }, 200);
            }, 150);
        }
    });
}


// =========================================================================================
/** BLOCK EVENT HANDLER */
// Semua Event Handler Disimpan pada Block Ini
// =========================================================================================

$(document).ready(function () {
  
    // Menampilkan Data Pertama Kali Saat Halaman Log Dibuka
    showLogGraph();
    showLogTable();
    showLogPengguna();
    showLogKategori();


    // -----------------------------------------------------
    // GRAFIK
    // -----------------------------------------------------
    // Ketika 'periode_data' diubah, akan mengubah 'FormLanjutanPeriodeGrafik' sesuai dengan pilihan yang dipilih.
    var periode_data = $('#periode_data');
    
    // Mengirimkan 'periode_data' ke _Page/Log/FormPeriode.php untuk mendapatkan Form Lanjutan Periode Grafik yang sesuai dengan pilihan yang dipilih.
    periode_data.change(function() {
        var selectedValue = $(this).val();
        $.ajax({
            url    : '_Page/Log/FormPeriode.php',
            method : 'POST',
            data   : { periode_data: selectedValue },
            success: function(response) {
                $('#FormLanjutanPeriodeGrafik').html(response);
            }
        });
    });

    $('#ModalPeriodeGrafik').on('shown.bs.modal', function () {
        $('#periode_data').trigger('change');
    });

    // Submit Form Periode Grafik
    $('#ProsesPeriodeGrafik').on('submit', function(e) {
        e.preventDefault();

        // Tutup Modal
        $('#ModalPeriodeGrafik').modal('hide');

        // Render Ulang Grafik
        showLogGraph();
    });

    // -----------------------------------------------------
    // TABEL AKTIVITAS
    // -----------------------------------------------------
    
    // Keyword By
    $('#keyword_by').change(function(){
        var keyword_by = $('#keyword_by').val();
        $.ajax({
            type 	    : 'POST',
            url 	    : '_Page/Log/FormFilter.php',
            data        : {keyword_by: keyword_by},
            success     : function(data){
                $('#FormFilter').html(data);
            },
            error: function () {
                $('#FormFilter').html('<div class="alert alert-danger mb-0">Filter gagal dimuat.</div>');
            }
        });
    });

    // Submit Filter
    $('#ProsesFilterLog').submit(function(){
        $('#page_filter_log').val("1");
        showLogTable();
        $('#ModalFilterLog').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page', function() {
        var page_now = parseInt($('#page_filter_log').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter_log').val(next_page);
        showLogTable(0);
    });
    $(document).on('click', '#previous_page', function() {
        var page_now = parseInt($('#page_filter_log').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter_log').val(next_page);
        showLogTable(0);
    });

    // -----------------------------------------------------
    // DETAIL LOG
    // -----------------------------------------------------

    // Ketika tombol detail log diklik, tampilkan modal detail
    $(document).on('click', '.modal_detail_log', function() {
        var id_log = $(this).data('id');
        
        $.ajax({
            type: 'POST',
            url: '_Page/Log/FormDetailLog.php',
            data: { id_log: id_log },
            success: function(response) {
                $('#FormDetailLog').html(response);
                $('#ModalDetailLog').modal('show');
            },
            error: function() {
                $('#FormDetailLog').html('<div class="alert alert-danger mb-0">Gagal memuat detail log.</div>');
                $('#ModalDetailLog').modal('show');
            }
        });
    });

    // -----------------------------------------------------
    // LIST PENGGUNA
    // -----------------------------------------------------
    
    // Submit Filter
    $('#ProsesFilterPengguna').submit(function(){
        $('#page_filter_pengguna').val("1");
        showLogPengguna();
        $('#ModalFilterPengguna').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page_pengguna', function() {
        var page_now = parseInt($('#page_filter_pengguna').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter_pengguna').val(next_page);
        showLogPengguna(0);
    });
    $(document).on('click', '#previous_page_pengguna', function() {
        var page_now = parseInt($('#page_filter_pengguna').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter_pengguna').val(next_page);
        showLogPengguna(0);
    });

    // -----------------------------------------------------
    // LIST KATEGORI
    // -----------------------------------------------------
    
    // Submit Filter
    $('#ProsesFilterKategori').submit(function(){
        $('#page_filter_kategori').val("1");
        showLogKategori();
        $('#ModalFilterKategori').modal('hide');
    });

    //Pagging
    $(document).on('click', '#next_page_kategori', function() {
        var page_now = parseInt($('#page_filter_kategori').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page_filter_kategori').val(next_page);
        showLogKategori(0);
    });
    $(document).on('click', '#previous_page_kategori', function() {
        var page_now = parseInt($('#page_filter_kategori').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page_filter_kategori').val(next_page);
        showLogKategori(0);
    });

});