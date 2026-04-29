<?php
include 'koneksi.php';
$id = $_GET['id'];

// Ambil nama gambar dulu sebelum data dihapus
$q = mysqli_query($conn, "SELECT gambar FROM artikel WHERE id = $id");
$data = mysqli_fetch_assoc($q);

if ($data) {
    // Poin 8: Hapus file dari folder uploads_artikel
    if (file_exists("uploads_artikel/" . $data['gambar'])) {
        unlink("uploads_artikel/" . $data['gambar']);
    }

    mysqli_query($conn, "DELETE FROM artikel WHERE id = $id");
    echo "Artikel dan gambar berhasil dihapus!";
}
?>