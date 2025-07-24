<?php
    include __DIR__ . '/../config/connection.php';

    header('Content-Type: application/json');

    try {
        $id_barang = $_POST['id_barang'] ?? null;
        $kode = $_POST['kode'] ?? null;
        $nama = $_POST['nama'] ?? null;
        $kategori = $_POST['kategori'] ?? null;
        $bahan_kode = $_POST['bahan_kode'] ?? [];

        if (!$id_barang || !$kode || !$nama) {
            throw new Exception('ID, kode, dan nama barang wajib diisi');
        }

        $pdo->beginTransaction();

        $stmt = $pdo->prepare("UPDATE tbl_barang SET kode = ?, nama = ?, kategori = ? WHERE kode = ?");
        $stmt->execute([$kode, $nama, $kategori, $id_barang]);
        
        $stmt = $pdo->prepare("DELETE FROM tbl_barang_bahan WHERE barang_kode = ?");
        $stmt->execute([$id_barang]);

        if (!empty($bahan_kode)) {
            $stmt = $pdo->prepare("INSERT INTO tbl_barang_bahan (barang_kode, bahan_kode) VALUES (?, ?)");
            foreach ($bahan_kode as $bahan) {
                $stmt->execute([$kode, $bahan]);
            }
        }

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Barang berhasil diupdate']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
?>