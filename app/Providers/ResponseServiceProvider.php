<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;

class ResponseServiceProvider extends ServiceProvider
{
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('api', function ($data) use ($factory) {

            $customFormat = [
                'count' => count($data),
                'data' => $data
            ];
            return $factory->make($customFormat);
        });
    }

    public function register()
    {
        //
    }
}
