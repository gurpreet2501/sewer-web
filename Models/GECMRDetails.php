<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;
use Illuminate\Database\Capsule\Manager as DB;

class GECMRDetails extends Model 
{
    protected $table    = 'ge_cmr_details';
    protected $fillable = ['account_id','cmr_agency_id','cmr_market_id','truck_no','tp_no','tp_date','ac_note_no','ac_note_date','quintals','no_of_bags','m_serial_no','cmr_society_id'];


    function market()
    {
    	return $this->hasOne(CMRMarkets::class, 'id', 'cmr_market_id');
    }
  
    function society()
    {
    	return $this->hasOne(CMRSocieties::class, 'id', 'cmr_society_id');
    }

    static function uniqueMSerialNo(){

        $res = DB::select("SELECT max(CAST(m_serial_no AS SIGNED)) as m_serial_no FROM `ge_cmr_details` ORDER BY `m_serial_no` ASC");        
               
        if ($res[0]->m_serial_no >= 1)        
            return $res[0]->m_serial_no + 1;
        else
            return 1;
    }
  





}
