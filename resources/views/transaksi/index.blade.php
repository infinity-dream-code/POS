<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body { 
            font-family: 'Inter', sans-serif; 
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .table-row {
            transition: all 0.2s ease;
        }
        
        .table-row:hover {
            background: linear-gradient(90deg, #f8fafc 0%, #e2e8f0 100%);
            transform: scale(1.01);
        }
        
        .modal-enter {
            animation: modalEnter 0.3s ease-out;
        }
        
        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-50px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
        }
        
        .glass-effect {
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .stats-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header dengan gradient -->
    <div class="gradient-bg py-8 mb-8">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2">Daftar Transaksi</h1>
                   
                </div>
                <a href="/" class="btn-primary text-white font-semibold px-6 py-3 rounded-xl shadow-lg hover:shadow-2xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>Kembali ke Kasir</span>
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 pb-8">
       

        <!-- Tabel Transaksi -->
        <div class="glass-effect shadow-2xl rounded-2xl overflow-hidden card-hover">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center space-x-2">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Riwayat Transaksi</span>
                    </h2>
                  
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-50 to-purple-50 text-sm font-semibold text-gray-700">
                            <th class="px-6 py-4 text-left border-b border-gray-200">
                                <div class="flex items-center space-x-2">
                                    <span>#</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="px-6 py-4 text-left border-b border-gray-200">📅 Tanggal</th>
                            <th class="px-6 py-4 text-left border-b border-gray-200">📦 Total Barang</th>
                            <th class="px-6 py-4 text-left border-b border-gray-200">💰 Total Harga</th>
                            <th class="px-6 py-4 text-center border-b border-gray-200">⚡ Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($transaksi as $trx)
                        <tr class="table-row">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ $trx->id }}
                                    </div>
                                </div>
                            </td>
                           <td class="px-6 py-4 whitespace-nowrap">
    <div class="text-sm font-medium text-gray-900">{{ $trx->tanggal->format('Y-m-d') }}</div>
</td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-lg">
                                        {{ $trx->total_barang }} items
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-lg font-bold text-green-600">
                                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button onclick="openModal({{ $trx->id }})" 
                                        class="btn-success text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center space-x-2 mx-auto shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>Detail</span>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <div class="mt-6">
    {{ $transaksi->links() }}
</div>

                </table>

            </div>
            
        </div>
    </div>
    

    <!-- Modal Detail -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden modal-enter mx-4">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-white flex items-center space-x-2">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Detail Transaksi</span>
                    </h2>
                    <button onclick="closeModal()" 
                            class="text-white hover:text-red-300 text-2xl font-bold w-10 h-10 rounded-full hover:bg-white hover:bg-opacity-20 transition-all">
                        ×
                    </button>
                </div>
            </div>
            
            <div id="modalBody" class="p-6 max-h-[70vh] overflow-y-auto">
                <div class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                    <p class="text-gray-500 text-lg ml-4">Memuat detail transaksi...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(transaksiId) {
            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            const modalBody = document.getElementById('modalBody');
            modalBody.innerHTML = `
                <div class="flex items-center justify-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                    <p class="text-gray-500 text-lg ml-4">Memuat detail transaksi...</p>
                </div>
            `;

            axios.get(`/transaksi/${transaksiId}/detail`)
                .then(response => {
                    const details = response.data;
                    let totalAmount = 0;
                    
                    let html = `
                        <div class="mb-6">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 mb-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 mb-1">ID Transaksi</p>
                                        <p class="text-xl font-bold text-indigo-600">#${transaksiId}</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 mb-1">Total Item</p>
                                        <p class="text-xl font-bold text-blue-600">${details.length} items</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600 mb-1">Status</p>
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Selesai</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full bg-white rounded-xl overflow-hidden shadow-lg">
                                <thead>
                                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 text-sm font-semibold text-gray-700">
                                        <th class="px-6 py-4 text-left">📦 Nama Barang</th>
                                        <th class="px-6 py-4 text-center">💰 Harga</th>
                                        <th class="px-6 py-4 text-center">🔢 Jumlah</th>
                                        <th class="px-6 py-4 text-right">💳 Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                    `;

                    details.forEach((item, index) => {
                        const subtotal = item.harga * item.jumlah;
                        totalAmount += subtotal;
                        
                        html += `
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="bg-indigo-100 text-indigo-800 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold">
                                            ${index + 1}
                                        </div>
                                        <span class="font-medium text-gray-800">${item.barang.nama_barang}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-gray-600 font-medium">Rp ${item.harga.toLocaleString('id-ID')}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">${item.jumlah}x</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-lg font-bold text-green-600">Rp ${subtotal.toLocaleString('id-ID')}</span>
                                </td>
                            </tr>
                        `;
                    });

                    html += `
                            </tbody>
                            <tfoot class="bg-gradient-to-r from-green-50 to-emerald-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right font-bold text-lg text-gray-800">
                                         Total Keseluruhan:
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-2xl font-bold text-green-600">Rp ${totalAmount.toLocaleString('id-ID')}</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    `;
                    
                    modalBody.innerHTML = html;
                })
                .catch(error => {
                    modalBody.innerHTML = `
                        <div class="text-center py-12">
                            <div class="mb-4">
                                <svg class="w-16 h-16 text-red-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-red-600 mb-2">Gagal Memuat Data</h3>
                            <p class="text-gray-600">Terjadi kesalahan saat memuat detail transaksi. Silakan coba lagi.</p>
                            <button onclick="openModal(${transaksiId})" class="mt-4 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors">
                                Coba Lagi
                            </button>
                        </div>
                    `;
                });
        }

        function closeModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('detailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>