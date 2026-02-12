<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SellerResource\Pages;
use App\Models\Seller;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerVerifiedMail;

class SellerResource extends Resource
{
    protected static ?string $model = Seller::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Sellers';
    protected static ?string $pluralModelLabel = 'Sellers';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('state')->label('State'),
                Tables\Columns\TextColumn::make('district')->label('District'),
                Tables\Columns\TextColumn::make('village')->label('Village'),
                Tables\Columns\TextColumn::make('pincode')->label('Pincode'),

                Tables\Columns\BadgeColumn::make('is_verified')
                    ->label('Verification Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Verified' : 'Pending')
                    ->colors([
                        'success' => fn ($state) => $state,
                        'warning' => fn ($state) => ! $state,
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registered On')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => ! $record->is_verified)
                    ->action(function ($record) {
                        $record->update([
                            'is_verified' => true,
                        ]);

                        Mail::to($record->email)
                            ->send(new SellerVerifiedMail($record));
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSellers::route('/'),
            'edit'  => Pages\EditSeller::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return true;
    }
}
