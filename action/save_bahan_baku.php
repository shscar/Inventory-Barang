<?php
    include __DIR__ . '/../config/connection.php';

    header('Content-Type: application/json');

    try {
        $kode = $_POST['kode'] ?? null;
        $nama = $_POST['nama'] ?? null;

        if (!$kode || !$nama) {
            throw new Exception('Kode dan nama bahan baku wajib diisi');
        }

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_bahan_baku WHERE kode = ?");
        $stmt->execute([$kode]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception('Kode bahan baku sudah digunakan');
        }

        $stmt = $pdo->prepare("INSERT INTO tbl_bahan_baku (kode, nama) VALUES (?, ?)");
        $stmt->execute([$kode, $nama]);

        echo json_encode(['success' => true, 'message' => 'Bahan baku berhasil ditambahkan']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
?>