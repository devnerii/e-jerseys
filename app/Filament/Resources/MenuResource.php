<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationGroup = 'Aparência';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),
                Forms\Components\Select::make('section')
                    ->label('Posição do menu')
                    ->options([
                        'header' => 'Cabeçalho',
                        'footer_1' => 'Rodapé (coluna 1)',
                        'footer_2' => 'Rodapé (coluna 2)',
                        'footer_3' => 'Rodapé (coluna 3)',
                    ])
                    ->required()
                    ->native(false),
                Forms\Components\Select::make('link_type')
                    ->label('Tipo de link')
                    ->options([
                        'none' => 'Nenhum',
                        'external' => 'Externo',
                        'product' => 'Produto',
                        'category' => 'Categória',
                        //'page' => 'Página',
                    ])
                    ->live(onBlur: true)
                    ->required()
                    ->native(false),
                Forms\Components\Select::make('link_slug')
                    ->label('Slug do link')
                    ->required(function (Get $get) {
                        return $get('link_type') !== 'none' && $get('link_type') !== 'external';
                    })
                    ->disabled(function (Get $get) {
                        return $get('link_type') === 'none' || $get('link_type') === 'external';
                    })
                    ->hidden(fn (Get $get) => $get('link_type') === 'external')
                    ->options(fn (Get $get) => match ($get('link_type')) {
                        'product' => Product::where('is_active', true)->orderBy('name')->pluck('name', 'slug'),
                        'category' => Category::where('is_active', true)->orderBy('name')->pluck('name', 'slug'),
                        //'page' => [],
                        default => [],
                    })
                    ->live()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('home_page_id')
                    ->label('Página Inicial')
                    ->relationship('homePage', 'title')
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('link_slug')
                    ->label('URL amigável')
                    ->required(function (Get $get) {
                        return $get('link_type') === 'external';
                    })
                    ->disabled(function (Get $get) {
                        return $get('link_type') !== 'external';
                    })
                    ->hidden(fn (Get $get) => $get('link_type') !== 'external')
                    ->url(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('section')
                    ->label('Posição do menu')
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'header' => 'Cabeçalho',
                        'footer_1' => 'Rodapé (coluna 1)',
                        'footer_2' => 'Rodapé (coluna 2)',
                        'footer_3' => 'Rodapé (coluna 3)',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('label')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('link_type')
                    ->label('Tipo de link')
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'none' => 'Nenhum',
                        'external' => 'Externo',
                        'product' => 'Produto',
                        'category' => 'Categória',
                        'page' => 'Página',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('link_slug')
                    ->label('URL amigável')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
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
                SelectFilter::make('section')
                    ->label('Posição do menu')
                    ->options([
                        'header' => 'Cabeçalho',
                        'footer_1' => 'Rodapé (coluna 1)',
                        'footer_2' => 'Rodapé (coluna 2)',
                        'footer_3' => 'Rodapé (coluna 3)',
                    ]),
                SelectFilter::make('link_type')
                    ->label('Tipo de link')
                    ->options([
                        'none' => 'Nenhum',
                        'external' => 'Externo',
                        'product' => 'Produto',
                        'category' => 'Categória',
                        'page' => 'Página',
                    ]),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
