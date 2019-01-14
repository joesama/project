<?php

use Illuminate\Routing\Router;
use Orchestra\Support\Facades\Foundation;

Foundation::group('joesama/project', '/', ['namespace' => 'Http\Controller', 'middleware' => ['web']], function (Router $router) {

    $webPolicies = collect(config('packages/joesama/project/policy'))->get('web');
    $apiPolicies = collect(config('packages/joesama/project/policy'))->get('api');

    $router->group(['middleware' => ['auth', 'entree']], function ($router) use($webPolicies){

        $router->get('portfolio', 'DashboardController@projectPorfolio');
        $router->get('subsidiaries', 'DashboardController@projectSubs');
        $router->get('dashboard', 'DashboardController@projectDashboard');

        collect($webPolicies)->each(function($policy,$module) use($router){
            collect($policy)->except('icon')->each(function($config,$submodule) use($module,$router){
                $router->name($module.'.'.$submodule.'.')
                ->prefix($module.'/'.$submodule)
                ->namespace(ucfirst($module))
                ->group(function ($router) use($module,$submodule,$config){

                    foreach($config as $page => $id){
                        if('no_menu' != $page){
                            $params = collect($id)->map(function($param){
                                return sprintf('{%s}', $param);
                            })->implode('/');
                            $router->name($page)->get(
                                $page.'/'.$params, 
                                ucfirst($submodule).'Controller'
                            );
                        }
                    }
                });
            });
        });
    });

    $router->group(['middleware' => ['api']], function ($router) use($apiPolicies){
        collect($apiPolicies)->each(function($api,$method) use($router){
            collect($api)->each(function($apiPolicy,$apiModule) use($method,$router){
                collect($apiPolicy)->each(function($apiConfig,$apiSubmodule) use($method,$apiModule,$router){

                    $router->name('api.'.$apiModule.'.')->prefix('api/'.$apiModule)
                    ->group(function ($router) use($method,$apiSubmodule,$apiConfig){

                        $params = collect($apiConfig)->map(function($param){
                            return sprintf('{%s}', $param);
                        })->implode('/');
                        $router->{strtolower($method)}(
                            $apiSubmodule.'/'.$params, 
                            'Api\\ApiController'
                        )->name($apiSubmodule);
                    });
                });
            });
        });
    });

});