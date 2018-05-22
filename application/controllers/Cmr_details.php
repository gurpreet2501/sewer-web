<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cmr_details extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		auth_force();
		$this->load->helper('url');
		$this->load->library('tank_auth');
	}

	function add()
	{	
		$m_serial_no = Models\GECMRDetails::uniqueMSerialNo();
	
		 $stub = [
			'account_id' 	=> isset($_GET['account_id']) ? $_GET['account_id'] : '',
			'cmr_agency_id' => isset($_GET['cmr_agency_id']) ? $_GET['cmr_agency_id'] : '',
			'cmr_market_id' => isset($_GET['cmr_market_id']) ? $_GET['cmr_market_id'] : '',
			'truck_no' 		=> isset($_GET['truck_no']) ? $_GET['truck_no'] : '',
			'tp_no' 		=> isset($_GET['tp_no']) ? $_GET['tp_no'] : '',
			'tp_date' 		=> isset($_GET['tp_date']) ? $_GET['tp_date'] : '',
			'ac_note_no' 	=> isset($_GET['ac_note_no']) ? $_GET['ac_note_no'] : '',
			'ac_note_date' 	=> isset($_GET['ac_note_date']) ? $_GET['ac_note_date'] : '',
			'quintals' 		=> isset($_GET['quintals']) ? $_GET['quintals'] : '',
			'no_of_bags' 	=> isset($_GET['no_of_bags']) ? $_GET['no_of_bags'] : '',
			'm_serial_no' 	=> isset($_GET['m_serial_no']) ? $_GET['m_serial_no'] : $m_serial_no,
			'created_at'  => '',
			'updated_at'  => '',
			'cmr_society_id'=> isset($_GET['cmr_society_id']) ? $_GET['cmr_society_id'] : '',
		  ];

		$accounts = Models\Accounts::whereGroupName(['SundryDebtors','SundryCreditors'])->orderBy('name')->get();
		$cmrMarkets = Models\CMRMarkets::get();
		$cmrSocieties = Models\CMRSocieties::get();
		
		$jsFiles = [
			base_url('assets/js/components/datepicker.js'),
			base_url('assets/js/components/agdropdown.js'),
			base_url('assets/js/vue/select2.component.js'),
			base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
			base_url('assets/js/make-all-caps.js?354'),
			base_url('assets/js/vue/cmr-details.js?432'),
		];

		$cssFiles = [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')];

		$data = [
			'js_files' => $jsFiles,
			'css_files' => $cssFiles,
			'for_js' => [
				'accounts' => $accounts,
				'markets' => $cmrMarkets,
				'cmr_societies' => $cmrSocieties,
				'cmr_agencies' 	=> Models\CMRAgencies::get(),
				'stub' => $stub,
			]
		];
		
		$this->load->view('cmr_details/add', $data);
		
	}

	function edit($id)
	{	

		 $stub = [
           'account_id'  => '',
           'cmr_agency_id'  => '',
           'cmr_market_id'  => '',
           'truck_no'  => '',
           'tp_no'  => '',
           'tp_date'  =>'',
           'ac_note_no'  => '',
           'ac_note_date'  => '',
           'quintals'  => '',
           'no_of_bags'  => '',
           'm_serial_no'  => '',
           'created_at'  => '',
           'updated_at'  => '',
           'cmr_society_id'  => '',
		  ];

		$accounts = Models\Accounts::whereGroupName(['SundryDebtors','SundryCreditors'])->orderBy('name')->get();
		$cmrMarkets = Models\CMRMarkets::get();
		$cmrSocieties = Models\CMRSocieties::get();
		
		$jsFiles = [
			base_url('assets/js/components/datepicker.js'),
			base_url('assets/js/components/agdropdown.js'),
			base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
			base_url('assets/js/make-all-caps.js?354'),
			base_url('assets/js/vue/cmr-details.js?432'),
		];

		$cssFiles = [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')];

		$entry = Models\GECMRDetails::where('id',$id)->first();
		$stub = $entry->toArray();

		$data = [
			'entry_id' => $id,
			'js_files' => $jsFiles,
			'css_files' => $cssFiles,
			'for_js' => [
				'accounts' 		=> $accounts,
				'markets' 		=> $cmrMarkets,
				'cmr_societies' => $cmrSocieties,
				'cmr_agencies' 	=> Models\CMRAgencies::get(),
				'stub' 			=> $stub,
			]
		];

		$this->load->view('cmr_details/edit',$data);		
	} 

	function view($id)
	{	

		 $stub = [
           'account_id'  => '',
           'cmr_agency_id'  => '',
           'cmr_market_id'  => '',
           'truck_no'  => '',
           'tp_no'  => '',
           'tp_date'  =>'',
           'ac_note_no'  => '',
           'ac_note_date'  => '',
           'quintals'  => '',
           'no_of_bags'  => '',
           'm_serial_no'  => '',
           'created_at'  => '',
           'updated_at'  => '',
           'cmr_society_id'  => '',
		  ];

		$accounts = Models\Accounts::whereGroupName(['SundryDebtors','SundryCreditors'])->orderBy('name')->get();
		$cmrMarkets = Models\CMRMarkets::get();
		$cmrSocieties = Models\CMRSocieties::get();
		
		$jsFiles = [
			base_url('assets/js/components/datepicker.js'),
			base_url('assets/js/components/agdropdown.js'),
			base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
			base_url('assets/js/make-all-caps.js?354'),
			base_url('assets/js/vue/cmr-details.js?432'),
		];

		$cssFiles = [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')];

		$entry = Models\GECMRDetails::where('id',$id)->first();
		
		$stub = $entry->toArray();

		$data = [
			  'entry_id' => $id,
			  'js_files' => $jsFiles,
				'css_files' => $cssFiles,
				'for_js' => [
					'accounts' => $accounts,
					'markets' => $cmrMarkets,
					'cmr_societies' => $cmrSocieties,
					'stub' => $stub,
				]
		];

		$this->load->view('cmr_details/view',$data);
		
	} 

	function cmr_post(){

		$_POST['cmr_details']['gate_entry_id'] = 0;
		$m_serial_no = intval(@$_POST['cmr_details']['m_serial_no']);

		if (($m_serial_no > 0) !== true){
			failure('invalid M.Serial No.');
		 	redirect('cmr_details/add?' . http_build_query($_POST['cmr_details']));
		 	return;
		}

		$duplicate = Models\GECMRDetails::where('m_serial_no', $m_serial_no)->count();

		if ($duplicate){
		 	failure('duplicate M.Serial No.');
		 	redirect('cmr_details/add?' . http_build_query($_POST['cmr_details']));
		 	return;
		}
		
		 $resp = Models\GECMRDetails::create($_POST['cmr_details']);	
		 if(!$resp)
		 	failure('Unable to save entry');

		 success('Details Saved Successfully');
		 redirect('data/cmrDetails');
	}

	function cmr_update(){

		$m_serial_no = intval(@$_POST['cmr_details']['m_serial_no']);
		if (($m_serial_no > 0) !== true){
			failure('invalid M.Serial No.');
		 	redirect('cmr_details/edit/' . $_POST['entry_id']);
		 	return;
		}
		
		if($_POST['entry_id'])
				$duplicate = Models\GECMRDetails::where('id','!=', $_POST['entry_id'])->where('m_serial_no', $m_serial_no)->count();
			else
				$duplicate = Models\GECMRDetails::where('m_serial_no', $m_serial_no)->count();

		// $duplicate = Models\GECMRDetails::where('m_serial_no', $m_serial_no)->count();

		if ($duplicate){
		 	failure('duplicate M.Serial No.');
		 	redirect('cmr_details/edit/' . $_POST['entry_id']);
		 	return;
		}
		
		

		$resp = Models\GECMRDetails::where('id', $_POST['entry_id'])
								   ->update($_POST['cmr_details']);
		 if(!$resp){
		 	failure('Unable to save entry');
		 	redirect('cmr_details/edit/' . $_POST['entry_id']);
		 }

		 success('Details Updated Successfully');
		 redirect('data/cmrDetails');
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
