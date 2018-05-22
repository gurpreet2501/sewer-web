<? $this->load->view('admin/partials/header'); ?>
<div class="row">
  <div class="col-lg-4"></div>
  <div class="col-lg-4">
    <h2 class="text-center">Add Custom Job</h2> 
	  <form method="post" action="<?=site_url('data/saveCustomLabourJob/?'.$get_string)?>">
		  <div class="form-group">
		    <label for="weight">Labour Job Name</label>
		    <input type="text" class="form-control" name="job_name" />
		  </div>
		  <div class="form-group">
		    <label for="">Party Name</label>
		    <select name="labour_party_id" class="required form-control">
		     	<option disabled selected>--Select--</option>		
		    	<?php foreach ($accounts as $key => $account): ?>
		    	  <option value="<?=$account->id?>" <?=($stub['party_id'] == $account->id) ? 'selected' : ''?>><?=$account->name?></option>		
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
		    <label for="amount">Amount</label>
		    <input type="text" class="form-control required" name="amount" />
		  </div>
		  <div class="form-group">
		    <label for="weight">Remarks</label>
		    <textarea class="form-control" rows="3" name="remarks"></textarea>
		  </div>
		  <div class="form-group">
		    <label for="date">Date</label>
		    <input type="text" class="required form-control _datepicker" id="dateTime" placeholder="Choose Date" name="created_at">
		  </div>
		  <button type="submit" class="btn btn-danger pull-right">Submit</button>
		</form>
  </div> <!-- col-xs-6 -->
  <div class="col-xs-4"></div>
</div>
<? $this->load->view('admin/partials/footer') ?>
