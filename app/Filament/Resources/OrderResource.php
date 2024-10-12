<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Service;
use App\Models\Washer;
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
                            ->label("Customer")
                            ->translateLabel()
                            ->required()
                            ->options(fn() => Customer::query()->get()->pluck('name', 'id')),
                        TextInput::make('garment_quantity')
                            ->label("Garment quantity")
                            ->translateLabel()
                            ->numeric()
                            ->minValue(1)
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculatePrice($get, $set);
                            })->live()
                            ->required(),
                        Select::make('service_id')
                            ->label("Service type")
                            ->translateLabel()
                            ->options(fn() => Service::query()->get()->pluck('name', 'id'))
                            ->required()
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $query = Service::query()->where('id', $state)->pluck('unit_price')->first();
                                $set('unit_price',$query);

                                self::calculatePrice($get, $set);
                            })
                            ->live(),
                        TextInput::make('unit_price')
                            ->label("Unit price")
                            ->translateLabel()
                            ->numeric()
                            ->minValue(1)
                            ->readOnly()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                self::calculatePrice($get, $set);
                            })->live()
                            ->required(),
                        TextInput::make('total_price')
                            ->label("Total")
                            ->translateLabel()
                            ->readOnly()
                            ->numeric()
                            ->minValue(1),
                        Select::make('washer_id')
                            ->label("Washer")
                            ->translateLabel()
                            ->options(function (Get $get) {
                                $typeService = $get('service_type');
                                return Washer::query()
                                    ->where('service_type', $typeService)
                                    ->Where('in_use', false)
                                    ->get()
                                    ->pluck('name', 'id');
                            })
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
