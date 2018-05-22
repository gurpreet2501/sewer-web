<?php $this->load->view('admin/partials/header'); ?>
<div class="row">
	<div class="col-xs-12">
		<h2 class="text-center">Gate Entries</h2>
		<hr/>
		<br/>
		<?php if(count($results)): ?>
		<table class="table text-center">
			<tr>
				<th>ID</th>
				<th>Party Name</th>
				<th>Truck Name</th>
				<th>Loaded Weight</th>
				<th>Tare Weight</th>
				<th>Action</th>
			</tr>

		<?php foreach($results as $entry): 
		    $party_name = get_party_name($entry->party_id);
		?>	
			<tr>
				<td><?=$entry->id?></td>
				<td><?=ht($party_name)?></td>
				<td><?=ht($entry->truck_no)?></td>
				<td><?=ht($entry->loaded_weight)?></td>
				<td><?=ht($entry->tare_weight)?></td>
				<td><a href="<?=site_url('gate_pass/index/'.$entry->id)?>"><button type="button" class="btn-danger">Update</button></a></td>
			</tr>
 		<?php endforeach; ?>	
		</table>
	<?php else: ?>
		<div class="text-center"><h2>No Records Found</h2></div>
	<?php endif; ?>
	</div>
</div>
<?php $this->load->view('admin/partials/footer'); ?>
