<?php
/**
 * Build one Observation FHIR payload from the joined local observation data.
 * Datetime columns in the local database are UTC, so serialized FHIR instants stay UTC.
 */
function buildObservationPayload(array $observation): array
{
    $missing = [];
    $requiredFields = [
        'patient_ihs' => 'ID IHS pasien',
        'encounter_ihs' => 'ID Encounter SATUSEHAT',
        'practitioner_ihs' => 'ID Practitioner SATUSEHAT',
        'category_system' => 'System kategori',
        'category_code' => 'Kode kategori',
        'category_display' => 'Display kategori',
        'observation_system' => 'System observasi',
        'observation_code' => 'Kode observasi',
        'observation_display' => 'Display observasi',
    ];

    foreach ($requiredFields as $field => $label) {
        if (trim((string) ($observation[$field] ?? '')) === '') {
            $missing[] = $label . ' belum tersedia.';
        }
    }

    // `subject.reference` must use the Patient IHS ID returned by SATUSEHAT MPI.
    // Do not silently trim/pad digits: that could point the clinical record to another patient.
    $patientIhs = trim((string) ($observation['patient_ihs'] ?? ''));
    $isPatientIhsFormatValid = preg_match('/^(?:\d{12}|P\d{11})$/', $patientIhs) === 1
        || preg_match('/^[0-9a-f]{8}-(?:[0-9a-f]{4}-){3}[0-9a-f]{12}$/i', $patientIhs) === 1;
    if ($patientIhs !== '' && !$isPatientIhsFormatValid) {
        $missing[] = 'Format ID IHS pasien tidak valid. Periksa pasien.id_ihs dan gunakan ID Patient dari MPI SATUSEHAT (contoh: 100000030009 atau P02478375538). ID tidak diubah otomatis.';
    }

    if (!empty($observation['observation_id'])) {
        $missing[] = 'Observation ini sudah pernah dikirim ke SATUSEHAT.';
    }

    $parseUtc = static function ($value): ?DateTimeImmutable {
        $value = trim((string) ($value ?? ''));
        if ($value === '') {
            return null;
        }
        try {
            return new DateTimeImmutable($value, new DateTimeZone('UTC'));
        } catch (Throwable $exception) {
            return null;
        }
    };

    $effectiveDateTime = $parseUtc($observation['datetime_observation'] ?? '');
    $issuedDateTime = $parseUtc($observation['datetime_entry'] ?? '');
    if (!$effectiveDateTime) {
        $missing[] = 'Tanggal dan waktu observasi tidak valid.';
    }
    if (!$issuedDateTime) {
        $missing[] = 'Waktu pencatatan (issued) tidak valid.';
    }

    $categoryCoding = [];
    foreach (['system' => 'category_system', 'code' => 'category_code', 'display' => 'category_display'] as $payloadKey => $dataKey) {
        $value = trim((string) ($observation[$dataKey] ?? ''));
        if ($value !== '') {
            $categoryCoding[$payloadKey] = $value;
        }
    }

    $observationCoding = [];
    foreach (['system' => 'observation_system', 'code' => 'observation_code', 'display' => 'observation_display'] as $payloadKey => $dataKey) {
        $value = trim((string) ($observation[$dataKey] ?? ''));
        if ($value !== '') {
            $observationCoding[$payloadKey] = $value;
        }
    }

    $payload = [
        'resourceType' => 'Observation',
        'status' => 'final',
    ];
    if ($categoryCoding) {
        $payload['category'] = [['coding' => [$categoryCoding]]];
    }
    if ($observationCoding) {
        $payload['code'] = ['coding' => [$observationCoding]];
    }
    if (trim((string) ($observation['patient_ihs'] ?? '')) !== '') {
        $payload['subject'] = ['reference' => 'Patient/' . trim((string) $observation['patient_ihs'])];
    }
    if (trim((string) ($observation['practitioner_ihs'] ?? '')) !== '') {
        $payload['performer'] = [[
            'reference' => 'Practitioner/' . trim((string) $observation['practitioner_ihs']),
        ]];
    }
    if (trim((string) ($observation['encounter_ihs'] ?? '')) !== '') {
        $encounterDisplay = 'Kunjungan ' . ($observation['id_kunjungan'] ?? '');
        if (!empty($observation['jenis_kunjungan'])) {
            $encounterDisplay .= ' (' . $observation['jenis_kunjungan'] . ')';
        }
        if (!empty($observation['nama_pasien'])) {
            $encounterDisplay .= ' - ' . $observation['nama_pasien'];
        }
        $payload['encounter'] = [
            'reference' => 'Encounter/' . trim((string) $observation['encounter_ihs']),
            'display' => $encounterDisplay,
        ];
    }
    if ($effectiveDateTime) {
        $payload['effectiveDateTime'] = $effectiveDateTime->format(DateTimeInterface::ATOM);
    }
    if ($issuedDateTime) {
        $payload['issued'] = $issuedDateTime->format(DateTimeInterface::ATOM);
    }

    $observationValue = trim((string) ($observation['observation_value'] ?? ''));
    $resultType = (string) ($observation['result_type'] ?? '');
    switch ($resultType) {
        case 'Numeric':
            if (preg_match('/^-?\d+$/D', $observationValue)) {
                $payload['valueQuantity'] = ['value' => (int) $observationValue];
            } else {
                $missing[] = 'Hasil observasi harus berupa bilangan bulat.';
            }
            break;

        case 'Decimal':
            if (preg_match('/^-?\d+(?:\.\d{1,3})?$/D', $observationValue)) {
                $payload['valueQuantity'] = ['value' => (float) $observationValue];
            } else {
                $missing[] = 'Hasil observasi harus berupa angka desimal.';
            }
            break;

        case 'Coded':
            $codedOptions = json_decode((string) ($observation['result_coded'] ?? ''), true);
            $codedLabel = null;
            if (is_array($codedOptions)) {
                foreach ($codedOptions as $option) {
                    if (is_array($option) && (string) ($option['value'] ?? '') === $observationValue) {
                        $codedLabel = (string) ($option['label'] ?? '');
                        break;
                    }
                }
            }
            if ($observationValue !== '' && $codedLabel !== null && $codedLabel !== '') {
                $payload['valueCodeableConcept'] = [
                    'coding' => [['code' => $observationValue, 'display' => $codedLabel]],
                    'text' => $codedLabel,
                ];
            } else {
                $missing[] = 'Hasil coded tidak cocok dengan pilihan pada referensi observasi.';
            }
            break;

        case 'Boolean':
            if (in_array($observationValue, ['0', '1'], true)) {
                $payload['valueBoolean'] = $observationValue === '1';
            } else {
                $missing[] = 'Hasil Boolean harus bernilai 0 atau 1.';
            }
            break;

        case 'Text':
            if ($observationValue !== '') {
                $payload['valueString'] = $observationValue;
            } else {
                $missing[] = 'Hasil observasi belum diisi.';
            }
            break;

        default:
            $missing[] = 'Tipe hasil observasi tidak dikenal.';
            break;
    }

    if (in_array($resultType, ['Numeric', 'Decimal'], true)) {
        foreach (['unit_system' => 'System satuan', 'unit_code' => 'Kode satuan'] as $field => $label) {
            if (trim((string) ($observation[$field] ?? '')) === '') {
                $missing[] = $label . ' belum tersedia untuk hasil kuantitatif.';
            }
        }
        $unitDisplay = trim((string) (($observation['unit_display'] ?? '') ?: ($observation['unit_name'] ?? '')));
        if ($unitDisplay === '') {
            $missing[] = 'Nama satuan belum tersedia untuk hasil kuantitatif.';
        }
        if (isset($payload['valueQuantity'])) {
            if ($unitDisplay !== '') {
                $payload['valueQuantity']['unit'] = $unitDisplay;
            }
            $unitSystem = trim((string) ($observation['unit_system'] ?? ''));
            $unitCode = trim((string) ($observation['unit_code'] ?? ''));
            if ($unitSystem !== '') {
                $payload['valueQuantity']['system'] = $unitSystem;
            }
            if ($unitCode !== '') {
                $payload['valueQuantity']['code'] = $unitCode;
            }
        }
    }

    return [
        'payload' => $payload,
        'missing' => $missing,
        'ready' => count($missing) === 0,
        'effective_datetime_utc' => $effectiveDateTime,
        'issued_datetime_utc' => $issuedDateTime,
    ];
}
?>
