<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteBulkAction as ActionsDeleteBulkAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Manajemen Produk';

    protected static ?string $navigationGroup = 'Manajemen Menu';

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery()->where('user_id', $user?->id);
    }

    public static function canCreate(): bool
    {
        if (Auth::user()->role === 'admin') {
            return true;
        }
    
        // Fetch the active subscription for the current user
        $subscription = Subscription::where('user_id', Auth::id())
            ->where('end_date', '>', now())
            ->where('is_active', true)
            ->latest()
            ->first();
    
        // Count the number of products for the current user
        $countProduct = Product::where('user_id', Auth::id())->count();
    
        // Allow creation if the product count is less than 2 or the user has an active subscription
        return !($countProduct >= 5 && !$subscription);
    }
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Toko')
                    ->relationship('user', 'name')
                    ->required()
                    ->hidden(fn() => Auth::user()->role === 'store'),
                Select::make('product_category_id')
                    ->label('Kategori Produk')
                    ->required()
                    ->relationship('productCategory', 'name')
                    ->options(function (callable $get) {
                        $userId = $get('user_id') ?? Auth::user()->id;
                        return ProductCategory::where('user_id', $userId)->pluck('name', 'id');
                    }),
                FileUpload::make('image')
                    ->label('Foto Menu')
                    ->image()
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Produk')
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi Produk')
                    ->required(),
                TextInput::make('price')
                    ->label('Harga Produk')
                    ->required()
                    ->numeric()
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Toko')
                    ->hidden(fn() => Auth::user()->role === 'store'),
                TextColumn::make('productCategory.name')
                    ->label('Kategori Produk'),
                ImageColumn::make('image')
                    ->label('Foto Barang'),
                TextColumn::make('price')
                    ->label('Harga Menu')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->label('Nama Toko')
                    ->hidden(fn() => Auth::user()->role === 'store'),
                SelectFilter::make('product_category_id')
                    ->label('Kategori Produk')
                    ->options(function () {
                        $user = Auth::user();
                        $query = $user->role === 'admin' 
                            ? ProductCategory::query() 
                            : ProductCategory::where('user_id', $user->id);
                        return $query->pluck('name', 'id');
                    }),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}