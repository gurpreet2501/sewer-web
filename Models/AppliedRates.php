<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class AppliedRates extends Model
{
	protected $table    = 'applied_rates';
    protected $fillable = ['contract_id','rate'];
}
