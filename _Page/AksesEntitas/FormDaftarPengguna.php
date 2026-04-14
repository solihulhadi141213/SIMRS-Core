<?php
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";

    // Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // ===============================
    // VALIDASI SESSION
    // ===============================
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger text-center">
                <small>Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // ===============================
    // VALIDASI ID
    // ===============================
    if (empty($_POST['id_akses_entitas'])) {
        echo '
            <div class="alert alert-danger text-center">
                <small>ID Entitas Tidak Boleh Kosong!</small>
            </div>
        ';
        exit;
    }

    $id_akses_entitas = intval($_POST['id_akses_entitas']);


    // ===============================
    // AMBIL DATA ENTITAS
    // ===============================
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

    $data = $result->fetch_assoc();

    $akses      = $data['akses'];
    $deskripsi  = $data['deskripsi'];

    $stmt->close();


    // ===============================
    // HEADER DATA ENTITAS
    // ===============================
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
            <small><b>Daftar Pengguna</b></small>
        </div>
    ';


    // ===============================
    // AMBIL DAFTAR PENGGUNA
    // ===============================
    $stmt_user = $Conn->prepare("
        SELECT id_akses, nama, email
        FROM akses
        WHERE id_akses_entitas = ?
        ORDER BY nama ASC
    ");

    $stmt_user->bind_param("i", $id_akses_entitas);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows == 0) {
        echo '
            <div class="alert alert-warning text-center">
                <small>Belum ada pengguna pada entitas ini.</small>
            </div>
        ';
        exit;
    }


    // ===============================
    // TAMPILKAN LIST USER
    // ===============================
    echo '
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
    ';

    $no = 1;

    while ($user = $result_user->fetch_assoc()) {
        echo '
            <tr>
                <td class="text-center">' . $no . '</td>
                <td>
                    <small class="fw-semibold">' . htmlspecialchars($user['nama']) . '</small>
                </td>
                <td>
                    <small class="text-muted">' . htmlspecialchars($user['email']) . '</small>
                </td>
            </tr>
        ';
        $no++;
    }

    echo '
                </tbody>
            </table>
        </div>
    ';

    $stmt_user->close();
?>