<?php
    // =====================================================
    // CONFIG
    // =====================================================
    error_reporting(E_ALL);
    ini_set('display_errors', 0);

    header('Content-Type: application/json');

    session_start();

    include "../../_Config/Connection.php";
    include "../../_Config/SimrsFunction.php";
    include "../../_Config/Session.php";

    // =====================================================
    // RESPONSE FUNCTION
    // =====================================================
    function response($status, $message)
    {
        echo json_encode([
            'status'  => $status,
            'message' => $message
        ]);

        exit;
    }

    // =====================================================
    // VALIDASI SESSION
    // =====================================================
    if (empty($SessionIdAkses)) {

        response(
            'error',
            'Session akses tidak valid!'
        );

    }

    // =====================================================
    // VALIDATE FUNCTION
    // =====================================================
    function validate($data)
    {
        return trim(
            htmlspecialchars(
                $data ?? '',
                ENT_QUOTES,
                'UTF-8'
            )
        );
    }

    // =====================================================
    // ESCAPE FUNCTION
    // =====================================================
    function escape($Conn, $value)
    {
        if ($value === null) {
            return null;
        }

        return mysqli_real_escape_string(
            $Conn,
            $value
        );
    }

    // =====================================================
    // AMBIL DATA
    // =====================================================
    $category_name     = validate($_POST['category_name'] ?? '');
    $category_code     = validate($_POST['category_code'] ?? '');
    $category_display  = validate($_POST['category_display'] ?? '');
    $category_system   = validate($_POST['category_system'] ?? '');

    $observation_name    = validate($_POST['observation_name'] ?? '');
    $observation_code    = validate($_POST['observation_code'] ?? '');
    $observation_display = validate($_POST['observation_display'] ?? '');
    $observation_system  = validate($_POST['observation_system'] ?? '');

    $unit_name     = validate($_POST['unit_name'] ?? '');
    $unit_code     = validate($_POST['unit_code'] ?? '');
    $unit_display  = validate($_POST['unit_display'] ?? '');
    $unit_system   = validate($_POST['unit_system'] ?? '');

    $result_type = validate($_POST['result_type'] ?? '');

    // =====================================================
    // VALIDASI MANDATORY
    // =====================================================
    if (empty($category_name)) {

        response(
            'error',
            'Kategori observasi tidak boleh kosong!'
        );

    }

    if (empty($observation_name)) {

        response(
            'error',
            'Nama observasi tidak boleh kosong!'
        );

    }

    if (empty($result_type)) {

        response(
            'error',
            'Result type tidak boleh kosong!'
        );

    }

    // =====================================================
    // VALIDASI UNIT
    // =====================================================
    if (
        $result_type == 'Numeric' ||
        $result_type == 'Decimal'
    ) {

        if (empty($unit_name)) {

            response(
                'error',
                'Satuan/unit wajib diisi!'
            );

        }

    }

    // =====================================================
    // VALIDASI DUPLIKAT
    // =====================================================
    $observation_name_escape = escape(
        $Conn,
        $observation_name
    );

    $queryCheck = mysqli_query(
        $Conn,
        "
        SELECT id_observation_reference
        FROM observation_reference
        WHERE observation_name='$observation_name_escape'
        LIMIT 1
        "
    );

    if (!$queryCheck) {

        response(
            'error',
            'Gagal validasi database!'
        );

    }

    if (mysqli_num_rows($queryCheck) > 0) {

        response(
            'error',
            'Nama observasi sudah digunakan!'
        );

    }

    // =====================================================
    // HANDLE RESULT CODED
    // =====================================================
    $result_coded = null;

    if ($result_type == 'Coded') {

        $labels = $_POST['label'] ?? [];
        $values = $_POST['value'] ?? [];

        $codedArray = [];

        if (
            is_array($labels) &&
            is_array($values)
        ) {

            foreach ($labels as $key => $label) {

                $label = trim($label ?? '');
                $value = trim($values[$key] ?? '');

                if (
                    !empty($label) &&
                    !empty($value)
                ) {

                    $codedArray[] = [
                        'label' => $label,
                        'value' => $value
                    ];

                }

            }

        }

        // Minimal 1 pilihan
        if (empty($codedArray)) {

            response(
                'error',
                'Alternatif jawaban coded belum diisi!'
            );

        }

        $result_coded = json_encode(
            $codedArray,
            JSON_UNESCAPED_UNICODE
        );

    }

    // =====================================================
    // ESCAPE DATA
    // =====================================================
    $category_name     = escape($Conn, $category_name);
    $category_code     = escape($Conn, $category_code);
    $category_display  = escape($Conn, $category_display);
    $category_system   = escape($Conn, $category_system);

    $observation_name    = escape($Conn, $observation_name);
    $observation_code    = escape($Conn, $observation_code);
    $observation_display = escape($Conn, $observation_display);
    $observation_system  = escape($Conn, $observation_system);

    $unit_name     = escape($Conn, $unit_name);
    $unit_code     = escape($Conn, $unit_code);
    $unit_display  = escape($Conn, $unit_display);
    $unit_system   = escape($Conn, $unit_system);

    $result_type   = escape($Conn, $result_type);
    $result_coded  = escape($Conn, $result_coded);

    // =====================================================
    // HANDLE NULL UNIT
    // =====================================================
    if (
        $result_type != 'Numeric' &&
        $result_type != 'Decimal'
    ) {

        $unit_name    = '';
        $unit_code    = '';
        $unit_display = '';
        $unit_system  = '';

    }

    // =====================================================
    // QUERY INSERT
    // =====================================================
    $queryInsert = mysqli_query(
        $Conn,
        "
        INSERT INTO observation_reference (

            category_name,
            category_code,
            category_display,
            category_system,

            observation_name,
            observation_code,
            observation_display,
            observation_system,

            unit_name,
            unit_code,
            unit_display,
            unit_system,

            result_type,
            result_coded

        ) VALUES (

            '$category_name',
            '$category_code',
            '$category_display',
            '$category_system',

            '$observation_name',
            '$observation_code',
            '$observation_display',
            '$observation_system',

            '$unit_name',
            '$unit_code',
            '$unit_display',
            '$unit_system',

            '$result_type',

            " . (
                $result_coded !== null
                    ? "'$result_coded'"
                    : "NULL"
            ) . "

        )
        "
    );

    // =====================================================
    // RESPONSE
    // =====================================================
    if ($queryInsert) {

        response(
            'success',
            'Referensi observation berhasil ditambahkan!'
        );

    } else {

        response(
            'error',
            'Gagal menyimpan data! ' . mysqli_error($Conn)
        );

    }
?>