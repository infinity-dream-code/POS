<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kasir Modern</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">
                <i class="fas fa-cash-register mr-3 text-blue-600"></i>
                POINT OF SALES
            </h1>

            <div class="flex justify-end space-x-2 mb-4">
    <a href="{{ route('barang.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
        Daftar Barang
    </a>
    <a href="{{ route('transaksi.index') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
        Daftar Transaksi
    </a>
</div>

            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
              
                <div class="lg:col-span-2">
                    <h4 class="text-xl font-semibold mb-4 text-gray-800">
                        <i class="fas fa-box mr-2 text-gray-600"></i>
                        Daftar Produk
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($barang as $item)
                        <div class="bg-white rounded-lg shadow-md border hover:shadow-lg">
                            <div class="bg-gray-100 h-48 rounded-t-lg flex items-center justify-center">
                                <i class="fas fa-box text-4xl text-gray-400"></i>
                            </div>
                            <div class="p-4">
                                <div class="text-sm text-gray-500 mb-2">{{ $item->kode_barang }}</div>
                                <h5 class="font-semibold text-lg mb-2 text-gray-800">{{ $item->nama_barang }}</h5>
                                <p class="text-green-600 font-bold text-lg mb-3">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md" 
                                        onclick="addToCart({{ $item->id }}, '{{ $item->kode_barang }}', '{{ $item->nama_barang }}', {{ $item->harga }})">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Keranjang -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-4 sticky top-6">
                        <h4 class="text-xl font-semibold mb-4 text-gray-800">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Keranjang Belanja
                            <span class="bg-blue-500 text-white text-sm px-2 py-1 rounded-full ml-2" id="cartCount">0</span>
                        </h4>
                        
                        <div id="cartItems" class="mb-4">
                            <div class="text-center py-12 text-gray-400">
                                <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                                <p class="text-lg">Keranjang masih kosong</p>
                                <p class="text-sm">Pilih produk untuk memulai belanja</p>
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 rounded-lg p-4" id="totalSection" style="display: none;">
                            <div class="flex justify-between mb-2">
                                <span>Total Item:</span>
                                <span id="totalItems" class="font-semibold">0</span>
                            </div>
                            <div class="flex justify-between mb-4 text-lg font-bold">
                                <span>Total Harga:</span>
                                <span id="totalPrice" class="text-green-600">Rp 0</span>
                            </div>
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-md font-semibold" 
                                    onclick="checkout()">
                                <i class="fas fa-credit-card mr-2"></i>
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <form id="checkoutForm" method="POST" action="{{ route('kasir.store') }}" style="display: none;">
        @csrf
        <input type="hidden" name="cart_data" id="cartData">
    </form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonText: 'OK'
    });

    
    sessionStorage.removeItem('cart');
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        title: 'Gagal!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'OK'
    });
</script>
@endif

    <script>
        let cart = JSON.parse(sessionStorage.getItem('cart')) || {};

        document.addEventListener('DOMContentLoaded', function() {
            updateCartDisplay();
        });

        function addToCart(id, kode_barang, nama_barang, harga) {
            if (cart[id]) {
                cart[id].quantity += 1;
            } else {
                cart[id] = {
                    id: id,
                    kode_barang: kode_barang,
                    nama_barang: nama_barang,
                    harga: harga,
                    quantity: 1
                };
            }

            saveCart();
            updateCartDisplay();
        }

        function updateQuantity(productId, change) {
            if (!cart[productId]) return;

            cart[productId].quantity += change;

            if (cart[productId].quantity <= 0) {
                delete cart[productId];
            }

            saveCart();
            updateCartDisplay();
        }

        function removeFromCart(productId) {
            delete cart[productId];
            saveCart();
            updateCartDisplay();
        }

        function saveCart() {
            sessionStorage.setItem('cart', JSON.stringify(cart));
        }

        function updateCartDisplay() {
            const cartItems = document.getElementById('cartItems');
            const cartCount = document.getElementById('cartCount');
            const totalSection = document.getElementById('totalSection');
            const totalItems = document.getElementById('totalItems');
            const totalPrice = document.getElementById('totalPrice');

            const cartArray = Object.values(cart);
            const itemCount = cartArray.reduce((sum, item) => sum + item.quantity, 0);
            const totalAmount = cartArray.reduce((sum, item) => sum + (item.harga * item.quantity), 0);

            cartCount.textContent = itemCount;
            totalItems.textContent = itemCount;
            totalPrice.textContent = 'Rp ' + totalAmount.toLocaleString('id-ID');

            if (cartArray.length === 0) {
                cartItems.innerHTML = `
                    <div class="text-center py-12 text-gray-400">
                        <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                        <p class="text-lg">Keranjang masih kosong</p>
                        <p class="text-sm">Pilih produk untuk memulai belanja</p>
                    </div>
                `;
                totalSection.style.display = 'none';
            } else {
                let cartHTML = '';
                cartArray.forEach(item => {
                    cartHTML += `
                        <div class="border-b border-gray-200 py-4">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex-1">
                                    <div class="text-sm text-gray-500">${item.kode_barang}</div>
                                    <h6 class="font-semibold text-gray-800">${item.nama_barang}</h6>
                                    <div class="text-green-600 font-semibold">Rp ${item.harga.toLocaleString('id-ID')}</div>
                                </div>
                                <button class="text-red-500 hover:text-red-700 w-6 h-6 flex items-center justify-center rounded-full border border-red-300 hover:border-red-500" 
                                        onclick="removeFromCart(${item.id})">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-2">
                                    <button class="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded" 
                                            onclick="updateQuantity(${item.id}, -1)">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <span class="px-3 font-semibold">${item.quantity}</span>
                                    <button class="w-8 h-8 flex items-center justify-center bg-gray-100 hover:bg-gray-200 rounded" 
                                            onclick="updateQuantity(${item.id}, 1)">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                                <div class="font-bold text-gray-800">Rp ${(item.harga * item.quantity).toLocaleString('id-ID')}</div>
                            </div>
                        </div>
                    `;
                });
                cartItems.innerHTML = cartHTML;
                totalSection.style.display = 'block';
            }
        }

        function checkout() {
            if (Object.keys(cart).length === 0) {
                alert('Keranjang masih kosong!');
                return;
            }

            const cartData = Object.values(cart).map(item => ({
                id_barang: item.id,
                jumlah: item.quantity,
                harga: item.harga,
                total: item.harga * item.quantity
            }));

            document.getElementById('cartData').value = JSON.stringify(cartData);
            
            const totalAmount = Object.values(cart).reduce((sum, item) => sum + (item.harga * item.quantity), 0);
            const totalItems = Object.values(cart).reduce((sum, item) => sum + item.quantity, 0);
            
            if (confirm(`Konfirmasi pembelian:\nTotal Item: ${totalItems}\nTotal Harga: Rp ${totalAmount.toLocaleString('id-ID')}\n\nLanjutkan transaksi?`)) {
                document.getElementById('checkoutForm').submit();
            }
        }

        function clearCart() {
            cart = {};
            saveCart();
            updateCartDisplay();
        }
    </script>
</body>
</html>