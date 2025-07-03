<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Filter Tanggal')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->default(now()->startOfYear())
                            ->maxDate(fn (Get $get) => $get('end_date') ?: now()),

                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->default(now()->endOfYear())
                            ->minDate(fn (Get $get) => $get('start_date') ?: now())
                            ->maxDate(now()),
                    ])
                    ->columns(2),
            ]);
    }
}
