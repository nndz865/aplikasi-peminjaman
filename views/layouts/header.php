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
    <!-- Google Fonts: Space Grotesk & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Cyberpunk / Brutalist Theme CSS (Overrides Style) -->
    <style>
        :root {
            --ov-bg: #f4f4f0;
            --ov-surface: #ffffff;
            --ov-text: #0d0d0d;
            --ov-muted: #595959;
            --ov-border: #0d0d0d;
            --ov-accent: #ff3300; /* Neon Orange / Red */
            --ov-yellow: #ffe600;
        }
        body {
            background-color: var(--ov-bg);
            color: var(--ov-text);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        h1, h2, h3, h4, h5, .brand-font {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            letter-spacing: -0.03em;
        }
        .sidebar {
            min-height: 100vh;
            background-color: var(--ov-surface);
            border-right: 3px solid var(--ov-border);
            position: fixed;
            top: 0;
            left: 0;
            width: 270px;
            z-index: 100;
            box-shadow: 5px 0 0 0 var(--ov-border);
        }
        .sidebar .brand {
            font-size: 1.1rem;
            font-weight: 700;
            padding: 1.5rem 1.25rem;
            background: var(--ov-accent);
            color: #fff;
            border-bottom: 3px solid var(--ov-border);
            letter-spacing: -0.02em;
        }
        .sidebar .nav-link {
            color: var(--ov-text);
            padding: 0.85rem 1.25rem;
            margin: 0.4rem 0.75rem;
            border: 2px solid transparent;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.1s ease;
        }
        .sidebar .nav-link:hover {
            background-color: var(--ov-yellow);
            border-color: var(--ov-border);
            box-shadow: 3px 3px 0 0 var(--ov-border);
            transform: translate(-2px, -2px);
        }
        .sidebar .nav-link.active {
            background-color: var(--ov-text);
            color: #fff;
            border-color: var(--ov-border);
            box-shadow: 4px 4px 0 0 var(--ov-accent);
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
            border-bottom: 3px solid var(--ov-border);
            margin-left: 270px;
            padding: 1rem 3rem;
            position: sticky;
            top: 0;
            z-index: 99;
            box-shadow: 0 4px 0 0 rgba(13, 13, 13, 0.05);
        }
        .card {
            background-color: var(--ov-surface);
            border: 3px solid var(--ov-border);
            border-radius: 0;
            box-shadow: 6px 6px 0 0 var(--ov-border);
            transition: all 0.1s ease;
        }
        .card:hover {
            box-shadow: 8px 8px 0 0 var(--ov-accent);
            transform: translate(-2px, -2px);
        }
        .card-header {
            background-color: var(--ov-yellow) !important;
            border-bottom: 3px solid var(--ov-border) !important;
            color: var(--ov-text) !important;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            padding: 1rem 1.5rem;
        }
        .table {
            color: var(--ov-text) !important;
            border-color: var(--ov-border) !important;
        }
        .table-light {
            background-color: #eaeaea !important;
            color: var(--ov-text) !important;
            border-color: var(--ov-border) !important;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(255, 230, 0, 0.2) !important;
        }
        .form-control, .form-select {
            background-color: #fff;
            border: 3px solid var(--ov-border);
            border-radius: 0;
            color: var(--ov-text);
            font-weight: 500;
            padding: 0.75rem 1rem;
            box-shadow: 3px 3px 0 0 rgba(13, 13, 13, 0.1);
        }
        .form-control:focus, .form-select:focus {
            background-color: #fff;
            border-color: var(--ov-accent);
            box-shadow: 4px 4px 0 0 var(--ov-border);
        }
        .btn-primary {
            background-color: var(--ov-accent);
            border: 3px solid var(--ov-border);
            border-radius: 0;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            padding: 0.75rem 1.5rem;
            box-shadow: 4px 4px 0 0 var(--ov-border);
            transition: all 0.1s ease;
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
            border-radius: 0;
            font-weight: 700;
            padding: 0.4em 0.8em;
            box-shadow: 2px 2px 0 0 var(--ov-border);
        }
        @media (max-width: 768px) {
            .sidebar { width: 100%; position: relative; min-height: auto; }
            .main-content, .navbar-top { margin-left: 0; }
        }
    </style>
</head>
<body>
