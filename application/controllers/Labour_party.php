<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Labour_party extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		auth_force();
	}
  
   public function _example_output($output = null)
	{
		$this->load->view('crud.php',(array)$output);
	}

	public function show_list(){
		$accCat = Models\AccountCategories::where('name','Labour Party')->first();

		if(empty($accCat)){
			failure('Account Category Labour Party Does not exists in DB.');
			redirect('dashboard/index');
		}	

		$crud = new grocery_CRUD();
		if($crud->getState() == 'add')
			redirect('labour_party/add');
   
		$crud->unset_read();
		$crud->unset_edit();
		$crud->unset_delete();

		$crud->set_theme('datatables');
		$crud->set_primary_key('account_id');
		$crud->display_as('account_id','Labour Party Name');
		$crud->columns('account_id');
		$crud->add_action('edit', '', 'labour_party/edit','ui-icon-pencil');
		$crud->set_relation('account_category_id','account_categories','name');
		$crud->set_table('accounts_categories_relation');
		$crud->where('account_category_id', $accCat->id);
		$crud->set_relation('account_id','accounts','name');
		$output = $crud->render();
		$this->_example_output($output);
	}

	 
  public function add(){
	  
	  $labourJobCategories = Models\LabourJobCategories::get();
	  $labourJobTypes = Models\LabourJobTypes::get();

		$this->load->view('labour_party/add',[
				'labour_job_categories' => $labourJobCategories,
				'js_files' => [
					base_url('assets/js/create-labour-party.js'),
					base_url('assets/js/labour-party-dropdown.js')
				],
				'for_js' => [
		  		'labour_job_categories'	=> $labourJobCategories,
		  		'labour_job_types'	=> $labourJobTypes,
		  		'selected_labour_job_categories' => []
				]
			]);
  }

  public function edit($id){

  	$selectedLabourJobTypes = [];

	  $selectedLabourJobCategories = Models\LabourJobCategoryAccountsRelation::where('account_id', $id)->get();
	  
	  if(!empty($selectedLabourJobCategories)){
	  	$jobcatIds = $selectedLabourJobCategories->toArray();
	  	$jobcatIds = array_column($jobcatIds,'labour_job_category_id');
	  }
	  
	  $labourJobCategories = Models\LabourJobCategories::get();

	  $labourJobTypes = Models\LabourJobTypes::with('labourJobCategory')->get();
	 
	  $labourPartyJobTypeRates = Models\LabourPartyJobTypes::where('account_id',$id)->get();
	
		$this->load->view('labour_party/edit',[
				'labour_job_categories' => $labourJobCategories,
				'account_name' => get_account_name($id),
				'account_id' => $id,
				'selected_labour_job_categories' => $jobcatIds,
				'js_files' => [
					base_url('assets/js/create-labour-party.js'),
					base_url('assets/js/labour-party-dropdown.js')
				],
				'for_js' => [
		  		'labour_job_categories'	=> $labourJobCategories,
		  		'selected_labour_job_categories' => $jobcatIds,
		  		'labour_party_job_type_rates' => !empty($labourPartyJobTypeRates) ? $labourPartyJobTypeRates->toArray() : [],
		  		'labour_job_types'	=> $labourJobTypes,
				]
			]);
  }

  public function saveForm(){

  	 $data = $_POST;
  	 
  	 $accCat = Models\AccountCategories::where('name','Labour Party')->first();
	   $data['acc_cat_id'] = $accCat->id;

	   $acc = Models\Accounts::create([
	   		'name' => $data['account_name']
	   	]);

	   $acc_cat_relation = Models\AccountsCategoriesRelation::create([
	   		'account_id' => $acc->id,
	   		'account_category_id' => $accCat->id
	   	]);

	  foreach ($data['job_category'] as $lab_job_cat_id) {
		    Models\LabourJobCategoryAccountsRelation::create([
		   		'account_id' => $acc->id,
		   		'labour_job_category_id' => $lab_job_cat_id,
		   	]);
	   } 
	   
	   foreach ($data['job_type_rate'] as $lab_job_type_id => $rate) {
		   $jobTypes = Models\LabourPartyJobTypes::create([
		   		'account_id' => $acc->id,
		   		'labour_job_type_id' => $lab_job_type_id,
		   		'rate' => $rate,
		   	]);
	   } 

	   success('Labour Party Saved Successfully');
	   redirect('labour_party/show_list');
	}

  public function updateForm(){

  	 $data = $_POST;
		 
  	 $accCat = Models\AccountCategories::where('name','Labour Party')->first();

	   $data['acc_cat_id'] = $accCat->id;

	   $acc = Models\Accounts::where('id',$data['account_id'])->update([
	   		'name' => $data['account_name']
	   	]);
	  
	  $enabledCategoryIds = []; 
	  foreach ($data['job_category'] as $lab_job_cat_id) {
	  	  $enabledCategoryIds[] = $lab_job_cat_id; 
        $exits = Models\LabourJobCategoryAccountsRelation::where('account_id', $data['account_id'])
        																				  ->where('labour_job_category_id', $lab_job_cat_id)->first();
        if(!$exits) 																				  
			    Models\LabourJobCategoryAccountsRelation::create([
			   		'account_id' => $data['account_id'],
			   		'labour_job_category_id' => $lab_job_cat_id,
			   	]);
	   } 

	   Models\LabourJobCategoryAccountsRelation::whereNotIn('labour_job_category_id',$enabledCategoryIds)
	   																					->where('account_id', $data['account_id'])			
	   																					->delete();

	  $enabledLabourJobTypes = []; 																					
	   
	  foreach ($data['job_type_rate'] as $lab_job_type_id => $rate) {
 	
 		    $job_type_exsits = Models\LabourPartyJobTypes::where('account_id', $data['account_id'])
 		   																						  ->where('labour_job_type_id', $lab_job_type_id)->get();
 		   																			  
 		   if(!count($job_type_exsits))	{

 		   	 $jobTypes = Models\LabourPartyJobTypes::create([
		   		'account_id' => $data['account_id'],
		   		'labour_job_type_id' => $lab_job_type_id,
		   		'rate' => $rate,
		   	]);
		   		
		   		$enabledLabourJobTypes[] = $jobTypes->id;	

 		   }																						  
 		    
 		   $enabledLabourJobTypes[]  = $lab_job_type_id;

			 Models\LabourPartyJobTypes::where('account_id', $data['account_id'])
																					  ->where('labour_job_type_id', $lab_job_type_id)->update([
																					      'rate' =>  	$rate
																					  	]); 	
																			
		   
	   } 


	   Models\LabourPartyJobTypes::whereNotIn('labour_job_type_id', $enabledLabourJobTypes)
	   																					->where('account_id', $data['account_id'])			
	   																					->delete();

 	   success('Labour Party Updated Successfully');
	   redirect('labour_party/edit/'.$data['account_id']);
	}


}

