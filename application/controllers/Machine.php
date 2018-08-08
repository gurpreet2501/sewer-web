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
		
		if(empty($_POST))
			return;
		
		$machine_status = $_POST['machine_status'];
		
		$obj = new ApiClient();
		$machine = Models\Machines::where('id',$_POST['machine_id'])->first();
		$machine_serial = trim($machine->machine_serial);
		$machine_status = ($machine_status) ? 1 :0; 	
		
		try{

		$resp  =  $obj->reset() 
                        ->set('object', 'machine_status')
                        ->set('api', 'update')
                        ->set('data',[
                        	'machine_serial' => $machine_serial,
                        	'machine_status' => $machine_status,
                        ])
                        ->exec();  

			if(!$resp->success()){
				echo false;
				return;
			}
			
			echo json_encode(true);

    }catch(Exception $e){
    		echo false;
				return;
    }

	   

	}

	function button_status_update()
	{
		
		if(empty($_POST))
			return;
		
		$button_status = $_POST['button_status'];
		
		$obj = new ApiClient();
		$machine = Models\Machines::where('id',$_POST['machine_id'])->first();
		$machine_serial = trim($machine->machine_serial);
		$button_status = ($button_status) ? 1 :0; 	
		
		try{

		$resp  =  $obj->reset() 
                        ->set('object', 'button_status')
                        ->set('api', 'update')
                        ->set('data',[
                        	'machine_serial' => $machine_serial,
                        	'button_status' => $button_status,
                        ])
                        ->exec();  

			if(!$resp->success()){
				echo false;
				return;
			}
			
			echo json_encode(true);

    }catch(Exception $e){
    		echo false;
				return;
    }

	   

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
