<?php
    $routes = [
        'Dashboard'        => '_Page/Dashboard/Dashboard.php',
        'Profile'          => '_Page/ProfileUser/ProfileUser.php',
        'Setting'          => '_Page/Setting/Setting.php',
        'ApiKey'           => '_Page/ApiKey/ApiKey.php',
        'EmailGateway'     => '_Page/EmailGateway/EmailGateway.php',
        'GoogleCredential' => '_Page/GoogleCredential/GoogleCredential.php',
        'AksesFitur'       => '_Page/AksesFitur/AksesFitur.php',
    ];

    $page = trim($_GET['Page'] ?? '');

    if ($page === '') {
        include $routes['Dashboard'];
    } elseif (isset($routes[$page])) {
        include $routes[$page];
    } else {
        include '_Page/Error/PageNotFound.php';
    }
?>