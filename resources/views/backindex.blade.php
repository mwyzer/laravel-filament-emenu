<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $store->name }}</title>

    <link rel="shortcut icon" href="{{ asset('storage/' . $store->logo) }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="profile">
                <img src="{{ asset('storage/' . $store->logo) }}" alt="Profile" class="profile-image">
                <span class="store-name">{{ $store->name }}</span>
            </div>
        </header>

        <form action="{{ route('index', $store->username) }}" class="search-bar">
            <input type="hidden" name="category" value="{{ request('category') }}">
            <input type="text" class="search-input" placeholder="Cari produk..." value="{{ request('search') }}"
                name="search">
            <button class="search-button">
                <i class="fa-solid  fa-magnifying-glass"></i>
            </button>
        </form>

        <section class="menu-category">
            <div class="category-header">
                <h2 class="category-title">Kategori</h2>
            </div>
            <div class="category-tabs">
                <!-- "All" category tab -->
                <a href="{{ route('index', ['username' => $store->username, 'search' => request('search')]) }}"
                    class="category-tab {{ request('category') === null ? 'active' : '' }}">
                    <p>All</p>
                </a>

                <!-- Dynamic category tabs -->
                @foreach ($categories as $category)
                    <a class="category-tab {{ request('category') === $category->slug ? 'active' : '' }}"
                        href="{{ route('index', ['username' => $store->username, 'category' => $category->slug, 'search' => request('search')]) }}">
                        <p>{{ $category->name }}</p>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="menu-items">
            @forelse ($products as $product)
                <div class="menu-card" data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}" data-description="{{ $product->description }}"
                    data-image="{{ $product->image }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        class="menu-image">
                    <h3 class="menu-name">{{ $product->name }}</h3>
                    <p class="menu-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
            @empty
                <div class="no-menu-wrapper">
                    <div id="lottie"></div>
                    <p class="no-menu">Ga ada menu yang cocok dengan pencarianmu.</p>
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
                    <label for="modal-note">Masukan Nomor WhatsApp</label>
                    <textarea id="modal-note" class="modal-note" placeholder="Masukan nomor whatsapp di sini..."></textarea>
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


        //validation form in modal-content
        document.getElementById('add-to-cart').addEventListener('click', function () {
        const whatsappField = document.getElementById('modal-note');
        const quantityField = document.getElementById('quantity');
        
        const whatsappValue = whatsappField.value.trim();
        const quantityValue = parseInt(quantityField.textContent, 10);

        let validationErrors = [];

        // Validate WhatsApp Number
        const whatsappRegex = /^[+]?[\d\s-]{10,}$/; // Matches WhatsApp-like numbers
        if (!whatsappValue || !whatsappRegex.test(whatsappValue)) {
            validationErrors.push("Nomor WhatsApp harus diisi dengan format yang valid (minimal 10 karakter).");
        }

        // Validate Quantity
        if (isNaN(quantityValue) || quantityValue < 1) {
            validationErrors.push("Jumlah produk harus minimal 1.");
        }

        // Show errors or proceed to add the product to the cart
        if (validationErrors.length > 0) {
            alert(validationErrors.join("\n")); // Show errors as an alert
            return; // Prevent adding to cart
        }

        // If validation passes, add the product to the cart
        alert('Produk berhasil ditambahkan ke keranjang!');

        // You can add further logic here to handle the actual "add to cart" functionality
    });
    </script>


</body>

</html>
