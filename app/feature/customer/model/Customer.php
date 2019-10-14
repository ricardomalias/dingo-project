<?php


namespace App\feature\customer\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\feature\customer\model\CustomerAddress as CustomerAddress;

class Customer extends Model
{
    protected $table = 'customer';
    public $primaryKey = 'customer_id';
    public $casts = array(
        'customer_id' => 'string',
        'company_id' => 'string',
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

    public function addresses() {
        return $this->hasMany(CustomerAddress::class, "customer_id", "customer_id");
    }

    public function documents() {
        return $this->hasMany(CustomerDocument::class, "customer_id", "customer_id");
    }
}
