<?php


namespace App\feature\debt\model;


use App\database\concerns\GenerateUuid;
use Illuminate\Database\Eloquent\Model;

class DebtNegotiation extends Model
{
    use GenerateUuid;

    protected $table = 'debt_negotiation';
    public $primaryKey = 'debt_negotiation_id';
    public $casts = array(
        'debt_negotiation_id' => 'string',
        'debt_id' => 'string',
        'amount' => 'float',
        'parcel_quantity' => 'integer',
        'payment_method' => 'string',
        'create_date' => 'string',
        'update_date' => 'string',
        'status' => 'integer'
    );

    protected static function boot()
    {
        self::bootUsesUuid();
    }
}