<div class="row">
	<div class="col-xs-2"></div>
	<div class="col-xs-4"><div class="sub-title">Job Categories</div></div>
	<div class="col-xs-6">
		<div class="form-group">
			<select data-placeholder="Choose Job Category..." name="job_category[<?=$key?>][]"  multiple class="chosen-select form-control">
				<?php foreach($lbrJobCat as $jobCat): ?>
			  		<option value="<?=$jobCat->id?>" <?=in_array($jobCat->id, $jobCategoryIds) ? 'selected' : ''?>><?=$jobCat->name?></option>
			  <?php endforeach; ?>
			</select>
		</div>
	</div>
</div>
