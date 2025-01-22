<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Sukses</title>

    <link rel="stylesheet" href="{{ asset('assets/success.css') }}">
</head>

<body>
    <div class="container">
        <div class="card">
            <h2>Transaksi Berhasil!</h2>
            <p>
                Tunjukkan <span style="font-weight: bold; color: #006400;">Kode Order</span> Anda kepada kasir untuk
                memproses pesanan, dan simpan <span style="font-weight: bold; color: #006400;">Kode Order</span> Anda untuk
                melihat status pesanan Anda.
            </p>

            <div class="transaction-code">
                <h3>Kode Transaksi</h3>
                <p>{{ $transaction->code }}</p>
            </div>

            <div class="order-details">
                <h3>Detail Pesanan</h3>
                <ul>
                    @foreach ($transaction->transactionDetails as $detail)
                    <li>
                        <span>{{ $detail->product->name }}</span>
                        <span>x{{ $detail->quantity }}</span>
                        <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>

                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="total-price">
                <p>Total Harga:</p>
                <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
            </div>

            <div class="back-button">
                <a href="{{ route('index', $store->username) }}">Kembali ke menu</a>
            </div>
        </div>
    </div>
</body>

</html>
