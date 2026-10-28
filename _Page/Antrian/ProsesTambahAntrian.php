<?php
    // Menangani penambahan atau perubahan antrean beserta validasi dan pencatatan aktivitas.
    header('Content-Type: application/json; charset=utf-8');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";

    /** Mengirim respons JSON error dengan kode HTTP yang sesuai lalu menghentikan proses. */
    function antrianJsonError(string $message, int $statusCode = 400): void
    {
        http_response_code($statusCode);
        echo json_encode(['status' => 'error', 'message' => $message], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Periksa sesi dan metode request sebelum memproses nilai dari form.
    if (empty($SessionIdAkses)) {
        antrianJsonError('Sesi berakhir. Silakan login kembali.', 401);
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        antrianJsonError('Metode request tidak valid.', 405);
    }

    // Ambil nilai form dan normalisasi teks agar validasi memakai bentuk yang konsisten.
    $idAntrian = (int) ($_POST['id_antrian'] ?? 0);
    $isNewAntrian = $idAntrian === 0;
    $idPasien = (int) ($_POST['id_pasien'] ?? 0);
    $idPoliklinik = (int) ($_POST['id_poliklinik'] ?? 0);
    $idJadwal = (int) ($_POST['id_jadwal'] ?? 0);
    $modePasien = (string) ($_POST['mode_pasien'] ?? 'lama');
    $namaPasien = trim((string) ($_POST['nama_pasien'] ?? ''));
    $gender = (string) ($_POST['gender'] ?? '');
    $nik = trim((string) ($_POST['nik'] ?? ''));
    $noBpjs = trim((string) ($_POST['no_bpjs'] ?? ''));
    $kontak = trim((string) ($_POST['kontak'] ?? ''));
    $tanggalKunjungan = trim((string) ($_POST['tanggal_kunjungan'] ?? ''));
    $pembayaran = (string) ($_POST['pembayaran'] ?? '');
    $nomorReferensi = trim((string) ($_POST['nomor_referensi'] ?? 'MANUAL'));
    $jenisReferensiInput = $_POST['jenis_referensi'] ?? '';
    $jenisReferensiInput = is_scalar($jenisReferensiInput) ? trim((string) $jenisReferensiInput) : '';
    $jenisReferensi = $jenisReferensiInput !== '' ? $jenisReferensiInput : null;
    $keluhan = trim((string) ($_POST['keluhan'] ?? ''));
    $status = (string) ($_POST['status_antrian'] ?? 'Terdaftar');
    $statusAllowed = ['Terdaftar', 'Batal', 'Checkin', 'Panggil Admisi', 'Tunggu Poli', 'Layanan Poli', 'Tunggu Farmasi', 'Layanan Farmasi', 'Selesai'];

    // Validasi relasi, jenis pasien, identitas wajib, format tanggal, dan batas panjang kolom.
    if (!$idPoliklinik || !$idJadwal) {
        antrianJsonError('Poliklinik dan jadwal dokter wajib dipilih.');
    }
    if ($modePasien === 'lama' && !$idPasien) {
        antrianJsonError('Pilih pasien yang sudah terdaftar.');
    }
    if (!in_array($modePasien, ['lama', 'baru'], true)) {
        antrianJsonError('Jenis pasien tidak valid.');
    }
    if ($modePasien === 'baru' && ($namaPasien === '' || !in_array($gender, ['Laki-laki', 'Perempuan'], true))) {
        antrianJsonError('Nama dan jenis kelamin pasien baru wajib diisi.');
    }
    if (strlen($namaPasien) > 255 || strlen($nomorReferensi) > 255) {
        antrianJsonError('Nama pasien atau nomor referensi melebihi panjang yang diizinkan.');
    }
    if (!$tanggalKunjungan || !DateTime::createFromFormat('!Y-m-d', $tanggalKunjungan) || DateTime::createFromFormat('!Y-m-d', $tanggalKunjungan)->format('Y-m-d') !== $tanggalKunjungan) {
        antrianJsonError('Tanggal rencana kunjungan tidak valid.');
    }
    if (!in_array($pembayaran, ['UMUM', 'BPJS', 'ASURANSI'], true)) {
        antrianJsonError('Metode pembayaran tidak valid.');
    }
    if ($jenisReferensi !== null && !in_array($jenisReferensi, ['1', '2', '3', '4'], true)) {
        antrianJsonError('Jenis referensi tidak valid.');
    }
    if ($keluhan === '') {
        antrianJsonError('Keluhan wajib diisi.');
    }
    if ($nomorReferensi === '') {
        $nomorReferensi = '';
    }
    if (!$idAntrian) {
        $status = 'Terdaftar';
    }
    if (strlen($nik) > 16 || strlen($noBpjs) > 13 || strlen($kontak) > 20) {
        antrianJsonError('NIK, nomor BPJS, atau kontak melebihi panjang yang diizinkan.');
    }

    // Tentukan hari praktik dari tanggal kunjungan dan satu timestamp UTC untuk seluruh perubahan.
    $appointmentDate = DateTime::createFromFormat('!Y-m-d', $tanggalKunjungan);
    $dayNames = [
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
        'Sunday' => 'Minggu',
    ];
    $appointmentDay = $dayNames[$appointmentDate->format('l')];
    $utcNow = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
    $idDokter = 0;
    $namaDokter = '';
    $namaPoliklinik = '';

    // Mulai transaksi agar perubahan antrean, riwayat status, dan audit tetap konsisten.
    if (!mysqli_begin_transaction($Conn)) {
        antrianJsonError('Gagal memulai proses penyimpanan antrian.', 500);
    }

    try {
        // Saat mengedit, kunci baris lama agar status dan nomor antrean tidak berubah di tengah proses.
        $current = null;
        if ($idAntrian) {
            $stmtCurrent = mysqli_prepare($Conn, "SELECT id_pasien, id_jadwal, id_poliklinik, tanggal_kunjungan, no_antrian, status_antrian, kode_booking, jenis_referensi FROM antrian WHERE id_antrian = ? FOR UPDATE");
            if (!$stmtCurrent) {
                throw new RuntimeException('Gagal menyiapkan data perubahan antrian.');
            }
            mysqli_stmt_bind_param($stmtCurrent, 'i', $idAntrian);
            if (!mysqli_stmt_execute($stmtCurrent)) {
                mysqli_stmt_close($stmtCurrent);
                throw new RuntimeException('Gagal mengambil data perubahan antrian.');
            }
            $currentResult = mysqli_stmt_get_result($stmtCurrent);
            $current = mysqli_fetch_assoc($currentResult);
            mysqli_stmt_close($stmtCurrent);
            if (!$current) {
                throw new DomainException('Data antrian tidak ditemukan.');
            }
            // Form edit lama belum mengirim jenis_referensi; pertahankan nilai yang sudah tersimpan.
            if (!array_key_exists('jenis_referensi', $_POST)) {
                $jenisReferensi = $current['jenis_referensi'] !== null
                    ? (string) $current['jenis_referensi']
                    : null;
            }
            if (!in_array($status, $statusAllowed, true)) {
                throw new DomainException('Status antrian tidak valid.');
            }
        }

        // Kunci jadwal selama proses untuk mencegah nomor antrean ganda pada pendaftaran serentak.
        $selectedInactiveSchedule = $current
            && (int) $current['id_jadwal'] === $idJadwal
            && (int) $current['id_poliklinik'] === $idPoliklinik
            ? (int) $current['id_jadwal']
            : 0;
        $stmtSchedule = mysqli_prepare(
            $Conn,
            "SELECT jd.id_jadwal, jd.id_dokter, jd.id_poliklinik, jd.hari,
                    d.nama AS nama_dokter, p.poliklinik AS nama_poliklinik
            FROM jadwal_dokter jd
            INNER JOIN dokter d ON d.id_dokter = jd.id_dokter
            INNER JOIN poliklinik p ON p.id_poliklinik = jd.id_poliklinik
            WHERE jd.id_jadwal = ?
            AND jd.id_poliklinik = ?
            AND jd.hari = ?
            AND ((jd.status <> 0 AND d.status = 1 AND p.status = 1) OR jd.id_jadwal = ?)
            FOR UPDATE"
        );
        if (!$stmtSchedule) {
            throw new RuntimeException('Gagal menyiapkan validasi jadwal.');
        }
        mysqli_stmt_bind_param($stmtSchedule, 'iisi', $idJadwal, $idPoliklinik, $appointmentDay, $selectedInactiveSchedule);
        if (!mysqli_stmt_execute($stmtSchedule)) {
            mysqli_stmt_close($stmtSchedule);
            throw new RuntimeException('Gagal memeriksa jadwal dokter.');
        }
        $scheduleResult = mysqli_stmt_get_result($stmtSchedule);
        $schedule = mysqli_fetch_assoc($scheduleResult);
        mysqli_stmt_close($stmtSchedule);
        if (!$schedule) {
            throw new DomainException('Jadwal dokter tidak aktif atau tidak tersedia pada tanggal yang dipilih.');
        }
        $idDokter = (int) $schedule['id_dokter'];
        $namaDokter = (string) $schedule['nama_dokter'];
        $namaPoliklinik = (string) $schedule['nama_poliklinik'];

        // Ambil data pasien terdaftar dari basis data; pasien baru memakai identitas dari form.
        if ($modePasien === 'lama') {
            $stmtPatient = mysqli_prepare(
                $Conn,
                "SELECT id_pasien, nama, nik, no_bpjs, kontak, gender, status
                FROM pasien WHERE id_pasien = ? LIMIT 1"
            );
            if (!$stmtPatient) {
                throw new RuntimeException('Gagal menyiapkan validasi pasien.');
            }
            mysqli_stmt_bind_param($stmtPatient, 'i', $idPasien);
            if (!mysqli_stmt_execute($stmtPatient)) {
                mysqli_stmt_close($stmtPatient);
                throw new RuntimeException('Gagal memeriksa data pasien.');
            }
            $patientResult = mysqli_stmt_get_result($stmtPatient);
            $patient = mysqli_fetch_assoc($patientResult);
            mysqli_stmt_close($stmtPatient);
            if (!$patient) {
                throw new DomainException('Pasien yang dipilih tidak ditemukan.');
            }
            if ($patient['status'] !== 'Active' && (!$current || (int) $current['id_pasien'] !== $idPasien)) {
                throw new DomainException('Pasien tidak aktif dan tidak dapat digunakan untuk antrian baru.');
            }
            $namaPasien = (string) $patient['nama'];
            $gender = (string) ($patient['gender'] ?: $gender);
            $nik = (string) ($patient['nik'] ?: $nik);
            $noBpjs = (string) ($patient['no_bpjs'] ?: $noBpjs);
            $kontak = (string) ($patient['kontak'] ?: $kontak);
            if (!in_array($gender, ['Laki-laki', 'Perempuan'], true)) {
                throw new DomainException('Jenis kelamin pasien wajib dilengkapi.');
            }
            if (strlen($nik) > 16 || strlen($noBpjs) > 13 || strlen($kontak) > 20) {
                throw new DomainException('Data NIK, BPJS, atau kontak pasien melebihi batas kolom antrian.');
            }
        } else {
            $idPasien = 0;
        }

        // Cabang edit mempertahankan kode booking dan menambah riwayat bila status berubah.
        if ($idAntrian) {
            // Nomor antrean baru dihitung bila jadwal atau tanggal tujuan berubah.
            $numberChanged = (int) $current['id_jadwal'] !== $idJadwal || $current['tanggal_kunjungan'] !== $tanggalKunjungan;
            if ($numberChanged) {
                $stmtLast = mysqli_prepare($Conn, "SELECT no_antrian FROM antrian WHERE id_jadwal = ? AND tanggal_kunjungan = ? ORDER BY no_antrian DESC LIMIT 1");
                if (!$stmtLast) {
                    throw new RuntimeException('Gagal menyiapkan nomor antrian.');
                }
                mysqli_stmt_bind_param($stmtLast, 'is', $idJadwal, $tanggalKunjungan);
                if (!mysqli_stmt_execute($stmtLast)) {
                    mysqli_stmt_close($stmtLast);
                    throw new RuntimeException('Gagal menghitung nomor antrian.');
                }
                $lastResult = mysqli_stmt_get_result($stmtLast);
                $lastRow = mysqli_fetch_assoc($lastResult);
                mysqli_stmt_close($stmtLast);
                $numberQueue = (int) ($lastRow['no_antrian'] ?? 0) + 1;
            } else {
                $numberQueue = (int) $current['no_antrian'];
            }

            $stmtUpdate = mysqli_prepare(
                $Conn,
                "UPDATE antrian SET
                    id_pasien = NULLIF(?, 0), id_poliklinik = ?, id_dokter = ?, id_jadwal = ?,
                    no_antrian = ?, nama_pasien = ?, nik = NULLIF(?, ''), no_bpjs = NULLIF(?, ''),
                    kontak = NULLIF(?, ''), gender = ?, nomor_referensi = ?, jenis_referensi = ?, jenis_request = ?,
                    pembayaran = ?, keluhan = ?, nama_dokter = ?, nama_poliklinik = ?,
                    tanggal_kunjungan = ?, status_antrian = ?, update_by_id = ?, update_by_name = ?, update_at = ?
                WHERE id_antrian = ?"
            );
            if (!$stmtUpdate) {
                throw new RuntimeException('Gagal menyiapkan pembaruan antrian.');
            }
            $requestNew = $modePasien === 'baru' ? 1 : 0;
            mysqli_stmt_bind_param(
                $stmtUpdate,
                'iiiiisssssssissssssissi',
                $idPasien, $idPoliklinik, $idDokter, $idJadwal, $numberQueue,
                $namaPasien, $nik, $noBpjs, $kontak, $gender, $nomorReferensi, $jenisReferensi, $requestNew,
                $pembayaran, $keluhan, $namaDokter, $namaPoliklinik,
                $tanggalKunjungan, $status, $SessionIdAkses, $SessionNama, $utcNow, $idAntrian
            );
            if (!mysqli_stmt_execute($stmtUpdate)) {
                mysqli_stmt_close($stmtUpdate);
                throw new RuntimeException('Gagal menyimpan perubahan antrian.');
            }
            mysqli_stmt_close($stmtUpdate);

            if ($current['status_antrian'] !== $status) {
                $stmtLog = mysqli_prepare($Conn, "INSERT INTO antrian_log (id_antrian, status_antrian, datetime_rs, datetime_bpjs) VALUES (?, ?, ?, NULL)");
                if (!$stmtLog) {
                    throw new RuntimeException('Gagal menyiapkan riwayat status antrian.');
                }
                mysqli_stmt_bind_param($stmtLog, 'iss', $idAntrian, $status, $utcNow);
                if (!mysqli_stmt_execute($stmtLog)) {
                    mysqli_stmt_close($stmtLog);
                    throw new RuntimeException('Gagal mencatat riwayat status antrian.');
                }
                mysqli_stmt_close($stmtLog);
            }
            $bookingCode = (string) $current['kode_booking'];
        } else {
            // Cabang tambah membuat kode booking, nomor urut, data antrean, dan status awal.
            $stmtLast = mysqli_prepare($Conn, "SELECT no_antrian FROM antrian WHERE id_jadwal = ? AND tanggal_kunjungan = ? ORDER BY no_antrian DESC LIMIT 1");
            if (!$stmtLast) {
                throw new RuntimeException('Gagal menyiapkan nomor antrian.');
            }
            mysqli_stmt_bind_param($stmtLast, 'is', $idJadwal, $tanggalKunjungan);
            if (!mysqli_stmt_execute($stmtLast)) {
                mysqli_stmt_close($stmtLast);
                throw new RuntimeException('Gagal menghitung nomor antrian.');
            }
            $lastResult = mysqli_stmt_get_result($stmtLast);
            $lastRow = mysqli_fetch_assoc($lastResult);
            mysqli_stmt_close($stmtLast);
            $numberQueue = (int) ($lastRow['no_antrian'] ?? 0) + 1;

            $bookingCode = strtoupper(bin2hex(random_bytes(8)));
            $requestNew = $modePasien === 'baru' ? 1 : 0;
            $stmtInsert = mysqli_prepare(
                $Conn,
                "INSERT INTO antrian (
                    id_pasien, id_poliklinik, id_dokter, id_jadwal, no_antrian, kode_booking,
                    nama_pasien, nik, no_bpjs, kontak, gender, nomor_referensi, jenis_referensi, jenis_request,
                    poli_eksekutif, pembayaran, keluhan, nama_dokter, nama_poliklinik,
                    tanggal_kunjungan, datetime_creat, status_antrian, sumber_antrian, ws_bpjs
                ) VALUES (
                    NULLIF(?, 0), ?, ?, ?, ?, ?, ?, NULLIF(?, ''), NULLIF(?, ''), NULLIF(?, ''),
                    ?, ?, ?, ?, 0, ?, ?, ?, ?, ?, ?, 'Terdaftar', 'Manual', 0
                )"
            );
            if (!$stmtInsert) {
                throw new RuntimeException('Gagal menyiapkan pendaftaran antrian.');
            }
            mysqli_stmt_bind_param(
                $stmtInsert,
                'iiiiissssssssissssss',
                $idPasien, $idPoliklinik, $idDokter, $idJadwal, $numberQueue,
                $bookingCode, $namaPasien, $nik, $noBpjs, $kontak, $gender, $nomorReferensi, $jenisReferensi,
                $requestNew, $pembayaran, $keluhan, $namaDokter,
                $namaPoliklinik, $tanggalKunjungan, $utcNow
            );
            if (!mysqli_stmt_execute($stmtInsert)) {
                mysqli_stmt_close($stmtInsert);
                throw new RuntimeException('Gagal menyimpan pendaftaran antrian.');
            }
            $idAntrian = mysqli_insert_id($Conn);
            mysqli_stmt_close($stmtInsert);

            $stmtLog = mysqli_prepare($Conn, "INSERT INTO antrian_log (id_antrian, status_antrian, datetime_rs, datetime_bpjs) VALUES (?, 'Terdaftar', ?, NULL)");
            if (!$stmtLog) {
                throw new RuntimeException('Gagal menyiapkan riwayat awal antrian.');
            }
            mysqli_stmt_bind_param($stmtLog, 'is', $idAntrian, $utcNow);
            if (!mysqli_stmt_execute($stmtLog)) {
                mysqli_stmt_close($stmtLog);
                throw new RuntimeException('Gagal mencatat status awal antrian.');
            }
            mysqli_stmt_close($stmtLog);
        }

        // Catat aktivitas utama agar perubahan dapat ditelusuri melalui log aplikasi.
        $logTitle = $isNewAntrian ? 'Membuat antrian manual' : 'Mengubah data antrian';
        $logMetadata = json_encode([
            'id_antrian' => $idAntrian,
            'kode_booking' => $bookingCode,
            'no_antrian' => $numberQueue,
            'status_antrian' => $status,
        ], JSON_UNESCAPED_UNICODE);
        $stmtAudit = mysqli_prepare(
            $Conn,
            "INSERT INTO log (id_akses, datetime_log, nama_petugas, title_log, metadata_log)
            VALUES (?, ?, ?, ?, ?)"
        );
        if (!$stmtAudit || $logMetadata === false) {
            throw new RuntimeException('Gagal menyiapkan pencatatan aktivitas antrian.');
        }
        mysqli_stmt_bind_param($stmtAudit, 'issss', $SessionIdAkses, $utcNow, $SessionNama, $logTitle, $logMetadata);
        if (!mysqli_stmt_execute($stmtAudit)) {
            mysqli_stmt_close($stmtAudit);
            throw new RuntimeException('Gagal mencatat aktivitas antrian.');
        }
        mysqli_stmt_close($stmtAudit);

        // Kirim hasil sukses hanya setelah seluruh perubahan dan pencatatan ter-commit.
        if (!mysqli_commit($Conn)) {
            throw new RuntimeException('Gagal menyelesaikan penyimpanan antrian.');
        }
        echo json_encode([
            'status' => 'success',
            'message' => 'Data antrian berhasil disimpan.',
            'id_antrian' => $idAntrian,
            'kode_booking' => $bookingCode,
            'no_antrian' => $numberQueue,
        ], JSON_UNESCAPED_UNICODE);
    // Batalkan seluruh perubahan jika validasi bisnis atau proses teknis gagal.
    } catch (DomainException $error) {
        mysqli_rollback($Conn);
        antrianJsonError($error->getMessage());
    } catch (Throwable $error) {
        mysqli_rollback($Conn);
        error_log('Antrian save failed: ' . $error->getMessage());
        antrianJsonError('Terjadi kegagalan saat menyimpan antrian. Periksa log aplikasi.', 500);
    }
?>
