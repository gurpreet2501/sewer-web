<?php $this->load->view('admin/partials/header'); ?>
<!-- filters -->
<div class="row">
	<div class="col-md-12">
		  <div class='filters'>
		    <form class="form-inline" method="post">
		       <div class="form-group">
		          <label class="sr-only" for="from">From Date</label>
		          <input type='text' name='filters[from_date]' id='from' value="" class="form-control _datepicker col-sm-2 date-input" placeholder="From Date" value='' />
		        </div>
		      
		        <div class="form-group">
		          <label class="sr-only" for="to">To Date</label>
		          <input type='text' name='filters[to_date]' id='to' value="" class="form-control _datepicker col-sm-2 date-input" placeholder='To date'
		          value='' />
		        </div>

		        <div class="form-group">
		          <select name="filters[machine_type]" class="form-control chosen-select">
		            <option disabled="true" selected="true">Select Machine Type</option>
		            <option value="ALL">All</option>
		            <option value="GAS">GAS</option>
		            <option value="SEWERAGE">SEWERAGE</option>
		          </select>
		        </div> 
		         <div class="form-group">
		          <select name="filters[machine_status]" class="form-control chosen-select">
		            <option disabled="true" selected="true">Select Machine Status</option>
		            <option value="1">Enabled</option>
		            <option value="0">Disabled</option>
		          </select>
		        </div>
		        <div class="form-group">
		          <select name="filters[button_status]" class="form-control chosen-select">
		            <option disabled="true" selected="true">Select Button Status</option>
		            <option value="1">Enabled</option>
		            <option value="0">Disabled</option>
		          </select>
		        </div>
		        <div class="form-group">
		          <select name="filters[blocked_status]" class="form-control chosen-select">
		            <option disabled="true" selected="true">Select Blocked/Unblocked</option>
		            <option value="1">Blocked</option>
		            <option value="0">Unblocked</option>
		          </select>
		        </div> 

		        <input type="submit" name="generate_report" class="btn btn-success" value="Filter">
		      </form>
		  </div>
	</div> <!-- col-md-12 -->
</div> <!-- row -->
<div class="row">         
	<div class="col-xs-12">
		<h1 class="text-center">MACHINES</h1>
		 <table class="table table-bordered">
		 		<tr>
		 				<td align="center"><strong>#Serial</strong></td>
		 				<td align="center"><strong>Name</strong></td>
		 				<td align="center"><strong>Machine Status</strong></td>
		 				<td align="center"><strong>Button Status</strong></td>
		 				<td align="center"><strong>Blocked Status/Toggle</strong></td>
		 		</tr>
		<?php foreach ($data->data as $key => $item):?>
			<tr>
				<td align="center"><?=ucwords($item->machine_serial)?></td>
				<td align="center"><?=$item->machine_name?></td>
				<td align="center">
					<input data-machine-id="<?=$item->id?>" id="machine_status_<?=$key?>" class="machine_status" data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="danger" 
						<?=($item->status ==1) ? 'checked' : ''?> data-toggle="toggle" data-onstyle="warning" data-offstyle="info" type="checkbox">
				</td>
				<td  align="center">
					<input data-machine-id="<?=$item->id?>" id="button_status_<?=$key?>" class="button_status" data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="danger" 
					<?=($item->button_status ==1) ? 'checked' : ''?> data-toggle="toggle" data-onstyle="warning" data-offstyle="info" type="checkbox">
						
				</td>
				<td  align="center">
					<input class="machine_blocked_status" data-machine-id="<?=$item->id?>" data-on="Unblocked" data-off="Blocked" data-onstyle="success" data-offstyle="danger" 
					<?=($item->blocked == 0) ? 'checked' : ''?> data-toggle="toggle" data-onstyle="warning" data-offstyle="info" type="checkbox">
				</td>
			</tr>
		<?php endforeach ?>
		 		
		 </table>
			
	</div>
</div>	
<?php  
$pagination = pagination_params($data);

	
	// $page = isset($_GET['page_no']) ? $_GET['page_no'] : 1;
	$next_page = $pagination['next_page'];
	$current_page = $pagination['current_page'];
	$previous_page = $pagination['previous_page'];
	$total_results = $pagination['total_results'];
	
		$pagination_params = [
			'filters' => isset($_GET['filters']) ? $_GET['filters'] : []
		];

	?>
<nav aria-label="...">
  <ul class="pager">
  	<?php if($previous_page>=1): ?>
    <li>
    	<a href='<?=site_url("dashboard/index/?".http_build_query($pagination_params)."&page_no={$previous_page}")?>'>Previous</a>
    </li>
  <?php endif; ?>
    <?php if($current_page <= $next_page): ?>
    <li>
    		<a href='<?=site_url("dashboard/index/?".http_build_query($pagination_params)."&page_no={$next_page}")?>'>Next</a>
    </li>
  <?php endif; ?>
  </ul>
 
  <div class="text-center">Total Results: <?=$total_results?></div>
</nav>
<?php $this->load->view('admin/partials/footer'); ?>
