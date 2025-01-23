<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $store->name }}</title>

    <link rel="shortcut icon" href="https://via.placeholder.com/50" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="profile">
                <img src="{{ $store->logo ? asset('/storage/' . $store->logo) : 'https://via.placeholder.com/50' }}"
                    alt="Profile" class="profile-image">
                <span class="store-name">{{ $store->name ?? 'Nama Toko Tidak Ditemukan' }}</span>
            </div>
        </header>

        <form action="{{ route('index', $store->username) }}" class="search-bar">
            <input type="hidden" name="category" value="{{ request('category') }}">
            <input type="text" class="search-input" placeholder="Cari voucher..." value="{{ request('search') }}"
                name="search">
            <button class="search-button">
                <i class="fa-solid  fa-magnifying-glass"></i>
            </button>
        </form>

        <section class="menu-category">
            <div class="category-header">
                <h2 class="category-title">Kategori</h2>
            </div>
            <div class="category-tabs-wrapper">
                <div class="category-tabs">
                    <!-- Tab "All" -->
                    <a href="{{ url('/{{username}}') }}" class="category-tab {{ request('category') ? '' : 'active' }}">
                        <p>All</p>
                    </a>
        
                    <!-- Tab untuk kategori dinamis -->
                    @if ($categories->isNotEmpty())
                        @foreach ($categories as $category)
                            <a 
                                href="{{ url('/{username}?category=' . $category->id) }}" 
                                class="category-tab {{ request('category') == $category->id ? 'active' : '' }}">
                                <p>{{ $category->name }}</p>
                            </a>
                        @endforeach
                    @else
                        <p class="no-categories">Kategori tidak ditemukan.</p>
                    @endif
                </div>
            </div>
        </section>
        

        <section class="menu-items">
            @forelse ($products as $product)
                <div class="menu-card" data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}" data-description="{{ $product->description }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="menu-image">
                    <h3 class="menu-name">{{ $product->name }}</h3>
                    <p class="menu-price">Rp {{ number_format($product->price) }}</p>
                </div>
            @empty
                <div class="no-menu-wrapper">
                    <div id="lottie"></div>
                    <p class="no-menu">Ga ada barang yang cocok dengan pencarianmu.</p>
                </div>
            @endforelse
        </section>

        <a href="{{ route('cart', $store->username) }}" class="cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="cart-count">0</span>
        </a>

        <div id="product-modal" class="modal hidden">
            <div class="modal-content">
                <button class="close-modal">&times;</button>
                <div class="modal-body">
                    <img id="modal-image" src="" alt="Product Image" class="modal-image">
                    <h3 id="modal-name" class="modal-name"></h3>
                    <p id="modal-price" class="modal-price"></p>
                    <p id="modal-description" class="modal-description"></p>
                    <label for="modal-note">Note:</label>
                    <textarea id="modal-note" class="modal-note" placeholder="Write note..."></textarea>
                    <div class="quantity-control">
                        <button id="decrease-quantity" class="quantity-btn">-</button>
                        <span id="quantity" class="quantity">1</span>
                        <button id="increase-quantity" class="quantity-btn">+</button>
                    </div>
                    <button id="add-to-cart" class="add-to-cart-btn">Tambahkan ke Keranjang</button>
                </div>
            </div>
        </div>
    </div>

    <div id="cart-modal" class="modal hidden">
        <div class="modal-content">
            <button class="close-cart-modal">&times;</button>
            <h2>Daftar Keranjang</h2>
            <div id="cart-items" class="cart-items"></div>
            <div class="cart-summary">
                <p id="total-amount">Total: $0</p>
                <button id="checkout-btn" class="checkout-btn">Checkout</button>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.12.2/lottie.min.js"></script>
    <script>
        var animation = bodymovin.loadAnimation({
            container: document.getElementById('lottie'),
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '{{ asset('assets/lottie/not-found.json') }}'
        })

        const decreaseButton = document.getElementById('decrease-quantity');
        const increaseButton = document.getElementById('increase-quantity');
        const quantityDisplay = document.getElementById('quantity');

        let quantity = 1; // Initial quantity

        // Increase quantity
        increaseButton.addEventListener('click', () => {
            quantity++;
            quantityDisplay.textContent = quantity;
        });

        // Decrease quantity
        decreaseButton.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                quantityDisplay.textContent = quantity;
            }
        });
    </script>

</body>

</html>
