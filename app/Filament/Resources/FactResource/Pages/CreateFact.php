<?php

namespace App\Filament\Resources\FactResource\Pages;

use App\Filament\Resources\FactResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFact extends CreateRecord
{

    use CreateRecord\Concerns\Translatable;

    protected static string $resource = FactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            // ...
        ];
    }
}
