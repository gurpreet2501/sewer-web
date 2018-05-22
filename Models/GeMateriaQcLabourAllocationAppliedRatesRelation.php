<?php

namespace Models;
use Illuminate\Database\Eloquent\Model;

class GeMateriaQcLabourAllocationAppliedRatesRelation extends Model
{  
    protected $table    = 'ge_material_qc_labour_allocation_applied_rates_relation';
    protected $fillable = ['ge_material_qc_labour_allocation_id', 'applied_rates_id'];

}
