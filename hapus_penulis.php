<?php
include 'koneksi.php';
$id = $_GET['id'];

// 1. Cek relasi artikel (Poin 6 - SUDAH BENAR)
$cek = mysqli_query($conn, "SELECT id FROM artikel WHERE id_penulis = $id");
if(mysqli_num_rows($cek) > 0) {
    die("Gagal! Penulis ini masih memiliki artikel.");
}

// 2. Ambil nama file foto dulu sebelum data di hapus (Biar folder nggak penuh sampah)
$cari_foto = mysqli_query($conn, "SELECT foto FROM penulis WHERE id = $id");
$data = mysqli_fetch_assoc($cari_foto);
$nama_file = $data['foto'];

// 3. Hapus data di database
$hapus = mysqli_query($conn, "DELETE FROM penulis WHERE id = $id");

if($hapus) {
    // 4. Kalau di DB berhasil hapus, baru hapus file fisiknya di folder
    // Cek dulu apakah filenya ada dan bukan folder
    if (!empty($nama_file) && file_exists("uploads_penulis/" . $nama_file)) {
        unlink("uploads_penulis/" . $nama_file);
    }
    echo "Data dan foto berhasil dihapus!";
} else {
    echo "Gagal menghapus data.";
}
?>