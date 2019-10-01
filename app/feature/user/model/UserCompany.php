<?php

namespace App\feature\user\model;


use App\database\concerns\GenerateUuid;
use App\feature\Company;
use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    use GenerateUuid;

    protected $table = 'user_company';
    public $primaryKey = 'user_company_id';
    public $casts = array(
        'user_company_id' => 'string',
        'user_id' => 'string',
        'company_id' => 'string',
        'create_date' => 'string',
        'update_date' => 'string',
        'status' => 'integer'
    );

    protected static function boot()
    {
        self::bootUsesUuid();
    }

//    public function user()
//    {
//        return $this->belongsTo(User::class, "user_id", "user_company_id");
//    }

    public function company()
    {
        return $this->belongsTo(Company::class, "company_id", "company_id");
    }
}