<?php
    // Menyediakan baris tabel antrean sesuai filter, urutan, dan batas halaman dari modal.
    header('Content-Type: text/html; charset=utf-8');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    // Batasi endpoint tabel untuk sesi aktif dan request POST.
    if (empty($SessionIdAkses)) {
        http_response_code(401);
        echo '<tr><td colspan="13" class="text-center text-danger">Sesi berakhir. Silakan login kembali.</td></tr>';
        exit;
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo '<tr><td colspan="13" class="text-center text-danger">Metode request tidak valid.</td></tr>';
        exit;
    }

    // Batasi pagination serta tentukan kolom pengurutan dan pencarian dari daftar yang diizinkan.
    $page = max(1, (int) ($_POST['page_filter'] ?? 1));
    $limit = (int) ($_POST['batas'] ?? 10);
    $limit = in_array($limit, [10, 25, 50, 100], true) ? $limit : 10;
    $offset = ($page - 1) * $limit;
    $keyword = trim((string) ($_POST['keyword'] ?? ''));
    $keywordBy = (string) ($_POST['keyword_by'] ?? '');
    $orderBy = (string) ($_POST['OrderBy'] ?? 'datetime_creat');
    $sort = strtoupper((string) ($_POST['ShortBy'] ?? 'DESC')) === 'ASC' ? 'ASC' : 'DESC';

    $allowedOrder = [
        'datetime_creat' => 'a.datetime_creat',
        'nama_pasien' => 'a.nama_pasien',
        'kode_booking' => 'a.kode_booking',
        'tanggal_kunjungan' => 'a.tanggal_kunjungan',
        'nama_poliklinik' => 'a.nama_poliklinik',
        'nama_dokter' => 'a.nama_dokter',
        'jadwal' => "CONCAT(TIME_FORMAT(jadwal.jam_mulai, '%H:%i'), ' - ', TIME_FORMAT(jadwal.jam_selesai, '%H:%i'))",
        'no_antrian' => 'a.no_antrian',
        'id_pasien' => 'a.id_pasien',
        'id_kunjungan' => 'a.id_kunjungan',
        'status_antrian' => 'a.status_antrian',
        'sumber_antrian' => 'a.sumber_antrian',
    ];
    $orderColumn = $allowedOrder[$orderBy] ?? 'a.datetime_creat';

    $allowedSearch = [
        'nama_pasien' => 'a.nama_pasien',
        'kode_booking' => 'a.kode_booking',
        'nama_poliklinik' => 'a.nama_poliklinik',
        'nama_dokter' => 'a.nama_dokter',
        'jadwal' => "CONCAT(TIME_FORMAT(jadwal.jam_mulai, '%H:%i'), ' - ', TIME_FORMAT(jadwal.jam_selesai, '%H:%i'))",
        'no_antrian' => 'a.no_antrian',
        'id_pasien' => 'a.id_pasien',
        'id_kunjungan' => 'a.id_kunjungan',
        'sumber_antrian' => 'a.sumber_antrian',
        'status_antrian' => 'a.status_antrian',
    ];
    // Susun kondisi pencarian terikat parameter agar nilai filter tidak menjadi bagian SQL.
    $where = [];
    $params = [];
    $types = '';

    // Tanggal daftar memakai rentang UTC, tanggal kunjungan memakai tanggal kalender, kolom lain teks.
    if ($keyword !== '') {
        if ($keywordBy === 'datetime_creat') {
            $date = DateTime::createFromFormat('Y-m-d', $keyword);
            if (!$date || $date->format('Y-m-d') !== $keyword) {
                echo '<tr data-page-count="0" data-current-page="0"><td colspan="13" class="text-center text-muted">Pilih tanggal yang valid untuk filter.</td></tr>';
                exit;
            }
            $utcStart = (string) ($_POST['utc_start'] ?? '');
            $utcEnd = (string) ($_POST['utc_end'] ?? '');
            $startDateTime = DateTime::createFromFormat('!Y-m-d H:i:s', $utcStart);
            $endDateTime = DateTime::createFromFormat('!Y-m-d H:i:s', $utcEnd);
            if (!$startDateTime || !$endDateTime || $startDateTime->format('Y-m-d H:i:s') !== $utcStart || $endDateTime->format('Y-m-d H:i:s') !== $utcEnd || $endDateTime <= $startDateTime) {
                echo '<tr data-page-count="0" data-current-page="0"><td colspan="13" class="text-center text-muted">Rentang tanggal lokal tidak valid. Pilih ulang tanggal.</td></tr>';
                exit;
            }
            $where[] = 'a.datetime_creat >= ? AND a.datetime_creat < ?';
            $params[] = $utcStart;
            $params[] = $utcEnd;
            $types .= 'ss';
        } elseif ($keywordBy === 'tanggal_kunjungan') {
            $date = DateTime::createFromFormat('Y-m-d', $keyword);
            if (!$date || $date->format('Y-m-d') !== $keyword) {
                echo '<tr data-page-count="0" data-current-page="0"><td colspan="13" class="text-center text-muted">Pilih tanggal yang valid untuk filter.</td></tr>';
                exit;
            }
            $where[] = 'a.tanggal_kunjungan = ?';
            $params[] = $keyword;
            $types .= 's';
        } elseif (isset($allowedSearch[$keywordBy])) {
            $where[] = $allowedSearch[$keywordBy] . ' LIKE ?';
            $params[] = '%' . $keyword . '%';
            $types .= 's';
        } else {
            $where[] = "(a.nama_pasien LIKE ? OR a.kode_booking LIKE ? OR a.nama_poliklinik LIKE ? OR a.nama_dokter LIKE ? OR CAST(a.no_antrian AS CHAR) LIKE ? OR CAST(a.id_pasien AS CHAR) LIKE ? OR CAST(a.id_kunjungan AS CHAR) LIKE ? OR a.status_antrian LIKE ? OR a.sumber_antrian LIKE ? OR CONCAT(TIME_FORMAT(jadwal.jam_mulai, '%H:%i'), ' - ', TIME_FORMAT(jadwal.jam_selesai, '%H:%i')) LIKE ?)";
            $search = '%' . $keyword . '%';
            array_push($params, $search, $search, $search, $search, $search, $search, $search, $search, $search, $search);
            $types .= 'ssssssssss';
        }
    }
    $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    // Hitung jumlah hasil terlebih dahulu untuk menentukan jumlah halaman.
    $countSql = "SELECT COUNT(*) AS total FROM antrian a LEFT JOIN jadwal_dokter jadwal ON jadwal.id_jadwal = a.id_jadwal $whereSql";
    $stmtCount = mysqli_prepare($Conn, $countSql);
    if (!$stmtCount) {
        error_log('Antrian table: failed to prepare count query: ' . mysqli_error($Conn));
        http_response_code(500);
        echo '<tr><td colspan="13" class="text-center text-danger">Gagal menyiapkan pencarian antrian.</td></tr>';
        exit;
    }
    if ($params) {
        mysqli_stmt_bind_param($stmtCount, $types, ...$params);
    }
    if (!mysqli_stmt_execute($stmtCount)) {
        error_log('Antrian table: failed to execute count query: ' . mysqli_stmt_error($stmtCount));
        mysqli_stmt_close($stmtCount);
        http_response_code(500);
        echo '<tr><td colspan="13" class="text-center text-danger">Gagal mengambil jumlah data antrian.</td></tr>';
        exit;
    }
    $countResult = mysqli_stmt_get_result($stmtCount);
    $total = (int) (mysqli_fetch_assoc($countResult)['total'] ?? 0);
    mysqli_stmt_close($stmtCount);
    $pageCount = $total > 0 ? (int) ceil($total / $limit) : 0;

    if ($pageCount > 0 && $page > $pageCount) {
        $page = $pageCount;
        $offset = ($page - 1) * $limit;
    }

    // Ambil baris antrean dan label relasi yang diperlukan untuk tabel serta menu tindakan.
    $sql = "
        SELECT
            a.id_antrian, a.id_pasien, a.id_kunjungan, a.id_poliklinik,
            a.id_dokter, a.id_jadwal, a.no_antrian, a.kode_booking,
            a.nama_pasien, a.nama_poliklinik, a.nama_dokter,
            a.tanggal_kunjungan, a.datetime_creat, a.status_antrian,
            a.sumber_antrian, a.pembayaran, p.id_pasien AS pasien_terdaftar,
            k.id_kunjungan AS kunjungan_terdaftar,
            poli.id_poliklinik AS poliklinik_terdaftar,
            dokter.id_dokter AS dokter_terdaftar,
            jadwal.id_jadwal AS jadwal_terdaftar,
            jadwal.jam_mulai, jadwal.jam_selesai
        FROM antrian a
        LEFT JOIN pasien p ON p.id_pasien = a.id_pasien
        LEFT JOIN kunjungan k ON k.id_kunjungan = a.id_kunjungan
        LEFT JOIN poliklinik poli ON poli.id_poliklinik = a.id_poliklinik
        LEFT JOIN dokter ON dokter.id_dokter = a.id_dokter
        LEFT JOIN jadwal_dokter jadwal ON jadwal.id_jadwal = a.id_jadwal
        $whereSql
        ORDER BY $orderColumn $sort, a.id_antrian DESC
        LIMIT ?, ?
    ";
    $stmt = mysqli_prepare($Conn, $sql);
    if (!$stmt) {
        error_log('Antrian table: failed to prepare data query: ' . mysqli_error($Conn));
        http_response_code(500);
        echo '<tr><td colspan="13" class="text-center text-danger">Gagal menyiapkan daftar antrian.</td></tr>';
        exit;
    }
    $dataParams = $params;
    $dataParams[] = $offset;
    $dataParams[] = $limit;
    $dataTypes = $types . 'ii';
    mysqli_stmt_bind_param($stmt, $dataTypes, ...$dataParams);
    if (!mysqli_stmt_execute($stmt)) {
        error_log('Antrian table: failed to execute data query: ' . mysqli_stmt_error($stmt));
        mysqli_stmt_close($stmt);
        http_response_code(500);
        echo '<tr><td colspan="13" class="text-center text-danger">Gagal mengambil daftar antrian.</td></tr>';
        exit;
    }
    $result = mysqli_stmt_get_result($stmt);

    if ($total === 0) {
        echo '<tr data-page-count="0" data-current-page="0"><td colspan="13" class="text-center text-danger">Data antrian tidak ditemukan.</td></tr>';
        mysqli_stmt_close($stmt);
        exit;
    }

    // Siapkan escaping, warna status, dan format timestamp sebelum mencetak baris tabel.
    $escape = static fn($value): string => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    $statusColors = [
        'Terdaftar' => 'warning',
        'Batal' => 'danger',
        'Checkin' => 'primary',
        'Panggil Admisi' => 'info',
        'Tunggu Poli' => 'secondary',
        'Layanan Poli' => 'primary',
        'Tunggu Farmasi' => 'secondary',
        'Layanan Farmasi' => 'primary',
        'Selesai' => 'success',
    ];
    $number = $offset + 1;
    $first = true;
    // Cetak satu baris per antrean; nama relasi hanya menjadi tautan jika datanya masih tersedia.
    while ($row = mysqli_fetch_assoc($result)) {
        $id           = (int) $row['id_antrian'];
        $idPasien     = (int) ($row['id_pasien'] ?? 0);
        $nama_pasien  = (string) ($row['nama_pasien'] ?? '-');
        $kode_booking = (string) ($row['kode_booking'] ?? '-');
        $idKunjungan  = (int) ($row['id_kunjungan'] ?? 0);
        $idPoliklinik = (int) ($row['poliklinik_terdaftar'] ?? 0);
        $idDokter     = (int) ($row['dokter_terdaftar'] ?? 0);
        $idJadwal     = (int) ($row['jadwal_terdaftar'] ?? 0);
        $status       = (string) $row['status_antrian'];
        $badgeColor   = $statusColors[$status] ?? 'dark';
        $schedule     = $idJadwal
            ? substr((string) $row['jam_mulai'], 0, 5) . ' - ' . substr((string) $row['jam_selesai'], 0, 5)
            :  '-';
        $dateCreated = str_replace(' ', 'T', (string) $row['datetime_creat']) . 'Z';
        $dateVisit   = strtotime((string) $row['tanggal_kunjungan']) ? date('d/m/Y', strtotime((string) $row['tanggal_kunjungan'])) : '-';
        $attributes  = $first ? ' data-page-count="' . $pageCount . '" data-current-page="' . $page . '"' : '';
        $first       = false;

        // Routing Status Antrian
        $status_label = '<span class="badge bg-'.$badgeColor.'">'.$status.'</span>';

        // Routing apakah sudah memiliki id_pasien
        if(empty($idPasien)) {
            $class_nama = '
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalPendaftaranPasien" data-id="' . $id . '" title="Pasien Baru, klik untuk mendaftarkan pasien">
                    <small  class="text-danger">
                    <i class="bi bi-plus"></i> ' . $nama_pasien . '
                    </small>
                </a>
            ';
        } else {
            $class_nama = '
                <a href="javascript:void(0);" class="modal_detail_pasien" data-id="' . $idPasien . '" title="Pasien Lama, klik untuk melihat detail pasien">
                    <small  class="text-muted">
                        <i class="bi bi-check-circle"></i> ' . $nama_pasien . '
                    </small>
                </a>
            ';
        }

        // Routing Apakah sudah memiliki id_kunjungan
        if(empty($idKunjungan)) {
            $class_kunjungan = '
                <a href="javascript:void(0);" class="modal_pendaftaran_kunjungan" data-id="' . $id . '" title="Belum terdaftar pada kunjungan, klik untuk menambahkan kunjungan">
                    <small  class="text-danger">
                        <i class="bi bi-plus"></i> ' . $dateVisit . '
                    </small>
                </a>
            ';
        } else {
            $class_kunjungan = '
                <a href="javascript:void(0);" class="modal_detail_kunjungan"  data-id="' . $idKunjungan . '" title="Klik untuk melihat detail kunjungan">
                    <small  class="text-muted">
                        <i class="bi bi-check-circle"></i> ' . $dateVisit . '
                    </small>
                </a>
            ';
        }
        // Menampilkan Baris Tabel
        echo '
            <tr>
                <td align="center"><small  class="text-muted">' . $number++ . '</small></td>
                <td>
                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="' . $id . '">
                        <small  class="text-primary text-decoration-underline">' . $kode_booking . '</small>
                    </a>
                </td>
                <td>' . $class_nama . '</td>
                <td>' . $class_kunjungan . '</td>
                <td><small class="text-muted">' . $row['nama_poliklinik'] . '</small></td>
                <td><small class="text-muted">' . $row['nama_dokter'] . '</small></td>
                <td><small class="text-muted">' . $row['sumber_antrian']. '</small></td>
                <td class="text-center"><small class="text-muted">' . $status_label . '</small></td>
                <td class="icon-btn text-center">
                    <button type="button" class="btn btn-md btn-secondary btn-floating" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalDetail" data-id="' . $id . '">
                                <i class="bi bi-info-circle"></i> Detail Antrian
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#ModalEdit" data-id="' . $id . '">
                                <i class="bi bi-pencil"></i> Edit Antrian
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#ModalHapus" data-id="' . $id . '">
                                <i class="bi bi-trash"></i> Hapus Antrian
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        ';
    }
    mysqli_stmt_close($stmt);
?>
