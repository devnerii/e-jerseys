<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'todos' => Tab::make('Todos')
                ->modifyQueryUsing(function ($query) {
                    return $query;
                }),
            'new' => Tab::make('Novo')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('payment_status', 'new');
                }),
            'unpaid' => Tab::make('Não pago')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('payment_status', 'unpaid');
                }),
            'paid' => Tab::make('Pago')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('payment_status', 'paid');
                }),

            'cancelled' => Tab::make('Cancelado')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('payment_status', 'cancelled');
                }),
        ];

    }
}
