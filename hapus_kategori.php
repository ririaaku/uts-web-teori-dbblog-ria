<?php
include 'koneksi.php';
$id = $_GET['id'];

// Syarat Poin 4: Cek jika kategori masih memiliki artikel
$cek_artikel = mysqli_query($conn, "SELECT id FROM artikel WHERE id_kategori = $id");

if (mysqli_num_rows($cek_artikel) > 0) {
    echo "Gagal! Kategori ini tidak bisa dihapus karena masih digunakan oleh beberapa artikel.";
} else {
    mysqli_query($conn, "DELETE FROM kategori_artikel WHERE id = $id");
    echo "Kategori berhasil dihapus!";
}
?>