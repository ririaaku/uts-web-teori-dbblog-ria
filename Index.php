<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Manajemen Blog (CMS) - Ria Kurniawati</title>
    <style>
        /* CSS DASAR & LAYOUT */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { display: flex; flex-direction: column; height: 100vh; background: #f4f7f6; }
        header { background: #34495e; color: white; padding: 15px 25px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .wrapper { display: flex; flex: 1; overflow: hidden; }
        
        /* SIDEBAR */
        nav { width: 250px; background: white; padding: 20px; border-right: 1px solid #ddd; }
        nav p { font-size: 11px; color: #999; font-weight: bold; margin-bottom: 15px; }
        nav ul { list-style: none; }
        nav ul li a { display: block; padding: 12px; text-decoration: none; color: #333; border-radius: 8px; margin-bottom: 5px; cursor: pointer; font-size: 14px; }
        nav ul li a:hover, nav ul li a.active { background: #e8f5e9; color: #2ecc71; font-weight: bold; }
        
        /* KONTEN UTAMA */
        main { flex: 1; padding: 30px; overflow-y: auto; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        
        /* TABEL & TOMBOL */
        table { width: 100%; border-collapse: collapse; }
        table th, table td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; font-size: 14px; }
        .btn { padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; color: white; font-size: 12px; }
        .btn-add { background: #2ecc71; float: right; }
       /* Styling tombol agar modern & bersih */
        .btn-edit {
        background-color: #3498db; /* Warna Biru */
        color: white;
        border: none; /* Menghilangkan garis pinggir hitam */
        padding: 8px 16px;
        border-radius: 6px; /* Membuat pojokan tumpul/rounded */
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
        margin-right: 5px;
}

        .btn-delete {
        background-color: #e74c3c; /* Warna Merah */
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.3s;
}

        /* Efek saat kursor menempel (hover) */
        .btn-edit:hover { background-color: #2980b9; }
        .btn-delete:hover { background-color: #c0392b; }

        /* MODAL CUSTOM RIA */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content { background: white; margin: 5% auto; padding: 25px; border-radius: 15px; width: 450px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        
        /* FORM DALAM MODAL */
        .form-group-row { display: flex; gap: 15px; margin-bottom: 10px; }
        .form-group { flex: 1; margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; font-weight: bold; margin-bottom: 5px; color: #333; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background: #fafafa; font-size: 14px; }
        .modal-footer { text-align: right; margin-top: 20px; display: flex; justify-content: flex-end; gap: 10px; }
        .btn-batal { background: #9e9e9e; color: white; padding: 10px 25px; border-radius: 6px; border: none; cursor: pointer; font-weight: bold; }
        .btn-simpan { background: #4caf50; color: white; padding: 10px 20px; border-radius: 6px; border: none; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>

<header><h2>Sistem Manajemen Blog (CMS)</h2></header>

<div class="wrapper">
    <nav>
        <p>MENU UTAMA</p>
        <ul>
            <li><a onclick="muatHalaman('penulis')" id="m-penulis">Kelola Penulis</a></li>
            <li><a onclick="muatHalaman('artikel')" id="m-artikel">Kelola Artikel</a></li>
            <li><a onclick="muatHalaman('kategori')" id="m-kategori">Kelola Kategori</a></li>
        </ul>
    </nav>
    <main>
        <div id="konten-tampil" class="card">
            <p>Memuat data...</p>
        </div>
    </main>
</div>

<div id="box-modal" class="modal">
    <div class="modal-content" id="isi-modal"></div>
</div>

<script>
    // 1. Fungsi Navigasi
    function muatHalaman(menu) {
        document.querySelectorAll('nav a').forEach(a => a.classList.remove('active'));
        const el = document.getElementById('m-' + menu);
        if(el) el.classList.add('active');

        fetch('ambil_' + menu + '.php')
            .then(res => res.text())
            .then(data => {
                document.getElementById('konten-tampil').innerHTML = data;
            })
            .catch(err => console.error("Error Fetch:", err));
    }

    // 2. Fungsi Tutup Modal
    function tutupModal() {
        document.getElementById('box-modal').style.display = 'none';
    }

    // 3. Fungsi Tambah Penulis
    function bukaModalTambah() {
        document.getElementById('box-modal').style.display = 'block';
        document.getElementById('isi-modal').innerHTML = `
            <h3 style="margin-bottom:20px;">Tambah Penulis</h3>
            <form id="formSimpan">
                <div class="form-group-row">
                    <div class="form-group">
                        <label>Nama Depan</label>
                        <input type="text" name="nama_depan" placeholder="Azizatul" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Belakang</label>
                        <input type="text" name="nama_belakang" placeholder="Nabilah" required>
                    </div>
                </div>
                <div class="form-group"><label>Username</label><input type="text" name="user_name" placeholder="a_nabilah" required></div>
                <div class="form-group"><label>Password</label><input type="password" name="password" placeholder="" required></div>
                <div class="form-group"><label>Foto Profil</label><input type="file" name="foto"></div>
                <div class="modal-footer">
                    <button type="button" class="btn-batal" onclick="tutupModal()">Batal</button>
                    <button type="submit" class="btn-simpan">Simpan Data</button>
                </div>
            </form>
        `;
        document.getElementById('formSimpan').onsubmit = function(e) {
            e.preventDefault();
            fetch('simpan_penulis.php', { method: 'POST', body: new FormData(this) })
            .then(res => res.text()).then(msg => { alert(msg); tutupModal(); muatHalaman('penulis'); });
        };
    }

    // 4. Fungsi Edit Penulis
    function editPenulis(id) {
        fetch('ambil_satu_penulis.php?id=' + id)
        .then(res => res.json())
        .then(data => {
            document.getElementById('box-modal').style.display = 'block';
            document.getElementById('isi-modal').innerHTML = `
                <h3 style="margin-bottom:20px;">Edit Penulis</h3>
                <form id="formUpdate">
                    <input type="hidden" name="id" value="${data.id}">
                    <div class="form-group-row">
                        <div class="form-group"><label>Nama Depan</label><input type="text" name="nama_depan" value="${data.nama_depan}" required></div>
                        <div class="form-group"><label>Nama Belakang</label><input type="text" name="nama_belakang" value="${data.nama_belakang}" required></div>
                    </div>
                    <div class="form-group"><label>Username</label><input type="text" name="user_name" value="${data.user_name}" required></div>
                    <div class="form-group"><label>Password Baru (opsional)</label><input type="password" name="password" placeholder="••••••••"></div>
                    <div class="form-group"><label>Foto Profil (opsional)</label><input type="file" name="foto"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn-batal" onclick="tutupModal()">Batal</button>
                        <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                    </div>
                </form>
            `;
            document.getElementById('formUpdate').onsubmit = function(e) {
                e.preventDefault();
                fetch('update_penulis.php', { method: 'POST', body: new FormData(this) })
                .then(res => res.text()).then(msg => { alert(msg); tutupModal(); muatHalaman('penulis'); });
            };
        });
    }

    // 5. Fungsi Konfirmasi Hapus (Custom Modal)
    function hapusPenulis(id) {
        document.getElementById('box-modal').style.display = 'block';
        document.getElementById('isi-modal').innerHTML = `
            <div style="text-align: center; padding: 10px;">
                <div style="width: 50px; height: 50px; background: #ffebee; color: #ef5350; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 25px;">🗑</div>
                <h3 style="margin-bottom: 5px;">Hapus data ini?</h3>
                <p style="color: #999; font-size: 13px; margin-bottom: 25px;">Data yang dihapus tidak dapat dikembalikan.</p>
                <div style="display: flex; justify-content: center; gap: 10px;">
                    <button onclick="tutupModal()" class="btn-batal">Batal</button>
                    <button id="btn-konfirm-hapus" class="btn-simpan" style="background: #ef5350;">Ya, Hapus</button>
                </div>
            </div>
        `;
        document.getElementById('btn-konfirm-hapus').onclick = function() {
            fetch('hapus_penulis.php?id=' + id).then(res => res.text()).then(msg => { 
                alert(msg); tutupModal(); muatHalaman('penulis'); 
            });
        };
    }
// FUNGSI TAMBAH ARTIKEL (GAMBAR 7)
function bukaModalTambahArtikel() {
    document.getElementById('box-modal').style.display = 'block';
    document.getElementById('isi-modal').innerHTML = `
        <h3 style="margin-bottom:20px;">Tambah Artikel</h3>
        <form id="formSimpanArtikel">
            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="judul" placeholder="Judul artikel..." required>
            </div>
            <div class="form-group-row">
                <div class="form-group">
                    <label>Penulis</label>
                    <select name="id_penulis" id="drop-penulis" required></select>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="id_kategori" id="drop-kategori" required></select>
                </div>
            </div>
            <div class="form-group">
                <label>Isi Artikel</label>
                <textarea name="isi" placeholder="Tulis isi artikel di sini..." style="width:100%; height:120px; padding:10px; border-radius:6px; border:1px solid #ddd;"></textarea>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-batal" onclick="tutupModal()">Batal</button>
                <button type="submit" class="btn-simpan">Simpan Data</button>
            </div>
        </form>
    `;
    
    // Poin 5 & 6: Isi Dropdown dari Database
    isiDropdown('ambil_penulis_json.php', 'drop-penulis');
    isiDropdown('ambil_kategori_json.php', 'drop-kategori');

    document.getElementById('formSimpanArtikel').onsubmit = function(e) {
        e.preventDefault();
        fetch('simpan_artikel.php', { method: 'POST', body: new FormData(this) })
        .then(res => res.text()).then(msg => { alert(msg); tutupModal(); muatHalaman('artikel'); });
    };
}

// Fungsi pembantu buat ngisi dropdown
function isiDropdown(url, idElemen) {
    fetch(url).then(res => res.json()).then(data => {
        let html = '<option value="">Pilih...</option>';
        data.forEach(item => {
            let label = item.nama_depan || item.nama_kategori;
            html += `<option value="${item.id}">${label}</option>`;
        });
        document.getElementById(idElemen).innerHTML = html;
    });
}

// FUNGSI HAPUS ARTIKEL (GAMBAR 9)
function hapusArtikel(id) {
    document.getElementById('box-modal').style.display = 'block';
    document.getElementById('isi-modal').innerHTML = `
        <div style="text-align: center; padding: 10px;">
            <div style="width: 50px; height: 50px; background: #ffebee; color: #ef5350; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 25px;">🗑</div>
            <h3>Hapus data ini?</h3>
            <p style="color: #999; font-size: 13px; margin-bottom: 25px;">Data yang dihapus tidak dapat dikembalikan.</p>
            <div style="display: flex; justify-content: center; gap: 10px;">
                <button onclick="tutupModal()" class="btn-batal">Batal</button>
                <button id="konfirm-hapus-artikel" class="btn-simpan" style="background: #ef5350;">Ya, Hapus</button>
            </div>
        </div>
    `;
    document.getElementById('konfirm-hapus-artikel').onclick = function() {
        fetch('hapus_artikel.php?id=' + id).then(res => res.text()).then(msg => { 
            alert(msg); tutupModal(); muatHalaman('artikel'); 
        });
    };
}

function editArtikel(id) {
    // 1. Ambil data artikel lama
    fetch('ambil_satu_artikel.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('box-modal').style.display = 'block';
        document.getElementById('isi-modal').innerHTML = `
            <h3 style="margin-bottom:20px;">Edit Artikel</h3>
            <form id="formUpdateArtikel">
                <input type="hidden" name="id" value="${data.id}">
                <div class="form-group">
                    <label>Judul Artikel</label>
                    <input type="text" name="judul" value="${data.judul}" required>
                </div>
                <div class="form-group-row">
                    <div class="form-group">
                        <label>Penulis</label>
                        <select name="id_penulis" id="edit-penulis" required></select>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="id_kategori" id="edit-kategori" required></select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Isi Artikel</label>
                    <textarea name="isi" style="width:100%; height:100px; border-radius:6px; padding:10px; border:1px solid #ddd;">${data.isi}</textarea>
                </div>
                <div class="form-group">
                    <label>Ganti Gambar (biarkan kosong jika tidak diganti)</label>
                    <input type="file" name="gambar">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-batal" onclick="tutupModal()">Batal</button>
                    <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                </div>
            </form>
        `;

        // 2. Load dropdown penulis & kategori dan set yang terpilih (selected)
        fetch('ambil_penulis_json.php').then(res => res.json()).then(p_list => {
            let opt = '';
            p_list.forEach(p => {
                let s = (p.id == data.id_penulis) ? 'selected' : '';
                opt += `<option value="${p.id}" ${s}>${p.nama_depan}</option>`;
            });
            document.getElementById('edit-penulis').innerHTML = opt;
        });

        fetch('ambil_kategori_json.php').then(res => res.json()).then(k_list => {
            let opt = '';
            k_list.forEach(k => {
                let s = (k.id == data.id_kategori) ? 'selected' : '';
                opt += `<option value="${k.id}" ${s}>${k.nama_kategori}</option>`;
            });
            document.getElementById('edit-kategori').innerHTML = opt;
        });

        // 3. Logika kirim ke update_artikel.php
        document.getElementById('formUpdateArtikel').onsubmit = function(e) {
            e.preventDefault();
            fetch('update_artikel.php', { method: 'POST', body: new FormData(this) })
            .then(res => res.text()).then(msg => { 
                alert(msg); tutupModal(); muatHalaman('artikel'); 
            });
        };
    });
}

// MODAL TAMBAH KATEGORI
function bukaModalTambahKategori() {
    document.getElementById('box-modal').style.display = 'block';
    document.getElementById('isi-modal').innerHTML = `
        <h3 style="margin-bottom:20px;">Tambah Kategori</h3>
        <form id="formSimpanKategori">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" placeholder="Misal: Tutorial" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" placeholder="Penjelasan singkat kategori..." style="width:100%; height:80px; padding:10px; border-radius:6px; border:1px solid #ddd;"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-batal" onclick="tutupModal()">Batal</button>
                <button type="submit" class="btn-simpan">Simpan Kategori</button>
            </div>
        </form>
    `;
    document.getElementById('formSimpanKategori').onsubmit = function(e) {
        e.preventDefault();
        fetch('simpan_kategori.php', { method: 'POST', body: new FormData(this) })
        .then(res => res.text()).then(msg => { alert(msg); tutupModal(); muatHalaman('kategori'); });
    };
}

// MODAL EDIT KATEGORI (Poin 3)
function editKategori(id) {
    fetch('ambil_satu_kategori.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        document.getElementById('box-modal').style.display = 'block';
        document.getElementById('isi-modal').innerHTML = `
            <h3 style="margin-bottom:20px;">Edit Kategori</h3>
            <form id="formUpdateKategori">
                <input type="hidden" name="id" value="${data.id}">
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" value="${data.nama_kategori}" required>
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" style="width:100%; height:80px; padding:10px; border-radius:6px; border:1px solid #ddd;">${data.keterangan}</textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-batal" onclick="tutupModal()">Batal</button>
                    <button type="submit" class="btn-simpan">Simpan Perubahan</button>
                </div>
            </form>
        `;
        document.getElementById('formUpdateKategori').onsubmit = function(e) {
            e.preventDefault();
            fetch('update_kategori.php', { method: 'POST', body: new FormData(this) })
            .then(res => res.text()).then(msg => { alert(msg); tutupModal(); muatHalaman('kategori'); });
        };
    });
}

// KONFIRMASI HAPUS KATEGORI (Poin 4)
function hapusKategori(id) {
    document.getElementById('box-modal').style.display = 'block';
    document.getElementById('isi-modal').innerHTML = `
        <div style="text-align: center; padding: 10px;">
            <div style="width: 50px; height: 50px; background: #ffebee; color: #ef5350; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 25px;">🗑</div>
            <h3>Hapus Kategori?</h3>
            <p style="color: #999; font-size: 13px; margin-bottom: 25px;">Kategori tidak bisa dihapus jika masih memiliki artikel.</p>
            <div style="display: flex; justify-content: center; gap: 10px;">
                <button onclick="tutupModal()" class="btn-batal">Batal</button>
                <button id="btn-hapus-kat" class="btn-simpan" style="background: #ef5350;">Ya, Hapus</button>
            </div>
        </div>
    `;
    document.getElementById('btn-hapus-kat').onclick = function() {
        fetch('hapus_kategori.php?id=' + id).then(res => res.text()).then(msg => { 
            alert(msg); tutupModal(); muatHalaman('kategori'); 
        });
    };
}

    // Start
    window.onload = () => muatHalaman('penulis');
</script>
</body>
</html>