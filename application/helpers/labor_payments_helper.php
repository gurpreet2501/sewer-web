<?php 

function getPaymentBalance($party_id,$end_date){
	$ci = &get_instance();
	$acc = Models\Accounts::where('id',$party_id)->first();
	if(!$acc)
		return;
	if(!$acc->ob_date || ($acc->ob_date > $end_date))
		$query = $ci->db->query("SELECT sum(transactions.amount) as total FROM `transactions` 
						left join `labor_payments` on transactions.id=labor_payments.transaction_id
						where secondary_account_id = ".$ci->db->escape($party_id)."
						AND labor_payments.transaction_id IS NULL");
	else
		$query = $ci->db->query("SELECT sum(transactions.amount) as total FROM `transactions` 
						left join `labor_payments` on transactions.id=labor_payments.transaction_id
						where secondary_account_id = ".$ci->db->escape($party_id)." AND transaction_date >= '".$ci->db->escape($acc->ob_date)."'
						AND labor_payments.transaction_id IS NULL");


	$total = $query->result_array()[0]['total'];

	$from_balance_amount = getFromBalanceAmount($party_id);
	
	return $total - $from_balance_amount;

}

function getFromBalanceAmount($party_id){

	$total = 0;
	$entries = Models\LaborPayments::where('labour_party_id', $party_id)->get();

	foreach ($entries as $key => $v) 
		$total = $total + $v->from_balance_amount;

	return $total;	

}


function payLaborParty($amount, $from_balance_amount,Array  $ge_ids, $payment_account_id, $labor_party_id){

	$transaction = Models\Transactions::create([
		'entry_type' => 'CASH',
		'transaction_date' => date('Y-m-d'),
		'amount' => $amount,
		'primary_account_id' => $payment_account_id,
		'secondary_account_id' => $labor_party_id
	]);

	$payment = Models\LaborPayments::create([
			'labour_party_id' => $labor_party_id,
			'amount' => $amount,
			'from_balance_amount' => $from_balance_amount,
			'payment_account_id' => $payment_account_id,
			'transaction_id' => $transaction->id
	]);
	
	$payment->geGodownQcLaborAllocations()->sync($ge_ids);
}

function reorderGodownBagAllocation($data){

		$filtered = [];
		foreach ($data as $key => $entry) {	
	
			$bags = $entry['bags'];
			if(!isset($filtered[$entry['labour_job_type_id']]))
				$filtered[$entry['labour_job_type_id']] = [
					'amount_paid' => 0,
					'amount_due' 	=> 0,
					'labour_job_type_name' => $entry['labour_job_type_name'],
					'rates' => [],
					'godowns' => [],
					'bags' => 0, 
				];

			$item = $filtered[$entry['labour_job_type_id']];
		
			if($entry['is_paid'])
				$item['amount_paid'] += $entry['amount'];
			else
				$item['amount_due'] += $entry['amount'];

			$item['bags'] += $entry['bags'];
			$item['ids'][] = $entry;
			
			if(!isset($item['godowns'][$entry['godown_id']]))
				$item['godowns'][$entry['godown_id']] = 0;	

			$item['godowns'][$entry['godown_id']] += $entry['bags'];

			$item['rates'][] = $entry['rate'];
			$item['rates'] = array_unique($item['rates']);
			
			
			$item['labour_job_type_id'] = $entry['labour_job_type_id'];
			// $item['qc_labor_alloc'] = $entry['qc_allocation_id'];

			$filtered[$entry['labour_job_type_id']] = $item;
		
		}
	
    return $filtered; 	
	}


 function reorderCustomJobsData($data){

		$filtered = [];
	  $sno = 1;
		foreach ($data as $key => $entry) {	
		
			$bags = $entry['bags'];
			if(!isset($filtered[$sno]))
				$filtered[$sno] = [
					'amount_paid' => 0,
					'amount_due' 	=> 0,
					'labour_job_type_name' => $entry['labour_job_type_name'],
					'rates' => [],
					'godowns' => [],
					'bags' => 0, 
				];

			$item = $filtered[$sno];

			if($entry['is_paid'])
				$item['amount_paid'] += $entry['amount'];
			else
				$item['amount_due'] += $entry['amount'];
		
			$item['ids'][] = $entry;
	
			$filtered[$sno] = $item;

			$sno++;
		}
	
    return $filtered; 	
	}
