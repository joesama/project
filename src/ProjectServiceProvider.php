<?php

namespace Joesama\Project;

use Orchestra\Foundation\Support\Providers\ModuleServiceProvider;

/**
 * Wrapper extension for joesama development.
 *
 * @author joharijumali@gmail.com
 **/
class ProjectServiceProvider extends ModuleServiceProvider
{
    /**
     * The application or extension group namespace.
     *
     * @var string|null
     */
    protected $routeGroup = '';

    /**
     * The fallback route prefix.
     *
     * @var string
     */
    protected $routePrefix = '/';

    /**
     * The application or extension namespace.
     *
     * @var string|null
     */
    protected $namespace = 'Joesama\Project';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 
    ];

    /**
     * The application's or extension's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // 
    ];

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Booting Entree Views, Language, Configuration.
     **/
    protected function bootExtensionComponents()
    {
        $path = realpath(__DIR__.'/../resources');

        $this->addLanguageComponent('joesama/project', 'joesama/project', $path.'/lang');
        $this->addConfigComponent('joesama/project', 'joesama/project', $path.'/config');
        $this->addViewComponent('joesama/project', 'joesama/project', $path.'/views');
    }

    /**
     * Boot extension routing.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        $path = realpath(__DIR__);

        $this->loadFrontendRoutesFrom($path.'/routes.php');
    }

} // END class Entree
