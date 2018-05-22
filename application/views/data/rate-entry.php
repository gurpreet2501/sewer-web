<?php $this->load->view('admin/partials/header');

	$string = '';
	if(!empty($_GET)){
		$string = http_build_query($_GET);
	}

 ?>
<div class="row">
	<div class="col-xs-12">
		<h2 class="text-center">Rate Entries</h2>
		<br/>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">

		<!-- NEW FORM -->
		<form  method="GET" id="rate_entry_id">
		<table class="table table-stripped">
		  <tr>
		  	<td>Select Stock Items</td>
		  	<td>Select Party Name</td>
		  	<td>Rate Assigned</td>
		  	<td>Start Date</td>
		  	<td>End Date</td>
		  	<td></td>
		  </tr>
		  <tr>
		  	<td width="20%">
		  		<!-- stock items -->
				  	<div class="form-group">
							<select class="form-control chosen-select" name="stock_items[]" id="inputWarning1" multiple data-placeholder="Select Stock Items">
							<?php foreach ($stock_items as $key => $stItem): 
											$selected = in_array($stItem->id, $stub['stock_items']) ? 'selected' : ''; ?>
									<option value="<?=$stItem->id?>" <?=$selected?>><?=$stItem->name?></option>
							<?php endforeach ?>
							</select>		
						</div>	
		  		<!-- stock items -->
		  	</td>
		  	<td width="20%">
		  		<!-- select party -->
		  			<div class="form-group">
							<select class="form-control chosen-select" name="accounts[]" multiple data-placeholder="Select Parties">
							<?php foreach ($accounts as $key => $accopunt): 
											$selected = in_array($accopunt->id, $stub['accounts']) ? 'selected' : '';
							?>
									<option value="<?=$accopunt->id?>" <?=$selected?>><?=$accopunt->name?></option>
							<?php endforeach ?>
							</select>		
						</div>
		  		<!-- select party -->
		  	</td>
		  	<td width="10%">
		  		<!-- Rate assigned -->
		  		<div class="form-group">
						<select class="form-control " name="_rate" id="rate_assigned">
							<option selected>-Select-</option>
							<option <?=$stub['_rate'] == 'ALL' ? 'selected' : ''?>>ALL</option>
							<option <?=$stub['_rate'] == 'YES' ? 'selected' : ''?>>YES</option>
							<option <?=$stub['_rate'] == 'NO' ? 'selected' : ''?>>NO</option>
						</select>		
					</div>	
		  		<!-- Rate assigned -->
		  	</td>
		  	<td width="10%">
			  	<!-- Start date		 -->
					<div class="form-group">
						<input type="text" id="start_date" class="form-control  _datepicker" name="start_date" value="<?=$stub['start_date']?>" placeholder="Select Start Date"  />
					</div>
			  	<!-- Start date		 -->
		  	</td>
		  	<td width="10%" align="left">
		  		<div class="form-group">
						<input type="text" class="form-control  _datepicker" name="end_date" placeholder="Select End Date" id="end_date" value="<?=$stub['end_date']?>"/>
					</div>	
		  	</td>
		  	<td align="left">
		  	<div class="form-group">  
		  		<!-- filter btn -->
								<button type="submit" class="btn btn-primary">Filter</button>
		  		<!-- filter btn -->
		  	</td>
		  </tr>
     </table>
		</form>
		
	</div>	 <!-- col-xs-12 -->
</div> <!-- row -->
<div class="row">
	<div class="col-xs-12">
  <?php if(count($forms)): ?> 
		<table class="table table-bordered">
			<tr>
				<td width="8%" align="center">Gate Entry Id</td>
				<td width="20%" align="center">Party Name</td>
				<td width="15%" width="10%" align="center">Stock Item</td>
				<td width="8%" align="center">No of Bags</td>
				<td width="10%" align="center">Item wt in kgs</td>
				<td width="10%" align="center">Item Weight in Q</td>
				<td width="10%" align="center">Weight Unit</td>
				<td align="center">Rate per unit</td>
				<td align="center">Date</td>
			</tr>
		
	<form method="post" action="<?=site_url('data/rateEntryUpdate/?'.$string)?>">
	  <?php foreach($forms as $key => $form):
	          //Displaying only Complete Gate Entries
            if(!in_array($form->ge_id, $ge_ids))
            	continue;
	  				
							$contractExists = isset($form->rateContract) ? 	true : false;
						
	  					 $newRate = [
	         	 	 		'rate' =>	$form->rate_per_unit,
	         	 	 		'readonly' => $contractExists,
	         	 			'contract_id' => NULL,

	         	 	 	];
													
				   	$weight_per_bag = calculate_weight_per_bag($form->ge_id); ?>
			 <tr>  
		     <td align="center">#<?=$form->gateEntry->id?></td>
		     <td align="center"><?=$form->gateEntry->accounts->name?></td>
		     <td align="center"><?=isset($form->stockItems->name) ? $form->stockItems->name : ''?></td>
		     <td align="center"><?=$form->bags?></td>
		     <td align="center"><?=round($weight_per_bag  *  $form->bags, 2)?></td>
		     <td align="center"><?=number_format(($weight_per_bag *  $form->bags)/100.0, 2, '.', '')?></td>
		     <td>
						 <select class="form-control" name="data[<?=$form->ge_id?>][<?=$form->id?>][item_rate_unit]">
						 <?php foreach ($wtUnits as $unit): ?>
			 			 	<option <?=($form->item_rate_unit == $unit->id) ? 'selected' : '' ?> value="<?=$unit->id?>"><?=$unit->name?></option>
			 			 <?php endforeach; ?>	
						 </select>
					 </td>
		     <td width="10%" align="center">
		     <input style="width:90px" type="text" 
		      class="form-control" 
		      <?=$newRate['readonly'] ? 'readonly' : ''?>
		       name="data[<?=$form->ge_id?>][<?=$form->id?>][item_rate]" value="<?=$newRate['rate']?>" /> 
		       <?php 
		        if($contractExists): ?>
		         <input type="hidden" name="data[<?=$form->ge_id?>][<?=$form->id?>][rate_contract_id]" value="<?=$form->rateContract->id?>" />
		        <?php endif; ?>

		       </td>

		     <td width="15%" align="center"><?=date('M d, Y', strtotime($form->created_at))?></td>

				</tr>	 
	    <?php endforeach; ?>
			<tr>
				<td align="right" colspan="9"><button type="submit" class="btn btn-danger">Update</button></td>
			</tr>
		</form>		
		</table>
	<?php else:?>
	<h4 class="text-center">No Records Found ! </h4>
	<?php endif;?>

	</div>
</div>
<? $this->load->view('admin/partials/footer'); ?>
