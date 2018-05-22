<?php $this->load->view('admin/partials/header');?>

<style>
@media print { 
 /* All your print styles go here */
	 .payment-block {
	    display: none;
	}
	#filter-select{
	    display: none;
	}
	.add-job-btns{
	    display: none;
	}
	.hide-on-print{
	    display: none;
	}
	 a[href]:after {
    content: none !important;
  }
}
</style>
<?
$party_id = !empty($_GET['party_id']) ? $_GET['party_id'] : 0;  ?>
<form class="form-inline" id="filter-select" name="filter-select">	
	<div class="row">
	  <div class="col-lg-1"></div>
	  <div class="col-lg-10">
					<div class="form-group">
					    <label for="end_date">Select Party </label>
					  	<select name="party_id" class="form-control">
					       <option selected disabled>Select Party</option>
					       <?php foreach($accounts as $account):?>
					       <option value="<?=$account->id?>" <?=$party_id == $account->id ? 'selected' : ''?> ><?=$account->name?></option>
					     <?php endforeach;?>
				     	</select>
				  </div>	
			  	<div class="form-group">
					  <label for="start_date">Start Date</label>
						<input type="text" id="start_date" class="form-control force-extend _datepicker" name="start_date" value="<?=$stub['start_date']?>" placeholder="Select Start Date"  />
					</div>	
					<div class="form-group">
					  <label for="end_date">End Date</label>
						<input type="text" class="form-control force-extend _datepicker" name="end_date" placeholder="Select End Date" id="end_date" value="<?=$stub['end_date']?>"/>
					</div>
			  	<button type="submit" class="btn btn-success" name="date_filter">Go</button>
			  	<button type="submit" class="btn btn-success" name="_today_filter">Generate For Today</button>
			  	<button  class="btn btn-success" onclick="printPage()">Print</button>
		
		  	<?php if(is_role('manager')): ?>
			  	<hr/>
		        <div class="btns-group pull-right"> 
				  
				  	<div class="form-group">
				  		<a href="<?=site_url('data/otherLabourJob/'.$party_id)?>"><button type="button" class="btn btn-danger add-job-">Add Job</button></a>
				  	</div>
				  	<div class="form-group">
				  		<a href="<?=site_url('data/customLabourJobs/'.$party_id)?>"><button type="button" class="btn btn-danger">Add Custom Job</button></a>
				  	</div>
				  </div>	
	        <?php endif;?> 
	  </div> <!-- col-lg-10 -->
	  <div class="col-lg-1"></div>
	</div> <!-- row -->
</form>	
<br>

<form method="post" class="labor_records" id="payment-form" name="payment-form" action="<?=site_url('data/updateLabourPartyRates/?').$get_string?>">

		<?php if($resultsFlag): 
			 $total_amount_paid = 0;
		?>
			 <?php $this->load->view('data/gate-entry-jobs'); ?>
			 
			 <?php $this->load->view('data/other-jobs'); ?>

			 <?php $this->load->view('data/custom-jobs'); ?>
		
			 
			 <div class="row">
			 	<div class="col-md-9">
			 	</div>
			 	<div class="col-md-3">
			 		<br>
			 			<div class="numerals-disp-block">
						 	 <div class="gd-total-paid">Total Amount Paid: Rs. <span>0.00</span></div>
						 	 <div class="gd-total-due">Total Amount Due: Rs. <span>0.00</span></div>
						</div>
			 		<br>

			 	</div>
			 </div>
		<?php else: ?>
			<h2 class="text-center">No Records Found</h2>
		<?php endif; ?>
  
 <div class="row pull-right">
 	<div class="col-xs-12">
  				
			  	<div class="form-group">
			  		<a href="<?=site_url('data/add_new_labour_job/?'.$get_string)?>"><button type="button" class="btn-small btn-danger add-job-btns">Add Other Job</button></a>
			  		<a href="<?=site_url('data/customLabourJobs/?'.$get_string)?>"><button type="button" class="btn-small btn-danger add-job-btns">Add Custom Job</button></a>
			  	</div>
 		
 	</div>
 </div> 
<div class="payment-block">
	<?php $this->load->view('data/payment-boxes'); ?>
</div>
 
</form>

<script>
function printPage() {
    window.print();
}
</script>
<? $this->load->view('admin/partials/footer') ?>
