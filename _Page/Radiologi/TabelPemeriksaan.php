<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "FungsiRadiologi.php";

    // Input
    $modality = $_POST['modality'] ?? "";
    $keyword = $_POST['keyword_pemeriksaan'] ?? "";
    $page    = $_POST['page_pemeriksaan'] ?? 1;
    $limit   = 10;

    // Validasi $modality
    if(empty($modality)){
        echo '<tr><td colspan="4" class="text-danger text-center">Pilih Modality terlebih dulu</td></tr>';
        exit;
    }

    // Ambil token Radix
    $tokenData = getRadixToken($Conn);

    if ($tokenData['status'] !== 'success') {
        echo '<tr><td colspan="4" class="text-danger text-center">'.$tokenData['message'].'</td></tr>';
        exit;
    }

    $token   = $tokenData['token'];
    $baseUrl = $tokenData['base_url'];

    // Call API Pemeriksaan
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $baseUrl . "/_API/pemeriksaan?modalitas=$modality&keyword=$keyword&limit=$limit&page=$page",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer $token"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    $result = json_decode($response, true);

    // Validasi API Response
    if (empty($result) || $result['status'] !== 'success') {
        echo '<tr><td colspan="4" class="text-danger text-center">Gagal mengambil data pemeriksaan</td></tr>';
        exit;
    }

    $data = $result['data'] ?? [];

    // Jika kosong
    if (count($data) === 0) {
        echo '<tr><td colspan="4" class="text-center">No Data</td></tr>';
        exit;
    }

    // Render Table Rows
    $no = 1 + (($page - 1) * $limit);

    foreach ($data as $row) {
       $json = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');

        echo '
            <tr class="pilih_pemeriksaan" 
                data-json="'.$json.'" 
                data-id="'.$row['id_master_pemeriksaan'].'" 
                data-name="'.$row['nama_pemeriksaan'].'"
                style="cursor:pointer;">
                <td>'.$no.'</td>
                <td>'.$row['nama_pemeriksaan'].'</td>
                <td><i>'.$row['bodysite_description'].'</i></td>
                <td>'.$row['modalitas'].'</td>
            </tr>
        ';
        $no++;
    }
    $meta = $result['meta'];
    echo "
        <script>
            $('#page_info_pemeriksaan').text('{$meta['page']} / {$meta['total_pages']}');
        </script>
    ";
?>