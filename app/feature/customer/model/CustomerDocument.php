<?php


namespace App\feature\customer\model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomerDocument extends Model
{
    protected $table = 'customer_document';
    public $primaryKey = 'customer_document_id';
    public $casts = array(
        'customer_document_id' => 'string',
        'customer_id' => 'string',
        'type' => 'string',
        'value' => 'string',
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