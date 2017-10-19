<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Contact;
use App\DefaultSize;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        setlocale(LC_TIME, config('app.locale').'_'.strtoupper(config('app.locale')).'.utf8');
        Schema::defaultStringLength(191);
        $this->SetRouteLang();
        view()->composer(['admin.includes.sidebar'], \App\Views\Composers\NotificationComposer::class);
        view()->composer('*', function ($view) {
            $view->with('active_locale', \App::getLocale());
        });
        view()->composer(['includes.header', 'includes.footer', 'contacts'], function ($view) {
            $view->with('contact', Contact::PuclicGetData());
        });
        view()->composer('print', function ($view) {
            $view->with('sizes', DefaultSize::GetItemsStatic());
        });
    }

    public function SetRouteLang() {
        $language = \Request::segment(1);
        $route_lang = '';
        if (isset(config('app.locales')[$language])) {
            \App::setLocale($language);
            $route_lang = $language;
        }

        \Config::set('route_lang', $route_lang);
    }
}
