<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use App\Models\Transaction;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Facades\FilamentAsset;


class ReportTransaction extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static string $view = 'filament.pages.report-transaction';
    protected static ?string $title = 'Laporan Transaksi';
    protected static ?string $navigationLabel = 'Laporan';
    protected static ?int $navigationSort = 3;

    public ?string $startDate = null;
    public ?string $endDate = null;

    public function mount(): void
    {
        $this->form->fill([
            'startDate' => now()->startOfMonth()->toDateString(),
            'endDate' => now()->endOfMonth()->toDateString(),
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\DatePicker::make('startDate')
                ->label('Dari Tanggal')
                ->reactive()
                ->afterStateUpdated(fn (Set $set, $state) => $set('startDate', $state)),

            Forms\Components\DatePicker::make('endDate')
                ->label('Sampai Tanggal')
                ->reactive()
                ->afterStateUpdated(fn (Set $set, $state) => $set('endDate', $state)),
        ];
    }

    public function getTransactions()
    {
        $state = $this->form->getState();

        return Transaction::with('category')
            ->whereBetween('date_transaction', [$state['startDate'], $state['endDate']])
            ->orderBy('date_transaction')
            ->get();
    }
}
