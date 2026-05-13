<?php
    // =========================================================
    // CONNECTION
    // =========================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    require '../../vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Shared\Date; // Tambahan untuk handling tanggal

    // =========================================================
    // HELPER
    // =========================================================
    function cell($row, $index){
        return trim((string)($row[$index] ?? ''));
    }

    function badgeStatus($status){
        if($status == 'Berhasil'){
            return 'success';
        }
        return 'danger';
    }

    // Fungsi tambahan untuk validasi format tanggal excel
    function formatTanggal($value) {
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)->format('Y-m-d H:i:s');
        }
        return $value;
    }

    // =========================================================
    // VALIDASI SESSION
    // =========================================================
    if (empty($SessionIdAkses)) {
        echo '<tr><td colspan="11" class="text-center text-danger">Session akses sudah berakhir</td></tr>';
        exit;
    }

    // =========================================================
    // VALIDASI FILE
    // =========================================================
    if(empty($_FILES['file_excel']) || empty($_FILES['file_excel']['tmp_name'])){
        echo '<tr><td colspan="11" class="text-center text-danger">File excel tidak ditemukan</td></tr>';
        exit;
    }

    $allowed = ['xls', 'xlsx'];
    $extension = strtolower(pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION));

    if(!in_array($extension, $allowed)){
        echo '<tr><td colspan="11" class="text-center text-danger">Format file tidak didukung</td></tr>';
        exit;
    }

    // =========================================================
    // LOAD EXCEL
    // =========================================================
    try{
        $spreadsheet = IOFactory::load($_FILES['file_excel']['tmp_name']);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        unset($rows[0]); // Hapus Header
    }catch(Exception $e){
        echo '<tr><td colspan="11" class="text-center text-danger">Gagal membaca file excel</td></tr>';
        exit;
    }

    // =========================================================
    // PROSES IMPORT
    // =========================================================
    $html = '';
    $no = 0;

    foreach($rows as $row){
        if(empty(array_filter($row))){ continue; }
        $no++;

        // =====================================================
        // MAPPING DATA (Tetap mengikuti index Anda: 1 sampai 26)
        // =====================================================
        $id_kunjungan         = cell($row, 1);
        $id_encounter         = cell($row, 2);
        $id_pasien            = cell($row, 3);
        $nama_pasien_excel    = cell($row, 4);
        $sep                  = cell($row, 5);
        $prioritas            = cell($row, 6);
        $keluhan              = cell($row, 7);
        $jenis_kunjungan      = cell($row, 8);
        $kode_dokter          = cell($row, 9);
        $kode_dpjp            = cell($row, 10);
        $kode_poli            = cell($row, 11);
        $kelas                = cell($row, 12);
        $ruangan              = cell($row, 13);
        $tempat_tidur         = cell($row, 14);
        $pembayaran           = cell($row, 15);
        $penanggung           = cell($row, 16);
        $kontak_darurat       = cell($row, 17);
        $nama_kontak          = cell($row, 18);
        $hubungan             = cell($row, 19);
        $cara_keluar          = cell($row, 20);
        $status               = cell($row, 21);
        $id_akses             = cell($row, 22);
        $nama_petugas         = cell($row, 23);
        
        // Konversi Tanggal agar terbaca sistem
        $datetime_daftar      = formatTanggal(cell($row, 24));
        $datetime_pelayanan   = formatTanggal(cell($row, 25));
        $datetime_selesai     = formatTanggal(cell($row, 26));

        // =====================================================
        // DEFAULT & VALIDASI (Logika Tetap Sama)
        // =====================================================
        $keterangan      = [];
        $nama_pasien     = '-';
        $nama_dokter     = '-';
        $dpjp_nama       = '-';
        $nama_poli       = '-';
        $id_dokter       = NULL;
        $dpjp_id         = NULL;
        $id_poliklinik   = NULL;

        // Validasi Wajib (Sesuai script asli)
        if(empty($id_pasien)){ $keterangan[] = 'ID Pasien kosong'; }
        if(empty($keluhan)){ $keterangan[] = 'Keluhan kosong'; }
        if(empty($jenis_kunjungan)){ $keterangan[] = 'Jenis kunjungan kosong'; }
        if(empty($prioritas)){ $keterangan[] = 'Prioritas kosong'; }
        if(empty($status)){ $keterangan[] = 'Status kosong'; }
        if(empty($nama_petugas)){ $keterangan[] = 'Nama petugas kosong'; }
        if(empty($datetime_daftar)){ $keterangan[] = 'Datetime daftar kosong'; }

        // Validasi Enum (Sesuai script asli)
        $allowed_prioritas = ['Normal','Urgent','Emergency'];
        if(!empty($prioritas) && !in_array($prioritas, $allowed_prioritas)){ $keterangan[] = 'Prioritas tidak valid'; }
        $allowed_jenis = ['Rajal','Ranap'];
        if(!empty($jenis_kunjungan) && !in_array($jenis_kunjungan, $allowed_jenis)){ $keterangan[] = 'Jenis kunjungan tidak valid'; }
        $allowed_status = ['Terdaftar','Selesai','Batal','Meninggal'];
        if(!empty($status) && !in_array($status, $allowed_status)){ $keterangan[] = 'Status tidak valid'; }
        $allowed_pembayaran = ['UMUM','ASURANSI'];
        if(!empty($pembayaran) && !in_array($pembayaran, $allowed_pembayaran)){ $keterangan[] = 'Pembayaran tidak valid'; }

        // =====================================================
        // VALIDASI DATABASE (Menggunakan mysqli_real_escape_string untuk keamanan)
        // =====================================================
        if(!empty($id_pasien)){
            $id_pasien_safe = mysqli_real_escape_string($Conn, $id_pasien);
            $query_pasien = mysqli_query($Conn, "SELECT nama FROM pasien WHERE id_pasien='$id_pasien_safe'");
            if($data_pasien = mysqli_fetch_assoc($query_pasien)){
                $nama_pasien = $data_pasien['nama'];
            }else{
                $keterangan[] = 'Pasien tidak ditemukan';
            }
        }

        if(!empty($id_kunjungan)){
            $id_k_safe = mysqli_real_escape_string($Conn, $id_kunjungan);
            $check_kunjungan = mysqli_query($Conn, "SELECT id_kunjungan FROM kunjungan WHERE id_kunjungan='$id_k_safe'");
            if(mysqli_num_rows($check_kunjungan) > 0){ $keterangan[] = 'ID kunjungan sudah digunakan'; }
        }

        if(!empty($kode_dokter)){
            $kd_safe = mysqli_real_escape_string($Conn, $kode_dokter);
            $query_dokter = mysqli_query($Conn, "SELECT id_dokter, nama FROM dokter WHERE kode='$kd_safe'");
            if($data_dokter = mysqli_fetch_assoc($query_dokter)){
                $id_dokter = $data_dokter['id_dokter'];
                $nama_dokter = $data_dokter['nama'];
            }else{ $keterangan[] = 'Dokter penerima tidak valid'; }
        }

        if(!empty($kode_dpjp)){
            $kdpjp_safe = mysqli_real_escape_string($Conn, $kode_dpjp);
            $query_dpjp = mysqli_query($Conn, "SELECT id_dokter, nama FROM dokter WHERE kode='$kdpjp_safe'");
            if($data_dpjp = mysqli_fetch_assoc($query_dpjp)){
                $dpjp_id = $data_dpjp['id_dokter'];
                $dpjp_nama = $data_dpjp['nama'];
            }else{ $keterangan[] = 'Dokter DPJP tidak valid'; }
        }

        if(!empty($kode_poli)){
            $kp_safe = mysqli_real_escape_string($Conn, $kode_poli);
            $query_poli = mysqli_query($Conn, "SELECT id_poliklinik, poliklinik FROM poliklinik WHERE kode='$kp_safe'");
            if($data_poli = mysqli_fetch_assoc($query_poli)){
                $id_poliklinik = $data_poli['id_poliklinik'];
                $nama_poli = $data_poli['poliklinik'];
            }else{ $keterangan[] = 'Poliklinik tidak valid'; }
        }

        if(!empty($id_akses)){
            $id_ak_safe = mysqli_real_escape_string($Conn, $id_akses);
            $query_akses = mysqli_query($Conn, "SELECT id_akses FROM akses WHERE id_akses='$id_ak_safe'");
            if(mysqli_num_rows($query_akses) == 0){ $keterangan[] = 'ID akses petugas tidak valid'; }
        }

        // =====================================================
        // INSERT
        // =====================================================
        $status_import = 'Berhasil';
        if(empty($keterangan)){
            // Perbaikan bind_param type (semua s untuk keamanan format ID/String)
            $stmt = $Conn->prepare("INSERT INTO kunjungan (id_encounter, id_pasien, sep, prioritas, keluhan, jenis_kunjungan, id_dokter, kode_dokter, dokter, dpjp_id, dpjp_kode, dpjp_nama, id_poliklinik, kode_poliklinik, poliklinik, kelas, ruang_rawat, tempat_tidur, pembayaran_metode, pembayaran_penanggung, kontak_darurat_nomor, kontak_darurat_nama, kontak_darurat_hubungan, cara_keluar, status, petugas_id, petugas_nama, datetime_daftar, datetime_pelayanan, datetime_selesai) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            if($stmt){
                // Gunakan ssssss... (30 parameter)
                $stmt->bind_param("ssssssssssssssssssssssssssssss", 
                    $id_encounter, $id_pasien, $sep, $prioritas, $keluhan, $jenis_kunjungan,
                    $id_dokter, $kode_dokter, $nama_dokter, $dpjp_id, $kode_dpjp, $dpjp_nama,
                    $id_poliklinik, $kode_poli, $nama_poli, $kelas, $ruangan, $tempat_tidur,
                    $pembayaran, $penanggung, $kontak_darurat, $nama_kontak, $hubungan,
                    $cara_keluar, $status, $id_akses, $nama_petugas, $datetime_daftar,
                    $datetime_pelayanan, $datetime_selesai
                );
                if(!$stmt->execute()){ $status_import = 'Gagal Insert : '.$stmt->error; }
                $stmt->close();
            } else { $status_import = 'Prepare Statement Gagal'; }
        }else{
            $status_import = implode(', ', $keterangan);
        }

        // =====================================================
        // OUTPUT (Tetap Sama)
        // =====================================================
        $badge = badgeStatus($status_import);
        $html .= '<tr>
                <td>'.$no.'</td>
                <td>'.$id_pasien.'</td>
                <td>'.$nama_pasien.'</td>
                <td>'.$datetime_daftar.'</td>
                <td>'.$jenis_kunjungan.'</td>
                <td>'.$nama_dokter.'</td>
                <td>'.$dpjp_nama.'</td>
                <td>'.$nama_poli.'</td>
                <td>'.$kelas.'</td>
                <td>'.$status.'</td>
                <td><span class="badge bg-'.$badge.'">'.$status_import.'</span></td>
            </tr>';
    }

    if(empty($html)){
        $html = '<tr><td colspan="11" class="text-center text-muted">Tidak ada data yang diproses</td></tr>';
    }
    echo $html;
?>