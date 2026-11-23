<?php
$config = include __DIR__ . '/../../config/app.php';
$baseUrl = rtrim($config['base_url'], '/');
$isAuthenticated = isset($_SESSION['user_id']);
$dashboardRoutes = [
    'admin' => 'admin/dashboard',
    'petugas' => 'petugas/dashboard',
    'peminjam' => 'peminjam/dashboard'
];
$primaryRoute = $dashboardRoutes[$_SESSION['role'] ?? ''] ?? 'login';
$primaryLabel = $isAuthenticated ? 'Buka dashboard' : 'Masuk ke aplikasi';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Platform peminjaman alat praktikum yang membantu inventaris, pengajuan, persetujuan, dan pengembalian tercatat dalam satu alur.">
    <title><?php echo htmlspecialchars($config['app_name']); ?> | Kelola alat dengan lebih teratur</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --ink: #17202a;
            --ink-soft: #52606d;
            --paper: #f7f8f5;
            --surface: #ffffff;
            --line: #dce2e5;
            --blue: #3157d5;
            --blue-dark: #2340a1;
            --yellow: #f7ce46;
            --green: #23836b;
            --shadow: 0 22px 60px rgba(23, 32, 42, .10);
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            color: var(--ink);
            background: var(--paper);
            font-family: 'DM Sans', sans-serif;
            line-height: 1.6;
        }
        a { color: inherit; text-decoration: none; }
        .landing-page { overflow: hidden; }
        .container-wide { width: min(1160px, calc(100% - 40px)); margin: 0 auto; }
        .site-header {
            position: relative;
            z-index: 10;
            padding: 22px 0;
            background: rgba(247, 248, 245, .92);
            border-bottom: 1px solid rgba(220, 226, 229, .7);
        }
        .nav-wrap { display: flex; align-items: center; justify-content: space-between; gap: 24px; }
        .brand { display: inline-flex; align-items: center; gap: 11px; font-family: 'Space Grotesk', sans-serif; font-size: 1.12rem; font-weight: 700; letter-spacing: -.03em; }
        .brand-mark { width: 38px; height: 38px; display: grid; place-items: center; color: var(--ink); background: var(--yellow); border: 2px solid var(--ink); border-radius: 11px; box-shadow: 3px 3px 0 var(--ink); }
        .brand small { display: block; color: var(--ink-soft); font-family: 'DM Sans', sans-serif; font-size: .67rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; }
        .nav-links { display: flex; align-items: center; gap: 28px; color: var(--ink-soft); font-size: .9rem; font-weight: 600; }
        .nav-links a { transition: color .2s ease; }
        .nav-links a:hover, .nav-links a:focus-visible { color: var(--blue); }
        .nav-actions { display: flex; align-items: center; gap: 10px; }
        .btn-landing { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 45px; padding: 0 18px; border: 1.5px solid var(--ink); border-radius: 9px; font-size: .88rem; font-weight: 700; transition: transform .2s ease, box-shadow .2s ease, background .2s ease; }
        .btn-landing:hover, .btn-landing:focus-visible { transform: translate(-2px, -2px); box-shadow: 4px 4px 0 var(--ink); }
        .btn-landing-primary { color: #fff; background: var(--blue); border-color: var(--blue); }
        .btn-landing-primary:hover, .btn-landing-primary:focus-visible { background: var(--blue-dark); }
        .btn-landing-quiet { background: transparent; }
        .menu-toggle { display: none; width: 44px; height: 44px; color: var(--ink); background: transparent; border: 1.5px solid var(--ink); border-radius: 9px; font-size: 1.35rem; }
        .hero { padding: 76px 0 86px; background: radial-gradient(circle at 86% 20%, rgba(247, 206, 70, .25), transparent 24%), var(--paper); }
        .hero-grid { display: grid; grid-template-columns: minmax(0, 1.02fr) minmax(420px, .98fr); align-items: center; gap: 72px; }
        .eyebrow { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px; color: var(--blue); font-size: .76rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; }
        .eyebrow::before { width: 25px; height: 2px; content: ''; background: var(--blue); }
        h1, h2, h3 { margin: 0; font-family: 'Space Grotesk', sans-serif; letter-spacing: -.055em; line-height: 1.06; }
        h1 { max-width: 680px; font-size: clamp(3rem, 6vw, 5.6rem); }
        h1 span { color: var(--blue); }
        .hero-copy { max-width: 570px; margin: 25px 0 30px; color: var(--ink-soft); font-size: 1.08rem; }
        .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; }
        .hero-note { display: flex; align-items: center; gap: 9px; margin-top: 25px; color: var(--ink-soft); font-size: .82rem; }
        .hero-note i { color: var(--green); font-size: 1.05rem; }
        .workspace-preview { position: relative; min-height: 450px; padding: 28px; background: #17202a; border: 2px solid var(--ink); border-radius: 22px; box-shadow: 14px 14px 0 var(--yellow); transform: rotate(1.2deg); }
        .preview-top { display: flex; align-items: center; justify-content: space-between; padding-bottom: 22px; border-bottom: 1px solid rgba(255,255,255,.15); color: #f7f8f5; }
        .preview-label { color: #9caab7; font-size: .72rem; letter-spacing: .1em; text-transform: uppercase; }
        .preview-top strong { display: block; margin-top: 4px; font-family: 'Space Grotesk', sans-serif; font-size: 1.15rem; }
        .preview-dots { display: flex; gap: 5px; }
        .preview-dots span { width: 7px; height: 7px; border-radius: 50%; background: #788796; }
        .preview-dots span:first-child { background: var(--yellow); }
        .preview-board { display: grid; grid-template-columns: .7fr 1.3fr; gap: 14px; padding-top: 25px; }
        .preview-sidebar { padding: 14px 10px; background: rgba(255,255,255,.06); border-radius: 12px; }
        .preview-side-line { height: 9px; margin: 11px 7px; border-radius: 4px; background: #3e4d5c; }
        .preview-side-line.active { background: var(--yellow); }
        .preview-content { min-width: 0; }
        .preview-heading { margin-bottom: 14px; color: #f7f8f5; font-family: 'Space Grotesk', sans-serif; font-size: 1.3rem; }
        .preview-flow { display: grid; gap: 10px; }
        .flow-item { display: flex; align-items: center; gap: 12px; padding: 12px; background: rgba(255,255,255,.09); border: 1px solid rgba(255,255,255,.13); border-radius: 10px; }
        .flow-number { width: 28px; height: 28px; display: grid; place-items: center; flex: 0 0 auto; color: var(--ink); background: var(--yellow); border-radius: 8px; font-size: .8rem; font-weight: 700; }
        .flow-item strong { display: block; color: #f7f8f5; font-size: .84rem; }
        .flow-item small { display: block; margin-top: 1px; color: #9caab7; font-size: .72rem; }
        .preview-status { display: flex; align-items: center; gap: 8px; margin-top: 22px; color: #a8d8c8; font-size: .75rem; }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; background: #66d3ab; box-shadow: 0 0 0 4px rgba(102,211,171,.16); }
        .trust-strip { padding: 23px 0; color: var(--ink-soft); background: var(--surface); border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
        .trust-items { display: grid; grid-template-columns: repeat(4, 1fr); gap: 22px; }
        .trust-item { display: flex; align-items: center; gap: 11px; font-size: .84rem; font-weight: 600; }
        .trust-item i { color: var(--blue); font-size: 1.1rem; }
        .section { padding: 105px 0; }
        .section-heading { max-width: 650px; margin-bottom: 46px; }
        .section-heading h2 { font-size: clamp(2.2rem, 4vw, 3.8rem); }
        .section-heading p { margin: 18px 0 0; color: var(--ink-soft); font-size: 1rem; }
        .benefit-layout { display: grid; grid-template-columns: .8fr 1.2fr; gap: 80px; align-items: start; }
        .benefit-intro { position: sticky; top: 30px; }
        .benefit-intro h2 { font-size: clamp(2.2rem, 4vw, 3.6rem); }
        .benefit-intro p { margin: 20px 0 0; color: var(--ink-soft); }
        .benefit-list { display: grid; gap: 0; border-top: 1px solid var(--line); }
        .benefit-item { display: grid; grid-template-columns: 58px 1fr; gap: 20px; padding: 28px 0; border-bottom: 1px solid var(--line); }
        .benefit-index { color: var(--blue); font-family: 'Space Grotesk', sans-serif; font-size: .92rem; font-weight: 700; }
        .benefit-item h3 { margin-bottom: 8px; font-size: 1.35rem; letter-spacing: -.035em; }
        .benefit-item p { max-width: 610px; margin: 0; color: var(--ink-soft); font-size: .94rem; }
        .roles-section { background: #eef1f0; }
        .role-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
        .role-card { min-height: 300px; display: flex; flex-direction: column; padding: 26px; background: var(--surface); border: 1px solid var(--line); border-radius: 16px; transition: transform .2s ease, box-shadow .2s ease; }
        .role-card:hover { transform: translateY(-5px); box-shadow: var(--shadow); }
        .role-card:nth-child(2) { background: var(--ink); color: #fff; border-color: var(--ink); }
        .role-icon { width: 46px; height: 46px; display: grid; place-items: center; margin-bottom: 42px; color: var(--ink); background: var(--yellow); border-radius: 12px; font-size: 1.25rem; }
        .role-card h3 { margin-bottom: 10px; font-size: 1.45rem; }
        .role-card p { margin: 0; color: var(--ink-soft); font-size: .9rem; }
        .role-card:nth-child(2) p { color: #b8c1c8; }
        .role-link { display: inline-flex; align-items: center; gap: 7px; margin-top: auto; padding-top: 26px; color: var(--blue); font-size: .85rem; font-weight: 700; }
        .role-card:nth-child(2) .role-link { color: var(--yellow); }
        .process-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; }
        .process-item { padding: 24px 0 0; border-top: 2px solid var(--ink); }
        .process-number { color: var(--blue); font-family: 'Space Grotesk', sans-serif; font-size: .8rem; font-weight: 700; }
        .process-item h3 { margin: 33px 0 10px; font-size: 1.2rem; }
        .process-item p { margin: 0; color: var(--ink-soft); font-size: .88rem; }
        .security-band { padding: 70px 0; color: #fff; background: var(--blue); }
        .security-layout { display: grid; grid-template-columns: .9fr 1.1fr; gap: 80px; align-items: center; }
        .security-layout h2 { font-size: clamp(2.2rem, 4vw, 3.5rem); }
        .security-layout p { margin: 20px 0 0; color: #dce4ff; }
        .security-points { display: grid; grid-template-columns: repeat(2, 1fr); gap: 18px; }
        .security-point { padding: 20px 0 0; border-top: 1px solid rgba(255,255,255,.34); }
        .security-point i { color: var(--yellow); font-size: 1.2rem; }
        .security-point strong { display: block; margin: 15px 0 5px; font-family: 'Space Grotesk', sans-serif; }
        .security-point span { display: block; color: #dce4ff; font-size: .84rem; }
        .final-cta { padding: 95px 0; text-align: center; background: var(--yellow); }
        .final-cta h2 { max-width: 710px; margin: 0 auto; font-size: clamp(2.4rem, 5vw, 4.5rem); }
        .final-cta p { max-width: 540px; margin: 19px auto 28px; color: #4c4630; }
        .final-cta .btn-landing { background: var(--ink); border-color: var(--ink); color: #fff; }
        .final-cta .btn-landing:hover, .final-cta .btn-landing:focus-visible { box-shadow: 4px 4px 0 rgba(23, 32, 42, .28); }
        footer { padding: 25px 0; color: #8b969f; background: var(--ink); font-size: .78rem; }
        .footer-wrap { display: flex; align-items: center; justify-content: space-between; gap: 18px; }
        .footer-brand { color: #fff; font-family: 'Space Grotesk', sans-serif; font-weight: 600; }
        :focus-visible { outline: 3px solid var(--yellow); outline-offset: 3px; }
        @media (max-width: 900px) {
            .hero-grid, .benefit-layout, .security-layout { grid-template-columns: 1fr; gap: 46px; }
            .benefit-intro { position: static; }
            .hero { padding: 62px 0 78px; }
            .workspace-preview { max-width: 650px; margin: 0 auto; width: 100%; }
            .role-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 700px) {
            .container-wide { width: min(100% - 30px, 560px); }
            .site-header { padding: 15px 0; }
            .menu-toggle { display: grid; place-items: center; }
            .nav-links, .nav-actions { display: none; }
            .nav-links.is-open { position: absolute; top: 76px; left: 15px; right: 15px; display: grid; gap: 0; padding: 8px; background: var(--surface); border: 1px solid var(--line); border-radius: 12px; box-shadow: var(--shadow); }
            .nav-links.is-open a { padding: 13px; border-radius: 7px; }
            .nav-links.is-open a:hover { background: var(--paper); }
            .nav-actions.is-open { position: absolute; top: 285px; left: 15px; right: 15px; display: block; padding: 0 8px 8px; background: var(--surface); border: 1px solid var(--line); border-top: 0; border-radius: 0 0 12px 12px; box-shadow: var(--shadow); }
            .nav-actions.is-open .btn-landing { width: 100%; }
            h1 { font-size: clamp(2.8rem, 14vw, 4.4rem); }
            .hero-copy { font-size: 1rem; }
            .workspace-preview { min-height: 390px; padding: 20px; box-shadow: 8px 8px 0 var(--yellow); }
            .trust-items, .process-grid { grid-template-columns: repeat(2, 1fr); }
            .role-grid { grid-template-columns: 1fr; }
            .role-card { min-height: 245px; }
            .security-points { grid-template-columns: 1fr 1fr; }
            .section { padding: 75px 0; }
            .footer-wrap { align-items: flex-start; flex-direction: column; }
        }
        @media (max-width: 430px) {
            .hero-actions .btn-landing { width: 100%; }
            .preview-board { grid-template-columns: 1fr; }
            .preview-sidebar { display: none; }
            .trust-items, .process-grid, .security-points { grid-template-columns: 1fr; }
            .benefit-item { grid-template-columns: 38px 1fr; gap: 12px; }
        }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            *, *::before, *::after { transition-duration: .01ms !important; animation-duration: .01ms !important; }
            .workspace-preview { transform: none; }
        }
    </style>
</head>
<body>
<div class="landing-page">
    <header class="site-header">
        <div class="container-wide nav-wrap">
            <a class="brand" href="<?php echo $baseUrl; ?>/index.php" aria-label="Beranda <?php echo htmlspecialchars($config['app_name']); ?>">
                <span class="brand-mark"><i class="bi bi-box-seam"></i></span>
                <span>LABLOAN<small>Inventory & lending system</small></span>
            </a>
            <nav class="nav-links" id="landingNav" aria-label="Navigasi utama">
                <a href="#keunggulan">Keunggulan</a>
                <a href="#peran">Untuk siapa</a>
                <a href="#alur">Cara kerja</a>
                <a href="#keamanan">Keamanan</a>
            </nav>
            <div class="nav-actions" id="landingActions">
                <a class="btn-landing btn-landing-primary" href="<?php echo $baseUrl; ?>/index.php?route=<?php echo $primaryRoute; ?>"><?php echo $primaryLabel; ?> <i class="bi bi-arrow-up-right"></i></a>
            </div>
            <button class="menu-toggle" id="landingMenuToggle" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="landingNav"><i class="bi bi-list"></i></button>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container-wide hero-grid">
                <div>
                    <div class="eyebrow">Platform peminjaman alat praktikum</div>
                    <h1>Alat yang tepat. <span>Alur yang jelas.</span></h1>
                    <p class="hero-copy">Satu ruang kerja untuk mengelola inventaris, mengajukan peminjaman, memvalidasi permintaan, dan memantau pengembalian tanpa kehilangan jejak.</p>
                    <div class="hero-actions">
                        <a class="btn-landing btn-landing-primary" href="<?php echo $baseUrl; ?>/index.php?route=<?php echo $primaryRoute; ?>"><?php echo $primaryLabel; ?> <i class="bi bi-arrow-right"></i></a>
                        <a class="btn-landing btn-landing-quiet" href="#alur">Lihat cara kerja <i class="bi bi-play-circle"></i></a>
                    </div>
                    <div class="hero-note"><i class="bi bi-check-circle-fill"></i> Dibuat untuk alur kerja Admin, Petugas, dan Peminjam.</div>
                </div>
                <div class="workspace-preview" aria-label="Ilustrasi alur peminjaman alat">
                    <div class="preview-top"><div><span class="preview-label">Workspace</span><strong>Alur peminjaman</strong></div><div class="preview-dots"><span></span><span></span><span></span></div></div>
                    <div class="preview-board">
                        <div class="preview-sidebar" aria-hidden="true"><div class="preview-side-line active"></div><div class="preview-side-line"></div><div class="preview-side-line"></div><div class="preview-side-line"></div><div class="preview-side-line"></div></div>
                        <div class="preview-content"><div class="preview-heading">Selesaikan dalam satu alur</div><div class="preview-flow">
                            <div class="flow-item"><span class="flow-number">01</span><span><strong>Pilih alat</strong><small>Temukan alat dari katalog</small></span></div>
                            <div class="flow-item"><span class="flow-number">02</span><span><strong>Ajukan kebutuhan</strong><small>Isi jumlah dan keperluan</small></span></div>
                            <div class="flow-item"><span class="flow-number">03</span><span><strong>Tunggu validasi</strong><small>Petugas meninjau pengajuan</small></span></div>
                            <div class="flow-item"><span class="flow-number">04</span><span><strong>Kembalikan tercatat</strong><small>Riwayat tetap mudah dipantau</small></span></div>
                        </div><div class="preview-status"><span class="status-dot"></span> Status alur mudah dipantau</div></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="trust-strip" aria-label="Kemampuan utama sistem">
            <div class="container-wide trust-items">
                <div class="trust-item"><i class="bi bi-grid-1x2"></i><span>Katalog inventaris terpusat</span></div>
                <div class="trust-item"><i class="bi bi-check2-square"></i><span>Persetujuan lebih tertib</span></div>
                <div class="trust-item"><i class="bi bi-clock-history"></i><span>Riwayat transaksi tercatat</span></div>
                <div class="trust-item"><i class="bi bi-shield-check"></i><span>Akses sesuai peran</span></div>
            </div>
        </section>

        <section class="section" id="keunggulan">
            <div class="container-wide benefit-layout">
                <div class="benefit-intro"><div class="eyebrow">Dibuat untuk operasional harian</div><h2>Lebih sedikit kebingungan. Lebih banyak kendali.</h2><p>Setiap bagian aplikasi dirancang mengikuti proses nyata: mulai dari alat tersedia sampai transaksi selesai.</p></div>
                <div class="benefit-list">
                    <article class="benefit-item"><div class="benefit-index">01</div><div><h3>Inventaris mudah ditemukan</h3><p>Informasi nama alat, kategori, stok, kondisi, dan lokasi tersusun dalam katalog sehingga pengguna dapat mengambil keputusan dengan konteks yang cukup.</p></div></article>
                    <article class="benefit-item"><div class="benefit-index">02</div><div><h3>Pengajuan punya status yang jelas</h3><p>Peminjam dapat mengirim kebutuhan melalui formulir, sementara petugas memiliki ruang kerja khusus untuk meninjau dan memproses pengajuan.</p></div></article>
                    <article class="benefit-item"><div class="benefit-index">03</div><div><h3>Pengembalian tidak berhenti di catatan manual</h3><p>Proses pengembalian, perhitungan denda, dan pembaruan stok terhubung dengan transaksi agar data tetap konsisten.</p></div></article>
                </div>
            </div>
        </section>

        <section class="section roles-section" id="peran">
            <div class="container-wide">
                <div class="section-heading"><div class="eyebrow">Satu sistem, tiga sudut pandang</div><h2>Semua user mendapatkan ruang kerja yang relevan.</h2><p>Hak akses dan menu disesuaikan dengan tanggung jawab masing-masing, bukan satu dashboard yang membingungkan untuk semua orang.</p></div>
                <div class="role-grid">
                    <article class="role-card"><div class="role-icon"><i class="bi bi-kanban"></i></div><h3>Admin</h3><p>Menjaga struktur sistem melalui pengelolaan user, kategori, inventaris, pengaturan, dan log aktivitas.</p><a class="role-link" href="<?php echo $baseUrl; ?>/index.php?route=login">Masuk sebagai Admin <i class="bi bi-arrow-up-right"></i></a></article>
                    <article class="role-card"><div class="role-icon"><i class="bi bi-clipboard-check"></i></div><h3>Petugas</h3><p>Mengoperasikan antrean pengajuan, persetujuan, pengembalian, dan laporan transaksi secara terarah.</p><a class="role-link" href="<?php echo $baseUrl; ?>/index.php?route=login">Masuk sebagai Petugas <i class="bi bi-arrow-up-right"></i></a></article>
                    <article class="role-card"><div class="role-icon"><i class="bi bi-person-workspace"></i></div><h3>Peminjam</h3><p>Menjelajahi katalog, mengajukan alat, melihat riwayat, dan mengurus pengembalian dari satu tempat.</p><a class="role-link" href="<?php echo $baseUrl; ?>/index.php?route=login">Masuk sebagai Peminjam <i class="bi bi-arrow-up-right"></i></a></article>
                </div>
            </div>
        </section>

        <section class="section" id="alur">
            <div class="container-wide">
                <div class="section-heading"><div class="eyebrow">Cara kerja</div><h2>Dari kebutuhan sampai selesai, tanpa melompat-lompat.</h2><p>Alur yang konsisten membantu setiap pihak tahu apa yang harus dilakukan berikutnya.</p></div>
                <div class="process-grid">
                    <article class="process-item"><div class="process-number">01 / TEMUKAN</div><h3>Jelajahi katalog</h3><p>Cari alat berdasarkan informasi yang tersedia dan pastikan stoknya sesuai kebutuhan.</p></article>
                    <article class="process-item"><div class="process-number">02 / AJUKAN</div><h3>Kirim pengajuan</h3><p>Masukkan jumlah, tanggal peminjaman, dan keperluan agar permintaan mudah ditinjau.</p></article>
                    <article class="process-item"><div class="process-number">03 / VALIDASI</div><h3>Tunggu keputusan</h3><p>Petugas memproses pengajuan sesuai kondisi inventaris dan aturan yang berlaku.</p></article>
                    <article class="process-item"><div class="process-number">04 / SELESAI</div><h3>Kembalikan alat</h3><p>Ajukan pengembalian dan biarkan sistem menjaga catatan transaksi tetap lengkap.</p></article>
                </div>
            </div>
        </section>

        <section class="security-band" id="keamanan">
            <div class="container-wide security-layout"><div><div class="eyebrow" style="color: #f7ce46;">Tertib sejak awal</div><h2>Data dan tanggung jawab tetap berada di jalurnya.</h2><p>Pengalaman yang sederhana tidak berarti kontrol yang longgar. Sistem membedakan ruang kerja, mencatat aktivitas, dan menjaga setiap proses tetap dapat ditelusuri.</p></div><div class="security-points"><div class="security-point"><i class="bi bi-person-lock"></i><strong>Akses berbasis peran</strong><span>Menu dan proses mengikuti tanggung jawab Admin, Petugas, atau Peminjam.</span></div><div class="security-point"><i class="bi bi-journal-text"></i><strong>Aktivitas tercatat</strong><span>Peristiwa penting dalam sistem memiliki jejak untuk membantu pemantauan.</span></div><div class="security-point"><i class="bi bi-database-check"></i><strong>Data transaksi konsisten</strong><span>Pengajuan dan pengembalian diproses melalui alur aplikasi yang sama.</span></div><div class="security-point"><i class="bi bi-phone"></i><strong>Siap dipakai di berbagai layar</strong><span>Navigasi dan tindakan utama tetap mudah digunakan di desktop maupun mobile.</span></div></div></div>
        </section>

        <section class="final-cta"><div class="container-wide"><h2>Siap membuat peminjaman alat lebih teratur?</h2><p>Masuk ke aplikasi dan gunakan ruang kerja yang sesuai dengan peran Anda.</p><a class="btn-landing" href="<?php echo $baseUrl; ?>/index.php?route=<?php echo $primaryRoute; ?>"><?php echo $primaryLabel; ?> <i class="bi bi-arrow-right"></i></a></div></section>
    </main>

    <footer><div class="container-wide footer-wrap"><span class="footer-brand"><i class="bi bi-box-seam me-2"></i>LABLOAN</span><span>&copy; <span id="landingYear"></span> <?php echo htmlspecialchars($config['app_name']); ?>. Built for clearer operations.</span></div></footer>
</div>
<script>
    (function () {
        var toggle = document.getElementById('landingMenuToggle');
        var nav = document.getElementById('landingNav');
        var actions = document.getElementById('landingActions');
        var year = document.getElementById('landingYear');
        if (year) year.textContent = new Date().getFullYear();
        if (!toggle || !nav || !actions) return;
        toggle.addEventListener('click', function () {
            var open = nav.classList.toggle('is-open');
            actions.classList.toggle('is-open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
            toggle.innerHTML = open ? '<i class="bi bi-x-lg"></i>' : '<i class="bi bi-list"></i>';
        });
        nav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                nav.classList.remove('is-open');
                actions.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.setAttribute('aria-label', 'Buka menu');
                toggle.innerHTML = '<i class="bi bi-list"></i>';
            });
        });
    }());
</script>
</body>
</html>
