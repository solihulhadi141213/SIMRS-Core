<?php
    if (empty($_POST['base_url_monitor'])) {
        echo '<span class="text-danger">Base URL Monitor Tidak Boleh Kosong!</span>';
        exit;
    }

    if (empty($_POST['access_key'])) {
        echo '<span class="text-danger">Access Key Tidak Boleh Kosong!</span>';
        exit;
    }

    $base_url_monitor = $_POST['base_url_monitor'];
    $access_key = $_POST['access_key'];

    // Path file JSON
    $setting_file = "setting-koneksi.json";

    // Membaca file JSON jika ada, atau inisialisasi data kosong jika tidak
    if (file_exists($setting_file)) {
        $data = json_decode(file_get_contents($setting_file), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo '<span class="text-danger">Gagal membaca file JSON!</span>';
            exit;
        }
    } else {
        $data = [];
    }

    // Menambahkan atau memperbarui data
    $data['base_url_monitor'] = $base_url_monitor;
    $data['access_key'] = $access_key;

    // Menyimpan kembali data ke file JSON
    if (file_put_contents($setting_file, json_encode($data, JSON_PRETTY_PRINT))) {
        echo '<span class="text-success" id="NotifikasiSimpanSettingKoneksiMonitorBerhasil">Success</span>';
    } else {
        echo '<span class="text-danger">Gagal menyimpan data!</span>';
    }
?>
