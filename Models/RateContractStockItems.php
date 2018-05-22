<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class RateContractStockItems extends Model
{
    protected $fillable = [
        'contract_id',
        'stock_item_id',
        'rate',
        'weight',
        'used_weight'
    ];

    public function stockItem()
    {
        return $this->hasOne(StockItems::class, 'id', 'stock_item_id');
    }

    public static function contractsStockItems()
    {
    	return self::where('transaction_type', 'DEBIT')->sum('amount');
    }

    public function pendingLimit(){
        return round($this->weight - $this->used_weight,4);
    }

    public function addWeightUsed($wt){
         $this->used_weight +=  $wt;
         $this->save();
    }
}
