<?php
namespace App\feature\company\model;
use Illuminate\Database\Eloquent\Model;

class CompanyDocument extends Model
{
    protected $table = 'company_document';
    public $primaryKey = 'company_document_id';
    public $casts = array(
        'company_document_id' => 'string',
        'company_id' => 'string',
        'type' => 'string',
        'value' => 'string',
        'create_date' => 'string',
        'update_date' => 'string',
        'status' => 'integer'
    );
}
