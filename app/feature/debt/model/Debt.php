<?php

namespace App\feature\debt\model;

use App\database\concerns\GenerateUuid;
use App\feature\customer\model\Customer;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use GenerateUuid;

    protected $table = 'debt';
    public $primaryKey = 'debt_id';
    public $casts = array(
        'debt_id' => 'string',
        'customer_id' => 'string',
        'amount' => 'float',
        'parcel_quantity' => 'integer',
        'create_date' => 'string',
        'update_date' => 'string',
        'status' => 'integer'
    );

    protected static function boot()
    {
        self::bootUsesUuid();
    }

    public function situation() {
        return $this->hasOne(DebtSituation::class, "debt_id", "debt_id")
            ->where("debt_situation.status", "=", "1");
    }

    public function discounts() {
        return $this->hasMany(DebtDiscount::class, "debt_id", "debt_id")
            ->where("debt_discount.status", "=", "1");
    }
}
