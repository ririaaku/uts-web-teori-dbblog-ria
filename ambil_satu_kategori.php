<?php
include 'koneksi.php';
$id = $_GET['id'];
$q = mysqli_query($conn, "SELECT * FROM kategori_artikel WHERE id = $id");
echo json_encode(mysqli_fetch_assoc($q));
?>