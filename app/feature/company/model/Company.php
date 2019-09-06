<?php

namespace App\feature;

use Illuminate\Database\Eloquent\Model;

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
}
