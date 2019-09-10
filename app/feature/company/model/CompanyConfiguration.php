<?php


namespace App\feature\company\model;


use Illuminate\Database\Eloquent\Model;

class CompanyConfiguration extends Model
{
    protected $table = 'company_configuration';
    public $primaryKey = 'company_configuration_id';
    public $casts = array(
        'company_configuration_id' => 'string',
        'company_id' => 'string',
        'key' => 'string',
        'value' => 'string',
        'create_date' => 'string',
        'update_date' => 'string',
        'status' => 'integer'
    );
}