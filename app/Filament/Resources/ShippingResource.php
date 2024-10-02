<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShippingResource\Pages;
use App\Models\Shipping;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Money;

class ShippingResource extends Resource
{
    protected static ?string $model = Shipping::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $modelLabel = 'Frete';

    protected static ?string $pluralModelLabel = 'Fretes';

    protected static ?string $navigationGroup = 'Logística';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Money::make('shipment_fee')
                    ->label('Taxa de envio')
                    ->required()
                    ->prefix('R$')
                    ->initialValue(null)
                    ->columnSpan(1),
                Forms\Components\Select::make('acronym_state')
                    ->label('UF')
                    ->options(
                        State::pluck('acronym_state', 'acronym_state')
                    )
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get) {
                        $state = State::where('acronym_state', $get('acronym_state'))->first()->state | '';
                        $set('state', $state);
                        $set('country', 'Brasil');
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('shipment_fee')
                    ->label('Taxa de envio')
                    ->money('BRL', locale: 'pt_BR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('acronym_state')
                    ->label('UF')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListShippings::route('/'),
            'create' => Pages\CreateShipping::route('/create'),
            'edit' => Pages\EditShipping::route('/{record}/edit'),
        ];
    }
}
