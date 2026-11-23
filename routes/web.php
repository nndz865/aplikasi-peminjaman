<?php
// routes/web.php

require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/KategoriController.php';
require_once __DIR__ . '/../controllers/AlatController.php';
require_once __DIR__ . '/../controllers/PeminjamanController.php';
require_once __DIR__ . '/../controllers/LaporanController.php';
require_once __DIR__ . '/../controllers/LogAktivitasController.php';
require_once __DIR__ . '/../controllers/ProfileController.php';

$route = $_GET['route'] ?? '';

// Root publik menampilkan landing page; pengguna yang sudah login diarahkan ke dashboard.
if (empty($route)) {
    if (isset($_SESSION['user_id'])) {
        AuthMiddleware::redirectByRole($_SESSION['role']);
    } else {
        require_once __DIR__ . '/../views/public/landing.php';
        exit;
    }
}

// Route landing page publik dapat dibuka langsung melalui ?route=landing.
if ($route === 'landing') {
    require_once __DIR__ . '/../views/public/landing.php';
    return;
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

// Route Profile
if ($route === 'profile/edit') {
    $controller = new ProfileController();
    $controller->edit();
    return;
}
if ($route === 'profile/update') {
    $controller = new ProfileController();
    $controller->update();
    return;
}

// Jika 404 Not Found
http_response_code(404);
require_once __DIR__ . '/../views/errors/404.php';
