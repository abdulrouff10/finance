<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use App\Models\Category;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Transaksi'; // Untuk menu sidebar
    
    protected static ?string $modelLabel = 'Transaksi'; // Untuk singular
    
    protected static ?string $pluralModelLabel = 'Transaksi'; // Untuk plural

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
    
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name') // relasi ke model Category
                    ->required(),
    
                Forms\Components\DatePicker::make('date_transaction')
                    ->required(),
    
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required(),
    
                Forms\Components\Textarea::make('note'),
    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\ImageColumn::make('category.image')
                     ->label('Icon'),
                     Tables\Columns\TextColumn::make('category.name')
                     ->label('Category')
                     ->description(fn ($record) => $record->note) // menampilkan deskripsi (note) di bawah nama kategori
                     ->searchable()
                     ->sortable(),
                 Tables\Columns\TextColumn::make('date_transaction')
                     ->label('Tanggal')
                     ->date('d M Y') // Contoh: 30 Jun 2025
                     ->sortable(),
                 
                     Tables\Columns\TextColumn::make('amount')
                     ->label('Jumlah')
                     ->money('IDR', locale: 'id_ID') // Akan jadi: Rp45.000
                     ->sortable(),
                 
                Tables\Columns\BooleanColumn::make('category.is_expense')
                        ->label('Tipe')
                        ->trueIcon('heroicon-m-arrow-up')     // Untuk pengeluaran
                        ->falseIcon('heroicon-m-arrow-down')  // Untuk pemasukan
                        ->trueColor('danger')                 // Merah
                        ->falseColor('success'),              // Hijau
                             
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
