<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Contact;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale(config('app.locale'));
        Schema::defaultStringLength(191);
        $this->SetRouteLang();
        view()->composer(['admin.includes.sidebar'], \App\Views\Composers\NotificationComposer::class);
        view()->composer('*', function ($view) {
            $view->with('active_locale', \App::getLocale());
        });
        view()->composer(['includes.header', 'includes.footer', 'contacts'], function ($view) {
            $view->with('contact', Contact::GetData());
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
