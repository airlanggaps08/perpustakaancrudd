<?php require __DIR__ . '/kepala.php'; ?>
<main class="wrap form-wrap" id="konten">
    <div class="form-panel">
        <div class="form-heading"><h1><?= htmlspecialchars($judulHalaman) ?></h1></div>
        <form method="post" class="book-form">
            <label for="judul">Judul buku</label>
            <input id="judul" type="text" name="judul" value="<?= htmlspecialchars($buku['judul'] ?? '') ?>" required>

            <label for="penulis">Penulis</label>
            <input id="penulis" type="text" name="penulis" value="<?= htmlspecialchars($buku['penulis'] ?? '') ?>" required>

            <div class="field-pair">
                <div>
                    <label for="tahun-terbit">Tahun terbit</label>
                    <input id="tahun-terbit" type="number" name="tahun_terbit" value="<?= htmlspecialchars((string) ($buku['tahun_terbit'] ?? '')) ?>" required>
                </div>
                <div>
                    <label for="stok">Stok</label>
                    <input id="stok" type="number" name="stok" value="<?= htmlspecialchars((string) ($buku['stok'] ?? '')) ?>" required>
                </div>
            </div>
            <div class="form-actions">
                <button class="button primary" type="submit" name="simpan"><?= htmlspecialchars($labelSimpan) ?></button>
                <a class="button secondary" href="index.php?halaman=katalog">Batal</a>
            </div>
        </form>
    </div>
</main>
</body>
</html>
