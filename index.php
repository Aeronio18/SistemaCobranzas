<?php
$request = $_SERVER['REQUEST_URI'];
switch ($request) {
    // case '/sandbox/' :
    // case '/sandbox/login' :
        //server
    case '/' :
    case '/login' :
        require __DIR__ . '/views/login.php';
        break;
    case '/sandbox/admin_dashboard' :
        require __DIR__ . '/views/admin_dashboard.php';
        break;
    case '/sandbox/cobrador_dashboard' :
        require __DIR__ . '/views/cobrador_dashboard.php';
        break;
    case '/sandbox/cliente_dashboard' :
        require __DIR__ . '/views/cliente_dashboard.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
?>
