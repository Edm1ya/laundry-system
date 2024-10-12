<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WasherResource\Pages;
use App\Filament\Resources\WasherResource\RelationManagers;
use App\Models\Washer;
use App\ServiceTypeEnum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ToggleColumn;

class WasherResource extends Resource
{
    protected static ?string $model = Washer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Select::make('service_type')
                        ->options(fn() => ServiceTypeEnum::indexed())
                        ->required(),
                        TextInput::make('garment_quantity')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                            Toggle::make('in_use')
                            ->default(false),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service_type'),
                TextColumn::make('garment_quantity'),
                ToggleColumn::make('in_use'),
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
            'index' => Pages\ListWashers::route('/'),
            'create' => Pages\CreateWasher::route('/create'),
            'edit' => Pages\EditWasher::route('/{record}/edit'),
        ];
    }
}
