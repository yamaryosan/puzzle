<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Genre;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // サイドバーのジャンル一覧を表示するための処理
        View::composer('partials.sidebar.sidebar', function ($view) {
            $genres = Genre::all();
            $view->with('genres', $genres);
        });
    }
}
