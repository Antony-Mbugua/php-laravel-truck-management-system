<?php

namespace App\Filament\Resources\DriverResource\Pages;

use App\Filament\Resources\DriverResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Hidden;

class CreateDriver extends CreateRecord
{
    protected static string $resource = DriverResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = 'driver'; // Set the role to 'driver'
        return $data;
    }

    protected function getFormSchema(): array
    {
        return [
            // Other form fields...
            Hidden::make('role'), // Hide the role field
        ];
    }
}
