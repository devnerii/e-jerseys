<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersPendingChart extends ChartWidget
{
    protected static ?string $heading = 'Pedidos pendentes';

    protected function getData(): array
    {
        $data = Trend::query(Order::where('payment_status', 'unpaid'))
            ->between(
                start: now()->subMonth(1),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Pedidos pendentes',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'tension' => 0.3,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
