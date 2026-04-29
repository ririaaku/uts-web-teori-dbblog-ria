<?php
include 'koneksi.php';

$id            = $_POST['id'];
$nama_kategori = $_POST['nama_kategori'];
$keterangan    = $_POST['keterangan'];

$stmt = mysqli_prepare($conn, "UPDATE kategori_artikel SET nama_kategori = ?, keterangan = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "ssi", $nama_kategori, $keterangan, $id);

if (mysqli_stmt_execute($stmt)) {
    echo "Kategori berhasil diperbarui!";
}
?>