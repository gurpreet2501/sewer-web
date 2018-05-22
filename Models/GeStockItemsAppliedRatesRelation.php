<?php

namespace Models;
use Illuminate\Database\Eloquent\Model;

class GeStockItemsAppliedRatesRelation extends Model
{  
    protected $table    = 'ge_stock_items_applied_rates_relation';
    protected $fillable = ['ge_stock_item_id', 'applied_rates_id'];

}
