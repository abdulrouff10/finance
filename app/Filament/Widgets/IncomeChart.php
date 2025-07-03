<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\Transaction;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class IncomeChart extends LineChartWidget
{
    use InteractsWithPageFilters;

    // Judul widget
    protected static ?string $heading = 'Pemasukan';

    // Urutan tampilan widget
    protected static ?int $sort = 0;

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
        $incomeTrends = Trend::query(
                Transaction::query()->income()
                    ->whereBetween('date_transaction', [$start, $end])
            )
            ->between(start: $start, end: $end)
            ->perDay()
            ->sum('amount');

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan Harian',
                    'data' => $incomeTrends->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#38c172', // Hijau (success)
                    'backgroundColor' => 'rgba(56, 193, 114, 0.3)',
                ],
            ],
            'labels' => $incomeTrends->map(fn ($value) => Carbon::parse($value->date)->format('d M'))->toArray(),
        ];
    }
}
