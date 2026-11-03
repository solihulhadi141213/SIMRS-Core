<?php
/// Nyalakan error reporting sementara untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Mengembalikan potongan string HTML untuk dimasukkan ke dalam DOM (#FormLanjutanPeriodeGrafik)
header('Content-Type: text/html; charset=utf-8');

// Ambil nilai periode_data dari AJAX POST (default 'Tahun')
$periode_data = isset($_POST['periode_data']) ? $_POST['periode_data'] : 'Tahun';

// Mendapatkan tahun sekarang
$tahun_sekarang = date('Y');

switch ($periode_data) {
    case 'Tahun':
        // Paradigma 1: Tampilkan input type number untuk Tahun (default tahun sekarang)
        echo '<div class="row mb-3">
                <div class="col-12">
                    <label for="tahun"><small>Tahun</small></label>
                    <input type="number" class="form-control" id="tahun" name="tahun" value="' . $tahun_sekarang . '" min="2000" max="'. ($tahun_sekarang + 5) .'" required>
                </div>
              </div>';
        break;
    
    case 'Bulan':
        // Paradigma 2: Tampilkan input type number untuk Tahun DAN select option Bulan
        $nama_bulan_indo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        $bulan_options = '';
        foreach ($nama_bulan_indo as $b => $label_bulan) {
            $selected = ($b == date('n')) ? ' selected' : '';
            $bulan_options .= '<option value="' . $b . '"' . $selected . '>' . $label_bulan . '</option>';
        }
        
        echo '<div class="row mb-3">
                <div class="col-12">
                    <label for="tahun"><small>Tahun</small></label>
                    <input type="number" class="form-control" id="tahun" name="tahun" value="' . $tahun_sekarang . '" min="2000" max="'. ($tahun_sekarang + 5) .'" required>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-12">
                    <label for="bulan"><small>Bulan</small></label>
                    <select class="form-control" id="bulan" name="bulan" required>
                        <option value="">-- Pilih Bulan --</option>
                        ' . $bulan_options . '
                    </select>
                </div>
              </div>';
        break;
    
    default:
        echo '';
        break;
}