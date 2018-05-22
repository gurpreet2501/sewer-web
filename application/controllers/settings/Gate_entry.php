<?php 

use Services\Settings\GateEntry;
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Gate_entry extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('grocery_CRUD');
		auth_force();
	}

	public function material($input_type){
		$type =  strtoupper($input_type);
		$data = [
			'forms' => Models\Forms::where('type', $type)->with('gateEntryConfig')->orderBy('name')->get(),
			'form_type' => $type,
			'dataModules' => $this->config->item('gate_entry_data_modules'),
		];

		$this->load->view('settings/material',$data);	
	}

	public function save_material($input_type){
		$ge = new GateEntry();
		$ge->saveMaterial($_POST['modules']);
		success('Data Saved Successfully!.');
		redirect('settings/gate_entry/material/'.$input_type);
	}
}
