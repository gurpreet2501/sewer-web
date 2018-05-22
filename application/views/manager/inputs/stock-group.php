
<div class="row">
	<div class="col-xs-2"></div>
	<div class="col-xs-4"><div class="sub-title">Stock Group</div></div>
	<div class="col-xs-6">
		<div class="form-group">
			<select data-placeholder="Select Group..."  multiple class="chosen-select form-control" name="stock_group[<?=$key?>][]">
			<?php foreach($stockGrps as $stGrp): ?>
	  		<option value="<?=$stGrp->id?>" <?=in_array($stGrp->id,$stockGroupIds) ? 'selected' : ''?>><?=$stGrp->name?></option>
	  <?php endforeach; ?>	
	  	</select>
		</div>
	</div>
</div>
