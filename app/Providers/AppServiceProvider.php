<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'me' => 'App\Models\Me',
            'season' => 'App\Models\Season',
        ]);

        Str::macro('clean', function (string $value) {
            $string = preg_replace('/[\s]+/u', '', $value); // Replaces all spaces with underscore.
            $string = strtolower($string);
            return preg_replace('/[^A-Za-z0-9\_]/', '', $string); // Removes special chars.
		});

		Stringable::macro('clean', function () {
            $string = preg_replace('/[\s]+/u', '', $this->value); // Replaces all spaces with underscore.
            $string = strtolower($string);
			return new Stringable(preg_replace('/[^A-Za-z0-9\_]/', '', $string));
		});
    }
}
