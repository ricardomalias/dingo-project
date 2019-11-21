<?php


namespace App\feature\debt\model;


use App\database\concerns\GenerateUuid;
use Illuminate\Database\Eloquent\Model;

class DebtDiscount extends Model
{
    use GenerateUuid;

    protected $table = 'debt_discount';
    public $primaryKey = 'debt_discount_id';
    public $casts = array(
        'debt_discount_id' => 'string',
        'debt_id' => 'string',
        'due_date' => 'date',
        'type' => 'string',
        'value' => 'decimal',
        'create_date' => 'string',
        'update_date' => 'string',
        'status' => 'integer'
    );

    protected static function boot()
    {
        self::bootUsesUuid();
    }
}