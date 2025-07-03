<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\Transaction;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class ExpenseChart extends LineChartWidget
{
    use InteractsWithPageFilters;

    // Judul widget
    protected static ?string $heading = 'Pengeluaran';

    // Urutan tampilan widget
    protected static ?int $sort = 1;

    // Mengambil data untuk chart
    protected function getData(): array
    {

        // Ambil nilai filter tanggal dari halaman Dashboard
        $start = $this->filter('start_date')
            ? Carbon::parse($this->filter('start_date'))
            : now()->startOfYear();

        $end = $this->filter('end_date')
            ? Carbon::parse($this->filter('end_date'))
            : now()->endOfYear();

        // Ambil tren data pemasukan
        $expenseTrends = Trend::query(
                Transaction::query()->expense()
                    ->whereBetween('date_transaction', [$start, $end])
            )
            ->between(start: $start, end: $end)
            ->perDay()
            ->sum('amount');

        return [
            'datasets' => [
                [
                    'label' => 'Pengeluaran Harian',
                    'data' => $expenseTrends->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#dc2626', // Merah danger
                    'backgroundColor' => 'rgba(220, 38, 38, 0.3)',
                ],
            ],
            'labels' => $expenseTrends->map(fn ($value) => Carbon::parse($value->date)->format('d M'))->toArray(),
        ];
    }
}
