<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transaction;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;

class StartOverview extends BaseWidget
{

    use InteractsWithPageFilters;

    protected function getStats(): array
    {

        $start = $this->filter('start_date')
            ? Carbon::parse($this->filter('start_date'))
            : now()->startOfYear();

        $end = $this->filter('end_date')
            ? Carbon::parse($this->filter('end_date'))
            : now()->endOfYear();

        $totalIncome = Transaction::whereHas('category', fn($q) => 
        $q->where('is_expense', 0))
        ->whereBetween('date_transaction', [$start, $end])
        ->sum('amount');

    $totalExpense = Transaction::whereHas('category', fn($q) => 
        $q->where('is_expense', 1))
        ->whereBetween('date_transaction', [$start, $end])
        ->sum('amount');

    $selisih = $totalIncome - $totalExpense;


        return [
        Stat::make('Total Pemasukan', 'Rp ' . number_format($totalIncome, 0, ',', '.'))
            ->description('Total semua pemasukan')
            ->color('success')
            ->icon('heroicon-m-arrow-trending-up'),

        Stat::make('Total Pengeluaran', 'Rp ' . number_format($totalExpense, 0, ',', '.'))
            ->description('Total semua pengeluaran')
            ->color('danger')
            ->icon('heroicon-m-arrow-trending-down'),

        Stat::make('Selisih', 'Rp ' . number_format($selisih, 0, ',', '.'))
            ->description('Pemasukan dikurangi pengeluaran')
            ->color($selisih >= 0 ? 'success' : 'danger')
            ->icon('heroicon-m-calculator'),
        ];
    }
}