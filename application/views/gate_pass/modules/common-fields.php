<?php  

 $allowEditing = $this->config->item('allow_common_field_editing');

 $readOnly = '';
 if($allowEditing && user_role()== 'admin')
  $readOnly = '';
 else 
  $readOnly = 'readonly';
?>
<fieldset class="party_name">
    <div class="form-group form-inline clearfix">
      <label for="party_id">Party Name</label> 
      
      <agdropdown name="party_name" input_class="required" next_field_id="truck_no" hidden_field_name="account_id" v-bind:options="common_fields.accounts" v-model="common_fields.account_id"> 
      </agdropdown> 

   <!--    <select2 :options="common_fields.accounts" text="name" name="party_id" id="id" v-model="common_fields.account_id" class="party_name_selector">
        <option disabled value="0">Select one</option>
      </select2> -->
    <div class="glyphicon glyphicon-plus add-pop-up" onclick="openPopUp()"></div>
    <!--     <input type="text" class="required form-control"
          name="account_id"
          v-model="common_fields.account_id"
          style='height:0; width:0; border:0' /> -->
    </div> <!-- form-group -->

    <div class="form-group form-inline">
      <label for="truck_no">Truck No.</label>
      <input name="truck_no" type="text" class="form-control required" autocomplete="off" id="truck_no" v-on:keyup="upper()"  value="<?=$autofill['truck_no']?>" v-model="common_fields.truck_no">
    </div>

    <div class="form-group form-inline">
      <label for="exampleInputPassword1">Loaded Weight</label>
      <input 
            type="text" 
            name="loaded_weight" min="1"
            class="form-control weight_total required loaded_weight" 
            id="loaded_weight" 
            placeholder="Enter Loaded Weight" 
            value="<?=$autofill['loaded_weight']?>" 
            v-model="common_fields.loaded_weight"
            v-key:up="weightChange()"
            tabindex="-1"
            <?=$readOnly?>>
    </div>

    <div class="form-group form-inline">
      <label for="tare_weight">Tare Weight</label>
      <input 
          type="text" 
          name="tare_weight" 
          class="form-control weight_total  tare_weight required" min="1"
          id="tare_wt" 
          v-key:up="weightChange()"
          placeholder="Enter Tare Weight" 
          value="<?=$autofill['tare_weight']?>" 
          v-model="common_fields.tare_weight"
            tabindex="-1"
      <?=$readOnly?>>
    </div>
    <div class="form-group form-inline">
      <label for="exampleInputPassword1">Gross Weight</label>
    <input type="text" class="form-control" name="gross_weight" id="gross_wt" placeholder="Enter Gross Weight" v-model="common_fields.gross_weight"
            tabindex="-1" <?=$readOnly?> >

    </div>

    <div class="form-group form-inline">
      <label for="exampleInputPassword1">Deduct Packing Material Weight</label>
      <div class="input-group with_checkbox">
        <span class="input-group-addon">   
          <input type="checkbox" name="deduct_packing_material"  v-model="common_fields.deduct_packing_material" id="deducyP">
        </span>
        <input type="text" class="form-control read-only deduct-packing-material" aria-label="..."
            tabindex="-1" readonly name="packing_material_weight"
        v-model="computedPackingWeight" />
      </div><!-- /input-group -->
    </div>  

    <div class="form-group form-inline">
      <label for="exampleInputPassword1">Net Weight</label>
      <input type="text" name="net_weight" class="form-control" id="exampleInputPassword1" placeholder="Enter Net Weight" 
        v-model="common_fields.net_weight"
            tabindex="-1"
        <?=$readOnly?>>
    </div>

  <div class="form-group form-inline" v-if="chatniReportFlag()">

    <label for="exampleInputPassword1">Chatni Report No.</label>

    <input type="text" v-model="common_fields.chatni_report_no" min="1" name="chatni_report_no" class="form-control chatni_report_no required" id="exampleInputPassword1" placeholder="Chatni Report No" >

  </div>

  <div class="form-group form-inline">

    <label for="exampleInputPassword1">Gate Pass No.</label>

    <input type="text" name="gate_pass_no"  v-model="common_fields.gate_pass_no" class="form-control" id="gate_pass_no_check" placeholder="Gate Pass No.">
    <div class="gate-pass-duplicate custom-error-msg">Duplicate Gatepass No.</div>
    </div>


  </fieldset>
    <div class="fieldset-spacer"></div>
