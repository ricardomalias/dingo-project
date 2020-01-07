<?php


namespace App\feature\CustomerList\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomerListRelationship extends Model
{
    protected $table = 'customer_list_relationship';
    public $primaryKey = 'customer_list_relationship_id';
    public $casts = array(
        'customer_list_relationship_id' => 'string',
        'customer_list_id' => 'string',
        'customer_id' => 'string',
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
