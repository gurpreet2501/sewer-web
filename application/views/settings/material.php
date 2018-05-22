<? $this->load->view('admin/partials/header') ?>
<div class="row">
	<div class="col-xs-12 text-center">
		<h2>Select Modules</h2>
	</div>
</div>
<form method="post" action="<?=site_url('settings/gate_entry/save_material/'.$form_type)?>">
	<div class="row">
		<?php foreach($forms as $form): ?>
			<div class="col-xs-4">
			<h3><?=ht($form->name)?></h3>
				<? foreach($dataModules as $id => $name): ?>
				<div class="checkbox">
			    <label>
			      <input type="checkbox" 
			      				name="modules[<?=$form->id?>][<?=at($id)?>]" 
			      				<?=$form->hasGateEntryModule($id)?'CHECKED':'';?>>
			      <?=ht($name)?>
			     </label>
			  </div>
		    <? endforeach; ?>
			</div>
		<? endforeach; ?>
	</div>
	<div class="text-center">
		<input type="submit" class="btn btn-lg btn-primary" name="__save__" value="SAVE">
	</div>
</form>	
<? $this->load->view('admin/partials/footer') ?>
