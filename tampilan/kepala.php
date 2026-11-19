<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($judulHalaman) ?> · Perpustakaan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a class="skip-link" href="#konten">Langsung ke konten</a>
<aside class="sidebar">
        <a class="wordmark" href="index.php">
            <span class="brand-mark" aria-hidden="true"><i></i><i></i><i></i></span>
            Perpustakaan
        </a>
        <nav aria-label="Menu utama">
            <a href="index.php" <?= $judulHalaman === 'Dashboard' ? 'aria-current="page"' : '' ?>><i class="nav-icon grid-icon" aria-hidden="true"></i>Dashboard</a>
            <a href="index.php?halaman=katalog" <?= $judulHalaman === 'Katalog buku' ? 'aria-current="page"' : '' ?>><i class="nav-icon catalog-icon" aria-hidden="true"></i>Katalog</a>
            <a href="tambah.php" <?= $judulHalaman === 'Tambah buku' ? 'aria-current="page"' : '' ?>><i class="nav-icon plus-icon" aria-hidden="true"></i>Tambah buku</a>
        </nav>
        <?php require __DIR__ . '/rak.php'; ?>
</aside>
