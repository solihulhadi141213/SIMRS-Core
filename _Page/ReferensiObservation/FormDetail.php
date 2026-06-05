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

    // VALIDASI id_observation_reference
    if (empty($_POST['id_observation_reference'])) {
        echo '
            <div class="alert alert-danger">
                <small>ID Referensi Tindakan tidak boleh kosong!</small>
            </div>
        ';
        exit;
    }

    // SANITASI INPUT
    $id_observation_reference = validateAndSanitizeInput($_POST['id_observation_reference']);

    // Buka Data Referensi Tindakan
    $sql  = "SELECT * FROM observation_reference WHERE id_observation_reference = ?";
    $stmt = $Conn->prepare($sql);
    $stmt->bind_param("i", $id_observation_reference);
    $stmt->execute();
    $result = $stmt->get_result();
    $Data   = $result->fetch_assoc();

    if (empty($Data)) {
        echo '
            <div class="alert alert-danger">
                <small>Data Referensi Tindakan Tidak Ditemukan!</small>
            </div>
        ';
        exit;
    }

    // Tutup Statment
    $stmt->close();

    // MAPPING DATA
    $id_observation_reference = $Data['id_observation_reference'] ?? null;
    $category_name            = $Data['category_name'] ?? '-';
    $category_code            = $Data['category_code'] ?? '-';
    $category_display         = $Data['category_display'] ?? '-';
    $category_system          = $Data['category_system'] ?? '-';
    $observation_name         = $Data['observation_name'] ?? '-';
    $observation_code         = $Data['observation_code'] ?? '-';
    $observation_display      = $Data['observation_display'] ?? '-';
    $observation_system       = $Data['observation_system'] ?? '-';
    $result_type              = $Data['result_type'] ?? '-';
    $unit_name                = $Data['unit_name'] ?? '-';
    $unit_code                = $Data['unit_code'] ?? '-';
    $unit_display             = $Data['unit_display'] ?? '-';
    $unit_system              = $Data['unit_system'] ?? '-';
   
    echo '
        <div class="row mb-2">
            <div class="col-12">
                <small><b>A. Kategori Observasi</b></small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Kategori</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$category_name.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Code</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$category_code.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Display</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$category_display.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>System</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$category_system.'</small>
            </div>
        </div>
        <hr>
    ';

    echo '
        <div class="row mb-2">
            <div class="col-12">
                <small><b>B. Observasi</b></small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small>Nama Observasi</small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$observation_name.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Code</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$observation_code.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Display</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$observation_display.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>System</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$observation_system.'</small>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-4"><small><i>Result Type</i></small></div>
            <div class="col-1"><small>:</small></div>
            <div class="col-7">
                <small class="text-muted">'.$result_type.'</small>
            </div>
        </div>
    ';
    if(!empty($Data['unit_name'])){
        echo '
            <hr>
            <div class="row mb-2">
                <div class="col-12">
                    <small><b>C. Unit</b></small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small>Nama Unit</small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$unit_name.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small><i>Code</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$unit_code.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small><i>Display</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$unit_display.'</small>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-4"><small><i>System</i></small></div>
                <div class="col-1"><small>:</small></div>
                <div class="col-7">
                    <small class="text-muted">'.$unit_system.'</small>
                </div>
            </div>
        ';
    }

    if(!empty($Data['result_coded'])){
        $result_coded      = $Data['result_coded'];
        $result_coded_arry = json_decode($result_coded, true);

        echo '
            <hr>
            <div class="row mb-2">
                <div class="col-12">
                    <small><b>C. Result Coded</b></small>
                </div>
            </div>
        ';

        echo '<ol>';
        foreach($result_coded_arry as $result_coded_list){
            $label = $result_coded_list['label'];
            $value = $result_coded_list['value'];
            echo '
                <li>
                    <small class="text-muted">'.$label.' ('.$value.')</small>
                </li>
            ';
        }
        echo '</ol>';
    }

?>
