<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Borrowing;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Book Total", Book::count())
                ->color("primary")
                ->description("All total book we have")
                ->descriptionIcon("heroicon-s-book-open", IconPosition::Before)
                ->chart([1, 3, 5, 10, 20, 40]),
            Stat::make("Category Total", BookCategory::count())
                ->color("info")
                ->description("All total book category we have")
                ->descriptionIcon("heroicon-s-rectangle-stack", IconPosition::Before)
                ->chart([1, 3, 5, 10, 20, 40]),
            Stat::make("Borrowed Total", Borrowing::count())
                ->color("success")
                ->description("All total borrowed we have")
                ->descriptionIcon("heroicon-s-archive-box-arrow-down", IconPosition::Before)
                ->chart([1, 3, 5, 10, 20, 40]),
        ];
    }
}
