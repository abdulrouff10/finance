<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationLabel = 'Kategori'; // Untuk menu sidebar
    
    protected static ?string $modelLabel = 'Kategori'; // Untuk singular
    
    protected static ?string $pluralModelLabel = 'Kategori'; // Untuk plural

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('is_expense')
                    ->label('Tipe')
                    ->options([
                        false => 'Pemasukan',
                        true => 'Pengeluaran',
                    ])
                    ->required()
                    ->native(false), // agar tampilannya lebih bagus di browser modern
                
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Ikon')
                    ->circular(), // Opsional: buat gambar bulat
    
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable(),
    
                    Tables\Columns\TextColumn::make('is_expense')
                    ->label('Tipe')
                    ->formatStateUsing(fn (bool $state) => $state ? 'Pengeluaran' : 'Pemasukan')
                    ->badge()
                    ->color(fn (bool $state) => $state ? 'danger' : 'success'),
                
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
