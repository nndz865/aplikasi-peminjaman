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
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --bs-primary: #1e293b;
            --bs-primary-rgb: 30, 41, 59;
            --bs-secondary: #3b82f6;
            --bs-success: #10b981;
            --bs-warning: #f59e0b;
            --bs-danger: #ef4444;
            --bs-body-bg: #f8fafc;
        }
        body {
            background-color: var(--bs-body-bg);
            font-family: 'Inter', sans-serif;
            color: #334155;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            width: 270px;
            z-index: 100;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        .sidebar .brand {
            font-size: 1.1rem;
            font-weight: 700;
            padding: 1.5rem 1.25rem;
            background: rgba(15, 23, 42, 0.9);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link {
            color: #94a3b8;
            padding: 0.8rem 1.25rem;
            margin: 0.25rem 0.8rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.06);
            transform: translateX(3px);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        .sidebar .nav-link i {
            margin-right: 0.85rem;
            font-size: 1.1rem;
        }
        .main-content {
            margin-left: 270px;
            padding: 2.5rem;
        }
        .navbar-top {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            margin-left: 270px;
            padding: 0.85rem 2.5rem;
            position: sticky;
            top: 0;
            z-index: 99;
            border-bottom: 1px solid #e2e8f0;
        }
        .card {
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            border-radius: 0.75rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        }
        .table > :not(caption) > * > * {
            padding: 1rem 1rem;
        }
        .btn {
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background-color: #3b82f6;
            border-color: #3b82f6;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
        }
        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
            transform: translateY(-1px);
        }
        @media (max-width: 768px) {
            .sidebar { width: 100%; position: relative; min-height: auto; }
            .main-content, .navbar-top { margin-left: 0; }
        }
    </style>
</head>
<body>
