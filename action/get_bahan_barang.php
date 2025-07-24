<?php
    include __DIR__ . '/../config/connection.php';

    header('Content-Type: application/json');

    try {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            throw new Exception('ID barang wajib diisi');
        }

        $stmt = $pdo->prepare("
            SELECT bb.kode, bb.nama 
            FROM tbl_barang_bahan tbb 
            JOIN tbl_bahan_baku bb ON tbb.bahan_kode = bb.kode 
            WHERE tbb.barang_kode = ?
        ");
        $stmt->execute([$id]);
        $bahanList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'data' => $bahanList]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
?>