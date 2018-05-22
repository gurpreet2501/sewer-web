<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Journal_entry extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		auth_force();
	}
  
   public function _example_output($output = null)
	{
		$this->load->view('crud.php',(array)$output);
	}

	public function addTransaction(){

		$groups = [
			'CashTransactionMenuItems','BankAccounts','Cash-in-hand','BankODA/c',
			'SecuredLoans'
		];

		$groupIds = Models\AccountsGroups::select('id')->whereIn('name', $groups)->get()->toArray();
		$groupIds = array_column($groupIds, 'id');

    $accounts	=	Models\Accounts::whereNotIn('accounts_group_id', $groupIds)->get();

		$fromDate = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-d');
		$toDate   = isset($_GET['to_date'])   ? $_GET['to_date']   : date('Y-m-d');

		$transactions = Models\Transactions::
			                 	between($fromDate, $toDate)
			                 ->where('entry_type','J')
			                 ->orderBy('transaction_date', 'ASC')->get();

		$this->load->view('journal-entry/add-transaction', [
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
				base_url('assets/js/vue/journal-entry.js'),
				base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
				base_url('assets/js/vue/select2.component.js'),
				base_url('assets/js/components/agdropdown.js'),
			],
			'for_js' => [
				'from_date' 	 =>  $fromDate,
				'to_date' 		 =>  $toDate,
				'journal_transactions' => $transactions,
				'accounts' => $accounts,
			]
		]);
	}

	public function addTransactionPost(){
			$data = $_POST;
			
			if(!isset($data['trx']))
				$data['trx'] = [];

			$toKeep = array_filter(array_column($data['trx'],'id'), function($id){
				return (Boolean)intval($id);
			});

			Models\Transactions::between($data['from_date'], $data['to_date'])
				->whereNotIn('id', $toKeep)
				->delete();
				
			foreach($data['trx'] as $trx){
				$trx['amount'] = str_replace(',','',$trx['amount']);
				if(!floatval($trx['amount']))
					continue;
				$saveData = $trx;
				$saveData['entry_type'] = 'J';
				
				unset($saveData['id']);
				if(intval($trx['id']))
					Models\Transactions::where('id',$trx['id'])->update($saveData);
				else{
					$saveData['entry_type'] = 'J';
					Models\Transactions::create($saveData);

				}
			}

			redirect('journal_entry/addTransaction/?' . http_build_query([
				'from_date' => $_POST['from_date'],
				'to_date'  => $_POST['to_date'],
				'alert'    => 'Transactions added successfully.'
			]));
	}


}

