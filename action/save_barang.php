<?php
    include __DIR__ . '/../config/connection.php';

    header('Content-Type: application/json');

    try {
        $kode = $_POST['kode'] ?? null;
        $nama = $_POST['nama'] ?? null;
        $kategori = $_POST['kategori'] ?? null;
        $bahan_kode = $_POST['bahan_kode'] ?? [];

        if (!$kode || !$nama) {
            throw new Exception('Kode dan nama barang wajib diisi');
        }

        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO tbl_barang (kode, nama, kategori) VALUES (?, ?, ?)");
        $stmt->execute([$kode, $nama, $kategori]);

        if (!empty($bahan_kode)) {
            $stmt = $pdo->prepare("INSERT INTO tbl_barang_bahan (barang_kode, bahan_kode) VALUES (?, ?)");
            foreach ($bahan_kode as $bahan) {
                $stmt->execute([$kode, $bahan]);
            }
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Barang berhasil ditambahkan']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
?>