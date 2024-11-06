<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AdminChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected int|string|array $columnSpan = "full";
    protected static ?string $maxHeight = "300px";

    protected function getData(): array
    {
        $books = Trend::model(Book::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear()
            )
            ->perMonth()
            ->count();

        $users = Trend::model(User::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear()
            )
            ->perMonth()
            ->count();

        $borrowings = Trend::model(Borrowing::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear()
            )
            ->perMonth()
            ->count();


        return [
            "datasets" => [
                [
                    "label" => "Books",
                    "data" => $books->map(fn(TrendValue $trend) => $trend->aggregate)
                ],
                [
                    "label" => "Users",
                    "data" => $users->map(fn(TrendValue $trend) => $trend->aggregate),
                    "borderColor" => "#327cc7"
                ],
                [
                    "label" => "Borrowings",
                    "data" => $borrowings->map(fn(TrendValue $trend) => $trend->aggregate),
                    "borderColor" => "#32a852"
                ],
            ],
            "labels" => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
