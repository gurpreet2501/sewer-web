<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
use Dompdf\Dompdf;
use App\Libs\PurchaseReport;
class Manager_dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		auth_force();
		$this->load->helper('url');
		$this->load->library('tank_auth');
	}

	function index()
	{
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('transactions');
		$crud->unset_columns('created_at','updated_at');
		$crud->unset_edit()->unset_add()->unset_delete()->unset_export()->unset_print();
		$crud->set_relation('account_id', 'accounts','{name}');
		$crud->display_as('account_id', 'Account');
		$this->load->view('manger_dashboard/cash_transaction/view', (array)$crud->render());
	}

	function edited_gate_entries($ge_id){
		if(empty($ge_id))
			return 404;
		$data = Models\GateEntryDiff::where('gate_entry_id', $ge_id)->get();
		$this->load->view('manger_dashboard/edited_gate_entries',[
			'data' => $data
		]);
	}

   function all_gate_entry_changes(){
		
   		$gate_entries = Models\GateEntry::with('differences')->with('accounts')->orderBy('id','DESC')->get();

   	
		$this->load->view('manger_dashboard/all_gate_entry_changes',[
			'ge' => $gate_entries
		]);
	}

	function machinery_parts()
	{

		//Read All Stock Groups
		$account_groups = Models\AccountsGroups::get();

		$accounts = Models\Accounts::get();
		
		$this->load->library('grocery_CRUD');

		$crud = new grocery_CRUD();
		
		$crud->callback_field('account_id', array($this,'select2_callback_for_accounts'));

		$crud->set_theme('datatables');

		$crud->required_fields('account_id','invoice_num','amount','challan_invoice_date');

		$crud->set_lang_string('list_add','Machinery Parts/Consumables Received')
					   ->set_lang_string('list_record','');

		$crud->set_table('machinery_parts');

		$crud->field_type('date','hidden', date('Y-m-d'));

		$crud->display_as('challan_invoice_date','Challan/Invoice Date');
		
		$crud->set_relation('account_id', 'accounts','{name}');

		$crud->set_relation('godown_id', 'godowns','{name}', array('godown_type' => 'Plant'));

		$crud->display_as([
			'account_id' => 'Account',
			'godown_id' => 'Plant Allocation',
			'invoice_num' => 'Invoice/Chalan No.',
		]);
		$crud->columns('account_id','invoice_num','challan_invoice_date','godown_id','amount','material_description','bill_image');
		$crud->edit_fields('account_id','invoice_num','challan_invoice_date','godown_id','amount','material_description','bill_image');
	
		$crud->add_fields('account_id','invoice_num','challan_invoice_date','godown_id','amount','material_description','bill_image');
		$crud->set_field_upload('bill_image','assets/uploads/files');		
		$crud->unset_columns(array('created_at','updated_at'));

		$crud->callback_before_upload(function($upload, $info){	
			$fileType = $upload[$info->encrypted_field_name]['type'];
			if (!in_array($fileType, ['image/jpeg', 'image/png']))
   				return 'Sorry, we can upload only PNG-images here.';
   			return true;
		});

		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));

		$crud->field_type('updated_at','hidden');

		$output = $crud->render();
		
    array_push($output->js_files,
     			base_url('assets/js/add-custom-control-in-crud.js'),
			    // base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
     			base_url('assets/js/vue/select2.component.js'),
     			base_url('assets/js/components/datepicker.js'),
     			base_url('assets/js/vue/crud-accounts-dropdown.js')
     			);
  if($crud->getState() == 'add' || $crud->getState() == 'edit')
    	array_push($output->css_files,base_url('assets/css/input-custom-size-crud.css'));

		$output->for_js = [
			'account_groups' => $account_groups,
			'accounts' => $accounts
		];
		
		$this->load->view('crud', $output);
	}

	function select2_callback_for_accounts(){
		return '<div id="crud-accounts-dropdown" class="pull-left">
								<select2 name="account_id" class="form-control account_selector"
		            :options="accounts" 
		            text="name" 
		            id="id" style="width:302px"
		            >
		            <option disabled value="0">Select Account</option>
		          </select2>
		          </div>
		      ';

	}


	function cmr_markets()
	{

		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('cmr_markets');

		if(user_role() == 'operator') {
			$crud->unset_edit();
			$crud->unset_delete();
		}

		$crud->display_as('cmr_society_id','Cmr Society');
		$crud->set_relation('cmr_society_id','cmr_society','name');
		$crud->unset_columns(array('created_at','updated_at'));
		$crud->field_type('created_at','hidden', date('Y-m-d H:i:s'));
		$crud->field_type('updated_at','hidden');
		$this->load->view('crud', (array)$crud->render());

	}

	function insert_received_transactions($items, $primary_acc_id){
		$currentTransactionIds = [];
		foreach ($items as $item)
		{    
			$item['transaction_type'] = '';
		      // Removing commas from amount
    			$item['amount'] = str_replace(',','', $item['amount']); 
					  	
					$transaction_id =  !empty($item['id']) ? $item['id'] : 0;

					$currentTransactionIds[] = $transaction_id;

					if(empty($item['secondary_account_id']) || empty($item['transaction_date']))
						continue;

					$item['primary_account_id'] = $primary_acc_id;

					if($transaction_id)
						Models\Transactions::where('id', $transaction_id)->update($item);	
					else{
						
						if(empty($item['amount']))
							continue;

						Models\Transactions::create($item);			
			    }
		     
		} //foreach

		return $currentTransactionIds;

	}

	function insert_payment_transactions($items, $primary_acc_id){
		
		$currentPayIds = [];

		foreach ($items as $item)
		{   
			$item['transaction_type'] = '';
		      // Removing commas from amount
			$item['amount'] = str_replace(',','', $item['amount']);
			  	
			$transaction_id =  !empty($item['id']) ? $item['id'] : 0;

			$currentPayIds[] = $transaction_id;

			if(empty($item['secondary_account_id']) || empty($item['transaction_date']))
				continue;

			$secondary_id = $item['secondary_account_id'];

			$item['secondary_account_id'] = $primary_acc_id;

			$item['primary_account_id'] = $secondary_id;

			if($transaction_id)
				Models\Transactions::where('id', $transaction_id)->update($item);	
			else{
				if(empty($item['amount']))
					continue;
				
				Models\Transactions::create($item);			
	    }
		     
		} //foreach

		return $currentPayIds;

	}

		function store_cash_transaction()
		{
			$data = $_POST;
		
			if(!isset($data['trx']))
				$data['trx'] = [];

			$account_id = $data['primary_account_id'];	
			$toKeep = array_filter(array_column($data['trx'],'id'), function($id){
				return (Boolean)intval($id);
			});

			Models\Transactions::where(function($q) use ($account_id){	
					$q->where('primary_account_id', $account_id)
				 	  ->orWhere('secondary_account_id',  $account_id);
				})
		        ->between($data['from_date'], $data['to_date'])
				->where('entry_type','CASH')
				->whereNotIn('id', $toKeep)
				->delete();

			foreach($data['trx'] as $trx){
				$trx['amount'] = str_replace(',','',$trx['amount']);
				if(!floatval($trx['amount']))
					continue;
				$saveData = $trx;

				unset($saveData['id']);
				if(intval($trx['id']))
					Models\Transactions::where('id',$trx['id'])->update($saveData);
				else
					Models\Transactions::create($saveData);
			}
			redirect('manager_dashboard/add_cash_transaction/' . $account_id  . '?' . http_build_query([
				'from_date' => $_POST['from_date'],
				'to_date'  => $_POST['to_date'],
				'alert'    => 'Transactions added successfully.'
			]));
	}

	function purchase_daily_report()
	{
		$gateEntries = [];

		$stub = [
			'start_date' => date('Y-m-d'),
			'end_date' => date('Y-m-d'),
		];

		$gateEntries = Models\GateEntry::with('accounts')
																			 ->where('created_at','>=', $stub['start_date'].' 00:00:00')	
																			 ->where('created_at','<=', $stub['end_date'].' 23:59:59')	
			                                 ->get(); 
		// post data
		if(!empty($_POST)){

			$data = $_POST;


			$stub['start_date'] = $data['start_date'];
			$stub['end_date'] = $data['end_date'];

			$gateEntries = Models\GateEntry::with('accounts')
																			 ->where('created_at','>=', $stub['start_date'].' 00:00:00')	
																			 ->where('created_at','<=', $stub['end_date'].' 23:59:59')	
			                                 ->get(); 
			
		}
                                                              
		$this->load->view('manger_dashboard/purchase_daily_report', [
			'gate_entries' => $gateEntries,
			'stub' => $stub,
			'css_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
			'js_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js')],
		]);                       
	}

 function generate_purchase_daily_report_csv(){
 	
 	 header('Content-type: text/csv');
	 header('Content-Disposition: attachment; filename="file.csv"');
	 
	  if(empty($_GET['start_date']))
	  	return;
 
	 // if(empty($_GET['start_date'])){
	 // 		$_GET['start_date'] = date('1971-m-d H:i:s');
	 // 		$_GET['end_date'] = date('Y-m-d 23:59:59');
	 // }

 	 $gateEntries = Models\GateEntry::with('accounts')
 																		->with('cmrDetails.market')
 																		->with('cmrDetails.society')
 																		->with('bagTypes.stockItem')
 																		->with('qualityCuts.qualityCutType')
 																		->with('stockItems')
 																		->with('godownLaborAllocation.godown')
 																		->with('godownQcLaborAllocation.godown')
 																		->with('godownQcLaborAllocation.stockItems')
 																		->with('godownQcLaborAllocation.stockItems.stockGroup')
 																		->with('accounts.accountGroups')
 																		->with('accounts.accountCategories')
 																		->with('accounts.laborPartyJobTypes')
 																		->where('status','Complete')
																		->where('created_at','>=', $_GET['start_date'].' 00:00:00')	
																		->where('created_at','<=', $_GET['end_date'].' 23:59:59');
$entry_type='';

	if(isset($_GET['entry_type']))																		
	{
		$entry_type	= $_GET['entry_type'];
		$gateEntries->where('entry_type',$entry_type);                             
	}

	$gateEntries = $gateEntries->get();


  $columns = [];			   

  if(!count($gateEntries))
  	return [];
 	
 	$responses = [];
 	$keys = [
			'godownQcLaborAllocation' => [],
			'QualityCut' =>[],
			'BagTypes' =>[]
		];

	foreach ($gateEntries as $key => $ge) {
		
	   $obj = new PurchaseReport($ge);

	   list($singleResp,$singlekeys) = $obj->getReport($ge);
	   $responses[] = $singleResp;

		$keys['godownQcLaborAllocation'] = array_merge($keys['godownQcLaborAllocation'],$singlekeys['godownQcLaborAllocation']);
		$keys['QualityCut'] = array_merge($keys['QualityCut'],$singlekeys['QualityCut']);
		$keys['BagTypes'] = array_merge($keys['BagTypes'],$singlekeys['BagTypes']);
	 	$columns = array_merge($columns, array_keys($singleResp));

	 }

	 array_splice( $columns, 5, 0, $keys['BagTypes']);
	 array_splice( $columns, 5, 0, $keys['QualityCut']);
	 array_splice( $columns, 5, 0, $keys['godownQcLaborAllocation']);

	 $columns = array_unique($columns);


	$fp = fopen('php://output', 'w');
	if($entry_type == 'OUT')
		fputcsv($fp, ['Sales Report']);
	else if($entry_type == 'IN')
		fputcsv($fp, ['Purchase Report']);



fputcsv($fp, $columns);


foreach ($responses as $val) {

	$filtered = [];
	foreach ($columns as $key => $index) {
	
		if(isset($val[$index]))
			$filtered[$index] =  $val[$index];
		else
			$filtered[$index] =  '';
	}

  fputcsv($fp, $filtered);
}


fclose($fp);
   
}


	function add_cash_transaction()
	{	
		
		$primaryAccountId = intval($this->uri->segment(3));
		
		$accGroups = Models\AccountsGroups::get();
		
		$accounts = Models\Accounts::where('id','!=', $primaryAccountId)->get();

		if ($primaryAccountId == 0)
			die('Invalid Account Id');

		$fromDate = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d');
		$toDate   = isset($_GET['to_date'])   ? $_GET['to_date']   : date('Y-m-d');
	
	
		//Downloading credit and debit entries as pdf
		$pdf_download = isset($_GET['pdfDownload']) ? $_GET['pdfDownload'] : false;
		$csv_download_enabled = isset($_GET['csvDownload']) ? $_GET['csvDownload'] : false;

		if($csv_download_enabled){
		  $this->cash_transaction_report_csv($fromDate, $toDate, $primaryAccountId);
		  return;
		}
	
		if($pdf_download){
			$htmlView = $this->load->view('manger_dashboard/cash_transaction/list_posts', [
				'entries' => [
				'credit' => Models\Transactions::where('primary_account_id', $primaryAccountId)->orderBy('id', 'DESC')->get(), 
				'debit' => Models\Transactions::where('secondary_account_id', $primaryAccountId)->orderBy('id', 'DESC')->get(),
			 ]],true);

			$dompdf = new Dompdf(); 
			$dompdf->loadHtml($htmlView);
			$dompdf->setPaper('A4', 'landscape');
			$dompdf->render();
			$dompdf->stream('cash-transaction-report-'.$fromDate.'__'.$toDate);
			return;
		}

		$opening_balance = Models\Transactions::openingBalance($fromDate, $primaryAccountId);

		$opening_balance = $this->indian_number_format($opening_balance);


		$transactions = Models\Transactions::
				 whereAccountID($primaryAccountId)
                 ->between($fromDate, $toDate)
                 ->where('entry_type','CASH')
                 ->orderBy('transaction_date', 'ASC')->get();
       

		$this->load->view('manger_dashboard/cash_transaction/add', [
			'pdfDownloadEnabled' => $pdf_download,
			'dompdf' => new Dompdf(),
			'accountId' => $primaryAccountId,
			'account'  => Models\Accounts::find($primaryAccountId),
			'openingBalance' => $opening_balance,
			'closingBalance' => Models\Transactions::closingBalance($toDate, $primaryAccountId),
			'creditTotal' 	 => Models\Transactions::creditBetween($fromDate, $toDate, $primaryAccountId),
			'debitTotal'	 =>   Models\Transactions::debitBetween($fromDate, $toDate, $primaryAccountId),
			'from_date' 	 =>  $fromDate,
			'to_date' 		 =>  $toDate,
			'css_files'    =>  [
					base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css'),
					base_url('assets/css/tippy.css')
			],
			'js_files' => [
				base_url('assets/js/sha1.js'),
				base_url('assets/js/components/datepicker.js'),
				base_url('assets/js/moment.js'),
				base_url('assets/js/numeral.js'),
				base_url('assets/js/directives/tooltip.js'),
				base_url('assets/js/tippy.min.js'),
				base_url('assets/js/vue/add-cash-transaction.js'),
				base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
				base_url('assets/js/vue/select2.component.js'),
				base_url('assets/js/components/agdropdown.js'),
			],
			'for_js' => [
				'transactions' => $transactions,
				'accounts' => $accounts,
				'primary_account_id' => $primaryAccountId,
				'account_groups' => $accGroups,
				'openingBalance' => $opening_balance,
			],
			'entries' => [
				'credit' => Models\Transactions::where('entry_type','CASH')->where('primary_account_id',$primaryAccountId)->orderBy('id', 'DESC')->get(), 
				'debit' => Models\Transactions::where('entry_type','CASH')->where('secondary_account_id',$primaryAccountId)->orderBy('id', 'DESC')->get()
			]

		]);
	}

	function indian_number_format($num) {
	    $num = (string)$num;

	    $float = '';
	    if (strpos($num, '.') !== false)
			list($num, $float) = explode('.', $num);

	    if( strlen($num) < 4) 
	    	return $num;
	    $tail = substr($num,-3);
	    $head = substr($num,0,-3);
	    $head = preg_replace("/\B(?=(?:\d{2})+(?!\d))/",",",$head);

	    if (!empty($float))
	    	return $head.",".$tail . '.'. $float; 
	    else
	    	return $head.",".$tail ;
	}

	function cash_transaction_report_csv($from_date, $to_date, $primaryAccountId){
	
		header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-disposition: attachment; filename=cash-transaction-report-'.$from_date.'__'.$to_date.'.csv');
		$file = fopen("php://output","w");
		fputcsv($file, ['From '.date('Y-m-d',  strtotime($from_date)).' to '.date('Y-m-d',  strtotime($to_date))]);
		fputcsv($file, ['']);

		$creditTransactions = Models\Transactions::getTransactionByType('CREDIT', $from_date, $to_date, $primaryAccountId)->with('primaryAccount')->orderBy('id', 'DESC')->get();

		 $debitTransactions = Models\Transactions::getTransactionByType('DEBIT', $from_date, $to_date, $primaryAccountId)->with('primaryAccount')->orderBy('id', 'DESC')->get();

		//Credit Transactions
		 fputcsv($file, ['']);
		 fputcsv($file, ['Credit Transactions']);
 		 fputcsv($file, ['Account Name','Secondary Account Name','Amount','Remarks','Transaction Date']);

		 foreach ($creditTransactions as  $creditTrans) {
		    fputcsv($file, 
		    	[
		    	$creditTrans->primaryAccount->name,
		    	$creditTrans->secondaryAccount->name,
		    	$creditTrans->amount,
		    	$creditTrans->remarks,
		    	date('Y-m-d', strtotime($creditTrans->transaction_date))]);
		 }
     
     //Debit Transactions
		 fputcsv($file, ['']);
		 fputcsv($file, ['Debit Transactions']);
 		 fputcsv($file, ['Account Name','Secondary Account Name','Amount','Remarks','Transaction Date']);
		 foreach ($debitTransactions as  $debitTrans) {
		    fputcsv($file, [
			    $debitTrans->primaryAccount->name,
			    $debitTrans->secondaryAccount->name,
	 	      $debitTrans->amount,
	 	      $debitTrans->remarks,
	 	      date('Y-m-d', strtotime($debitTrans->created_at)) 
 	      ]);
		 }

		 fputcsv($file, []);
		 fclose($file); 
		 return;

	}

	function cmr_rice_quality_report()
	{	
		$list = Models\GateEntry::where('status','Partially Completed')->get();
		$this->load->view('manger_dashboard/cmr_rice_quality_report', array('list' => $list));
	}

	function bran_quality_report()
	{	
		$list = Models\GateEntry::where('status','Partially Completed')->get();
		$this->load->view('manger_dashboard/bran_quality_report', array('list' => $list));
	}

	function cmr_rice_quality_report_input($id)
	{	
		$entry = Models\GateEntry::find($id);
		$qc_types = Models\QualityCutTypes::where('stock_group_id', $entry->stock_group_id)->get();
		
		$this->load->view('manger_dashboard/cmr_rice_quality_report_input', [
				'qc_types' => $qc_types,
				'gate_entry_id' => $id,
				'js_files' 		=> [
							base_url('assets/js/store.js'),
							base_url('assets/js/vue/ge-delivery.js'),
					],
				'for_js'  => [
				  'gateEntry' => $entry,
					'qcRowTemplate' => $this->load->view('manger_dashboard/partials/qc_row', ['qc_types' => $qc_types], true),
				]
			]);
	}


	function bran_quality_report_form($id)
	{	
		$entry = Models\GateEntry::find($id);
		
		$this->load->view('manger_dashboard/bran_quality_report_form', [
			'gate_entry_id' => $id,
			'js_files' 		=> [ base_url('assets/js/vue/ge-delivery.js') ],
			'for_js'        => []
		]);
	}

	function save_cmr_rice_quality_report()
	{	
		$results = $_POST;
		
		$geDelDtls = new Models\GEDeliveryDetails();
		if(isset($results['ge_delivery_details']))
			$geDelDtls->saveDelieveryDetails($results['ge_delivery_details']);

		$geDelQc = new Models\GEDeliveryQc();
		if(isset($results['ge_delivery_qc']))

			$geDelQc->saveDelieveryQc($results['ge_delivery_qc'], $results['gate_entry_id']);
		
		success('Data Saved Successfully!');
		redirect('manager_dashboard/cmr_rice_quality_report_input/'.$results['gate_entry_id']);
	}

	function save_bran_quality_report()
	{	
		$results = $_POST;
	
		$geDelDtls = new Models\GEDeliveryDetails();
		$branQualityReport = new Models\GEBranQualityReport();

		if(isset($results['ge_delivery_details'])){
			$results['ge_delivery_details']['gate_entry_id'] = $results['gate_entry_id'];
			$geDelDtls->saveDelieveryDetails($results['ge_delivery_details']);
		}

		 if(isset($results['bran_quality_report'])){
		 	$results['bran_quality_report']['gate_entry_id'] = $results['gate_entry_id'];
		 	 $branQualityReport->saveData($results['bran_quality_report']);
		 }

		success('Data Saved Successfully!');
		redirect('manager_dashboard/bran_quality_report_form/'.$results['gate_entry_id']);
	}

	function rate_contracts()
	{
		$this->load->library('grocery_CRUD');
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('rate_contracts');
		$crud->display_as('stock_group_id','Stock Group');
		$crud->add_action('View', '', 'manager_dashboard/view_rate_contract','ui-icon-document');
		$crud->where('deleted_at',"0000-00-00 00:00:00");
		$crud->unset_columns('created_at','updated_at');
		$crud->set_relation('account_id', 'accounts','{name}');
		$crud->set_relation('stock_group_id', 'stock_groups','{name}');
		$crud->display_as('account_id', 'Account');
		$crud->callback_delete(array($this,'delete_rate_contracts'));
		$crud->columns(array('account_id','from_date','to_date','stock_group_id'));
		$crud->unset_edit()->unset_add()->unset_read()->unset_export()->unset_print();
		$this->load->view('manger_dashboard/rate_contracts/view', (array)$crud->render());
	}

	public function delete_rate_contracts($primary_key)
	{
		$t = Models\RateContracts::where('id', $primary_key)->delete();
		return true;
	}

	public function view_rate_contract($id){
		
		$data = Models\RateContracts::where('id', $id)->with('stockGroup','account','contractsStockItems.stockItem')->first();
		
		$this->load->view('manger_dashboard/view_rate_contract' , ['data' => $data]);
	}

	function add_rate_contracts()
	{  
    $stockItems = Models\StockItems::orderBy('name')->get();
		$stockGroups = Models\StockGroups::orderBy('name')->get();
		$this->load->view('manger_dashboard/rate_contracts/add', [
			'accounts'     => Models\Accounts::whereGroupName(['SundryDebtors','SundryCreditors'])->orderBy('name')->get(),
			'stock_items' => $stockItems,
			'stock_groups' => $stockGroups,
			'css_files'   => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
			'js_files' 	  => [
				base_url('assets/js/vue/rate_contracts.js'),
				base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
			],
			'for_js' => [
				'stockItems' => $stockItems,
			]

		]);
	}

	function store_rate_contracts()
	{	
		
		$post = $_POST['contract'];
	
		$record = array(
			'account_id' => $post['account_id'],
			'from_date'  => $post['from_date'],
			'stock_group_id' 	 	 => $post['stock_group_id'],
			'status' => 'ACTIVE',
			'type' => strtoupper($post['type'])
		);

		if ($post['type'] === 'quantity')
			$record['quantity'] = $post['quantity'] * 100; // Converting quintals to kg
		else
			$record['to_date'] = $post['to_date'];

		$contract = Models\RateContracts::create($record);

		foreach ($post['items'] as $item)
			$contract->contractsStockItems()->create($item);
		
		redirect('manager_dashboard/rate_contracts?alert=Transactions added successfully.');
	}

	function transactions_report_generator()
	{
		$this->load->view('manger_dashboard/transactions_report_generator',[
			'css_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
			'js_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js')],
		]);
	}

	function profit_loss_report_generator()
	{
		$this->load->view('manger_dashboard/profit_loss_report_generator',[
			'css_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')],
			'js_files' => [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js')],
		]);
	}

	function transactions_report()
	{
		$data = $_GET;

		extract($data);

		if (!isset($from_date) ||  !isset($to_date) || !isset($account_id)){
			die('Unable to generate report, data missing.');
		}

		$to_date = date('Y-m-d', strtotime($to_date))  . ' 23:59:59';
		$from_date = date('Y-m-d', strtotime($from_date)) . ' 00:00:00';
		$primaryAccount = Models\Accounts::find($account_id);
	
		// $resp = Models\Transactions::where('primary_account_id', $account_id)
		// 				   ->where('created_at', '<=', $to_date)
		// 				   ->where('created_at', '>=', $from_date)
		// 				   ->with('secondaryAccount')
		// 				   ->get();

		$resp = Models\Transactions::where('primary_account_id', $account_id)
						   ->where('created_at', '<=', $to_date)
						   ->where('created_at', '>=', $from_date)
						   ->orWhere('secondary_account_id', $account_id)
						   ->with('secondaryAccount')
						   ->with('primaryAccount')
						   // ->orderBy('created_at','DESC')
						   ->get();
					 
		//Downloading credit and debit entries as pdf

		$pdf_download = isset($_GET['pdfDownload']) ? $_GET['pdfDownload'] : false;
		
		$csvDownload = isset($_GET['csvDownload']) ? $_GET['csvDownload'] : false;
        
		if($pdf_download)
			return $this->generate_transaction_report_pdf($resp,$account_id,$from_date,$to_date,$primaryAccount);

		if($csvDownload)
			return $this->generate_transaction_report_csv($resp,$account_id,$from_date,$to_date,$primaryAccount);
		
		$this->load->view('manger_dashboard/transactions-report', [
			'records' 		  => $resp,
			'opening_balance' => Models\Transactions::openingBalance($from_date, $to_date, $account_id),
			'credit_total' 	  => Models\Transactions::creditBetween($from_date, $to_date, $account_id),
			'debit_total'	  => Models\Transactions::debitBetween($from_date, $to_date, $account_id),
			'to_date' 		  => $to_date,
			'from_date'		  => $from_date,
			'primary_account' => $primaryAccount,
			'make_date' => function($date){
				return date('d M,Y', strtotime($date));
			}
		]);
	}
  
 	function generate_transaction_report_pdf($resp,$account_id,$from_date,$to_date,$primaryAccount){
	    $htmlView = $this->load->view('manger_dashboard/transactions-report-view', ['records' => $resp,
				'opening_balance' => Models\Transactions::openingBalance($from_date, $to_date, $account_id),
				'credit_total' 	  => Models\Transactions::creditBetween($from_date, $to_date, $account_id),
				'debit_total'	  => Models\Transactions::debitBetween($from_date, $to_date, $account_id),
				'to_date' 		  => $to_date,
				'from_date'		  => $from_date,
				'primary_account' => $primaryAccount,
				'make_date' => function($date){
					return date('Y-m-d', strtotime($date));
		}],true);

		$dompdf = new Dompdf(); 
		$dompdf->set_option('isHtml5ParserEnabled', true);
		$dompdf->loadHtml($htmlView);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		$dompdf->stream(); 
		return;
	}

	function generate_transaction_report_csv($resp, $account_id, $from_date, $to_date, $primaryAccount){
		
		header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-disposition: attachment; filename=report-'.date('Y-m-d').'.csv');
		$creditTotal = Models\Transactions::creditBetween($from_date, $to_date, $account_id);
		$debitTotal  = Models\Transactions::debitBetween($from_date, $to_date, $account_id);
		$openingBalance  = Models\Transactions::openingBalance($from_date, $to_date, $account_id);
		$file = fopen("php://output","w");
		fputcsv($file, ['Navdanya Foods Pvt. Ltd.']);
		fputcsv($file, ['At.- Govindpur,']);
		fputcsv($file, ['P.O./Dt.-Bargarh. 768028.']);
		fputcsv($file, ['Odisha. India.']);
		fputcsv($file, ['CIN: U15312OR2000PTC006047']);
		fputcsv($file, ["REPORT TYPE: ".$primaryAccount->name]);
		fputcsv($file, ['Ledger Account']);
		fputcsv($file, ['From '.date('Y-m-d',  strtotime($from_date)).' to '.date('Y-m-d',  strtotime($to_date))]);
		fputcsv($file, ['']);

		fputcsv($file, ['Date','','Particulars','Vch Type','Vch No','Debit','Credit']);

		// fputcsv($file, [date('Y-m-d',  strtotime($to_date)),'Opening Balance','','',$openingBalance,'']);
		
		foreach ($resp as $v) {
				$creditEntry =  $v['id'] == $primaryAccount->id ? true : false;
				$credit = 0;
				$debit = 0;
			$type = '';	
			if($creditEntry){
				$credit = $v->amount;
				$type = 'Dr';
			}
			else{
				$type = 'Cr';
				$debit = $v->amount;				
			}
		
			fputcsv($file, [
				date('Y-m-d',  strtotime($v->created_at)), $type ,
				$v->secondaryAccount->name,
				0,0, $debit, $credit]);

		}
		
		fputcsv($file, []);
		fputcsv($file, ['','','','','',$openingBalance,$creditTotal]);
		fputcsv($file, ['','','','','Total',($openingBalance+$debitTotal),$creditTotal]);
	 
		fclose($file); 

	}

	function salesAccReport($from_date, $to_date){
		$report = [];
		$saleAccounts = Models\StockGroups::select('sales_account_id')
																				->where('sales_account_id','!=',0)
		                                    ->groupBy('sales_account_id')->get();

		foreach ($saleAccounts as $key => $value) {
		  $credit = Models\Transactions::creditCalculations($value->sales_account_id,$from_date,$to_date)->sum('amount');
		  $debit = Models\Transactions::debitCalculations($value->sales_account_id,$from_date,$to_date)->sum('amount');
		   if(!$credit && !$debit)
		  	continue;
			$report[$value->sales_account_id]['amount'] = $credit - $debit;
			$report[$value->sales_account_id]['account_name'] = get_account_name($value->sales_account_id);
    }
    return $report;

	}

	function purchaseAccReport($from_date, $to_date){
		$report = [];
		$purchaseAccounts = Models\StockGroups::select('purchase_account_id')
																				->where('purchase_account_id','!=',0)
		                                    ->groupBy('purchase_account_id')->get();
		                 
		foreach ($purchaseAccounts as $key => $value) {
		 $credit = Models\Transactions::creditCalculations($value->purchase_account_id,$from_date,$to_date)->sum('amount');
		 
		 $debit = Models\Transactions::debitCalculations($value->purchase_account_id,$from_date,$to_date)->sum('amount');
		 
		  if(!$credit && !$debit)
		  	continue;
			$report[$value->purchase_account_id]['amount'] = $credit - $debit;
			$report[$value->purchase_account_id]['account_name'] = get_account_name($value->purchase_account_id);
    }
    return $report;
    
	}

	function profit_loss_report()
	{
		$data = $_GET;
		$items = [];
		$stockGrpups = Models\StockGroups::get();
		$accounts = [];

		$categories = [
			'purchase_accounts' => ['name' => 'Purchase Accounts','type' => 'DEBIT'],
			'direct_expenses' => ['name' => 'Direct Expenses','type' => 'DEBIT'],
			'indirect_expenses' => ['name' => 'Indirect Expenses','type' => 'CREDIT'],
			'sales_accounts' => ['name' => 'Sales Accounts','type' => 'DEBIT'],
			'direct_incomes' => ['name' => 'Direct Incomes','type' => 'CREDIT'],
			'indirect_incomes' => ['name' => 'Indirect Incomes','type' => 'DEBIT'],
		];
			

		// Fetching account having these categories
		foreach($categories as $key => $cat){
		 	$catAccounts =  Models\Accounts::whereLabourParty($cat['name'])->get();
		 	if(!count($catAccounts))
		 		continue;

		 	$accounts[$key] = $catAccounts->toArray();

		}

		$total = [];
		$openingStockTotal = 0.00;
		$closingStockTotal = 0.00;

		foreach($stockGrpups as $stGrp){
			$total[$stGrp->id]['stock_group_id'] = $stGrp->id;
			$total[$stGrp->id]['stock_group_name'] = $stGrp->name;
			$openingStock = $stGrp->openingStock($data['from_date']);
			$closingStock = $stGrp->closingStock($data['to_date']);
			$total[$stGrp->id]['closing_stock_total'] = $closingStock;
			$openingStockTotal = $openingStockTotal + $openingStock;
			$closingStockTotal = $closingStockTotal + $closingStock;
			$total[$stGrp->id]['opening_stock_total'] = $openingStock;
		}
	
		$this->load->view('manger_dashboard/profit-loss-report', [
			  'accounts' => $accounts,
			  'categories' => $categories,
				'opening_closing_stock_total' => $total,
				'purchase_acc_report' => $this->purchaseAccReport($data['from_date'],$data['to_date']),
				'sales_acc_report' => $this->salesAccReport($data['from_date'],$data['to_date']),
				'make_date' => function($date){
					return date('M d,Y',strtotime($date));
				},
				'from_date' => $data['from_date'],
				'to_date' => $data['to_date'],
				'opening_stock_total' => $openingStockTotal,
				'closing_stock_total' => $closingStockTotal 
		]);
		
	}
}
