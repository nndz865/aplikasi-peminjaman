<?php
$config = include __DIR__ . '/../../config/app.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Sistem Peminjaman Lab'; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Google Fonts: Syne & Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <!-- Theme Inspired by b-egg.farm -->
    <style>
        :root {
            /* Refined Neo-Brutalist Palette */
            --ov-bg: #f9f7f2;
            --ov-surface: #ffffff;
            --ov-text: #1a1a1a;
            --ov-muted: #666666;
            --ov-border: #1a1a1a;
            --ov-accent: #3b5bdb; /* More professional blue */
            --ov-yellow: #fcc419;
            --ov-shadow: 4px 4px 0px 0px var(--ov-border);
            --ov-transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        body {
            background-color: var(--ov-bg);
            color: var(--ov-text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
        }
        h1, h2, h3, h4, h5 {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            letter-spacing: -0.02em;
        }
        .sidebar {
            min-height: 100vh;
            background-color: var(--ov-surface);
            border-right: 3px solid var(--ov-border);
            position: fixed;
            top: 0;
            left: 0;
            width: 270px;
            height: 100vh;
            z-index: 100;
        }
        .sidebar .brand {
            font-size: 1.1rem;
            font-weight: 800;
            padding: 1.5rem;
            background: var(--ov-yellow);
            color: var(--ov-text);
            border-bottom: 3px solid var(--ov-border);
            letter-spacing: -0.01em;
            font-family: 'Syne', sans-serif;
        }
        .sidebar .nav-link {
            color: var(--ov-text);
            padding: 0.8rem 1.25rem;
            margin: 0.5rem 1rem;
            border: 2px solid transparent;
            font-weight: 600;
            border-radius: 12px;
            transition: var(--ov-transition);
        }
        .sidebar .nav-link:hover {
            background-color: #f1f3f5;
            border-color: var(--ov-border);
        }
        .sidebar .nav-link.active {
            background-color: var(--ov-accent);
            color: #fff;
            border-color: var(--ov-border);
            box-shadow: 3px 3px 0 0 var(--ov-border);
        }
        .sidebar-user { 
            border: 2px solid var(--ov-border); 
            border-radius: 12px; 
            background: #fff; 
            margin: 1rem;
            padding: 1rem;
            box-shadow: 3px 3px 0 0 var(--ov-border);
        }
        .main-content {
            margin-left: 270px;
            padding: 2.5rem;
        }
        .navbar-top {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 3px solid var(--ov-border);
            margin-left: 270px;
            padding: 1rem 2.5rem;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .card {
            background-color: var(--ov-surface);
            border: 3px solid var(--ov-border);
            border-radius: 16px;
            box-shadow: var(--ov-shadow);
            transition: var(--ov-transition);
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 6px 6px 0 0 var(--ov-border);
        }
        .card-header {
            background-color: #f8f9fa !important;
            border-bottom: 3px solid var(--ov-border) !important;
            padding: 1rem 1.5rem;
        }
        .btn-primary {
            background-color: var(--ov-accent);
            border: 2px solid var(--ov-border);
            border-radius: 10px;
            font-weight: 700;
            padding: 0.6rem 1.2rem;
            box-shadow: 3px 3px 0 0 var(--ov-border);
            transition: var(--ov-transition);
            color: #fff;
        }
        .btn-primary:hover {
            transform: translate(-1px, -1px);
            box-shadow: 4px 4px 0 0 var(--ov-border);
            background-color: #2b48a0;
        }
        .badge {
            border: 2px solid var(--ov-border);
            border-radius: 8px;
            font-weight: 700;
            padding: 0.5em 0.9em;
            box-shadow: 2px 2px 0 0 var(--ov-border);
        }
        @media (max-width: 768px) {
            .sidebar { width: 100%; position: relative; min-height: auto; display: none !important; }
            .sidebar.sidebar-open { display: flex !important; }
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
