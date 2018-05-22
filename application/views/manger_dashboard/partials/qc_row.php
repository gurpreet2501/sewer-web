<tr>
  <td width="20%">
    <div>
      <select class="form-control required" v-bind:name="'ge_delivery_qc['+rowId+'][qc_type_id]'">
      		<option></option>
      	<?php foreach($qc_types as $qc_type): ?>
      		<option value="<?=$qc_type->id?>"><?=$qc_type->name?></option>
      	<?php endforeach; ?>
      </select>
    </div>
  </td>      
  <td>
    <input type="text" class="form-control required" 
    v-bind:name="'ge_delivery_qc['+rowId+'][quantity_per_unit]'" v-model='qc_quantity' v-on:keyup='updateTotal'>

  </td>
  <td width="20%">
    <div>
      <select class="form-control cut_unit_name required" 
      v-bind:name="'ge_delivery_qc['+rowId+'][cut_unit]'"
      v-model='cutUnit'>
      		<option value="QUINTAL">Quintal</option>
      		<option value="BAG">Bags</option>
      </select>
    </div>
  </td>      
  <td>
    <input type="text" class="form-control required" 
    v-bind:name="'ge_delivery_qc['+rowId+'][unit_count]'"  
    v-model='unit_count' v-on:keyup='updateTotal'
    />
  </td>
  <td>
    <total-calculator></total-calculator>
    <input type="text" class="form-control" readonly  v-model="total"/>
  </td>
  <td>
  	<span class="glyphicon glyphicon-trash red" aria-hidden="true" v-on:click="deleteRow(rowId)"></span>
  </td>
  </tr>
