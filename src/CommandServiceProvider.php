<?php

namespace Joesama\Project;

use Orchestra\Support\Providers\CommandServiceProvider as ServiceProvider;

class CommandServiceProvider  extends ServiceProvider
{
	/**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
    	'MockData' => 'joesama.project.commands.mockingdata'
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    protected function registerMockDataCommand(): void
    {
        $this->app->singleton('joesama.project.commands.mockingdata', function () {
            return new Commands\MockCorporateData();
        });
    }

} 