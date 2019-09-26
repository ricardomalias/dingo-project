<?php

namespace App\feature\debt\model;

use App\database\concerns\GenerateUuid;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use GenerateUuid;

    protected $table = 'debt';
    public $primaryKey = 'debt_id';
    public $casts = array(
        'debt_id' => 'string',
        'company_id' => 'string',
        'amount' => 'float',
        'parcel_quantity' => 'integer',
        'due_date' => 'date',
        'create_date' => 'string',
        'update_date' => 'string',
        'status' => 'integer'
    );

    protected static function boot()
    {
        self::bootUsesUuid();
    }
}
