<?php 
function success($msg){
	$ci = &get_instance();
	return $ci->session->set_flashdata('success_msgs', $msg);
}

function failure($msg){
	$ci = &get_instance();
	return $ci->session->set_flashdata('error_msgs', $msg);
}


function logErrors($error, $file_name,$line_no,$function_input){
	return Models\ErrorLogs::create([
		'error' => serialize($error),
		'file_name' => $file_name,
		'line_no' => $line_no,
		'function_input' => serialize($function_input),
	]);
}
