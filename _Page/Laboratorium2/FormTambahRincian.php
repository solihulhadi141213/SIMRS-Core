<?php
    //Koneksi
    date_default_timezone_set('Asia/Jakarta');
    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";
    include "FungsiLaboratorium.php";

    // Validasi Akses
    if(empty($_SESSION['id_akses'])){
        echo '<div class="alert alert-danger text-center">Sesi Akses Sudah Berakhir! Silahkan Login Ulang!</div>';
        exit;
    }

    // Validasi Data yang Wajib Terisi Atau Ada
    if(empty($_POST['id_laboratorium'])){
        echo '<div class="alert alert-danger text-center">ID Laboratorium Tidak Boleh Kosong!</div>';
        exit;
    }

    // Buat Variabel
    $id_laboratorium = $_POST['id_laboratorium'];

    // Ambil token Radix
    $tokenData = getAnalyzaToken($Conn);

    if ($tokenData['status'] !== 'success') {
        echo '<div class="alert alert-danger text-center">'.$tokenData['message'].'</div>';
        exit;
    }

    $token   = $tokenData['token'];
    $baseUrl = $tokenData['base_url'];

    // Call API Pemeriksaan
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $baseUrl . "/_API/DetailPemeriksaan?id_laboratorium=$id_laboratorium",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $token"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($response, true);

    // Validasi API Response
    if (empty($result)) {
        echo '<div class="alert alert-danger text-center">Gagal Mengambil Data</div>';
        exit;
    }
    if ($result['status'] !== 'success') {
        echo '<div class="alert alert-danger text-center">'.$result['message'].'</div>';
        exit;
    }
    $rincian_pemeriksaan = $result['rincian'] ?? [];

    // Form Hidden
    echo '<input type="hidden" name="id_laboratorium" value="'.$id_laboratorium.'">';
?>

<div class="row mb-3">
    <div class="col-12">
        <dt>Silahkan pilih beberapa parameter pemeriksaan yang ingin ditambahkan.</dt>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="table table-responsive">
            <table class="table table-hover table-sm">
                <tbody>
                    <?php
                        // Call API Pemeriksaan
                        $curl = curl_init();
                        curl_setopt_array($curl, [
                            CURLOPT_URL => $baseUrl . "/_API/ReferensiPemeriksaan.php",
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_HTTPHEADER => [
                                "Authorization: Bearer $token"
                            ],
                        ]);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        $result = json_decode($response, true);

                        // Validasi API Response
                        if (empty($result)) {
                            echo '<tr><td colspan="4" class="text-center text-danger">Terjadi Kesalahan pada saat meminta data dari Analyza</td></tr>';
                            exit;
                        }

                        if ($result['status'] !== 'success') {
                            echo '<tr><td colspan="4" class="text-center text-danger">Terjadi Kesalahan pada saat meminta data dari Analyza <br> <i>'.$result['message'].'</i></td></tr>';
                            exit;
                        }
                        $data = $result['data'] ?? [];
                        
                        // Jika kosong
                        if (count($data) === 0) {
                            echo '<tr><td colspan="4" class="text-center text-danger">Data ATidak Ditemukan</td></tr>';
                            exit;
                        }

                        // Render Table Rows
                        $no = 1;
                        foreach ($data as $row) {
                            $category_pemeriksaan = $row['category_pemeriksaan'];
                            $list_by_category = $row['list_by_category'];
                            echo '
                                <tr>
                                    <td colspan="4"><dt>'.$category_pemeriksaan.'</dt></td>
                                </tr>
                            ';

                            $no2 = 1;
                            foreach ($list_by_category as $row2) {
                                $id_referensi_pemeriksaan = $row2['id_referensi_pemeriksaan'];
                                $nama_pemeriksaan         = $row2['nama_pemeriksaan'];
                                $code_pemeriksaan         = $row2['code_pemeriksaan'];
                                $display_pemeriksaan      = $row2['display_pemeriksaan'];

                                // Memeriksa Apakah Rincian Sudah Ada Atau Belum
                                $status_ada = 0;
                                foreach ($rincian_pemeriksaan as $rincian_pemeriksaan_list){
                                    if($id_referensi_pemeriksaan==$rincian_pemeriksaan_list['id_referensi_pemeriksaan']){
                                        $status_ada = 1;
                                    }
                                }
                                if(empty($status_ada)){
                                    $tombol_opsi_rincian = '
                                        <input type="checkbox" name="id_referensi_pemeriksaan[]" id="id_referensi_pemeriksaan_tambah'.$no.'_'.$no2.'" class="form-check-input" value="'.$id_referensi_pemeriksaan.'|'.$nama_pemeriksaan.'|'.$category_pemeriksaan.'">
                                    ';
                                }else{
                                     $tombol_opsi_rincian = '
                                        <span class="text-success">
                                            <i class="ti ti-check-box"></i>
                                        </span>
                                    ';
                                }
                                echo '
                                    <tr class="row-pemeriksaan" data-target="id_referensi_pemeriksaan'.$no.'_'.$no2.'">
                                        <td class="text-right text-muted">'.$no.'.'.$no2.'</td>
                                        <td class="text-left text-muted">'.$nama_pemeriksaan.'</td>
                                        <td class="text-left text-muted">'.$code_pemeriksaan.'</td>
                                        <td class="text-center">'.$tombol_opsi_rincian.'</td>
                                    </tr>
                                ';
                                $no2++;
                            }
                            $no++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
