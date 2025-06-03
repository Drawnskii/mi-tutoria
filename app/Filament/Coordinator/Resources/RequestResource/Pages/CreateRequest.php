<?php

namespace App\Filament\Coordinator\Resources\RequestResource\Pages;

use App\Filament\Coordinator\Resources\RequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRequest extends CreateRecord
{
    protected static string $resource = RequestResource::class;
}
