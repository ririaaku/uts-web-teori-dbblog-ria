<?php
include 'koneksi.php';

// --- 1. LOGIKA TANGGAL (Sesuai Syarat UTS) ---
date_default_timezone_set('Asia/Jakarta');
$hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$bulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
$sekarang = new DateTime();
$hari_tanggal = $hari[$sekarang->format('w')] . ", " . $sekarang->format('j') . " " . $bulan[(int)$sekarang->format('n')] . " " . $sekarang->format('Y') . " | " . $sekarang->format('H:i');

// --- 2. AMBIL DATA DARI FORM ---
$id_penulis  = $_POST['id_penulis'];
$id_kategori = $_POST['id_kategori'];
$judul       = $_POST['judul'];
$isi         = $_POST['isi'];
$nama_gambar = ""; // Default kosong jika tidak upload

// --- 3. VALIDASI & UPLOAD GAMBAR (KEAMANAN) ---
if (!empty($_FILES['gambar']['name'])) {
    $file_tmp  = $_FILES['gambar']['tmp_name'];
    $file_size = $_FILES['gambar']['size'];

    // Poin 3 Keamanan: Limit 2MB
    if ($file_size > 2 * 1024 * 1024) {
        die("Gagal! Ukuran file maksimal adalah 2MB.");
    }

    // Poin 2 Keamanan: Validasi Tipe File pakai finfo
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file_tmp);
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($mime, $allowed_types)) {
        die("Gagal! File yang diupload harus berupa gambar (JPG/PNG/GIF).");
    }

    // Jika lolos validasi, baru pindahkan file
    $nama_gambar = time() . "_" . $_FILES['gambar']['name'];
    move_uploaded_file($file_tmp, "uploads_artikel/" . $nama_gambar);
}

// --- 4. PREPARED STATEMENTS (KEAMANAN POIN 1) ---
$sql  = "INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

// "iissss" artinya: integer, integer, string, string, string, string
mysqli_stmt_bind_param($stmt, "iissss", $id_penulis, $id_kategori, $judul, $isi, $nama_gambar, $hari_tanggal);

if (mysqli_stmt_execute($stmt)) {
    echo "Artikel berhasil disimpan!";
} else {
    echo "Gagal menyimpan: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>