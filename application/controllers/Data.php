<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Illuminate\Database\Capsule\Manager as DB;
class Data extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		auth_force();
		$this->load->database();
		$this->load->helper('url');
	}

	public function _example_output($output = null)
	{
		$this->load->view('crud.php',(array)$output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	public function stockGroups()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('stock_groups');
			$crud->display_as('account_id','account_name');
			$crud->set_relation('account_id','accounts','name');
			$crud->set_relation('sales_account_id','accounts','name');
			$crud->set_relation('purchase_account_id','accounts','name');
			$crud->set_relation_n_n('category', 'stock_group_categories_relation', 'stock_group_categories', 'stock_group_id', 'stock_group_categories_id', 'name');
			// $crud->field_type('type','dropdown',array('IN' => 'IN', 'OUT' => 'OUT'));
			$output = $crud->render();
			$this->_example_output($output);
	}

	public function cmr_agencies()
	{
			
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('cmr_agencies');
			$crud->columns('name');
			$crud->unset_read();
		  $output = $crud->render();
			$this->_example_output($output);

	}

	public function cmr_society()
	{
			
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('cmr_society');
			$crud->columns('name');
			$crud->edit_fields('name');
			$crud->unset_read();
			$crud->fields('name');
			$output = $crud->render();
			$this->_example_output($output);

	}


	public function cmrDetails()
	{  

			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');

			if($crud->getState()=='add')
				redirect('cmr_details/add');


			
			$crud->set_table('ge_cmr_details');
			// $crud->columns('name');
			if(user_role() != 'admin'){
				$crud->unset_edit();	
				$crud->unset_delete();	
			}

			$crud->unset_read();	
			$crud->unset_texteditor('tp_no');
			$crud->unset_edit();
			$crud->unset_texteditor('ac_note_no');

			
			if(user_role() == 'admin')
				$crud->add_action('', '', 'cmr_details/edit','ui-icon-pencil');

			$crud->add_action('', '', 'cmr_details/view','ui-icon-search');

			$crud->columns('cmr_agency_id', 'account_id','cmr_society_id','cmr_market_id','truck_no','tp_no','tp_date','quintals','no_of_bags','m_serial_no');
			// $crud->where('ge_id','<=',0);
			$crud->field_type('ge_id','hidden',0);
			$crud->display_as('cmr_agency_id','Agency');
			$crud->display_as('account_id','Account');
			$crud->display_as('cmr_market_id','CMR Market');


			// $crud->set_relation('sales_account_id','accounts','name');
			$crud->set_relation('cmr_agency_id','cmr_agencies','name');
			$crud->set_relation('cmr_market_id','cmr_markets','name');
			$crud->set_relation('cmr_society_id','cmr_society','name');
			$crud->set_relation('account_id','accounts','name');

			$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
			$crud->field_type('updated_at','hidden');
			$crud->unset_export();
			$crud->unset_print();

			
			$output = $crud->render();

			$output->js_files[] = base_url('/assets/js/datatable-grid-calculator.js?'.time());
			
			$output = (array)$output;
			$output['title'] = 'CMR Agencies Paddy Received Details';
	
			$this->load->view('data/cmr-details',$output);

	}

	public function bag_weights()
	{ 	
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('bag_weights');
			$crud->columns('stock_group','stock_item_id','bag_weight','weight_type','standard_weight');
			$crud->set_relation('stock_group','stock_groups','name'); 
			$crud->set_relation('stock_item_id','stock_items','name'); 
			$crud->display_as('stock_item_id','Stock Item');
			$output = $crud->render();
			$this->_example_output($output);	
	}

	public function add_bag_weights()
	{
		$stockGroups = Models\StockGroups::orderBy('name')->get();
		$this->load->view(
		'data/bag_weights/add',
		[
		'stock_groups' => $stockGroups,
		]
		);
	}
	
	public function update_bag_weights($id=null)
	{
		$bagWeight = Models\BagWeights::where('id',$id)->get();
		//echo "<pre>";print_r($bagWeight);die;
		$stockGroups = Models\StockGroups::orderBy('name')->get();
		foreach($bagWeight as $weight)
		{
			$stockItems = Models\StockItems::orderBy('name')->where('stock_group_id',$weight->stock_group)->get();
		}
		$this->load->view(
		'data/bag_weights/edit',
		[
		'stock_groups' => $stockGroups,
		'stock_items' => $stockItems,
		'bagweight' => $bagWeight,
		]
		);
	}
	
	public function filter_stockitems()
	{
		$stockGroup_id =  $_GET['stock_group'];
		$stock_items = Models\StockItems::where('stock_group_id', $stockGroup_id)->get();
		//echo "<pre>";print_r($stock_items);die;
		$result='';
		foreach($stock_items as $items)
		{
			$result = $result.$items->id.'&'.$items->name.'$';
		}
		
		echo $result;
	}
	// public function savebagWeights()
	// { 	
	// 	  if(empty($_POST))	
	// 	  	return 404;
	// 	  $postData = $_POST['data'];
		 
	// 	  foreach($postData as $stockItemId => $val){
		  
	// 	  	$count = Models\BagWeights::where('stock_item_id', $stockItemId)->count();

	// 	    if(!$count){
	// 	    	Models\BagWeights::create([
	// 	    			'stock_item_id' => $stockItemId,
	// 	    			'weight' => $val['weight'],
	// 	    		]);
	// 	    }
	// 	    else{
	// 	    	Models\BagWeights::where('stock_item_id', $stockItemId)->update([
	// 	    			'weight' => $val['weight'],
	// 	    		]);
	// 	    }
	// 	  }  

	// 	  success('Weights Updated Successfully');  
	// 	  redirect('data/bagWeights');  

	// }

	public function edit_labour_job(){
		if(empty($_GET))
			return 404;

		$data = $_GET;
		
		$jobs = getLaborJobsWithDateFilter($data);
		
		$this->load->view('manger_dashboard/edit_labour_job',[
			'jobs' => $jobs,
			'parties' => getAllLaborParties(),
			'godowns' => getAllGodowns(),
			'params' => http_build_query($data['params']),
			'labour_job_types' => getLabourJobTypes(),
		]);
	}

  public function edit_custom_labour_job(){
		if(empty($_GET))
			return 404;

		$data = $_GET;
		
		$jobs = getCustomLaborJobsWithDateFilter($data);
	
		$this->load->view('manger_dashboard/edit_custom_labour_job',[
			'jobs' => $jobs,
			'parties' => getAllLaborParties(),
			'godowns' => getAllGodowns(),
			'params' => http_build_query($data['params']),
			'labour_job_types' => getLabourJobTypes(),
		]);
	}

	public function update_edited_labour_job(){
		if(empty($_POST))
			return 404;
		$data = $_POST;
	
		foreach ($data['job'] as $key => $entry) {
			
			if(!$entry['ge_qc_mat_alloc_id'])
				continue;
		  $ge_qc_mat_alloc_id = $entry['ge_qc_mat_alloc_id'];

		  unset($entry['ge_qc_mat_alloc_id']);

			Models\GEGodownQcLaborAllocation::where('id',$ge_qc_mat_alloc_id)
							->update($entry);
		}

			if(isset($data['params']))				
				$redirect_url = site_url('data/dailyLabourAccounts/?'.$data['params']);
			else
				$redirect_url = site_url('data/dailyLabourAccounts/');
		
			success('Entries Updated Successfully');					
			redirect($redirect_url);
	}

	public function customLabourJobs(){
		
		$stub['party_id'] = 0;
		if(isset($_GET['party_id']))
		  $stub['party_id'] = $_GET['party_id'];

		$godowns = Models\Godowns::get();
		$labour_job_types = Models\LabourJobTypes::get();
		$weight_units = Models\WeightUnits::get();

		$this->load->view('data/custom-labour-jobs', [
			'godowns' => $godowns,
			'stub' => $stub,
			'get_string' => http_build_query($_GET),
			'accounts' => Models\Accounts::whereLabourParty('Labour Party')->get(),
			'weight_units' => $weight_units,
			'labour_job_types' => $labour_job_types,
			'css_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
			'js_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js')],

		]);

	}


	public function saveOtherLabourJob(){
		if(empty($_POST))		
			return 404;

		$data = $_POST;
	
		$dat = Models\OtherLabourJobs::create($data);
		if($dat)
			success('Labour Job Added Successfully');
		else
			failure('Unable to Add Labour Job. Please Try Again');

		redirect('data/dailyLabourAccounts');

	}

	public function saveCustomLabourJob(){
		
		if(empty($_POST))		
			return 404;

		$data = $_POST;

		$data['type'] = 'CUSTOM';
		$data['created_at'] = $data['created_at'].' 00:00:00';


		$dat = Models\GEGodownQcLaborAllocation::create($data);
		if($dat){
			DB::table('ge_material_qc_labour_allocation')->where('id',$dat->id)->update(array(
			   'created_at'=> $data['created_at']
			));
			success('Custom Labour Job Added Successfully');

		}
		else
			failure('Unable to Add Custom Labour Job. Please Try Again');

		redirect('data/dailyLabourAccounts/?'.http_build_query($_GET));

	}

	public function dailyLabourAccounts()
	{   

			$party_id = 0;
		  $opening_balance = 0; 
		  $closing_balance = 0; 
	    $filteredResults = [];	
	    $otherJobsTotal = 0;	
      $jobsTotal = 0.0;	 
		  $resultsFlag = false;
		  $data = [];
		  $get_string = '';
		  $otherJobsData = [];
		  $customJobsData = [];
		  $godowns = Models\Godowns::get();
		  $get_string = $_GET;
		  $stub = [
		  	'start_date' => date('Y-m-d'),
		  	'end_date' => date('Y-m-d')
		  ];

		  $accounts = Models\Accounts::whereLabourParty('Labour Party')->get();
			
		 	if(!empty($_GET)){
		 	
		 			$postData = $_GET;
		 				
		 			if(isset($_GET['print'])){
		 				redirect('labour_party/dailyLaborAccountsPrint/?'.http_build_query($postData));
		 			}
		 			
		 			$get_string = $_GET;
		 		
		 			if(!isset($_GET['party_id'])){
		 				failure("Select party id from drop down to add job");
		 				redirect('data/dailyLabourAccounts');
		 			}
		 			 			
		 			if(!empty($postData['start_date']))
		 				$stub['start_date'] = $postData['start_date'];
		 			
		 			if(!empty($postData['end_date']))
		 				$stub['end_date'] = $postData['end_date'];

		 			if(isset($postData['_today_filter'])){
		 				$stub['start_date'] = date('Y-m-d');	
		 				$stub['end_date'] = date('Y-m-d');
		 			}
					
					$party_id = $postData['party_id'];
				
		 			//Read Gateentry QcLabour allocation entries
		 			$geGodQcLabAll = Models\GEGodownQcLaborAllocation::where('type','GATE_ENTRY')->with('labourJobType','laborPayment','godown','labourJobType')
		 													->where('labour_party_id', $postData['party_id'])
															->where('created_at', '<=', $stub['end_date'].' 23:59:59');
          
          $restricted_date = date('Y-m-d 00:00:00', strtotime('-7 days'));

         if(user_role() != 'admin') {
		         	if($stub['start_date'] < $restricted_date)
		          	$geGodQcLabAll->where('created_at', '>=', $restricted_date.' 00:00:00');
		          else 		
								$geGodQcLabAll->where('created_at', '>=', $stub['start_date'].' 00:00:00');
				  }else{
				 		$geGodQcLabAll->where('created_at', '>=', $stub['start_date'].' 00:00:00');
				  }
				 		
				          
     		$geGodQcLabAll = $geGodQcLabAll->get();	
  													
			  foreach ($geGodQcLabAll as $key => $detail) {
			
			  	if(empty($detail->labourJobType->id))
			  		continue;

		  		$data[$key]['id'] =  $detail->id;
		  		$data[$key]['ge_id'] =  $detail->ge_id;
		  		$data[$key]['qc_allocation_id'] =  $detail->id;
			  	$data[$key]['labour_party_name'] = isset($detail->labourJobType->name) ? $detail->labourJobType->name : '';
			  	$data[$key]['labour_job_type_id'] = isset($detail->labourJobType->id) ? $detail->labourJobType->id : '';
			  	$data[$key]['amount'] = round($detail->rate*$detail->bags,2);
			  	$data[$key]['bags'] = $detail->bags;
			   	$data[$key]['godown_name'] = $detail->godown->name;
			   	$data[$key]['godown_id'] = $detail->godown_id;
			  	$data[$key]['labour_job_type_name'] = isset($detail->labourJobType->name) ? $detail->labourJobType->name : '';
          $data[$key]['rate'] = $detail->rate;
          $data[$key]['is_paid'] = (Boolean)count($detail->laborPayment);
		    }			
			
				$filteredResults = reorderGodownBagAllocation($data);
			
			  // Filtering Custom jobs
			  $customJobsData = [];
				
				$customJobs = Models\GEGodownQcLaborAllocation::with('accounts','laborPayment','labourJobType','godown')->where('type','CUSTOM')->where('labour_party_id', $postData['party_id'])
												->where('created_at', '>=', $stub['start_date'].' 00:00:00')	
												->where('created_at', '<=', $stub['end_date'].' 23:59:59')
												->get();		
				$customJobs = count($customJobs) ? $customJobs->toArray() : [];

				foreach ($customJobs as $key => $job) {
					$customJobs[$key]['is_paid'] = (Boolean)count($job['labor_payment']);
					$customJobs[$key]['labour_job_type_name'] = '';
					
				}

			  $customJobsData = reorderCustomJobsData($customJobs);
			
				$otherJobsData = [];
				
				$otherJobs = Models\GEGodownQcLaborAllocation::with('accounts','laborPayment','labourJobType')->where('type','JOB')->where('labour_party_id', $postData['party_id'])
												->where('created_at', '>=', $stub['start_date'].' 00:00:00')	
												->where('created_at', '<=', $stub['end_date'].' 23:59:59')
												->get();		
						
				$odata = [];
				foreach ($otherJobs as $key => $detail) {
				
						$odata[$key]['id'] =  $detail->id;
			  		$odata[$key]['ge_id'] =  $detail->ge_id;
			  		$odata[$key]['qc_allocation_id'] =  $detail->id;
				  	$odata[$key]['labour_party_name'] = isset($detail->labourJobType->name) ? $detail->labourJobType->name : '';
				  	$odata[$key]['labour_job_type_id'] = isset($detail->labourJobType->id) ? $detail->labourJobType->id : '';
				  	$odata[$key]['amount'] = round($detail->rate*$detail->bags,2);
				  	$odata[$key]['bags'] = $detail->bags;
				   	$odata[$key]['godown_name'] = getGodownName($detail->godown_id);
				   	$odata[$key]['godown_id'] = $detail->godown_id;
				  	$odata[$key]['labour_job_type_name'] = getLaboutJobTypeName($detail->labour_job_type_id);
	          $odata[$key]['rate'] = $detail->rate;
	          $odata[$key]['is_paid'] = (Boolean)count($detail->laborPayment);
					}		
							
				$otherJobsData = reorderGodownBagAllocation($odata);	
			
			  if(count($data) || count($customJobsData) || count($otherJobsData))	
			  	$resultsFlag = true;
				
		 	} //GET Data block
		
		 	$get_string['start_date'] = $stub['start_date'];
		 	$get_string['end_date'] = $stub['end_date'];
		 	
			$this->load->view('data/daily-labour-accounts', [
					'data' => $data,
					'filtered_results' => $filteredResults,
					'stub' => $stub,
					'get_string' => http_build_query($get_string),
					'godowns' => $godowns,
					'jobs_total' => $jobsTotal,
					'accounts' => $accounts,
					'opening_balance' => $opening_balance,
					'closing_balance' => $closing_balance,
					'party_id' => $party_id,
					'advance_payment' => getPaymentBalance($party_id,$stub['end_date']),
					'custom_jobs_data' => $customJobsData,
					'other_jobs_data' => $otherJobsData,
					'resultsFlag' => $resultsFlag,
					'css_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
				  'js_files' => [
					   base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
					   base_url('assets/js/moment.js'),
						 base_url('assets/js/numeral.js'),
					   base_url('assets/js/labour-acc-rate-cal.js'),
					   base_url('assets/js/labor-acc-grand-total.js'),
				   ],
  		  ]);
	}


	function updateLabourPartyRates(){
			
			$data = array_merge($_POST,$_GET);
		
			if(isset($data['labour_type_to_edit'])){
					$this->edit_other_and_custom_jobs($data['labour_type_to_edit'],$data['associated_qc_lab_ids'],http_build_query($_GET));
			}
			
			if(isset($data['_DELETE'])){
				if(empty($data['labour_type_to_delete'])){
					  failure('No Entry Selected For Deletion');
						redirect('data/dailyLabourAccounts/?'.http_build_query($_GET));	
				}

				$this->delete_daily_labor_accounts($data['labour_type_to_delete'],$data['associated_qc_lab_ids']);
				success('Entries Deleted Successfully');
				redirect('data/dailyLabourAccounts/?'.http_build_query($_GET));	

			}

	    $data['amount'] = floatval(str_replace(',', "", $data['amount']));
	    $data['from_advance'] = floatval(str_replace(',', "", $data['from_advance']));

	    
			if(!isset($data['pay_jobs']) || !count($data['pay_jobs'])){
				failure('No jobs selected for payment.');
				redirect('data/dailyLabourAccounts/?'.http_build_query($_GET));	
			}

		
			$payJobs = [];
			foreach(array_keys($data['pay_jobs'])  as $typeId)
				$payJobs = array_merge($payJobs,explode(',',$data['jobs'][$typeId]));
		
			payLaborParty($data['amount'], $data['from_advance'] ,$payJobs, $data['source_payment_account'], $data['party_id']);
			success('Payment completed.');
			redirect('data/dailyLabourAccounts/?'.http_build_query($_GET));	

	}

	function dailyLabourAccPayment($data){
		
	
		// $total = 0;
		// foreach ($data['rate'] as $key => $entry) 
		// 	$total = $total + $entry['rate'] * $entry['bags'];

		if(!$data['amount']){
			failure('Unable to pay');
			redirect('data/updateLabourPartyRates/?'.http_build_query($_GET));	
		}

		Models\Transactions::create([
				'entry_type' => 'CASH',
				'transaction_date' => date('Y-m-d'),
				'amount' => $data['amount'],
				'primary_account_id' => $data['secondary_payment_account'],
				'secondary_account_id' => $data['party_id']
		]);

		success('Payment Successfull');
		redirect('data/dailyLabourAccounts/?'.http_build_query($_GET));
	}

	public function arrangeJobsOutput($job){
		
				  	$jobData['id'] = intVal($job->id);
				  	$jobData['bags'] = intVal($job->bags);
				  	$jobData['job_name'] = isset($job->job_name) ? $job->job_name : '' ;
				  	// $jobData['party_id'] = $job->party_id;
				  	$jobData['party_id'] = $job->labour_party_id;
				  	$jobData['is_paid'] = (boolean)(count($job->laborPayment));
				  	$jobData['date'] = $job->date;
				  	$jobData['remarks'] = $job->remarks;
				  	$jobData['rate'] = $job->rate;
				  	$jobData['amount'] = round($job->rate*$job->bags,2);
				  	$jobData['godown_name'] = $job->godown->name;
				  	$jobData['accounts'] = count($job->accounts)? $job->accounts->toArray() : [];
				  	$jobData['labour_job_type_name'] = $job->labourJobType->name;
				  	if(isset($job->labour_job_type_id))
				  		$jobData['labour_job_type_id'] = $job->labour_job_type_id;
				 
				  	return $jobData;
	}


	public function add_new_labour_job()
	{

		$jsFiles = [
			base_url('assets/js/numeral.js'),
			base_url('assets/js/vue/add-new-labor-job.js'),
		];

		$stub['party_id'] = 0;

		if(isset($_GET['party_id']))
		  $stub['party_id'] = $_GET['party_id'];

		$godowns = Models\Godowns::get(); 
		$labour_job_types = Models\LabourJobTypes::get();
		$weight_units = Models\WeightUnits::get();

		$accounts = Models\Accounts::with('laborPartyJobTypes.labourJobTypes')
																->with('accountlabourJobCategories.labourCategories')
																->whereLabourParty('Labour Party')->get();

		
		$qc_allocation_id = isset($_GET['qc_allocation_id']) ?$_GET['qc_allocation_id'] : 0;
		$qc_allocation = [];
		if($qc_allocation_id){
			$qc_allocation = Models\GEGodownQcLaborAllocation::where('id', $qc_allocation_id)->first();
			
		}

			
		$data = [
			'labour_job_types' => $labour_job_types,
			'get_string' => http_build_query($_GET),
			'stub' => $stub,
			'is_update' => isset($qc_allocation->id) ? $qc_allocation->id : 0,
			'godowns' => $godowns,
			'weight_units' => $weight_units,
			'accounts' => $accounts,
			'js_files' => $jsFiles,
			'for_js' => [
				'accounts' => $accounts,
				'laborJobTypes' => $labour_job_types,
				'godowns' => $godowns,
				'weightUnits' => $weight_units,
				'qc_allocation_entry' => $qc_allocation
				]	
		];
	
		$this->load->view('data/add-new-labor-job', $data);
		
	}

	public function save_new_labor_job()
	{
		if(empty($_POST))
			return 404;

		$data = $_POST;
	
		if($data['qc_mat_all_id']){
			
			unset($data['account_labour_job_cat']);
			unset($data['date']);
			unset($data['date']);
			$qc_id = $data['qc_mat_all_id'];
			unset($data['qc_mat_all_id']);
			
			$red_params = $_GET;
			
			unset($red_params['qc_allocation_id']);

			Models\GEGodownQcLaborAllocation::where('id', $qc_id)->update($data);
			success('Entry Updated Successfully');
			redirect('data/dailyLabourAccounts/?'.http_build_query($red_params));
		}

		$data['type'] = 'JOB';

		Models\GEGodownQcLaborAllocation::create($data);

		redirect('data/dailyLabourAccounts/?'.http_build_query($_GET));
		
	}

	public function accounts()
	{
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('accounts');
		$crud->unset_print();
		$crud->unset_export();
		$crud->columns('name','accounts_category','accounts_group_id','ob_date','ob_amount');
		$crud->display_as('accounts_group_id','Account Group');
		$crud->display_as('ob_amount','OB Balance');
		$crud->display_as('ob_date','OB Date');
		$crud->set_relation('accounts_group_id','accounts_group','{name}');
		$crud->set_relation_n_n('accounts_category','accounts_categories_relation','account_categories','account_id', 'account_category_id', 'name');	
		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');
		$output = $crud->render();
		$output = (array)$output;
		$output['title'] = 'Ledger Account';

		$this->load->view('crud.php',$output);


	}

	public function sale_purchase_gate_entries()
	{

		$page_num = 1;
		$stub = [
			'account_id' => '',
			'form_id' => 0,
			'truck_no' => "",
			'start_date' => '',
			'end_date' => '',
		];

		if(isset($_GET['page_no']))
			$page_num = $_GET['page_no'];

		 
		$accounts = Models\Accounts::get();
		$forms = Models\Forms::get();
		
		$entry_type = isset($_GET['entry_type']) ? $_GET['entry_type'] : '';
		$gate_entries = Models\GateEntry::with('forms')->with('accounts')->where('entry_type',$entry_type);
		
		if(isset($_POST['filters'])){
		
			if(!empty(($_POST['filters']['truck_no']))){
				$stub['truck_no'] = $_POST['filters']['truck_no'];
				$gate_entries = $gate_entries->where('truck_no', trim($_POST['filters']['truck_no']));
			}

			
			if(!empty($_POST['filters']['account_id'])){
				$stub['account_id'] = 	$_POST['filters']['account_id'];
				$gate_entries = $gate_entries->where('account_id', $_POST['filters']['account_id']);
			}

			if(!empty($_POST['filters']['form_id'])){
				$stub['form_id'] = 	$_POST['filters']['form_id'];
				$gate_entries = $gate_entries->where('form_id', $_POST['filters']['form_id']);
			}

			if(!empty($_POST['filters']['start_date']) && !empty($_POST['filters']['end_date'])){
				
				$stub['start_date'] = 	$_POST['filters']['start_date'];
				$stub['end_date'] = 	$_POST['filters']['end_date'];
				$gate_entries = $gate_entries->where('created_at','>=', $_POST['filters']['start_date'].' 00:00:00');
				$gate_entries = $gate_entries->where('created_at','<=', $_POST['filters']['end_date'].' 23:59:59');
			}
			
		}

		$gate_entries = $gate_entries->paginate(50,null,'page_num',$page_num);
		
		$this->load->view('crud_accounts.php',[
			'gate_entries' => $gate_entries,
			'type' => $entry_type,
			'accounts' => $accounts,
			'forms' => $forms,
			'stub' => $stub,
			'css_files' 	 => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
		 	'js_files' => [
					base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
					base_url('assets/js/numeral.js'),
				],
		]);
	}

	public function add_get_params($primary_key , $row){
		return site_url('gate_pass/index/'.$row->id).'?only_edit=1';
	}

	public function modify_net_weight($value, $row)
	{
  	return $value/100;
	}

	public function modify_serial_no($value, $row)
	{
  	return $row->id.$row->prefix.$row->serial;
	}

	public function change_date_display($value, $row)
	{
  	return date('Y-m-d', strtotime($value));
	}
  
  public function get_stock_group($value, $row)
	{
		$gateEntry = Models\GateEntry::where('id', $row->id)
								->with('godownQcLaborAllocation.stockItems.stockGroup')->first()->toArray();
								
		if(!isset($gateEntry['godown_qc_labor_allocation'][0]['stock_items']))
			return '';

		return get_stock_group_name($gateEntry['godown_qc_labor_allocation'][0]['stock_items']['stock_group_id']);
	}


	public function manageUsers()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('users');
			$crud->columns('username');
			$crud->fields('username','password','role','email');
			$crud->field_type('role','dropdown', array('admin' => 'Admin', 'operator' => 'Operator','manager' => 'Manager'));
			$crud->callback_field('password', array($this,'edit_password_callback'));
			$crud->callback_before_update(array($this,'on_update_encrypt_password_callback'));
      $crud->callback_before_insert(array($this,'on_update_encrypt_password_callback'));
			$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
			$crud->field_type('updated_at','hidden');
			$output = $crud->render();
			$this->_example_output($output);
	}

	public function userAccess()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->field_type('role','dropdown', array('operator' => 'Operator','manager' => 'Manager'));
			$crud->set_table('user_access');
			$crud->callback_field('feature',array($this,'get_menu_keys'));
			$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
			$crud->field_type('updated_at','hidden');
			$output = $crud->render();
			$this->_example_output($output);
	}

	function get_menu_keys($value = '', $primary_key = null)
	{  

		$menuItems = [];

		foreach($this->config->item('menu_access') as $key => $val):
			foreach($val as $feature => $url):
				$menuItems[] = $feature;
			endforeach;	
		endforeach;
		$dropDown = "<select class='form-control' name='feature'>";
		foreach($menuItems as $v):
		 $dropDown .= "<option value=".$v.">".ucwords(str_replace('_', ' ', $v))."</option>";
		endforeach;		

		$dropDown .= "</select>";
		
		return $dropDown;
		
	}

	public function bagTypes()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('bag_types');
			$crud->columns('name','weight','weight_type');
			$crud->field_type('stock_group_id','hidden');
			// $crud->set_relation('stock_group_id','stock_groups','{name}');
			$output = $crud->render();
			$this->_example_output($output);
	}

	public function stockItems()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('stock_items');
			$crud->columns('name','stock_group_id');
			$crud->display_as('stock_group_id', 'Stock Group');
			$crud->set_relation('stock_group_id','stock_groups','{name}');
			$crud->field_type('created_at','hidden',date('Y-m-d H:i:s'));
			$crud->field_type('updated_at','hidden');
			$output = $crud->render();
			$this->_example_output($output);
	}


	public function qualityCutTypes()
	{
			$crud = new grocery_CRUD();
			$crud->set_theme('datatables');
			$crud->set_table('quality_cut_types');
			$crud->display_as('stock_group_id', 'Stock Group');
			$crud->set_relation('stock_group_id','stock_groups','{name}');
			$output = $crud->render();
			$this->_example_output($output);
	}

	public function labourAccounts()
	{
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('labour_accounts');
		
		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');

		$crud->set_relation('labour_job_category_id', 'labour_job_categories','{name}');
		$crud->callback_before_update(array($this,'add_updated_at_value'));

		$output = $crud->render();
		$output->title = 'Labour Accounts';
		$this->_example_output($output);
	}

	public function rateEntry()
	{ 
 		
 		$ge_ids = [];
 		if(Models\GateEntry::where('status', 'Complete')->count()){
 			$gateEntries = Models\GateEntry::where('status', 'Complete')->get()->toArray();
 			$ge_ids = array_column($gateEntries, 'id');
 		}

 		$accounts = Models\Accounts::get();
 		
 		$stock_items = Models\StockItems::get();
 		$stock_groups = Models\StockGroups::get();

		 $stub = [
		 	'start_date' => date('Y-m-d'),
		 	'end_date' => date('Y-m-d'),
		 	'_rate' => '',
		 	'stock_items' => [],
		 	'accounts' => [] 
		 ];

		 $query = new Models\GEGodownQcLaborAllocation;	
		 // $query = new Models\GEStockItems;
		 	
		 if(!empty($_GET['accounts'])){

		 	$query =  $query->whereAccountIds($_GET['accounts']);
		 	$stub['accounts'] = $_GET['accounts'];
		 }

		 $query = $query->with('gateEntry.accounts')->with('stockItems');

		 if(!empty($_GET['stock_items'])){
		 	 $stub['stock_items'] = $_GET['stock_items'];
			 $query = $query->whereIn('stock_item_id', $_GET['stock_items']);			
		 }
		 	
		 if(!empty($_GET['_rate'])){

  				 	if($_GET['_rate'] == 'NO'){
					 		$query = $query->where('rate', 0);
					 		$stub['_rate'] = 'NO';
					 	}
					 	else if($_GET['_rate'] == 'YES'){
					 		$query = $query->where('rate','>', 0);
					 		$stub['_rate'] = 'YES';
					 	}
					 	else
					 		$stub['_rate'] = 'ALL';
		 	}

		if(!empty($_GET['start_date']) && !empty($_GET['end_date'])){
			  $stub['start_date'] = $_GET['start_date'] ? $_GET['start_date'] : '';
			 	$stub['end_date'] = $_GET['end_date'] ? $_GET['end_date'] : '';
			 	$query = $query->where('created_at','>=', $stub['start_date'].' 00:00:00');
			 	$query = $query->where('created_at','<=', $stub['end_date'].' 23:59:59');
		 }else{
		 		$start_date = $stub['start_date'];
			 	$end_date = $stub['end_date'];
			 	$query = $query->where('created_at','>=', $start_date.' 00:00:00');
			 	$query = $query->where('created_at','<=', $end_date.' 23:59:59');
		 }
		 
		 $qcMaterialFormsQuery = $query;
		 
		 $qcMaterialForms = $query->get();
     
     $gate_entry_ids = [];

		 $contracts = [];
		 
		 if(count($qcMaterialForms)){
			 $gate_entry_ids = array_column($qcMaterialForms->toArray(), 'ge_id');
			 //$obj = new Models\RateContracts;
	 		 //$obj->updateContractRates($gate_entry_ids); 	
		 }

		 $qcMaterialForms = $qcMaterialFormsQuery->with('rateContract.contractsStockItems','laborPayment')->get();
		
		 $wtUnits = Models\WeightUnits::get();

		 $this->load->view('data/rate-entry', [
		 		'forms' => $qcMaterialForms,
		 		'accounts' => $accounts,
		 		'ge_ids' => $ge_ids,
		 		'stock_items' => $stock_items,
		 		'stock_groups' => $stock_groups,
		 		'wtUnits' => $wtUnits,
		 		'stub' => $stub,
		 		'css_files' 	 => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
		 		'js_files' => [
						base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
						base_url('assets/js/numeral.js'),
					],
		 	]);
	}



	public function rateEntryUpdate()
	{ 
		if(empty($_POST))
			return 404;
			$string = '';
			if(!empty($_GET)){
				$string = http_build_query($_GET);
			}	

		 $data = $_POST['data'];
	
		 foreach ($data as $gateEntryId => $stockItems) {
		 		foreach ($stockItems as $key => $value) 
		 				Models\GEGodownQcLaborAllocation::where('id',$key)->update($value);
		 }
		 
		 redirect('data/rateEntry/?'.$string);
		 
	}

	public function forms()
	{
		$crud = new grocery_CRUD();
		if($crud->getState() == 'add')
			redirect('manager/formCreate/');

		$crud->set_theme('datatables');
		$crud->where('deleted_at','0000-00-00 00:00:00');
		$crud->set_table('forms');
		$crud->columns('name','type','created_at');
		$crud->unset_edit();
		$crud->unset_read();
		$crud->callback_delete(array($this,'delete_form_relationship_tables_data'));
		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');
		$crud->field_type('deleted_at','hidden');
		$crud->add_action('Edit', '', '','ui-icon-pencil', array($this,'editFormRedirect'));
		$crud->field_type('type','dropdown', ['IN' => 'IN', 'OUT' => 'OUT']);
		$crud->callback_edit_field('phone',array($this,'edit_field_callback_1'));
		$crud->callback_before_update(array($this,'add_updated_at_value'));
		$output = $crud->render();
		$output->title = 'Labour Accounts';
		$this->_example_output($output);
	}


	function delete_daily_labor_accounts($labour_type_ids,$ge_qc_lab_all){
			


			foreach ($labour_type_ids as $key => $lbr_type_id) {
				 $ge_ids = [];
				 
				 if(count($ge_qc_lab_all[$lbr_type_id]))
					 $ge_ids = explode(',', $ge_qc_lab_all[$lbr_type_id]);
					
					foreach ($ge_ids as $key => $ge_id)
						  Models\GEGodownQcLaborAllocation::where('labour_job_type_id',$lbr_type_id)
																					->where('id',$ge_id)->delete();
					
			}
			return true;
	}

	function delete_custom_labor_job(){
		if(!isset($_GET['params']['god_lab_all_id'])){
			failure('Unable to delete entry');
			redirect('data/dailyLabourAccounts/?'.http_build_query($_GET['params']));
		}

		Models\GEGodownQcLaborAllocation::where('id',$_GET['params']['god_lab_all_id'])->delete();
		success('Entry Deleted Successfully');
		redirect('data/dailyLabourAccounts/?'.http_build_query($_GET['params']));
	}

	function delete_form_relationship_tables_data($primary_key){
		
		$count = Models\GateEntry::where('form_id', $primary_key)->count();

		if($count){
			Models\Forms::where('id', $primary_key)->delete();
			return true;
		}

		Models\Forms::where('id', $primary_key)->forceDelete();

		$form_modules = Models\FormModules::select('id')->where('form_id', $primary_key)->get();
	
		$ids = [];	
		if(!empty($form_modules))		{
			$form_modules = $form_modules->toArray();
		  $ids = array_column($form_modules,'id');

		}
	
		Models\FormModulesLabourJobCategories::whereIn('form_modules_id', $ids)->forceDelete();
		Models\FormModulesQualityCutTypes::whereIn('form_modules_id', $ids)->forceDelete();
		Models\FormModulesStockGroups::whereIn('form_modules_id', $ids)->forceDelete();
		Models\FormModulesStockItems::whereIn('form_modules_id', $ids)->forceDelete();

	  Models\FormModules::select('id')->where('form_id', $primary_key)->forceDelete();

		return true;
	}

	function editFormRedirect($primary_key , $row){
		return site_url('manager/formEdit/'.$primary_key);
	}

	public function add_updated_at_value($post)
	{
		$post['updated_at'] = date('Y-m-d H:i:s');
		return $post;
	}

	public function gateEntryConfig()
	{
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('gate_entry_config');
		$crud->set_relation('form_id', 'forms','{name}');
		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');
		$crud->callback_before_update(array($this,'add_updated_at_value'));

		$crud->unset_columns(array('created_at','updated_at'));

		
		$output = $crud->render();

		$output->title = 'Labour Accounts';
		$this->_example_output($output);
	}

	function on_update_encrypt_password_callback($post_array){
		if($post_array['password'] != '__DEFAULT_PASSWORD_'){
      $password=$post_array['password'];
			$hasher = new PasswordHash(
	    		$this->config->item('phpass_hash_strength', 'tank_auth'),
		    	$this->config->item('phpass_hash_portable', 'tank_auth')
			);

			$post_array['password'] = $hasher->HashPassword($password);
			$post_array['activated'] = 1;
			return $post_array;
		}

		unset($post_array['password']);
		return $post_array;
	}

	  function edit_password_callback($post_array){
		return '<input type="password" class="form-control" value="__DEFAULT_PASSWORD_" name="password" style="width:462px">';
	}

	public function labour_job_categories()
	{
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('labour_job_categories');
		$crud->set_relation_n_n('Accounts', 'labour_job_category_accounts_relation', 'accounts', 'labour_job_category_id', 'account_id', 'name');
		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');
		$crud->callback_before_update(array($this,'add_updated_at_value'));

		$crud->unset_columns(array('created_at','updated_at'));
		
		$output = $crud->render();

		$output->title = 'Labour Job Categories';
		$this->_example_output($output);
	}

	public function labour_job_types()
	{
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('labour_job_types');
		$crud->set_relation('labour_job_category_id', 'labour_job_categories','{name}');
		$crud->display_as('labour_job_category_id','Job category');
		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');
		$crud->callback_before_update(array($this,'add_updated_at_value'));
		$crud->unset_columns(array('created_at','updated_at'));
		$crud->order_by('created_at','desc');
		$output = $crud->render();
		$output->title = 'Labour Job Types';
		$this->_example_output($output);
	}


	public function labour_job_rates()
	{

		$category = Models\AccountCategories::where('name', 'Labour Party')->first();
		$accounts = Models\AccountsCategoriesRelation::where('account_category_id', $category->id)
													 ->with('accounts')
													 ->get();
		$accounts = array_column($accounts->toArray(), 'accounts');
		$selectAccount = isset($_GET['account_id']) ? intval($_GET['account_id']) : 0;
		$jobTypes  = [];
		$rates  = [];


		usort($accounts, function($a, $b) {
		  return strcmp($a["name"], $b["name"]);
		});

		if ($selectAccount > 0)
		{
			$categories = Models\LabourJobCategoryAccountsRelation::where('account_id',$selectAccount)->get();
			$categoriesIds = array_column($categories->toArray(), 'labour_job_category_id');


			$jobTypes = Models\LabourJobTypes::whereIn('labour_job_category_id', $categoriesIds)->get()->toArray();
			$priceList =  Models\LabourPartyJobTypes::where('account_id', $selectAccount)
													  ->whereIn('labour_job_type_id', array_column($jobTypes, 'id'))
													  ->get();
			foreach ($priceList as $price)
				$rates[$price->labour_job_type_id]  = $price->rate;
		}

		$this->load->view('data/labour_job_rates', [ 
			'accounts' => $accounts,
			'jobTypes' => $jobTypes,
			'rates' => $rates,
			'account_id' => $selectAccount,
		]);
	}

	public function store_labour_job_rates()
	{
		$data = $_POST;
		$account_id = $data['account_id'];    

	    foreach ($data['labour_job_type'] as $labour_job_type_id => $rate) 
	    {
	    	if (empty($rate))
	    		continue;

			$record = Models\LabourPartyJobTypes::where('account_id', $account_id)
												->where('labour_job_type_id', $labour_job_type_id);
			
			if ($record->count() > 0)
			{
				$record->update(['rate' => $rate]);
			}
			else
			{
				Models\LabourPartyJobTypes::create([
					'labour_job_type_id' => $labour_job_type_id,
					'account_id' 		 => $account_id,
					'rate' 				 => $rate,
				]);
			}
	    }

	    $this->session->set_flashdata('success_msg', 'Price Updated successfully.');
	    redirect('data/labour_job_rates/?'. http_build_query(['account_id' => $account_id]));
	}
	
/*	public function getForlumaApplied()
	{
		$id = $_POST;
		echo "<script>alert('Hello');</script>";
	}
	*/
	//17-05-2018 by bunty
	
	public function bag_account_details()
	{
		$stock_group_id = 0;
	    $filteredResults = [];	
		$data = [];
		$get_string = '';
		$get_string = $_GET;
		$stub = [
		  	'start_date' => date('Y-m-d'),
		  	'end_date' => date('Y-m-d')
		  ];

		  $StockGroups = Models\StockGroups::get();
			
		 	if(!empty($_GET)){
		 	
		 			$postData = $_GET;
		 			$get_string = $_GET;
		 			if(!empty($postData['start_date']))
		 				$stub['start_date'] = $postData['start_date'];
		 			
		 			if(!empty($postData['end_date']))
		 				$stub['end_date'] = $postData['end_date'];

		 			if(isset($postData['_today_filter'])){
		 				$stub['start_date'] = date('Y-m-d');	
		 				$stub['end_date'] = date('Y-m-d');
		 			}
					
					$stock_group_id = $postData['stock_group_id'];
					
					$qry = "select * from stock_groups where id In (".implode(",",$stock_group_id).")";
					$fth =$this->db->query($qry);
					$rslt = $fth->result();
					foreach($rslt as $key => $results){
						$data['stockGroup'][] = $results->name;
					}
					
					$start_date = $postData['start_date'];
					$end_date = $postData['end_date'];
				
				
				//For Gate Entry In
		 		$query = "select DISTINCT ac.name as account_name,ac.id as account_id, si.id as item_id,si.name as item_name,ge.id as gate_id,ge.gate_pass_no as gate_pass,ge.entry_type,ge.created_at as created_date, SUM(ge_bt.bags) as bags from stock_items as si left join ge_bag_types as ge_bt on ge_bt.stock_item_id = si.id left join gate_entries as ge on ge.id = ge_bt.ge_id left join accounts as ac on ac.id = ge.account_id where si.stock_group_id In (".implode(',',$stock_group_id).")  and ge.created_at >= '".$start_date."' and ge.created_at <= '".$end_date."' IS NOT NULL group by ac.name ,si.id,ac.id, ge.id";
				
				$fetch =$this->db->query($query);
				$results = $fetch->result();
				$items = array();
				foreach($results as $key => $rslts)
				{
					
					$data[$key]['item_id'] = $rslts->item_id;
					$data[$key]['account_id'] = $rslts->account_id;
					$data[$key]['account_name'] = $rslts->account_name;
					$data[$key]['bags'] = $rslts->bags;
				}
				
				//For gate Entry OUT
				$query1 = "select DISTINCT ac.name as account_name,ac.id as account_id,si.id as item_id,si.name as item_name,ge.id as gate_id,ge.gate_pass_no as gate_pass,ge.entry_type,ge.created_at as created_date, SUM(ge_si.bags) as bags from stock_items as si left join ge_stock_items as ge_si on ge_si.stock_item_id = si.id left join gate_entries as ge on ge.id = ge_si.ge_id left join accounts as ac on ac.id = ge.account_id where si.stock_group_id In (".implode(',',$stock_group_id).") and ge.created_at >= '".$start_date."' and ge.created_at <= '".$end_date."' IS NOT NULL group by ac.name ,si.id,ac.id, ge.id";
				
				$fetch1 =$this->db->query($query1);
				$results1 = $fetch1->result();
				$items1 = array();
				foreach($results1 as $key => $rslts1)
				{
					$data[$key]['bags_out'] = $rslts1->bags;
					
					if(isset($data[$key]['bags_out']) && isset($data[$key]['bags']))
					{
						$data[$key]['total_bags'] = $data[$key]['bags'] - $data[$key]['bags_out'];
					}
					else{
						if(isset( $data[$key]['bags']))
						{
							$data[$key]['total_bags'] = $data[$key]['bags'];
						}
						
					}	
				}
			}
			// echo "<pre>";
			// print_r($data);
			// die;
			
			$get_string['start_date'] = $stub['start_date'];
		 	$get_string['end_date'] = $stub['end_date'];
		 	
		$this->load->view('data/bag_account_details', [
					'data' => $data,
					'stub' => $stub,
					'stockGroups' => $StockGroups,
					'stock_group_id' => $stock_group_id,
					'get_string' => http_build_query($get_string),
					'css_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
				  'js_files' => [
					   base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
					   base_url('assets/js/moment.js'),
						 base_url('assets/js/numeral.js'),
					   base_url('assets/js/labour-acc-rate-cal.js'),
				   ],
  		  ]);
	}
	
	public function PartyBagAccount()
	{
		
		if(!empty($_POST)){
			$postData = $_POST;
			$acnt_name = $postData['acnt_name'];
			$start_date = $postData['start_date'];
			$end_date = $postData['end_date'];
			$query = "select ac.name as account_name,ac.id as account_id,si.id as item_id,si.name as item_name,ge.id as gate_id,ge.gate_pass_no as gate_pass_no,ge.created_at as gate_date,ge.gate_pass_no as gate_pass,ge.entry_type,ge.created_at as created_date,ge_si.bags as bags from accounts as ac left join gate_entries as ge on ge.account_id =ac.id left join ge_stock_items as ge_si on ge_si.ge_id = ge.id left join stock_items as si on si.id = ge_si.stock_item_id where ac.name = '".$acnt_name."' and ge.created_at >= '".$start_date."' and ge.created_at <= '".$end_date."' IS NOT NULL group by cast(ge.created_at as date),ac.name,si.id,si.name";
			//echo $query;	
			$fetch =$this->db->query($query);
			$results = $fetch->result();
				$arrdata = array();
			foreach($results as $key => $rslt)
			{
				if(isset($rslt->gate_pass_no) && isset($rslt->gate_date) && isset($rslt->item_name) && isset($rslt->item_id) && isset($rslt->bags))
				{
					$data[$key]['gate_pass_no'] = $rslt->gate_pass_no;
					$data[$key]['gate_date'] = $rslt->gate_date;
					$data[$key]['item_name'] = $rslt->item_name;
					$data[$key]['item_id'] = $rslt->item_id;
					$data[$key]['bags'] = $rslt->bags;
				}
				
			}
			$items = array();
			foreach($data as $dt)
			{	
				//items
				if(isset($dt['item_name'])) {
					if(!in_array($dt['item_name'],$items))
					{
						$data['items'][] = (object) [ 
								'item_name' => $dt['item_name'],'bags' => $dt['bags'] 
						];
					}
				}
				$items[] = $dt['item_name'];
			}

			echo json_encode($data);
		}
	}
	
	
	public function PayBagAmount($account_id = NULL)
	{
		
		$party_name_id = 0;
	    $filteredResults = [];	
		$data = [];
		$get_string = '';
		$get_string = $_GET;
		$stub = ['date' => date('Y-m-d')];
			//Original query
		  $accounts = Models\AccountsGroups::where('id','11')->where('id','15')->orwhere('group_id','11')->orwhere('group_id','15')->get();
		  
			//Now used	
			//$accounts = Models\Accounts::get();
			
			
			//For payment accounts 
			$sql = "SELECT * FROM accounts WHERE name LIKE 'cash%' OR name LIKE 'bank%'";
			$qry =$this->db->query($sql);
			$rslt = $qry->result();
			foreach($rslt as $rslts)
			{
				$data['payment_accounts'][] = $rslts;
			}
			
			if(empty($account_id))
			{
				if(!empty($_GET))
				{
					$postData = $_GET;
					$get_string = $_GET;
					$party_name_id = $postData['party_name_id'];
					$date = $postData['date'];
					if(!empty($postData['date']))
		 				$stub['date'] = $postData['date'];
				}else{
					$get_string = $account_id;
				}
				
			}
			else{
				$party_name_id = $account_id;
				
			}			
			
			
		 	if(!empty($party_name_id))
			{
		 	
		 		$query = "SELECT ge.id as gate_id,ge.gate_pass_no as gate_pass,ge.entry_type,ge.created_at,ac.id as account_id,ac.name as account_name FROM `gate_entries` as ge left join accounts as ac on ac.id = ge.account_id WHERE ge.`account_id`= ".$party_name_id."";
				$fetch =$this->db->query($query);
				$results = $fetch->result();
				foreach($results as $key => $rslt)
				{
					if($rslt->entry_type == 'IN')
					{
						$sub_query1 = "select * from ge_bag_types as ge_bt
						left join stock_items as si on si.id = ge_bt.stock_item_id left join rate_contract_stock_items as rcs on rcs.stock_item_id = si.id where ge_bt.ge_id =".$rslt->gate_id;
						$fetch1 =$this->db->query($sub_query1);
						$sub_result1 = $fetch1->result();
						foreach($sub_result1 as $key1 => $rslt1)
						{
							$data[$key1]['bagsIn'] = $rslt1->bags;
							$data[$key1]['item_name'] = $rslt1->name;
							$data[$key1]['item_id'] = $rslt1->stock_item_id;
							$data[$key1]['contract_id'] = $rslt1->contract_id;
							$data[$key1]['rate'] = $rslt1->rate;
						}
					}
					else{
						$sub_query2 = "select * from ge_stock_items as ge_si left join stock_items as si on si.id = ge_si.stock_item_id left join rate_contract_stock_items as rcs on rcs.stock_item_id = si.id where ge_si.ge_id =".$rslt->gate_id;
						$fetch2 =$this->db->query($sub_query2);
						$sub_result2 = $fetch2->result();
						foreach($sub_result2 as $key2 => $rslt2)
						{
							$data[$key2]['bagsOut'] = $rslt2->bags;
							$data[$key2]['item_name'] = $rslt2->name;
							$data[$key2]['item_id'] = $rslt2->stock_item_id;
							$data[$key2]['contract_id'] = $rslt2->contract_id;
							$data[$key2]['rate'] = $rslt2->rate;
						}
					}
					
					$data[$key]['gate_id'] = $rslt->gate_id;
					$data[$key]['gate_pass'] = $rslt->gate_pass;
					$data[$key]['gate_date'] = $rslt->created_at;
				}
				
				$arrData = array();	
				 foreach($data as $key => $dt)
				 {
					if(isset($dt['bagsIn']) && isset($dt['bagsOut']))
					{
						$data[$key]['total_bags'] = $dt['bagsIn'] - $dt['bagsOut'];
					}
				 }
			}
			
				$get_string['date'] = $stub['date'];
				$this->load->view('data/pay_bag_amount', [
					'data' => $data,
					'stub' => $stub,
					'accounts' => $accounts,
					'party_name_id' => $party_name_id,
					'get_string' => http_build_query($get_string),
					'css_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
				  'js_files' => [
					   base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
					   base_url('assets/js/moment.js'),
						 base_url('assets/js/numeral.js'),
					   base_url('assets/js/labour-acc-rate-cal.js'),
				   ],
  		  ]);
	}
	
	//For Saving payment bag account's data
	public function updatePartyBagAccount()
	{
		$date = date('Y-m-d');
		$data = array_merge($_POST,$_GET);
		
		$query = "select * from accounts where id =".$data['pay_account'];
		$fetch =$this->db->query($query);
		$results = $fetch->result();
		foreach($results as $result)
		{
			$data['transaction_type'] = $result->name;
		}
		
		if(isset($data['date']))
		{
			$date = $data['date'];
		}
		else{
			$date = date('Y-m-d');
		}
		
		$transaction = Models\Transactions::create([
			'entry_type' => $data['transaction_type'],
			'transaction_date' => $date,
			'created_at' => date('Y-m-d'),
			'amount' => $data['total_amount'],
			'secondary_account_id' => $data['party_name_id']
		]);
		
		if($transaction)
		{
			success('Payment completed.');
			redirect('data/PayBagAmount/?'.http_build_query($_GET));	
		}
	}
	
}
