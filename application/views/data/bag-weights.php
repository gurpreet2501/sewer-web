<? $this->load->view('admin/partials/header'); ?>
<div class="row">
	<div class="col-xs-12">
		<h2 class="text-center">Bag Weights</h2>
		<br/>
	</div>
</div>
<div class="row">
	<div class="col-xs-2"></div>
	<div class="col-xs-8">
<?php if(count($stGrps)): ?>
		<table class="table table-stripped">
			<tr>
				<td>Stock Group</td>
				<td>Weight Unit</td>
				<td>Weight</td>
			</tr>
	<form method="post" action="<?=site_url('data/saveBagWeights')?>">
	<?php
	 $weight = 0.00;
	 $weight_unit = '';
	 foreach($stGrps as $key => $stgrp):
				foreach($stgrp->bagWeights as $entity){
					$weight = $entity->weight ? $entity->weight : 0.00;
					$weight_unit = $entity->weight_unit ? $entity->weight_unit : '';
				}
	?>

			 <tr> 
			 <td><?=$stgrp->name?></td>
			 <td>
			 <select class="form-control" name="data[<?=$stgrp->id?>][weight_unit]" >
			 <?php foreach($wtUnits as $unit): ?> 
			 	<option <?=($weight_unit == $unit->name) ? 'selected' : ''?> value="<?=$unit->name?>"><?=$unit->name?></option>
			 <?php endforeach; ?> 

			 </select>
			 </td>
			 <td><input type="text" name="data[<?=$stgrp->id?>][weight]" class="form-control" 
			 value="<?=isset($weight) ? $weight : 0.00?>"
			  /></td>
			</tr>
	<?php endforeach; ?>
			<td><button type="submit" class="btn btn-danger">Update</button></td>
		</form>		
		</table>
	<?php else:?>
	<h4 class="text-center">No Records Found ! </h4>
	<?php endif;?>

	</div>
</div>
<? $this->load->view('admin/partials/footer'); ?>
