<?php

namespace App\Filament\Dispatcher\Resources\UserResource\Pages;

use App\Filament\Dispatcher\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
