<?php
include 'koneksi.php';

$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$user_name = $_POST['user_name'];
// Syarat 3.4: Password di-hash pakai BCRYPT
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$foto_name = "";

if(!empty($_FILES['foto']['name'])) {
    $tmp = $_FILES['foto']['tmp_name'];
    $size = $_FILES['foto']['size'];
    
    // Syarat 3.3: Ukuran file maksimal 2 MB
    if($size > 2 * 1024 * 1024) { 
        die("Ukuran file maksimal 2MB!");
    }
    
    // Syarat 3.2: Validasi tipe file menggunakan fungsi finfo
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($tmp);
    $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
    
    if(!in_array($mime, $allowed)) {
        die("Tipe file harus gambar (JPG/PNG)!");
    }
    
    $foto_name = time() . "_" . $_FILES['foto']['name'];
    move_uploaded_file($tmp, "uploads_penulis/" . $foto_name);
}

// Syarat 3.1: Prepared statements dengan mysqli
$sql = "INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $nama_depan, $nama_belakang, $user_name, $password, $foto_name);

if(mysqli_stmt_execute($stmt)) {
    echo "Data berhasil disimpan!";
} else {
    echo "Gagal: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>