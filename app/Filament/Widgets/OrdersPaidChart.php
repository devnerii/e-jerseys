<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersPaidChart extends ChartWidget
{
    protected static ?string $heading = 'Pedidos pagos';

    protected function getData(): array
    {
        $data = Trend::query(Order::where('payment_status', 'paid'))
            ->between(
                start: now()->subMonth(1),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Pedidos pagos',
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
