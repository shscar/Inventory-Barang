<?php
require_once __DIR__ . '/../config/connection.php';

$isEdit = isset($_GET['edit']);
$barang = ['kode' => '', 'nama' => '', 'kategori' => ''];
$bahanBakus = [];

if ($isEdit) {
    $kodeBarang = $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM barang WHERE kode = ?");
    $stmt->execute([$kodeBarang]);
    $barang = $stmt->fetch();

    // Ambil bahan baku yang terkait
    $stmtBahan = $pdo->prepare("SELECT * FROM bahan_baku WHERE barang_kode = ?");
    $stmtBahan->execute([$kodeBarang]);
    $bahanBakus = $stmtBahan->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];

    if ($isEdit) {
        $stmt = $pdo->prepare("UPDATE barang SET nama = ?, kategori = ? WHERE kode = ?");
        $stmt->execute([$nama, $kategori, $kode]);
        // hapus bahan baku lama
        $pdo->prepare("DELETE FROM bahan_baku WHERE barang_kode = ?")->execute([$kode]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO barang (kode, nama, kategori) VALUES (?, ?, ?)");
        $stmt->execute([$kode, $nama, $kategori]);
    }

    foreach ($_POST['bahan_baku'] as $bahan) {
        if (empty($bahan['kode']) || empty($bahan['nama']))
            continue;
        $stmt = $pdo->prepare("INSERT INTO bahan_baku (kode, nama, barang_kode) VALUES (?, ?, ?)");
        $stmt->execute([$bahan['kode'], $bahan['nama'], $kode]);
    }

    header("Location: barang.php");
    exit;
}
?>

<h3><?= $isEdit ? 'Edit Barang' : 'Tambah Barang' ?></h3>
<form method="POST">
    <label>Kode Barang:</label><br>
    <input name="kode" value="<?= $barang['kode'] ?>" <?= $isEdit ? 'readonly' : '' ?>><br>

    <label>Nama Barang:</label><br>
    <input name="nama" value="<?= $barang['nama'] ?>"><br>

    <label>Kategori:</label><br>
    <input name="kategori" value="<?= $barang['kategori'] ?>"><br><br>

    <label>Bahan Baku:</label>
    <table id="bahanTable" border="1">
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bahanBakus as $bahan): ?>
                <tr>
                    <td><input name="bahan_baku[][kode]" value="<?= $bahan['kode'] ?>"></td>
                    <td><input name="bahan_baku[][nama]" value="<?= $bahan['nama'] ?>"></td>
                    <td><button type="button" onclick="this.parentElement.parentElement.remove()">🗑</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="button" onclick="addBahan()">➕</button><br><br>

    <button type="submit">Simpan</button>
</form>

<script>
    function addBahan() {
        const table = document.getElementById('bahanTable').getElementsByTagName('tbody')[0];
        const row = document.createElement('tr');
        row.innerHTML = `
        <td><input name="bahan_baku[][kode]"></td>
        <td><input name="bahan_baku[][nama]"></td>
        <td><button type="button" onclick="this.parentElement.parentElement.remove()">🗑</button></td>
    `;
        table.appendChild(row);
    }
</script>

<a href="?">← Kembali</a>