<?php

namespace Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forms extends Model
{  
    use SoftDeletes;
    protected $table    = 'forms';
    protected $fillable = ['name', 'stock_group_id','type','chatni_report_no'];

    public function gateEntryConfig()
    {
        return $this->hasMany(GateEntryConfig::class, 'form_id');   
    }

    public function modules()
    {   
    	return $this->hasMany(FormModules::class, 'form_id');	
    }

    function hasGateEntryModule($moduleId){
    	return  (Boolean) $this->gateEntryConfig->filter(function($configItem) use ($moduleId){
    		return ($moduleId == $configItem->module_id);
    	})
    	->count();   
    }

}
