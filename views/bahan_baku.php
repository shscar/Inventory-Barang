<?php
require_once __DIR__ . '/../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO bahan_baku (nama, stok, harga, supplier, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->execute([$_POST['nama'], $_POST['stok'], $_POST['harga'], $_POST['supplier']]);
}

$bahanBakus = $pdo->query("SELECT * FROM bahan_baku")->fetchAll();
?>

<h2>Data Bahan Baku</h2>
<form method="POST">
    Nama: <input name="nama"><br>
    Stok: <input name="stok"><br>
    Harga: <input name="harga"><br>
    Supplier: <input name="supplier"><br>
    <button type="submit">Tambah Bahan Baku</button>
</form>

<table border="1">
    <tr>
        <th>Nama</th>
        <th>Stok</th>
        <th>Harga</th>
        <th>Supplier</th>
    </tr>
    <?php foreach ($bahanBakus as $bahan): ?>
        <tr>
            <td><?= $bahan['nama'] ?></td>
            <td><?= $bahan['stok'] ?></td>
            <td><?= $bahan['harga'] ?></td>
            <td><?= $bahan['supplier'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="index.php">← Kembali</a>