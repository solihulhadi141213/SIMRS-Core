<?php
    // Load koneksi, helper SATUSEHAT, dan sesi pengguna.
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Escape nilai dinamis sebelum ditampilkan sebagai HTML.
    $escapeLocationDetail = static function ($value) {
        if (!is_scalar($value) && $value !== null) {
            $value = json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        return htmlspecialchars((string)($value ?? '-'), ENT_QUOTES, 'UTF-8');
    };

    // Tampilkan pesan gagal dalam format yang digunakan modal detail.
    $showLocationDetailError = static function ($message) use ($escapeLocationDetail) {
        echo '<div class="alert alert-danger text-center mb-0"><small>'
            . $escapeLocationDetail($message)
            . '</small></div>';
        exit;
    };

    // Tampilkan satu baris label dan nilai detail.
    $showLocationDetailRow = static function ($label, $value) use ($escapeLocationDetail) {
        echo '
            <div class="row mb-2">
                <div class="col-4"><small>' . $escapeLocationDetail($label) . '</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7"><small class="text-muted">'
                    . $escapeLocationDetail($value)
                    . '</small></div>
            </div>
        ';
    };

    // Format list nilai dari resource FHIR menjadi teks yang mudah dibaca.
    $formatLocationDetailList = static function ($items, $field = null) {
        if (!is_array($items)) {
            return '-';
        }

        $values = [];
        foreach ($items as $item) {
            if ($field !== null) {
                $item = is_array($item) ? ($item[$field] ?? '') : '';
            }
            if (is_scalar($item) && trim((string)$item) !== '') {
                $values[] = trim((string)$item);
            }
        }

        return $values ? implode(', ', $values) : '-';
    };

    // Ambil teks coding atau text dari CodeableConcept.
    $getLocationDetailConcept = static function ($concept) {
        if (!is_array($concept)) {
            return '-';
        }

        $coding = $concept['coding'] ?? [];
        $firstCoding = is_array($coding) ? ($coding[0] ?? []) : [];
        $display = is_array($firstCoding)
            ? ($firstCoding['display'] ?? $concept['text'] ?? '')
            : ($concept['text'] ?? '');

        return is_scalar($display) && trim((string)$display) !== ''
            ? trim((string)$display)
            : '-';
    };

    // Validasi sesi dan ID resource yang dikirim dari baris tabel.
    if (empty($SessionIdAkses)) {
        $showLocationDetailError('Sesi akses sudah berakhir. Silakan login ulang.');
    }

    $idLocationInput = $_POST['id_location'] ?? '';
    if (!is_scalar($idLocationInput)) {
        $showLocationDetailError('ID Location tidak valid.');
    }
    $idLocation = trim((string)$idLocationInput);
    if (!preg_match('/^[A-Za-z0-9.-]{1,64}$/', $idLocation)) {
        $showLocationDetailError('ID Location tidak valid.');
    }

    // Buat token SATUSEHAT untuk membaca resource.
    $tokenResult = generateTokenSatuSehat($Conn);
    if (($tokenResult['status'] ?? 'error') !== 'success') {
        $showLocationDetailError(
            'Gagal membuat token SATUSEHAT: ' .
            ($tokenResult['message'] ?? 'Terjadi kesalahan yang tidak diketahui.')
        );
    }

    $token = trim((string)($tokenResult['token'] ?? ''));
    if ($token === '') {
        $showLocationDetailError('Token SATUSEHAT tidak tersedia.');
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
        $showLocationDetailError('Base URL SATUSEHAT tidak ditemukan. Silakan periksa konfigurasi.');
    }

    // Ambil resource Location berdasarkan ID dari SATUSEHAT.
    $response = locationById($baseUrl, $token, $idLocation);
    if (!is_string($response) || $response === '') {
        $showLocationDetailError('Tidak menerima response Location dari SATUSEHAT.');
    }

    $location = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($location)) {
        $showLocationDetailError('Response SATUSEHAT bukan JSON yang valid.');
    }
    if (($location['resourceType'] ?? '') === 'OperationOutcome') {
        $issue = $location['issue'][0] ?? [];
        $message = $issue['diagnostics'] ?? $issue['details']['text'] ?? '';
        if (!is_scalar($message) || trim((string)$message) === '') {
            $message = 'SATUSEHAT tidak mengembalikan detail error.';
        }
        $showLocationDetailError((string)$message);
    }
    if (($location['resourceType'] ?? '') !== 'Location') {
        $showLocationDetailError('Response SATUSEHAT bukan resource Location.');
    }
    if (trim((string)($location['id'] ?? '')) === '') {
        $showLocationDetailError('Resource Location tidak memiliki ID.');
    }

    // Siapkan informasi utama Location.
    $identifiers = [];
    $locationIdentifiers = $location['identifier'] ?? [];
    if (is_array($locationIdentifiers)) {
        foreach ($locationIdentifiers as $identifier) {
            if (!is_array($identifier)) {
                continue;
            }
            $parts = [];
            foreach (['use', 'system', 'value'] as $field) {
                if (isset($identifier[$field]) && is_scalar($identifier[$field])) {
                    $parts[] = $field . ': ' . $identifier[$field];
                }
            }
            if ($parts) {
                $identifiers[] = implode(' | ', $parts);
            }
        }
    }
    $identifierText = $identifiers ? implode('; ', $identifiers) : '-';

    $typeLabels = [];
    $locationTypes = $location['type'] ?? [];
    if (is_array($locationTypes)) {
        foreach ($locationTypes as $type) {
            $display = $getLocationDetailConcept($type);
            if ($display !== '-') {
                $typeLabels[] = $display;
            }
        }
    }

    $address = $location['address'] ?? [];
    $addressText = '-';
    if (is_array($address)) {
        $addressParts = [];
        foreach (['use', 'type', 'text', 'city', 'district', 'state', 'postalCode', 'country'] as $field) {
            if (isset($address[$field]) && is_scalar($address[$field]) && trim((string)$address[$field]) !== '') {
                $addressParts[] = $address[$field];
            }
        }
        $addressLine = $formatLocationDetailList($address['line'] ?? []);
        if ($addressLine !== '-') {
            array_unshift($addressParts, $addressLine);
        }
        if ($addressParts) {
            $addressText = implode(', ', $addressParts);
        }
    }

    $telecoms = [];
    $locationTelecoms = $location['telecom'] ?? [];
    if (is_array($locationTelecoms)) {
        foreach ($locationTelecoms as $telecom) {
            if (!is_array($telecom)) {
                continue;
            }
            $system = $telecom['system'] ?? '';
            $value = $telecom['value'] ?? '';
            if (is_scalar($value) && trim((string)$value) !== '') {
                $telecoms[] = (is_scalar($system) && $system !== '' ? $system . ': ' : '') . $value;
            }
        }
    }

    $physicalPosition = $location['position'] ?? [];
    $position = '-';
    if (is_array($physicalPosition)) {
        $coordinates = [];
        foreach (['longitude', 'latitude', 'altitude'] as $coordinate) {
            if (isset($physicalPosition[$coordinate]) && is_scalar($physicalPosition[$coordinate])) {
                $coordinates[] = $coordinate . ': ' . $physicalPosition[$coordinate];
            }
        }
        if ($coordinates) {
            $position = implode(', ', $coordinates);
        }
    }

    $hours = [];
    $hoursOfOperation = $location['hoursOfOperation'] ?? [];
    if (is_array($hoursOfOperation)) {
        foreach ($hoursOfOperation as $hour) {
            if (!is_array($hour)) {
                continue;
            }
            $days = $formatLocationDetailList($hour['daysOfWeek'] ?? []);
            $closed = !empty($hour['allDay']) ? '24 jam' : '';
            $open = is_scalar($hour['openingTime'] ?? '') ? ($hour['openingTime'] ?? '') : '';
            $close = is_scalar($hour['closingTime'] ?? '') ? ($hour['closingTime'] ?? '') : '';
            $period = $closed !== '' ? $closed : trim((string)$open . ' - ' . (string)$close, ' -');
            $hours[] = trim($days . ($period !== '' ? ': ' . $period : ''), ': ');
        }
    }

    $versionId = $location['meta']['versionId'] ?? '-';
    $lastUpdated = $location['meta']['lastUpdated'] ?? '-';
    $rawJson = json_encode(
        $location,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
    );
?>
<div class="row mb-2">
    <div class="col-12"><small><b><i>A. Informasi Location</i></b></small></div>
</div>
<?php
    $showLocationDetailRow('ID Location', $location['id'] ?? '-');
    $showLocationDetailRow('Nama', $location['name'] ?? '-');
    $showLocationDetailRow('Status', $location['status'] ?? '-');
    $showLocationDetailRow('Mode', $location['mode'] ?? '-');
    $showLocationDetailRow('Deskripsi', $location['description'] ?? '-');
    $showLocationDetailRow('Alias', $formatLocationDetailList($location['alias'] ?? []));
    $showLocationDetailRow('Identifier', $identifierText);
?>
<hr>
<div class="row mb-2">
    <div class="col-12"><small><b><i>B. Klasifikasi dan Organisasi</i></b></small></div>
</div>
<?php
    $showLocationDetailRow('Type', $typeLabels ? implode(', ', $typeLabels) : '-');
    $showLocationDetailRow('Physical Type', $getLocationDetailConcept($location['physicalType'] ?? []));
    $showLocationDetailRow('Managing Organization', $location['managingOrganization']['reference'] ?? '-');
    $showLocationDetailRow('Part Of', $location['partOf']['reference'] ?? '-');
    $showLocationDetailRow('Endpoint', $formatLocationDetailList($location['endpoint'] ?? [], 'reference'));
?>
<hr>
<div class="row mb-2">
    <div class="col-12"><small><b><i>C. Kontak dan Alamat</i></b></small></div>
</div>
<?php
    $showLocationDetailRow('Telecom', $telecoms ? implode(', ', $telecoms) : '-');
    $showLocationDetailRow('Alamat', $addressText);
    $showLocationDetailRow('Posisi', $position);
?>
<hr>
<div class="row mb-2">
    <div class="col-12"><small><b><i>D. Operasional dan Metadata</i></b></small></div>
</div>
<?php
    $showLocationDetailRow('Jam Operasional', $hours ? implode('; ', $hours) : '-');
    $showLocationDetailRow('Pengecualian Jam', $location['availabilityExceptions'] ?? '-');
    $showLocationDetailRow('Version ID', $versionId);
    $showLocationDetailRow('Last Updated', $lastUpdated);
?>
<hr>
<div class="row mb-2">
    <div class="col-12">
        <small><b><i>E. Raw JSON Response</i></b></small>
        <pre class="small bg-light p-3 rounded border mt-2" style="max-height:300px; overflow:auto;"><?php
            echo $escapeLocationDetail($rawJson);
        ?></pre>
    </div>
</div>