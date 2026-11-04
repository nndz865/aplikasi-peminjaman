<?php
$config = include __DIR__ . '/../../config/app.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Aplikasi Peminjaman Alat UKK RPL'; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --bs-primary: #0f172a;
            --bs-primary-rgb: 15, 23, 42;
            --bs-secondary: #2563eb;
        }
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background-color: var(--bs-primary);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            z-index: 100;
            transition: all 0.3s;
        }
        .sidebar .brand {
            font-size: 1.1rem;
            font-weight: bold;
            padding: 1.5rem 1rem;
            background: #090d16;
            text-align: center;
            letter-spacing: 0.5px;
        }
        .sidebar .nav-link {
            color: #94a3b8;
            padding: 0.75rem 1.25rem;
            margin: 0.2rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 500;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff;
            background-color: var(--bs-secondary);
        }
        .sidebar .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }
        .main-content {
            margin-left: 260px;
            padding: 2rem;
        }
        .navbar-top {
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
            margin-left: 260px;
            padding: 0.75rem 2rem;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .card {
            border: none;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.05);
            border-radius: 0.5rem;
        }
        @media (max-width: 768px) {
            .sidebar { width: 100%; position: relative; min-height: auto; }
            .main-content, .navbar-top { margin-left: 0; }
        }
    </style>
</head>
<body>
