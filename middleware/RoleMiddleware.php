<?php
require_once __DIR__ . '/AuthMiddleware.php';

class RoleMiddleware {
    public static function allow($allowedRoles = []) {
        AuthMiddleware::check();

        $userRole = $_SESSION['role'] ?? '';

        if (!in_array($userRole, $allowedRoles)) {
            http_response_code(403);
            require_once __DIR__ . '/../views/errors/403.php';
            exit;
        }
    }
}
