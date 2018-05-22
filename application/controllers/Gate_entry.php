<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
use App\Libs\GateEntryAction;
class Gate_entry extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		auth_force();
		$this->load->helper('url');
		$this->load->library('tank_auth');
	}

	function view($gate_entry_id)
	{
		
 		if(!Models\GateEntry::where('id', $gate_entry_id)->count())	
			return;

			$gateEntry = Models\GateEntry::where('id', $gate_entry_id)
			            ->with('bagTypes.stockItem')
			            ->with('qualityCuts.qualityCutType')
									->with('godownQcLaborAllocation.stockItems.stockGroup')->first()->toArray();
			
			$gateEntry['account_name'] = get_account_name($gateEntry['account_id']);
			$gateEntry['stock_group_name'] = get_stock_group_name($gateEntry['stock_group_id']);
		
			unset($gateEntry['account_id']);
			unset($gateEntry['stock_group_id']);
			
			$this->load->view('gate_entry/view', array(
				'data' => $gateEntry,
				'cmr_details' =>  Models\GECMRDetails::where('ge_id', $gate_entry_id)->with('market')->first(),
				'canDisplay' => function($value){
					if (is_null($value) || empty(trim($value)))
						return 'style="display:none"';
					else
						return '';
				} 
			));
	}


	function cancel(){
		$data = $_GET;
		
		GateEntryAction::cancel($data['reason'], $data['user_id'], $data['ge_id']);
		success('Gate Entry Canceled Successfully');
		redirect('dashboard/index');

	}




}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
