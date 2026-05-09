<?php
    header('Content-Type: application/json; charset=utf-8');

    // Koneksi
    include "../../_Config/Connection.php";

    // Ambil keyword
    $keyword = isset($_POST['keyword'])
        ? trim($_POST['keyword'])
        : '';

    // =====================================================
    // QUERY DEFAULT (20 PASIEN PERTAMA)
    // =====================================================
    if (empty($keyword)) {

        $stmt = mysqli_prepare($Conn, "
            SELECT 
                id_pasien,
                nama,
                nik,
                tanggal_lahir
            FROM pasien
            WHERE status = 'Active'
            ORDER BY nama ASC
            LIMIT 20
        ");

    } else {

        // =====================================================
        // QUERY PENCARIAN
        // =====================================================
        $search = "%" . $keyword . "%";

        $stmt = mysqli_prepare($Conn, "
            SELECT 
                id_pasien,
                nama,
                nik,
                tanggal_lahir
            FROM pasien
            WHERE status = 'Active'
            AND (
                nama LIKE ? OR
                nik LIKE ? OR
                id_pasien LIKE ?
            )
            ORDER BY nama ASC
            LIMIT 20
        ");

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $search,
            $search,
            $search
        );
    }

    // =====================================================
    // EKSEKUSI QUERY
    // =====================================================
    mysqli_stmt_execute($stmt);

    $result_query = mysqli_stmt_get_result($stmt);

    // =====================================================
    // FORMAT SELECT2
    // =====================================================
    $result = [];

    while ($row = mysqli_fetch_assoc($result_query)) {

        // Format tanggal lahir
        $tgl = '-';

        if (!empty($row['tanggal_lahir'])) {
            $tgl = date('d/m/Y', strtotime($row['tanggal_lahir']));
        }

        // Text dropdown
        $text = $row['id_pasien']
              . ' | '
              . $row['nama']
              . ' | '
              . ($row['nik'] ?? '-')
              . ' | '
              . $tgl;

        $result[] = [
            "id"   => $row['id_pasien'],
            "text" => $text
        ];
    }

    mysqli_stmt_close($stmt);

    // =====================================================
    // OUTPUT JSON
    // =====================================================
    echo json_encode($result);
?>