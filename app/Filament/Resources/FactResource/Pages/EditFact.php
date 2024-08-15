<?php

namespace App\Filament\Resources\FactResource\Pages;

use App\Filament\Resources\FactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFact extends EditRecord
{

    use EditRecord\Concerns\Translatable;

    protected static string $resource = FactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
