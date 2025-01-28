<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4">

        <!-- Header Section -->
        <header class="flex items-center justify-between py-4">
            <div class="flex items-center space-x-4">
                <img src="profile.jpg" alt="Profile" class="w-12 h-12 rounded-full">
                <div>
                    <h1 class="text-lg font-semibold">John Doe</h1>
                    <p class="text-sm text-gray-600">Member Status: <span class="text-green-500">Premium</span></p>
                </div>
            </div>
            <div class="flex space-x-4">
                <button class="relative">
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-500 rounded-full">3</span>
                    <i class="fas fa-bell text-gray-700 text-xl"></i>
                </button>
            </div>
        </header>

        <!-- Balance and Actions Section -->
        <section class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-sm text-gray-600">Balance</h2>
                    <p class="text-2xl font-semibold text-gray-800">Rp 500,000</p>
                </div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">Top-Up</button>
            </div>
        </section>

        <!-- Menu Section -->
        <section class="grid grid-cols-4 gap-4 text-center mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <i class="fas fa-ticket-alt text-blue-500 text-2xl"></i>
                <p class="mt-2 text-sm font-semibold">Voucher</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <i class="fas fa-star text-yellow-500 text-2xl"></i>
                <p class="mt-2 text-sm font-semibold">Points</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <i class="fas fa-handshake text-green-500 text-2xl"></i>
                <p class="mt-2 text-sm font-semibold">Partners</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <i class="fas fa-users text-purple-500 text-2xl"></i>
                <p class="mt-2 text-sm font-semibold">Referrals</p>
            </div>
        </section>

        <!-- Banner Section -->
        <section class="mb-6">
            <div class="relative bg-blue-500 rounded-lg p-6 text-white">
                <h2 class="text-lg font-semibold">Special Discount!</h2>
                <p>Get up to 50% off on selected items</p>
                <img src="banner.jpg" alt="Banner" class="absolute top-0 right-0 w-1/3 h-full object-cover rounded-lg">
            </div>
        </section>

        <!-- Flash Sale Section -->
        <section class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Flash Sale</h2>
                <span class="text-sm text-gray-600">Ends in: <span class="text-red-500">02:30:45</span></span>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-lg shadow">
                    <img src="item1.jpg" alt="Flash Sale Item" class="w-full h-24 object-cover rounded-lg mb-2">
                    <h3 class="text-sm font-semibold">Item Name</h3>
                    <p class="text-red-500 text-sm">Rp 100,000</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <img src="item2.jpg" alt="Flash Sale Item" class="w-full h-24 object-cover rounded-lg mb-2">
                    <h3 class="text-sm font-semibold">Item Name</h3>
                    <p class="text-red-500 text-sm">Rp 150,000</p>
                </div>
            </div>
        </section>

        <!-- Voucher List Section -->
        <section class="mb-6">
            <h2 class="text-lg font-semibold mb-4">Your Vouchers</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-sm font-semibold">10% Off</h3>
                    <p class="text-gray-600 text-xs">Valid until 31 Dec 2025</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-sm font-semibold">Free Shipping</h3>
                    <p class="text-gray-600 text-xs">Valid until 31 Jan 2026</p>
                </div>
            </div>
        </section>

        <!-- Navigation Bar -->
        <nav class="fixed bottom-0 left-0 right-0 bg-white shadow p-4 flex justify-between">
            <a href="#" class="flex flex-col items-center text-gray-700">
                <i class="fas fa-home text-xl"></i>
                <span class="text-sm">Home</span>
            </a>
            <a href="#" class="flex flex-col items-center text-gray-700">
                <i class="fas fa-search text-xl"></i>
                <span class="text-sm">Search</span>
            </a>
            <a href="#" class="flex flex-col items-center text-gray-700">
                <i class="fas fa-shopping-cart text-xl"></i>
                <span class="text-sm">Cart</span>
            </a>
            <a href="#" class="flex flex-col items-center text-gray-700">
                <i class="fas fa-user text-xl"></i>
                <span class="text-sm">Profile</span>
            </a>
        </nav>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js"></script>
</body>

</html>
