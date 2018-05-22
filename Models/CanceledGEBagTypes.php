<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class CanceledGEBagTypes extends Model
{
    protected $table = 'canceled_ge_bag_types';
    protected $fillable = ['ge_id','stock_item_id','bags'];

     function stockItem(){
      return $this->belongsTo(StockItems::class, 'stock_item_id', 'id');
    }
}
