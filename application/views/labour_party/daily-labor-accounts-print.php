<?php $this->load->view('admin/partials/header');
$party_id = !empty($_GET['party_id']) ? $_GET['party_id'] : 0;  ?>

<div class="row">
 <div class="col-lg-12">
  <?php if($resultsFlag): ?>
  <h2 class="text-center">Daily Labour Account</h2>

     <table class="table table-hover">
		 		<tr>
		  		<td>Sno.</td>
		  		<td>Item</td>
		  		<td>Rate</td>
 		  	  <?php foreach ($godowns as $key => $godown): ?>
		  			<td><?=$godown->name?></td>
		  	  <?php endforeach; ?>
		  		<td>Amount</td>
		  	</tr>
  	<?php 
  	 $sno = 1; 

  	 foreach($filtered_results as $records): 
  
  	 			//$ids = implode(', ', $records['ids']); ?>
  	 	     <tr class="labAcc">
			  		<td><?=$sno?></td>
			  		<td><?=$records['labour_job_type_name']?></td>
			  		<td width="20%"><input type="text" class="labour_acc_rate " readonly value="<?=$records['rate']?>" name="rate[<?=$sno?>][value][]" style="border:none;background:transparent; box-shadow: none " /></td>
			  		
     <?php foreach($godowns as $godown): ?>
     			<td class="bag_exists">
   					<?=isset($records['godowns'][$godown->id]) ? $records['godowns'][$godown->id]['bags']: 0?>
     			</td>
     <?php endforeach; ?>
     		<td><div class="labour_acc_entry_total">0</div></td>
       </tr>
    <?php   $sno++;     endforeach; ?>
    
		
   </table>

 <div class="row">
	 <div class="col-xs-9"></div>
	 	<div class="col-xs-3 pull-right">
		  	<h4>Total: <span class="grandTotal">Rs. 0</span></h4>
		  	<h5>Opening Bal: Rs. <?=$opening_balance?></h5>
		  	<h5>Closing Bal: Rs. <?=$closing_balance?></h5>
	 	</div>
 </div> <!-- row -->
 <br/>

 </form>
 <hr/>
<hr/>
 <?php else: ?>
	 	<h2 class="text-center"> No Records Found !</h2>
 <?php endif; ?>
 
  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>


<script type="text/javascript">
	jQuery(function(){
		window.print();
	})
</script>
