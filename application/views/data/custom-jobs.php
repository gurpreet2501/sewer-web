 <h2 class="text-center">Custom Jobs</h2>
<div class="row">
	<div class="col-xs-12">
		<?php 
			$cjobs_amount_paid = 0;
			$cjobs_amount_due = 0;
		 ?>
		<?php if(count($custom_jobs_data)): ?>
		<table class="table table-stripped">
		   <tr>
		   	<td>Sno</td>
		   	<td>Job Name</td>
		   	<td>Party Name</td>
		   	<td>Godown Name</td>
		   	<td>Remarks</td>
		   	<td>Amount Paid</td>
		   	<td>Amount Due</td>
		   </tr>
	  <?php $total = 0; $sno=1; foreach($custom_jobs_data as $custom_job): 
	 
	  						$cjobs_amount_paid = $cjobs_amount_paid + $custom_job['amount_paid'];
	  						$cjobs_amount_due = $cjobs_amount_due + $custom_job['amount_due'];

	   ?>
			  	<tr>
			  		<td><?=$sno?></td>
			  		<td><?=$custom_job['ids'][0]['job_name']?></td>
			  		<td><?=$custom_job['ids'][0]['accounts']['name']?></td>
			  		<td><?=$custom_job['ids'][0]['godown']['name']?></td>
			  		<td><?=$custom_job['ids'][0]['remarks']?></td>
			  		<td><div class="labour_acc_entry_total"><?=$custom_job['amount_paid']?></div>
	     			<input 	type="hidden" name="jobs[custom_<?=$sno?>]" 
	     							value="<?=$custom_job['ids'][0]['id']?>">	
			  		<td><div class="amount_due"><?=$custom_job['amount_due']?></div></td>
			  		<td><input type="checkbox" class="select_for_payment no-print" name="pay_jobs[custom_<?=$sno?>]" /></td>
			  		
			  	</tr>
    <?php $sno++; endforeach; ?> 	
    	<tr>
    		<td colspan="5">Total</td>
    		<td><label class="label label-success">Rs. 
    			<span class="cjobs_amount_paid"><?=$cjobs_amount_paid?></span>
    		</label></td>
    		<td><label class="label label-success">Rs. 
  				<span class="cjobs_amount_due"><?=$cjobs_amount_due?></span>
   			</label></td>
    	</tr>
		</table>

	<?php else: ?>
		<h3 class="text-center">No Records Found</h3>
	<?php endif; ?>
	</div>
</div> 
