<?php $this->load->view('admin/partials/header'); ?>
<div class="row" id="transactions_report_generator">	
	<div class="col-md-8 col-md-offset-2">
		<div class="title text-center">
		<br><h4>Generate Report</h4><br>
		</div>
	<form class="form-horizontal" method="GET" action="<?= site_url('manager_dashboard/profit_loss_report') ?>" target="_blank">
			<!-- Select Basic -->
			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="from_date">From Date</label>  
			  <div class="col-md-4">
			  <input id="from_date" name="from_date" type="text" placeholder="From Date" class="form-control input-md">
			  </div>
			</div>

			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="to_date">To Date</label>  
			  <div class="col-md-4">
			  <input id="to_date" name="to_date" type="text" placeholder="To Date" class="form-control input-md">
			  </div>
			</div>

			<!-- Button -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="generate"></label>
			  <div class="col-md-4">
			    <button id="generate" name="generate" class="btn btn-success">Generate Report</button>
			  </div>

		</form>
	</div>
</div>
<?php $this->load->view('admin/partials/footer'); ?>
