<?php

namespace App\Filament\User\Resources\User\BookListResource\Pages;

use App\Filament\User\Resources\User\BookListResource;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditBookList extends EditRecord
{
    protected static string $resource = BookListResource::class;

    public function getFormActions(): array
    {
        return [
            Action::make("Back")
                ->icon('')
                ->action(fn () => redirect($this->getResource()::getUrl('index')))
        ];
    }
    public function form(Form $form): Form
    {
        $class = ['style' => "box-shadow: none"];
        return $form
            ->schema([
                TextInput::make('name')->disabled()->extraAttributes($class, true),
                TextInput::make('writer')->disabled()->extraAttributes($class, true),
                TextInput::make('publisher')->disabled()->extraAttributes($class, true),
                TextInput::make('year_publish')->disabled()->extraAttributes($class, true),
            ]);
    }
    public function getTitle():string
    {
        return "Book Detail";
    }
}
