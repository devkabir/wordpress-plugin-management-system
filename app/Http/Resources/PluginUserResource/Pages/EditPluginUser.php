<?php

namespace App\Http\Resources\PluginUserResource\Pages;

use App\Http\Resources\PluginUserResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPluginUser extends EditRecord
{
    protected static string $resource = PluginUserResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
