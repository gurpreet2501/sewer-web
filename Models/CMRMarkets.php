<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class CMRMarkets extends Model
{
    protected $table    = 'cmr_markets';
    protected $fillable = ['name','cmr_society_id'];

    function market()
    {
    	return $this->hasOne(CMRMarkets::class, 'id', 'cmr_market_id');
    }

}
