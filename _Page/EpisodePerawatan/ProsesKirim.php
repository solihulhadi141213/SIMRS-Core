
<?php
    header('Content-Type: application/json; charset=utf-8');

    // CONNECTION, FUNCTION & SESSION
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    date_default_timezone_set('Asia/Jakarta');

    // =====================================================
    // FUNCTION RESPONSE JSON
    // =====================================================
    function sendEpisodeOfCareResponse($response){
        echo json_encode(
            $response,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
        exit;
    }

    // =====================================================
    // VALIDASI SESSION
    // =====================================================
    if (empty($SessionIdAkses)) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Sesi Akses Sudah Berakhir! Silahkan Login Ulang!'
        ]);
    }

    // =====================================================
    // VALIDASI INPUT
    // =====================================================
    if (empty($_POST['id_episode_perawatan'])) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'ID Episode Perawatan Tidak Boleh Kosong'
        ]);
    }

    // =====================================================
    // SANITASI INPUT
    // =====================================================
    $id_episode_perawatan = validateAndSanitizeInput(
        $_POST['id_episode_perawatan']
    );

    if (!ctype_digit((string)$id_episode_perawatan)) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'ID Episode Perawatan Tidak Valid'
        ]);
    }

    // =====================================================
    // AMBIL DATA EPISODE PERAWATAN
    // =====================================================
    $sql = "SELECT
                ep.id_episode_perawatan,
                ep.kode_episode_perawatan,
                ep.IdEpisodeOfCare,
                ep.id_pasien,
                ep.id_episode_perawatan_kode,
                ep.episode_name,
                ep.episode_display,
                ep.episode_code,
                ep.episode_system,
                ep.id_diagnosis,
                ep.id_dokter,
                ep.date_start,
                ep.date_end,
                ep.status,

                p.id_ihs,
                p.nama AS nama_pasien,

                d.id_ihs_practitioner,
                d.nama AS nama_dokter,

                dg.id_condition,
                dg.icd_kode,
                dg.icd_deskripsi,
                dg.jenis_diagnosis

            FROM episode_perawatan ep

            LEFT JOIN pasien p
                ON ep.id_pasien = p.id_pasien

            LEFT JOIN dokter d
                ON ep.id_dokter = d.id_dokter

            LEFT JOIN diagnosis dg
                ON ep.id_diagnosis = dg.id_diagnosis

            WHERE ep.id_episode_perawatan = ?
            LIMIT 1";

    $stmt = $Conn->prepare($sql);

    if (!$stmt) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Gagal mempersiapkan query Episode Perawatan'
        ]);
    }

    $stmt->bind_param("i", $id_episode_perawatan);
    $stmt->execute();

    $result = $stmt->get_result();
    $Episode = $result->fetch_assoc();

    $stmt->close();

    if (empty($Episode)) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Data Episode Perawatan Tidak Ditemukan!'
        ]);
    }

    // =====================================================
    // CEK SUDAH TERDAFTAR SATUSEHAT
    // =====================================================
    if (!empty($Episode['IdEpisodeOfCare'])) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Episode Perawatan ini sudah memiliki ID EpisodeOfCare SATUSEHAT!'
        ]);
    }

    // =====================================================
    // VALIDASI DATA WAJIB
    // =====================================================
    $requiredFields = [
        'id_ihs'              => 'Patient IHS',
        'nama_pasien'         => 'Nama Pasien',
        'status'              => 'Status Episode Perawatan',
        'episode_system'      => 'Episode System',
        'episode_code'        => 'Episode Code',
        'episode_display'     => 'Episode Display',
        'date_start'          => 'Tanggal Mulai Episode Perawatan',
        'id_condition'        => 'ID Condition SATUSEHAT',
        'icd_deskripsi'       => 'Deskripsi Diagnosis',
        'id_ihs_practitioner' => 'Practitioner IHS',
        'nama_dokter'         => 'Nama Dokter'
    ];

    foreach ($requiredFields as $field => $label) {
        if (empty($Episode[$field])) {
            sendEpisodeOfCareResponse([
                'status' => 'error',
                'message' => $label . ' Tidak Boleh Kosong'
            ]);
        }
    }

    // =====================================================
    // VALIDASI STATUS
    // =====================================================
    $allowedStatus = [
        'planned',
        'waitlist',
        'active',
        'onhold',
        'finished',
        'cancelled',
        'entered-in-error'
    ];

    if (!in_array($Episode['status'], $allowedStatus, true)) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Status Episode Perawatan Tidak Valid'
        ]);
    }

    // =====================================================
    // BACA PENGATURAN SATUSEHAT
    // =====================================================
    $status_setting_satusehat = 1;

    $sql = "SELECT *
            FROM setting_satusehat
            WHERE status_setting_satusehat = ?
            LIMIT 1";

    $stmt = $Conn->prepare($sql);

    if (!$stmt) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Gagal membaca pengaturan SATUSEHAT'
        ]);
    }

    $stmt->bind_param("i", $status_setting_satusehat);
    $stmt->execute();

    $result = $stmt->get_result();
    $setting = $result->fetch_assoc();

    $stmt->close();

    if (empty($setting)) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Setting Koneksi SATUSEHAT Tidak Ditemukan!'
        ]);
    }

    // =====================================================
    // AMBIL ORGANIZATION DARI DATABASE
    // =====================================================
    $organization_id = $setting['organization_id'] ?? '';
    $organization_display = $setting['nama_setting_satusehat'] ?? '';

    if (empty($organization_id)) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Organization ID Tidak Boleh Kosong'
        ]);
    }

    // =====================================================
    // FORMAT TANGGAL FHIR
    // =====================================================
    $timestampStart = strtotime($Episode['date_start']);

    if ($timestampStart === false) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Tanggal Mulai Episode Perawatan Tidak Valid'
        ]);
    }

    $formatFHIR = date('Y-m-d\TH:i:sP', $timestampStart);

    // FORMAT TANGGAL SELESAI JIKA TERISI
    $formatFHIR_end = '';

    if (!empty($Episode['date_end'])) {

        $timestampEnd = strtotime($Episode['date_end']);

        if ($timestampEnd === false) {
            sendEpisodeOfCareResponse([
                'status' => 'error',
                'message' => 'Tanggal Selesai Episode Perawatan Tidak Valid'
            ]);
        }

        if ($timestampEnd < $timestampStart) {
            sendEpisodeOfCareResponse([
                'status' => 'error',
                'message' => 'Tanggal Selesai Tidak Boleh Lebih Awal Dari Tanggal Mulai'
            ]);
        }

        $formatFHIR_end = date('Y-m-d\TH:i:sP', $timestampEnd);
    }

    // =====================================================
    // MEMBUAT PAYLOAD EPISODE OF CARE
    // SELURUH INFORMASI DIAMBIL DARI DATABASE
    // =====================================================
    $payload = [
        'resourceType' => 'EpisodeOfCare',

        'status' => $Episode['status'],

        'type' => [
            [
                'coding' => [
                    [
                        'system' => $Episode['episode_system'],
                        'code' => $Episode['episode_code'],
                        'display' => $Episode['episode_display']
                    ]
                ]
            ]
        ],

        'diagnosis' => [
            [
                'condition' => [
                    'reference' => 'Condition/' . $Episode['id_condition'],
                    'display' => $Episode['icd_deskripsi']
                ]
            ]
        ],

        'patient' => [
            'reference' => 'Patient/' . $Episode['id_ihs'],
            'display' => $Episode['nama_pasien']
        ],

        'managingOrganization' => [
            'reference' => 'Organization/' . $organization_id,
            'display' => $organization_display
        ],

        'careManager' => [
            'reference' => 'Practitioner/' . $Episode['id_ihs_practitioner'],
            'display' => $Episode['nama_dokter']
        ],

        'period' => [
            'start' => $formatFHIR
        ]
    ];

    // PERIOD END HANYA JIKA TERISI
    if (!empty($formatFHIR_end)) {
        $payload['period']['end'] = $formatFHIR_end;
    }

    // =====================================================
    // UBAH PAYLOAD MENJADI JSON
    // =====================================================
    $json_payload = json_encode(
        $payload,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );

    if ($json_payload === false) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Gagal membuat JSON: ' . json_last_error_msg()
        ]);
    }

    // =====================================================
    // VALIDASI URL SATUSEHAT
    // =====================================================
    $url_satusehat = rtrim(
        $setting['url_satusehat'] ?? '',
        '/'
    );

    if (empty($url_satusehat)) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'URL SATUSEHAT Tidak Ditemukan!'
        ]);
    }

    // =====================================================
    // GENERATE TOKEN
    // =====================================================
    $token = $setting['token'] ?? '';
    $datetime_expired = $setting['datetime_expired'] ?? '';

    if (
        empty($token) ||
        empty($datetime_expired) ||
        strtotime($datetime_expired) <= time()
    ) {
        $tokenResult = generateTokenSatuSehat($Conn);

        if (($tokenResult['status'] ?? '') !== 'success') {
            sendEpisodeOfCareResponse([
                'status' => 'error',
                'message' => $tokenResult['message'] ?? 'Generate Token Gagal!'
            ]);
        }

        $token = $tokenResult['token'] ?? '';
    }

    if (empty($token)) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Token SATUSEHAT Tidak Tersedia!'
        ]);
    }

    // =====================================================
    // KIRIM KE SATUSEHAT
    // =====================================================
    $resultSend = CreatEpisodeOfCare(
        $url_satusehat,
        $json_payload,
        $token
    );

    // =====================================================
    // CEK CURL ERROR
    // =====================================================
    if (!$resultSend['success']) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Curl Error: ' . ($resultSend['curl_error'] ?? 'Tidak diketahui'),
            'payload' => $payload
        ]);
    }

    $httpCode = $resultSend['http_code'];
    $content = $resultSend['body'];

    // =====================================================
    // PARSING RESPONSE
    // =====================================================
    $responseData = json_decode($content, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Response SATUSEHAT bukan JSON valid. HTTP Code: ' . $httpCode .
                         '. Response: ' . substr((string)$content, 0, 500),
            'payload' => $payload
        ]);
    }

    // =====================================================
    // CEK OPERATION OUTCOME
    // =====================================================
    if (($responseData['resourceType'] ?? '') === 'OperationOutcome') {

        $message = $responseData['issue'][0]['diagnostics'] ??
                   $responseData['issue'][0]['details']['text'] ??
                   'SATUSEHAT menolak payload EpisodeOfCare';

        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'HTTP Code: ' . $httpCode . '. ' . $message,
            'payload' => $payload
        ]);
    }

    // =====================================================
    // VALIDASI HTTP RESPONSE
    // =====================================================
    if ($httpCode != 200 && $httpCode != 201) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'Pengiriman EpisodeOfCare gagal. HTTP Code: ' . $httpCode,
            'payload' => $payload
        ]);
    }

    // =====================================================
    // AMBIL UUID EPISODE OF CARE
    // =====================================================
    $idEpisodeOfCare = $responseData['id'] ?? '';

    if (empty($idEpisodeOfCare)) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'ID EpisodeOfCare Tidak Ditemukan!',
            'payload' => $payload
        ]);
    }

    // =====================================================
    // UPDATE DATABASE LOKAL
    // =====================================================
    $sql = "UPDATE episode_perawatan
            SET IdEpisodeOfCare = ?
            WHERE id_episode_perawatan = ?
            AND (IdEpisodeOfCare IS NULL OR IdEpisodeOfCare = '')";

    $stmt = $Conn->prepare($sql);

    if (!$stmt) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'EpisodeOfCare berhasil dibuat di SATUSEHAT, tetapi query update gagal disiapkan. ID SATUSEHAT: ' . $idEpisodeOfCare
        ]);
    }

    $stmt->bind_param(
        "si",
        $idEpisodeOfCare,
        $id_episode_perawatan
    );

    $execute = $stmt->execute();
    $affectedRows = $stmt->affected_rows;

    $stmt->close();

    if (!$execute || $affectedRows !== 1) {
        sendEpisodeOfCareResponse([
            'status' => 'error',
            'message' => 'EpisodeOfCare berhasil dibuat di SATUSEHAT, tetapi ID gagal disimpan ke database lokal. ID SATUSEHAT: ' . $idEpisodeOfCare
        ]);
    }

    // =====================================================
    // RESPONSE BERHASIL
    // =====================================================
    sendEpisodeOfCareResponse([
        'status' => 'success',
        'message' => 'EpisodeOfCare berhasil dikirim ke SATUSEHAT',
        'id_episode_perawatan' => $id_episode_perawatan,
        'id_episode_of_care' => $idEpisodeOfCare,
        'http_code' => $httpCode
    ]);
?>
