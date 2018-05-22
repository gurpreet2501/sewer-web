<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class BagTypes extends Model
{
    protected $table    = 'bag_types';
    protected $fillable = ['id','name'];
     function stockItem(){
      return $this->belongsTo(StockItems::class, 'stock_item_id', 'id');
    }
}
