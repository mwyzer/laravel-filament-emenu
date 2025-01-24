<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    // this function for hide/unhide sidebar each roles, eg admin, csp
    public static function canViewAny(): bool
    {
        return in_array(Auth::user()->role, ['admin', 'csp', 'marketing', 'finance', 'sales']);
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
        return $form->schema([
            Select::make('user_id')
                ->label('Nama Toko')
                ->options(User::all()->pluck('name', 'id')->toArray())
                ->required()
                ->hidden(fn() => Auth::user()->role === 'store'),
            Toggle::make('is_active')
                ->required()
                ->hidden(fn() => Auth::user()->role === 'store'),
            Repeater::make('subscriptionPayment')
                ->relationship()
                ->schema([
                    FileUpload::make('proof')
                        ->label('Bukti Transfer ke Rekening 21231233424 (BCA) A/N Anu Sebesar Rp. 50.000')
                        ->required()
                        ->columnSpanFull(),
                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'success' => 'Success',
                            'failed' => 'Failed',
                        ])
                        ->required()
                        ->label('Status Pembayaran')
                        ->columnSpanFull()
                        ->hidden(fn() => Auth::user()->role === 'store'),
                ])
                ->columnSpanFull()
                ->addable(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama Toko')
                    ->hidden(fn() => Auth::user()->role === 'store'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Tanggal Mulai'),
                TextColumn::make('end_date')
                    ->dateTime()
                    ->label('Tanggal Berakhir'),
                ImageColumn::make('subscriptionPayment.proof')
                    ->label('Bukti Transfer')
                    ->hidden(fn() => Auth::user()->role === 'store'),
                TextColumn::make('subscriptionPayment.status')
                    ->label('Status Pembayaran')
                    ->hidden(fn() => Auth::user()->role === 'store'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
