<?php


namespace App\Providers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

class BaseControllerProvider extends Controller
{
    use Helpers;

    public function boot()
    {
        $this->app['Dingo\Api\Transformer\Factory']->setAdapter(function ($app) {
            return new Dingo\Api\Transformer\Adapter\Fractal(new League\Fractal\Manager, 'include', ',');
        });
    }

}