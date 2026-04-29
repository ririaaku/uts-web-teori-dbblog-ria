<?php
include 'koneksi.php';

$id = $_GET['id'];
// Ambil data artikel tertentu
$q = mysqli_query($conn, "SELECT * FROM artikel WHERE id = $id");
$data = mysqli_fetch_assoc($q);

// Kirim hasil ke JavaScript dalam format JSON
echo json_encode($data);
?>