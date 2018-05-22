<form action="<?=site_url('manager_dashboard/store_cash_transaction') ?>" method="POST" v-on:submit="onSubmit" class="storage-form">

	<div class="col-md-6">
		<?php  $this->load->view('manger_dashboard/cash_transaction/debit'); ?>	
	</div>  
	<div class="col-md-6"> 
		<?php $this->load->view('manger_dashboard/cash_transaction/credit'); ?>
	</div>

	<div class="clearfix"></div>
	<div class="col-md-12">
						<hr>

		<div class="row">
		
			<div class="col-md-6">
				<div class="form-group form-inline">
					<label>Closing Balance:</label> 
					<input name="closing_balance" type="text" placeholder="00.00" v-model="closingBalance()" value="<?=$closingBalance?>" class="form-control read-only" readonly style="width: 200px;">
				</div>
			</div>

			
		</div>

		<hr>
	</div>

	<input type="hidden" value="<?=isset($account->id) ? $account->id : 0 ?>" name="primary_account_id">
	<input type="hidden" value="<?= $from_date ?>" name="from_date" >
	<input type="hidden" value="<?= $to_date ?>" name="to_date">


	<div class="col-md-12 text-right">
		<button type="submit" class="btn btn-success" name="form-action" value="store">Save</button>	
		<a href="<?= site_url('manager_dashboard/cash_transaction') ?>" class="btn btn-danger">Cancel</a>
	</div>
</form>
