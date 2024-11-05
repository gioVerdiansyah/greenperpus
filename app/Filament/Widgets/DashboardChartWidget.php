<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\Borrowing;
use Filament\Widgets\ChartWidget as Chart;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class DashboardChartWidget extends Chart
{
    protected static ?string $heading = 'Created Book Chart';
    protected int|string|array $columnSpan = 'full';
    protected static ?string $maxHeight = '200px';

    protected function getData(): array
    {
        $book = Trend::model(Book::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        $borrowed = Trend::model(Borrowing::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            "datasets" => [
                [
                    "label" => "Books",
                    "data" => $book->map(fn(TrendValue $val) => $val->aggregate)
                ],
                [
                    "label" => "Borrowed",
                    "data" => $borrowed->map(fn(TrendValue $val) => $val->aggregate),
                    "borderColor" => "#22C55E"
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
