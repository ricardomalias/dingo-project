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

            if(Pagination::$responseWithPagination
                && !array_key_exists('links', $customFormat))
            {
                $customFormat['links'] = Pagination::hydratePagination();
            }

            return $factory->make($customFormat);
        });
    }

    public function register()
    {
        //
    }
}
