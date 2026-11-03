<?php
    // Koneksi
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // Ambil id_log dari POST
    $id_log = isset($_POST['id_log']) ? (int)$_POST['id_log'] : 0;

    // Query ambil data log berdasarkan id_log
    $sql = "SELECT * FROM log WHERE id_log = ?";
    $stmt = mysqli_prepare($Conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_log);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $id_log       = $row['id_log'];
        $nama_petugas = $row['nama_petugas'] ?? '-';
        $category_log = $row['category_log'] ?? 'Umum';
        $title_log    = $row['title_log'] ?? '-';
        $datetime_log = $row['datetime_log'];

        // Format tanggal log
        $formatted_datetime = '-';
        if (!empty($datetime_log)) {
            $timezoneName = trim((string)($SessionUserTimezone ?? ''));
            if (preg_match('/^UTC([+-])(\d{2}):(\d{2})$/', $timezoneName, $timezoneOffset)) {
                $timezoneName = $timezoneOffset[1] . $timezoneOffset[2] . ':' . $timezoneOffset[3];
            }
            try {
                $userTimezone = new DateTimeZone($timezoneName !== '' ? $timezoneName : 'UTC');
            } catch (Throwable $e) {
                $userTimezone = new DateTimeZone('UTC');
            }
            try {
                $dt = new DateTimeImmutable((string)$datetime_log, new DateTimeZone('UTC'));
                $formatted_datetime = $dt->setTimezone($userTimezone)->format('d/m/Y H:i T');
            } catch (Throwable $e) {
                $formatted_datetime = date('d/m/Y H:i T', strtotime((string)$datetime_log));
            }
        }

        // Format title log (potong jika > 20 karakter)
        // Catatan: Jika ini untuk modal detail, biasanya ditampilkan penuh. Tapi jika ingin tetap dipotong, biarkan seperti ini:
        $display_title = htmlspecialchars($title_log); 
        
        // Metadata Formatting (Pretty Print JSON)
        if (!empty($row['metadata_log'])) {
            // Coba decode string JSON dari database lalu encode kembali agar berformat rapi (pretty print)
            $decoded_json = json_decode($row['metadata_log']);
            if (json_last_error() === JSON_ERROR_NONE) {
                $metadata = json_encode($decoded_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            } else {
                // Jika bukan format JSON valid, tampilkan apa adanya
                $metadata = $row['metadata_log'];
            }
        } else {
            $metadata = "-";
        }

        echo '
            <div class="row mb-2">
                <div class="col-4">
                    <small>ID Log</small>
                </div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">' . htmlspecialchars($id_log) . '</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small>Nama Petugas</small>
                </div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">' . htmlspecialchars($nama_petugas) . '</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small>Kategori</small>
                </div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">' . htmlspecialchars($category_log) . '</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small>Tipe Log</small>
                </div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">' . $display_title . '</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small>Waktu Log</small>
                </div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">' . htmlspecialchars($formatted_datetime) . '</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4">
                    <small>Metadata</small>
                </div>
                <div class="col-1"><small>:</small></div>
            </div>
            <div class="row mb-2">
               <div class="col-12">
                    <div class="p-3 border rounded" style="background-color: #f8f9fa; max-height: 200px; overflow-y: auto;">
                        <pre class="mb-0" style="background-color: transparent; color: #212529; font-family: Consolas, Menlo, Monaco, monospace; font-size: 12px; white-space: pre-wrap; word-break: break-all;"><code style="color: #212529; background-color: transparent;">'.htmlspecialchars($metadata).'</code></pre>
                    </div>
                </div>
            </div>
        ';
    }
?>