<?php

namespace App\feature;

use App\database\concerns\GenerateUuid;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use GenerateUuid;

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
        self::bootUsesUuid();
    }
}
