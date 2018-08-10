<?php $this->load->view('admin/partials/header'); ?>
<!-- filters -->
<div class="row">
	<div class="col-md-12">
		  <div class='filters'>
		    <form class="form-inline" method="get">
		        <div class="form-group">
		        	<div><label >Machine Type</label></div>
		          <select name="filters[machine_type]" id="test" class="form-control chosen-select">
		            <option disabled="true" selected="true">Select Machine Type</option>
		            <option <?=$filters['machine_type'] == 'ALL' ? 'selected' : ''?> value="ALL">ALL</option> 
		            <option <?=$filters['machine_type'] == 'GAS' ? 'selected' : ''?> value="GAS">GAS</option> 
		            <option <?=$filters['machine_type'] == 'SEWERAGE' ? 'selected' : ''?> value="SEWERAGE">SEWERAGE</option>
		          </select>
		        </div> 
		         <div class="form-group">
		         	<div><label >Machine Status</label></div>
		          <select name="filters[machine_status]" class="form-control chosen-select">
		            <option disabled="true" >Select Machine Status</option>
		            <option <?=$filters['machine_status'] == 2 ? 'selected' : ''?> selected="true" value="2">ALL</option> 
		            <option <?=$filters['machine_status'] == 1 ? 'selected' : ''?> value="1">Enabled</option>
		            <option <?=$filters['machine_status'] == 0 ? 'selected' : ''?> value="0">Disabled</option>
		          </select>
		        </div>
		        <div class="form-group">
		        	<div><label >Button Status</label></div>
		          <select name="filters[button_status]" class="form-control chosen-select">
		            <option disabled="true" >Select Button Status</option>
		            <option <?=$filters['button_status'] == 2 ? 'selected' : ''?>selected="true" value="2">ALL</option>
		            <option <?=$filters['button_status'] == 1 ? 'selected' : ''?> value="1">Enabled</option>
		            <option <?=$filters['button_status'] == 0 ? 'selected' : ''?> value="0">Disabled</option>
		          </select>
		        </div>
		        <div class="form-group">
		        	<div><label >Machine Blocked Status </label></div>
		          <select name="filters[blocked_machines]" class="form-control chosen-select">
		            <option disabled="true">Select Blocked/Unblocked</option>
		            <option <?=$filters['blocked_machines'] == 2 ? 'selected' : ''?>  selected="true" value="2">ALL</option>
		            <option <?=$filters['blocked_machines'] == 1 ? 'selected' : ''?> value="1">Blocked</option>
		            <option <?=$filters['blocked_machines'] == 0 ? 'selected' : ''?> value="0">Unblocked</option>
		          </select>
		        </div> 
		        <input type="submit" name="filter" class="btn btn-success" value="FILTER">
		        <input type="submit" name="clear_filters" class="btn btn-danger" value="RESET">
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
		 				<td align="center"><strong>Machine Type</strong></td>
		 				<td align="center"><strong>Machine Status</strong></td>
		 				<td align="center"><strong>Button Status</strong></td>
		 				<td align="center"><strong>Blocked Status/Toggle</strong></td>
		 		</tr>
		<?php foreach ($data->data as $key => $item):?>
			<tr>
				<td align="center"><a href="<?=site_url('machine/details/'.$item->id)?>"><?=ucwords($item->machine_serial)?></a></td>
				<td align="center"><?=$item->machine_name?></td>
				<td align="center"><span class="label <?=$item->type == 'GAS' ? 'label-primary' : 'label-default'?>"><?=strtoupper($item->type)?></span></td>
				<td align="center">
					<input data-machine-serial="<?=trim($item->machine_serial)?>" id="machine_status_<?=$key?>" class="machine_status" data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="danger" 
						<?=($item->status ==1) ? 'checked' : ''?> data-toggle="toggle" data-onstyle="warning" data-offstyle="info" type="checkbox">
				</td>
				<td  align="center">
					<?php if($item->type == 'GAS'): ?>
							<input data-machine-serial="<?=trim($item->machine_serial)?>" id="button_status_<?=$key?>" class="button_status" data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="danger" 
							<?=($item->button_status ==1) ? 'checked' : ''?> data-toggle="toggle" data-onstyle="warning" data-offstyle="info" type="checkbox">
					<?php else: ?>
						<?php  echo '-NA-';?>;		
					<?php endif; ?>		
						
				</td>
				<td  align="center">
					<input class="machine_blocked_status" data-machine-serial="<?=trim($item->machine_serial)?>" data-on="Unblocked" data-off="Blocked" data-onstyle="success" data-offstyle="danger" 
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
