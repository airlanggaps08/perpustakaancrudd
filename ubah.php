<?php
require "koneksi.php";
$id = (int) $_GET["id"];
if (isset($_POST["simpan"])) {
$judul = $_POST["judul"];
$penulis = $_POST["penulis"];
$tahun = $_POST["tahun_terbit"];
$stok = $_POST["stok"];
$sql = "UPDATE buku
SET judul = ?, penulis = ?, tahun_terbit = ?, stok = ?
WHERE id_buku = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "ssiii",
$judul, $penulis, $tahun, $stok, $id);
mysqli_stmt_execute($stmt);
header("Location: index.php?pesan=Data berhasil diubah");
exit;
}
$hasil = mysqli_query($koneksi, "SELECT * FROM buku WHERE id_buku = $id");
$buku = mysqli_fetch_assoc($hasil);
?>
<?php
$judulHalaman = 'Ubah buku';
$labelSimpan = 'Simpan perubahan';
require __DIR__ . '/tampilan/formulir-buku.php';
