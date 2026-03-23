<?php

    function getAnalyzaToken($Conn) {

        $id_setting = getDataDetail_v2($Conn, 'setting_analyza', 'status', 1, 'id_setting_analyza');
        if (empty($id_setting)) {
            return ['status' => 'error', 'message' => 'Setting Radix tidak ditemukan'];
        }

        $base_url   = getDataDetail_v2($Conn, 'setting_analyza', 'status', 1, 'base_url');
        $username   = getDataDetail_v2($Conn, 'setting_analyza', 'status', 1, 'username');
        $password   = getDataDetail_v2($Conn, 'setting_analyza', 'status', 1, 'password');
        $expired_at = getDataDetail_v2($Conn, 'setting_analyza', 'status', 1, 'expired_at');
        $token      = getDataDetail_v2($Conn, 'setting_analyza', 'status', 1, 'token');

        // Token masih valid
        if (!empty($token) && $expired_at > date('Y-m-d H:i:s')) {
            return ['status' => 'success', 'token' => $token, 'base_url' => $base_url];
        }

        // Request token baru
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $base_url . '/_API/GenerateToken.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'username' => $username,
                'password' => $password
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded'
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($response, true);

        if (empty($result) || $result['status'] !== 'success') {
            return ['status' => 'error', 'message' => 'Gagal membuat token'];
        }

        $token_new  = $result['token'];
        $expired_at = $result['token_expired_at'];
        $created_at = $result['created_at'];

        // Simpan token baru
        $update = $Conn->prepare("
            UPDATE setting_analyza 
            SET token = ?, creat_at = ?, expired_at = ?, status = 1
            WHERE id_setting_analyza = ?
        ");
        $update->bind_param("sssi", $token_new, $created_at, $expired_at, $id_setting);
        $update->execute();
        $update->close();

        return ['status' => 'success', 'token' => $token_new, 'base_url' => $base_url];
    }

?>