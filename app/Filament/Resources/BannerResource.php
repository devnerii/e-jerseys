<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Aparência';

    protected static ?string $modelLabel = 'banner';

    protected static ?string $pluralModelLabel = 'banners';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image_sm')
                    ->label('Imagem (pequena)')
                    ->helperText('O banner deve ter 430px de largura e 586px de altura para uma melhor apresentação.')
                    ->directory('banners')
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '215:293',
                    ])
                    ->imageCropAspectRatio('215:293')
                    ->imageResizeTargetWidth('430')
                    ->imageResizeTargetHeight('586'),
                Forms\Components\FileUpload::make('image_lg')
                    ->helperText('O banner deve ter 1872px de largura e 716px de altura para uma melhor apresentação.')
                    ->label('Imagem (grande)')
                    ->directory('banners')
                    ->image()
                    ->imageResizeMode('cover')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '468:179',
                    ])
                    ->imageCropAspectRatio('468:179')
                    ->imageResizeTargetWidth('1872')
                    ->imageResizeTargetHeight('716')
                    ->required(),
                    Forms\Components\FileUpload::make('video_path')
                    ->label('Vídeo')
                    ->helperText('Faça upload de um vídeo opcional para o banner.')
                    ->directory('banners/videos')
                    ->acceptedFileTypes(['video/mp4', 'video/avi', 'video/mov'])
                    ->maxSize(102400) 
                    ->nullable(),
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
                    Forms\Components\Toggle::make('mid_page_banner')
                    ->label('Exibir como Banner da Página do Meio')
                    ->helperText('Marque para exibir este banner na seção do meio da página.')
                    ->default(false),
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
                    Select::make('home_page_id')
                                ->label('Página Inicial')
                                ->relationship('homePage', 'title')
                                ->required()
                                ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_sm')
                    ->label('Imagem (pequena)'),
                Tables\Columns\ImageColumn::make('image_lg')
                    ->label('Imagem (grande)'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
