<?php

namespace App\feature;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Company extends Model
{
    protected $table = 'company';
	protected $primaryKey = 'company_id';
	protected $casts = array(
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
            $item->{$item->primaryKey} = (string) Str::uuid();
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
