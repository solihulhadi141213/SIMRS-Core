<?php
    include "../../_Config/Connection.php";

    $keyword_by = trim($_POST['keyword_by'] ?? '');

    // =========================================================================
    // FILTER TIPE PRAKTISI
    // =========================================================================
    if ($keyword_by == 'tipe_praktisi') {

        echo '
            <select name="keyword" id="keyword_select" class="form-select">
                <option value="">Pilih</option>
                <option value="Medis">Medis</option>
                <option value="Non Medis">Non Medis</option>
            </select>
        ';

        exit;
    }

    // =========================================================================
    // FILTER PROFESI PRAKTISI
    // =========================================================================
    if ($keyword_by == 'profesi_praktisi') {

        echo '
            <select name="keyword" id="keyword_select" class="form-select">
                <option value="">Pilih Profesi</option>
        ';

        $query = mysqli_query($Conn, "
            SELECT DISTINCT profesi_praktisi
            FROM praktisi
            WHERE profesi_praktisi IS NOT NULL
            AND profesi_praktisi != ''
            ORDER BY profesi_praktisi ASC
        ");

        while ($data = mysqli_fetch_assoc($query)) {

            $profesi = htmlspecialchars($data['profesi_praktisi']);

            echo '
                <option value="'.$profesi.'">'.$profesi.'</option>
            ';
        }

        echo '
            </select>
        ';

        exit;
    }

    // =========================================================================
    // DEFAULT
    // =========================================================================
    echo '
        <input type="text" 
            name="keyword" 
            id="keyword" 
            class="form-control">
    ';
?>