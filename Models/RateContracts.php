<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\SoftDeletes;
class RateContracts extends Model
{  
    use SoftDeletes; 
    
    protected $fillable = [
        'account_id',
        'from_date',
        'stock_group_id',
        'to_date',
        'status','type'

    ];

    public function contractsStockItems()
    {
        return $this->hasMany(RateContractStockItems::class, 'contract_id', 'id');
    }

    public function stockGroup()
    {
        return $this->hasOne(StockGroups::class, 'id', 'stock_group_id');
    }

    public function account()
    {
        return $this->hasOne(Accounts::class, 'id', 'account_id');
    }

    

     function scopeWhereStockItemId($query, $id){
        return $query->whereHas('contractsStockItems', function ($query) use ($id) {
             $query->where('stock_item_id', $id);
        });
    }

    public function totalWeightTillDate(){
        $wtQuery = "SELECT 
            sum(gmqla.weight_in_kg) as weight
          FROM `ge_material_qc_labour_allocation` as gmqla
          where  
              gmqla.id != 13
              AND gmqla.stock_item_id=1
              AND gmqla.created_at<='2017-08-01 00:00:00'
              AND gmqla.rate_contract_id=1";

        $resultsWtQuery = DB::select($wtQuery);      
    }

    public function updateContractRates($ids){
    
        $sqlIds = implode(',', $ids);

        $contracts = "
        SELECT  
            rcsi.stock_item_id,
            rcsi.rate,
            rcsi.weight,
            rc.account_id,
            rc.id,
            rc.from_date,
            rc.to_date,
            rc.created_at
        FROM `rate_contract_stock_items` as rcsi
        left join rate_contracts as rc on rc.id=rcsi.contract_id";

        $query = "
        SELECT 
            gmqla.id,
            gmqla.stock_item_id,
            gmqla.weight_in_kg,
            ge.id as gate_entry_id,
            ge.account_id,
            ge.first_weight_date, 
            contracts.id as contract_id,   
            contracts.rate,   
            contracts.weight,
            contracts.to_date,
            contracts.created_at
        from 
        ge_material_qc_labour_allocation as `gmqla`
        left join gate_entries as ge 
            on ge.id=gmqla.ge_id
        left join ($contracts) as contracts
            on ge.account_id=contracts.account_id
            AND gmqla.stock_item_id=contracts.stock_item_id
            AND ge.first_weight_date>= contracts.from_date

        where ge.id IN ({$sqlIds}) AND contracts.id IS NOT NULL";
        // where ge.id IN ({$sqlIds}) AND gmqla.rate_contract_id IS NULL AND contracts.id IS NOT NULL";

        $results = DB::select($query);
       
        $contracts = [];
      
        foreach($results as $result){
           
            $contract = [
                'contract_id'  => $result->contract_id,
                'rate'  => $result->rate,
                'weight'    => $result->weight,
                'to_date'   => $result->to_date,
                'created_at'   => $result->created_at,
            ];

            $contractDetails = RateContractStockItems::where('contract_id', $contract['contract_id'])
                  ->where('stock_item_id', $result->stock_item_id)
                  ->first();
               
            $pending_limit = 0.0;      

            $pending_limit = $contractDetails->pendingLimit();      

            if(!is_null($contract['to_date'])){
              if($contract['to_date'] < $result->first_weight_date)
                continue;

            }else if($result->weight_in_kg > $pending_limit){
                continue;
              }  

            $contractDetails->addWeightUsed($result->weight_in_kg);
           
            $table = DB::table('ge_material_qc_labour_allocation')->where('id',$result->id)->update([
                'rate_contract_id' => $contractDetails->contract_id,
                'rate' => $contractDetails->rate
              ]);

        }
        
    }
}
