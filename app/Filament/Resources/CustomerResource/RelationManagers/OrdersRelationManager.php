<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use App\Filament\Resources\OrderResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\ContentTabPosition;
use Illuminate\Database\Eloquent\Model;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';
//     public function isReadOnly(): bool
// {
//     return true;
// }

    public function form(Form $form): Form
    {
        return OrderResource::form($form);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('garment_quantity'),
                Tables\Columns\TextColumn::make('service_type'),
                Tables\Columns\TextColumn::make('unit_price'),
                Tables\Columns\TextColumn::make('total_price'),
                Tables\Columns\TextColumn::make('created_at')
                ->dateTime("h:i A"),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
