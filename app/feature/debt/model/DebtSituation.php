<?php


namespace App\feature\debt\model;


use App\database\concerns\GenerateUuid;
use Illuminate\Database\Eloquent\Model;

class DebtSituation extends Model
{
    use GenerateUuid;

    protected $table = 'debt_situation';
    public $primaryKey = 'debt_situation_id';
    public $casts = array(
        'debt_situation_id' => 'string',
        'debt_id' => 'string',
        'situation' => 'string',
        'create_date' => 'string',
        'update_date' => 'string',
        'status' => 'integer'
    );

    protected static function boot()
    {
        self::bootUsesUuid();
    }
}
