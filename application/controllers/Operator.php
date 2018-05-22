<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operator extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		auth_force();
	}
 
 
  public function dashboard(){
		$results = Models\GateEntry::where('status','Partially Completed')
						->with('accounts')
						->get();
		$this->load->view('dashboard', ['results' => $results]);
  }

	public function index($id = null)
	{	
		
		// jQuery Validations
		$required = '';
		if($id)
			$required = 'required';

		$parties = Models\Parties::get();
		$gateEntry = $id
						? Models\GateEntry::find($id)
						: null;
		$labourParties = Models\LabourParties::with('labourJobTypes')->get();
	
		$stockItems =  Models\StockItems::get();
		$forms = Models\Forms::orderBy('name')->get();
		$stockGroups = Models\StockGroups::with('bagTypes')
                                         ->with('qualityCutTypes')
                                         ->get();
		$stockItems = Models\StockItems::get();
		$gateEntryConfig = Models\GateEntryConfig::get();

		$data = [
		  'required' => $required,
		  'isUpdate' => (Boolean)$id,
			'autofill' => common_fields_autofill($id),
			'material_types'=> Models\MaterialTypes::get(),
			'quality_cut_types' => Models\QualityCutTypes::get(),
			'godowns' 		=> Models\Godowns::get(),
			'cmr_agencies' 	=> Models\CMRAgencies::get(),
			'labour_parties' => $labourParties,
			'delivery_destinations' => Models\DeliveryDestinations::get(),
			'fci_godowns' 	=> Models\FCIGodowns::get(),
			'stock_items' 	=> $stockItems,
			'parties' 		=> $parties,
			'js_files' 		=> [
				base_url('assets/js/store.js'),
				base_url('assets/js/vue/gate-entry.js'),
				base_url('assets/js/validators/stock-items.js'),
				base_url('assets/js/validators/bag-types.js'),
				base_url('assets/js/validators/validate-loaded-weight.js'),
				base_url('assets/js/validators/validate-tare-weight.js'),
				base_url('assets/js/validators/validate-entry-creation.js'),
				base_url('assets/js/gate-entry-weight-reader.js?8558'),
			],
			'for_js' => [
		  		'isUpdate' 			=> (Boolean)$id,
				'gate_entry'		=> $gateEntry,
				'stock_groups' 		=> $stockGroups,
				'stock_items' 		=> $stockItems,
				'forms' 			=> $forms,
				'labour_parties_with_job_types' => $labourParties,
				'gate_entry_config'	=> $gateEntryConfig,
			]
			
	  	];	
	 
		$this->load->view('gate_pass/index', $data);
	}

	public function save($id=null)
	{ 
		
		$r = $_POST;
		
		$updateFlag = false;	
		if($id)	{
			$ge = Models\GateEntry::find($id);
			$updateFlag = true;
		}
		else
			$ge = new Models\GateEntry();
		
		if(isset($r['deduct_packing_material'])){
			if($r['deduct_packing_material'] == 'on')
				$r['deduct_packing_material'] = true;
			else
				$r['deduct_packing_material'] = false;
		}
		
		$ge->saveCommonData($r);
		
		if(isset($r['stock_items']))
			$ge->saveStockItems($r['stock_items']);

		if(isset($r['bag_types']))
			$ge->saveBagTypes($r['bag_types']);
		
		if(isset($r['quality_cut']))
			$ge->saveQualityCuts($r['quality_cut']);
		
		if(isset($r['ge_godown_labor_allocation']))
			$ge->saveGodownLaborAllocation($r['ge_godown_labor_allocation']);

    	if(isset($r['ge_godown_qc_labor_allocation']))
			$ge->saveGodownQcLaborAllocation($r['ge_godown_qc_labor_allocation']);

		if(isset($r['cmr_details']))
			$ge->saveCMRDetails($r['cmr_details']);

		if(isset($r['cmr_rice_delivery_details']))
			$ge->saveCMRRiceDeliveryDetails($r['cmr_rice_delivery_details']);
		
		if($updateFlag)
			$ge->completeStatus();

		success('Data Saved Successfully!');

		redirect('dashboard/index/'.$id);
	}
}

