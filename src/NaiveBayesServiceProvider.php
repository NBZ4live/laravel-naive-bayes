<?php

namespace Tsuzukit\NaiveBayes;

use Illuminate\Support\ServiceProvider;

class NaiveBayesServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //define the migrations file which are going to be published
        $this->publishes([
            __DIR__.'/../database/migrations/2016_03_17_162226_create_bayes_categories_table.php' => base_path('database/migrations/2016_03_17_162226_create_bayes_categories_table.php'),
            __DIR__.'/../database/migrations/2016_03_17_162439_create_bayes_words_table.php' => base_path('database/migrations/2016_03_17_162439_create_bayes_words_table.php'),
        ], 'NaiveBayse:migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('naive_bayes', function($app)
        {
            return new Classifier();
        });
    }

}