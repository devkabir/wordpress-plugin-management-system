<?php

namespace App\Http\Resources\PluginUserResource\Pages;

use App\Http\Resources\PluginUserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPluginUsers extends ListRecords
{
    protected static string $resource = PluginUserResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New User')
                ->icon('heroicon-s-plus'),
        ];
    }
}
