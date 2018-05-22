<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Payment extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		auth_force();
		$this->load->helper('url');
		$this->load->library('tank_auth');
	}

	function dailyLabourAccounts()
	{

		


	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
