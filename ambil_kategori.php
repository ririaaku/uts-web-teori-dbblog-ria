<?php include 'koneksi.php'; ?>
<div style="margin-bottom: 20px; overflow: hidden;">
    <h3 style="float: left;">Data Kategori Artikel</h3>
    <button class="btn-simpan" style="float: right;" onclick="bukaModalTambahKategori()">+ Tambah Kategori</button>
</div>

<table>
    <thead>
        <tr>
            <th>NAMA KATEGORI</th>
            <th>KETERANGAN</th>
            <th>AKSI</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = mysqli_query($conn, "SELECT * FROM kategori_artikel ORDER BY id DESC");
        while ($row = mysqli_fetch_array($sql)) {
        ?>
            <tr>
                <td style="font-weight: bold; color: #2c3e50;"><?= htmlspecialchars($row['nama_kategori']) ?></td>
                <td style="color: #7f8c8d; font-size: 13px;"><?= htmlspecialchars($row['keterangan']) ?></td>
                <td>
                    <button class="btn-edit" onclick="editKategori(<?= $row['id'] ?>)">Edit</button>
                    <button class="btn-delete" onclick="hapusKategori(<?= $row['id'] ?>)">Hapus</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>