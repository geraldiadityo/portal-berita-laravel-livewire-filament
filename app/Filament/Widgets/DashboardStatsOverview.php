<?php

namespace App\Filament\Widgets;

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class DashboardStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '30s';
    protected function getStats(): array
    {
        $user = Auth::user();
        if ($user->role === 'admin' || $user->role === 'editor') {
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

        if ($user->role === 'author') {
            return [
                Stat::make('Artikel Publish', Article::where('author_id', $user->id)->where('status', 'publish')->count())
                    ->description('Article Published')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('success'),

                Stat::make('Article Review', Article::where('author_id', $user->id)->where('status', ArticleStatus::PENDING_REVIEW)->count())
                    ->description('Article On Review')
                    ->descriptionIcon('heroicon-m-clock')
                    ->color('warning'),

                Stat::make('Article Draf', Article::where('author_id', $user->id)->where('status', ArticleStatus::DRAF)->count())
                    ->description('Article Draf')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('info'),
            ];
        }

        return [];
    }
}
