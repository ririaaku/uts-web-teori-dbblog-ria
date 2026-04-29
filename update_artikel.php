<?php
include 'koneksi.php';

$id          = $_POST['id'];
$id_penulis  = $_POST['id_penulis'];
$id_kategori = $_POST['id_kategori'];
$judul       = $_POST['judul'];
$isi         = $_POST['isi'];

// 1. Logika Update Gambar (Jika ada gambar baru)
if (!empty($_FILES['gambar']['name'])) {
    // Ambil nama file lama buat dihapus
    $q_lama = mysqli_query($conn, "SELECT gambar FROM artikel WHERE id = $id");
    $data_lama = mysqli_fetch_assoc($q_lama);
    if (file_exists("uploads_artikel/" . $data_lama['gambar'])) {
        unlink("uploads_artikel/" . $data_lama['gambar']);
    }

    // Upload file baru
    $nama_gambar = time() . "_" . $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], "uploads_artikel/" . $nama_gambar);

    // Update dengan gambar baru
    $stmt = mysqli_prepare($conn, "UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "iisssi", $id_penulis, $id_kategori, $judul, $isi, $nama_gambar, $id);
} else {
    // 2. Update tanpa ganti gambar
    $stmt = mysqli_prepare($conn, "UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "iissi", $id_penulis, $id_kategori, $judul, $isi, $id);
}

if (mysqli_stmt_execute($stmt)) {
    echo "Artikel berhasil diperbarui!";
} else {
    echo "Gagal memperbarui artikel.";
}
?>