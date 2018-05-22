<?php $this->load->view('admin/partials/header');?>
<div class="row pull-right">
	<div class="col-xs-12">
		<a href="<?=site_url('manager_dashboard/rate_contracts')?>"><button type="button" class="btn btn-danger">Back</button></a>
	</div>
</div>
<div class="row">
	<div class="col-xs-3"></div>
	<div class="col-xs-6">
		<div class="rate-contrct">
			<h2 class="text-center">
				Rate Contract Details
			</h2>
			<table  class="table table-bordered" cellspacing="5px">
				<tr>
					<td><strong>Contract ID</strong> </td>
					<td><?=$data->id?></td>
				</tr>
				<?php if(isset($data->account->name)):?>
				<tr>
					<td><strong>Account Name</strong> </td>
					<td><?=$data->account->name?></td>
				</tr>
			<?php endif; ?>
			<?php if(isset($data->stockGroup->name)):?>
				<tr>
					<td><strong>Stock Group</strong> </td>
					<td><?=$data->stockGroup->name?></td>
				</tr>
			<?php endif; ?>
			<?php if(isset($data->from_date)):?>
				<tr>
					<td><strong>From Date</strong> </td>
					<td><?=$data->from_date?></td>
				</tr>
			<?php endif; ?>

			<?php if($data->to_date): ?>
				<tr>
					<td><strong>To Date</strong> </td>
					<td><?=$data->to_date?></td>
				</tr>
			<?php endif; ?>	
			</table>
			<table class="table table-bordered">
				<tr>
					<td><strong>Stock Item Name</strong></td>
					<td><strong>Rate</strong></td>
					<td><strong>Weight (in quintails)</strong></td>
				</tr>
				<?php foreach ($data->contractsStockItems as $key => $value): ?>
					<tr>
						<?php if(isset($value->stockItem->name)): ?>
					 	  <td><?=$value->stockItem->name?></td>
					  <?php endif; ?>
						<?php if(isset($value->rate)): ?>
							<td><?=$value->rate?></td>
					  <?php endif; ?>
						<?php if(isset($value->weight)): ?>
							<td><?=number_format(($value->weight)/100.0, 2, '.', '')?></tr>
					  <?php endif; ?>
					</tr>
				<?php endforeach ?>

			</table>
		</div>
	</div>
</div>		
<?php $this->load->view('admin/partials/footer'); ?>
