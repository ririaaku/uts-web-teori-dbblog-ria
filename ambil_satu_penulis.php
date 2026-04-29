<?php
include 'koneksi.php';
$id = $_GET['id'];
$q = mysqli_query($conn, "SELECT * FROM penulis WHERE id = $id");
$data = mysqli_fetch_assoc($q);

// Ini yang bikin JavaScript bisa baca datanya
echo json_encode($data);
?>