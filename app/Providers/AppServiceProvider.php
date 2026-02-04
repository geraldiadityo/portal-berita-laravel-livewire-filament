<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Category;
use App\Observers\ArticleObserver;
use App\Observers\CategoryObserver;
use App\Repositories\SettingRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(SettingRepository $settingRepository): void
    {
        //
        View::composer('*', function ($view) use ($settingRepository) {
            $view->with('settings', (object) $settingRepository->getAll());
        });
        Article::observe(ArticleObserver::class);
        Category::observe(CategoryObserver::class);
        Model::preventLazyLoading(! app()->isProduction());
    }
}
