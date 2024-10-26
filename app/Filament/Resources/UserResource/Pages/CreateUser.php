<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Services\AuthService;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function mutateFormDataBeforeCreate(array $data): array {
        $data['password'] = AuthService::hash($data["password"]);
        return $data;
    }
}
