<div class="row">
	<div class="col-xs-12">
		<h2 class="text-center">Other Jobs</h2>
  
		<?php 
		$ojobs_total_amt_paid = 0;
		$ojobs_total_amt_due = 0;
		$dynamic_td_count = count($godowns);
		$get_params = isset($_GET) ? $_GET : [];		
		 if(count($other_jobs_data)): ?>
			 <input type="hidden" class="form-control" value="<?=$party_id?>" name="party_id" />

	     <table class="table table-stripped">
			 		<tr>
			  		<td>Sno.</td>
			  		<td>Item</td>
			  		<td>Rates</td>
	 		  	  <?php foreach ($godowns as $key => $godown): ?>
			  			<td><?=$godown->name?></td>
			  	  <?php endforeach; ?>
			  		<td>Amount Paid</td>
			  		<td>Amount Due</td>
			  		<td class="no-print">Pay</td>
			  		<td class="no-print">Delete</td>
			  		<td class="no-print">Edit</td>
			  	</tr>
	  	<?php 
	  	 $sno = 1; 

	  	 foreach($other_jobs_data as $labour_job_type_id => $records): 
	  			$is_paid = $records['ids'][0]['is_paid']; 
	  	 		$ojobs_total_amt_paid = $ojobs_total_amt_paid + $records['amount_paid'];
	  	 		$ojobs_total_amt_due = $ojobs_total_amt_due + $records['amount_due'];
	  	 	?>
	  	 	  <tr class="labAcc">
				  		<td><?=$sno?></td>
				  		<td><?=$records['labour_job_type_name']?></td>
				  		<td width="10%">
				  			<?php foreach ($records['rates'] as  $rate): ?>
						  			<span class="label label-danger"><?=$rate?></span>
				  			<?php endforeach ?>
				  		</td>
				  		
				  		
	     <?php foreach($godowns as $godown): ?>
	     			<td class="bag_exists">
	   					<?=isset($records['godowns'][$godown->id]) ? $records['godowns'][$godown->id]: 0?>
	     			</td>
	     <?php endforeach; ?>
	     
	     		<td>
	     			<div class="labour_acc_entry_total"><?=$records['amount_paid']?></div>
	     			<input 	type="hidden" name="jobs[other_<?=$labour_job_type_id?>]" 
	     							value="<?=implode(',',array_column($records['ids'], 'id'))?>">	
	     		</td>
	     		<!-- Fetching ids to delete the entries -->
	     			<input 	type="hidden" name="associated_qc_lab_ids[<?=$labour_job_type_id?>]" 
	     							value="<?=implode(',',array_column($records['ids'], 'id'))?>">	
	     		<td>
	     			<div class="amount_due"><?=$records['amount_due']?></div>
      		</td>
	     		<td>
	     			<?php if($records['amount_due'] != 0): ?>
	     			<input type="checkbox" class="select_for_payment no-print"  name="pay_jobs[other_<?=$labour_job_type_id?>]" />
	     			<?php else: ?>
		     			<label class="label no-print label-success">Paid</label>
		     		<?php endif; ?>
	     		</td>
	     		<td>
	     			<?php 	 if($records['amount_due'] != 0):  ?>
	     			<input type="checkbox" name="labour_type_to_delete[<?=$labour_job_type_id?>]" value="<?=$labour_job_type_id?>" />
	     		<?php endif; ?>
	     		</td>
	     		<td>
	     				<?php 
	     				$get_params['labour_job_type_id'] = $labour_job_type_id; 
	     				$get_params['qc_allocation_id'] = $records['ids'][0]['qc_allocation_id']; 
	     			 if($records['amount_due'] != 0): 		
	     				?>
	     			  <a href="<?=site_url('data/add_new_labour_job/?edit=1&').http_build_query($get_params)?>">
	     			  	<button type="button" class="btn btn-warning">
	     						Edit	 
		     		   </button>
		     		 </a>
		     		<?php endif; ?>
	     	  </td>
	       </tr>
	    <?php $sno++; endforeach; ?>
	   	<tr>
	   		<td align="right" colspan="<?=$dynamic_td_count+3?>">Total:</td>
	   		<td><label class="label label-success">Rs. 
	   			<span class="ojobs_total_amt_paid"><?=$ojobs_total_amt_paid?></span>
	   		</label></td>
	   		<td><label class="label label-danger">Rs. 
	   			<span class="ojobs_total_amt_due"><?=$ojobs_total_amt_due?></span>
	   				
	   			</label></td>
	   	</tr>
	 		</table>
	 	<?php else: ?>
			<h3 class="text-center">No Records Found</h3>
		<?php endif; ?>
	</div>
</div>
<div class="row">
	<div class="col-md-10"></div>
	<div class="col-md-2">
		<div class="form-group">
  			<button class="btn btn-danger" type="submit">Delete</button>	
  	</div>
  	
	</div>
</div>
