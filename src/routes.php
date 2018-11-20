<?php

use Illuminate\Routing\Router;
use Orchestra\Support\Facades\Foundation;

Foundation::group('joesama/project', '/', ['namespace' => 'Http\Controller', 'middleware' => ['web']], function (Router $router) {

    $router->group(['middleware' => ['auth']], function ($router) {

    	$router->get('dashboard', 'DashboardController@projectDashboard');
        $router->group(['prefix' => 'project'], function ($router) {
            $router->get('/info/{id?}', 'ProjectController@projectInformation');
    	});

    });

});