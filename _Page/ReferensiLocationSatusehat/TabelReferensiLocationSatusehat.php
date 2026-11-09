<?php
    // Koneksi, helper, dan session.
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Escape semua nilai dinamis sebelum ditampilkan sebagai HTML.
    $escape = static function ($value) {
        if (!is_scalar($value) && $value !== null) {
            $value = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        return htmlspecialchars((string)($value ?? '-'), ENT_QUOTES, 'UTF-8');
    };

    // Tampilkan pesan dalam format baris yang sesuai dengan tabel Location.
    $showMessage = static function ($message, $class = 'text-danger') use ($escape) {
        echo '<tr><td class="text-center ' . $class . '" colspan="8"><small>'
            . $escape($message)
            . '</small></td></tr>';
        exit;
    };

    // Validasi session dan parameter pencarian.
    if (empty($SessionIdAkses)) {
        $showMessage('Sesi akses sudah berakhir. Silakan login ulang.');
    }

    $keywordBy = $_POST['keyword_by'] ?? '';
    $keyword = $_POST['keyword'] ?? '';
    if (!is_scalar($keywordBy) || !is_scalar($keyword)) {
        $showMessage('Parameter pencarian tidak valid.');
    }

    $keywordBy = trim((string)$keywordBy);
    $keyword = trim((string)$keyword);

    if ($keywordBy === '') {
        $showMessage('Dasar pencarian tidak boleh kosong.');
    }
    if ($keyword === '') {
        $showMessage('Kata kunci pencarian tidak boleh kosong.');
    }
    if (!in_array($keywordBy, ['organization_id', 'location_id', 'location_name'], true)) {
        $showMessage('Dasar pencarian tidak valid.');
    }

    // Periksa nilai ID sebelum dipakai ke endpoint FHIR.
    if (
        in_array($keywordBy, ['organization_id', 'location_id'], true) &&
        !preg_match('/^[A-Za-z0-9.-]{1,64}$/', $keyword)
    ) {
        $showMessage('ID Organization atau Location tidak valid.');
    }

    // Generate token SATUSEHAT.
    $tokenResult = generateTokenSatuSehat($Conn);
    if (($tokenResult['status'] ?? 'error') !== 'success') {
        $showMessage(
            'Gagal membuat token SATUSEHAT: ' .
            ($tokenResult['message'] ?? 'Terjadi kesalahan yang tidak diketahui.')
        );
    }

    $token = trim((string)($tokenResult['token'] ?? ''));
    if ($token === '') {
        $showMessage('Token SATUSEHAT tidak tersedia.');
    }

    // Ambil URL SATUSEHAT yang aktif.
    $baseUrl = rtrim(trim((string)getDataDetail(
        $Conn,
        'setting_satusehat',
        'status_setting_satusehat',
        1,
        'url_satusehat'
    )), '/');
    if ($baseUrl === '') {
        $showMessage('Base URL SATUSEHAT tidak ditemukan. Silakan periksa konfigurasi.');
    }

    // Jalankan helper pencarian berdasarkan kriteria yang dipilih.
    $encodedKeyword = rawurlencode($keyword);
    if ($keywordBy === 'organization_id') {
        $response = organizationLocation($baseUrl, $token, $encodedKeyword);
    } elseif ($keywordBy === 'location_id') {
        $response = locationById($baseUrl, $token, $encodedKeyword);
    } else {
        $response = locationSearchByName($baseUrl, $token, $encodedKeyword);
    }

    // Pastikan response dapat dibaca sebagai JSON FHIR.
    if (!is_string($response) || $response === '') {
        $showMessage('Tidak ada response dari SATUSEHAT.');
    }

    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
        $showMessage('Response SATUSEHAT bukan JSON yang valid.');
    }

    // Tampilkan pesan diagnostik jika SATUSEHAT mengembalikan OperationOutcome.
    if (($data['resourceType'] ?? '') === 'OperationOutcome') {
        $issue = $data['issue'][0] ?? [];
        $message = $issue['diagnostics'] ?? $issue['details']['text'] ?? '';
        if (!is_scalar($message) || trim((string)$message) === '') {
            $message = 'SATUSEHAT tidak mengembalikan detail error.';
        }
        $showMessage((string)$message);
    }

    // Normalisasi response Location tunggal dan hasil pencarian Bundle.
    if (($data['resourceType'] ?? '') === 'Location') {
        $locations = [$data];
    } elseif (($data['resourceType'] ?? '') === 'Bundle') {
        $locations = [];
        $entries = $data['entry'] ?? [];
        if (!is_array($entries)) {
            $showMessage('Format hasil pencarian Location tidak valid.');
        }
        foreach ($entries as $entry) {
            $resource = is_array($entry) ? ($entry['resource'] ?? null) : null;
            if (is_array($resource) && ($resource['resourceType'] ?? '') === 'Location') {
                $locations[] = $resource;
            }
        }
    } else {
        $showMessage('Response SATUSEHAT bukan resource Location atau Bundle pencarian Location.');
    }

    if (empty($locations)) {
        $showMessage('Data Location tidak ditemukan.', 'text-muted');
    }

    // Ambil display tipe dari CodeableConcept FHIR.
    $getConceptDisplay = static function ($concept) {
        if (!is_array($concept)) {
            return '';
        }

        $coding = $concept['coding'] ?? [];
        $firstCoding = is_array($coding) ? ($coding[0] ?? []) : [];
        $display = is_array($firstCoding)
            ? ($firstCoding['display'] ?? $concept['text'] ?? '')
            : ($concept['text'] ?? '');
        return is_scalar($display) ? trim((string)$display) : '';
    };

    // Tampilkan hasil pencarian sebagai baris tabel.
    foreach ($locations as $index => $location) {
        $name = $location['name'] ?? '-';
        $mode = $location['mode'] ?? '-';
        $id = $location['id'] ?? '-';
        $status = $location['status'] ?? '-';

        $type = '';
        $types = $location['type'] ?? [];
        if (is_array($types)) {
            foreach ($types as $typeConcept) {
                $type = $getConceptDisplay($typeConcept);
                if ($type !== '') {
                    break;
                }
            }
        }
        if ($type === '') {
            $type = $getConceptDisplay($location['physicalType'] ?? []);
        }

        $rowAttributes = $index === 0
            ? ' data-page-count="1" data-current-page="1"'
            : '';

        // Routing status
        $statusValue = is_scalar($status) ? trim((string)$status) : '';
        if ($statusValue === 'active') {
            $label_status = '
                <a href="javascript:void(0);" class="px-2 py-1 bg-success-subtle text-success rounded-1 modal_status" data-id="'.$id.'" title="Active">
                    <i class="bi bi-check"></i> Active
                </a>
            ';
        } elseif ($statusValue === 'suspended') {
            $label_status = '
                <a href="javascript:void(0);" class="px-2 py-1 bg-warning-subtle text-warning rounded-1 modal_status" data-id="'.$id.'" title="Suspended">
                    <i class="bi bi-pause"></i> Suspended
                </a>
            ';
        } else {
            $label_status = '
                <a href="javascript:void(0);" class="px-2 py-1 bg-danger-subtle text-danger rounded-1 modal_status" data-id="'.$id.'" title="Inactive">
                    <i class="bi bi-x"></i> Inactive
                </a>
            ';
        }

        // Cek apakah id location digunakan pada tabel 'setting_satusehat'
        $status_setting_satusehat = getDataDetail($Conn,'setting_satusehat','default_location_id',$id,'status_setting_satusehat');
        if(empty($status_setting_satusehat)){
            $label_default = '
                <a href="javascript:void(0);" class="px-2 py-1 bg-secondary-subtle text-secondary rounded-1 modal_default" data-id="'.$id.'" title="No Default">
                    <i class="bi bi-x"></i> None
                </a>
            ';
        }else{
            $label_default = '
                <a href="javascript:void(0);" class="px-2 py-1 bg-primary-subtle text-primary rounded-1 modal_default" data-id="'.$id.'" title="Default Setting">
                    <i class="bi bi-check"></i> Default
                </a>
            ';
        }

        // Tampilkan Baris Data
        echo '
            <tr' . $rowAttributes . '>
                <td class="text-center">
                    <span class="text-muted">' . ($index + 1) . '</span>
                </td>
                <td>
                    <span class="text-muted">' . $escape($name) . '</span>
                </td>
                <td>
                    <a href="javascript:void(0);" class="text-primary modal_detail" data-id="' . $id . '">
                        <small>' . $escape($id) . '</small>
                    </a>
                </td>
                <td>
                    <span class="text-muted">' . $escape($mode) . '</span>
                </td>
                <td class="text-center">
                    <span class="text-muted">
                        ' . $escape($type !== '' ? $type : '-') . '
                    </span>
                </td>
                <td class="text-center">
                    ' . $label_status . '
                </td>
                <td class="text-center">
                    ' . $label_default . '
                </td>
                <td class="icon-btn text-center">
                    <a href="javascript:void(0);" class="btn btn-md btn-floating btn-option-outline" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>
                    <ul class="dropdown-menu shadow">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_detail" data-id="' . $id . '">
                                <i class="bi bi-info-circle"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item modal_edit" data-id="' . $id . '">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </li>
                    </ul>
                </td>
            </tr>
        ';
    }
?>
