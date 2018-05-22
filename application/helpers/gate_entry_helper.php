<?php  

function common_fields_autofill($id=null){

	if(!$id)
		return [
			'account_id' => '',
			'truck_no' => '',
			'loaded_weight' => '',
			'tare_weight' => ''
		]; 

	 $result = Models\GateEntry::where('id', $id)->first();		

		return [
		  'id' => $id,
			'account_id' => $result->account_id,
			'truck_no' => $result->truck_no,
			'loaded_weight' => $result->loaded_weight,
			'tare_weight' => $result->tare_weight
		];

}

function get_account_name($id){
	 $result = Models\Accounts::where('id', $id)->first();		
	 if(empty($result))
	 	return 'Unknown';
	 
	 return $result->name;

}

function get_stock_group_name($id){
	 $result = Models\StockGroups::where('id', $id)->first();		
	 if(!count($result))
	 	return 'Unknown';
	 
	 return $result->name;
}

function calculate_weight_per_bag($id){
	 $net_weight = 0.0;	
	 
	 $gateEntry = Models\GateEntry::select('net_weight')->where('id',$id)->first();
	 
	 $result = Models\GEGodownQcLaborAllocation::where('ge_id', $id)->with('stockItems')->get();
		
	 if(!count($result))
	 	return 0.00;
   
   $net_weight = $gateEntry->net_weight;
  

	 $total_bags = 0;
	 foreach ($result as $key => $val) {
	 	$total_bags = $total_bags + $val->bags;
	 }
	
   //Weight per bag
	 return ($net_weight/$total_bags);
}

function bindSerialAndPrefix($data){
	
	if($data['entry_type'] == 'IN'){
		
		$data['prefix'] = 'MI';
		$max_serial = intval(Models\GateEntry::where('entry_type','IN')->max('serial'));
		$canceled_max_serial = Models\CanceledGateEntry::where('entry_type','IN')->max('serial');
		
		if($max_serial > $canceled_max_serial)
			$data['serial'] = $max_serial + 1;
		else if($max_serial < $canceled_max_serial)
			$data['serial'] = $canceled_max_serial + 1;
		else
			$data['serial'] = 1;

	}
	else{

		$data['prefix'] = 'MO';
		$max_out_serial = intval(Models\GateEntry::where('entry_type','OUT')->max('serial'));
		$canceled_max_out_serial = intval(Models\CanceledGateEntry::where('entry_type','OUT')->max('serial'));
	

		if($max_out_serial > $canceled_max_out_serial)
			$data['serial'] = $max_out_serial + 1;
		else if($max_out_serial < $canceled_max_out_serial)
			$data['serial'] = $canceled_max_out_serial+1;
		else
			$data['serial'] = 1;
	}

	return $data;
	
}
