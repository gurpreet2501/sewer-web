<? $this->load->view('admin/partials/header'); 
$page_no = isset($_GET['page_no']) ? $_GET['page_no'] : 1;
$params_data = !empty($_GET) ? $_GET : [];
$params_data['sale_purchase_report_print'] = 1;
$get_params = http_build_query($params_data);
 ?>
 <div class="row">
 	<div class="col-md-6"><h3><?=$type == 'OUT' ? 'Sales Report' : 'Purchase Report'?></h3></div>
 	  <div class="col-lg-6">
		 <form  method="get" action="<?=site_url('manager_dashboard/generate_purchase_daily_report_csv')?>" class="form-inline report-gen-form">
		 	<input type="hidden" name="entry_type" value="<?=$type?>">
		  	<div class="form-group">
				  <label for="start_date">Start Date</label>
					<input type="text" id="start_date" class="form-control force-extend _datepicker" name="start_date" placeholder="Select Start Date" 
					value="<?=date('Y-m-d')?>" />
				</div>	
				<div class="form-group">
				  <label for="end_date">End Date</label>
					<input  type="text" value="<?=date('Y-m-d')?>" class="form-control force-extend _datepicker" name="end_date" placeholder="Select End Date" id="end_date">
				</div>
		  	<button type="submit" class="btn btn-success">Download Report</button>
	  </form>	
	  
  </div>
 </div>
<div class="row">
	  <div class="col-lg-10">
		 <form  method="post" action="<?=site_url('data/sale_purchase_gate_entries/?entry_type='.$type.'&page_no='.$page_no)?>" class="form-inline report-gen-form" id="__filter">
		 	<input type="hidden" name="filters[entry_type]" value="<?=$type?>">
		  		<div class="form-group">
				  <label for="start_date">Party Name</label>
				  <select class="form-control" name="filters[account_id]">
				  	<option disabled selected>Select Party</option>
				  	<?php foreach ($accounts as $key => $account): ?>
				  		<option <?=($stub['account_id'] == $account->id) ? 'selected' : ''?> value="<?=$account->id?>"><?=$account->name?></option>
				  	<?php endforeach ?>
				  </select>
				</div>	
				<div class="form-group">
				  <label for="start_date">Form Name</label>
				  <select class="form-control" name="filters[form_id]">
				  	<option disabled selected>Select Form</option>
				  	<?php foreach ($forms as $key => $form): ?>
				  		<option <?=($stub['form_id'] == $form->id) ? 'selected' : ''?> value="<?=$form->id?>"><?=$form->name?></option>
				  	<?php endforeach ?>
				  </select>
				</div>	
				<div class="form-group">
				  <label for="end_date">Truck No</label>
					<input  type="text" value="<?=$stub['truck_no']?>" class="form-control force-extend" name="filters[truck_no]" placeholder="Truck No" id="truck_no">
				</div>
				<div class="form-group">
				  <label for="start_date">Start Date</label>
					<input type="text" id="filters_start_date" class="form-control force-extend _datepicker" name="filters[start_date]" placeholder="Select Start Date" 
					value="<?=$stub['start_date']?>" />
				</div>	
				<div class="form-group">
				  <label for="end_date">End Date</label>
					<input  type="text" value="<?=$stub['end_date']?>" class="form-control force-extend _datepicker" name="filters[end_date]" placeholder="Select End Date" id="filters_end_date">
				</div>
		  	
		  	<button type="submit" class="btn btn-success">Filter Results</button>
	  </form>	
  </div>
  <div class="col-md-2"></div>
</div>
<hr>
<div class="row">
  <div class="col-lg-12">
  	<table class="table table-stripped">
	  	<tr>
	  		<th align="center">Serial</th>
	  		<th>Date</th>
	  		<th>Party Name</th>
	  		<th>Form Name</th>
	  		<th>Truck No</th>
	  		<th>Net Weight In Q</th>
	  		<th>Actions</th>
	  	</tr>
		  	<?php foreach ($gate_entries as $key => $ge): ?>
		  	<tr>
		  		<td align="center">#<?=$ge->id.$ge->prefix.$ge->serial?></td>
		  		<td align="center"><?=$ge->second_weight_date?></td>
		  		<td align="center"><?=isset($ge->accounts->name) ? $ge->accounts->name : ''?></td>
		  		<td align="center"><?=$ge->forms->name?></td>
		  		<td align="center"><?=$ge->truck_no?></td>
		  		<td align="center"><?=($ge->net_weight)/100.0?></td>
		  		<td align="center">
		  			<a href="<?=site_url('gate_entry/view/'.$ge->id)?>"><button class="btn btn-success">View</button></a>
		  			<a href="<?=site_url('weight_receipt/print_slip/'.$ge->id.'/?'.$get_params)?>"><button class="btn btn-warning">Print</button></a>
		  			<a href="<?=site_url('gate_pass/index/'.$ge->id.'/?only_edit=1')?>"><button class="btn btn-danger">Edit</button></a>
		  		</td>
		  	</tr>
		  	<?php endforeach;?>
    </table>
  </div>
</div>
<?php  
	

  	
	$pagination = pagination_params($gate_entries);
	// $page = isset($_GET['page_no']) ? $_GET['page_no'] : 1;
	$entry_type = isset($_GET['entry_type']) ? $_GET['entry_type'] : '';
	$last_page = $pagination['last_page'];
	$next_page = $pagination['next_page'];
	$total = $pagination['total_results'];
	$previous_page = $pagination['previous_page'];

	?>
<nav aria-label="...">
  <ul class="pager">
  	<?php if($previous_page>=1): ?>
    <li>
    	<a href='<?=site_url("data/sale_purchase_gate_entries/?entry_type={$entry_type}&page_no={$previous_page}")?>'>Previous</a>
    </li>
  <?php endif; ?>
    <?php if($last_page != $next_page): ?>
    <li>
    		<a href='<?=site_url("data/sale_purchase_gate_entries/?entry_type={$entry_type}&page_no={$next_page}")?>'>Next</a>
    </li>
  <?php endif; ?>
  </ul>
</nav>
  <div class="text-center">Total Results: <?=$total?></div>
<? $this->load->view('admin/partials/footer') ?>
