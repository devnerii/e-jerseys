<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\ItemsRelationManager;
use App\Models\Order;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Money;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $modelLabel = 'pedido';

    protected static ?string $pluralModelLabel = 'pedidos';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Informações do pedido')
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label('Usuário')
                                    ->relationship('user', 'name')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('payment_status')
                                    ->label('Estado do pagamento')
                                    ->maxLength(255)
                                    ->dehydrated()
                                    ->disabled(),
                                Forms\Components\Select::make('status')
                                    ->label('Estado do pedido')
                                    ->options([
                                        'new' => 'Novo',
                                        'processing' => 'Processando',
                                        'shipped' => 'Enviado',
                                        'delivered' => 'Entregue',
                                        'cancelled' => 'Cancelado',
                                    ])
                                    ->native(false)
                                    ->required(),
                            ])->columns(2),
                        Tabs\Tab::make('Valor do pedido')
                            ->schema([
                                Money::make('subtotal')
                                    ->label('Sub-total')
                                    ->required(),
                                Money::make('shipment_fee')
                                    ->label('Taxa de envio')
                                    ->required(),
                            ])->columns(2),
                        Tabs\Tab::make('Endereço de entrega')
                            ->schema([
                                Cep::make('postal_code')
                                    ->label('CEP')
                                    ->viaCep(
                                        mode: 'suffix', // Determines whether the action should be appended to (suffix) or prepended to (prefix) the cep field, or not included at all (none).
                                        errorMessage: 'CEP inválido.', // Error message to display if the CEP is invalid.
                                        setFields: [
                                            'address' => 'logradouro',
                                            'complement' => 'bairro',
                                            'city' => 'localidade',
                                            'acronym_state' => 'uf',
                                        ]
                                    )
                                    ->required()
                                    ->afterStateUpdated(function (Set $set, Get $get) {
                                        $state = State::where('acronym_state', $get('acronym_state'))->first()->state | '';
                                        $set('state', $state);
                                        $set('country', 'Brasil');
                                    }),
                                Forms\Components\TextInput::make('city')
                                    ->label('Cidade')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('address')
                                    ->label('Endereço')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('complement')
                                    ->label('Complemento')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('state')
                                    ->label('Estado')
                                    ->options(
                                        State::pluck('state', 'state')
                                    )
                                    ->required(),
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
                                    ->required(),
                                Forms\Components\TextInput::make('country')
                                    ->label('Pais')
                                    ->required()
                                    ->maxLength(255),
                            ])->columns(3),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuário')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Estado do pedido')
                    ->options([
                        'new' => 'Novo',
                        'processing' => 'Processando',
                        'shipped' => 'Enviado',
                        'delivered' => 'Entregue',
                        'cancelled' => 'Cancelado',
                    ]),
                Tables\Columns\TextColumn::make('payment_status')
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'paid' => 'Pago',
                        'unpaid' => 'Não pago',
                        'new' => 'Novo',
                        'cancelled' => 'Cancelado',
                        default => $state,
                    })
                    ->label('Estado do pagamento')->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Sub-total')
                    ->money(currency: 'BRL', locale: 'pt_BR')
                    ->sortable()->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('shipment_fee')
                    ->label('Taxa de envio')
                    ->money(currency: 'BRL', locale: 'pt_BR')
                    ->sortable()->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('address')
                    ->label('Endereço')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('city')
                    ->label('Cidade')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('acronym_state')
                    ->label('UF')->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('country')
                    ->label('Pais')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('postal_code')
                    ->label('CEP')
                    ->searchable()->toggleable(isToggledHiddenByDefault: false),
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
            ItemsRelationManager::class,
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
}
