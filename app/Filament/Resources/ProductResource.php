<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Filament\Forms\Components\TextInput;
use App\Models\HomePage; 
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Select;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $modelLabel = 'produto';

    protected static ?string $pluralModelLabel = 'produtos';

    protected static ?string $navigationGroup = 'Itens';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        $value = null;

        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Informações do produto')
                            ->collapsible()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nome')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(
                                        fn (string $operation, string $state, Set $set) => $operation === 'create' ?
                                                $set('slug', str($state)->slug()->toString()) : null)
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('slug')
                                    ->label('URL amigávell')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                Forms\Components\RichEditor::make('description')
                                    ->label('Descrição')
                                    ->columnSpanFull()
                                    ->maxLength(65535)
                                    ->required()
                                    ->extraInputAttributes(['style' => 'min-height: 40vh; max-height: 40vh; overflow-y: auto;']),

                                Money::make('price')
                                    ->label('Preço')
                                    ->required()
                                    ->prefix('R$')
                                    ->initialValue(null)
                                    ->columnSpan(1),
                                Money::make('price_full')
                                    ->label('Preço original')
                                    //->required()
                                    ->prefix('R$')
                                    ->initialValue(null)
                                    ->columnSpan(1),
                                Forms\Components\MultiSelect::make('categories')
                                    ->label('Categoria')
                                    ->relationship('categories', 'name')
                                    ->required()
                                    ->columnSpan(2)
                                    ->searchable()
                                    ->preload(),
                                    Repeater::make('quantity_discounts')
                                    ->label('Descontos por Quantidade')
                                    ->schema([
                                        Forms\Components\TextInput::make('min_quantity')
                                            ->label('Quantidade Mínima')
                                            ->numeric()
                                            ->required(),
                                        Forms\Components\TextInput::make('max_quantity')
                                            ->label('Quantidade Máxima')
                                            ->numeric()
                                            ->required(),
                                        Money::make('discounted_price')
                                            ->label('Preço com Desconto')
                                            ->required()
                                            ->prefix('R$')
                                            ->columnSpan(1),
                                    ])
                                    ->minItems(1)
                                    ->columns(3)
                                    ->reorderable()
                                  //  ->helperText('Adicione faixas de desconto por quantidade.')
                                ,
                                Forms\Components\Toggle::make('show_on_main_page')
                                ->label("show on main page"),

                                Select::make('home_page_id')
                                ->label('Página Inicial')
                                ->relationship('homePage', 'title')
                                ->required()
                                ->searchable(),
                            ])->columns(2),
                    ])->columnSpan(2),
                    
                    
                Group::make()
                    ->schema([
                        Section::make('SEO')
                            ->collapsible()
                            ->schema([
                                ...self::formsSEO(),
                            ])
                            ->columns(1)
                            ->columnSpan(1),
                        Section::make('Controles')
                            ->collapsible()
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Ativo')
                                    ->required()
                                    ->default(true),
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Destaque')
                                    ->required(),
                                Forms\Components\Toggle::make('in_stock')
                                    ->label('Em estoque')
                                    ->required()
                                    ->default(true),
                                Forms\Components\Toggle::make('on_sale')
                                    ->label('Em promoção')
                                    ->required(),
                            ])
                            ->columnSpan(1)
                            ->columns(1),
                    ])->columnSpan(1), 
                Section::make('Destaque')
                    ->collapsible()
                    ->schema([
                        Forms\Components\FileUpload::make('images')
                            ->label('Imagens')
                            ->multiple()
                            ->maxFiles(8)
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                            ])
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('586')
                            ->imageResizeTargetHeight('586')
                            ->reorderable()
                            ->directory('products')
                            ->panelLayout('grid')
                            ->columnSpanFull(),

                            Forms\Components\FileUpload::make('videos')
                            ->label('Vídeos')
                            ->multiple()
                            ->maxFiles(5)
                            ->directory('products')
                            ->panelLayout('grid')
                            ->columnSpanFull()
                            ->acceptedFileTypes(['video/*']),

                            Forms\Components\FileUpload::make('gifs')
                            ->label('GIFs')
                            ->multiple()
                            ->maxFiles(5)
                            ->directory('products')
                            ->panelLayout('grid')
                            ->columnSpanFull()
                            ->acceptedFileTypes(['image/gif']),
                    ]),
                Section::make('Propriedades e variantes')
                    ->collapsible()
                    ->schema([
                        Forms\Components\KeyValue::make('properties')
                            ->label('Propriedades gerais')
                            ->keyLabel('Nome da propriedade')
                            ->valueLabel('Valor da propriedade')
                            ->reorderable()
                            ->columnSpanFull(),
                        Repeater::make('variant_properties')
                            ->label('Propriedades das variantes')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Propriedades da variante')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                Forms\Components\TagsInput::make('values')
                                    ->label('Valores da variante')
                                    ->required()
                                    ->reorderable()
                                    ->placeholder('Defina as propriedades da variante')
                                    ->columnSpan(1),
                            ])
                            ->defaultItems(0)
                            ->columns(2)
                            ->columnSpanFull(),
                        Repeater::make('variants')
                            ->label('Estoque das Variantes')
                            ->schema(
                                function (Get $get): array {
                                    return static::variantsFileds($get);
                                },
                            )
                            ->defaultItems(0)
                            ->columns(3)
                            ->columnSpanFull(),
                    ]),
            ])->columns(3);
    }

    public static function formsSEO(): array
    {
        $seoFields = \_34ml\SEO\SEOField::make('seo');

        foreach ($seoFields as $group) {
            foreach ($group->getChildComponents() as $field) {
                $field->label(__($field->getLabel()));
            }
        }

        return $seoFields;
    }

    public static function variantsFileds(Get $get): array
    {
        $fields = [];
        $variant_properties = $get('variant_properties');
        foreach ($variant_properties as $item) {
            if ($item['name'] !== null) {
                $fields[] = Forms\Components\Select::make($item['name'])
                    ->options($item['values'])
                    ->required()
                    ->columnSpan(1);
            }

        }
        if (count($fields) >= 0) {
            $fields[] = Forms\Components\TextInput::make('quantity')
                ->label('Quantidade')
                ->columnSpan(1)
                ->numeric()
                ->default(1)
                ->minValue(0)
                ->required();
        }

        return $fields;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoría')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('URL amigável')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Preço')
                    ->money(currency: 'BRL', locale: 'pt_BR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_full')
                    ->label('Preço original')
                    ->money(currency: 'BRL', locale: 'pt_BR')
                    ->sortable(),
               /* Tables\Columns\TextColumn::make('quantity_discounts')
                    ->formatStateUsing(fn ($state) => json_encode($state))
                    ->html(),*/
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destaque')
                    ->boolean(),
                Tables\Columns\IconColumn::make('in_stock')
                    ->label('Em estoque')
                    ->boolean(),
                Tables\Columns\IconColumn::make('on_sale')
                    ->label('Em promoção')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
