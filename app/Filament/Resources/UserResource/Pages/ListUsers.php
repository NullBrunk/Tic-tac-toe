<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            "all" => Tab::make()
                ->icon('heroicon-m-user')
                ->badge(User::query()->count()),

            "Active" => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_banned', false))
                ->icon('heroicon-m-user-plus')
                ->badgeColor("success")
                ->badge(User::query()->where('is_banned', false)->count()),

            "banned" => Tab::make()
                ->icon('heroicon-m-user-minus')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_banned', true))
                ->badgeColor("danger")
                ->badge(User::query()->where('is_banned', true)->count()),
        ];
    }
}
