<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Weight_receipt extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('tank_auth');
	}

	function print_slip($gate_entry_id)
	{	
		$redirect_url = '';
		if(isset($_GET['sale_purchase_report_print'])){
			$redirect_url = site_url('data/sale_purchase_gate_entries').'?'.http_build_query($_GET);
		}else{
			$redirect_url = site_url('dashboard/index');
		}

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
		
		$this->load->view('weight_receipt/print', array(
			'data' => $gateEntry,
			'redirect_url' => $redirect_url,
			'cmr_details' =>  Models\GECMRDetails::where('ge_id', $gate_entry_id)->with('market')->first(),
			'canDisplay' => function($value){
				if (is_null($value) || empty(trim($value)))
					return 'style="display:none"';
				else
					return '';
			}
		));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
