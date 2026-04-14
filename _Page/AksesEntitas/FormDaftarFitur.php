<?php
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Session
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi ID
    if (empty($_POST['id_akses_entitas'])) {
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Entitas Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    $id_akses_entitas = intval($_POST['id_akses_entitas']);


    // =====================================
    // AMBIL DATA ENTITAS
    // =====================================
    $stmt = $Conn->prepare("
        SELECT akses, deskripsi
        FROM akses_entitas
        WHERE id_akses_entitas = ?
    ");
    $stmt->bind_param("i", $id_akses_entitas);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Data entitas tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    $Data = $result->fetch_assoc();

    $akses      = $Data['akses'];
    $deskripsi  = $Data['deskripsi'];

    $stmt->close();


    // =====================================
    // TAMPILKAN HEADER DATA ENTITAS
    // =====================================
    echo '
        <div class="row mb-2">
            <div class="col-4"><small>Entitas Akses</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted fw-bold">' . htmlspecialchars($akses) . '</small>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-4"><small>Deskripsi</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">' . htmlspecialchars($deskripsi) . '</small>
            </div>
        </div>

        <hr>

        <div class="mb-3">
            <small><b>Daftar Fitur Yang Dapat Diakses</b></small>
        </div>
    ';


    // =====================================
    // AMBIL FITUR DENGAN JOIN
    // =====================================
    $stmt_fitur = $Conn->prepare("
        SELECT 
            af.kategori,
            af.nama_fitur,
            af.keterangan,
            af.kode
        FROM akses_entitas_acc aea
        INNER JOIN akses_fitur af 
            ON aea.id_akses_fitur = af.id_akses_fitur
        WHERE aea.id_akses_entitas = ?
        ORDER BY af.kategori ASC, af.nama_fitur ASC
    ");

    $stmt_fitur->bind_param("i", $id_akses_entitas);
    $stmt_fitur->execute();
    $result_fitur = $stmt_fitur->get_result();

    if ($result_fitur->num_rows == 0) {
        echo '
            <div class="alert alert-warning text-center">
                <small>Belum ada fitur yang diberikan pada entitas ini.</small>
            </div>
        ';
        exit;
    }


    // =====================================
    // KELOMPOKKAN BERDASARKAN KATEGORI
    // =====================================
    $fiturByKategori = [];

    while ($row = $result_fitur->fetch_assoc()) {
        $fiturByKategori[$row['kategori']][] = $row;
    }

    echo '<div class="border rounded p-3">';

    foreach ($fiturByKategori as $kategori => $fiturList) {

        echo '
            <div class="mb-3">
                <div class="fw-bold text-primary mb-2">
                    <i class="bi bi-folder2-open"></i> ' . htmlspecialchars($kategori) . '
                </div>

                <ul class="mb-0" style="padding-left: 20px;">
        ';

        foreach ($fiturList as $fitur) {
            echo '
                <li class="mb-2">
                    <small>
                        <span class="fw-semibold">' . htmlspecialchars($fitur['nama_fitur']) . '</span><br>
                        <span class="text-muted">' . htmlspecialchars($fitur['keterangan']) . '</span><br>
                        <code>' . htmlspecialchars($fitur['kode']) . '</code>
                    </small>
                </li>
            ';
        }

        echo '
                </ul>
            </div>
        ';
    }

    echo '</div>';

    $stmt_fitur->close();
?>