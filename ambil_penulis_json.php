<?php 
include 'koneksi.php'; 
$q = mysqli_query($conn, "SELECT id, nama_depan FROM penulis"); 
echo json_encode(mysqli_fetch_all($q, MYSQLI_ASSOC)); 
?>