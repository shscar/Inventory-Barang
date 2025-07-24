<?php
    include __DIR__ . '/../config/connection.php';

    header('Content-Type: application/json');

    try {
        $id_bahan = $_POST['id_bahan'] ?? null;
        $kode = $_POST['kode'] ?? null;
        $nama = $_POST['nama'] ?? null;

        if (!$id_bahan || !$kode || !$nama) {
            throw new Exception('ID, kode, dan nama bahan baku wajib diisi');
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_bahan_baku WHERE kode = ? AND kode != ?");
        $stmt->execute([$kode, $id_bahan]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception('Kode bahan baku sudah digunakan');
        }
        
        $stmt = $pdo->prepare("UPDATE tbl_bahan_baku SET kode = ?, nama = ? WHERE kode = ?");
        $stmt->execute([$kode, $nama, $id_bahan]);

        echo json_encode(['success' => true, 'message' => 'Bahan baku berhasil diupdate']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
?>