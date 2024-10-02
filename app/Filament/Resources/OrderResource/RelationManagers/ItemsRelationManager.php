<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Produto')
                    ->relationship('product', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        function (string $state, Set $set, Get $get) {
                            $product = Product::find($state);
                            $set('unit_price', $product->price);
                            $quantity = $get('quantity');
                            $quantity = $quantity ? $quantity : 1;
                            $set('quantity', $quantity);
                            $set('total_price', $product->price * $quantity);
                        }
                    ),
                Forms\Components\TextInput::make('quantity')
                    ->label('Quantidade')
                    ->numeric()
                    ->required()
                    ->afterStateUpdated(
                        function (string $state, Set $set, Get $get) {
                            $unit_price = $get('unit_price');
                            $set('total_price', $unit_price * $state);
                        }
                    )->live(debounce: 300),
                Forms\Components\TextInput::make('unit_price')
                    ->label('Preço Un.')
                    ->numeric()
                    ->inputMode('decimal')
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                Forms\Components\TextInput::make('total_price')
                    ->label('Preço Tot.')
                    ->numeric()
                    ->inputMode('decimal')
                    ->disabled()
                    ->dehydrated()
                    ->required(),
                KeyValue::make('variants')
                    ->label('Variante do item')
                    ->keyLabel('Nome da propriedade')
                    ->valueLabel('Valor da propriedade')
                    ->disabled()
                    ->dehydrated()
                    ->deletable(false)->addable(false)->columnSpanFull(),
            ]);
    }

    public static function variantsFileds(Get $get): array
    {
        $fields = [];
        $variant_properties = $get('variants');
        foreach ($variant_properties as $name => $value) {

            $fields[] = [
                Forms\Components\TextInput::make('name')
                    ->label('Tipo')
                    ->value($name)
                    ->columnSpan(1)
                    ->required()
                    ->disabled(true)
                    ->dehydrated(),
                Forms\Components\TextInput::make('value')
                    ->label('Valor')
                    ->value($value)
                    ->columnSpan(1)
                    ->required()
                    ->disabled(true)
                    ->dehydrated(),
            ];

        }

        return $fields;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.name')
            ->heading('item')
            ->modelLabel('item')
            ->pluralModelLabel('items')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Nome do item'),
                Tables\Columns\TextColumn::make('unit_price')
                    ->label('Preço Un.')
                    ->money('brl', locale: 'pt_BR'),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantidade'),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Preço Tot.')
                    ->money('brl', locale: 'pt_BR'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
