<?php
    date_default_timezone_set('Asia/Jakarta');

    include "../../_Config/Connection.php";
    include "../../_Config/Session.php";
    include "../../_Config/SimrsFunction.php";

    header('Content-Type: application/json');

    // ===============================
    // VALIDASI SESSION
    // ===============================
    if (empty($SessionIdAkses)) {
        echo json_encode([
            "status" => "error",
            "message" => "Sesi berakhir"
        ]);
        exit;
    }

    // ===============================
    // AMBIL INPUT
    // ===============================
    $id_akses_pengajuan = $_POST['id_akses_pengajuan'] ?? '';
    $status             = $_POST['status_pengajuan'] ?? '';
    $password           = $_POST['password_pengguna'] ?? '';
    $id_entitas         = $_POST['id_akses_entitas'] ?? '';
    $alasan             = $_POST['alasan_penolakan'] ?? '';
    $kirim_email        = $_POST['kirim_pemberitahuan'] ?? '';

    // ===============================
    // VALIDASI DASAR
    // ===============================
    if (empty($id_akses_pengajuan)) {
        echo json_encode(["status"=>"error","message"=>"ID tidak valid"]);
        exit;
    }

    if (empty($status)) {
        echo json_encode(["status"=>"error","message"=>"Status wajib dipilih"]);
        exit;
    }

    // ===============================
    // AMBIL DATA PENGAJUAN
    // ===============================
    $stmt = $Conn->prepare("SELECT * FROM akses_pengajuan WHERE id_akses_pengajuan=?");
    $stmt->bind_param("i", $id_akses_pengajuan);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$data) {
        echo json_encode(["status"=>"error","message"=>"Data tidak ditemukan"]);
        exit;
    }

    // ===============================
    // AMBIL EMAIL GATEWAY AKTIF
    // ===============================
    $id_gateway = null;
    $q = $Conn->query("SELECT id_setting_email_gateway FROM setting_email_gateway WHERE status=1 LIMIT 1");
    if ($row = $q->fetch_assoc()) {
        $id_gateway = $row['id_setting_email_gateway'];
    }

    // ===============================
    // JIKA DITOLAK
    // ===============================
    if ($status == "Ditolak") {

        if (empty($alasan)) {
            echo json_encode(["status"=>"error","message"=>"Alasan penolakan wajib diisi"]);
            exit;
        }

        $stmt = $Conn->prepare("UPDATE akses_pengajuan SET status='Ditolak', keterangan=? WHERE id_akses_pengajuan=?");
        $stmt->bind_param("si", $alasan, $id_akses_pengajuan);
        $stmt->execute();
        $stmt->close();

        // Kirim Email
        if ($kirim_email == "1" && $id_gateway) {
            $subjek = "Pengajuan Akses Ditolak";
            $pesan  = "Pengajuan akses Anda ditolak.<br><br>Alasan:<br>$alasan";

            SendEmail($Conn, $id_gateway, $subjek, $data['email'], $data['nama'], $pesan);
        }

        echo json_encode(["status"=>"success"]);
        exit;
    }

    // ===============================
    // JIKA DITERIMA
    // ===============================
    if ($status == "Diterima") {

        if (empty($id_entitas)) {
            echo json_encode(["status"=>"error","message"=>"Entitas akses wajib dipilih"]);
            exit;
        }

        if (empty($password)) {
            echo json_encode(["status"=>"error","message"=>"Password wajib diisi"]);
            exit;
        }

        // ===============================
        // VALIDASI DUPLIKASI
        // ===============================
        $stmt = $Conn->prepare("SELECT id_akses FROM akses WHERE email=? OR kontak=? LIMIT 1");
        $stmt->bind_param("ss", $data['email'], $data['kontak']);
        $stmt->execute();
        $cek = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($cek) {
            echo json_encode([
                "status"=>"error",
                "message"=>"Email atau kontak sudah terdaftar pada akun lain"
            ]);
            exit;
        }

        // ===============================
        // HASH PASSWORD
        // ===============================
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // ===============================
        // HANDLE FOTO
        // ===============================
        $foto_lama = $data['foto'];
        $foto_baru = null;

        if (!empty($foto_lama)) {
            $source = "../../assets/images/PengajuanAkses/" . $foto_lama;
            $target = "../../assets/images/user/" . $foto_lama;

            if (file_exists($source)) {
                copy($source, $target);
                $foto_baru = $foto_lama;
            }
        }

        // ===============================
        // INSERT AKSES
        // ===============================
        $akses_role = "User";

        $stmt = $Conn->prepare("
            INSERT INTO akses 
            (id_akses_pengajuan, id_akses_entitas, tanggal, nama, nik, email, kontak, password, akses, gambar, updatetime)
            VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "iisssssss",
            $id_akses_pengajuan,
            $id_entitas,
            $data['nama'],
            $data['nik'],
            $data['email'],
            $data['kontak'],
            $password_hash,
            $akses_role,
            $foto_baru
        );

        $stmt->execute();
        $id_akses = $stmt->insert_id;
        $stmt->close();

        // ===============================
        // COPY HAK AKSES
        // ===============================
        $q = $Conn->prepare("SELECT id_akses_fitur FROM akses_entitas_acc WHERE id_akses_entitas=?");
        $q->bind_param("i", $id_entitas);
        $q->execute();
        $result = $q->get_result();

        while ($row = $result->fetch_assoc()) {
            $stmt = $Conn->prepare("INSERT INTO akses_acc (id_akses, id_akses_fitur) VALUES (?, ?)");
            $stmt->bind_param("ii", $id_akses, $row['id_akses_fitur']);
            $stmt->execute();
            $stmt->close();
        }

        $q->close();

        // ===============================
        // UPDATE STATUS
        // ===============================
        $stmt = $Conn->prepare("UPDATE akses_pengajuan SET status='Diterima' WHERE id_akses_pengajuan=?");
        $stmt->bind_param("i", $id_akses_pengajuan);
        $stmt->execute();
        $stmt->close();

        // ===============================
        // KIRIM EMAIL
        // ===============================
        if ($kirim_email == "1" && $id_gateway) {

            $subjek = "Pengajuan Akses Diterima";

            $pesan = "
                Pengajuan akses Anda telah diterima.<br><br>
                Email: {$data['email']}<br>
                Password: $password<br><br>
                Silakan login dan segera ubah password Anda.
            ";

            SendEmail($Conn, $id_gateway, $subjek, $data['email'], $data['nama'], $pesan);
        }

        echo json_encode(["status"=>"success"]);
        exit;
    }

    // ===============================
    echo json_encode([
        "status" => "error",
        "message" => "Status tidak valid"
    ]);
?>