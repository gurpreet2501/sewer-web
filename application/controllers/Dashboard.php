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
		// $obj = new ApiClient();
	
		// $test  =  $obj->reset() 
  //                       ->set('object', 'user')
  //                       ->set('api', 'login')
  //                       ->set('data',[
  //                       	'email' => 'waheguru@mera.com',
  //                       	'password' => 'C@ash2add',
  //                       	'device_id'
  //                       ])
  //                       ->exec();  

  //             echo "<pre>";
  //                       print_r($test);
  //                       exit;          
		$this->load->view('dashboard');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
