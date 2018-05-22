<? $this->load->view('admin/partials/header'); ?>
<div class="row">
  <div class="col-lg-4"></div>
  <div class="col-lg-4">
    <h2 class="text-center">Add Labour Job</h2> 
	  <form method="post" action="<?=site_url('data/saveOtherLabourJob')?>">
		  <div class="form-group">
		    <label for="weight">Labour Job Types</label>
		    <select name="job_type_id" class="required form-control">
		    	  <option disabled selected>--Select--</option>		
		    	<?php foreach ($labour_job_types as $key => $labJobType): ?>
		    	  <option value="<?=$labJobType->id?>"><?=$labJobType->name?></option>		
		    	<?php endforeach ?>
		    </select>
		  </div>
		  <div class="form-group">
		    <label for="weight">Godown</label>
		    <select name="godown_id" class="required form-control">
		     	<option disabled selected>--Select--</option>		
		    	<?php foreach ($godowns as $key => $godown): ?>
		    	  <option value="<?=$godown->id?>"><?=$godown->name?></option>		
		    	<?php endforeach ?>
		    </select>
		  </div>
		  <div class="form-group">
		    <label for="weight">Weight</label>
		    <input type="text" class="required form-control" id="weight" placeholder="Enter Weight" name="weight">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputFile">Weight Unit</label>
		    <select name="weight_unit" class="required form-control" id="from_date">
		    	<option disabled selected>--Select--</option>	
		    	<?php foreach ($weight_units as $key => $wunit): ?>
		    	  <option value="<?=$wunit->id?>"><?=$wunit->name?></option>		
		    	<?php endforeach ?>
		    </select>
		  </div>
		  <div class="form-group">
		    <label for="date">Date</label>
		    <input type="text" class="required form-control _datepicker" id="dateTime" placeholder="Enter Date" name="date">
		  </div>
		  <input type="hidden" name="party_id" value="<?=$party_id?>" />
		  <button type="submit" class="btn btn-danger pull-right">Submit</button>
		</form>
  </div> <!-- col-xs-6 -->
  <div class="col-xs-4"></div>
</div>
<? $this->load->view('admin/partials/footer') ?>
