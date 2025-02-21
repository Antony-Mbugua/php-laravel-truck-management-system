<?php

namespace App\Filament\Resources\DispatcherResource\Pages;

use App\Filament\Resources\DispatcherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDispatcher extends EditRecord
{
    protected static string $resource = DispatcherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
