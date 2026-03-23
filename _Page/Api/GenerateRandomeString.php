<?php
    include "../../_Config/SimrsFunction.php";
    $RandomeString=GenerateToken(36);
    echo json_encode([
        'string' => $RandomeString
    ]);
    exit;
?>