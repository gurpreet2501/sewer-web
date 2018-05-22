<?php $this->load->view('admin/partials/header');?>
<div id="create_labour_party">
	<div class="row">
		<div class="col-xs-4"></div>
		<div class="col-xs-4"><h3>Add Labour Party</h3></div>
		<div class="col-xs-4"></div>
	</div>
	<div class="row">
		<div class="col-xs-4"></div>
		<div class="col-xs-4">
			<form method="post" action="<?=site_url('labour_party/saveForm')?>">
			  <div class="form-group">
			    <label for="exampleInputEmail1">Labour Party Name</label>
			    <input type="text" name="account_name" class="form-control" id="" placeholder="Labour Party Name">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputPassword1">Choose Category</label>
			     <select  data-placeholder="Choose Job Category..." name="job_category[]"  multiple class="chosen-select form-control"  id="choose-category">
					<?php foreach($labour_job_categories as $jobCat):?>
				  		<option data-id="<?=$jobCat->id?>" value="<?=$jobCat->id?>"><?=$jobCat->name?></option>
				  <?php endforeach; ?>
			</select>
			  </div>
			  <div class="form-group" v-for="jobType in jobTypes">
			  	<label>{{jobType.name}}</label>
			  	<input type="text" class="form-control" v-bind:name="'job_type_rate['+jobType.id+']'">
			  </div>
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
		</div>
		<div class="col-xs-4"></div>
	</div>
</div>
<?php $this->load->view('admin/partials/footer');?>
