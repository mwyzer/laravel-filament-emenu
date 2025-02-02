<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>WiFi Voucher</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Header Section -->
    <div class="bg-blue-500 text-white p-4 rounded-b-lg relative">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="https://via.placeholder.com/50" alt="Profile" class="rounded-full w-12 h-12">
                <div>
                    <h1 class="text-lg font-bold">Davriel Wija Grazio</h1>
                    <p class="text-sm">Member <span class="font-semibold">Silver</span></p>
                </div>
            </div>
            <div class="absolute top-4 right-4">
                <button class="relative">
                    <span class="text-xl"><i class="fas fa-bell"></i></span>
                    <span class="absolute top-0 right-0 bg-red-500 text-xs text-white rounded-full px-1">1</span>
                </button>
            </div>
        </div>
        <div class="text-center mt-4">
            <h2 class="text-lg">Saldo Anda</h2>
            <h1 class="text-2xl font-bold">Rp 350.000</h1>
            <button class="bg-white text-blue-500 px-4 py-1 rounded-lg mt-2">Top Up</button>
            <p class="mt-2">20 Points</p>
        </div>
    </div>

    <!-- Navigation Section -->
    <div class="grid grid-cols-4 text-center gap-2 my-4 px-4">
        <button class="bg-white p-3 rounded-lg shadow">Voucher WiFi</button>
        <button class="bg-white p-3 rounded-lg shadow">Tukar Poin</button>
        <button class="bg-white p-3 rounded-lg shadow">Mitra Wilzio</button>
        <button class="bg-white p-3 rounded-lg shadow">Referral</button>
    </div>

    <!-- Banner Section -->
    <div class="px-4">
        <div class="overflow-hidden rounded-lg relative">
            <div class="flex transition-transform ease-in-out duration-300">
                <img src="https://via.placeholder.com/600x200" alt="Banner 1" class="w-full">
                <img src="https://via.placeholder.com/600x200" alt="Banner 2" class="w-full">
            </div>
        </div>
    </div>

    <!-- Flash Sale Section -->
    <div class="px-4 mt-6">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-lg">FLASH SALE</h2>
            <p class="text-red-500 font-semibold">00:30:59</p>
        </div>
        <div class="flex overflow-x-auto space-x-4 mt-4">
            <div class="bg-white rounded-lg shadow p-4 w-60 flex-none">
                <h3 class="font-bold">Unlimited</h3>
                <p>30 Hari</p>
                <p class="text-red-500 text-lg">Rp 200.000</p>
                <button class="bg-blue-500 text-white px-4 py-1 rounded-lg mt-2">Beli Sekarang</button>
            </div>
            <div class="bg-white rounded-lg shadow p-4 w-60 flex-none">
                <h3 class="font-bold">25 GB</h3>
                <p>30 Hari</p>
                <p class="text-red-500 text-lg">Rp 150.000</p>
                <button class="bg-blue-500 text-white px-4 py-1 rounded-lg mt-2">Beli Sekarang</button>
            </div>
        </div>
    </div>

    <!-- Voucher Section -->
    <div class="px-4 mt-6">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-lg">Voucher WiFi</h2>
            <button class="text-blue-500 text-sm">Lihat Semua</button>
        </div>
        <div class="flex overflow-x-auto space-x-4 mt-4">
            <div class="bg-white rounded-lg shadow p-4 w-60 flex-none">
                <h3 class="font-bold">20 GB</h3>
                <p>25 Hari</p>
                <p class="text-red-500 text-lg">Rp 20.000</p>
                <button class="bg-blue-500 text-white px-4 py-1 rounded-lg mt-2">Beli Sekarang</button>
            </div>
            <div class="bg-white rounded-lg shadow p-4 w-60 flex-none">
                <h3 class="font-bold">30 GB</h3>
                <p>30 Hari</p>
                <p class="text-red-500 text-lg">Rp 50.000</p>
                <button class="bg-blue-500 text-white px-4 py-1 rounded-lg mt-2">Beli Sekarang</button>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <div class="fixed bottom-0 w-full bg-white border-t shadow-md">
        <div class="flex justify-around py-2">
            <button class="flex flex-col items-center text-blue-500">
                <i class="fas fa-home text-lg"></i>
                <span class="text-xs">Beranda</span>
            </button>
            <button class="flex flex-col items-center">
                <i class="fas fa-shopping-cart text-lg"></i>
                <span class="text-xs">Keranjang</span>
            </button>
            <button class="flex flex-col items-center">
                <i class="fas fa-file-invoice text-lg"></i>
                <span class="text-xs">Transaksi</span>
            </button>
            <button class="flex flex-col items-center">
                <i class="fas fa-cog text-lg"></i>
                <span class="text-xs">Pengaturan</span>
            </button>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
