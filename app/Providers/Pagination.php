<?php

namespace App\Providers;

use Core\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Pagination {

    /**
     * @var LengthAwarePaginator
     */
    public static $paginator;

    /**
     * @var bool
     */
    public static $responseWithPagination = false;

    public function __construct()
    {
        $this->response = new ResponseServiceProvider();
//        $this->paginator = LengthAwarePaginator::class;
    }

    /**
     * @param $items
     * @param int $perPage
     * @param int $currentPage
     * @return array
     */
    public static function make($items, $perPage = 20, $currentPage = 1)
    {
        self::$responseWithPagination = true;

        if (!empty($_GET['page']))
        {
            $currentPage = $_GET['page'];
        }

        if ($items instanceof Model)
        {
            self::$paginator = $items->paginate($perPage, ['*'], 'page', $currentPage);
        }
        else
        {
            self::$paginator = $items->paginate($perPage, ['*'], 'page', $currentPage);
//            $collection = new Collection($items);

//            self::$paginator = new LengthAwarePaginator(
//                $collection->slice(($currentPage - 1) * $perPage, $perPage),
//                $collection->count(),
//                $perPage,
//                $currentPage
//            );
        }

        return self::$paginator->items();
    }

    public static function hydratePagination()
    {
        $paginator = self::$paginator;

        return array(
            'first' => 1,
            'self' => $paginator->currentPage(),
            'next' => self::next(),
            'previous' => self::previous(),
            'last' => $paginator->lastPage(),
            'total' => $paginator->total(),
        );
    }

    private static function next() {
        $next_url = self::$paginator->nextPageUrl();

        if(!$next_url) {
            return null;
        }

        return (int) substr($next_url, strlen($next_url)-1);
    }

    private static function previous() {
        $previous_url = self::$paginator->previousPageUrl();

        if(!$previous_url) {
            return null;
        }

        return (int) substr($previous_url, strlen($previous_url)-1);
    }
}