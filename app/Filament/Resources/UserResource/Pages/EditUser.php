<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Services\AuthService;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function mutateFormDataBeforeSave(array $data): array {
        $data['password'] = AuthService::hash($data["password"]);
        return $data;
    }
}
