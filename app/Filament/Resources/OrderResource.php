<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Pages\ListRecords;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Orders';
    protected static ?string $pluralLabel = 'Orders';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order ID'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User'),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product'),

                Tables\Columns\TextColumn::make('quantity'),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total'),

                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Payment'),

                Tables\Columns\TextColumn::make('order_status')
                    ->label('Status'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}