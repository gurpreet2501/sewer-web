<?php 
use App\Libs\FormModules;
$obj = new FormModules($formData);

$this->view('admin/partials/header'); 
 ?>
<form method="post" action="<?=site_url('manager/formUpdate')?>">
	<div class="container">
	  <div class="row">
			<div class="col-xs-12">
				<h2 class="text-center">Master Form Creation/Edit Form</h2> <a href="<?=site_url('data/forms')?>"><button type="button" class="btn-danger pull-right">Back</button></a>
			</div>
		</div> <!-- row -->
		<div class="row">
			<div class="col-xs-3"></div>
			<div class="col-xs-3">
				<div class="form-group">
	    		<label for="form_name">Form Name</label>
	   		  <input type="text" class="form-control required" id="form_name" name="form_name" value="<?=$formData->name?>" placeholder="Enter Form Name">
	   		  <input type="hidden"  name="form_id" value="<?=$formData->id?>">
	  		</div>
			</div>  <!-- col-xs-3 -->
			<div class="col-xs-2">
				<div class="radio">
				  TYPE&nbsp; &nbsp;&nbsp;&nbsp;
				  <label>
				    <input type="radio" name="form_type" id="form_type" value="IN" <?=$formData->type == 'IN' ? 'checked' : ''?>>
				    IN
				  </label>
				  <label>
				    <input type="radio" name="form_type" id="form_type" value="OUT" <?=$formData->type == 'OUT' ? 'checked' : ''?>>
				    OUT
				  </label>
				</div>
			</div> <!-- col-xs-3 -->
				<div class="col-xs-4">
				<div class="radio">
				<label>CHATNI REPORT NO.</label>
				  <label>
				    <input type="radio" name="chatni_report_no" id="chatni_report_no" value="1" 
				    <?=($formData->chatni_report_no == 1) ? 'checked' : ''?> />
				    Show
				  </label>
				  <label>
				    <input type="radio" name="chatni_report_no" id="chatni_report_no" value="0"
				    <?=($formData->chatni_report_no == 0) ? 'checked' : ''?>
				    >
				    Hide
				  </label>
				</div>
			</div>
		</div> <!-- row -->
   <?php 
   $modules = $this->config->item('gate_entry_data_modules');

   $reqInputs = $this->config->item('required_inputs');

   foreach($modules as $mobuleKey => $module):
   		$checked = $obj->hasModule($mobuleKey) ? 'checked' : '';
    ?>
		<div class="row">
			<div class="col-xs-3"></div>
			<div class="col-xs-6">
					<div class="checkbox">
					  <label>
					    <input type="checkbox" value="<?=$mobuleKey?>" name="modulesEnabled[]" <?=$checked?>/>
					    <strong><?=$module?></strong>
					  </label>
					</div>
					<?php foreach($reqInputs as $inputKey => $inpts):
			
						if($mobuleKey == $inputKey){
								if($inpts['stock_group'] == 1)
									$this->load->view('manager/inputs/stock-group', [
										'key' => $mobuleKey,
										'stockGroupIds' => $obj->getStockGroupIds($mobuleKey)
										]);
								if($inpts['stock_items'] == 1)
									$this->load->view('manager/inputs/stock-items', [
										'key' => $mobuleKey,
										'stockItemIds' => $obj->getStockItemIds($mobuleKey)
										]);
								if($inpts['job_categories'] == 1)
									$this->load->view('manager/inputs/job-categories', [
										'key' => $mobuleKey,
										'jobCategoryIds' => $obj->getJobCategoryIds($mobuleKey)

										]);
								if($inpts['quality_cut_types'] == 1)
									$this->load->view('manager/inputs/quality-cut-types', [
										'key' => $mobuleKey,
										'qualityCutIds' => $obj->getQualityCutIds($mobuleKey)
										]);
							}
						 ?>
					<?php ?>
				<?php endforeach; ?>
			</div> <!-- col-xs-3 -->
		</div> <!-- row -->
  <?php endforeach;?>
	  <div class="row">
	  	<div class="col-xs-8"></div>
	  	<div class="col-xs-2"><button class="btn btn-danger" type="submit"  />Update</button>
	  </div>
	</div> <!-- container -->
</form>
<br/>
<?php $this->view('admin/partials/footer'); ?>
