//Fungsi Menampilkan Data
function ShowData() {
    var ProsesFilter = $('#ProsesFilter').serialize();
    var $tabel       = $('#TabelPersediaan');

    // Tambahkan efek visual loading (opacity menurun)
    $tabel.css({
        'opacity': '0.5',
        'pointer-events': 'none',
        'transition': 'opacity 0.3s ease'
    });

    $.ajax({
        type   : 'POST',
        url    : '_Page/PersediaanFarmasi/TabelPersediaanFarmasi.php',
        data   : ProsesFilter,
        success: function(data) {
            // Ganti isi tabel tanpa mengganti elemen induk
            $tabel.html(data);

            // Kembalikan efek normal
            $tabel.css({
                'opacity': '1',
                'pointer-events': 'auto'
            });
            
            // 🔁 Re-inisialisasi tooltip setelah data dimuat
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
        error: function() {
            $tabel.html('<tr><td class="text-center" colspan="7"><small class="text-danger">Gagal Memuat, Silahkan Coba Lagi!</small></td></tr>');
            $tabel.css({
                'opacity': '1',
                'pointer-events': 'auto'
            });
        }
    });
}

function TandaiTahunAktif(){
    var tahun = $('#tahun').val();

    $('.pilih_tahun').removeClass('btn-primary').addClass('btn-secondary');

    $('.pilih_tahun').each(function(){
        if($(this).data('id') == tahun){
            $(this).removeClass('btn-secondary').addClass('btn-primary');
        }
    });
}

//Menampilkan Data Pertama Kali
$(document).ready(function() {

    //Menampilkan Data Pertama Kali
    ShowData();

    TandaiTahunAktif();

    //Pagging
    $(document).on('click', '.next_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now + 1;
        $('#page').val(next_page);
        ShowData();
    });
    $(document).on('click', '.preview_button', function() {
        var page_now = parseInt($('#page').val(), 10); // Pastikan nilai diambil sebagai angka
        var next_page = page_now - 1;
        $('#page').val(next_page);
        ShowData();
    });

    // Ketika Tahun Di Click
    $(document).on('click', '.pilih_tahun', function() {
       var tahun = $(this).data('id');
       var page = 1;
        $('#tahun').val(tahun);
        $('#page').val(page);
        ShowData();
        TandaiTahunAktif();
    });

    
});
