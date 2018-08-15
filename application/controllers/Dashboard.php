<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
use App\Libs\ApiClient;

class Dashboard extends CI_Controller
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
		$obj = new ApiClient();
		
		// Enable/disble mapping structure
		// 0 - > disabled
		// 1 - > enabled
		// 2 - > all i.e. filter reset

	  $filters = [
	  	'from_date' => date('Y-m-d 00:00:00'),
	  	'to_date' => date('Y-m-d 23:59:59'),
	  	'machine_type' => 'ALL',
	  	'machine_serial' => '',
	  	'page_no' => isset($_GET['page_no']) ? $_GET['page_no'] : 1,
	  	'machine_status' => 2, //Show All 
	  	'button_status' => 2, //Show All
	  	'blocked_machines' => 2 //Show All
	  ];
	  
	  if(isset($_GET['clear_filters']))
	  	redirect('dashboard/index');
	  

	  if(isset($_GET['filters']['machine_type']))
	  	$filters['machine_type'] = $_GET['filters']['machine_type'];

	 	if(isset($_GET['filters']['machine_status']))
	  	$filters['machine_status'] = $_GET['filters']['machine_status'];

	  if(isset($_GET['filters']['blocked_machines']))
	  	$filters['blocked_machines'] = $_GET['filters']['blocked_machines'];
	  
	  if(isset($_GET['filters']['button_status']))
	  	$filters['button_status'] = $_GET['filters']['button_status'];

	  if(isset($_GET['filters']['machine_serial']))
	  	$filters['machine_serial'] = $_GET['filters']['machine_serial'];
	  

	
		$resp  =  $obj->reset() 
                        ->set('object', 'machine')
                        ->set('api', 'view')
                        ->set('data',[
                        	'token' => get_sessions_token(),
                        	'type' => $filters['machine_type'],
                        	'paginate' => true,
                        	'page_no' => $filters['page_no'],
                        	'type' => $filters['machine_type'],
                        	'status' => $filters['machine_status'],
                        	'button_status' => $filters['button_status'],
                        	'blocked' => $filters['blocked_machines'],
                        	'machine_serial' => $filters['machine_serial']
                        ])
                        ->exec();
        
         
    if(!$resp->success()) {
    	failure('Something wrong happened');
    	redirect('dashboard/index');
    }
    
    $jsFiles = [
			base_url('assets/js/components/datepicker.js'),
			base_url('assets/js/loadingoverlay.min.js'),
			base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
			base_url('assets/js/machine-btns-toggling.js'),
		];

		$cssFiles = [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')];


		$this->load->view('dashboard',[
			'data' => $resp->response(),
			'js_files' => $jsFiles,
			'css_files' => $cssFiles,
			'filters' => $filters
		]);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
