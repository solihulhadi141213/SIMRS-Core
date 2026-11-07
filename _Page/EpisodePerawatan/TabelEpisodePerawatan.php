<?php
    // ==========================================================
    // TabelEpisodePerawatan.php
    // Menampilkan baris tabel Episode Perawatan (dipanggil AJAX)
    // ==========================================================

    // Load konfigurasi & helper
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // ------------------------------------------------------
    // Fungsi lokal: baris pesan (error / kosong), colspan = 10 (disesuaikan dengan jumlah kolom render)
    // data-page-count=0 membuat tombol paging nonaktif di jQuery
    // ------------------------------------------------------
    function BarisPesan($pesan, $class = 'text-muted') {
        echo '<tr data-page-count="0" data-current-page="0">';
        echo '  <td align="center" colspan="10"><small class="' . $class . '">' . htmlspecialchars($pesan) . '</small></td>';
        echo '</tr>';
    }

    // ------------------------------------------------------
    // Fungsi lokal: format tanggal (Y-m-d) menjadi d/m/Y
    // Tipe kolom 'date' = tanggal kalender, TIDAK dikonversi timezone
    // ------------------------------------------------------
    function FormatTanggal($tanggal) {
        if (empty($tanggal) || $tanggal === '0000-00-00') {
            return '-';
        }
        $dt = DateTime::createFromFormat('Y-m-d', $tanggal);
        return $dt ? $dt->format('d/m/Y') : '-';
    }

    // ------------------------------------------------------
    // Fungsi lokal: pembatas string maksimal 15 karakter + "..."
    // ------------------------------------------------------
    function BatasiKarakter($teks, $maksimal = 15) {
        $teks_bersih = htmlspecialchars($teks ?? '-');
        if (mb_strlen($teks_bersih) > $maksimal) {
            return mb_substr($teks_bersih, 0, $maksimal) . '...';
        }
        return $teks_bersih;
    }

    // ------------------------------------------------------
    // 1. VALIDASI SESSION
    // ------------------------------------------------------
    if (empty($SessionIdAkses)) {
        BarisPesan('Sesi login berakhir. Silakan login kembali.', 'text-danger');
        exit;
    }

    // ------------------------------------------------------
    // 2. VALIDASI HAK AKSES FITUR
    // GANTI nilainya sesuai kolom 'kode' pada tabel akses_fitur
    // ------------------------------------------------------
    // $kode_fitur = 'EpisodePerawatan';
    // if (!GetStatusAccess($Conn, $SessionIdAkses, $kode_fitur)) {
    //     BarisPesan('Anda tidak memiliki izin mengakses data ini.', 'text-danger');
    //     exit;
    // }

    // ------------------------------------------------------
    // 3. AMBIL & VALIDASI PARAMETER
    // Nama kolom tidak bisa di-bind, maka dibatasi whitelist
    // ------------------------------------------------------
    $batas_valid = [5, 10, 25, 50, 100, 250, 500];
    $batas = (int) ($_POST['batas'] ?? 10);
    if (!in_array($batas, $batas_valid, true)) {
        $batas = 10;
    }

    $page = max(1, (int) ($_POST['page_filter'] ?? 1));

    // Peta nilai dropdown -> kolom SQL sebenarnya
    $kolom_map = [
        'id_pasien'       => 'e.id_pasien',
        'nama'            => 'p.nama',
        'episode_name'    => 'e.episode_name',
        'id_dokter'       => 'd.nama',          // diurutkan berdasarkan nama dokter
        'date_start'      => 'e.date_start',
        'status'          => 'e.status',
        'IdEpisodeOfCare' => 'e.IdEpisodeOfCare'
    ];

    // Nilai enum status yang valid (sesuai schema.sql)
    $status_valid = ['planned', 'waitlist', 'active', 'onhold', 'finished', 'cancelled', 'entered-in-error'];

    $OrderBy    = $_POST['OrderBy'] ?? '';
    $ShortBy    = (($_POST['ShortBy'] ?? 'DESC') === 'ASC') ? 'ASC' : 'DESC';
    $order_sql  = $kolom_map[$OrderBy] ?? 'e.id_episode_perawatan';
    $keyword_by = $_POST['keyword_by'] ?? '';
    $keyword    = trim($_POST['keyword'] ?? '');

    // ------------------------------------------------------
    // 4. BANGUN WHERE DINAMIS (semua nilai lewat placeholder ?)
    // ------------------------------------------------------
    $where  = [];
    $params = [];

    if ($keyword !== '' && isset($kolom_map[$keyword_by])) {
        switch ($keyword_by) {

            // No.RM: harus angka, cocok persis
            case 'id_pasien':
                if (ctype_digit($keyword)) {
                    $where[]  = "e.id_pasien = ?";
                    $params[] = (int) $keyword;
                } else {
                    $where[] = "1 = 0";
                }
                break;

            // Dokter: angka = ID dokter, selain itu cari berdasarkan nama
            case 'id_dokter':
                if (ctype_digit($keyword)) {
                    $where[]  = "e.id_dokter = ?";
                    $params[] = (int) $keyword;
                } else {
                    $where[]  = "d.nama LIKE ?";
                    $params[] = '%' . $keyword . '%';
                }
                break;

            // Status: hanya nilai enum yang valid
            case 'status':
                if (in_array($keyword, $status_valid, true)) {
                    $where[]  = "e.status = ?";
                    $params[] = $keyword;
                } else {
                    $where[] = "1 = 0";
                }
                break;

            // Tanggal mulai: format YYYY-MM-DD
            case 'date_start':
                $cek = DateTime::createFromFormat('Y-m-d', $keyword);
                if ($cek && $cek->format('Y-m-d') === $keyword) {
                    $where[]  = "e.date_start = ?";
                    $params[] = $keyword;
                } else {
                    $where[] = "1 = 0";
                }
                break;

            // Pencarian teks (nama pasien, episode, ID Episode Of Care)
            default:
                $where[]  = $kolom_map[$keyword_by] . " LIKE ?";
                $params[] = '%' . $keyword . '%';
        }
    }

    $where_sql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

    // FROM/JOIN dipakai bersama oleh query hitung & query data
    $from_sql = "
        FROM episode_perawatan e
        LEFT JOIN pasien p ON p.id_pasien = e.id_pasien
        LEFT JOIN dokter d ON d.id_dokter = e.id_dokter
    ";

    // ------------------------------------------------------
    // 5. HITUNG TOTAL DATA & JUMLAH HALAMAN
    // ------------------------------------------------------
    $resCount = $Conn->execute_query("SELECT COUNT(*) AS total $from_sql $where_sql", $params);
    if (!$resCount) {
        BarisPesan('Gagal memuat data.', 'text-danger');
        exit;
    }
    $total_data = (int) $resCount->fetch_assoc()['total'];

    if ($total_data === 0) {
        BarisPesan('Tidak ada data episode perawatan yang ditemukan.');
        exit;
    }

    $page_count = (int) ceil($total_data / $batas);
    if ($page > $page_count) {
        $page = $page_count;
    }
    $offset = ($page - 1) * $batas;

    // ------------------------------------------------------
    // 6. AMBIL DATA HALAMAN AKTIF
    // $order_sql & $ShortBy aman karena berasal dari whitelist.
    // Urutan kedua (id) menjaga urutan stabil antar halaman.
    // ------------------------------------------------------
    $sql = "
        SELECT
            e.id_episode_perawatan,
            e.kode_episode_perawatan,
            e.IdEpisodeOfCare,
            e.id_pasien,
            e.episode_name,
            e.date_start,
            e.date_end,
            e.status,
            p.nama AS nama_pasien,
            d.nama AS nama_dokter
        $from_sql
        $where_sql
        ORDER BY $order_sql $ShortBy, e.id_episode_perawatan DESC
        LIMIT ? OFFSET ?
    ";
    $resData = $Conn->execute_query($sql, array_merge($params, [$batas, $offset]));

    if (!$resData) {
        BarisPesan('Gagal memuat data.', 'text-danger');
        exit;
    }

    // Warna badge status (status standar FHIR EpisodeOfCare)
    $badge_status = [
        'planned'          => 'secondary',
        'waitlist'         => 'info',
        'active'           => 'success',
        'onhold'           => 'warning',
        'finished'         => 'primary',
        'cancelled'        => 'danger',
        'entered-in-error' => 'dark'
    ];

    // ------------------------------------------------------
    // 7. RENDER BARIS TABEL
    // Baris pertama membawa data-page-count & data-current-page
    // yang dibaca jQuery untuk pagination
    // ------------------------------------------------------
    $no = $offset + 1;
    $baris_pertama = true;

    while ($row = $resData->fetch_assoc()) {

        // Escape semua output & batasi maksimal 15 karakter dengan fungsi BatasiKarakter()
        $id_ep                  = (int) $row['id_episode_perawatan'];
        $id_pasien              = (int) $row['id_pasien'];
        
        // Dibatasi maksimal 15 karakter dan ditambah titik 3 (...) jika melebihi
        $kode_episode_perawatan = BatasiKarakter($row['kode_episode_perawatan'] ?? '-', 15);
        $nama                   = BatasiKarakter($row['nama_pasien'] ?? '-', 15);
        $dokter                 = BatasiKarakter($row['nama_dokter'] ?? '-', 15);

        $episode                = htmlspecialchars($row['episode_name'] ?? '-');
        $id_eoc                 = htmlspecialchars($row['IdEpisodeOfCare'] ?? '-');
        $status                 = $row['status'] ?? '';
        $badge                  = $badge_status[$status] ?? 'secondary';

        // Tanggal: rentang mulai - selesai
        $start = FormatTanggal($row['date_start']);
        $end   = FormatTanggal($row['date_end']);

        // Atribut pagination hanya pada baris pertama
        $attr = '';
        $original_kode_ep = htmlspecialchars($row['kode_episode_perawatan'] ?? '-');
        if ($baris_pertama) {
            $attr = ' data-page-count="' . $page_count . '" data-current-page="' . $page . '"';
            $baris_pertama = false;
        }

        // Routing Tombol EpisodeOfCare
        if(empty($row['IdEpisodeOfCare'])){
            $buttonEoc='
                <a href="javascript:void(0);" class="btn btn-sm btn-outline-danger modal_kirim" data-id="'.$id_ep.'">
                    <i class="bi bi-send"></i> Kirim
                </a>
            ';
        }else{
            $buttonEoc='
                <a href="javascript:void(0);" class="btn btn-sm btn-outline-info modal_detail_episode_of_care" data-id="'.$id_eoc.'">
                    <i class="bi bi-info-circle"></i> Detail
                </a>
            ';
        }
        echo '
                <tr' . $attr . '>
                    <td align="center"><small class="text-muted">' . $no . '</small></td>
                    <td align="left">
                        <small>
                            <a href="javascript:void(0);" class="text-primary modal_detail" data-id="' . $id_ep . '" title="' . $original_kode_ep . '">
                                <small>' . $kode_episode_perawatan . '</small>
                            </a>
                        </small>
                    </td>
                    <td align="left"><small class="text-muted" title="' . htmlspecialchars($row['nama_pasien'] ?? '-') . '">' . $nama . '</small></td>
                    <td align="left">
                        <small>
                            <a href="javascript:void(0);" class="text-info modal_detail_pasien" data-id="' . $id_pasien . '">
                                <small>' . $id_pasien . '</small>
                            </a>
                        </small>
                    </td>
                    <td align="left"><small class="text-muted">' . $episode . '</small></td>
                    <td align="left"><small class="text-muted" title="' . htmlspecialchars($row['nama_dokter'] ?? '-') . '">' . $dokter . '</small></td>
                    <td align="left"><small class="text-muted">' . $start . '</small></td>
                    <td align="left"><small class="text-muted">' . $end . '</small></td>
                    <td align="left"><span class="badge bg-' . $badge . '">' . htmlspecialchars($status) . '</span></td>
                    <td align="left">
                        ' . $buttonEoc . '
                    </td>
                    <td class="icon-btn text-center">
                        <button type="button" class="btn btn-md btn-floating btn-option-outline" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Opsi Episode Perawatan">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item modal_detail" data-id="' . $id_ep . '">
                                    <i class="bi bi-info-circle"></i> Detail
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item modal_edit" data-id="' . $id_ep . '">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item text-danger modal_hapus" data-id="' . $id_ep . '">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
        ';

        $no++;
    }
?>