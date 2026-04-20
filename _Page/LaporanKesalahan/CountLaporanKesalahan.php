<?php
    header('Content-Type: application/json');

    // Koneksi
    include "../../_Config/Connection.php";

    try {

        // Tangkap input
        $keyword_by = $_POST['keyword_by'] ?? '';
        $keyword    = $_POST['keyword'] ?? '';

        // Base query (pakai conditional aggregation biar 1x query)
        $sql = "
            SELECT
                COUNT(*) AS semua,
                SUM(CASE WHEN status = 'Terkirim' THEN 1 ELSE 0 END) AS terkirim,
                SUM(CASE WHEN status = 'Dibaca' THEN 1 ELSE 0 END) AS dibaca,
                SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) AS selesai
            FROM akses_laporan
        ";

        // Filter optional
        if ($keyword_by == 'status' && !empty($keyword)) {
            $sql .= " WHERE status = ?";
            $stmt = $Conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare gagal: " . $Conn->error);
            }

            $stmt->bind_param("s", $keyword);
        } else {
            $stmt = $Conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Prepare gagal: " . $Conn->error);
            }
        }

        // Eksekusi
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            throw new Exception("Gagal mengambil data");
        }

        $data = $result->fetch_assoc();

        // Pastikan tidak null
        $metadata = [
            "semua"    => (int)($data['semua'] ?? 0),
            "terkirim" => (int)($data['terkirim'] ?? 0),
            "dibaca"   => (int)($data['dibaca'] ?? 0),
            "selesai"  => (int)($data['selesai'] ?? 0),
        ];

        echo json_encode([
            "status"   => "success",
            "message"  => "Data berhasil diambil",
            "metadata" => $metadata
        ]);

        $stmt->close();
        $Conn->close();

    } catch (Exception $e) {

        echo json_encode([
            "status"  => "error",
            "message" => $e->getMessage()
        ]);
    }
?>