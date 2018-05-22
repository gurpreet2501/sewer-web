<?php 
namespace App\Libs;
use Models;
use Illuminate\Database\Capsule\Manager as DB;
class GateEntryAction{
	function __construct(){

	}

   /*
	   @1 -Cancelation reason 
	   @2 - Canceled by user_id 
	   @3 - Original Gateentry id  
   */
	public static function cancel($reason,$user_id,$ge_id){
		
		GateEntryAction::copyGateEntryDataToCanceledTables($reason,$user_id,$ge_id);

	}

	public static function processInvalidFields($data){
		$processedArr = [];
		foreach ($data as $key => $v) {

			if($v != '0000-00-00'){
				$processedArr[$key] = $v;
				continue;
			}

			$processedArr[$key] = '';
	  	}

	  	return $processedArr;
	 }

	public static function copyGateEntryDataToCanceledTables($reason,$user_id,$ge_id){

		
		$tables = [
			'canceled_ge_bag_types' => 'ge_bag_types',
			'canceled_ge_cmr_details' => 'ge_cmr_details',
			'canceled_ge_cmr_rice_delivery_details' => 'ge_cmr_rice_delivery_details',
			'canceled_ge_delivery_details' => 'ge_delivery_details',
			'canceled_ge_delivery_qc' => 'ge_delivery_qc',
			'canceled_ge_godown_labor_allocation' => 'ge_godown_labor_allocation',
			'canceled_ge_material_qc_labour_allocation' => 'ge_material_qc_labour_allocation',
			'canceled_ge_quality_cut' => 'ge_quality_cut',
			'canceled_ge_stock_items' => 'ge_stock_items',
		];

		$gateEntry = Models\GateEntry::find($ge_id);
		
		if(!$gateEntry)
			return 404;

		$gate_entry = $gateEntry->toArray();
		$gate_entry['orig_id'] = $gate_entry['id'];
		$gate_entry['cancelation_reason'] = $reason;
		$gate_entry['canceled_by_user_id'] = $user_id;
		
	 	unset($gate_entry['id']);	
	 	unset($gate_entry['second_weight_date']);	
		
		DB::beginTransaction();
		try{
			//Migration pending orig_id
			
			DB::table('canceled_gate_entries')->insert($gate_entry);

			foreach ($tables as $can_tab => $table) {
				
			

				if($can_tab == 'canceled_ge_delivery_details' || $can_tab == 'canceled_ge_delivery_qc' )
				 		$results = DB::table($table)->where('gate_entry_id', $ge_id)->get();				
				else
						$results =DB::table($table)->where('ge_id', $ge_id)->get();
					
				if(!count($results))
					continue;

				foreach ($results as $res) {			
					$origId = $res->id;					
					$res->orig_id = $origId;
					$savearray = (Array)$res;
					
					$savearray = self::processInvalidFields($savearray);
					unset($savearray['id']);
					
					$resp = DB::table($can_tab)->insert($savearray);
					DB::table($table)->where('id',$origId)->delete();
				}


			}	

			DB::table('gate_entries')->where('id',$ge_id)->delete();
			


		}catch(\Exception $e){
			echo $e->getMessage();
			DB::rollBack();
			die('Unable to cancel due to some errors.');
		}
		DB::commit();
		return true;		
	}

	public static function pregMatchStr($pattern,$string){
	
			return preg_match("/{$pattern}/i",$string);
	}

	
	public static function valueExistsButChanged($db_values, $edited_post_data){

		$difference = []; 
		foreach ($edited_post_data as $key => $d) {
			if(array_key_exists($key, $db_values)){
				if($edited_post_data[$key] != $db_values[$key]){
					$difference[$key]['previous_value'] = $db_values[$key];
					$difference[$key]['new_value'] = $d;
				}
			}
			# code...
		}
		return $difference;

	}

	public static function valueExistsButNotPresentBefore($db_values, $edited_post_data){

		$difference = []; 
		foreach ($edited_post_data as $key => $d) {
			if(!array_key_exists($key, $db_values) && !empty($d)){
					$difference[$key] = $d;
				}
			}

		return $difference;

	}


	public static function stockItemsKeysFilter($key){
		 $difference = [];
		   if(
					preg_match("/^stock_items\.[0-9]*?\..*$/i",$key)
					&& 
					preg_match("/^stock_items\.[0-9]*?\.(stock_item_id|bags).*$/i",$key)
				){
					
						$difference[$key] = $db_values[$key];
				}
				return $difference;
	}


	public static function diffArraysKeyCols($db_values, $edited_post_data, $key, $cols){
	
		$diff = [];
		$dbRows = $db_values[$key];
		$postedRows = $edited_post_data[$key];

		$dbRowsCount = count($db_values[$key]);
		$postedRowsCount = count($edited_post_data[$key]);

		$maxRows = ($dbRowsCount > $postedRowsCount) ? $dbRowsCount: $postedRowsCount;
		$compareCols = $cols;
		$diff = [];

		for($i=0 ; $i<$maxRows ; $i++){
			if(!isset($dbRows[$i])){	
				$diff[] = [
					'data' => $postedRows[$i],
					'diff' => 'ADDED',
				];
				continue;
			}

			if(!isset($postedRows[$i])){
				$diff[] = [
					'data' => $dbRows[$i],
					'diff' => 'REMOVED',
				];
				continue;
			}

			foreach($compareCols as $compareCol)
				
				if($postedRows[$i][$compareCol] != $dbRows[$i][$compareCol])
					$diff[] = [
						'old_data' => $dbRows[$i],
						'new_data' => $postedRows[$i],
						'diff' => 'CHANGED',
					];
		}
	
		return $diff;
	}

	public static function diffArrays($db_values, $edited_post_data){
		
		$masterDiff = [];

		$masterDiff['common_fields'] = self::diffArraysKeyCols(
			$db_values, 
			$edited_post_data,
			'common_fields',
			['entry_type', 'form_id', 'account_id', 'truck_no', 'loaded_weight', 'tare_weight', 'gross_weight', 'packing_material_weight', 'net_weight', 'gate_pass_no']
		);

		
		$masterDiff['godown_qc_labor_allocation'] = self::diffArraysKeyCols(
			$db_values, 
			$edited_post_data,
			'godown_qc_labor_allocation',
			['stock_item_id','bags','godown_id','labour_party_id','labour_job_type_id','remarks']
		);

		$masterDiff['stock_items'] = self::diffArraysKeyCols(
			$db_values, 
			$edited_post_data,
			'stock_items',
			['stock_item_id','bags']
		);

		$masterDiff['quality_cuts'] = self::diffArraysKeyCols(
			$db_values, 
			$edited_post_data,
			'quality_cuts',
			['quality_cut_type','bags','qty_per_bag','remarks']
		);
		return $masterDiff;
	}

	public static function makeDiffLog($db_values, $edited_post_data){
		
		$ge_id = isset($db_values['id']) ? $db_values['id'] : 0;	
		$common_fields_db = [];
		$common_fields_post_data = [];

		$common_field_keys = ['entry_type', 'form_id', 'account_id', 'truck_no', 'loaded_weight', 'tare_weight', 'gross_weight', 'packing_material_weight', 'net_weight', 'gate_pass_no'];

		foreach ($common_field_keys as $key => $cf) {
			$common_fields_post_data[0][$cf] = $edited_post_data[$cf];
		}

		foreach ($common_field_keys as $key => $cf) {
			$common_fields_db[0][$cf] = $db_values[$cf];
		}

		$db_values['common_fields'] = $common_fields_db;
		$edited_post_data['common_fields'] = $common_fields_post_data;
		
		$diff3 = self::diffArrays($db_values, $edited_post_data);
		// $diff3 = self::valueDoesNotExistsInPostButPresentInDb($db_values, $edited_post_data);

		Models\GateEntryDiff::create([
			'user_id' => user_id(),
			'data' => json_encode($diff3),
			'gate_entry_id' => $ge_id,
			'edited_at' => date('Y-m-d H:i:s')
		]);

		return true;
	}

	public static function recordEdits($id,$post){

		$post['godown_qc_labor_allocation'] = isset($post['ge_godown_qc_labor_allocation']) ? array_values($post['ge_godown_qc_labor_allocation']) : [];

		$post['godown_labor_allocation'][0] = isset($post['ge_godown_labor_allocation']) ? $post['ge_godown_labor_allocation'] : [];

		$cmr_details = isset($post['cmr_details']) ? $post['cmr_details'] : [];

		unset($post['cmr_details']);
		
		$cmr_rice_del_details = $post['cmr_rice_delivery_details'];
		unset($post['cmr_rice_delivery_details']);

		$post['cmr_details'][0] = $cmr_details;
		
		$post['cmr_rice_delivery_details'][0] = $cmr_rice_del_details;

		$post['quality_cuts'] = isset($post['quality_cut']) ? array_values($post['quality_cut']) : [];

		unset($post['quality_cut']);
		unset($post['ge_godown_qc_labor_allocation']);
		unset($post['ge_godown_labor_allocation']);

		$stock_items = [];

		$i = 0;

		foreach ($post['stock_items'] as $si_id => $bags) {
			$stock_items[$i]['stock_item_id'] = $si_id;
			$stock_items[$i]['bags'] = $bags;
			$i++;
		}
		
		$post['stock_items'] = $stock_items;
		
		$saved_entries = Models\GateEntry::with('godownQcLaborAllocation')
								 ->with('stockItems.stockItem')
								 ->with('bagTypes.stockItem')
								 ->with('qualityCuts')
								 ->with('godownLaborAllocation')
								 ->with('cmrDetails')
								 ->with('cmrRiceDeliveryDetails')
								->find($id);

		self::makeDiffLog($saved_entries->toArray(),$post);			

	}



}
