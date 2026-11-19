<?php
require "koneksi.php";
session_start();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$kata = is_string($_GET['q'] ?? null) ? trim($_GET['q']) : '';
$filter = ['halaman' => 'katalog'];
if ($kata !== '') {
    $filter['q'] = $kata;
}
$katalog = 'index.php?' . http_build_query($filter);
$metode = $_SERVER['REQUEST_METHOD'];
$galat = '';

if (!$id) {
    http_response_code(404);
    $galat = 'Buku tidak ditemukan.';
} elseif ($metode === 'POST') {
    $token = $_POST['token'] ?? null;
    if (!isset($_SESSION['kunci_hapus']) || !is_string($token)
        || !hash_equals(hash_hmac('sha256', (string) $id, $_SESSION['kunci_hapus']), $token)) {
        http_response_code(403);
        $galat = 'Konfirmasi tidak berlaku. Buka kembali buku yang ingin dihapus dari katalog.';
    } else {
        $stmt = mysqli_prepare($koneksi, "DELETE FROM buku WHERE id_buku = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $pesan = mysqli_stmt_affected_rows($stmt) ? 'Data berhasil dihapus' : 'Buku sudah tidak ada di katalog';
        header('Location: index.php?' . http_build_query($filter + ['pesan' => $pesan]), true, 303);
        exit;
    }
} elseif ($metode === 'GET' || $metode === 'HEAD') {
    $stmt = mysqli_prepare($koneksi, "SELECT judul, penulis FROM buku WHERE id_buku = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $buku = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if ($buku) {
        $_SESSION['kunci_hapus'] ??= bin2hex(random_bytes(32));
        $token = hash_hmac('sha256', (string) $id, $_SESSION['kunci_hapus']);
    } else {
        http_response_code(404);
        $galat = 'Buku tidak ditemukan.';
    }
} else {
    http_response_code(405);
    header('Allow: GET, HEAD, POST');
    $galat = 'Buka halaman konfirmasi melalui katalog.';
}

$judulHalaman = 'Hapus buku';
require __DIR__ . '/tampilan/kepala.php';
?>
<main class="wrap form-wrap" id="konten">
    <div class="form-panel">
        <div class="form-heading"><h1>Hapus buku</h1></div>
        <?php if ($galat !== '') { ?>
            <div class="book-form">
                <p class="confirm-text"><?= htmlspecialchars($galat) ?></p>
                <div class="form-actions"><a class="button secondary" href="<?= htmlspecialchars($katalog) ?>">Kembali ke katalog</a></div>
            </div>
        <?php } else { ?>
            <form class="book-form" method="post">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <p class="confirm-text">Hapus <strong><?= htmlspecialchars($buku['judul']) ?></strong> karya <?= htmlspecialchars($buku['penulis']) ?> dari katalog?</p>
                <div class="form-actions">
                    <a class="button secondary" href="<?= htmlspecialchars($katalog) ?>">Batal</a>
                    <button class="button danger" type="submit">Ya, hapus buku</button>
                </div>
            </form>
        <?php } ?>
    </div>
</main>
</body>
</html>
