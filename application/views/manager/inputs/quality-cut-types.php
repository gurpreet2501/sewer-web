<div class="row">
	<div class="col-xs-2"></div>
	<div class="col-xs-4"><div class="sub-title">Quality Cut Types</div></div>
	<div class="col-xs-6">
		<div class="form-group">
			<select data-placeholder="Choose Quality Cut..." name="quality_cut[<?=$key?>][]"  multiple class="chosen-select form-control">
				<?php foreach($qualityCutTypes as $qcut): ?>
			  		<option value="<?=$qcut->id?>" <?=in_array($qcut->id, $qualityCutIds) ? 'selected' : ''?>><?=$qcut->name?></option>
			  <?php endforeach; ?>
			</select>
		</div>
	</div>
</div>
