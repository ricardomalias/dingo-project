<?php


namespace App\feature\customer\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';
    protected $casts = array(
        'customer_id' => 'string',
        'name' => 'string',
        'create_date' => 'string',
        'update_date' => 'string',
        'status' => 'integer'
    );

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $item->{$item->primaryKey} = (string)Str::uuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
