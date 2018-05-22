<div class="row">
		 <div class="col-lg-12">
		 
		  <h2 class="text-center">Daily Labour Account</h2>
		     <?php if(count($filtered_results)): ?>
				 <input type="hidden" class="form-control" value="<?=$party_id?>" name="party_id" />
				 <?php 
				 $ge_job_amopunt_paid = 0;
				 $ge_job_amopunt_due = 0;
				 $dynamic_td_count = count($godowns);
				  ?>
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
				  		<td class="hide-on-print no-print">Pay</td>
				
				  	</tr>
		  	<?php 
		  	 $sno = 1;
		  
		  	 foreach($filtered_results as $labour_job_type_id => $records):
		  	 			 
		  	 		$ge_job_amopunt_paid = $ge_job_amopunt_paid + $records['amount_paid'];
		  	 		$ge_job_amopunt_due = $ge_job_amopunt_due + $records['amount_due'];
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
		     		</td>
		     		<td>
		     			<div class="amount_due"><?=$records['amount_due']?></div>
		     			<?php $ids = implode(',',array_column($records['ids'], 'id')); 		?>
		     			<input type="hidden" value="<?=$ids?>" />
		     		</td>
		     		<td class="hide-on-print">
		     			<?php if($records['amount_due'] != 0): ?>
		     			<input type="checkbox" class="select_for_payment no-print" name="pay_jobs[<?=$labour_job_type_id?>]" />
		     		<?php else: ?>
		     			<label class=" no-print label label-success">Paid</label>
		     		<?php endif; ?>
		     		</td>	
		     	
		       </tr>
		   
		    <?php $sno++; endforeach; ?>
		 		<tr>
		 			<td colspan="<?=$dynamic_td_count+3?>">Total:</td>
		 			<td><label class="label label-success">Rs. <span class="ge_job_amount_paid"><?=$ge_job_amopunt_paid?></span></label></td>
		 			<td><label class="label label-danger">Rs. <span class="ge_job_amount_due"><?=$ge_job_amopunt_due?></span></label></td>
		 		</tr>
		   </table>
		 <?php else: ?>
				<h3 class="text-center">No Records Found</h3>
		 <?php endif; ?>
			</div>
		</div>
