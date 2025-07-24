<?php
    include __DIR__ . '/../config/connection.php';

    header('Content-Type: application/json');

    try {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            throw new Exception('ID barang wajib diisi');
        }

        $pdo->beginTransaction();

        $stmt = $pdo->prepare("DELETE FROM tbl_barang_bahan WHERE barang_kode = ?");
        $stmt->execute([$id]);

        $stmt = $pdo->prepare("DELETE FROM tbl_barang WHERE kode = ?");
        $stmt->execute([$id]);

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Barang berhasil dihapus']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
?>