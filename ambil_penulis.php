<?php include 'koneksi.php'; ?>
<div style="margin-bottom: 20px; overflow: hidden;">
    <h3 style="float: left;">Data Penulis</h3>
    <button class="btn btn-add" onclick="bukaModalTambah()">+ Tambah Penulis</button>
</div>

<table>
    <thead>
        <tr>
            <th>FOTO</th>
            <th>NAMA</th>
            <th>USERNAME</th>
            <th>PASSWORD</th>
            <th>AKSI</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM penulis");
        while ($row = mysqli_fetch_array($sql)) {
            
            // --- TARUH LOGIKA FOTO DI SINI (Sebelum <tr>) ---
            $nama_file = trim($row['foto']);
            $folder = 'uploads_penulis/';
            
            // Cek fisik file: Kalau ada di DB dan ada di Folder, pakai itu. 
            // Kalau salah satu nggak ada, pakai default.png
            if (!empty($nama_file) && file_exists($folder . $nama_file)) {
                $tampil_foto = $folder . $nama_file;
            } else {
                $tampil_foto = $folder . 'default.png';
            }
            // ------------------------------------------------
        ?>
            <tr>
                <td>
                    <img src="<?= $tampil_foto ?>?t=<?= time(); ?>" width="40" height="40" 
                         style="border-radius: 50%; object-fit: cover; border: 1px solid #eee;">
                </td>
                <td><?= htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']) ?></td>
                <td><?= htmlspecialchars($row['user_name']) ?></td>
                <td><small style="color: #999;"><i>[Hashed]</i></small></td>
                <td>
                    <button class="btn btn-edit" onclick="editPenulis(<?= $row['id'] ?>)">Edit</button>
                    <button class="btn btn-delete" onclick="hapusPenulis(<?= $row['id'] ?>)">Hapus</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>