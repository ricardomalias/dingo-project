<?php


namespace App\feature\customer\model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomerAddress extends Model
{
    protected $table = 'customer_address';
    public $primaryKey = 'customer_address_id';
    public $casts = array(
        'customer_address_id' => 'string',
        'customer_id' => 'string',
        'zip_code' => 'string',
        'address' => 'string',
        'number' => 'string',
        'city' => 'string',
        'state' => 'string',
        'country' => 'string',
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
