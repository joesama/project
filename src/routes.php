<?php

use Illuminate\Routing\Router;
use Orchestra\Support\Facades\Foundation;

Foundation::group('joesama/project', '/', ['namespace' => 'Http\Controller', 'middleware' => ['web']], function (Router $router) {

    $router->group(['middleware' => ['auth']], function ($router) {

    	$router->get('portfolio', 'DashboardController@projectPorfolio');
    	$router->get('subsidiaries', 'DashboardController@projectSubs');
    	$router->get('dashboard', 'DashboardController@projectDashboard');
        $router->group(['prefix' => 'project'], function ($router) {
            $router->get('/{part}/{id}/{app?}', 'ProjectController@projectInformation');
    	});
        $router->group(['prefix' => 'report'], function ($router) {
            $router->get('/project/{id}', 'ReportController@projectReport');
            $router->get('/format/{id}/{report?}', 'ReportController@reportFormat');
    	});

    });

});