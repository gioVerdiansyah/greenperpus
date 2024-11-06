<?php

namespace App\Filament\Resources\BorrowingResource\Pages;

use App\Filament\Resources\BorrowingResource;
use App\Models\Book;
use App\Models\Borrowing;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListBorrowings extends ListRecords
{
    protected static string $resource = BorrowingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make("generate_report")
                ->icon("heroicon-o-printer")
                ->action(function () {
                    $borrowed = Borrowing::where('status', "APPROVED")->get();

                    $pdf = Pdf::loadView("generate_report", ['data' => $borrowed]);

                    return response()->streamDownload(fn() => print ($pdf->output()), 'borrowed_list_report.pdf');
                })
        ];
    }
}
