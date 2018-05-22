<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
use App\Response\Factory as Resp;
class Accounts extends CI_Controller
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

		// header('Content-Type: application/json');
		$postData = $_POST;
	    if(!empty($postData)){
	    	    $accGrpDetails = Models\AccountsGroups::select('id')->where('name', $postData['accounts_group'])->first();
	    	    
	    	    if(empty($accGrpDetails))
	    	    	print_r(json_encode(Resp::errorCode(101)));
	    	    
				$record = Models\Accounts::create([
						'name' => $postData['name'],
						'accounts_group_id' => $accGrpDetails->id
					]);

				if(isset($record->id)){
			 	  $data = $record->toArray();
					print_r(json_encode(Resp::success($data)));
				}else{
					print_r(json_encode(Resp::errorCode(101)));
			}


		}

	}


	function addMarketNameInCmrForm(){
				$postData = $_POST;
			
    		if(empty($postData['name']) && empty($postData['cmr_society_id'])){
    			print_r(json_encode(Resp::errorCode(101)));
    			return;
    		}

				$record = Models\CMRMarkets::create([
						'name' => $postData['name'],
						'cmr_society_id' => $postData['cmr_society_id']
					]);

				if(isset($record->id)){
			 	  $data = $record->toArray();
					print_r(json_encode(Resp::success($data)));
				}else{
					print_r(json_encode(Resp::errorCode(101)));
			}

	}

	function addCashTransactionAccount()
	{	

		// header('Content-Type: application/json');
    		$postData = $_POST;
    		if(empty($postData['name']) && empty($postData['account_group']) && empty($postData['primary_account_id'])){
    			print_r(json_encode(Resp::errorCode(101)));
    			return;
    		}

				$record = Models\Accounts::create([
						'name' => $postData['name'],
						'accounts_group_id' => $postData['account_group']
					]);

				if(isset($record->id)){
			 	  $data = $record->toArray();
					print_r(json_encode(Resp::success($data)));
				}else{
					print_r(json_encode(Resp::errorCode(101)));
			}

		}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
