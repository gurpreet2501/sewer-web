<?php $this->load->view('admin/partials/header'); ?>
<!-- $selected_labour_job_categories -->
<div id="create_labour_party">
	<div class="row">
		<div class="col-xs-4"></div>
		<div class="col-xs-4"><h3>Update Labour Party</h3></div>
		<div class="col-xs-4"></div>
	</div>

	<div class="row">
		<div class="col-xs-4"></div>
		<div class="col-xs-4">
			<form method="post" action="<?=site_url('labour_party/updateForm')?>">
			  <div class="form-group">
			    <label for="exampleInputEmail1">Labour Party Name</label>
			    <input type="text" name="account_name" class="form-control" value="<?=$account_name?>" placeholder="Labour Party Name">
			    <input type="hidden" name="account_id" class="form-control" value="<?=$account_id?>" />
			  </div>
			  <div class="form-group">
			    <label for="exampleInputPassword1">Choose Category</label>
			     <select  data-placeholder="Choose Job Category..." name="job_category[]"  multiple class="chosen-select form-control"  id="choose-category">
					<?php foreach($labour_job_categories as $jobCat):?>
				  		<option data-id="<?=$jobCat->id?>" <?=in_array($jobCat->id, $selected_labour_job_categories) ? 'selected' : ''?> value="<?=$jobCat->id?>"><?=$jobCat->name?></option>
				  <?php endforeach; ?>
			   </select>
			  </div>
			  <div class="title" v-if="jobTypes.length"><h4>Job Types</h4></div>
			  <div class="form-group" v-for="jobType in jobTypes">
			  	  <fieldset class="job_type">
			  	  	<legend>{{jobType.name}}</legend>
			  	  	<div class="row">
			  			<div class="col-xs-9">
				  			<div class="lb-job-cat-sub-titles">
				  					<span>Job Category:</span>
				  					<span class="color-red"> {{jobType.labour_job_category.name}}</span>
				  			</div>
				  			<div class="lb-job-cat-sub-titles">
				  					<span>Description:</span> <em>{{jobType.job_description}}</em>
				  			</div>
			  			</div> <!-- col-xs-9 -->
			  			<div class="col-xs-3">
			  				<input type="text" class="form-control job_type_input_box" v-model="getJobTypeValue(jobType.id)" v-bind:name="'job_type_rate['+jobType.id+']'">
			  			</div>
			  		</div>		
			  	  </fieldset>
			  </div>
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
		</div>
		<div class="col-xs-4"></div>
	</div>
</div>
<?php $this->load->view('admin/partials/footer');?>
