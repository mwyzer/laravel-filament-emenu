<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Product;
use App\Models\SubscriptionPayment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class DashboardOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalTransaction = 0;
        $totalAmount = 0;

        if (Auth::check()) {
            $totalTransaction = Transaction::where('user_id', Auth::id())
                ->where('payment_status', 'success')
                ->count();


            $totalAmount = Transaction::where('user_id', Auth::id())
                ->where('payment_status', 'success')
                ->sum('total_price');
   
        }

        if (Auth::user()->role === 'admin') {
            $totalSubscriptionPayments = SubscriptionPayment::where('status', 'success')->count();
            $totalRevenue = $totalSubscriptionPayments * 50000; // Assuming each successful payment is Rp 50,000


            return [
                Stat::make('Total Pengguna', User::count()),
                Stat::make('Total Pendapatan Langganan', 'Rp ' . number_format(SubscriptionPayment::where('status', 'success')->count() * 50000)),
                Stat::make('Total Produk', Product::count()),
            ];
        } else {
            return [
                Stat::make('Total Transaksi', $totalTransaction),
                Stat::make('Total Pendapatan', 'Rp ' . number_format($totalAmount)),
                Stat::make('Rata-rata Pendapatan', $totalTransaction > 0 ? 'Rp ' . number_format($totalAmount / $totalTransaction, 0, ',', '.') : 'Rp 0'),
            ];
        }
    }
}
