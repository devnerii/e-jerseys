<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomePageResource\Pages;
use App\Filament\Resources\HomePageResource\RelationManagers;
use App\Models\HomePage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;

class HomePageResource extends Resource
{
    protected static ?string $model = HomePage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('title')
                ->label('Título')
                ->required()
                ->maxLength(255),
                
            TextInput::make('slug')
                ->label('Slug (URL)')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            TextInput::make('description')
                ->label('Descrição')
                ->maxLength(500),

            Toggle::make('is_active')
                ->label('Ativo')
                ->default(true),
            
            FileUpload::make('logo_path') 
                ->label('Logo')
                ->image()
                ->required() 
                ->disk('public') 
                ->directory('logos'),

        /*    Select::make('products')
                ->label('Produtos')
                ->multiple()
                ->relationship('products', 'name')
                ->preload(), */
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('slug')
                    ->label('Slug')
                    ->sortable()
                    ->searchable(),

                BooleanColumn::make('is_active')
                    ->label('Ativo')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListHomePages::route('/'),
            'create' => Pages\CreateHomePage::route('/create'),
            'edit' => Pages\EditHomePage::route('/{record}/edit'),
        ];
    }
}
