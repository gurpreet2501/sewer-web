<h3><?=strtoupper(str_replace('_',' ',$mod_name))?></h3>
<div> <span class="label label-success"><?=$diff->diff?></span></div>
<hr>
<table class="table table-bordered">
	<tr>
		<th>Key</th>
		<th>Old Value</th>
		<th>Modified Value</th>
	</tr>
 <?php foreach ($diff->old_data as $val_key => $val): 
			$flag = 0;	
			if(!array_key_exists($val_key, $diff->new_data))
				continue;

			$new_val = $diff->new_data->$val_key;

			if($val_key =='stock_item')
					continue; 

			if($val_key == 'account_id'){
				 $val_key = 'Account Name';
				 $val = getPartyName($val); 
				 $new_val = getPartyName($diff->new_data->account_id); 
			} 

			if($val_key == 'godown_id'){
				 $val_key = 'Godown';
				 $val = getGodownName($val); 
				 $new_val = getGodownName($diff->new_data->godown_id); 
			} 

			if($val_key == 'labour_party_id'){
				 $val_key = 'Labor Party';
				 $val = getPartyName($val); 
				 $new_val = getPartyName($diff->new_data->labour_party_id); 
			} 

			if($val_key == 'stock_item_id'){
				 $val_key = 'Stock Item';
				 $val = getStockItemName($val); 
				 $new_val = getStockItemName($diff->new_data->stock_item_id); 
			} 

			if($val_key == 'labour_job_type_id'){
				
					 $val_key = 'Labor Job Type';
					 $val = getLaborJobTypes($val); 
					 $new_val = getLaborJobTypes($diff->new_data->labour_job_type_id); 
				} 
				
		
			if($val != $new_val)		
				$flag = 1;


		?>
	
	<tr>
		<td width="40%"><strong><?=ucfirst(str_replace('_', ' ', $val_key))?></strong></td>
		<td class="<?=($flag == 1) ? 'color-red' : ''?>"><?=$val?></td>
		<td class="<?=($flag == 1) ? 'color-green' : ''?>"><?=$new_val?></td>
	</tr>

<?php endforeach ?>

</table>	