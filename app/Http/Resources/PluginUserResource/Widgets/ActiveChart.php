<?php

namespace App\Http\Resources\PluginUserResource\Widgets;

use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\DB;

class ActiveChart extends LineChartWidget
{
    protected static ?string $heading = 'Activation';

    protected function getFilters(): ?array
    {
        return DB::table('plugin_users')
            ->select('name')
            ->groupBy('name')
            ->orderBy('name')
            ->get()
            ->pluck('name', 'name')
            ->toArray();
    }

    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $chart = DB::table('plugin_users')
            ->select(DB::raw("DATE_FORMAT(activated_at, '%m') AS month, SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS activate_count, SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) AS deactivate_count"))
            ->whereYear('activated_at', DB::raw('YEAR(CURRENT_DATE)'))
            ->where('activated_at', '>=', DB::raw("DATE_FORMAT(DATE_SUB(CURRENT_DATE, INTERVAL 6 MONTH), '%Y-%m-01')"))
            ->groupBy('month')
            ->when($activeFilter, function ($q) use ($activeFilter) {
                return $q->where('name', '=', $activeFilter);
            })
            ->orderBy('month')
            ->get();


        return [
            'datasets' => [
                [
                    'label' => 'Active',
                    'data' => $chart->pluck('activate_count'),
                    'borderColor' => '#4ade80'
                ],
                [
                    'label' => 'Deactivate',
                    'data' => $chart->pluck('deactivate_count'),
                    'borderColor' => '#f87171'
                ],
            ],
            'labels' => $chart->pluck('month'),
        ];
    }
}
