<?php
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

function observasiEditResponse(string $status, string $message): void
{
    echo json_encode(
        ['status' => $status, 'message' => $message],
        JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );
    exit;
}

class ObservasiEditRequestException extends RuntimeException
{
}

if (empty($SessionIdAkses)) {
    observasiEditResponse('error', 'Sesi akses berakhir. Silakan login kembali.');
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    observasiEditResponse('error', 'Metode request tidak valid.');
}

try {
    $parsePositiveId = static function ($value, string $field): int {
        $id = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false) {
            throw new ObservasiEditRequestException('Data ' . $field . ' tidak valid.');
        }
        return (int) $id;
    };

    $idObservation = $parsePositiveId($_POST['id_observation'] ?? null, 'observasi');
    $idPasien = $parsePositiveId($_POST['id_pasien'] ?? null, 'pasien');
    $idKunjungan = $parsePositiveId($_POST['id_kunjungan'] ?? null, 'kunjungan');
    $idPraktisi = $parsePositiveId($_POST['id_praktisi'] ?? null, 'praktisi');
    $idObservationReference = $parsePositiveId(
        $_POST['id_observation_reference'] ?? null,
        'referensi observasi'
    );

    $categoryName = trim((string) ($_POST['category_name'] ?? ''));
    $valueInput = $_POST['observation_value'] ?? null;
    if ($categoryName === '' || !is_scalar($valueInput)) {
        throw new ObservasiEditRequestException('Kategori dan hasil observasi wajib diisi.');
    }
    $observationValue = trim((string) $valueInput);
    if ($observationValue === '') {
        throw new ObservasiEditRequestException('Nilai / hasil observasi wajib diisi.');
    }

    $dateInput = trim((string) ($_POST['tanggal_observasi'] ?? ''));
    $timeInput = trim((string) ($_POST['jam_observasi'] ?? ''));
    $timezoneInput = trim((string) ($SessionUserTimezone ?? ''));
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateInput)) {
        throw new ObservasiEditRequestException('Tanggal observasi tidak valid.');
    }
    if (!preg_match('/^\d{2}:\d{2}(?::\d{2})?$/', $timeInput)) {
        throw new ObservasiEditRequestException('Jam observasi tidak valid.');
    }
    if ($timezoneInput === '') {
        throw new ObservasiEditRequestException('Zona waktu pada sesi tidak tersedia. Silakan login kembali.');
    }

    if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneInput, $offsetMatch)) {
        $offsetHours = (int) $offsetMatch[2];
        $offsetMinutes = (int) $offsetMatch[3];
        if ($offsetMinutes > 59 || $offsetHours > 14 || ($offsetHours === 14 && $offsetMinutes !== 0)) {
            throw new ObservasiEditRequestException('Zona waktu pada sesi tidak valid.');
        }
        $timezone = new DateTimeZone($offsetMatch[1] . $offsetMatch[2] . ':' . $offsetMatch[3]);
    } else {
        try {
            $timezone = new DateTimeZone($timezoneInput);
        } catch (Throwable $exception) {
            throw new ObservasiEditRequestException('Zona waktu pada sesi tidak valid.');
        }
    }

    $dateTimeFormat = strlen($timeInput) === 8 ? '!Y-m-d H:i:s' : '!Y-m-d H:i';
    $localInput = $dateInput . ' ' . $timeInput;
    $localDateTime = DateTimeImmutable::createFromFormat($dateTimeFormat, $localInput, $timezone);
    $dateTimeErrors = DateTimeImmutable::getLastErrors();
    if (
        $localDateTime === false ||
        ($dateTimeErrors !== false && ($dateTimeErrors['warning_count'] > 0 || $dateTimeErrors['error_count'] > 0)) ||
        $localDateTime->format(strlen($timeInput) === 8 ? 'Y-m-d H:i:s' : 'Y-m-d H:i') !== $localInput
    ) {
        throw new ObservasiEditRequestException('Tanggal dan jam observasi tidak valid pada zona waktu tersebut.');
    }
    $datetimeObservation = $localDateTime
        ->setTimezone(new DateTimeZone('UTC'))
        ->format('Y-m-d H:i:s');

    $stmt = $Conn->prepare('SELECT id_observation FROM observation WHERE id_observation = ? LIMIT 1');
    $stmt->bind_param('i', $idObservation);
    $stmt->execute();
    $existingObservation = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$existingObservation) {
        throw new ObservasiEditRequestException('Data observasi tidak ditemukan.');
    }

    $stmt = $Conn->prepare('SELECT id_pasien FROM pasien WHERE id_pasien = ? LIMIT 1');
    $stmt->bind_param('i', $idPasien);
    $stmt->execute();
    $patient = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$patient) {
        throw new ObservasiEditRequestException('Data pasien tidak ditemukan.');
    }

    $stmt = $Conn->prepare(
        "SELECT id_kunjungan FROM kunjungan
         WHERE id_kunjungan = ? AND id_pasien = ? AND status <> 'Batal' LIMIT 1"
    );
    $stmt->bind_param('ii', $idKunjungan, $idPasien);
    $stmt->execute();
    $visit = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$visit) {
        throw new ObservasiEditRequestException('Kunjungan tidak sesuai dengan pasien atau sudah dibatalkan.');
    }

    $stmt = $Conn->prepare('SELECT nama_praktisi FROM praktisi WHERE id_praktisi = ? LIMIT 1');
    $stmt->bind_param('i', $idPraktisi);
    $stmt->execute();
    $practitioner = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$practitioner) {
        throw new ObservasiEditRequestException('Data praktisi tidak ditemukan.');
    }

    $stmt = $Conn->prepare(
        'SELECT category_name, result_type, result_coded
         FROM observation_reference WHERE id_observation_reference = ? LIMIT 1'
    );
    $stmt->bind_param('i', $idObservationReference);
    $stmt->execute();
    $reference = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$reference || !hash_equals((string) $reference['category_name'], $categoryName)) {
        throw new ObservasiEditRequestException('Referensi observasi tidak sesuai dengan kategori yang dipilih.');
    }

    switch ($reference['result_type']) {
        case 'Numeric':
            if (!preg_match('/^-?\d+$/D', $observationValue)) {
                throw new ObservasiEditRequestException('Hasil harus berupa bilangan bulat.');
            }
            break;
        case 'Decimal':
            if (!preg_match('/^-?\d+(?:\.\d{1,3})?$/D', $observationValue)) {
                throw new ObservasiEditRequestException('Hasil harus berupa angka dengan maksimal 3 angka desimal.');
            }
            break;
        case 'Coded':
            $codedOptions = json_decode((string) ($reference['result_coded'] ?? ''), true);
            $allowedValues = [];
            if (is_array($codedOptions)) {
                foreach ($codedOptions as $option) {
                    if (is_array($option) && array_key_exists('value', $option)) {
                        $allowedValues[] = (string) $option['value'];
                    }
                }
            }
            if (!in_array($observationValue, $allowedValues, true)) {
                throw new ObservasiEditRequestException('Hasil tidak termasuk pilihan pada referensi observasi.');
            }
            break;
        case 'Boolean':
            if (!in_array($observationValue, ['0', '1'], true)) {
                throw new ObservasiEditRequestException('Hasil Boolean harus bernilai 1 atau 0.');
            }
            break;
        case 'Text':
            break;
        default:
            throw new ObservasiEditRequestException('Tipe hasil pada referensi observasi tidak dikenal.');
    }

    $namaPraktisi = (string) $practitioner['nama_praktisi'];
    $stmt = $Conn->prepare(
        'UPDATE observation SET
            id_observation_reference = ?,
            id_pasien = ?,
            id_kunjungan = ?,
            id_praktisi = ?,
            nama_praktisi = ?,
            observation_value = ?,
            datetime_observation = ?
         WHERE id_observation = ?
         LIMIT 1'
    );
    $stmt->bind_param(
        'iiiisssi',
        $idObservationReference,
        $idPasien,
        $idKunjungan,
        $idPraktisi,
        $namaPraktisi,
        $observationValue,
        $datetimeObservation,
        $idObservation
    );
    if (!$stmt->execute()) {
        throw new RuntimeException($stmt->error);
    }
    $stmt->close();

    observasiEditResponse('success', 'Data observasi berhasil diperbarui.');
} catch (ObservasiEditRequestException $exception) {
    observasiEditResponse('error', $exception->getMessage());
} catch (Throwable $exception) {
    error_log('Observasi edit: gagal memperbarui data: ' . $exception->getMessage());
    observasiEditResponse('error', 'Gagal memperbarui data observasi. Silakan coba lagi.');
}
?>
