<?php $this->load->view('admin/partials/header'); ?>

<form method="post" action="<?=site_url('manager_dashboard/save_cmr_rice_quality_report')?>" id="ge_delievery">
<input type="hidden" class="form-control" name="gate_entry_id" value="<?=$gate_entry_id?>"/>
<div class="row">
	<div class="col-xs-3"></div>
	<div class="col-xs-6">
		<h2 class="text-center">CMR Rice Quality Report</h2>
	 <fieldset>
		  <legend>Weight</legend>
			<div class="form-group">
				<label for="weight">Weight at the delivery Godown</label>
				<input type="text" class="form-control required" name="ge_delivery_details[weight]" v-model='weight' v-on:change='calcWtDiff' />
				<input type="hidden" class="form-control" name="ge_delivery_details[gate_entry_id]" value="<?=$gate_entry_id?>"/>
			</div>
			<div class="form-group">
				<label for="weight-diff">Weight Difference</label>
				<input type="text" class="form-control" name="ge_delivery_details[weight_diff]" v-model='wtDifference' readonly/>
			</div>
		</fieldset>
		<div class="fieldset-spacer"></div>
    <fieldset>
		  <legend>Godown Entry Delievery Qc</legend>

		  <div class="form-group" >

		   <table class="table table-stripped">
		     <tr>
		       <th>
		        <div class='bold'>Qc Type</div>
		       </th>
		       <th>
		        <div class='bold'>Qc Quantity</div>
		       </th>
		       <th>
		        <div class='bold'>Cut Unit</div>
		       </th>
		       <th>
		        <div class='bold'>{{unitCount}}</div>
		       </th>
		       <th>
		        <div class='bold'>Total Qc</div>
		       </th>
		      </tr>
		   </table>
		   <table>
					<qc-row	
							v-for='geDelieveryRow in geDelieveryQc' 
							:key="geDelieveryRow" 
							v-bind:row-id='geDelieveryRow' 
							v-on:delete="deleteGeDelieveryQc"></qc-row>
				</table>
		   <div class="plus-sign pull-right">
				 	<span class="glyphicon glyphicon-plus pull-right" aria-hidden="true" id="dsd" v-on:click="addGeDeleieveryQc()"></span>
		   </div>
		   <br/>
		  </div>
		</fieldset>	
		<br/>
		<button type="submit" class="btn btn-danger pull-right">Update</button>
	</div> <!-- col-xs-8 -->
	<div class="col-xs-3"></div>
</div> <!-- row ends -->
</form>
<?php $this->load->view('admin/partials/footer'); ?>
