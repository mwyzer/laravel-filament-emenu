<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang</title>

    <!-- Include CSS using Laravel asset helper -->
    <link rel="stylesheet" href="{{ asset('assets/cart.css') }}">
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" type="image/x-icon">
</head>

<body>
    <header class="cart-header">
        <a href="{{ route('index', $store->username ?? '') }}" id="back-button" class="back-button">&larr;</a>
        <h1>Keranjang</h1>
        <button id="refresh-button" class="refresh-button" aria-label="Refresh">&#x21bb;</button>
    </header>

    <main id="cart-container" class="cart-container">
        <!-- Items will be dynamically added here -->
    </main>

    <footer class="cart-footer">
        <div class="pay-amount">
            <span>Total Pembayaran</span>
            <span id="total-price">Rp 0</span>
        </div>
        <button id="order-button" class="order-button">Bayar</button>
    </footer>

    <!-- Modal for payment -->
    <div id="payment-modal" class="modal">
        <div class="modal-content">
            <span id="close-modal" class="close-button" aria-label="Close">&times;</span>
            <h2>Detail Pembayaran</h2>
            <form id="payment-form" action="{{ route('payment', $store->username ?? '') }}" method="POST">
                @csrf
                <input type="hidden" name="cart" id="cart-data">

                <label for="customer-name">Nama</label>
                <input type="text" id="customer-name" name="name" placeholder="Masukkan nama Anda" required>

                <label for="payment-method">Metode Pembayaran</label>
                <select id="payment-method" name="payment_method" required>
                    <option value="cash">Cash</option>
                    <option value="midtrans">Midtrans</option>
                </select>

                <button type="submit" class="submit-button">Bayar</button>
            </form>
        </div>
    </div>

    <!-- Include JavaScript using Laravel asset helper -->
    <script src="{{ asset('assets/cart.js') }}"></script>
</body>

</html>
