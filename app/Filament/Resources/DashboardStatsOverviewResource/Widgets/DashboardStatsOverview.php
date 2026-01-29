<?php

namespace App\Filament\Resources\DashboardStatsOverviewResource\Widgets;

use App\Models\Article;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            //
            Stat::make('Total Penulis', User::where('role', 'author')->count())
                ->description('Author')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Artikel Publish', Article::where('status', 'publish')->count())
                ->description('Artikel yang telah publish')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make('Total Artikel Unpublish', Article::where('status', '!=', 'publish')->count())
                ->description('Artikel unpublished')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
        ];
    }
}
