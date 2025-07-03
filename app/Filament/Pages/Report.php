<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class Report extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.report';
    protected static ?string $navigationLabel = 'Laporan';
    protected static ?int $navigationSort = 3;

    public ?string $start_date = null;
    public ?string $end_date = null;

    public function mount(): void
    {
        $this->start_date = now()->startOfMonth()->toDateString();
        $this->end_date = now()->endOfMonth()->toDateString();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('start_date')->label('Tanggal Mulai'),
                DatePicker::make('end_date')->label('Tanggal Akhir'),
            ])
            ->statePath('data');
    }

    public function getTransactions()
    {
        return Transaction::with('category')
            ->whereBetween('date_transaction', [$this->start_date, $this->end_date])
            ->get();
    }

    public function getPdfUrl(): string
    {
        return route('transactions.report.pdf', [
            'start' => $this->start_date,
            'end' => $this->end_date,
        ]);
    }
}
