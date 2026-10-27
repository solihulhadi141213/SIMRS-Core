<?php
header('Content-Type: application/json; charset=utf-8');
include "../../_Config/Connection.php";
include "../../_Config/Session.php";

function observasiInsertResponse(string $status, string $message, array $extra = []): void
{
    echo json_encode(
        array_merge(['status' => $status, 'message' => $message], $extra),
        JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );
    exit;
}

class ObservasiRequestException extends RuntimeException
{
}

if (empty($SessionIdAkses)) {
    observasiInsertResponse('error', 'Sesi akses sudah berakhir. Silakan login kembali.');
}
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    observasiInsertResponse('error', 'Metode request tidak valid.');
}

try {
    $parsePositiveId = static function ($value, string $field): int {
        $id = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($id === false) {
            throw new ObservasiRequestException('Data ' . $field . ' tidak valid.');
        }
        return (int) $id;
    };

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
        throw new ObservasiRequestException('Kategori dan hasil observasi wajib diisi.');
    }
    $observationValue = trim((string) $valueInput);
    if ($observationValue === '') {
        throw new ObservasiRequestException('Nilai / hasil observasi wajib diisi.');
    }

    $dateInput = trim((string) ($_POST['tanggal_observasi'] ?? ''));
    $timeInput = trim((string) ($_POST['jam_observasi'] ?? ''));
    $timezoneInput = trim((string) ($_POST['timezone_user'] ?? ''));
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateInput)) {
        throw new ObservasiRequestException('Tanggal observasi tidak valid.');
    }
    if (!preg_match('/^\d{2}:\d{2}(?::\d{2})?$/', $timeInput)) {
        throw new ObservasiRequestException('Jam observasi tidak valid.');
    }
    if ($timezoneInput === '') {
        throw new ObservasiRequestException('Zona waktu pengguna tidak tersedia. Muat ulang halaman dan coba lagi.');
    }

    // Terima zona waktu IANA dari browser, serta offset UTC yang dipakai sebagai fallback.
    if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneInput, $offsetMatch)) {
        $offsetHours = (int) $offsetMatch[2];
        $offsetMinutes = (int) $offsetMatch[3];
        if ($offsetMinutes > 59 || $offsetHours > 14 || ($offsetHours === 14 && $offsetMinutes !== 0)) {
            throw new ObservasiRequestException('Zona waktu pengguna tidak valid.');
        }
        $timezone = new DateTimeZone($offsetMatch[1] . $offsetMatch[2] . ':' . $offsetMatch[3]);
    } else {
        try {
            $timezone = new DateTimeZone($timezoneInput);
        } catch (Throwable $exception) {
            throw new ObservasiRequestException('Zona waktu pengguna tidak valid.');
        }
    }

    $dateTimeFormat = strlen($timeInput) === 8 ? '!Y-m-d H:i:s' : '!Y-m-d H:i';
    $localDateTimeInput = $dateInput . ' ' . $timeInput;
    $localDateTime = DateTimeImmutable::createFromFormat($dateTimeFormat, $localDateTimeInput, $timezone);
    $dateTimeErrors = DateTimeImmutable::getLastErrors();
    if (
        $localDateTime === false ||
        ($dateTimeErrors !== false && ($dateTimeErrors['warning_count'] > 0 || $dateTimeErrors['error_count'] > 0)) ||
        $localDateTime->format(strlen($timeInput) === 8 ? 'Y-m-d H:i:s' : 'Y-m-d H:i') !== $localDateTimeInput
    ) {
        throw new ObservasiRequestException('Tanggal dan jam observasi tidak valid pada zona waktu tersebut.');
    }
    $datetimeObservation = $localDateTime
        ->setTimezone(new DateTimeZone('UTC'))
        ->format('Y-m-d H:i:s');

    // Pastikan No. RM aktif dan kunjungan memang milik pasien yang dikirim.
    $stmt = $Conn->prepare("SELECT id_pasien FROM pasien WHERE id_pasien = ? AND status = 'Active' LIMIT 1");
    $stmt->bind_param('i', $idPasien);
    $stmt->execute();
    $patient = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$patient) {
        throw new ObservasiRequestException('Data pasien tidak ditemukan atau tidak aktif.');
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
        throw new ObservasiRequestException('Kunjungan tidak sesuai dengan pasien atau sudah dibatalkan.');
    }

    $stmt = $Conn->prepare('SELECT nama_praktisi FROM praktisi WHERE id_praktisi = ? LIMIT 1');
    $stmt->bind_param('i', $idPraktisi);
    $stmt->execute();
    $practitioner = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$practitioner) {
        throw new ObservasiRequestException('Data praktisi tidak ditemukan.');
    }
    $namaPraktisi = (string) $practitioner['nama_praktisi'];

    $stmt = $Conn->prepare(
        'SELECT category_name, result_type, result_coded
         FROM observation_reference WHERE id_observation_reference = ? LIMIT 1'
    );
    $stmt->bind_param('i', $idObservationReference);
    $stmt->execute();
    $reference = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (!$reference || !hash_equals((string) $reference['category_name'], $categoryName)) {
        throw new ObservasiRequestException('Referensi observasi tidak sesuai dengan kategori yang dipilih.');
    }

    // Cocokkan nilai yang dikirim dengan jenis hasil pada referensi database.
    switch ($reference['result_type']) {
        case 'Numeric':
            if (!preg_match('/^-?\d+$/D', $observationValue)) {
                throw new ObservasiRequestException('Hasil harus berupa bilangan bulat.');
            }
            break;
        case 'Decimal':
            if (!preg_match('/^-?\d+(?:\.\d{1,3})?$/D', $observationValue)) {
                throw new ObservasiRequestException('Hasil harus berupa angka dengan maksimal 3 angka desimal.');
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
                throw new ObservasiRequestException('Hasil tidak termasuk pilihan pada referensi observasi.');
            }
            break;
        case 'Boolean':
            if (!in_array($observationValue, ['0', '1'], true)) {
                throw new ObservasiRequestException('Hasil Boolean harus bernilai 1 atau 0.');
            }
            break;
        case 'Text':
            // Teks bebas yang tidak kosong telah divalidasi di atas.
            break;
        default:
            throw new ObservasiRequestException('Tipe hasil pada referensi observasi tidak dikenal.');
    }

    $datetimeEntry = (new DateTimeImmutable('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s');
    $petugasId = (int) $SessionIdAkses;
    $petugasNama = (string) $SessionNama;

    $stmt = $Conn->prepare(
        'INSERT INTO observation (
            id_observation_reference,
            id_pasien,
            id_kunjungan,
            id_praktisi,
            nama_praktisi,
            observation_value,
            datetime_observation,
            datetime_entry,
            petugas_id,
            petugas_nama
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $stmt->bind_param(
        'iiiissssis',
        $idObservationReference,
        $idPasien,
        $idKunjungan,
        $idPraktisi,
        $namaPraktisi,
        $observationValue,
        $datetimeObservation,
        $datetimeEntry,
        $petugasId,
        $petugasNama
    );
    if (!$stmt->execute()) {
        throw new RuntimeException($stmt->error);
    }
    $idObservation = (int) $Conn->insert_id;
    $stmt->close();

    observasiInsertResponse('success', 'Data observasi berhasil ditambahkan.', [
        'id_observation' => $idObservation,
    ]);
} catch (ObservasiRequestException $exception) {
    observasiInsertResponse('error', $exception->getMessage());
} catch (Throwable $exception) {
    error_log('Observasi: gagal menyimpan observasi: ' . $exception->getMessage());
    observasiInsertResponse('error', 'Gagal menyimpan data observasi. Silakan coba lagi.');
}
?>
