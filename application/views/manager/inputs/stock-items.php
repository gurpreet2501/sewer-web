
<div class="row">
	<div class="col-xs-2"></div>
	<div class="col-xs-4"><div class="sub-title">Stock Items</div></div>
	<div class="col-xs-6">
		<div class="form-group">
			<select data-placeholder="Select Stock Item..."  multiple class="chosen-select form-control" name="stock_items[<?=$key?>][]">
			<?php foreach($stockItems as $stItem): ?>
	  		<option value="<?=$stItem->id?>" <?=in_array($stItem->id,$stockItemIds) ? 'selected' : ''?>><?=$stItem->name?></option>
	  <?php endforeach; ?>	
	  	</select>
		</div>
	</div>
</div>
