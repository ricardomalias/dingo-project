<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ResponseServiceProvider extends ServiceProvider
{
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('api', function ($data) use ($factory) {

            if(empty($data)) {
                throw new HttpException("404");
            }

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
