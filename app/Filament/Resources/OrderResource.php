<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Customer;
use App\Models\Order;
use App\ServiceTypeEnum;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Select::make('customer_id')
                            ->required()
                            ->options(fn() => Customer::query()->get()->pluck('name', 'id')),
                        TextInput::make('garment_quantity')
                            ->numeric()
                            ->minValue(1)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculatePrice($get, $set);
                            })->live()
                            ->required(),
                        Select::make('service_type')
                            ->options(fn() => ServiceTypeEnum::indexed())
                            ->required(),
                        TextInput::make('unit_price')
                            ->numeric()
                            ->minValue(1)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculatePrice($get, $set);
                            })->live()
                            ->required(),
                        TextInput::make('total_price')
                            ->readOnly()
                            ->numeric()
                            ->minValue(1),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name'),
                TextColumn::make('status'),
                TextColumn::make('garment_quantity'),
                TextColumn::make('service_type'),
                TextColumn::make('unit_price'),
                TextColumn::make('total_price')
                    ->money(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function calculatePrice(Get $get, Set $set)
    {
        $garmentQuantity = $get('garment_quantity') != "" ? $get('garment_quantity') : 0;
        $unitPrice = $get('unit_price') != "" ? $get('unit_price') : 0;
        $set('total_price', $garmentQuantity * $unitPrice);
    }
}
