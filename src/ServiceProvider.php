<?php
/**
 * Created by PhpStorm.
 * User: Small_K
 * Date: 2019/1/2
 * Time: 9:15
 */

namespace Smallk\Weather;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Weather::class, function () {
            return new Weather(config('services.weather.key'));
        });
        $this->app->alias(Weather::class, 'weather');
    }

    public function provides()
    {
        return [Weather::class, 'weather'];
    }
}