<?php $this->load->view('admin/partials/header'); ?>

<?php if (isset($_GET['alert'])): ?>
	<div class="alert alert-success"><?= $_GET['alert'] ?>	</div>
<?php endif; ?>


<div class="" id="add-rate-contracts">
	<form action="<?=site_url('manager_dashboard/store_rate_contracts') ?>" method="POST">
		<div class="row">
			<div class="text-center"><h2>Add Entry</h2></div>

			<div class="alert alert-danger form-error text-center" style="display: none">Incomplete entry.</div>
		
			<div class="col-md-12">
				<hr>
				<div class="form-group form-inline col-xs-6">
				  <label for="party_name">Party Name</label>
				  <select class="js-example-basic-multiple form-control" name="contract[account_id]">
				  	<option></option>
				  	<?php foreach($parties as $party): ?>
				    <option value="<?=$party->id?>"><?=$party->name?></option>
				  	<?php endforeach; ?>
				</select>
				</div>
				<hr>
			</div>

			<div class="col-md-12">
				<fieldset>
					<legend>Rate Contracts</legend>
				   	<div class="form-group">
				   		<table class="table table-stripped">
					     <tr>
					       <th>Name</th>
					       <th>From Date</th>
					       <th>To Date</th>
					       <th>Unit</th>
					       <th>Quantity</th>
					       <th></th>
					     </tr>

				     <tr>
				       	<td><input type="text" class="form-control"  min="0" name="contract[name]"></td>
				       	<td><input type="text" class="form-control allow-datepicker"  min="0" name="contract[from_date]"></td>
				       	<td><input type="text" class="form-control allow-datepicker"  min="0" name="contract[to_date]"></td>
				       	<td>
				       	<select name="contract[unit]" class="form-control">
				       		<option value=""></option>
				       		<option value="QUINTALS">Quintals</option>
				       		<option value="BAG_COUNT">Bag Count</option>
				       	</select>
				       	</td>
				       	<td><input type="number" class="form-control"  min="0" name="contract[weight]"></td>
				      </tr>
				      <br/>
				   </table>
				  </div> <!-- div ends -->
				</fieldset>  
				<div class="fieldset-spacer"></div>
			</div>
			<div class="clearfix"></div>

			<div class="col-md-12">
				<fieldset>
					<legend>Items</legend>
				   	<div class="form-group">
				   		<table class="table table-stripped">
					     <tr>
					       <th>Stock Item</th>
					       <th>Rate</th>
					       <th></th>
					     </tr>
				     <tr  v-for='val in iterator.items'>		       	
				       	<td>
				       	<select class="js-example-basic-multiple form-control" v-bind:name="'contract[items]['+ val + '][stock_item_id]'" >
						  	<option></option>
						  	<?php foreach($stock_items as $item): ?>
						    <option value="<?=$item->id?>"><?=$item->name?></option>
						  	<?php endforeach; ?>
						</select>
				       	</td>
				       	<td><input type="number" class="form-control"  v-bind:name="'contract[items]['+ val + '][rate]'"> </td>
				       	 <td> <span class="glyphicon glyphicon-trash " id="delete_row" v-on:click="iteratorRemove('items', val)"></span></td>
				      </tr>
				      <br/>
				   </table>
				  </div> <!-- div ends -->
				     <div class="row pull-right">
					    <div class="col-xs-12 ">
					      <span class="glyphicon glyphicon-plus" id="add_row" aria-hidden="true" v-on:click="iteratorInsert('items')"></span>
					    </div>
					  </div>
				</fieldset>  
				<div class="fieldset-spacer"></div>

			</div>
	

			<div class="col-md-12 text-right">
				<button type="submit" class="btn btn-success">Save</button>	
				<a href="<?= site_url('manager_dashboard/cash_transaction') ?>" class="btn btn-danger">Cancel</a>
			</div>
			
		</div><!-- row -->
		
	</form>
</div>
<?php $this->load->view('admin/partials/footer'); ?>
