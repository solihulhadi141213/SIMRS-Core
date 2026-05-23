<?php
    // Connection, Function & Session
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // VALIDASI SESSION
    if (empty($SessionIdAkses)) {
        echo '
            <div class="alert alert-danger">
                <small>Sesi akses sudah berakhir! Silahkan login ulang.</small>
            </div>
        ';
        exit;
    }

    // VALIDASI ID KUNJUNGAN
    if (empty($_POST['id_kunjungan'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Kunjungan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_kunjungan = validateAndSanitizeInput($_POST['id_kunjungan']);

    // DETAIL KUNJUNGAN & PASIEN
    $sql = "
        SELECT 
            k.*,
            k.status AS status_kunjungan,

            p.id_pasien,
            p.nama,
            p.nik,
            p.no_bpjs,
            p.id_ihs,
            p.gender,
            p.status AS status_pasien

        FROM kunjungan k

        LEFT JOIN pasien p 
            ON k.id_pasien = p.id_pasien

        WHERE k.id_kunjungan = ?
    ";

    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_kunjungan);
    $stmt->execute();
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();
    if (empty($Data)) {
        echo '
            <div class="alert alert-danger">
                <small>Data kunjungan tidak ditemukan!</small>
            </div>
        ';
        exit;
    }

    /// MAPPING DATA PASIEN
    $id_pasien       = $Data['id_pasien'] ?? null;
    $nama            = $Data['nama'] ?? null;
    $gender          = $Data['gender'] ?? null;
    $id_ihs          = $Data['id_ihs'] ?? null;
    

    // MAPPING DATA KUNJUNGAN
    $jenis_kunjungan = $Data['jenis_kunjungan'] ?? null;
    $datetime_daftar = $Data['datetime_daftar'] ?? null;
    $id_encounter = $Data['id_encounter'] ?? null;

    // Close
    $stmt->close();

    // FORMAT TANGGAL DAFTAR
    if (!empty($datetime_daftar)) {
        $datetime_daftar = date('d/m/Y H:i', strtotime($datetime_daftar));
    }

    
?>

<!-- ===================================================== -->
<!-- INFORMASI PASIEN & KUNJUNGAN -->
<!-- ===================================================== -->
 <input type="hidden" id="put_id_kunjungan" value="<?php echo $id_kunjungan; ?>">
<div class="row mb-3">

    <div class="col-md-6">

        <b class="mb-2">A. Informasi Pasien</b>

        <div class="row mb-2">
            <div class="col-4"><small>No.RM</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $id_pasien; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Nama Pasien</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $nama; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Gender</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $gender; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>ID IHS</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $id_ihs; ?>
                </small>
            </div>
        </div>

    </div>

    <div class="col-md-6">

        <b class="mb-2">B. Informasi Kunjungan</b>

        <div class="row mb-2">
            <div class="col-4"><small>No.REG</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $id_kunjungan; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Tujuan/Jenis</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $jenis_kunjungan; ?>
                </small>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-4"><small>Tanggal Daftar</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $datetime_daftar; ?>
                </small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>ID Encounter</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">
                    <?php echo $id_encounter; ?>
                </small>
            </div>
        </div>

    </div>

</div>
<hr>
<div class="row mb-3">
    <div class="col-12">
        <b class="mb-2">C. Riwayat Alergi Pasien <i>(SATUSEHAT)</i></b>
    </div>
</div>
<?php
    // MEMBUKA RIWAYAT AllergyIntolerance
    if(empty($id_ihs)){
        echo '
            <div class="alert alert-warning text-center mt-3">
                <small>
                    Riwayat Alergi Dari SATUSEHAT Tidak Dapat Ditampilkan Karena Pasien Belum Terdaftar.
                </small>
            </div>
        ';
    }else{
        // Buka Pengaturan Satusehat
        $query_setting = mysqli_query($Conn,"SELECT * FROM setting_satusehat WHERE status_setting_satusehat='1' LIMIT 1");
        $setting = mysqli_fetch_assoc($query_setting);
        $baseurl_satusehat = rtrim($setting['url_satusehat'] ?? '', '/');
        if (empty($baseurl_satusehat)) {
            echo '
                <div class="alert alert-warning text-center mt-3">
                    <small>
                        URL SATUSEHAT tidak ditemukan pada pengaturan koneksi
                    </small>
                </div>
            ';
        }else{
            // Generate Token
            $tokenResult = generateTokenSatuSehat($Conn);
            if (($tokenResult['status'] ?? '') !== 'success') {
                echo '
                    <div class="alert alert-warning text-center mt-3">
                        <small>
                            <b>Generate token gagal!</b><br>Keterangan : '.$tokenResult['message'].'
                        </small>
                    </div>
                ';
            }else{
                $token = $tokenResult['token'];
                
                // URL
                $url = $baseurl_satusehat . '/fhir-r4/v1/AllergyIntolerance?patient='.$id_ihs.'';

                // CURL
                $ch = curl_init($url);
                curl_setopt_array($ch, [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HEADER         => false,
                    CURLOPT_ENCODING       => '',
                    CURLOPT_MAXREDIRS      => 10,
                    CURLOPT_TIMEOUT        => 60,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_CUSTOMREQUEST  => 'GET',
                    CURLOPT_HTTPHEADER     => [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $token
                    ],
                ]);

                // Response
                $response   = curl_exec($ch);
                $httpcode   = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curl_error = curl_error($ch);
                curl_close($ch);

                // Curl Error
                if (!empty($curl_error)) {
                    echo '
                        <div class="alert alert-warning text-center mt-3">
                            <small>
                                CURL Error : '.$curl_error.'
                            </small>
                        </div>
                    ';
                }else{
                    // Decode JSON
                    $result = json_decode($response, true);

                    // Vlidasi Data JSON
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        echo '
                            <div class="alert alert-warning text-center mt-3">
                                <small>Response SATUSEHAT tidak valid!</small>
                            </div>
                        ';
                    }else{
                        if ($httpcode >= 400) {
                            $issue_text = $result['issue'][0]['details']['text'] ?? 'Terjadi kesalahan pada SATUSEHAT';
                            echo '
                                <div class="alert alert-danger">
                                    <small>
                                        <b>HTTP CODE :</b> '.$httpcode.'<br>
                                        <b>Message :</b> '.$issue_text.'
                                    </small>
                                </div>
                            ';
                        }else{

                            // Validasi apakah ada data entry
                            if (empty($result['entry'])) {
                                echo '
                                    <div class="alert alert-info text-center mt-3">
                                        <small>Tidak ada riwayat alergi ditemukan.</small>
                                    </div>
                                ';
                            } else {
                                // Menampilkan Raw
                                $responseData = json_decode($response, true);
                                echo '
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <textarea class="form-control">'.json_encode($responseData,JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).'</textarea>
                                        </div>
                                    </div>
                                ';

                                // Alert
                                echo '
                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                <small>
                                                    Berikut ini adalah informasi riwayat alergi dari resource SATUSEHAT berdasarkan ID IHS Pasien.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                ';
                                echo '
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <td><small><b>No</b></small></td>
                                                    <td><small><b>Kategori</b></small></td>
                                                    <td><small><b>Alergi</b></small></td>
                                                    <td><small><b>Status Klinis</b></small></td>
                                                    <td><small><b>Status Verifikasi</b></small></td>
                                                    <td><small><b>Tanggal Dicatat</b></small></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                ';

                                $no = 1;

                                foreach ($result['entry'] as $item) {

                                    $resource = $item['resource'] ?? [];

                                    // Ambil kategori
                                    $category = $resource['category'][0] ?? '-';

                                    // Nama alergi
                                    $alergi = $resource['code']['coding'][0]['display'] ?? '-';

                                    // Keterangan/text
                                    $keterangan = $resource['code']['text'] ?? '';

                                    // Status klinis
                                    $clinical = $resource['clinicalStatus']['coding'][0]['code'] ?? '-';

                                    // Status verifikasi
                                    $verification = $resource['verificationStatus']['coding'][0]['code'] ?? '-';

                                    // Tanggal dicatat
                                    $recordedDate = $resource['recordedDate'] ?? '';

                                    // Format tanggal
                                    if (!empty($recordedDate)) {
                                        $recordedDate = date('d/m/Y H:i', strtotime($recordedDate));
                                    } else {
                                        $recordedDate = '-';
                                    }

                                    echo '
                                        <tr>
                                            <td class="text-center">'.$no.'</td>
                                            <td>'.$category.'</td>
                                            <td>
                                                <b>'.$alergi.'</b><br>
                                                <small class="text-muted">'.$keterangan.'</small>
                                            </td>
                                            <td>'.$clinical.'</td>
                                            <td>'.$verification.'</td>
                                            <td>'.$recordedDate.'</td>
                                        </tr>
                                    ';

                                    $no++;
                                }

                                echo '
                                            </tbody>
                                        </table>
                                    </div>
                                ';
                            }
                        }
                    }
                }
            }
        }
    }
?>
<hr>
<div class="row mb-3">
    <div class="col-12">
        <button type="button" class="btn btn-md btn-primary w-100 rounded-2 modal_tambah_alergi" data-id="<?php echo $id_kunjungan; ?>">
            <i class="bi bi-plus"></i> Tambah Riwayat Alergi
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td class="text-center"><small><b>No</b></small></td>
                        <td class="text-left"><small><b>Tanggal</b></small></td>
                        <td class="text-left"><small><b>Kategori</b></small></td>
                        <td class="text-left"><small><b>Alergen</b></small></td>
                        <td class="text-left"><small><b>Klinis</b></small></td>
                        <td class="text-left"><small><b>Verifikasi</b></small></td>
                        <td class="text-left"><small><b><i>Performer</i></b></small></td>
                        <td class="text-center"><small><b><i>AI</i></b></small></td>
                        <td class="text-center"><small><b>Opsi</b></small></td>
                    </tr>
                </thead>
                <tbody>
                   
                    <?php
                        $jumlah_alergi = mysqli_num_rows(mysqli_query($Conn, "SELECT id_alergi FROM alergi WHERE id_pasien='$id_pasien'"));
                        if(empty($jumlah_alergi)){
                            echo '
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <small class="text-muted">
                                            Riwayat Alergi Tidak Ditemukan Pada Database SIMRS
                                        </small>
                                    </td>
                                </tr>
                            ';
                            exit;
                        }
                        $SqlAlergi = "SELECT * FROM alergi WHERE id_pasien = ? ORDER BY id_alergi_alergen DESC";
                        $stmt_alergi = $Conn->prepare($SqlAlergi);
                        $stmt_alergi->bind_param("i", $id_pasien);
                        $stmt_alergi->execute();
                        $result_alergi = $stmt_alergi->get_result();

                        // Menampilkan Daftar
                        $no = 1;
                        while ($row = $result_alergi->fetch_assoc()) {
                            $id_alergi           = $row['id_alergi'] ?? 0;
                            $clinical_status     = $row['clinical_status'];
                            $verification_status = $row['verification_status'];
                            $id_praktisi         = $row['id_praktisi'];
                            $nama_praktisi       = $row['nama_praktisi'];
                            $author_id           = $row['author_id'];
                            $author_name         = $row['author_name'];
                            $datetime_creat      = $row['datetime_creat'];

                            // Fixed String
                            $clinical_status = ucfirst($clinical_status);
                            $verification_status = ucfirst($verification_status);

                            // Kategori Dan Nama
                            if(empty($row['id_alergi_alergen'])){
                                $kategori_alergen = $row['kategori_alergen'];
                                $nama_alergen     = $row['nama_alergen'];
                            }else{
                                $id_alergi_alergen   = $row['id_alergi_alergen'];
                                $kategori_alergen    = getDataDetail_v2($Conn, 'alergi_alergen', 'id_alergi_alergen', $id_alergi_alergen, 'kategori_alergen');
                                $nama_alergen        = getDataDetail_v2($Conn, 'alergi_alergen', 'id_alergi_alergen', $id_alergi_alergen, 'nama_alergen');
                                $nama_alergen        = '<a href="javascript:void(0);" class="text-primary modal_detail_alergen" data-id="'.$id_alergi_alergen.'">'.$nama_alergen.'</a>';
                            }

                            // Format Tanggal
                            if(!empty($datetime_creat)){
                                $datetime_creat_format = date('d/m/Y H:i', strtotime($datetime_creat));
                            }else{
                                $datetime_creat_format = '-';
                            }

                            // Praktisi
                            if(empty($row['id_praktisi'])){
                                $nama_praktisi = $row['nama_praktisi'];
                            }else{
                                $id_praktisi   = $row['id_praktisi'];
                                $nama_praktisi = getDataDetail_v2($Conn, 'praktisi', 'id_praktisi', $id_praktisi, 'nama_praktisi');
                                $nama_praktisi        = '<a href="javascript:void(0);" class="text-primary modal_detail_praktisi" data-id="'.$id_praktisi.'">'.$nama_praktisi.'</a>';
                            }

                            //$AllergyIntolerance
                            if(empty($row['AllergyIntolerance'])){
                                $button_ai = '
                                    <button type="button" class="btn btn-sm btn-danger modal_kirim_alergi" data-id="'.$id_alergi.'">
                                        <i class="bi bi-send"></i> Kirim
                                    </button>
                                ';
                            }else{
                                $AllergyIntolerance  = $row['AllergyIntolerance'];
                                $button_ai = '
                                    <button type="button" class="btn btn-sm btn-info modal_detail_allergy_intolerance" data-id="'.$AllergyIntolerance.'">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                ';
                            }
                            

                            echo '
                                <tr>
                                    <td class="text-center"><small class="text-muted">'.$no.'</small></td>
                                    <td class="text-left"><small class="text-muted">'.$datetime_creat_format.'</small></td>
                                    <td class="text-left"><small class="text-muted">'.$kategori_alergen.'</small></td>
                                    <td class="text-left"><small class="text-muted">'.$nama_alergen.'</small></td>
                                    <td class="text-left"><small class="text-muted">'.$clinical_status.'</small></td>
                                    <td class="text-left"><small class="text-muted">'.$verification_status.'</small></td>
                                    <td class="text-left"><small class="text-muted">'.$nama_praktisi.'</small></td>
                                    <td class="text-center"><small class="text-muted">'.$button_ai.'</small></td>
                                    <td class="text-center icon-btn">
                                        <button type="button" class="btn btn-floating" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu shadow">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item modal_detail" data-id="'.$id_alergi.'">
                                                    <i class="bi bi-info-circle"></i> Detail Alergi
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item modal_edit" data-id="'.$id_alergi.'">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item modal_hapus" data-id="'.$id_alergi.'">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            ';

                            $no++;
                        }
                        $result_alergi->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>