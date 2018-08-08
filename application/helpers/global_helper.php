<?php

if (!function_exists('cashTransactionMenuItems')):
	function cashTransactionMenuItems()
	{
		$groups = [
			'CashTransactionMenuItems','BankAccounts','Cash-in-hand','BankODA/c',
			'SecuredLoans'
		];

		$groupIds = Models\AccountsGroups::select('id')->whereIn('name', $groups)->get()->toArray();
		$groupIds = array_column($groupIds, 'id');

		return Models\Accounts::whereIn('accounts_group_id', $groupIds)->get();
	}
endif;

if (!function_exists('cashTransactionDropDownItems')):
	function cashTransactionDropDownItems()
	{ 
		return Models\Accounts::get();
	}
endif;

/**
 * @param id (integer) 
 */
function getGodownName($id){
		$godown = Models\Godowns::where('id', $id)->first();
		if(!count($godown))
			return '';
		return $godown->name;
}



/**
 * @param id (integer) 
 */
function getPartyName($id){
		$account = Models\Accounts::where('id', $id)->first();
		if(!count($account))
			return '';
		return $account->name;

}
/**
 * @param id (integer) 
 */
function getLaboutJobTypeName($id){
		$labJobType = Models\LabourJobTypes::where('id', $id)->first();
		if(!count($labJobType))
			return '';
		return $labJobType->name;

}


function pagination_params($data){

	$data->next_page_url = str_replace('http://sewerage-api.com/v1?page=', '', $data->next_page_url);
	preg_match_all('!\d+!', $data->next_page_url, $next_page);
	if($data->current_page>1)
		$previous_page = $data->current_page-1;
	else
		$previous_page = null;

  return [
		'last_page' => $data->last_page,
		'current_page' => $data->current_page,
		'next_page' => isset($next_page[0][0]) ? $next_page[0][0] : '',
		'previous_page' => $previous_page,
		'total_results' => $data->total,
	];


}