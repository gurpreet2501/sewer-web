<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manager extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		auth_force();
	}
 
 
  public function dashboard(){
	
		$this->load->view('manager/dashboard');
  }

  function removeUncheckedOptions($data){
  		$checks = ['stock_group','quality_cut','job_category'];

			foreach($checks as $v)
				if(isset($data[$v]))
					foreach ($data[$v] as $key => $stgrp) 
						if(!in_array($key, $data['modulesEnabled']))
							unset($data[$v][$key]);

			return $data;			
  }

  public function formCreate(){
		
		if(!empty($_POST)){
			$postData = $_POST;

			if(!isset($postData['modulesEnabled']))
				$postData['modulesEnabled'] = [];

			//Removing modules if checkbox not enabled 
			$postData = $this->removeUncheckedOptions($postData);
					
			$data = [
				'name' => $postData['form_name'],
				'type' => $postData['form_type'],
				'chatni_report_no' => $postData['chatni_report_no']
			];
		
			
			$formObj = Models\Forms::create($data);
			
			foreach ($postData['modulesEnabled'] as $key => $mod) {
						
						$formMod =  Models\FormModules::create([	
						 	'form_id' =>  $formObj->id,
						 	'module_id' => $mod
							]);

						// Adding FormModulesStockGroups in DB
						if(isset($postData['stock_group'][$mod]))
							foreach ($postData['stock_group'][$mod] as $key => $stGrpId) {
								Models\FormModulesStockGroups::create([
										'form_modules_id' => $formMod->id,
										'stock_groups_id' => $stGrpId,
									]);
							}
						
						// Adding FormModulesStockGroups in DB
						if(isset($postData['stock_items'][$mod]))
							foreach ($postData['stock_items'][$mod] as $key => $stItemId) {
								Models\FormModulesStockItems::create([
										'form_modules_id' => $formMod->id,
										'stock_item_id' => $stItemId,
									]);
							}

						// Adding FormModulesLabourJobCategories in DB
						if(isset($postData['job_category'][$mod]))
							foreach ($postData['job_category'][$mod] as $key => $jobCatId) {
								Models\FormModulesLabourJobCategories::create([
										'form_modules_id' => $formMod->id,
										'labour_job_categories_id' => $jobCatId,
									]);
							}
					
					 // Adding QualityCutTypes in DB
						
						if(isset($postData['quality_cut'][$mod]))
							foreach ($postData['quality_cut'][$mod] as $key => $qcId) {
								Models\FormModulesQualityCutTypes::create([
										'form_modules_id' => $formMod->id,
										'quality_cut_types_id' => $qcId,
									]);
							}

					}
				
		
			success('Data Saved Successfully!');		
			redirect('manager/formCreate');	

		}

		$stockGrps = Models\StockGroups::get();
		$stockItems = Models\StockItems::get();
		
		$lbrJobCat = Models\LabourJobCategories::get();
		$qualityCutTypes = Models\QualityCutTypes::get();
	
		$this->load->view('manager/form-create', [
			'stockGrps' => $stockGrps,
			'stockItems' => $stockItems,
			'lbrJobCat' => $lbrJobCat,
			'qualityCutTypes' => $qualityCutTypes,
			]);
  }

  function formEdit($id){

		//Fetching existing form data  	
		 $formData = Models\Forms::with('modules.stockGroups')
									->with('modules.stockItems')
												->with('modules.labourJobCategories')
												->with('modules.qualityCutTypes')
												->where('id',$id)->first();
									
  	    $stockGrps = Models\StockGroups::get();
  	    $stockItems = Models\StockItems::get();
				$lbrJobCat = Models\LabourJobCategories::get();
				$qualityCutTypes = Models\QualityCutTypes::get();



  	$this->load->view('manager/form-edit', [
			'stockGrps' => $stockGrps,
			'stockItems' => $stockItems,
			'lbrJobCat' => $lbrJobCat,
			'qualityCutTypes' => $qualityCutTypes,
			'formData' => $formData
			]);

  }

  function formUpdate(){
  	if(empty($_POST))
  		return 404;

  	$postData = $_POST;
  	
  	Models\Forms::where('id',$postData['form_id'])->update([
  		'name' => $postData['form_name'],
  		'type' => $postData['form_type'],
  		'chatni_report_no' => $postData['chatni_report_no'],
  	]);

  	//Removing modules if checkbox not enabled 
		$postData = $this->removeUncheckedOptions($postData);
	
		$this->deletePreviousEntries($postData['form_id']);	
		foreach ($postData['modulesEnabled'] as $key => $mod) {
						
												
						$formMod =  Models\FormModules::create([	
						 	'form_id' =>  $postData['form_id'],
						 	'module_id' => $mod
							]);
					
						// Adding FormModulesStockGroups in DB
						if(isset($postData['stock_group'][$mod]))
							foreach ($postData['stock_group'][$mod] as $key => $stGrpId) {
								$entryStgrp = Models\FormModulesStockGroups::create([
										'form_modules_id' => $formMod->id,
										'stock_groups_id' => $stGrpId,
									]);
							}

             if(isset($postData['stock_items'][$mod]))
							 foreach ($postData['stock_items'][$mod] as $key => $stItemId) {
								$entryStgrp = Models\FormModulesStockItems::create([
										'form_modules_id' => $formMod->id,
										'stock_item_id' => $stItemId,
									]);
							}

						// Adding FormModulesLabourJobCategories in DB
						if(isset($postData['job_category'][$mod]))
							foreach ($postData['job_category'][$mod] as $key => $jobCatId) {
								$jobCat = Models\FormModulesLabourJobCategories::create([
										'form_modules_id' => $formMod->id,
										'labour_job_categories_id' => $jobCatId,
									]);
							}
					
					 // Adding QualityCutTypes in DB
						
						if(isset($postData['quality_cut'][$mod]))
							foreach ($postData['quality_cut'][$mod] as $key => $qcId) {
								$qualcut = Models\FormModulesQualityCutTypes::create([
										'form_modules_id' => $formMod->id,
										'quality_cut_types_id' => $qcId,
									]);

							}

					}	
  
  		success('Form Updated Successfully!');		
			redirect('manager/formEdit/'.$postData['form_id']);	
		
  }

 function deletePreviousEntries($formId){
 		 $modules = Models\FormModules::where('form_id',$formId)->get()->toArray();
		 $moduleIds = array_column($modules, 'id');
 		 Models\FormModules::where('form_id', $formId)->delete();

		foreach ($moduleIds as $id) {
			 Models\FormModulesStockGroups::where('form_modules_id',$id)->delete();
			 Models\FormModulesLabourJobCategories::where('form_modules_id',$id)->delete();
			 Models\FormModulesQualityCutTypes::where('form_modules_id',$id)->delete();
		}		 
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
				base_url('assets/js/gate-entry-weight-reader.js?6713'),
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

