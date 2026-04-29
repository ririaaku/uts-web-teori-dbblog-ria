<?php include 'koneksi.php'; ?>
<div style="margin-bottom: 20px; overflow: hidden;">
    <h3 style="float: left;">Data Artikel</h3>
    <button class="btn-simpan" style="float: right;" onclick="bukaModalTambahArtikel()">+ Tambah Artikel</button>
</div>

<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>GAMBAR</th>
            <th>JUDUL</th>
            <th>KATEGORI</th>
            <th>PENULIS</th>
            <th>TANGGAL</th>
            <th>AKSI</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // JOIN antar 3 tabel
        $sql = mysqli_query($conn, "SELECT a.*, k.nama_kategori, p.nama_depan 
                                    FROM artikel a 
                                    JOIN kategori_artikel k ON a.id_kategori = k.id 
                                    JOIN penulis p ON a.id_penulis = p.id 
                                    ORDER BY a.id DESC");
        while ($row = mysqli_fetch_array($sql)) {
            // LOGIKA GAMBAR: Kita proses dulu di sini sebelum masuk ke kolom
            $path_gambar = 'uploads_artikel/' . $row['gambar'];
            if (!empty($row['gambar']) && file_exists($path_gambar)) {
                $gambar_tampil = $path_gambar;
            } else {
                $gambar_tampil = 'uploads_artikel/default.png'; 
            }
        ?>
            <tr>
                <td>
                    <img src="<?= $gambar_tampil ?>?t=<?= time(); ?>" width="50" height="50" style="border-radius: 4px; object-fit: cover; border: 1px solid #eee;">
                </td>

                <td style="font-weight: bold;"><?= htmlspecialchars($row['judul']) ?></td>

                <td>
                    <span style="background: #e3f2fd; color: #1976d2; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 600;">
                        <?= $row['nama_kategori'] ?>
                    </span>
                </td>

                <td><?= $row['nama_depan'] ?></td>

                <td><small style="color: #666;"><?= $row['hari_tanggal'] ?></small></td>

                <td>
                    <button class="btn-edit" onclick="editArtikel(<?= $row['id'] ?>)">Edit</button>
                    <button class="btn-delete" onclick="hapusArtikel(<?= $row['id'] ?>)">Hapus</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>