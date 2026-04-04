<?php
     //Zona Waktu
    date_default_timezone_set('Asia/Jakarta');

    // Connection
    include "../../_Config/Connection.php";
    
    // Simrs Function
    include "../../_Config/SimrsFunction.php";

    // Session
    include "../../_Config/Session.php";

    // Validasi Sessi Akses
    if(empty($SessionIdAkses)){
        echo '
            <div class="alert alert-danger text-center">
                <small class="text text-danger">Sesi Akses Berakhir! Silahkan Login Ulang!</small>
            </div>
        ';
        exit;
    }

    // Validasi kategori
    if(empty($_POST['kategori'])){
        echo '
            <div class="alert alert-danger text-center">
                <small class="text text-danger">Tidak ada kategori yang dipilih!</small>
            </div>
        ';
        exit;
    }

    $kategori = mysqli_real_escape_string($Conn, $_POST['kategori']);

    // Ambil data fitur + status akses dalam satu query (hindari N+1)
    $query = mysqli_query($Conn, "
        SELECT 
            af.id_akses_fitur,
            af.nama_fitur,
            af.kode,
            af.keterangan,
            CASE WHEN aa.id_akses_acc IS NULL THEN 0 ELSE 1 END AS punya_akses
        FROM akses_fitur af
        LEFT JOIN akses_acc aa 
            ON aa.id_akses_fitur = af.id_akses_fitur
            AND aa.id_akses = '$SessionIdAkses'
        WHERE af.kategori = '$kategori'
        ORDER BY af.nama_fitur ASC
    ");

    if(mysqli_num_rows($query)===0){
        echo '
            <div class="alert alert-danger text-center">
                <small class="text text-danger">Tidak ada fitur yang ditemukan!</small>
            </div>
        ';
        exit;
    }

    echo '<ol class="list-group list-group-numbered mb-0">';
    while ($data = mysqli_fetch_array($query)) {
        $nama_fitur     = $data['nama_fitur'];
        $kode           = $data['kode'];
        $keterangan     = $data['keterangan'];
        $punyaAkses     = (int)$data['punya_akses'] === 1;

        $label_fitur = $punyaAkses
            ? '<span class="text-success"><i class="bi bi-check-circle"></i></span>'
            : '<span class="text-danger"><i class="bi bi-x-circle"></i></span>';

        echo '
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">'.$nama_fitur.'</div>
                    <small class="text-muted">'.$keterangan.'</small>
                </div>
                <div class="text-end" title="'.$kode.'">'.$label_fitur.'</div>
            </li>
        ';
    }
    echo '</ol>';
?>
