<?php $this->load->view('admin/partials/header');  ?>

<style>
	.form-control[disabled], 
	.form-control[readonly], 
	fieldset[disabled] .form-control{
		width: 130px !important;
		border: 1px solid #ccc;
	}

	#debit_trans th a,
	#credit_trans th a{
		cursor: pointer;
	}
	#debit_trans th,
	#credit_trans th{
		text-align: left;
	}
	#debit_trans th:first-child,
	#credit_trans th:first-child{
		/*width: 218px;
    	padding-left: 58px;*/
    	width: 6%;
	}
	#debit_trans td,
	#credit_trans td{
	    padding: 0px 12px;
	}

	#debit_trans td input,
	#credit_trans td input{
		height: 29px;
	    font-size: 12px;
	    padding: 1px 0px 0px 4px;
	}

	#debit_trans td.date,
	#credit_trans td.date {
		width: 83px !important;
	}
</style>
<div class="" id="add-cash-transaction">
	<?php if (isset($_GET['alert'])): ?>
		<div class="alert alert-success"><?=$_GET['alert'] ?>	</div>
	<?php endif; ?>

   <div class="row ">
   		<div class="col-xs-8"></div>
   		<div class="col-xs-4 text-right">
   		  <!-- <button class="btn btn-danger" onclick="addCashAccount()">Add New Acc</button> -->
   		  <a href="<?=site_url('manager_dashboard/add_cash_transaction/'.$accountId.'/?pdfDownload=true&from_date='.$from_date.'&to_date='.$to_date)?>"><button type="button" class="btn btn-danger">PDF Download</button></a>
   		  <a href="<?=site_url('manager_dashboard/add_cash_transaction/'.$accountId.'/?csvDownload=true&from_date='.$from_date.'&to_date='.$to_date)?>"><button type="button" class="btn btn-danger">CSV Download</button></a>
   		</div>		
   </div>
	<div class="row">
		<div class="text-center"><h2>Add Entries For <?=isset($account->name) ? $account->name : ('#' . (($account->id) ? $account->id : 0)) ?></h2></div>
		<div class="alert alert-danger form-error text-center" style="display: none">Incomplete entry.</div>
		<div class="col-md-12">
			<hr>
			<div class="form-group col-md-2">
				
			</div>
			<div class="form-group form-inline col-md-4">
				<label >Opening Balance:</label> 
				<input name="opening_balance" type="text" value="<?=$openingBalance?>" class="form-control read-only" readonly style="width: 200px;">
			</div>
			<div class="col-md-6">
				<?php $this->load->view('manger_dashboard/cash_transaction/date_calculation_form'); ?>
			</div>
			<hr> 
		</div>
		<?php
		    $this->load->view('manger_dashboard/cash_transaction/storage_form'); 
			  // $this->load->view('manger_dashboard/cash_transaction/list_posts'); 	
		?>
		
	</div><!-- row -->
</div>
<?php $this->load->view('admin/partials/footer'); ?>
 
