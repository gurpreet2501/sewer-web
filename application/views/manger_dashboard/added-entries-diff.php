<h3><?=strtoupper(str_replace('_',' ',$mod_name))?></h3>
<div> <span class="label label-success"><?=$diff->diff?></span></div>
<hr>
<table class="table table-bordered">
	<tr>
		<th>Key</th>
		<th>Value</th>
	</tr>
 <?php 
 
  foreach ($diff->data as $key => $val): 
 
				$flag = 0;	
				
				if($key == 'stock_item')
						continue; 

				if($key == 'account_id'){
					 $key = 'Account Name';
					 $val = getPartyName($val); 
					
				} 

				if($key == 'godown_id'){
					 $key = 'Godown';
					 $val = getGodownName($val); 
				} 

				if($key == 'labour_party_id'){
					 $key = 'Labor Party';
					 $val = getPartyName($val); 
				} 

				if($key == 'labour_job_type_id'){
				
					 $key = 'Labor Job Type';
					 $val = getLaborJobTypes($val); 
				} 

				if($key == 'stock_item_id'){
					 $key = 'Stock Item';
					 $val = getStockItemName($val); 
				} 



		?>
	
	<tr>
		<td width="40%"><strong><?=ucfirst(str_replace('_', ' ', $key))?></strong></td>
		<td ><?=$val ? $val : 0?></td>
	
	</tr>

<?php ;endforeach; ?>

</table>	