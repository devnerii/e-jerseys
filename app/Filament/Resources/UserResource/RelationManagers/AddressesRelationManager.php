<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\State;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Cep;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Cep::make('postal_code')
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
                    ->maxLength(255),
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
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('country')
                    ->label('Pais')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('address')
            ->heading('Endereços')
            ->modelLabel('endereço')
            ->pluralModelLabel('endereços')
            ->columns([
                Tables\Columns\TextColumn::make('address')
                    ->label('Endereço')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('complement')
                    ->label('Complemento')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Cidade')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->label('Estado')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('acronym_state')
                    ->label('UF'),
                Tables\Columns\TextColumn::make('country')
                    ->label('Pais'),
                Tables\Columns\TextColumn::make('postal_code')
                    ->label('CEP'),
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
