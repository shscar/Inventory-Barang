<?php
    include __DIR__ . '/../config/connection.php';

    header('Content-Type: application/json');

    try {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            throw new Exception('ID bahan baku wajib diisi');
        }

        $pdo->beginTransaction();

        $stmt = $pdo->prepare("DELETE FROM tbl_barang_bahan WHERE bahan_kode = ?");
        $stmt->execute([$id]);

        $stmt = $pdo->prepare("DELETE FROM tbl_bahan_baku WHERE kode = ?");
        $stmt->execute([$id]);

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Bahan baku berhasil dihapus']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
?>