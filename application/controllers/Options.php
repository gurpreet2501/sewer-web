<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Options extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		auth_force();
		$this->load->helper('url');
		$this->load->library('tank_auth');
	}

	function chrome_weight_app_id()
	{
    $key = 'chrome_weight_app_id';
    $success = false;

    if (isset($_POST[$key])){
      $success = true;
      // handle post
      $value = trim($_POST[$key]);
      $record = Models\Options::where('key', $key)->first();
      if (!is_null($record)){
        // existing record
        $record->update(['value' => $value]);
      }else{
        // create new entry
        Models\Options::create(['key' => $key, 'value' => $value]);
      }
    }
    $data = [
      'success' => $success,
    ];
    $record = Models\Options::where('key', $key)->first();
    if (!is_null($record)){
      $data['value'] = $record->value;
    }
    $this->load->view('options/chrome_weight_app_id', $data);
  }

}
