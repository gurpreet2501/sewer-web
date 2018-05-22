<?php $this->load->view('admin/partials/header'); ?>

<form method="post" action="<?=site_url('manager_dashboard/save_bran_quality_report')?>" id="ge_delievery">
<input type="hidden" class="form-control" name="gate_entry_id" value="<?=$gate_entry_id?>"/>
<div class="row">
	<div class="col-xs-3"></div>
	<div class="col-xs-6">
		<h2 class="text-center">Bran Quality Report</h2>
	 <fieldset>
		  <legend>Weight</legend>
			<div class="form-group">
				<label for="weight">Weight at the delivery Godown</label>
				<input type="text" class="form-control required" name="ge_delivery_details[weight]"  />
			</div>
			<div class="form-group">
				<label for="weight-diff">Weight Difference</label>
				<input type="text" class="form-control" name="ge_delivery_details[weight_diff]"  />
			</div>
			<div class="form-group">
				<label for="weight-diff">Party Test Report</label>
				<input type="text" class="form-control" name="bran_quality_report[party_test_report]"  />
			</div>
			<div class="form-group">
				<label for="weight-diff">Lab Test Report</label>
				<input type="text" class="form-control" name="bran_quality_report[lab_test_report]"  />
			</div>
			<div class="form-group">
				<label for="weight-diff">Disputed</label>
				<select class="form-control" name="bran_quality_report[disputed]">
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>  
			</div>
			<div class="form-group">
				<label for="weight-diff">Remarks</label>
				<input type="text" class="form-control" name="bran_quality_report[remarks]"  />
			</div>
		</fieldset>
		<div class="fieldset-spacer"></div>
		<br/>
		<button type="submit" class="btn btn-danger pull-right">Update</button>
	</div> <!-- col-xs-8 -->
	<div class="col-xs-3"></div>
</div> <!-- row ends -->
</form>
<?php $this->load->view('admin/partials/footer'); ?>
