<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('vendor.pagination.bootstrap-4');

        \Form::macro("booleanbox", function($name, $value = 1, $checked = null, $options = array()){
            return $this->toHtmlString("<input type=\"hidden\" name=\"{$name}\" value=\"0\">". \Form::checkbox($name, $value, $checked, $options));
        });

    }
}
