<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GEStockItems extends Model
{
    protected $table = 'ge_stock_items';
    protected $fillable = ['ge_id','stock_item_id','bags','rate_contract_id','rate','weight_unit'];

     function gateEntry(){
     	return $this->belongsTo(GateEntry::class, 'ge_id', 'id');
    }

    function stockItem(){
      return $this->belongsTo(StockItems::class, 'stock_item_id', 'id');
    }

}
