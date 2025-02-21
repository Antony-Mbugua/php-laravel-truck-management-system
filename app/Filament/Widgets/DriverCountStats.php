<?php

namespace App\Filament\Widgets;


use App\Models\Driver;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;

use Filament\Widgets\StatsOverviewWidget\Stat;


class DriverCountStats extends BaseWidget

{

    protected function getStats(): array

    {

        return [

            Stat::make('Total Drivers', Driver::count())

                ->description('Total drivers')

                ->descriptionIcon('heroicon-o-truck')

                ->color('primary'),

        ];

    }

}
