<?php
    header('Content-Type: application/json; charset=utf-8');

    // =====================================================
    // CONNECTION, FUNCTION & SESSION
    // =====================================================
    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =====================================================
    // RESPONSE DEFAULT
    // =====================================================
    $response = [
        'status'  => 'error',
        'message' => 'Terjadi kesalahan'
    ];

    // =====================================================
    // VALIDASI SESSION
    // =====================================================
    if (empty($SessionIdAkses)) {
        $response['message'] = 'Sesi akses sudah berakhir!';

        echo json_encode($response);
        exit;
    }

    // =====================================================
    // VALIDASI ID DIAGNOSIS
    // =====================================================
    if (empty($_POST['id_diagnosis'])) {
        $response['message'] = 'ID Diagnosis tidak boleh kosong!';

        echo json_encode($response);
        exit;
    }

    // =====================================================
    // SANITASI INPUT
    // =====================================================
    $id_diagnosis = validateAndSanitizeInput($_POST['id_diagnosis']);

    // =====================================================
    // CEK DATA DIAGNOSIS
    // =====================================================
    $sqlDiagnosis = "
        SELECT
            id_diagnosis,
            id_kunjungan
        FROM diagnosis
        WHERE id_diagnosis = ?
        LIMIT 1
    ";

    $stmtDiagnosis = $Conn->prepare($sqlDiagnosis);

    if (!$stmtDiagnosis) {
        $response['message'] = 'Gagal mempersiapkan query diagnosis!';

        echo json_encode($response);
        exit;
    }

    $stmtDiagnosis->bind_param("i", $id_diagnosis);
    $stmtDiagnosis->execute();

    $resultDiagnosis = $stmtDiagnosis->get_result();
    $dataDiagnosis   = $resultDiagnosis->fetch_assoc();

    $stmtDiagnosis->close();

    if (empty($dataDiagnosis)) {
        $response['message'] = 'Data diagnosis tidak ditemukan!';

        echo json_encode($response);
        exit;
    }

    $id_kunjungan = $dataDiagnosis['id_kunjungan'];

    // =====================================================
    // HAPUS DATA
    // =====================================================
    $sqlDelete = "
        DELETE FROM diagnosis
        WHERE id_diagnosis = ?
    ";

    $stmtDelete = $Conn->prepare($sqlDelete);

    if (!$stmtDelete) {
        $response['message'] = 'Gagal mempersiapkan query hapus diagnosis!';

        echo json_encode($response);
        exit;
    }

    $stmtDelete->bind_param("i", $id_diagnosis);
    $proses = $stmtDelete->execute();
    $affectedRows = $stmtDelete->affected_rows;

    $stmtDelete->close();

    // =====================================================
    // RESPONSE
    // =====================================================
    if ($proses && $affectedRows > 0) {
        $response = [
            'status'       => 'success',
            'message'      => 'Data diagnosis berhasil dihapus',
            'id_kunjungan' => $id_kunjungan
        ];
    } else {
        $response['message'] = 'Gagal menghapus data diagnosis!';
    }

    echo json_encode($response);
?>
