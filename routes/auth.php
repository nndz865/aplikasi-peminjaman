<?php
// routes/auth.php
$route = $_GET['route'] ?? 'login';

switch ($route) {
    case 'login':
        $controller = new AuthController();
        $controller->showLogin();
        break;
    case 'login-process':
        $controller = new AuthController();
        $controller->login();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    default:
        return false; // Not handled here
}
return true;
