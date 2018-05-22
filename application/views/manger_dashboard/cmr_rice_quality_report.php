<?php $this->load->view('admin/partials/header'); ?>
<div class="row">
	<div class="col-xs-12">
		<h2 class="text-center">Partially Completed Gate Entries</h2>
		<hr/>
		<br/>
		<?php if(count($list)): ?>
		<table class="table text-center">
			<tr>
				<th>ID</th>
				<th>Account Name</th>
				<th>Truck Name</th>
				<th>Loaded Weight</th>
				<th>Tare Weight</th>
				<th>Action</th>
			</tr>

		<?php foreach($list as $entry):  $account_name = get_account_name($entry->account_id);
		?>	
			<tr>
				<td><?=$entry->id?></td>
				<td><?=ht($account_name)?></td>
				<td><?=$entry->truck_no?></td>
				<td><?=$entry->loaded_weight?></td>
				<td><?=$entry->tare_weight?></td>
				<td><a href="<?=site_url('manager_dashboard/cmr_rice_quality_report_input/'.$entry->id)?>"><button type="button" class="btn-danger">Update</button></a></td>
			</tr>
 		<?php endforeach; ?>	
		</table>
	<?php else: ?>
		<div class="text-center"><h2>No Records Found</h2></div>
	<?php endif; ?>
	</div>
</div>
<?php $this->load->view('admin/partials/footer'); ?>
