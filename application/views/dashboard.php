<?php $this->load->view('admin/partials/header'); ?>
<div class="row">
	<div class="col-xs-6">
		<?php if(count($results)): ?>
		<h3 class="text-center">MATERIAL <?=ht('IN')?></h3>
		<table class="table text-center">
			<tr>
				<th>ID</th>
				<th>Account Name</th>
				<th>Truck Name</th>
				<th>Loaded Weight</th> 
				<th>Tare Weight</th>
				<th>Date</th>
				<th>Action</th>
			</tr>

		<?php foreach($results as $entry): 
			if($entry->entry_type != 'IN')
				continue;
		    $account_name = get_account_name($entry->account_id);
		?>	
			<tr>
				<td><?=$entry->id.$entry->prefix.$entry->serial?></td>
				<td><?=ht($account_name)?></td>
				<td><?=ht($entry->truck_no)?></td>
				<td><?=ht($entry->loaded_weight)?></td>
				<td><?=ht($entry->tare_weight)?></td>
				<td>
					<?=date('d/m',strtotime($entry->created_at))?>
					<div><?=date('H:i',strtotime($entry->created_at))?></div>	
					
				</td>
				<td colspan="2"><a href="<?=site_url('gate_pass/index/'.$entry->id)?>"><button type="button" class="btn-success">Update</button></a>
				<?php if(user_role()=='admin'): ?>
					<div class="margin-top-5 text-center">
							<a href="<?=site_url('gate_pass/index/'.$entry->id.'?only_edit=1')?>"><button type="button" class="btn-warning">Edit</button></a>
					  <div class="margin-top-5 text-center">
							<a href="#" class="cancel-ge-btn" data-user_id="<?=user_id()?>" data-ge_id="<?=$entry->id?>" ><button type="button" class="btn-danger">Cancel</button></a>						
					</div>
			   <?php endif; ?>
				</td>
			</tr>
 		<?php endforeach; ?>	
		</table>
		<hr />
	<?php else: ?>
		<div class="text-center"><h2>No Records Found</h2></div>
	<?php endif; ?>
	</div><!-- col-xs-6 -->

	<div class="col-xs-6">
		<?php if(count($results)): ?>
		<h3 class="text-center">MATERIAL <?=ht('OUT')?></h3>
		<table class="table text-center">
			<tr>
				<th>ID</th>
				<th>Account Name</th>
				<th>Truck Name</th>
				<th>Loaded Weight</th> 
				<th>Tare Weight</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
			
		<?php foreach($results as $entry): 
			if($entry->entry_type != 'OUT')
				continue;
		    $account_name = get_account_name($entry->account_id);
		?>	
			<tr>
				<td><?=$entry->id.$entry->prefix.$entry->serial?></td>
				<td><?=ht($account_name)?></td>
				<td><?=ht($entry->truck_no)?></td>
				<td><?=ht($entry->loaded_weight)?></td>
				<td><?=ht($entry->tare_weight)?></td>
				<td>
					<?=date('d/m',strtotime($entry->created_at))?>
					<div><?=date('H:i',strtotime($entry->created_at))?></div>	
					
				</td>
					<td colspan="2"><a href="<?=site_url('gate_pass/index/'.$entry->id)?>"><button type="button" class="btn-success">Update</button></a>
				<?php if(user_role()=='admin'): ?>
					<div class="margin-top-5 text-center">
							<a href="<?=site_url('gate_pass/index/'.$entry->id.'?only_edit=1')?>"><button type="button" class="btn-warning">Edit</button></a>
					  <div class="margin-top-5 text-center">
							<a href="#" class="cancel-ge-btn" data-user_id="<?=user_id()?>" data-ge_id="<?=$entry->id?>" ><button type="button" class="btn-danger">Cancel</button></a>						
					</div>
			   <?php endif; ?>
				</td>
			</tr>
 		<?php endforeach; ?>	
		</table>
		<hr />
	<?php else: ?>
		<div class="text-center"><h2>No Records Found</h2></div>
	<?php endif; ?>
	</div>



</div>
<?php $this->load->view('admin/partials/footer'); ?>
