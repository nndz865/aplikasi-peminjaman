<?php
// routes/web.php

require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/KategoriController.php';
require_once __DIR__ . '/../controllers/AlatController.php';
require_once __DIR__ . '/../controllers/PeminjamanController.php';
require_once __DIR__ . '/../controllers/LaporanController.php';
require_once __DIR__ . '/../controllers/LogAktivitasController.php';

$route = $_GET['route'] ?? '';

// Jika route kosong atau root, arahkan ke login atau dashboard sesuai session
if (empty($route)) {
    if (isset($_SESSION['user_id'])) {
        AuthMiddleware::redirectByRole($_SESSION['role']);
    } else {
        header('Location: index.php?route=login');
        exit;
    }
}

// Coba route auth
if (file_exists(__DIR__ . '/auth.php')) {
    $handled = include __DIR__ . '/auth.php';
    if ($handled) return;
}

// Coba route admin
if (file_exists(__DIR__ . '/admin.php')) {
    $handled = include __DIR__ . '/admin.php';
    if ($handled) return;
}

// Coba route petugas
if (file_exists(__DIR__ . '/petugas.php')) {
    $handled = include __DIR__ . '/petugas.php';
    if ($handled) return;
}

// Coba route peminjam
if (file_exists(__DIR__ . '/peminjam.php')) {
    $handled = include __DIR__ . '/peminjam.php';
    if ($handled) return;
}

// Jika 404 Not Found
http_response_code(404);
require_once __DIR__ . '/../views/errors/404.php';
