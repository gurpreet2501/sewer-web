<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class LabourJobCategoryAccountsRelation extends Model
{
    protected $table    = 'labour_job_category_accounts_relation';
    protected $fillable = ['labour_job_category_id','account_id'];

    function labourCategories(){
    	 return $this->hasOne(LabourJobCategories::class,'id','labour_job_category_id');
    }
}
