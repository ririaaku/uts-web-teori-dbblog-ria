<?php
include 'koneksi.php';

$id = $_POST['id'];
$nama_depan = $_POST['nama_depan'];
$nama_belakang = $_POST['nama_belakang'];
$user_name = $_POST['user_name'];

if(!empty($_POST['password'])) {
    $pw = password_hash($_POST['password'], PASSWORD_BCRYPT);
    mysqli_query($conn, "UPDATE penulis SET password = '$pw' WHERE id = $id");
}

if(!empty($_FILES['foto']['name'])) {
    $tmp = $_FILES['foto']['tmp_name'];
    $foto_name = time() . "_" . $_FILES['foto']['name'];
    move_uploaded_file($tmp, "uploads_penulis/" . $foto_name);
    mysqli_query($conn, "UPDATE penulis SET foto = '$foto_name' WHERE id = $id");
}

$stmt = mysqli_prepare($conn, "UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=? WHERE id=?");
mysqli_stmt_bind_param($stmt, "sssi", $nama_depan, $nama_belakang, $user_name, $id);

if(mysqli_stmt_execute($stmt)) {
    echo "Perubahan disimpan!";
}
?>