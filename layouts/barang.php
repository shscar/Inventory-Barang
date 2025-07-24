<?php
    $barang = $pdo->query("SELECT * FROM tbl_barang")->fetchAll(PDO::FETCH_ASSOC);
    $bahanBaku = $pdo->query("SELECT * FROM tbl_bahan_baku")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Barang</title>
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
        
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');
            
            const alert = document.createElement('div');
            alert.className = `px-4 py-3 rounded-lg shadow-md text-sm font-medium text-white ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            alert.textContent = message;

            alertContainer.appendChild(alert);

            // Hapus otomatis setelah 3 detik
            setTimeout(() => {
                alert.remove();
            }, 3000);
        }
    </script>
</head>

<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <!-- alert -->
    <div id="alert-container" class="fixed top-4 right-4 z-50 space-y-2"></div>
    
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
                    <a href="/barang" class="flex items-center space-x-2 px-4 py-2 rounded-xl bg-primary-50 text-primary-600 font-medium">
                        <i class="fas fa-boxes"></i>
                        <span>Data Barang</span>
                    </a>
                    
                    <a href="/bahan-baku" class="flex items-center space-x-2 px-4 py-2 rounded-xl text-gray-700 hover:bg-gray-100 hover:text-primary-600 transition-all duration-200 group">
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
                    <h1 class="text-2xl font-bold text-gray-900">Barang</h1>
                    <p class="text-sm text-gray-600">Kelola data barang dan bahan baku</p>
                </div>
            </div>
            <button onclick="toggleForm('add')" class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Barang</span>
            </button>
        </div>

        <!-- Form Tambah/Edit -->
        <div id="formBarang" class="hidden mb-8 transform transition-all duration-300">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
                    <h2 id="formTitle" class="text-xl font-semibold text-white flex items-center space-x-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>Form Tambah Barang</span>
                    </h2>
                </div>
                
                <div class="p-6">
                    <form id="barangForm" class="space-y-6">
                        <input type="hidden" name="id_barang" id="id_barang">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700 flex items-center space-x-1">
                                    <i class="fas fa-barcode text-primary-500"></i>
                                    <span>Kode Barang</span>
                                </label>
                                <input type="text" name="kode" id="kode" placeholder="Masukkan kode barang" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700 flex items-center space-x-1">
                                    <i class="fas fa-tags text-primary-500"></i>
                                    <span>Kategori</span>
                                </label>
                                <input type="text" name="kategori" id="kategori" placeholder="Masukkan kategori" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center space-x-1">
                                <i class="fas fa-cube text-primary-500"></i>
                                <span>Nama Barang</span>
                            </label>
                            <input type="text" name="nama" id="nama" placeholder="Masukkan nama barang" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200" required>
                        </div>

                        <!-- Bahan Baku -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-800 flex items-center space-x-2">
                                    <i class="fas fa-layer-group text-primary-500"></i>
                                    <span>Bahan Baku Digunakan</span>
                                </h3>
                                <button type="button" onclick="openModal()" 
                                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                                    <i class="fas fa-plus"></i>
                                    <span>Tambah Bahan</span>
                                </button>
                            </div>
                            
                            <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                                <table class="min-w-full" id="bahanTable">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Bahan</th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr class="text-gray-500 text-center">
                                            <td colspan="3" class="px-6 py-8">
                                                <i class="fas fa-inbox text-4xl mb-2"></i>
                                                <p>Belum ada bahan baku dipilih</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" onclick="toggleForm('cancel')" 
                                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium transition-colors duration-200">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <i class="fas fa-save"></i>
                                <span id="submitButtonText">Simpan Barang</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Barang -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center space-x-2">
                    <i class="fas fa-list text-primary-500"></i>
                    <span>Daftar Barang</span>
                </h2>
            </div>
            
            <?php if (empty($barang)): ?>
                <div class="p-12 text-center">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-500 mb-2">Belum Ada Data</h3>
                    <p class="text-gray-400">Silakan tambah barang baru untuk memulai</p>
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
                                        <span>Nama Barang</span>
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
                            <?php foreach ($barang as $index => $item): ?>
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
                                            <button onclick='viewBarang(<?= json_encode($item) ?>)' 
                                                    class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-2 rounded-lg transition-colors duration-200">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button onclick='editBarang(<?= json_encode($item) ?>)' 
                                                    class="bg-blue-100 hover:bg-blue-200 text-blue-600 px-3 py-2 rounded-lg transition-colors duration-200">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="deleteBarang('<?= htmlspecialchars($item['kode']) ?>')" 
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

    <!-- Modal Pilih Bahan Baku -->
    <div id="modalBahan" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[80vh] flex flex-col shadow-2xl">
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-white flex items-center space-x-2">
                        <i class="fas fa-search"></i>
                        <span>Pilih Bahan Baku</span>
                    </h2>
                    <button onclick="closeModal()" class="text-white hover:text-gray-200 transition-colors duration-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-6 flex-1 overflow-hidden flex flex-col">
                <div class="mb-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" placeholder="Cari kode atau nama bahan baku..." 
                               oninput="searchBahan(this.value)" 
                               class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                    </div>
                </div>
                
                <div class="flex-1 overflow-auto border border-gray-200 rounded-xl">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Bahan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bahanList" class="bg-white divide-y divide-gray-200">
                            <?php foreach ($bahanBaku as $bahan): ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= htmlspecialchars($bahan['kode']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= htmlspecialchars($bahan['nama']) ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <button onclick="addToBahan('<?= htmlspecialchars($bahan['kode']) ?>', '<?= htmlspecialchars($bahan['nama']) ?>')" 
                                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-1 mx-auto">
                                            <i class="fas fa-plus"></i>
                                            <span>Pilih</span>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Barang -->
    <div id="modalView" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl w-full max-w-4xl max-h-[80vh] flex flex-col shadow-2xl">
            <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-white flex items-center space-x-2">
                        <i class="fas fa-eye"></i>
                        <span>Detail Barang</span>
                    </h2>
                    <button onclick="closeViewModal()" class="text-white hover:text-gray-200 transition-colors duration-200">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <div class="p-6 flex-1 overflow-auto">
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center space-x-1">
                                <i class="fas fa-barcode text-primary-500"></i>
                                <span>Kode Barang</span>
                            </label>
                            <p id="viewKode" class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200"></p>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700 flex items-center space-x-1">
                                <i class="fas fa-tags text-primary-500"></i>
                                <span>Kategori</span>
                            </label>
                            <p id="viewKategori" class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200"></p>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 flex items-center space-x-1">
                            <i class="fas fa-cube text-primary-500"></i>
                            <span>Nama Barang</span>
                        </label>
                        <p id="viewNama" class="text-sm text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200"></p>
                    </div>

                    <!-- Bahan Baku  -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center space-x-2 mb-4">
                            <i class="fas fa-layer-group text-primary-500"></i>
                            <span>Bahan Baku Digunakan</span>
                        </h3>
                        <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
                            <table class="min-w-full" id="viewBahanTable">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Bahan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="viewBahanList">
                                    <tr class="text-gray-500 text-center">
                                        <td colspan="2" class="px-6 py-8">
                                            <i class="fas fa-inbox text-4xl mb-2"></i>
                                            <p>Belum ada bahan baku dipilih</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

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
            const form = document.getElementById('formBarang');
            const formTitle = document.getElementById('formTitle');
            const submitButtonText = document.getElementById('submitButtonText');

            form.classList.toggle('hidden');
            formMode = mode;

            if (form.classList.contains('hidden')) {
                resetForm();
            } else {
                formTitle.innerHTML = mode === 'add' 
                    ? '<i class="fas fa-plus-circle"></i><span>Form Tambah Barang</span>'
                    : '<i class="fas fa-edit"></i><span>Form Edit Barang</span>';
                submitButtonText.textContent = mode === 'add' ? 'Simpan Barang' : 'Update Barang';
            }
        }

        function resetForm() {
            document.getElementById('barangForm').reset();
            document.getElementById('id_barang').value = '';
            clearBahanTable();
            formMode = 'add';
        }

        function openModal() {
            document.getElementById('modalBahan').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('modalBahan').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function clearBahanTable() {
            const tbody = document.querySelector('#bahanTable tbody');
            tbody.innerHTML = `
                <tr class="text-gray-500 text-center">
                    <td colspan="3" class="px-6 py-8">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>Belum ada bahan baku dipilih</p>
                    </td>
                </tr>
            `;
        }

        function addToBahan(kode, nama) {
            const tbody = document.querySelector('#bahanTable tbody');
            const emptyRow = tbody.querySelector('tr td[colspan="3"]');
            if (emptyRow) {
                emptyRow.parentElement.remove();
            }

            const existingRows = tbody.querySelectorAll('tr');
            for (let row of existingRows) {
                const existingKode = row.querySelector('input[name="bahan_kode[]"]');
                if (existingKode && existingKode.value === kode) {
                    alert('Bahan baku sudah dipilih!');
                    return;
                }
            }

            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 transition-colors duration-200';
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-900">${kode}</span>
                        <input type="hidden" name="bahan_kode[]" value="${kode}">
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${nama}</td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <button type="button" onclick="removeBahan(this)" 
                            class="bg-red-100 hover:bg-red-200 text-red-600 px-3 py-2 rounded-lg transition-colors duration-200">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
            closeModal();
        }

        function removeBahan(button) {
            const row = button.closest('tr');
            const tbody = row.parentElement;
            row.remove();
            if (tbody.children.length === 0) {
                clearBahanTable();
            }
        }

        function searchBahan(keyword) {
            const rows = document.querySelectorAll('#bahanList tr');
            rows.forEach(row => {
                const kode = row.children[0].textContent.toLowerCase();
                const nama = row.children[1].textContent.toLowerCase();
                row.style.display = kode.includes(keyword.toLowerCase()) || nama.includes(keyword.toLowerCase()) ? '' : 'none';
            });
        }

        function viewBarang(item) {
            document.getElementById('viewKode').textContent = item.kode;
            document.getElementById('viewNama').textContent = item.nama;
            document.getElementById('viewKategori').textContent = item.kategori || '-';

            // Fetch and populate related bahan baku
            fetch(`../action/get_bahan_barang.php?id=${encodeURIComponent(item.kode)}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('viewBahanList');
                    tbody.innerHTML = '';
                    if (data.success && data.data.length > 0) {
                        data.data.forEach(bahan => {
                            const row = document.createElement('tr');
                            row.className = 'hover:bg-gray-50 transition-colors duration-200';
                            row.innerHTML = `
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">${bahan.kode}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${bahan.nama}</td>
                            `;
                            tbody.appendChild(row);
                        });
                    } else {
                        tbody.innerHTML = `
                            <tr class="text-gray-500 text-center">
                                <td colspan="2" class="px-6 py-8">
                                    <i class="fas fa-inbox text-4xl mb-2"></i>
                                    <p>Belum ada bahan baku dipilih</p>
                                </td>
                            </tr>
                        `;
                    }
                    document.getElementById('modalView').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                })
                .catch(error => {
                    alert('Terjadi kesalahan saat memuat bahan baku.');
                    console.error(error);
                });
        }

        function closeViewModal() {
            document.getElementById('modalView').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function editBarang(item) {
            toggleForm('edit');
            document.getElementById('id_barang').value = item.kode;
            document.getElementById('kode').value = item.kode;
            document.getElementById('nama').value = item.nama;
            document.getElementById('kategori').value = item.kategori || '';

            // Fetch and populate related bahan baku
            fetch(`../action/get_bahan_barang.php?id=${encodeURIComponent(item.kode)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        clearBahanTable();
                        data.data.forEach(bahan => addToBahan(bahan.kode, bahan.nama));
                    } else {
                        alert('Gagal memuat bahan baku: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan saat memuat bahan baku.');
                    console.error(error);
                });
        }

        function deleteBarang(kode) {
            if (confirm('Apakah Anda yakin ingin menghapus barang ini?')) {
                fetch(`../action/delete_barang.php?id=${encodeURIComponent(kode)}`, {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        setTimeout(() => window.location.reload(), 1000); // kasih waktu animasi
                    } else {
                        showAlert('Error: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    showAlert('Terjadi kesalahan saat menghapus data.', 'error');
                    console.error(error);
                });
            }
        }


        document.getElementById('modalBahan').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.getElementById('modalView').addEventListener('click', function(e) {
            if (e.target === this) {
                closeViewModal();
            }
        });

        document.getElementById('barangForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const url = formMode === 'add' ? '../action/save_barang.php' : '../action/update_barang.php';
            
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