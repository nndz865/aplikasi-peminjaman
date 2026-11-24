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
            /* Quiet institutional system: hierarchy over decoration */
            --ov-bg: #f7f7f5;
            --ov-surface: #ffffff;
            --ov-text: #171717;
            --ov-muted: #6b6b67;
            --ov-border: #deded9;
            --ov-accent: #1f4f9a;
            --ov-yellow: #e6b93f;
            --ov-shadow: 0 1px 2px rgba(23, 23, 23, .04);
            --ov-transition: all 0.16s ease;
        }
        body {
            background-color: var(--ov-bg);
            color: var(--ov-text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
        }
        h1, h2, h3, h4, h5 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        .sidebar {
            min-height: 100vh;
            background-color: var(--ov-surface);
            border-right: 1px solid var(--ov-border);
            position: fixed;
            top: 0;
            left: 0;
            width: 270px;
            height: 100vh;
            z-index: 1050;
            transform: translateX(-100%);
            transition: var(--ov-transition);
            box-shadow: 8px 0 24px rgba(23, 33, 43, 0.08);
        }
        .sidebar.sidebar-open,
        .sidebar.sidebar-collapsed {
            transform: translateX(0);
        }
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.42);
            backdrop-filter: blur(2px);
            z-index: 1045;
            opacity: 0;
            visibility: hidden;
            transition: var(--ov-transition);
        }
        .sidebar-overlay.is-visible {
            opacity: 1;
            visibility: visible;
        }
        .sidebar .brand {
            font-size: .92rem;
            font-weight: 800;
            padding: 1.35rem 1.25rem;
            background: var(--ov-text);
            color: #fff;
            border-bottom: 1px solid var(--ov-text);
            letter-spacing: .04em;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .sidebar .nav-link {
            color: var(--ov-muted);
            padding: 0.68rem .9rem;
            margin: 0.18rem .75rem;
            border: 1px solid transparent;
            font-size: .88rem;
            font-weight: 600;
            border-radius: 5px;
            transition: var(--ov-transition);
        }
        .sidebar .nav-link:hover {
            background-color: #f1f3f5;
            border-color: var(--ov-border);
        }
        .sidebar .nav-link.active {
            background-color: #edf2fa;
            color: var(--ov-accent);
            border-color: #d5dfed;
            box-shadow: inset 3px 0 0 var(--ov-accent);
        }
        .sidebar-user {
            border: 1px solid var(--ov-border);
            border-radius: 8px;
            background: #fff;
            margin: 1rem;
            padding: 1rem;
            box-shadow: none;
        }
        .main-content {
            margin-left: 0;
            padding: 2rem 2.5rem 3rem;
        }
        .navbar-top {
            background: rgba(255, 255, 255, .98);
            border-bottom: 1px solid var(--ov-border);
            margin-left: 0;
            padding: .75rem 2.5rem;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .card {
            background-color: var(--ov-surface);
            border: 1px solid var(--ov-border) !important;
            border-radius: 6px;
            box-shadow: var(--ov-shadow) !important;
            transition: border-color var(--ov-transition), box-shadow var(--ov-transition);
        }
        .card:hover { border-color: #c2c2bc !important; box-shadow: 0 4px 12px rgba(23, 23, 23, .07) !important; }
        .card-header {
            background-color: #fbfbfa !important;
            border-bottom: 1px solid var(--ov-border) !important;
            padding: .9rem 1.25rem;
        }
        .btn {
            border-radius: 5px;
            font-weight: 600;
            box-shadow: none !important;
            transition: background-color var(--ov-transition), border-color var(--ov-transition), color var(--ov-transition);
        }
        .btn-primary { background-color: var(--ov-accent); border-color: var(--ov-accent); padding: .6rem 1.15rem; color: #fff; }
        .btn-primary:hover, .btn-primary:focus { background-color: #1d4789; border-color: #1d4789; }
        .btn-outline-primary { color: var(--ov-accent); border-color: #b9c9df; }
        .btn-outline-primary:hover { background: #eaf0f8; color: #1d4789; border-color: #aabed9; }
        .form-control, .form-select, .input-group-text { border-color: #cfd8e1; border-radius: 7px; }
        .form-control:focus, .form-select:focus { border-color: #84a5d6; box-shadow: 0 0 0 .2rem rgba(36, 87, 166, .12); }
        .badge { border: 0; border-radius: 999px; font-weight: 700; padding: .45em .75em; box-shadow: none; }
        .table > :not(caption) > * > * { border-color: #e5eaef; }
        .table-dark { --bs-table-bg: #24313f; --bs-table-border-color: #3c4a58; }
        .alert { border-radius: 8px; border-width: 1px; }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { transition-duration: .01ms !important; } }
        @media (max-width: 768px) {
            .sidebar { width: 100%; position: relative; min-height: auto; display: none !important; }
            .sidebar.sidebar-open { display: flex !important; }
            .main-content, .navbar-top { margin-left: 0; }
        }
        /* Product UI: restrained Carbon-inspired surfaces */
        .main-content > .card.bg-dark {
            background: var(--ov-text) !important;
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }
        .main-content > .card.bg-dark .card-body { padding: 2rem !important; }
        .main-content > .card.bg-dark h1 { font-size: clamp(1.65rem, 3vw, 2.35rem); letter-spacing: -.04em; }
        .main-content > .card.bg-dark .display-1,
        .main-content > .card.bg-dark .position-absolute { display: none; }
        .main-content .card.border-0 { border: 1px solid var(--ov-border) !important; }
        .main-content .shadow-sm, .main-content .shadow-lg { box-shadow: var(--ov-shadow) !important; }
        .main-content .rounded-4 { border-radius: 6px !important; }
        .main-content .rounded-pill { border-radius: 4px !important; }
        .main-content .card-header { color: var(--ov-text); }
        .main-content .catalog-card img { border-radius: 4px !important; }
        .eyebrow-label { color: var(--ov-accent); font-size: .72rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .page-heading { display: flex; align-items: end; justify-content: space-between; gap: 1rem; }
        .page-heading h1 { letter-spacing: -.04em; }
        .page-heading-actions { display: flex; gap: .5rem; }
        .action-strip { display: flex; align-items: center; flex-wrap: wrap; gap: .25rem 1.25rem; padding: .8rem 0; border-top: 1px solid var(--ov-border); border-bottom: 1px solid var(--ov-border); }
        .action-strip-label { color: var(--ov-muted); font-size: .72rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; }
        .action-strip a { color: var(--ov-accent); font-size: .85rem; font-weight: 600; text-decoration: none; }
        .action-strip a:hover { text-decoration: underline; }
        @media (max-width: 576px) { .page-heading { align-items: start; flex-direction: column; } .page-heading-actions { width: 100%; } .page-heading-actions .btn { flex: 1; } }
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
