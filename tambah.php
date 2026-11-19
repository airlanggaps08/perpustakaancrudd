<?php
require "koneksi.php";
if (isset($_POST["simpan"])) {
$judul = $_POST["judul"];
$penulis = $_POST["penulis"];
$tahun = $_POST["tahun_terbit"];
$stok = $_POST["stok"];
$sql = "INSERT INTO buku (judul, penulis, tahun_terbit, stok)
VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "ssii", $judul, $penulis, $tahun, $stok);
mysqli_stmt_execute($stmt);
header("Location: index.php?pesan=Data berhasil ditambahkan");
exit;
}
?>
<?php
$judulHalaman = 'Tambah buku';
$labelSimpan = 'Simpan buku';
require __DIR__ . '/tampilan/formulir-buku.php';
