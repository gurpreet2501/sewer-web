<?php $this->load->view('admin/partials/header'); ?>
<div class="row">
	<div class="col-xs-10"></div>
	<div class="col-xs-2">
		<a href="<?=site_url('manager_dashboard/generate_purchase_daily_report_csv/?start_date='.$stub['start_date'].'&end_date='.$stub['end_date'])?>">
				<button type="submit" class="btn btn-success">Generate Csv</button>
			</a>
	</div>
</div>
<div class="row text-center">
  <div class="col-xs-2"></div>
	<div class="col-xs-8">
	<h2>Generate Daily Purchase Report</h2>
	  <form method="post" class="form-inline">	
		  	<div class="form-group">
				  <label for="start_date">Start Date</label>
					<input type="text" id="start_date" class="form-control force-extend _datepicker" name="start_date" value="<?=$stub['start_date']?>" placeholder="Select Start Date"  />
				</div>	
				<div class="form-group">
				  <label for="end_date">End Date</label>
					<input type="text" class="form-control force-extend _datepicker" name="end_date" placeholder="Select End Date" id="end_date" value="<?=$stub['end_date']?>"/>
				</div>
		  	<button type="submit" class="btn btn-success">Go</button>
	  </form>	
	</div> <!-- col-xs-4 -->
	<div class="col-xs-2"></div>
</div> <!-- row -->
<br/>
<?php if(count($gate_entries)): ?>
<div class="row">
	<div class="col-xs-12">
		<table class="table table-stripped">
			<tr>
				<td>Sno</td>
				<td>Party Name</td>
				<td>Truck No</td>
				<td>Loaded Weight</td>
				<td>Status</td>
			</tr>
			<?php foreach($gate_entries as $entry):  ?>
			<tr>
				<td><?=$entry->id?></td>
				<td><?=isset($entry->accounts) ? $entry->accounts->name : '-'?></td>
				<td><?=$entry->truck_no?></td>
				<td><?=$entry->loaded_weight?></td>
				<td><?=$entry->status?></td>
			</tr>
		<?php endforeach; ?>	
		</table>
	</div>
</div>
<?php else: ?>
	<div class="row">
		<div class="col-xs-12">
			<h2 class="text-center">No Records Found.</h2>
		</div>
	</div>
<?php endif; ?>
<?php $this->load->view('admin/partials/footer'); ?>
