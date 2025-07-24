<?php
    $bahanBaku = $pdo->query("SELECT * FROM tbl_bahan_baku")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Bahan Baku - Modern Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <!-- header -->
    <div class="bg-white shadow-lg border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div>
                        <h1 class="text-3xl font-bold text-red-400">Infentory Barang</h1>
                    </div>
                </div>
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="/barang" class="flex items-center space-x-2 px-4 py-2 rounded-xl text-gray-700 hover:bg-gray-100 hover:text-primary-600 transition-all duration-200 group">
                        <i class="fas fa-boxes"></i>
                        <span>Data Barang</span>
                    </a>
                    
                    <a href="/bahan-baku" class="flex items-center space-x-2 px-4 py-2 rounded-xl bg-primary-50 text-primary-600 font-medium">
                        <i class="fas fa-tags group-hover:scale-110 transition-transform duration-200"></i>
                        <span class="font-medium">Bahan Baku</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Bahan Baku</h1>
                    <p class="text-sm text-gray-600">Kelola data bahan baku</p>
                </div>
            </div>
            <button onclick="toggleForm('add')" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Bahan Baku</span>
            </button>
        </div>

        <!-- Form Tambah/Edit -->
        <div id="formBahanBaku" class="hidden mb-8 transform transition-all duration-300">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                    <h2 id="formTitle" class="text-xl font-semibold text-white flex items-center space-x-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>Form Tambah Bahan Baku</span>
                    </h2>
                </div>
                
                <div class="p-6">
                    <form id="bahanBakuForm" class="space-y-6">
                        <input type="hidden" name="id_bahan" id="id_bahan">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700 flex items-center space-x-1">
                                    <i class="fas fa-barcode text-primary-500"></i>
                                    <span>Kode Bahan</span>
                                </label>
                                <input type="text" name="kode" id="kode" placeholder="Masukkan kode bahan" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700 flex items-center space-x-1">
                                    <i class="fas fa-cube text-primary-500"></i>
                                    <span>Nama Bahan</span>
                                </label>
                                <input type="text" name="nama" id="nama" placeholder="Masukkan nama bahan" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200" required>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="toggleForm('cancel')" 
                                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition-colors duration-200">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <i class="fas fa-save"></i>
                                <span id="submitButtonText">Simpan Bahan Baku</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Bahan Baku -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center space-x-2">
                    <i class="fas fa-list text-primary-500"></i>
                    <span>Daftar Bahan Baku</span>
                </h2>
            </div>
            
            <?php if (empty($bahanBaku)): ?>
                <div class="p-12 text-center">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-500 mb-2">Belum Ada Data</h3>
                    <p class="text-gray-400">Silakan tambah bahan baku baru untuk memulai</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-barcode"></i>
                                        <span>Kode</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-cube"></i>
                                        <span>Nama Bahan</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="flex items-center justify-center space-x-1">
                                        <i class="fas fa-cog"></i>
                                        <span>Aksi</span>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($bahanBaku as $index => $item): ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-900"><?= htmlspecialchars($item['kode']) ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($item['nama']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex justify-center space-x-2">
                                            <button onclick='viewBahan(<?= json_encode($item) ?>)' 
                                                    class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2 rounded-lg transition-colors duration-200">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick='editBahan(<?= json_encode($item) ?>)' 
                                                    class="bg-blue-100 hover:bg-blue-200 text-blue-600 px-3 py-2 rounded-lg transition-colors duration-200">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="deleteBahan('<?= htmlspecialchars($item['kode']) ?>')" 
                                                    class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-2 rounded-lg transition-colors duration-200">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal View Bahan Baku -->
    <div id="modalView" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl w-full max-w-md max-h-[80vh] flex flex-col shadow-2xl">
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-white flex items-center space-x-2">
                        <i class="fas fa-eye"></i>
                        <span>Detail Bahan Baku</span>
                    </h2>
                    <button onclick="closeViewModal()" class="text-white hover:text-gray-200 transition-colors duration-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-6 flex-1 overflow-auto">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center space-x-1">
                            <i class="fas fa-barcode text-primary-500"></i>
                            <span>Kode Bahan</span>
                        </label>
                        <p id="viewKode" class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200"></p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center space-x-1">
                            <i class="fas fa-cube text-primary-500"></i>
                            <span>Nama Bahan</span>
                        </label>
                        <p id="viewNama" class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200"></p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center space-x-1">
                            <i class="fas fa-clock text-primary-500"></i>
                            <span>Tanggal Dibuat</span>
                        </label>
                        <p id="viewCreatedAt" class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200"></p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center space-x-1">
                            <i class="fas fa-clock text-primary-500"></i>
                            <span>Tanggal Diperbarui</span>
                        </label>
                        <p id="viewUpdatedAt" class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200"></p>
                    </div>
                    <!-- Close Button -->
                    <div class="flex justify-end pt-4">
                        <button onclick="closeViewModal()" 
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition-colors duration-200">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let formMode = 'add';

        function toggleForm(mode = 'add') {
            const form = document.getElementById('formBahanBaku');
            const formTitle = document.getElementById('formTitle');
            const submitButtonText = document.getElementById('submitButtonText');

            form.classList.toggle('hidden');
            formMode = mode;

            if (form.classList.contains('hidden')) {
                resetForm();
            } else {
                formTitle.innerHTML = mode === 'add' 
                    ? '<i class="fas fa-plus-circle"></i><span>Form Tambah Bahan Baku</span>'
                    : '<i class="fas fa-edit"></i><span>Form Edit Bahan Baku</span>';
                submitButtonText.textContent = mode === 'add' ? 'Simpan Bahan Baku' : 'Update Bahan Baku';
            }
        }

        function resetForm() {
            document.getElementById('bahanBakuForm').reset();
            document.getElementById('id_bahan').value = '';
            formMode = 'add';
        }

        function viewBahan(item) {
            document.getElementById('viewKode').textContent = item.kode;
            document.getElementById('viewNama').textContent = item.nama;
            document.getElementById('viewCreatedAt').textContent = item.created_at || '-';
            document.getElementById('viewUpdatedAt').textContent = item.updated_at || '-';
            document.getElementById('modalView').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeViewModal() {
            document.getElementById('modalView').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function editBahan(item) {
            toggleForm('edit');
            document.getElementById('id_bahan').value = item.kode;
            document.getElementById('kode').value = item.kode;
            document.getElementById('nama').value = item.nama;
        }

        function deleteBahan(kode) {
            if (confirm('Apakah Anda yakin ingin menghapus bahan baku ini?')) {
                fetch(`../action/delete_bahan_baku.php?id=${encodeURIComponent(kode)}`, {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan saat menghapus data.');
                    console.error(error);
                });
            }
        }

        document.getElementById('modalView').addEventListener('click', function(e) {
            if (e.target === this) {
                closeViewModal();
            }
        });

        document.getElementById('bahanBakuForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const url = formMode === 'add' ? '../action/save_bahan_baku.php' : '../action/update_bahan_baku.php';
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Terjadi kesalahan saat menyimpan data.');
                console.error(error);
            });
        });
    </script>
</body>
</html>