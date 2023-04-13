<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PhpParser\ParserFactory;
use PhpParser\Parser as PhpParser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PhpParser::class, function ($app) {

            $parserFactory = new ParserFactory();

            return $parserFactory->create(ParserFactory::PREFER_PHP7);
        });
    }
}
