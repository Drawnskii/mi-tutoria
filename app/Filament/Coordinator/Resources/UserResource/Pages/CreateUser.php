<?php

namespace App\Filament\Coordinator\Resources\UserResource\Pages;

use App\Filament\Coordinator\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}
