<?php $this->load->view('admin/partials/header'); ?>	
<h2 class="text-center">Check Entry Differences</h2>
<br>
<div class="row">
		
	<?php $total_entries = 0; foreach ($ge as $key => $entry):
			if($total_entries > 20)
				break;
	        $color = '';
			if(count($entry->differences)){
				$total_entries = $total_entries+1;
				$color = 'color-red';
			}else{
				continue;
			}
	?>
		<div class="col-md-3">
			<a class="no-decoration" href="<?=site_url('manager_dashboard/edited_gate_entries/'.$entry->id)?>">
				<div class="ge-entry-edit-panel <?=$color?>">
				
					<div class="fields">Gate Entry ID: #<?=$entry->id?></div>
					<div class="fields">Entry Type: <?=$entry->entry_type?></div>
					<div class="fields">Party Name: <?=strtoupper($entry->accounts->name)?></div>
				</div>
			</a>
		</div>
	<?php endforeach ?>
</div>

<?php $this->load->view('admin/partials/footer'); ?>
