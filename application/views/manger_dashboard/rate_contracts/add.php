<?php $this->load->view('admin/partials/header'); ?>

<?php if (isset($_GET['alert'])): ?>
	<div class="alert alert-success"><?= $_GET['alert'] ?>	</div>
<?php endif; ?>

<div id="add-rate-contracts" style="max-width: 960px;margin: auto;">
	<form action="<?=site_url('manager_dashboard/store_rate_contracts') ?>" method="POST" class="validate">
		<div class="row">
			<div class="text-center"><h2>Add Entry</h2></div>

			<div class="alert alert-danger form-error text-center" style="display: none">Incomplete entry.</div>
			<div class="col-md-12">
				<fieldset>
					<legend>Rate Contracts</legend>
					<div class="form-group pull-right">
						<select class="form-control" name="contract[type]" v-model="contractType" v-on:change="onContractTypeChange">
							<option value="by_end_date" selected>By Date</option>
							<option value="quantity">Quantity</option>
						</select>
					</div>
					<label class="pull-right" style="margin-top: 12px;">Contract Type:</label>
				   	<div class="form-group">
				   		<table class="table table-stripped">
					     <tr>
					       <th>Party Name</th>
					       <th>From Date</th>
					       <th class="to-date">To Date</th>
					       <!-- <th class="quantity hidden">Quantity (in Kg)</th> -->
					       <th class="trash-icon hidden"></th>
					     </tr>

				     <tr>
				       	<td>
							  <select class="form-control required" name="contract[account_id]">
							  	<option></option>
							  	<?php foreach($accounts as $account): ?>
							    <option value="<?=$account->id?>"><?=$account->name?></option>
							  	<?php endforeach; ?>
							  </select>
				       	</td>
				       	<td><input type="text" class="form-control allow-datepicker required" name="contract[from_date]"></td>
				       	<td class="to-date"><input type="text" class="form-control allow-datepicker required"  name="contract[to_date]"></td>
				      <!--  	<td class="quantity hidden"><input type="number" class="form-control"  min="0" name="contract[quantity]" ></td> -->
				      </tr>
				      <br/>
				   </table>
				  </div> <!-- div ends -->
				</fieldset>  
				<div class="fieldset-spacer"></div>
			</div>
		</div>	
			<div class="clearfix"></div>
				<div class="row">
					<div class="col-md-4">
					<fieldset>
					<legend>Stock Group</legend>
						<div class="form-group">
						  <label>Select Stock Group</label>
							<select class="form-control required" v-bind:name="'contract[stock_group_id]'" v-model="stockGroupId" >
								<?php foreach ($stock_groups as $grp): ?>
									<option value="<?=$grp->id?>"><?=$grp->name?></option>
								<?php endforeach ?>
							</select>
							</div> <!-- formgroup -->
							</fieldset>
					</div> <!-- col-md-4 -->
				</div>	<!-- row -->
					<div class="fieldset-spacer"></div>
      <div class="row">
			 <div class="col-md-12">
				<fieldset>
					<legend>Items</legend>
				   	<div class="form-group">
				   		<table class="table table-stripped">
					     <tr>
					       <th>Stock Item</th>
					       <th>Rate Per Unit</th>
					       <th class="quantity" v-if="!hideWeight">Weight in kg</th>
					       <th></th>
					     </tr>
					     <tr v-for="(stockItem,index) in filterStockItems()">
					     	<td>
					     		<label>{{stockItem.name}}</label>
					     		<input type="hidden" v-bind:value="stockItem.id" v-bind:name="'contract[items]['+ index + '][stock_item_id]'">
					     	</td>
					     	<td>
					     		<input type="number" class="form-control required"  v-bind:name="'contract[items]['+index+'][rate]'"> 
					     	</td> 
					     	<td>
				       		<input type="text" class="form-control quantity" v-if="!hideWeight"  v-bind:name="'contract[items]['+index+'][weight]'"> 
				       	</td>
					     </tr>
				      <br/>
				   </table>
				  </div> <!-- div ends -->
				   
				</fieldset>  
				<div class="fieldset-spacer"></div>

			</div> <!-- col -->
	  </div> <!-- row -->
		<div class="row">
			<div class="col-md-12 text-center">
			<br>
				<button type="submit" class="btn btn-success">Save</button>	
				<a href="<?= site_url('manager_dashboard/rate_contracts') ?>" class="btn btn-danger">Cancel</a>
			<br>
			<br>
			</div>
			
		</div><!-- row -->
		
	</form>
</div>
<?php $this->load->view('admin/partials/footer'); ?>
