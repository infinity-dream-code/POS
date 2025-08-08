<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#64748B'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <button onclick="goBack()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200 group">
                <svg class="w-5 h-5 mr-2 text-gray-600 group-hover:text-gray-800 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="text-gray-700 font-medium">Kembali</span>
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-white">Daftar Barang</h1>
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="text-blue-200 text-sm font-medium">List Barang</span>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-b">
                <div class="flex items-center justify-end">
                    <span class="text-sm text-gray-600">Total: <span class="font-semibold text-blue-600">{{ $totalBarang }}</span> item</span>
                </div>
            </div>

            @if($barang->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($barang as $item)
                        <tr class="hover:bg-blue-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $loop->iteration % 4 == 1 ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $loop->iteration % 4 == 2 ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $loop->iteration % 4 == 3 ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $loop->iteration % 4 == 0 ? 'bg-orange-100 text-orange-800' : '' }}">
                                    {{ $item->kode_barang }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->nama_barang }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-semibold">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($barang->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-gray-700 mb-2 sm:mb-0">
                        Menampilkan {{ $barang->firstItem() }} - {{ $barang->lastItem() }} dari {{ $barang->total() }} hasil
                    </div>
                    <div class="flex space-x-1">
                        {{-- Previous Page Link --}}
                        @if ($barang->onFirstPage())
                            <span class="px-3 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-not-allowed rounded-l-md">Previous</span>
                        @else
                            <a href="{{ $barang->previousPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">Previous</a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($barang->getUrlRange(1, $barang->lastPage()) as $page => $url)
                            @if ($page == $barang->currentPage())
                                <span class="px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($barang->hasMorePages())
                            <a href="{{ $barang->nextPageUrl() }}" class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">Next</a>
                        @else
                            <span class="px-3 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-not-allowed rounded-r-md">Next</span>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            @else
           
            <div class="px-6 py-12 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.463.898-6.057 2.369M12 3c-1.66 0-3 1.34-3 3v1c0 .552.448 1 1 1h4c.552 0 1-.448 1-1V6c0-1.66-1.34-3-3-3z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada data ditemukan</h3>
                <p class="text-gray-500">Belum ada data barang yang tersedia</p>
            </div>
            @endif

            <!-- Footer -->
            <div class="px-6 py-3 bg-gray-50 border-t text-center">
                <p class="text-xs text-gray-500">© 2024 Sistem Inventory Management</p>
            </div>
        </div>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }

        document.querySelector('button').addEventListener('click', function() {
            this.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memuat...';
            setTimeout(() => goBack(), 200);
        });
    </script>
</body>
</html>