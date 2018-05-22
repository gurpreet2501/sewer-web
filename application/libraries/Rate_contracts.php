<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rate_contracts
{	

	// from date should be same ?
	// account should be same  => AAR Tech Engine
	// if date range 
	// should be in date 
	// quantity
	// if (QUINTALS) then count weight 
	// if BAG count bags in case max out 
	// get contract price

	private $record = [];
	private $inputSource = [];


	/**
	 * @var integer $accountId
	 * @var integer $stockItemId
	 * @var string  $fromDate start date of contract
	 * @var integer $quantity number of bags/quantiles
	 * @var string  $unit should be BAGS or quantiles
	 * @var string  $toDate (optional) End Date of contract 
	 */
	public function getRate($accountId, $stockItemId, $fromDate, $unit, $inputSource, $toDate = null)
	{
		$record = $this->findContracts($accountId, $stockItemId, $fromDate, $toDate);
		if (empty($record))
			return null;

		$this->record 	   = $record;
		$this->inputSource = $inputSource;


		// if toDate is present the contract is based on date. 
		// so we dont need to check wight limit or bag limit.
		if (!empty($toDate))
			return $this->buildResp();

		return $this->checkCount($stockItemId, $unit, $inputSource);
	}

	private function findContracts($accountId, $stockItemId, $fromDate, $toDate = null)
	{
		if (empty($accountId) || empty($fromDate))
			return null;

		$rateContracts = Models\RateContracts::where('account_id', $accountId)->where('from_date', '<=', $fromDate);

		if (!empty($toDate))
		{
			$rateContracts->where('to_date', '=>', $toDate);
		}

		$rateContracts->with('contractsStockItems');

		$ret = null;
		foreach ($rateContracts->get()->toArray() as $items) 
		{
			foreach ($items['contracts_stock_items'] as $item)
			{
				if ($item['stock_item_id'] == $stockItemId)
				{
					$ret = [
						'contract_row' 		 => $items,
						'matched_stock_item' => $item,
					];

					break;
				}
			}
		}

		return $ret;
	}

	public function getContracts($accountId, $stockItemId, $fromDate, $quantity=null)
	{  

		
		if (empty($accountId) || empty($fromDate))
			return null;

		$rateContracts = Models\RateContracts::where('account_id', $accountId)->where('from_date', '<=', $fromDate)->where('quantity', 0.00);
		
		$rateContracts = $rateContracts->whereStockItemId($stockItemId)->with('contractsStockItems');
		
	    if(count($rateContracts->get()))
	    	return $rateContracts->get()->toArray();

	    return $this->getQuantityRateContract($accountId, $stockItemId, $fromDate, $quantity);

	}

	function getQuantityRateContract($accountId, $stockItemId,$fromDate, $itemQty){
		$rcQuantity = 0;
		$rateContracts = Models\RateContracts::where('account_id', $accountId)
											  ->where('from_date', '<=', $fromDate)
											  ->where('quantity', '!=', 0.00)
											  ->whereStockItemId($stockItemId)
											  ->with('contractsStockItems')->get();
		
		foreach($rateContracts as $rc){

			if(!count($rc))
			  return [];

		  $rcQuantity = $rc->quantity;
		}
		
        if($this->getStockItemTotalForAccount($accountId,$stockItemId,$itemQty,$rcQuantity))
        	return $rateContracts->toArray();

        return false;

	}

	function getStockItemTotalForAccount($accountId,$stockItemId,$itemQty,$rcQuantity){

		$ges = Models\GateEntry::where('account_id', $accountId)->with('stockItems')->get();
		$total = 0;
		foreach($ges as $ge)
			foreach ($ge->stockItems as $key => $item) {
				if($stockItemId == $item->id){
				  $total = $total + $item->bags;
				}
			}

		$totalQty = $total+$itemQty;

		if($totalQty <= $rcQuantity)		
			return true;

		return false;
	
	}

	public function buildResp()
	{
		extract($this->record);
		return [
			'contract_id' => $matched_stock_item['contract_id'],
			'rate' 	      => $matched_stock_item['rate'],
		];
	}

	private function checkCount($stockItemId, $unit)
	{

		$contract = $this->record['contract_row'];
		logErrors('undefined index unit',__FILE__,__LINE__, func_get_args());

		if ($unit !== 'BAGS')
			return null;

		if(isset($contract['unit']))
			if ($contract['unit'] !== $unit)
				return null;			
	
		if ($this->inputSource  === 'GE_STOCK_ITEMS')
			$count = Models\GEStockItems::where('stock_item_id', $stockItemId)->get()->sum('bags');
		
		elseif ($this->inputSource === 'GE_LABOR_ALLOCATION')
			$count = Models\GEGodownQcLaborAllocation::where('stock_item_id', $stockItemId)->get()->sum('bags');
		else
			return null;
		if(isset($contract['quantity']))
			if ($count <= intval($contract['quantity']))
				return $this->buildResp();

		return null;
	}
  
}
