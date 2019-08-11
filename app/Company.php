<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';
	protected $primaryKey = 'company_id';
	protected $casts = array(
        'company_id' => 'integer',
        'name' => 'string',
        'create_date' => 'string',
        'update_date' => 'string',
        'status' => 'integer'
    );
}
