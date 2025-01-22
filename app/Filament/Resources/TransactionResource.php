<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Manajemen Transaksi';
    protected static ?string $navigationGroup = 'Manajemen Transaksi';

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery()->where('user_id', $user->id);
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->hidden(fn() => Auth::user()->role === 'store'),
                TextInput::make('code')
                    ->label('Kode Transaksi')
                    ->default(fn(): string => 'TRX-' . mt_rand(1000, 99999))
                    ->readOnly()
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Pemesan')
                    ->placeholder('e.g., Lionel Messi')
                    ->required(),
                TextInput::make('whatsapp')
                    ->label('Nomor WhatsApp')
                    ->tel()
                    ->placeholder('e.g., +628123456789')
                    ->required()
                    ->numeric()
                    ->rules('numeric|min:10'),
                Select::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'cash' => 'Cash',
                        'transfer' => 'Transfer',
                    ])
                    ->required(),
                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Tertunda',
                        'success' => 'Berhasil',
                        'failed' => 'Gagal',
                    ])
                    ->required(),
                Repeater::make('transactionDetails')
                    ->relationship()
                    ->schema([
                        Select::make('product_id')
                            ->label('Produk')
                            ->relationship('product', 'name')
                            ->options(function () {
                                if (Auth::user()->role === 'admin') {
                                    return Product::all()->mapWithKeys(function ($product) {
                                        return [$product->id => "$product->name (Rp " . number_format($product->price) . ")"];
                                    });
                                }
                                return Product::where('user_id', Auth::id())->get()->mapWithKeys(function ($product) {
                                    return [$product->id => "$product->name (Rp " . number_format($product->price) . ")"];
                                });
                            })
                            ->required(),
                        TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(1),
                        TextInput::make('note',)
                    ])->columnSpanFull()->live()->afterStateUpdated(function (Get $get, Set $set) {
                        self::updateTotals($get, $set);
                    }),
                TextInput::make('total_price')
                    ->required()
                    ->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Transaksi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode Transaksi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pemesan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Harga')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                    }),
            ])
            ->filters([
                // Add table filters if needed
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
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relations if needed
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

    public static function updateTotals(Get $get, Set $set): void
    {
        $selectedProducts = collect($get('transactionDetails'))->filter(fn($item) => !empty($item['product_id']) && !empty($item['quantity']));

        $prices = Product::find($selectedProducts->pluck('product_id'))->pluck('price', 'id');

        $total = $selectedProducts->reduce(function ($total, $product) use ($prices) {
            $price = $prices->get($product['product_id']);
            return $total + ($price * $product['quantity']);
        }, 0);

        $set('total_price', (string) $total);
    }
}
