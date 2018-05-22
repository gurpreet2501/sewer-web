<?php $this->load->view('admin/partials/header'); ?>
<div class="row">
	<div class="col-xs-4"></div>
	<div class="col-xs-4">
		<div id="add-new-labor-job">
			<h2>Add New Job</h2>
				<form action="<?=site_url('data/save_new_labor_job/?'.$get_string)?>" method="post">
				  <div class="form-group">
				    <label for="tp_date">Labour Party Name</label>
				    <select class="form-control required" name="labour_party_id" tabindex="5" id="party_id" v-model="account_id">
				    	<option>-Select-</option>
				    	<option v-for="account in accounts"  v-bind:value="account.id">{{account.name}}</option>
				    </select>
				  </div>  
				  <div class="form-group" v-if="account_id">
				    <label for="exampleInputEmail1">Account Labour Job Category</label>
				    <select name="account_labour_job_cat" class="form-control" v-model="job_labour_cat_id"  placeholder="Labour Job Type">
						    <option selected disabled>-Select-</option>
						    <option v-bind:value="accLabJobCat.labour_categories.id" v-for="accLabJobCat in filterAccountLaborJobCategories()">
						    	{{accLabJobCat.labour_categories.name}}
						    </option>
				    </select>
				  </div>

				  <div class="form-group" v-if="job_labour_cat_id">
				    <label for="exampleInputEmail1">Labour Job Type</label>
				    <select name="labour_job_type_id" class="form-control" v-on:change="getLabourTypeRate()" v-model="labour_job_type_id" id="job_type" placeholder="Labour Job Type">
				    <option selected disabled>-Select-</option>
						<option v-bind:value="labourJobType.id" v-for="labourJobType in filterLaborJobTypes()">
								{{labourJobType.name}}    	
						</option>
				   	
				    </select>
				  </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Godowns</label>
				    <select name="godown_id" class="form-control" v-model="godown_id" id="job_type" placeholder="Labour Job Type">
				    	<option selected disabled>-Select-</option>
				    	<option v-bind:value="godown.id" v-for="godown in godowns">
								{{godown.name}}    	
						</option>
				    
				    </select>
				  </div>

				  <div class="form-group">
				  	<label for="exampleInputEmail1">No. of Bags</label>
				  	<input type="text" name="bags" class="form-control" v-model="bags" />

				  	<input type="hidden" name="date" class="form-control" value="<?=date('Y-m-d')?>" />
				  </div>
				  <div class="form-group">
				  	<label for="exampleInputEmail1">Rate</label>
				  	<input type="hidden" name="rate" class="form-control" v-model="labour_rate" />
				  	<input type="text" name="rate" class="form-control" disabled="true" v-bind:value="labour_rate" />
				  </div>
				  <div class="total numerals-disp-block pull-right">Total: Rs. {{calculateJobTotal()}}</div>
				  <?php 
				    /*  <div class="form-group">
						      <label for="exampleInputEmail1">Weight unit</label>
							    <select name="weight_unit" class="form-control" id="job_type" placeholder="Labour Job Type">
							    	<option selected disabled>-Select-</option>
							    <?php foreach ($weight_units as $key => $wtunit): ?>
							    	<option value="<?=$wtunit->id?>"><?=$wtunit->name?></option>
							    <?php endforeach ?>
							    </select>
					      </div> 
					 */
				  ?>
				  <input type="hidden" name="qc_mat_all_id" value="<?=$is_update?>">

				  <button type="submit" class="btn btn-danger">Submit</button>
				</form>
			</div> <!-- addnewlabor jiob -->	
	</div>
	<div class="col-xs-4"></div>
</div>
<?php $this->load->view('admin/partials/footer'); ?>
