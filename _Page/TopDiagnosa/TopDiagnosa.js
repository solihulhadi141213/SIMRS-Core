$(document).ready(function () {
    // Event saat tombol "Tampilkan" diklik
    $('#TampilkanDataTopDiagnosa').on('click', function () {
        // Ambil nilai dari input
        let periode_1 = $('#periode_1').val();
        let periode_2 = $('#periode_2').val();
        let tujuan = $('#tujuan').val();
        let kategori = $('#kategori').val();

        // Kirim data via AJAX ke PHP
        $.ajax({
            url: '_Page/TopDiagnosa/TabelTopDiagnosa.php',
            type: 'POST',
            data: {
                periode_1: periode_1,
                periode_2: periode_2,
                tujuan: tujuan,
                kategori: kategori
            },
            beforeSend: function () {
                $('#TabelTopDiagnosa').html('<tr><td colspan="7" align="center"><i>Loading...</i></td></tr>');
            },
            success: function (data) {
                $('#TabelTopDiagnosa').html(data);
            },
            error: function () {
                $('#TabelTopDiagnosa').html('<tr><td colspan="7" align="center"><i>Terjadi kesalahan dalam memuat data</i></td></tr>');
            }
        });
    });

    // Event saat tombol "Export" diklik
    $('#ExportDataTopDiagnosa').on('click', function () {
        // Ambil nilai dari input
        let periode_1 = $('#periode_1').val();
        let periode_2 = $('#periode_2').val();
        let tujuan = $('#tujuan').val();
        let kategori = $('#kategori').val();

        // Buat URL dengan query string
        let url = '_Page/TopDiagnosa/ExportTopDiagnosa.php' +
            '?periode_1=' + encodeURIComponent(periode_1) +
            '&periode_2=' + encodeURIComponent(periode_2) +
            '&tujuan=' + encodeURIComponent(tujuan) +
            '&kategori=' + encodeURIComponent(kategori);

        // Buka tab baru
        window.open(url, '_blank');
    });
});