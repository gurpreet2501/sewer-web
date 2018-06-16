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
	  $session = Models\UserSessions::where('user_id',user_id())->first();
	 
	 if(empty($session))
	 	return('auth/logout');
	

		$resp  =  $obj->reset() 
                        ->set('object', 'machine')
                        ->set('api', 'view')
                        ->set('data',[
                        	'token' => $session->token,
                        	'type' => 'GAS'
                        ])
                        ->exec();  

    if(!$resp->success()) {
    	failure('Something wrong happened');
    	redirect('dashboard/index');
    }


		$this->load->view('dashboard',[
			'data' => $resp->response()
		]);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
