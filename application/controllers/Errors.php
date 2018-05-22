<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
use Illuminate\Pagination;
use Illuminate\Pagination\Paginator;
class Errors extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('tank_auth');
	}

	function printing()
	{
		$currentPage = 1;
		if(isset($_GET['page']))
		 $currentPage = $_GET['page'];	
		
		Paginator::currentPageResolver(function () use ($currentPage) {
        return $currentPage;
    });

		$errors = Models\ErrorLogs::paginate(10);
		
		// print_r($errors->url(2));
		
		$this->load->view('errors/print',[
			'errors' => $errors
		]);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
