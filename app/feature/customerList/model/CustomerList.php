<?php


namespace App\feature\CustomerList\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\feature\customer\model\Customer;

class CustomerList extends Model
{
    protected $table = 'customer_list';

    public $primaryKey = 'customer_list_id';
    protected $hidden = ['pivot'];
    public $casts = array(
        'customer_list_id' => 'string',
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

    public function customers() {
        return $this->belongsToMany(Customer::class, 'customer_list_relationship', 'customer_list_id', 'customer_id')
            ->where("customer_list_relationship.status", "=", "1");
    }
}
