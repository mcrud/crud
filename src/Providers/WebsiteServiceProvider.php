<?php

namespace mcrud\crud\Providers ;
use mcrud\crud\Commands\crud;
use mcrud\crud\Commands\tables;

use Illuminate\Support\ServiceProvider;
class WebsiteServiceProvider extends ServiceProvider
{
    public function boot() {
      //  dd('retger');
    }

    public function register(){
        $this->app->singleton('create.db', function ($app) {
            return new crud();
        });
        $this->app->singleton('make.crud', function ($app) {
            return new tables();
        });
        $this->commands([
            'make.crud',
            'create.db']);
    }
}

?>
