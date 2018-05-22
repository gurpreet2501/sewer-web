<?php $account_id = isset($account->id) ? $account->id : 0; ?>
<form action="<?=site_url('manager_dashboard/add_cash_transaction/'.$account_id) ?>" method="get">
	<div class="row">
		<div class="col-md-4"> 
			<div class="form-group form-inline">
				<label style="width: 30px;">From:</label> 
				<input name="from_date" type="text" class="form-control from_date" value="<?= $from_date ?>">
			</div>
		</div>
		<div class="col-md-4"> 
			<div class="form-group form-inline">
				<label  style="width: 15px;">To:</label> 
				<input name="to_date" type="text" class="form-control to_date" value="<?= $to_date ?>">
			</div>
		</div>
		<div class="col-md-2">
			<button type="submit" class="btn btn-primary">Set Date Range</button>
			
		</div>

	</div>
</form>
