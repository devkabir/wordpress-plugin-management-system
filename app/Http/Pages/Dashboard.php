<?php

namespace App\Http\Pages;

use App\Http\Resources\PluginUserResource\Widgets\ActiveChart;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    protected function getHeaderWidgets(): array
    {
        return [ActiveChart::class];
    }
}
