<?php
require "koneksi.php";
$kata = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
$dashboard = ($_GET['halaman'] ?? '') !== 'katalog' && !isset($_GET['q']) && !isset($_GET['pesan']);
if ($kata === '') {
    $hasil = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id_buku");
} else {
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM buku
        WHERE LOCATE(LOWER(?), LOWER(judul)) > 0 OR LOCATE(LOWER(?), LOWER(penulis)) > 0
        ORDER BY id_buku");
    mysqli_stmt_bind_param($stmt, 'ss', $kata, $kata);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);
}
$jumlahHasil = mysqli_num_rows($hasil);
$jumlahJudul = $jumlahHasil;
if ($dashboard) {
    $ringkasan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COALESCE(SUM(stok), 0) AS eksemplar,
        COUNT(DISTINCT NULLIF(TRIM(penulis), '')) AS penulis FROM buku"));
} elseif ($kata !== '') {
    $jumlahJudul = (int) mysqli_fetch_row(mysqli_query($koneksi, "SELECT COUNT(*) FROM buku"))[0];
}
$filterUrl = $kata === '' ? '' : '&amp;q=' . rawurlencode($kata);
$judulHalaman = $dashboard ? 'Dashboard' : 'Katalog buku';
require __DIR__ . '/tampilan/kepala.php';
?>
<main class="wrap" id="konten">
    <header class="page-heading">
        <h1><?= $judulHalaman ?></h1>
        <a class="button primary" href="tambah.php"><span aria-hidden="true">+</span> Tambah buku</a>
    </header>
    <?php if ($dashboard) { ?>
        <dl class="metrics" aria-label="Ringkasan koleksi">
            <div><dt>Judul buku</dt><dd><?= $jumlahJudul ?></dd></div>
            <div><dt>Total eksemplar</dt><dd><?= (int) $ringkasan['eksemplar'] ?></dd></div>
            <div><dt>Penulis</dt><dd><?= (int) $ringkasan['penulis'] ?></dd></div>
        </dl>
    <?php } ?>

    <?php if (isset($_GET["pesan"])) { ?>
        <p class="pesan" role="status"><?= htmlspecialchars($_GET["pesan"]) ?></p>
    <?php } ?>

    <div class="catalog-panel">
            <div class="catalog-tools">
                <h2><?= $dashboard ? 'Katalog buku' : 'Daftar buku' ?></h2>
                <?php if ($jumlahJudul > 0 || $kata !== '') { ?>
                <form class="search-form" role="search" method="get" action="index.php">
                    <input type="hidden" name="halaman" value="katalog">
                    <label class="search-box">
                        <span class="search-icon" aria-hidden="true"></span>
                        <span class="sr-only">Cari judul atau penulis</span>
                        <input type="search" name="q" value="<?= htmlspecialchars($kata) ?>" placeholder="Cari judul atau penulis…">
                    </label>
                    <button class="button primary" type="submit">Cari</button>
                </form>
                <?php } ?>
            </div>
        <?php if ($kata !== '') { ?>
            <p class="result-count"><?= $jumlahHasil ?> judul ditemukan · <a href="index.php?halaman=katalog">Tampilkan semua</a></p>
        <?php } ?>
        <table aria-label="Daftar buku">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Penulis</th>
                    <th scope="col">Tahun</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php while ($baris = mysqli_fetch_assoc($hasil)) { ?>
                    <tr class="book-row">
                        <td class="number"><?= $no++ ?></td>
                        <td class="book-title"><?= htmlspecialchars($baris["judul"]) ?></td>
                        <td class="author"><?= htmlspecialchars($baris["penulis"]) ?></td>
                        <td class="year"><span class="mobile-label" aria-hidden="true">Tahun </span><?= $baris["tahun_terbit"] ?></td>
                        <td class="stock"><span class="mobile-label" aria-hidden="true">Stok </span><span class="stock-value"><?= $baris["stok"] ?></span></td>
                        <td class="actions">
                            <a href="ubah.php?id=<?= $baris["id_buku"] ?>">Ubah</a>
                            <a class="delete-link" href="hapus.php?id=<?= $baris["id_buku"] . $filterUrl ?>">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if ($jumlahJudul === 0) { ?>
            <p class="empty-state">Belum ada buku di katalog. <a href="tambah.php">Tambahkan buku pertama</a>.</p>
        <?php } elseif ($jumlahHasil === 0) { ?>
            <p class="empty-state">Buku tidak ditemukan. Coba judul atau nama penulis lain.</p>
        <?php } ?>
    </div>
</main>
</body>
</html>
