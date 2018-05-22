<?php /**
* 
*/
namespace App\Libs;
class PurchaseReport
{
	
	function __construct($gate_entry)
	{
			auth_force();
			$this->ge = $gate_entry;
	}

	public function getSno(){
		return $this->ge->id.$this->ge->prefix.$this->ge->serial;
	}


	public function getTruckNo(){
		return $this->ge->truck_no;
	}

	public function getDate(){
		return date('Y-m-d', strtotime($this->ge->created_at));
	}

	public function getCommodity(){
		if(!isset($this->ge->godownQcLaborAllocation[0]))
			return '';

		if(!isset($this->ge->godownQcLaborAllocation[0]->StockItems->stockGroup->name))
			return '';

		return $this->ge->godownQcLaborAllocation[0]->StockItems->stockGroup->name;

	}

	public function getPartyName(){

		return isset($this->ge->accounts->name) ? $this->ge->accounts->name : '';
	}

	public function getNetWeight(){
		return $this->ge->net_weight;
	}

	//Swarna, puja ,mota entries
	public function getGodownQcLaborAllocation(){
		
		if(!isset($this->ge->godownQcLaborAllocation))
			return [];	

		$items = [];

		foreach ($this->ge->godownQcLaborAllocation as $key => $v) {
			if(!isset($v->stockItems->name))
				continue;

			if(isset($items[$v->stockItems->name]))
				$items[$v->stockItems->name]= 	$items[$v->stockItems->name] + $v->bags;
			else
				$items[$v->stockItems->name] = $v->bags;
		}
		return $items;
	
	}


	public function getQualityCut(){

	
		if(!isset($this->ge->qualityCuts))
			return [];	

		$items = [];
	
		foreach ($this->ge->qualityCuts as $key => $v) {
			if(!isset($v->qualityCutType->name))
				continue;

			if(isset($items[$v->qualityCutType->name]))
				$items[$v->qualityCutType->name] = 	$items[$v->qualityCutType->name] + $v->bags * $v->qty_per_bag;
			else
				$items[$v->qualityCutType->name] = $v->bags * $v->qty_per_bag;
			
		}
	
		return $items;
		
	}

	public function getBagTypes(){
		
		if(!isset($this->ge->bagTypes))
			return [];

		$items = [];

		foreach ($this->ge->bagTypes as $key => $v) {
			if(!isset($v->stockItem->name))
				continue;

			if(isset($items[$v->stockItem->name]))
				$items[$v->stockItem->name] = 	$items[$v->stockItem->name] + $v->bags;
			else
				$items[$v->stockItem->name] = $v->bags;
		}
		return $items;
	
	}

	public function getMsno(){
		if(!isset($this->ge->cmrDetails[0]))
			return '';

		return isset($this->ge->cmrDetails[0]->m_serial_no) ? $this->ge->cmrDetails[0]->m_serial_no : '';
	}

	public function getMarket(){
		if(!isset($this->ge->cmrDetails[0]))
			return '';
			
		return isset($this->ge->cmrDetails[0]->market->name)? $this->ge->cmrDetails[0]->market->name : '';
		
	}

	public function getSociety(){

		if(!isset($this->ge->cmrDetails[0]))
			return '';
		
		return isset($this->ge->cmrDetails[0]->society->name)? $this->ge->cmrDetails[0]->society->name : '';
	}

	public function getAcNote(){
		if(!isset($this->ge->cmrDetails[0]))
			return '';
		
		return isset($this->ge->cmrDetails[0]->ac_note_no)? $this->ge->cmrDetails[0]->ac_note_no : '';
		
	}

	public function getTpNo(){

		if(!isset($this->ge->cmrDetails[0]))
			return '';
		
		return isset($this->ge->cmrDetails[0]->tp_no)? $this->ge->cmrDetails[0]->tp_no : '';
		
	}

	public function getTotalBags(){
		if(!isset($this->ge->bagTypes))
			return 0;
		
		$total = 0;
		
		foreach ($this->ge->bagTypes as $key => $v) 
			$total = $total + $v->bags;
		
		return $total;	
	}

	public function getReport(){

		$data = [
			'S.No.' => $this->getSno(),
			'Date' => $this->getDate(),
			'Party Name' => $this->getPartyName(),
			'Truck No.' => $this->getTruckNo(),
			'Weight (In Kg)' => $this->getNetWeight(), //Net WEight
		];
		$keys = [
			'godownQcLaborAllocation' => [],
			'QualityCut' =>[],
			'BagTypes' =>[]
		];

		if(count($this->getGodownQcLaborAllocation())){
			$keys['godownQcLaborAllocation'] = array_merge($keys['godownQcLaborAllocation'],array_keys($this->getGodownQcLaborAllocation()));
			$data = array_merge($data,$this->getGodownQcLaborAllocation());
		}
		if(count($this->getQualityCut())){
			$keys['QualityCut'] = array_merge($keys['QualityCut'],array_keys($this->getQualityCut()));
			$data = array_merge($data,$this->getQualityCut());
		}
		if(count($this->getBagTypes())){
			$keys['BagTypes'] = array_merge($keys['BagTypes'],array_keys($this->getBagTypes()));
			$data = array_merge($data, $this->getBagTypes());
		}

		$data['M. Sno.'] = $this->getMsno(); 
		$data['Commodity'] = $this->getCommodity(); 
		$data['Market'] = $this->getMarket(); 
		$data['Society'] = $this->getSociety(); 
		$data['AC Note'] = $this->getAcNote(); 
		$data['TP Note'] = $this->getTpNo(); 
		$data['Bags'] = $this->getTotalBags(); 

		return [$data,$keys];
		
	}


} 
