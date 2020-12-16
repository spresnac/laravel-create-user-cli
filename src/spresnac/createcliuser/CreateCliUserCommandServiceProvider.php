<?php

namespace spresnac\createcliuser;

use Illuminate\Support\ServiceProvider;

class CreateCliUserCommandServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateCliUserCommand::class,
            ]);
        }
    }
}
