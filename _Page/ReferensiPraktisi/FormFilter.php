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

        // Prepared Statement: load available practitioner professions.
        $stmt = mysqli_prepare($Conn, "
            SELECT DISTINCT profesi_praktisi
            FROM praktisi
            WHERE profesi_praktisi IS NOT NULL
            AND profesi_praktisi != ''
            ORDER BY profesi_praktisi ASC
        ");
        mysqli_stmt_execute($stmt);
        $query = mysqli_stmt_get_result($stmt);

        while ($data = mysqli_fetch_assoc($query)) {

            $profesi = htmlspecialchars($data['profesi_praktisi']);

            echo '
                <option value="'.$profesi.'">'.$profesi.'</option>
            ';
        }
        mysqli_stmt_close($stmt);

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