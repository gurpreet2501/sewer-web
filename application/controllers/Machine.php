<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
use App\Libs\ApiClient;

class Machine extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		auth_force();
		$this->load->helper('url');
		$this->load->library('tank_auth');
	}

	function status_update()
	{

		echo "<pre>";
		print_r('data');
		exit;
		// $obj = new ApiClient();


	 //  $filters = [
	 //  	'from_date' => date('Y-m-d 00:00:00'),
	 //  	'to_date' => date('Y-m-d 23:59:59'),
	 //  	'machine_type' => 'GAS',
	 //  	'page_no' => isset($_GET['page_no']) ? $_GET['page_no'] : 1
	 //  ];


		// $resp  =  $obj->reset() 
  //                       ->set('object', 'machine')
  //                       ->set('api', 'view')
  //                       ->set('data',[
  //                       	'token' => get_sessions_token(),
  //                       	'type' => $filters['machine_type'],
  //                       	'paginate' => true,
  //                       	'page_no' => $filters['page_no']
  //                       ])
  //                       ->exec();  
                
  //   if(!$resp->success()) {
  //   	failure('Something wrong happened');
  //   	redirect('dashboard/index');
  //   }
    
  //   $jsFiles = [
		// 	base_url('assets/js/components/datepicker.js'),
		// 	base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.js'),
		// 	base_url('assets/js/machine-btns-toggling.js'),
		// ];

		// $cssFiles = [base_url('assets/js/jquery-ui-1.12.1.custom/jquery-ui.min.css')];


		// $this->load->view('dashboard',[
		// 	'data' => $resp->response(),
		// 	'js_files' => $jsFiles,
		// 	'css_files' => $cssFiles
		// ]);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
