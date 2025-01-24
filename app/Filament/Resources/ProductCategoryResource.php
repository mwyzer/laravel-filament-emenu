<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductCategoryResource\Pages;
use App\Filament\Resources\ProductCategoryResource\RelationManagers;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Manajemen Kategori Produk';

    protected static ?string $navigationGroup = 'Manajemen Menu';

    // this function for hide/unhide sidebar each roles, eg admin, csp
    public static function canViewAny(): bool
    {
        return in_array(Auth::user()->role, ['admin', 'store']);
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user(); // Get the authenticated user

        // If the user is an admin, allow them to see all records
        if ($user && $user->role === 'admin') {
            return parent::getEloquentQuery();
        }

        // Restrict other users to their own records
        return parent::getEloquentQuery()->where('user_id', $user?->id);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Nama Toko') // Label for the select field
                    ->relationship('user', 'name')
                    ->required()
                    ->hidden(fn() => Auth::user()->role === 'store'), // Ensures the field is mandatory
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('user.name')
                    ->label('Nama Toko')
                    ->hidden(fn() => Auth::user()->role === 'store'),
                TextColumn::make('name')
                    ->label('Nama Kategori')
            ])
            ->filters([
                //
                SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->label('Nama Toko')
                    ->hidden(fn() => Auth::user()->role === 'store'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProductCategories::route('/'),
            'create' => Pages\CreateProductCategory::route('/create'),
            'edit' => Pages\EditProductCategory::route('/{record}/edit'),
        ];
    }
}
