<?php

namespace App\Filament\Widgets;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Book Total", Book::count())
                ->color("primary")
                ->description("All books we have")
                ->descriptionIcon("heroicon-o-book-open", IconPosition::Before)
                ->chart([1, 3, 5, 10, 20, 40]),
            Stat::make("User Total", User::where("role", "USER")->count())
                ->color("info")
                ->description("All users we have")
                ->descriptionIcon("heroicon-o-user-group", IconPosition::Before)
                ->chart([1, 3, 5, 10, 20, 40]),
            Stat::make("Borrowed Book", Borrowing::where("status", "APPROVED")->count())
                ->color("success")
                ->description("All books borrowed we have")
                ->descriptionIcon("heroicon-o-bookmark", IconPosition::Before)
                ->chart([1, 3, 5, 10, 20, 40])
        ];
    }
}
