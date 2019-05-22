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
        'entree.menu:ready' => [
            'Joesama\Project\Events\Handlers\MenuHandler'
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'Joesama\Project\Events\Subscriber\UserEventSubscriber',
    ];

    /**
     * The application's or extension's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        Orchestra\Messages\Http\Middleware\StoreMessageBag::class
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

        $this->publishes([
            $path.'/views/components/shortcut.blade.php' => resource_path('views/joesama/entree/layouts/menu/shortcut.blade.php'),
        ], 'views');

        $this->publishes([
            $path.'/views/components/mailing.blade.php' => resource_path('views/joesama/entree/layouts/themes/mailing.blade.php'),
        ], 'views');
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
