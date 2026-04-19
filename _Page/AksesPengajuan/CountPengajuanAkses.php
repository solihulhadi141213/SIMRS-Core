<?php
    header('Content-Type: application/json');

    // Koneksi
    include "../../_Config/Connection.php";

    try {

        // Tangkap input
        $keyword_by = $_POST['keyword_by'] ?? '';
        $keyword    = $_POST['keyword'] ?? '';

        // Default Query
        $where = "";
        $param = [];
        $types = "";

        // Filter jika berdasarkan status
        if ($keyword_by == 'status' && !empty($keyword)) {
            $where = "WHERE status = ?";
            $param[] = $keyword;
            $types .= "s";
        }

        // =========================
        // TOTAL
        // =========================
        $query_total = "SELECT COUNT(*) as total FROM akses_pengajuan $where";
        $stmt_total  = $Conn->prepare($query_total);

        if (!empty($param)) {
            $stmt_total->bind_param($types, ...$param);
        }

        $stmt_total->execute();
        $result_total = $stmt_total->get_result()->fetch_assoc();
        $total = $result_total['total'] ?? 0;

        // =========================
        // PENDING
        // =========================
        $query_pending = "SELECT COUNT(*) as total FROM akses_pengajuan WHERE status='Pending'";
        $result_pending = $Conn->query($query_pending)->fetch_assoc();
        $pending = $result_pending['total'] ?? 0;

        // =========================
        // DITOLAK
        // =========================
        $query_ditolak = "SELECT COUNT(*) as total FROM akses_pengajuan WHERE status='Ditolak'";
        $result_ditolak = $Conn->query($query_ditolak)->fetch_assoc();
        $ditolak = $result_ditolak['total'] ?? 0;

        // =========================
        // DITERIMA
        // =========================
        $query_diterima = "SELECT COUNT(*) as total FROM akses_pengajuan WHERE status='Diterima'";
        $result_diterima = $Conn->query($query_diterima)->fetch_assoc();
        $diterima = $result_diterima['total'] ?? 0;

        // =========================
        // RESPONSE
        // =========================
        echo json_encode([
            "status"   => "success",
            "message"  => "Data berhasil diambil",
            "metadata" => [
                "total"    => (int)$total,
                "pending"  => (int)$pending,
                "ditolak"  => (int)$ditolak,
                "diterima" => (int)$diterima
            ]
        ]);

    } catch (Exception $e) {
        echo json_encode([
            "status"  => "error",
            "message" => $e->getMessage()
        ]);
    }
?>