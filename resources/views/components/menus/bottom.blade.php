<nav class="fixed bottom-0 left-0 right-0 bg-white shadow p-4 flex justify-between">
    <!-- Home Menu -->
    <a href="{{ route('index', ['username' => request()->route('username')]) }}/" class="flex flex-col items-center text-gray-700">
        <i class="fas fa-home text-xl"></i>
        <span class="text-sm">Beranda</span>
    </a>

    <!-- Cart Menu -->
    <a href="{{ route('cart', ['username' => request()->route('username')]) }}/" class="flex flex-col items-center text-gray-700">
        <i class="fas fa-shopping-cart text-xl"></i>
        <span class="text-sm">Keranjang</span>
    </a>

    <!-- Transactions Menu -->
    <a href="{{ route('payment', ['username' => request()->route('username')]) }}/" class="flex flex-col items-center text-gray-700">
        <i class="fas fa-exchange-alt text-xl"></i>
        <span class="text-sm">Transaksi</span>
    </a>

    <!-- Settings Menu -->
    <a href="#" class="flex flex-col items-center text-gray-700">
        <i class="fas fa-cog text-xl"></i>
        <span class="text-sm">Pengaturan</span>
    </a>
</nav>
