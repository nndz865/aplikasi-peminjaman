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
    <!-- Google Fonts: Syne & Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <!-- Theme Inspired by b-egg.farm -->
    <style>
        :root {
            --ov-bg: #fffbf0;
            --ov-surface: #ffffff;
            --ov-text: #1a1a1a;
            --ov-muted: #666666;
            --ov-border: #1a1a1a;
            --ov-accent: #ff5500;
            --ov-yellow: #ffd000;
        }
        body {
            background-color: var(--ov-bg);
            color: var(--ov-text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
        }
        h1, h2, h3, h4, h5, .brand-font {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            letter-spacing: -0.04em;
        }
        .sidebar {
            min-height: 100vh;
            background-color: var(--ov-surface);
            border-right: 4px solid var(--ov-border);
            position: fixed;
            top: 0;
            left: 0;
            width: 270px;
            z-index: 100;
            box-shadow: 6px 0 0 0 var(--ov-border);
        }
        .sidebar .brand {
            font-size: 1.2rem;
            font-weight: 800;
            padding: 1.75rem 1.25rem;
            background: var(--ov-yellow);
            color: var(--ov-text);
            border-bottom: 4px solid var(--ov-border);
            letter-spacing: -0.03em;
            font-family: 'Syne', sans-serif;
        }
        .sidebar .nav-link {
            color: var(--ov-text);
            padding: 0.9rem 1.25rem;
            margin: 0.5rem 0.75rem;
            border: 2px solid transparent;
            font-weight: 600;
            font-size: 0.9rem;
            border-radius: 12px;
            transition: all 0.15s ease;
        }
        .sidebar .nav-link:hover {
            background-color: var(--ov-yellow);
            border-color: var(--ov-border);
            box-shadow: 3px 3px 0 0 var(--ov-border);
            transform: translate(-2px, -2px);
        }
        .sidebar .nav-link.active {
            background-color: var(--ov-accent);
            color: #fff;
            border-color: var(--ov-border);
            box-shadow: 4px 4px 0 0 var(--ov-border);
        }
        .sidebar .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }
        .main-content {
            margin-left: 270px;
            padding: 3rem;
        }
        .navbar-top {
            background: var(--ov-surface);
            border-bottom: 4px solid var(--ov-border);
            margin-left: 270px;
            padding: 1rem 3rem;
            position: sticky;
            top: 0;
            z-index: 99;
            box-shadow: 0 4px 0 0 rgba(26, 26, 26, 0.05);
        }
        .card {
            background-color: var(--ov-surface);
            border: 4px solid var(--ov-border);
            border-radius: 20px;
            box-shadow: 6px 6px 0 0 var(--ov-border);
            transition: all 0.15s ease;
        }
        .card:hover {
            box-shadow: 10px 10px 0 0 var(--ov-accent);
            transform: translateY(-3px);
        }
        .card-header {
            background-color: var(--ov-yellow) !important;
            border-bottom: 4px solid var(--ov-border) !important;
            color: var(--ov-text) !important;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            padding: 1.25rem 1.5rem;
            border-top-left-radius: 16px !important;
            border-top-right-radius: 16px !important;
        }
        .table {
            color: var(--ov-text) !important;
            border-color: var(--ov-border) !important;
        }
        .table-light {
            background-color: #fff4d1 !important;
            color: var(--ov-text) !important;
            border-color: var(--ov-border) !important;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.05em;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(255, 208, 0, 0.15) !important;
        }
        .form-control, .form-select {
            background-color: #ffffff;
            border: 3px solid var(--ov-border);
            border-radius: 12px;
            color: var(--ov-text);
            font-weight: 500;
            padding: 0.75rem 1rem;
            box-shadow: 3px 3px 0 0 rgba(26, 26, 26, 0.1);
        }
        .form-control:focus, .form-select:focus {
            background-color: #fff;
            border-color: var(--ov-accent);
            box-shadow: 4px 4px 0 0 var(--ov-border);
        }
        .btn-primary {
            background-color: var(--ov-accent);
            border: 3px solid var(--ov-border);
            border-radius: 12px;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            padding: 0.75rem 1.5rem;
            box-shadow: 4px 4px 0 0 var(--ov-border);
            transition: all 0.15s ease;
            color: #fff;
        }
        .btn-primary:hover {
            background-color: var(--ov-yellow);
            color: var(--ov-text);
            border-color: var(--ov-border);
            box-shadow: 6px 6px 0 0 var(--ov-border);
            transform: translate(-2px, -2px);
        }
        .badge {
            border: 2px solid var(--ov-border);
            border-radius: 8px;
            font-weight: 700;
            padding: 0.5em 0.9em;
            box-shadow: 2px 2px 0 0 var(--ov-border);
        }
        @media (max-width: 768px) {
            .sidebar { width: 100%; position: relative; min-height: auto; }
            .main-content, .navbar-top { margin-left: 0; }
        }
        @media print {
            body { background: #fff !important; color: #000 !important; }
            .sidebar, .navbar-top, .d-print-none, button, .btn, .modal-backdrop { display: none !important; }
            .modal { position: static !important; overflow: visible !important; display: block !important; }
            .modal-dialog { max-width: 100% !important; margin: 0 !important; }
            .modal-content { border: none !important; box-shadow: none !important; }
            .modal-header, .modal-footer { display: none !important; }
            .main-content { margin: 0 !important; padding: 0 !important; width: 100% !important; }
            .card { border: none !important; box-shadow: none !important; }
            .table-responsive { overflow: visible !important; }
            table { width: 100% !important; font-size: 9pt !important; word-break: break-word !important; }
        }
    </style>
</head>
<body>
