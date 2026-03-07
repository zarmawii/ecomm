<?php

namespace App\Filament\Resources;

use App\Models\Product;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Product Info
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category'),

                Tables\Columns\TextColumn::make('price')
                    ->money('INR'),

                // AI Status Column
                Tables\Columns\TextColumn::make('ai_status')
                    ->label('AI Status')
                    ->badge()
                    ->colors([
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'warning' => 'pending',
                    ]),

                // AI Result (Fresh / Rotten etc.)
                Tables\Columns\TextColumn::make('ai_result')
                    ->label('AI Result'),

                // AI Confidence %
                Tables\Columns\TextColumn::make('ai_confidence')
                    ->label('Confidence')
                    ->formatStateUsing(fn ($state) => $state ? $state . '%' : '-'),

                // Manual Approval Status
                Tables\Columns\BooleanColumn::make('is_approved')
                    ->label('Admin Approved'),

                // Product Image
                ImageColumn::make('image')
                    ->disk('public'),
            ])

            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->action(fn ($record) =>
                        $record->update(['is_approved' => true])
                    )
                    ->visible(fn ($record) => ! $record->is_approved),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    // Only show AI-approved (Fresh) products that are not yet manually approved
    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->where('ai_status', 'approved');
}
}